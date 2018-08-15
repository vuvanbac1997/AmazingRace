<?php namespace App\Repositories\Eloquent;

use \App\Repositories\PlayerRepositoryInterface;
use \App\Models\Player;

class PlayerRepository extends SingleKeyModelRepository implements PlayerRepositoryInterface
{

    public function getBlankModel()
    {
        return new Player();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

}
