<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Resident;

class ReportPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\Resident
    * */
    public function resident()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cacheKey = \CacheHelper::keyForModel('ResidentModel');
            $cached = Redis::hget($cacheKey, $this->entity->resident_id);

            if( $cached ) {
                $resident = new Resident(json_decode($cached, true));
                $resident['id'] = json_decode($cached, true)['id'];
                return $resident;
            } else {
                $resident = $this->entity->resident;
                Redis::hsetnx($cacheKey, $this->entity->resident_id, $resident);
                return $resident;
            }
        }

        $resident = $this->entity->resident;
        return $resident;
    }

    
}
