<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateteamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Add some more columns
            $table->string('username');
            $table->string('display_name');
            $table->string('password');
            $table->bigInteger('cover_image_id')->nullable()->default(0);

            $table->softDeletes();
            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('teams', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
