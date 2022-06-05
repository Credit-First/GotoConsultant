<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissedNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missed_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->bigInteger('receiver_id')->unsigned();
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('CASCADE');

            $table->timestamp('created_at')->useCurrent();

            $table->index(['sender_id', 'receiver_id'], 'missed_notifications_sender_id_receiver_id_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('missed_notifications');
    }
}
