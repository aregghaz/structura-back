<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_folders', function (Blueprint $table) {
            $table->unsignedBigInteger('email_id');
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('user_id');
            $table->primary(['email_id', 'folder_id','user_id']);
//            $table->foreign('email_id')->references('id')->on('emails');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_folders');
    }
};
