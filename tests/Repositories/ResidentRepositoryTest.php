<?php namespace Tests\Repositories;

use App\Models\Resident;
use Tests\TestCase;

class ResidentRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ResidentRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ResidentRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $residents = factory(Resident::class, 3)->create();
        $residentIds = $residents->pluck('id')->toArray();

        /** @var  \App\Repositories\ResidentRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ResidentRepositoryInterface::class);
        $this->assertNotNull($repository);

        $residentsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Resident::class, $residentsCheck[0]);

        $residentsCheck = $repository->getByIds($residentIds);
        $this->assertEquals(3, count($residentsCheck));
    }

    public function testFind()
    {
        $residents = factory(Resident::class, 3)->create();
        $residentIds = $residents->pluck('id')->toArray();

        /** @var  \App\Repositories\ResidentRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ResidentRepositoryInterface::class);
        $this->assertNotNull($repository);

        $residentCheck = $repository->find($residentIds[0]);
        $this->assertEquals($residentIds[0], $residentCheck->id);
    }

    public function testCreate()
    {
        $residentData = factory(Resident::class)->make();

        /** @var  \App\Repositories\ResidentRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ResidentRepositoryInterface::class);
        $this->assertNotNull($repository);

        $residentCheck = $repository->create($residentData->toFillableArray());
        $this->assertNotNull($residentCheck);
    }

    public function testUpdate()
    {
        $residentData = factory(Resident::class)->create();

        /** @var  \App\Repositories\ResidentRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ResidentRepositoryInterface::class);
        $this->assertNotNull($repository);

        $residentCheck = $repository->update($residentData, $residentData->toFillableArray());
        $this->assertNotNull($residentCheck);
    }

    public function testDelete()
    {
        $residentData = factory(Resident::class)->create();

        /** @var  \App\Repositories\ResidentRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ResidentRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($residentData);

        $residentCheck = $repository->find($residentData->id);
        $this->assertNull($residentCheck);
    }

}
