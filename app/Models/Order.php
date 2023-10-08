<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'address', 'number', 'email', 'payment', 'note', 'status', 'total', 'userid',
    ];
    use HasFactory;
}
