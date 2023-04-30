<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory, Notifiable; //traits

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Appended Model Attribute
    public function fullMobile():Attribute{
        return new Attribute(get: fn()=> $this->mobile !="" ? "+00".$this->mobile : "No Mobile");
    }

    // 1 => * : hasMany
    public function categories(){
        return $this->hasMany(Category::class , 'user_id' , 'id');
    }
}

/*
    Relations:
    Example: Tables(User => Category) // Model = Table in Laravel
    1- One-To-One  => hasOne(Category)
    2- One-To-Many => hasMany(Category)
    3-Many-To-Many => ?

    Inverse Of Relations:
    1- One-To-One => belongsTo(User) // belongsTo = تنتمي الى
    2- One-To-One => belongsTo(User)
    3-Many-To-Many => ?

    Define Relations in Eloquent:
    1- Create new public function
    2- New function name should be related to the relation type
        Example:
            - hasMany - Plural - categories
            - hasOne - singuler - category

*/
