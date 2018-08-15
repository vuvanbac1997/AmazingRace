<?php namespace App\Repositories\Eloquent;

use \App\Repositories\TeamRepositoryInterface;
use \App\Models\Team;

class TeamRepository extends SingleKeyModelRepository implements TeamRepositoryInterface
{

    public function getBlankModel()
    {
        return new Team();
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
