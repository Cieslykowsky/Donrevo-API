<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public const TABLE = 'groups';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELDS = [
        self::FIELD_NAME,
        self::FIELD_DESCRIPTION,
    ];

    protected $table = self::TABLE;

    protected $fillable = self::FIELDS;
}