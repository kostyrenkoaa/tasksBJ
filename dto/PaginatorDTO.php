<?php

namespace App\dto;

class PaginatorDTO extends DTO
{
    public $page = 1;
    public $sortBy = 'id';
    public $direction = 'DESC';
    public $countPages = 1;
    public $countInPage = 3;
    public $offset = 0;

    /**
     * Разрешенные направления сортировок
     *
     * @return string[]
     */
    public function getDirections()
    {
        return ['DESC', 'ASC'];
    }

    /**
     * Разрешенные поля для сортировок
     *
     * @return string[]
     */
    public function getSortBys()
    {
        return ['id', 'user_name', 'email', 'status'];
    }

    /**
     * Возвращает список ссылок для пагинации
     *
     * @return array
     */
    public function getArrayPages()
    {
        $array = [];

        for ($i = 1; $i <= $this->countPages; $i++) {
            $array[] = "?page={$i}&direction={$this->direction}&sortBy={$this->sortBy}";
        }

        return $array;
    }

    /**
     * Возвращает ссылку для сортировки по указанному полю
     *
     * @param $field
     * @return string
     */
    public function getSortString($field)
    {
        $direction = 'DESC';
        if ($this->sortBy == $field && $this->direction == 'DESC') {
            $direction = 'ASC';
        }

        return "?page={$this->page}&direction={$direction}&sortBy={$field}";
    }

    /**
     * Возвращает активный класс по указанному полю
     *
     * @param $field
     * @return string
     */
    public function getClassAction($field)
    {
        if ($field == $this->sortBy) {
            return 'action';
        }

        return '';
    }
}