<?php namespace Tests\Repositories;

use App\Models\Player;
use Tests\TestCase;

class PlayerRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\PlayerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PlayerRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $players = factory(Player::class, 3)->create();
        $playerIds = $players->pluck('id')->toArray();

        /** @var  \App\Repositories\PlayerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PlayerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $playersCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Player::class, $playersCheck[0]);

        $playersCheck = $repository->getByIds($playerIds);
        $this->assertEquals(3, count($playersCheck));
    }

    public function testFind()
    {
        $players = factory(Player::class, 3)->create();
        $playerIds = $players->pluck('id')->toArray();

        /** @var  \App\Repositories\PlayerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PlayerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $playerCheck = $repository->find($playerIds[0]);
        $this->assertEquals($playerIds[0], $playerCheck->id);
    }

    public function testCreate()
    {
        $playerData = factory(Player::class)->make();

        /** @var  \App\Repositories\PlayerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PlayerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $playerCheck = $repository->create($playerData->toFillableArray());
        $this->assertNotNull($playerCheck);
    }

    public function testUpdate()
    {
        $playerData = factory(Player::class)->create();

        /** @var  \App\Repositories\PlayerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PlayerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $playerCheck = $repository->update($playerData, $playerData->toFillableArray());
        $this->assertNotNull($playerCheck);
    }

    public function testDelete()
    {
        $playerData = factory(Player::class)->create();

        /** @var  \App\Repositories\PlayerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\PlayerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($playerData);

        $playerCheck = $repository->find($playerData->id);
        $this->assertNull($playerCheck);
    }

}
