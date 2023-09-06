<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','user_id','payment_status','payment_mode','order_status','address','reject_res','delivered_date','remark','invoice'];
}
