<?php namespace Tests\Services;

use Tests\TestCase;

class TeamServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\TeamServiceInterface $service */
        $service = \App::make(\App\Services\TeamServiceInterface::class);
        $this->assertNotNull($service);
    }

}
