<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    const ID = 'id';

    const INVOICE_ID = 'invoice_id';

    const PRODUCT_ID = 'product_id';

    const QUANTITY = 'quantity';

    const UNIT_PRICE = 'unit_price';

    const AMOUNT = 'amount';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::INVOICE_ID,
        self::PRODUCT_ID,
        self::QUANTITY,
        self::UNIT_PRICE,
        self::AMOUNT,
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
