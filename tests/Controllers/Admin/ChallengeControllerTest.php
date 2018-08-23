<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class ChallengeControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\ChallengeController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\ChallengeController::class);
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
        $response = $this->action('GET', 'Admin\ChallengeController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\ChallengeController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $challenge = factory(\App\Models\Challenge::class)->make();
        $this->action('POST', 'Admin\ChallengeController@store', [
                '_token' => csrf_token(),
            ] + $challenge->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $challenge = factory(\App\Models\Challenge::class)->create();
        $this->action('GET', 'Admin\ChallengeController@show', [$challenge->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $challenge = factory(\App\Models\Challenge::class)->create();

        $name = $faker->name;
        $id = $challenge->id;

        $challenge->name = $name;

        $this->action('PUT', 'Admin\ChallengeController@update', [$id], [
                '_token' => csrf_token(),
            ] + $challenge->toArray());
        $this->assertResponseStatus(302);

        $newChallenge = \App\Models\Challenge::find($id);
        $this->assertEquals($name, $newChallenge->name);
    }

    public function testDeleteModel()
    {
        $challenge = factory(\App\Models\Challenge::class)->create();

        $id = $challenge->id;

        $this->action('DELETE', 'Admin\ChallengeController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkChallenge = \App\Models\Challenge::find($id);
        $this->assertNull($checkChallenge);
    }

}
