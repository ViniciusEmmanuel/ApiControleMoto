<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->char('id', 36)
                ->primary()
                ->charset('ascii')
                ->nullable(false);

            $table->integer('user')
                ->nullable(false);

            $table->unique('user');

            $table->string('name')
                ->nullable(false);

            $table->string('password')
                ->nullable(false);

            $table->integer('role')
                ->nullable(false);

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
        Schema::drop('users');
    }
}
