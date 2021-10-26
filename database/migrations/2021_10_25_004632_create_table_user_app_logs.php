<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserAppLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('UserAppLogs', function (Blueprint $table) {
            $table->id();
            $table->string('UserId', 50)->nullable();
            $table->string('Type', 500)->nullable();
            $table->string('Details', 2000)->nullable();
            $table->string('LatLong', 100)->nullable();
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
        Schema::connection('sqlsrv')->dropIfExists('UserAppLogs');
    }
}
