<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Gasoline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gasoline', function (Blueprint $table) {
            $table->increments('id');

            $table->char('user_id', 36)
                ->charset('ascii');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->unsignedInteger('motorcicle_id');

            $table->foreign('motorcicle_id')
                ->references('id')
                ->on('motorcicles');

            $table->date('date')
                ->nullable(false);

            $table->float('km', 10, 2)
                ->nullable(false);

            $table->float('liters', 10, 2)
                ->nullable(false);

            $table->float('price', 10, 2)
                ->nullable(false);

            $table->boolean('deleted')
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
        Schema::drop('gasoline');
    }
}
