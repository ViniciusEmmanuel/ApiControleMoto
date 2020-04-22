<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Maintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->integer('motorcicle_id')
                ->nullable(false);

            $table->foreign('motorcicle_id')
                ->references('id')
                ->on('motorcicles');

            $table->integer('part_id')
                ->nullable(false);

            $table->foreign('part_id')
                ->references('id')
                ->on('parts');

            $table->date('date')
                ->nullable(false);

            $table->float('km', 10, 2)
                ->nullable(false);

            $table->float('price', 10, 2)
                ->nullable(false);

            $table->string('mechanic')
                ->nullable(false);

            $table->mediumText('description')
                ->nullable(true);

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
        Schema::drop('maintenance');
    }
}
