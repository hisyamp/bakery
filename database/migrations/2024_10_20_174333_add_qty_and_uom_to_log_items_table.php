<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyAndUomToLogItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_items', function (Blueprint $table) {
            // Add qty as an integer and uom as a string to the log_items table
            $table->integer('qty')->after('notes')->default(0); // Default value is 0
            $table->string('uom')->after('qty'); // Add UOM (Unit of Measurement)
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
            // Drop the columns if the migration is rolled back
            $table->dropColumn('qty');
            $table->dropColumn('uom');
        });
    }
}
