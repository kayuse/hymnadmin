<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingCreditLogs extends Model
{
    //
    public $table = 'pending_credit_logs';
    protected $fillable = ['from_user_id', 'assigned_to', 'reference', 'claimed', 'reference_id'];
}
