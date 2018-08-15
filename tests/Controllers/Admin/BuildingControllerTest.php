<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class BuildingControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\BuildingController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\BuildingController::class);
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
        $response = $this->action('GET', 'Admin\BuildingController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\BuildingController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $building = factory(\App\Models\Building::class)->make();
        $this->action('POST', 'Admin\BuildingController@store', [
                '_token' => csrf_token(),
            ] + $building->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $building = factory(\App\Models\Building::class)->create();
        $this->action('GET', 'Admin\BuildingController@show', [$building->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $building = factory(\App\Models\Building::class)->create();

        $name = $faker->name;
        $id = $building->id;

        $building->name = $name;

        $this->action('PUT', 'Admin\BuildingController@update', [$id], [
                '_token' => csrf_token(),
            ] + $building->toArray());
        $this->assertResponseStatus(302);

        $newBuilding = \App\Models\Building::find($id);
        $this->assertEquals($name, $newBuilding->name);
    }

    public function testDeleteModel()
    {
        $building = factory(\App\Models\Building::class)->create();

        $id = $building->id;

        $this->action('DELETE', 'Admin\BuildingController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkBuilding = \App\Models\Building::find($id);
        $this->assertNull($checkBuilding);
    }

}
