<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatestvUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stv_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Add some more columns

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('stv_users', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stv_users');
    }
}
