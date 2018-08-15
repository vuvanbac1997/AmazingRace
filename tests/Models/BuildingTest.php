<?php namespace Tests\Models;

use App\Models\Building;
use Tests\TestCase;

class BuildingTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Building $building */
        $building = new Building();
        $this->assertNotNull($building);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Building $building */
        $buildingModel = new Building();

        $buildingData = factory(Building::class)->make();
        foreach( $buildingData->toFillableArray() as $key => $value ) {
            $buildingModel->$key = $value;
        }
        $buildingModel->save();

        $this->assertNotNull(Building::find($buildingModel->id));
    }

}
