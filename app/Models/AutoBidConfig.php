<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoBidConfig extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'user_id',
        'auto_bidding_max_amount',
        'auto_bidding_current_amount'
    ];
}
