<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    const ID = 'id';

    const CLIENT_ID = 'client_id';

    const DATE = 'date';

    const INVOICE_NUMBER = 'invoice_number';

    const SUBTOTAL = 'subtotal';

    const GST = 'gst';

    const PST = 'pst';

    const TOTAL_AMOUNT = 'total_amount';

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::CLIENT_ID,
        self::DATE,
        self::INVOICE_NUMBER,
        self::SUBTOTAL,
        self::GST,
        self::PST,
        self::TOTAL_AMOUNT,
    ];

    protected $casts = [
        self::DATE => 'date',

    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'invoice_service');
    }
}
