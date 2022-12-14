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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id')->length(11)->nullable();
            $table->string('hex', 11)->unique();
            $table->integer('user_id')->length(11);
            $table->string('name');
            $table->string('slug');
            $table->string('english_name')->nullable();
            $table->string('english_slug')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('color_id', 6)->nullable();
            $table->timestamps(); 
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
