<?php

namespace App\Models;
Use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Products::class);
    }
    
}

