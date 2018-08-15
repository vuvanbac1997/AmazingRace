<?php namespace Tests\Models;

use App\Models\Player;
use Tests\TestCase;

class PlayerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Player $player */
        $player = new Player();
        $this->assertNotNull($player);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Player $player */
        $playerModel = new Player();

        $playerData = factory(Player::class)->make();
        foreach( $playerData->toFillableArray() as $key => $value ) {
            $playerModel->$key = $value;
        }
        $playerModel->save();

        $this->assertNotNull(Player::find($playerModel->id));
    }

}
