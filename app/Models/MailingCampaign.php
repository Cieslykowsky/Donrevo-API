<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingCampaign extends Model
{
    use HasFactory;

    protected $table = 'mailing_campaigns';

    protected $fillable = [
        'campaign_id',
        'template_id',
        'name',
        'subject',
        'content',
        'is_active',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function template()
    {
        return $this->belongsTo(MailTemplate::class, 'template_id');
    }
}