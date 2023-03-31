<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableThirdPartyTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrv')->create('ThirdPartyTransactions', function (Blueprint $table) {
            $table->string('id')->unsigned();
            $table->primary('id');
            $table->string('AccountNumber')->nullable();
            $table->date('ServicePeriodEnd')->nullable();
            $table->string('BillNumber')->nullable();
            $table->double('KwhUsed')->nullable();
            $table->double('Amount')->nullable();
            $table->double('Surcharge')->nullable();
            $table->double('TotalAmount')->nullable();
            $table->string('Company')->nullable();
            $table->string('Teller')->nullable();
            $table->string('Status')->nullable();
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
        Schema::dropIfExists('ThirdPartyTransactions');
    }
}
