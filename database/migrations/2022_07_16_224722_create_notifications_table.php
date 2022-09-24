<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->timestamps();
			$table->string('title');
			$table->text('content');
			$table->integer('donation_request_id')->unsigned();
			$table->increments('id');
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}
