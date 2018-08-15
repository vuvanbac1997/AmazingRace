<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class ResidentControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\ResidentController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\ResidentController::class);
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
        $response = $this->action('GET', 'Admin\ResidentController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\ResidentController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $resident = factory(\App\Models\Resident::class)->make();
        $this->action('POST', 'Admin\ResidentController@store', [
                '_token' => csrf_token(),
            ] + $resident->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $resident = factory(\App\Models\Resident::class)->create();
        $this->action('GET', 'Admin\ResidentController@show', [$resident->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $resident = factory(\App\Models\Resident::class)->create();

        $name = $faker->name;
        $id = $resident->id;

        $resident->name = $name;

        $this->action('PUT', 'Admin\ResidentController@update', [$id], [
                '_token' => csrf_token(),
            ] + $resident->toArray());
        $this->assertResponseStatus(302);

        $newResident = \App\Models\Resident::find($id);
        $this->assertEquals($name, $newResident->name);
    }

    public function testDeleteModel()
    {
        $resident = factory(\App\Models\Resident::class)->create();

        $id = $resident->id;

        $this->action('DELETE', 'Admin\ResidentController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkResident = \App\Models\Resident::find($id);
        $this->assertNull($checkResident);
    }

}
