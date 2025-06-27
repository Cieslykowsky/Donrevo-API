<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MailingCampaign extends Model
{
    use HasFactory;

    public const TABLE = 'mailing_campaigns';
    public const FIELDS = [
       self::FIELD_CAMPAIGN_ID,
       self::FIELD_MAIL_TEMPLATE_ID,
       self::FIELD_NAME,
       self::FIELD_SUBJECT,
       self::FIELD_CONTENT,
       self::FIELD_IS_ACTIVE,
       self::FIELD_SCHEDULED_AT,
       self::FIELD_SENT_AT,
    ];
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_MAIL_TEMPLATE_ID = 'mail_template_id';
    public const FIELD_NAME = 'name';
    public const FIELD_SUBJECT = 'subject';
    public const FIELD_CONTENT = 'content';
    public const FIELD_IS_ACTIVE = 'is_active';
    public const FIELD_SCHEDULED_AT = 'scheduled_at';
    public const FIELD_SENT_AT = 'sent_at';

    protected $table = self::TABLE;

    protected $fillable = self::FIELDS;

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(MailTemplate::class);
    }
}