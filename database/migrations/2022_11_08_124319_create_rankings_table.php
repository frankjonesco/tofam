<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->string('hex', 11)->unique();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('company_id');
            $table->integer('year');
            $table->boolean('is_latest')->nullable();
            $table->bigInteger('turnover')->nullable();
            $table->integer('employees')->nullable();
            $table->decimal('training_rate', 20, 2)->nullable();
            $table->boolean('confirmed_by_company')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('rankings');
    }
};
