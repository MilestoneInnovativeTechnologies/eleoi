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
        Schema::create('_properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('master')->index();
            $table->string('name',128)->index();
            $table->unsignedBigInteger('value_master')->index()->nullable();
            $table->enum('index',['Y','N'])->index()->default('N');
            $table->enum('nature',['Single','Multiple','Y/N'])->nullable()->default('Single');
            $table->enum('control',['text','number','textarea','readonly','hidden','select','radio','checkbox'])->nullable()->default('text');
            $table->text('auto_on')->nullable();
            $table->text('auto_formula')->nullable();
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
        Schema::dropIfExists('_properties');
    }
};
