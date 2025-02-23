<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCutoffIdToLogItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_items', function (Blueprint $table) {
            $table->unsignedBigInteger('cutoff_id')->nullable()->after('item_id');
            $table->foreign('cutoff_id')->references('id')->on('cutoff')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_items', function (Blueprint $table) {
            $table->dropForeign(['cutoff_id']);
            $table->dropColumn('cutoff_id');
        });
    }
}
