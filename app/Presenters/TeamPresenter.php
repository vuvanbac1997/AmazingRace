<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\LastNotification;
use App\Models\Image;

class TeamPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = ['profile_image'];

    /**
    * @return \App\Models\LastNotification
    * */
    public function lastNotification()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cacheKey = \CacheHelper::keyForModel('LastNotificationModel');
            $cached = Redis::hget($cacheKey, $this->entity->last_notification_id);

            if( $cached ) {
                $lastNotification = new LastNotification(json_decode($cached, true));
                $lastNotification['id'] = json_decode($cached, true)['id'];
                return $lastNotification;
            } else {
                $lastNotification = $this->entity->lastNotification;
                Redis::hsetnx($cacheKey, $this->entity->last_notification_id, $lastNotification);
                return $lastNotification;
            }
        }

        $lastNotification = $this->entity->lastNotification;
        return $lastNotification;
    }

    /**
    * @return \App\Models\Image
    * */
    public function profileImage()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cacheKey = \CacheHelper::keyForModel('ImageModel');
            $cached = Redis::hget($cacheKey, $this->entity->profile_image_id);

            if( $cached ) {
                $image = new Image(json_decode($cached, true));
                $image['id'] = json_decode($cached, true)['id'];
                return $image;
            } else {
                $image = $this->entity->profileImage;
                Redis::hsetnx($cacheKey, $this->entity->profile_image_id, $image);
                return $image;
            }
        }

        $image = $this->entity->profileImage;
        return $image;
    }

    
}
