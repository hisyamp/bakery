<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogItemsTable extends Migration
{
    public function up()
    {
        Schema::create('log_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->foreignId('branch_id');
            $table->foreignId('type_log_id');
            $table->text('notes')->nullable();
            $table->timestamp('transaction_date');
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_items');
    }
}
