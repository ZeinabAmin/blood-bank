<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientGovernorateTable extends Migration {

	public function up()
	{
		Schema::create('client_governorate', function(Blueprint $table) {
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->integer('governorate_id')->unsigned();
			$table->increments('id');
		});
	}

	public function down()
	{
		Schema::drop('client_governorate');
	}
}
