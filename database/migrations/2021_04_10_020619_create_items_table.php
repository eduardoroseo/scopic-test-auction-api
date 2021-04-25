<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->float('start_price');
            $table->float('price');
            $table->timestamp('bid_expiration');
            $table->boolean('available')->default(1);
            $table->string('picture')
                ->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained();
            $table->boolean('auto_bidding')
                ->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
