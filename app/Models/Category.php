<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    const ID = 'id';
    const NAME = 'name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::NAME,
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
