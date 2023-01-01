<?php

use App\Http\Controllers\Enum\AddToTotals;
use App\Http\Controllers\Enum\Currency;
use App\Http\Controllers\Enum\IsBinary;
use App\Http\Controllers\Enum\MainWallet;
use App\Http\Controllers\Enum\ManagementType;

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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->decimal('initialBalance', 12, 2);
            $table->decimal('balance', 12, 2);
            $table->decimal('take', 12, 2)->default(10,00);
            $table->integer('takePercentage')->default(0)->nullable();
            $table->decimal('stop', 12, 2)->default(5,00);
            $table->integer('stopPercentage')->default(0)->nullable();
            $table->integer('qtdWin')->default(1)->nullable();
            $table->integer('qtdLoss')->default(0)->nullable();
            $table->string('currency')->default(Currency::BRL->value);
            $table->string('managementType')->default(ManagementType::FIXED->value);
            $table->integer('addToTotals');
            $table->integer('isBinary');
            $table->integer('isMain');
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
        Schema::dropIfExists('wallets');
    }
};
