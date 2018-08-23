<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ChallengeRepositoryInterface;
use \App\Models\Challenge;

class ChallengeRepository extends SingleKeyModelRepository implements ChallengeRepositoryInterface
{

    public function getBlankModel()
    {
        return new Challenge();
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
