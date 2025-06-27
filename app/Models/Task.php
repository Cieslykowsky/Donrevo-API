<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    public const TABLE = 'tasks';
    public const FIELDS = [
       self::FIELD_CAMPAIGN_ID,
       self::FIELD_CONTACT_ID,
       self::FIELD_MAILING_CAMPAIGN_ID,
       self::FIELD_TITLE,
       self::FIELD_DESCRIPTION,
       self::FIELD_DUE_DATE,
       self::FIELD_PRIORITY,
       self::FIELD_STATUS,
       self::FIELD_ASSIGNED_TO,
    ];
    public const FIELD_CAMPAIGN_ID = 'campaign_id';
    public const FIELD_CONTACT_ID = 'contact_id';
    public const FIELD_MAILING_CAMPAIGN_ID = 'mailing_campaign_id';
    public const FIELD_TITLE = 'title';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_DUE_DATE = 'due_date';
    public const FIELD_PRIORITY = 'priority';
    public const FIELD_STATUS = 'status';
    public const FIELD_ASSIGNED_TO = 'assigned_to';

    protected $table = self::TABLE;

    protected $fillable = self::FIELDS;

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function mailingCampaign(): BelongsTo
    {
        return $this->belongsTo(MailingCampaign::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}