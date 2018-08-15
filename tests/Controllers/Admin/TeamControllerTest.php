<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class TeamControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\TeamController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\TeamController::class);
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
        $response = $this->action('GET', 'Admin\TeamController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\TeamController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $team = factory(\App\Models\Team::class)->make();
        $this->action('POST', 'Admin\TeamController@store', [
                '_token' => csrf_token(),
            ] + $team->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $team = factory(\App\Models\Team::class)->create();
        $this->action('GET', 'Admin\TeamController@show', [$team->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $team = factory(\App\Models\Team::class)->create();

        $name = $faker->name;
        $id = $team->id;

        $team->name = $name;

        $this->action('PUT', 'Admin\TeamController@update', [$id], [
                '_token' => csrf_token(),
            ] + $team->toArray());
        $this->assertResponseStatus(302);

        $newTeam = \App\Models\Team::find($id);
        $this->assertEquals($name, $newTeam->name);
    }

    public function testDeleteModel()
    {
        $team = factory(\App\Models\Team::class)->create();

        $id = $team->id;

        $this->action('DELETE', 'Admin\TeamController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkTeam = \App\Models\Team::find($id);
        $this->assertNull($checkTeam);
    }

}
