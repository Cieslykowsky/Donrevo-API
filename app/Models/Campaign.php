<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Campaign extends Model
{
    use HasFactory;

    public const TABLE = 'campaigns';
    public const FIELDS = [
        self::FIELD_GROUP_ID,
        self::FIELD_NAME,
        self::FIELD_DESCRIPTION,
        self::FIELD_IS_ACTIVE,
        self::FIELD_START_DATE,
        self::FIELD_END_DATE,
    ];
    public const FIELD_GROUP_ID = 'group_id';
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_IS_ACTIVE = 'is_active';
    public const FIELD_START_DATE = 'start_date';
    public const FIELD_END_DATE = 'end_date';

    protected $table = self::TABLE;

    protected $fillable = self::FIELDS;

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}