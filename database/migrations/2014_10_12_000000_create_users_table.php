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
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id');
            $table->string('hex', 11);
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->tinyInteger('active');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id')->nullable();
            $table->string('hex', 11);
            $table->tinyInteger('user_type_id', $autoIncrement = false, $unsigned = false)->length(1);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('gender')->nullable();
            $table->string('country_iso')->nullable();
            $table->integer('color_fill_id')->nullable();
            $table->boolean('blocked')->nullable();
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
        Schema::dropIfExists('user_types');
        Schema::dropIfExists('users');
    }
};
