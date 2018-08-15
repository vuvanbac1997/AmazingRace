<?php namespace Tests\Models;

use App\Models\Report;
use Tests\TestCase;

class ReportTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Report $report */
        $report = new Report();
        $this->assertNotNull($report);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Report $report */
        $reportModel = new Report();

        $reportData = factory(Report::class)->make();
        foreach( $reportData->toFillableArray() as $key => $value ) {
            $reportModel->$key = $value;
        }
        $reportModel->save();

        $this->assertNotNull(Report::find($reportModel->id));
    }

}
