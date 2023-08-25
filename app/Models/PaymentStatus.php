<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;
    protected $fillable = ['name','status','is_default'];

    static $active = '1';
    static $inactive = '0';
    
}
