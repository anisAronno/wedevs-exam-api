<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class Order extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded = ['id'];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // $collectName=substr($district, 0,3) ?? Str::random(3);
    // $orderId= "#".strtolower($collectName)."00".$order->id;

    public function setOrderIdAttribute($value)
    {
        Log::debug($this->order->id);
        $collectName=substr($value, 0,3) ?? Str::random(3);
        $orderId= "#".strtolower($collectName)."00".$this->order->id;
        $this->attributes['order_id'] = $orderId;
    }
}
