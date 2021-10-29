<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded = ['id'];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
