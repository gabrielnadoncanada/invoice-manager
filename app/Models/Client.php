<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Squire\Models\Region;

class Client extends Model
{
    use HasFactory;

    const ID = 'id';

    const NAME = 'name';

    const ADDRESS = 'address';

    const CITY = 'city';

    const STATE = 'state';


    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';
    const COUNTRY = 'country';
    const POSTAL_CODE = 'postal_code';

    public const FULL_ADDRESS = 'full_address';
    public const DISPLAY_STATE = 'display_state';
    public const DISPLAY_COUNTRY = 'display_country';

    protected $fillable = [
        self::NAME,
        self::ADDRESS,
        self::CITY,
        self::STATE,
        self::COUNTRY,
        self::POSTAL_CODE,
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }


    protected function displayState(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->region?->name
        );
    }

    protected function displayCountry(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->region?->country?->name
        );
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'state');
    }

    protected function fullAddress(): Attribute
    {
        $status = $this->deleted_at ? ' (désactivée)' : '';

        return Attribute::make(
            get: fn(): string => sprintf(
                '%s, %s, %s %s%s',
                $this->{self::ADDRESS},
                $this->{self::CITY},
                $this->region?->name,
                $this->{self::POSTAL_CODE},
                $status
            )
        );
    }
}
