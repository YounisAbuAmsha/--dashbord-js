<?php

namespace App\Http\Controllers;

use App\Mail\UserWelcomeEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd("younis");
        // Query On Database - Table (Users)
        // 1 :Eloquent (Model)
        // $data = User::all();  //['NameColumn']
        $data = User::withCount('categories')->get();
        // $data = User::where('id' , '>', 5)->get();  //['NameColumn']

        // 2: Query Builder
        // $data = DB::table('users')->where('id' , '>', 5)->get();

        //3: SQL
        // $data = DB::select('SELECT * FROM users Where id > 5');
        return response()->view("cms.users.index" , ['users'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("cms.users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required|string|min:2|max:20',
            'email'=>'required|string|email|unique:users,email',
            'user_address'=>'nullable|string|max:100',
            'user_mobile'=>'required|numeric|digits:12',
            // 'user_image'=>'nullable|image|mimes:jpg,png|max:1024', //size:1024
            'user_image' => 'required|image|mimes:jpg,png|max:1024',
            'password'=>[
                'required', 'string',
                Password::min(8)->letters()->numbers()->symbols()->mixedCase()->uncompromised(),
            ]
        ]);
        // 1 :Eloquent (Model)
        $user = new User();
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->address = $request->input("user_address");
        $user->mobile = $request->input("user_mobile");
        $user->password = Hash::make($request->input("password"));
        $saved = $user->save();
        if ($request->hasFile('user_image')) {
            $userImage = $request->file('user_image');
            $imageName = time() . '_image_' . $user->name . '.' . $userImage->getClientOriginalExtension();
            $userImage->storePubliclyAs('users', $imageName, ['disk' => 'public']);
            $user->image = 'users/' . $imageName;
        }
        if($saved){
            Mail::to($request->user())->send(new UserWelcomeEmail($user));
        }
        // 2: Query Builder
        // $saved = DB::table('users')->insert([
        //     'name'=>$request->input("name"),
        //     'email'=>$request->input("email"),
        //     'address'=>$request->input("user_address"),
        //     'mobile'=>$request->input("user_mobile"),
        //     'password'=>Hash::make($request->input("password")),
        //     // 'created_at' => now(),
        //     // 'updated_at' => now(),
        // ]);

        // 3: SQL
        // $saved = DB::insert('INSERT into users (name , email , password , mobile ,address, created_at, updated_at) values (?,?,?,?,?,?,?)',
        // [
        //     $request->input("name"),
        //     $request->input("email"),
        //     Hash::make($request->input("password")),
        //     $request->input("user_mobile"),
        //     $request->input("user_address"),
        //     now(),
        //     now(),
        // ]);

        // return redirect()->back();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 1: Eloquent
        // $user = User::find($id);
        $user = User::findOrFail($id);

        // 2: Query Builder
        // $user = DB::table('users')->find($id);  //find(['id' ,'name','address'])

        //3: SQL
        // $user = DB::select('SELECT * FROM users Where id = ?' , [$id]); //Binding => تمرير المتغير بدل ؟
        // $user = DB::select("SELECT * FROM users Where id = $id");
        // $user = DB::select('SELECT * FROM users Where id = ' . $id);

        return response()->view('cms.users.edit',['edit_user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required|string|min:2|max:20',
            'email'=>'required|string|email|unique:users,email,'.$id,
            'user_address'=>'nullable|string|max:100',
            'password'=>[
                'nullable', 'string',
                Password::min(8)->letters()->numbers()->symbols()->mixedCase()->uncompromised(),
            ]
        ]);

        // 1: Eloquent
        // $user = User::find($id);
        $user = User::findOrFail($id);
        // $user = column name = $request->input("input name");
        $user -> name = $request->input("name");
        $user -> email = $request->input("email");
        $user -> address = $request->input("user_address");
        if($request->has("password")){
            $user -> password = Hash::make($request->input("password"));
        }
        $saved = $user->save();

        return redirect()->route('users.index');

        // 2: Query Builder

        // 3: SQL


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd("younis");

        // 1: Eloquent
        // $user = User::find($id)->delete();
        // $user = User::findOrfail($id)->delete();
        // $user = User::destroy($id);

        // 2: Query Builder
        // $user = DB::table('users')->delete($id);
        // $user = DB::table('users')->where('id', '=' , $id)->delete();

        // 3: SQL
        $user = DB::delete('DELETE FROM users where id = ?', [$id]);


        return redirect()->back();
    }
}
