<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}

/*
    Relations:
    Example: Tables(User => Category) // Model = Table in Laravel
    1- One-To-One  => hasOne(Category)
    2- One-To-Many => hasMany(Category)
    3-Many-To-Many => ?

    Inverse Of Relations:
    1- One-To-One => hasOne(Category) // belongsTo = تنتمي الى
    2- One-To-One => belongsTo(User)
    3-Many-To-Many => ?

    Define Relations in Eloquent:
    1- Create new public function
    2- New function name should be related to the relation type
        Example:
            - hasMany - Plural - categories
            - hasOne - singuler - category

*/
