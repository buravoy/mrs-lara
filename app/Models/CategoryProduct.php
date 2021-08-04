<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'category_product';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
//    protected $fillable = ['name'];
//     protected $hidden = ['name'];
    // protected $dates = [];
    protected $translatable = [];
}
