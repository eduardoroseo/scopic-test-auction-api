<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_price',
        'price'
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
