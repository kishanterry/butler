<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
			$table->increments('id')->unsigned();
			$table->string('app_id');
			$table->string('name');
			$table->string('app_key');
			$table->string('app_secret');
			$table->integer('user_id');
			$table->boolean('enabled')->default(0);
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
        Schema::drop('apps');
    }

}
