<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'category_id', 'unit'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function harvests()
    {
        return $this->hasMany(Harvest::class);
    }
}
