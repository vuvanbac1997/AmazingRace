<?php namespace Tests\Repositories;

use App\Models\Building;
use Tests\TestCase;

class BuildingRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\BuildingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BuildingRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $buildings = factory(Building::class, 3)->create();
        $buildingIds = $buildings->pluck('id')->toArray();

        /** @var  \App\Repositories\BuildingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BuildingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $buildingsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Building::class, $buildingsCheck[0]);

        $buildingsCheck = $repository->getByIds($buildingIds);
        $this->assertEquals(3, count($buildingsCheck));
    }

    public function testFind()
    {
        $buildings = factory(Building::class, 3)->create();
        $buildingIds = $buildings->pluck('id')->toArray();

        /** @var  \App\Repositories\BuildingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BuildingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $buildingCheck = $repository->find($buildingIds[0]);
        $this->assertEquals($buildingIds[0], $buildingCheck->id);
    }

    public function testCreate()
    {
        $buildingData = factory(Building::class)->make();

        /** @var  \App\Repositories\BuildingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BuildingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $buildingCheck = $repository->create($buildingData->toFillableArray());
        $this->assertNotNull($buildingCheck);
    }

    public function testUpdate()
    {
        $buildingData = factory(Building::class)->create();

        /** @var  \App\Repositories\BuildingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BuildingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $buildingCheck = $repository->update($buildingData, $buildingData->toFillableArray());
        $this->assertNotNull($buildingCheck);
    }

    public function testDelete()
    {
        $buildingData = factory(Building::class)->create();

        /** @var  \App\Repositories\BuildingRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BuildingRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($buildingData);

        $buildingCheck = $repository->find($buildingData->id);
        $this->assertNull($buildingCheck);
    }

}
