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
            $table->string('username');
            $table->string('display_name');
            $table->string('password');
            $table->bigInteger('id_company');
            // Add some more columns
             $table->bigInteger('last_notification_id')->default(0);

            $table->string('api_access_token')->default('');

            $table->bigInteger('profile_image_id')->default(0);

            $table->smallInteger('is_activated')->default(0);

            $table->softDeletes();
            $table->rememberToken();
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
