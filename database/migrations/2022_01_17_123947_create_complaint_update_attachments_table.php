<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintUpdateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_update_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('attachment');
            $table->string('attachment_path');
            $table->foreignId('complaint_update_id')->references('id')->on('complaint_updates')->onDelete('cascade');
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
        Schema::dropIfExists('complaint_update_attachments');
    }
}
