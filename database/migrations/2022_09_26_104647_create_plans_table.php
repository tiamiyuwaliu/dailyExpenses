<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('trial_days')->default(0);
            $table->integer('is_free')->default(0)->unique();
            $table->integer('monthly_price')->nullable();
            $table->integer('yearly_price')->nullable();
            $table->integer('visibility')->default(1);
            $table->integer('position')->default(0);
            $table->text('features')->nullable();
            $table->text('taxes')->nullable();
            $table->text('coupons')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('plans');
    }
};
