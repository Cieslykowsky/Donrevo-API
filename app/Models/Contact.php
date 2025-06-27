<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public const TABLE = 'contacts';
    public const FIELDS = [
        self::FIELD_FIRST_NAME,
        self::FIELD_LAST_NAME,
        self::FIELD_EMAIL,
        self::FIELD_PHONE,
        self::FIELD_STREET,
        self::FIELD_HOUSE_NUMBER,
        self::FIELD_POSTAL_CODE,
        self::FIELD_CITY,
        self::FIELD_COUNTRY,
        self::FIELD_IS_ACTIVE,
        self::FIELD_NOTES,
    ];
    public const FIELD_FIRST_NAME = 'first_name';
    public const FIELD_LAST_NAME = 'last_name';
    public const FIELD_EMAIL = 'email';
    public const FIELD_PHONE = 'phone';
    public const FIELD_STREET = 'street';
    public const FIELD_HOUSE_NUMBER = 'house_number';
    public const FIELD_POSTAL_CODE = 'postal_code';
    public const FIELD_CITY = 'city';
    public const FIELD_COUNTRY = 'country';
    public const FIELD_IS_ACTIVE = 'is_active';
    public const FIELD_NOTES = 'notes';

    protected $table = self::TABLE;

    protected $fillable = self::FIELDS;
}