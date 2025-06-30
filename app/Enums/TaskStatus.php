<?php
declare(strict_types=1);

namespace App\Enums;

enum TaskStatus: string
{
    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case ON_HOLD = 'on_hold';
    case CANCELLED = 'cancelled';
    case READY_FOR_REVIEW = 'ready_for_review';
    case IN_REVIEW = 'in_review';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case DEFERRED = 'deferred';
    case TESTING = 'testing';
    case COMPLETED = 'completed';
}
