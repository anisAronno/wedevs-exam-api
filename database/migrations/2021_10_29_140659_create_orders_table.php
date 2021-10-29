<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 128);
            $table->string('customer_mobile', 32);
            $table->text('address');
            $table->string('district', 32);
            $table->string('country', 32)->default('Bangladesh');
            $table->decimal('total_price',10,2);
            $table->unsignedBigInteger('user_id');
            $table->enum('status',[ 'Pending','Approved','Processing', 'Shipped', 'Delivered', 'Returned','Cancelled',])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
