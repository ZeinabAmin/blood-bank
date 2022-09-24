<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration {

	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('subject');
			$table->integer('client_id')->unsigned();
			$table->string('msg');
		});
	}

	public function down()
	{
		Schema::drop('contacts');
	}
}
