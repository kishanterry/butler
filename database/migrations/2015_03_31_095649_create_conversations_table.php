<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConversationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->string('title')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('conversation_user', function (Blueprint $table) {
			$table->bigIncrements('id')->unsigned();
			$table->bigInteger('conversation_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->boolean('seen')->default(0);
        });
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('conversations');
    }

}
