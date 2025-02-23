<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id'); // Foreign key to items table
            $table->integer('stok_awal');         // Initial stock
            $table->integer('stok_akhir');        // Final stock
            $table->date('transaction_date');     // Date of transaction
            $table->timestamps();                 // created_at and updated_at
            $table->unsignedBigInteger('created_by'); // Reference to the user who created this record
            
            // Add foreign key constraint for item_id
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            
            // Add foreign key constraint for created_by (if referring to a users table)
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_items');
    }
}
