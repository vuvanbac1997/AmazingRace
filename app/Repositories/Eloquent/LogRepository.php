<?php namespace App\Repositories\Eloquent;

use \App\Repositories\LogRepositoryInterface;
use \App\Models\Log;

class LogRepository extends SingleKeyModelRepository implements LogRepositoryInterface
{

    public function getBlankModel()
    {
        return new Log();
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

    public function getWithFilter($filter, $order, $direction, $offset, $limit)
    {
        $logModel = $this->getBlankModel();

        $keyword = isset($filter['keyword']) ? $filter['keyword'] : '';
        $logModel = $logModel->where(function ($subquery) use ($keyword) {
            $subquery->where('user_name', 'like', '%'.$keyword.'%')
                     ->orWhere('email', 'like', '%'.$keyword.'%')
                     ->orWhere('action', 'like', '%'.$keyword.'%')
                     ->orWhere('table', 'like', '%'.$keyword.'%')
                     ->orWhere('record_id', 'like', '%'.$keyword.'%')
                     ->orWhere('query', 'like', '%'.$keyword.'%');
        });

        return $logModel->orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public function countWithFilter($filter)
    {
        $logModel = $this->getBlankModel();

        $keyword = isset($filter['keyword']) ? $filter['keyword'] : '';
        $logModel = $logModel->where(function ($subquery) use ($keyword) {
            $subquery->where('user_name', 'like', '%'.$keyword.'%')
                     ->orWhere('email', 'like', '%'.$keyword.'%')
                     ->orWhere('action', 'like', '%'.$keyword.'%')
                     ->orWhere('table', 'like', '%'.$keyword.'%')
                     ->orWhere('record_id', 'like', '%'.$keyword.'%')
                     ->orWhere('query', 'like', '%'.$keyword.'%');
        });

        return $logModel->count();
    }
}
