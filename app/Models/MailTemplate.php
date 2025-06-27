<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    public const TABLE = 'mail_templates';
    public const FIELDS = [
       self::FIELD_NAME,
       self::FIELD_SUBJECT,
       self::FIELD_CONTENT,
       self::FIELD_DESCRIPTION,
       self::FIELD_IS_ACTIVE,
    ];
    public const FIELD_NAME = 'name';
    public const FIELD_SUBJECT = 'subject';
    public const FIELD_CONTENT = 'content';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_IS_ACTIVE = 'is_active';

    protected $table = self::TABLE;

    protected $fillable = self::FIELDS;

}
