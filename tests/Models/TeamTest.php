<?php namespace Tests\Models;

use App\Models\Team;
use Tests\TestCase;

class TeamTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Team $team */
        $team = new Team();
        $this->assertNotNull($team);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Team $team */
        $teamModel = new Team();

        $teamData = factory(Team::class)->make();
        foreach( $teamData->toFillableArray() as $key => $value ) {
            $teamModel->$key = $value;
        }
        $teamModel->save();

        $this->assertNotNull(Team::find($teamModel->id));
    }

}
