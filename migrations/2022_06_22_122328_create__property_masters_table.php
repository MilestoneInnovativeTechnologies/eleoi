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
        Schema::create('_property_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property')->index();
            $table->unsignedBigInteger('data')->index()->nullable();
            $table->string('value',512)->nullable();
            $table->mediumText('ids')->nullable();
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
        Schema::dropIfExists('_property_masters');
    }
};
