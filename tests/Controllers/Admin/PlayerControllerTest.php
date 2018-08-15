<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class PlayerControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\PlayerController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\PlayerController::class);
        $this->assertNotNull($controller);
    }

    public function setUp()
    {
        parent::setUp();
        $authUser = \App\Models\AdminUser::first();
        $this->be($authUser, 'admins');
    }

    public function testGetList()
    {
        $response = $this->action('GET', 'Admin\PlayerController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\PlayerController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $player = factory(\App\Models\Player::class)->make();
        $this->action('POST', 'Admin\PlayerController@store', [
                '_token' => csrf_token(),
            ] + $player->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $player = factory(\App\Models\Player::class)->create();
        $this->action('GET', 'Admin\PlayerController@show', [$player->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $player = factory(\App\Models\Player::class)->create();

        $name = $faker->name;
        $id = $player->id;

        $player->name = $name;

        $this->action('PUT', 'Admin\PlayerController@update', [$id], [
                '_token' => csrf_token(),
            ] + $player->toArray());
        $this->assertResponseStatus(302);

        $newPlayer = \App\Models\Player::find($id);
        $this->assertEquals($name, $newPlayer->name);
    }

    public function testDeleteModel()
    {
        $player = factory(\App\Models\Player::class)->create();

        $id = $player->id;

        $this->action('DELETE', 'Admin\PlayerController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkPlayer = \App\Models\Player::find($id);
        $this->assertNull($checkPlayer);
    }

}
