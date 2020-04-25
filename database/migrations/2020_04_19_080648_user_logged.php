<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserLogged extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('user_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->char('user_id', 36)
                ->charset('ascii');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->string('token');

            $table->boolean('status')
                ->default(new Expression('false'));

            $table->timestamp('created_at')
                ->useCurrent();

            $table->timestamp('updated_at')
                ->useCurrent();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_logs');
    }
}
