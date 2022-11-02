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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id')->nullable();
            $table->string('hex', 11);
            $table->foreignId('user_id')->nullable();
            $table->string('category_ids')->nullable();
            $table->string('industry_ids')->nullable();
            $table->string('registered_name');
            $table->string('trading_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('parent_organization')->nullable();
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->string('founded_in')->nullable();
            $table->string('founded_by')->nullable();
            $table->string('headquarters')->nullable();
            $table->string('address_building_name')->nullable();
            $table->string('address_number')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_zip')->nullable();
            $table->string('address_country')->nullable();
            $table->string('address_phone')->nullable();
            $table->boolean('family_business')->nullable();
            $table->string('family_name')->nullable();
            $table->integer('family_generations')->nullable();
            $table->boolean('family_executive')->nullable();
            $table->boolean('female_executive')->nullable();
            $table->boolean('stock_listed')->nullable();
            $table->boolean('matchbird_partner')->nullable();
            $table->boolean('tofam_company')->nullable();
            $table->string('tofam_status')->nullable();
            $table->boolean('mail_blacklist')->nullable();
            $table->integer('views')->nullable();
            $table->boolean('locked')->nullable();
            $table->timestamps();
            $table->boolean('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
