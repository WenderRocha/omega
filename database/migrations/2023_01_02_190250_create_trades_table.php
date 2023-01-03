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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_id')->constrained('management');
            $table->string('date')->default(now()->format('d/m/Y'));
            $table->string('assets');
            $table->integer('payout');
            $table->decimal('value', 12, 2);
            $table->decimal('income', 12, 2);
            $table->string('orderType');
            $table->string('operational');
            $table->string('tradeResult');
            $table->text('observation');
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
        Schema::dropIfExists('trades');
    }
};
