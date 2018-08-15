<?php namespace Tests\Repositories;

use App\Models\Team;
use Tests\TestCase;

class TeamRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\TeamRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeamRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $teams = factory(Team::class, 3)->create();
        $teamIds = $teams->pluck('id')->toArray();

        /** @var  \App\Repositories\TeamRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeamRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teamsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Team::class, $teamsCheck[0]);

        $teamsCheck = $repository->getByIds($teamIds);
        $this->assertEquals(3, count($teamsCheck));
    }

    public function testFind()
    {
        $teams = factory(Team::class, 3)->create();
        $teamIds = $teams->pluck('id')->toArray();

        /** @var  \App\Repositories\TeamRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeamRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teamCheck = $repository->find($teamIds[0]);
        $this->assertEquals($teamIds[0], $teamCheck->id);
    }

    public function testCreate()
    {
        $teamData = factory(Team::class)->make();

        /** @var  \App\Repositories\TeamRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeamRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teamCheck = $repository->create($teamData->toFillableArray());
        $this->assertNotNull($teamCheck);
    }

    public function testUpdate()
    {
        $teamData = factory(Team::class)->create();

        /** @var  \App\Repositories\TeamRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeamRepositoryInterface::class);
        $this->assertNotNull($repository);

        $teamCheck = $repository->update($teamData, $teamData->toFillableArray());
        $this->assertNotNull($teamCheck);
    }

    public function testDelete()
    {
        $teamData = factory(Team::class)->create();

        /** @var  \App\Repositories\TeamRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\TeamRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($teamData);

        $teamCheck = $repository->find($teamData->id);
        $this->assertNull($teamCheck);
    }

}
