<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 1 :Eloquent (Model)
        // $data = Category::all();
        $data = Category::with('user')->get();
        return response()->view('cms.categories.index', ["catego" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Eloquent => User::all();
        // Query Builder => DB::table('users')->get();
        //SQL => SELECT * FROM users;
        $data = User::all();

        return response()->view('cms.categories.create', ["user_categ" => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json(['message' => 'success - js'] , 201);
        // 2:
        $valid = validator($request->all(), [
            'users_name' => 'required|numeric|exists:users,id',
            'category_title' => 'required|string|max:30',
            'category_active' => 'required|boolean',
        ]);

        if (!$valid->fails()) {
            // 1 :Eloquent (Model)
            $categ = new Category();
            $categ->user_id = $request->input("users_name");
            $categ->title = $request->input("category_title");
            $categ->active = $request->input("category_active");
            $saved = $categ->save();
            if ($saved) {
                // Success
                return response()->json(['message' => 'Category Saved Success', 'icon' => 'success'], Response::HTTP_CREATED); //201
            } else {
                // Save failed
                return response()->json(['message' => 'Failed To Saved Category', 'icon' => 'error'], Response::HTTP_BAD_REQUEST); //400
            }
        } else {
            // Validation error
            return response()->json(['message' => $valid->getMessageBag()->first(), 'icon' => 'error'], Response::HTTP_BAD_REQUEST); //400
        }
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
        //category لعرض المحتوى الخاص بال
        $category = Category::findOrFail($id);
        //select لعرض اسم المستخدم اللي بال
        $users = User::all();
        return response()->view("cms.categories.edit", ['categ' => $category , 'user' => $users]);
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
        $valid = validator($request->all(), [
            'user_name' => 'required|numeric|exists:users,id',
            'title_catego' => 'required|string|max:30',
            // 'category_active' => 'nullable|string|in:on',
            'active_catego' => 'required|boolean',
        ]);

        if (!$valid->fails()) {
            // 1 :Eloquent (Model)
            $categ = Category::findOrFail($id);
            $categ->user_id = $request->input("user_name");
            $categ->title = $request->input("title_catego");
            // $categ->category_active = $request->has("active");
            $categ->active = $request->input("active_catego");
            $saved = $categ->save();
            return response()->json(['message' =>
            $saved ? "Category updated successfully" : "Faield to updated category"],
            $saved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST); //201
        } else {
            // Validation error
            return response()->json(['message' => $valid->getMessageBag()->first()],
            Response::HTTP_UNPROCESSABLE_ENTITY); //422
            //  Response::HTTP_BAD_REQUEST == HTTP_UNPROCESSABLE_ENTITY  // 400 == 422
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 1: Eloquent
        $deleted = Category::destroy($id);
        return response()->json(
            ['message' => $deleted ? "Category deleted successfully" : "Failed to delete category"],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
