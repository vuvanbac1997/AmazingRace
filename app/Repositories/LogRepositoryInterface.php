<?php namespace App\Repositories;

interface LogRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * Get logs with filter conditions
     *
     * @param array     $filter ['keyword', $price['from'], $price['to'], $subcategory]
     * @return array    App\Model\Product
     * */
    public function getWithFilter($filter, $order, $direction, $offset, $limit);

    /**
     * Count logs with filter conditions
     *
     * @param array     $filter ['keyword', $price['from'], $price['to'], $subcategory]
     * @return array    App\Model\Product
     * */
    public function countWithFilter($filter);
}