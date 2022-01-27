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

    public function getDirections()
    {
        return ['DESC', 'ASC'];
    }

    public function getSortBys()
    {
        return ['id', 'user_name', 'email', 'status'];
    }

    public function getArrayPages()
    {
        $array = [];

        for ($i = 1; $i <= $this->countPages; $i++) {
            $array[] = "?page={$i}&direction={$this->direction}&sortBy={$this->sortBy}";
        }

        return $array;
    }

    public function getSortString($field)
    {
        $direction = 'DESC';
        if ($this->sortBy == $field && $this->direction == 'DESC') {
            $direction = 'ASC';
        }

        return "?page={$this->page}&direction={$direction}&sortBy={$field}";
    }

    public function getClassAction($field)
    {
        if ($field == $this->sortBy) {
            return 'action';
        }

        return '';
    }
}