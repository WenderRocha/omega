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
        Schema::create('management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets');
            $table->string('date')->default(now()->format('d/m/Y'));
            $table->integer('qtdTrades')->default(0);
            $table->integer('qtdWin')->default(0);
            $table->integer('qtdLoss')->default(0);
            $table->integer('qtdDraw')->default(0);
            $table->decimal('totalInvestment', 12, 2)->default(0);
            $table->decimal('valueWin', 12, 2)->default(0);
            $table->decimal('valueLoss', 12, 2)->default(0);
            $table->decimal('profit', 12, 2)->default(0);
            $table->integer('resultPercentage')->default(0);
            $table->decimal('dayBalance', 12, 2)->default(0);
            $table->string('resultDay')->default('noTrade');
            $table->string('key')->default('')->nullable();
            $table->string('highlight')->default('')->nullable();
            $table->string('dates')->default(now()->format('d/m/Y'))->nullable();
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
        Schema::dropIfExists('management');
    }
};
