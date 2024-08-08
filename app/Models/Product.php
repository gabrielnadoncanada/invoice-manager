<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const ID = 'id';

    const NAME = 'name';

    const CATEGORY = 'category';

    const PRICE = 'price';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    const CATEGORY_ID = 'category_id';

    protected $fillable = [
        self::NAME,
        self::CATEGORY,
        self::PRICE,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
