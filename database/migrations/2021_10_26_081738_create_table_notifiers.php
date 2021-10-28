<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNotifiers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('Notifiers', function (Blueprint $table) { // Notifications, Events, ETC
            $table->id();
            $table->string('Type', 100)->nullable(); // Interruption, Event, Advisory, Information, Link Approval
            $table->string('Title', 500)->nullable();
            $table->string('Details', 3000)->nullable();
            $table->string('Town', 10)->nullable();
            $table->string('Barangay', 10)->nullable();
            $table->datetime('DateTimeFrom')->nullable();
            $table->datetime('DateTimeTo')->nullable();
            $table->string('ToUser', 30)->nullable(); // userid
            $table->string('CommentsEnabled')->nullable(); // True, False
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
        Schema::connection('sqlsrv')->dropIfExists('Notifiers');
    }
}
