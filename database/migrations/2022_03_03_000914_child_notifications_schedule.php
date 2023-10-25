<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChildNotificationsSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_notifications_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('notification_events')->nullable();
            $table->longText('notification_message')->nullable();
            $table->string('notification_schedule')->nullable();
            $table->string('notification_method')->nullable();
            $table->string('notification_addresses')->nullable();
            $table->unsignedBigInteger('fk_ChildID')->nullable();
            $table->foreign('fk_ChildID')->references('id')->on('children');
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
        Schema::dropIfExists('child_notifications_schedule');
    }
}
