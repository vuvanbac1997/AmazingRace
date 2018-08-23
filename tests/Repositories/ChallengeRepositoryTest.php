<?php namespace Tests\Repositories;

use App\Models\Challenge;
use Tests\TestCase;

class ChallengeRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ChallengeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ChallengeRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $challenges = factory(Challenge::class, 3)->create();
        $challengeIds = $challenges->pluck('id')->toArray();

        /** @var  \App\Repositories\ChallengeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ChallengeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $challengesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Challenge::class, $challengesCheck[0]);

        $challengesCheck = $repository->getByIds($challengeIds);
        $this->assertEquals(3, count($challengesCheck));
    }

    public function testFind()
    {
        $challenges = factory(Challenge::class, 3)->create();
        $challengeIds = $challenges->pluck('id')->toArray();

        /** @var  \App\Repositories\ChallengeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ChallengeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $challengeCheck = $repository->find($challengeIds[0]);
        $this->assertEquals($challengeIds[0], $challengeCheck->id);
    }

    public function testCreate()
    {
        $challengeData = factory(Challenge::class)->make();

        /** @var  \App\Repositories\ChallengeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ChallengeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $challengeCheck = $repository->create($challengeData->toFillableArray());
        $this->assertNotNull($challengeCheck);
    }

    public function testUpdate()
    {
        $challengeData = factory(Challenge::class)->create();

        /** @var  \App\Repositories\ChallengeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ChallengeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $challengeCheck = $repository->update($challengeData, $challengeData->toFillableArray());
        $this->assertNotNull($challengeCheck);
    }

    public function testDelete()
    {
        $challengeData = factory(Challenge::class)->create();

        /** @var  \App\Repositories\ChallengeRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ChallengeRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($challengeData);

        $challengeCheck = $repository->find($challengeData->id);
        $this->assertNull($challengeCheck);
    }

}
