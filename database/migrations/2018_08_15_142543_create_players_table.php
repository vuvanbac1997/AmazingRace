<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateplayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->bigInteger('id_team');
            // Add some more columns

            $table->bigInteger('cover_image_id')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('players', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
