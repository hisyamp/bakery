<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCutoffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutoff', function (Blueprint $table) {
            $table->id();
            $table->string('cutoff_name');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['open', 'closed', 'processing'])->default('open');
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('closed_by')->unsigned()->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->timestamp('closed_at')->nullable();
            $table->boolean('is_active')->default(true);

            // Foreign keys
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('closed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cutoff');
    }
}
