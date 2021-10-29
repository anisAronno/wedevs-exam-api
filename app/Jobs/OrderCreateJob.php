<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $order;
    public function __construct(Order $order)
    {
        $this->order=$order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admins=User::with("roles")->whereHas("roles", function($q) {
            $q->where("name", "!=", "user");
        })->get();
        
        foreach ($admins as $admin) {
            $admin->notify(new OrderNotification($this->order));
        }
    }
}
