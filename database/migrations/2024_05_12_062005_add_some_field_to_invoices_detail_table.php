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
        Schema::table('invoices_detail', function (Blueprint $table) {
            $table->integer('border_id')->nullable();
            $table->integer('topping_id')->nullable();
            $table->integer('size_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices_detail', function (Blueprint $table) {
            $table->dropColumn('border_id');
            $table->dropColumn('topping_id');
            $table->dropColumn('size_id');
        });
    }
};
