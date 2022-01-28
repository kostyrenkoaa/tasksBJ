<?php

namespace App\services;

use App\dto\PaginatorDTO;
use App\repositories\Repository;

class PaginatorService extends Service
{
    /**
     * Возвращает обработанные безопасные данные для работы пагинатора
     *
     * @param Repository $repository
     * @param PaginatorDTO $paginatorDTO
     * @return PaginatorDTO
     */
    public function getData(Repository $repository, PaginatorDTO $paginatorDTO)
    {
        $data = $repository->getCount();
        $count = $data['count'];

        $countPages = intdiv($count, $paginatorDTO->countInPage);
        if ($count % $paginatorDTO->countInPage) {
            $countPages++;
        }

        if (empty($countPages)) {
            $countPages = 1;
        }

        $paginatorDTO->countPages = $countPages;

        if (empty($paginatorDTO->page) || $paginatorDTO->page > $countPages) {
            $paginatorDTO->page = 1;
        }

        $direction = $paginatorDTO->getDirections();
        if (!in_array($paginatorDTO->direction, $direction)) {
            $paginatorDTO->direction = $direction[0];
        }

        $sortBys = $paginatorDTO->getSortBys();
        if (!in_array($paginatorDTO->sortBy, $sortBys)) {
            $paginatorDTO->sortBy = $sortBys[0];
        }

        $paginatorDTO->offset = ($paginatorDTO->page -1 ) * $paginatorDTO->countInPage;

        return $paginatorDTO;
    }
}
