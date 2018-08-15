<?php namespace Tests\Models;

use App\Models\ElectricBill;
use Tests\TestCase;

class ElectricBillTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\ElectricBill $electricBill */
        $electricBill = new ElectricBill();
        $this->assertNotNull($electricBill);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\ElectricBill $electricBill */
        $electricBillModel = new ElectricBill();

        $electricBillData = factory(ElectricBill::class)->make();
        foreach( $electricBillData->toFillableArray() as $key => $value ) {
            $electricBillModel->$key = $value;
        }
        $electricBillModel->save();

        $this->assertNotNull(ElectricBill::find($electricBillModel->id));
    }

}
