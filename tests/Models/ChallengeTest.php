<?php namespace Tests\Models;

use App\Models\Challenge;
use Tests\TestCase;

class ChallengeTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Challenge $challenge */
        $challenge = new Challenge();
        $this->assertNotNull($challenge);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Challenge $challenge */
        $challengeModel = new Challenge();

        $challengeData = factory(Challenge::class)->make();
        foreach( $challengeData->toFillableArray() as $key => $value ) {
            $challengeModel->$key = $value;
        }
        $challengeModel->save();

        $this->assertNotNull(Challenge::find($challengeModel->id));
    }

}
