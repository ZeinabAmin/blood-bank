<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('phone')->unique();
			$table->string('email');
			$table->integer('blood_type_id')->unsigned();
			$table->string('password');
			$table->string('name');
			$table->date('date_of_birth');
			$table->string('pin_code')->nullable();
			$table->integer('city_id')->unsigned();
			$table->date('last_donation_date');
            $table->string('api_token',60)->unique()->nullable();
            
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
