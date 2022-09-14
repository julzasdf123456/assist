<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableThirdPartyTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('ThirdPartyTokens', function (Blueprint $table) {
            $table->string('id')->unsigned();
            $table->primary('id');
            $table->string('Company', 300)->nullable();
            $table->string('AccessKey', 300)->nullable();
            $table->string('Token', 600)->nullable();
            $table->date('ExpiresIn')->nullable();
            $table->string('Status', 200)->nullable();
            $table->string('Notes', 600)->nullable();
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
        Schema::dropIfExists('ThirdPartyTokens');
    }
}
