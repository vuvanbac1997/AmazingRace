<?php namespace Tests\Models;

use App\Models\WaterBill;
use Tests\TestCase;

class WaterBillTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\WaterBill $waterBill */
        $waterBill = new WaterBill();
        $this->assertNotNull($waterBill);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\WaterBill $waterBill */
        $waterBillModel = new WaterBill();

        $waterBillData = factory(WaterBill::class)->make();
        foreach( $waterBillData->toFillableArray() as $key => $value ) {
            $waterBillModel->$key = $value;
        }
        $waterBillModel->save();

        $this->assertNotNull(WaterBill::find($waterBillModel->id));
    }

}
