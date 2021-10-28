<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('AccountLinks', function (Blueprint $table) {
            $table->id();
            $table->string('UserId');
            $table->string('AccountNumber');
            $table->string('ConsumerName', 500);
            $table->string('Status', 50)->nullable(); // Pending, Linked
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
        Schema::connection('sqlsrv')->dropIfExists('AccountLinks');
    }
}
