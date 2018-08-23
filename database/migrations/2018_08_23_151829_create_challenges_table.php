<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatechallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('content');
            $table->unsignedBigInteger('score');
            $table->text('answer');
            $table->unsignedBigInteger('cover_image_id')->nullable()->default(0);
            
            // Add some more columns

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('challenges', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenges');
    }
}
