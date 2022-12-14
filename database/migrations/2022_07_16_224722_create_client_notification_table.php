<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientNotificationTable extends Migration {

	public function up()
	{
		Schema::create('client_notification', function(Blueprint $table) {
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->integer('notification_id')->unsigned();
			$table->boolean('is_seen');
			$table->increments('id');
		});
	}

	public function down()
	{
		Schema::drop('client_notification');
	}
}
