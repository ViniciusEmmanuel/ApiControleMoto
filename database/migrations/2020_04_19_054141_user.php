<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
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
            $table->uuid('id')
                ->primary()
                ->default(new Expression('uuid_generate_v4()'));

            $table->integer('userId')
                ->nullable(false);
            $table->unique('userId');

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
