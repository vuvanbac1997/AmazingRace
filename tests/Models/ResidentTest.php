<?php namespace Tests\Models;

use App\Models\Resident;
use Tests\TestCase;

class ResidentTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Resident $resident */
        $resident = new Resident();
        $this->assertNotNull($resident);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Resident $resident */
        $residentModel = new Resident();

        $residentData = factory(Resident::class)->make();
        foreach( $residentData->toFillableArray() as $key => $value ) {
            $residentModel->$key = $value;
        }
        $residentModel->save();

        $this->assertNotNull(Resident::find($residentModel->id));
    }

}
