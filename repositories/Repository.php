<?php
namespace App\repositories;

use App\dto\PaginatorDTO;
use App\entities\Entity;
use App\services\DBService;

abstract class Repository
{
    /**
     * Good constructor.
     */
    public function __construct(
        protected DBService $db
    )
    {
    }

    /**
     * Возвращает имя сущности
     *
     * @return string
     */
    abstract protected function getEntityClass();

    /**
     * Возвращает имя таблицы в базе
     *
     * @return string
     */
    abstract protected function getTableName();

    public function getNewEntity(): Entity
    {
        $entity = $this->getEntityClass();
        return new $entity();
    }

    /**
     * Получение конкретной записи
     *
     * @param $id
     * @return
     */
    public function getOne($id)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE id = :id";
        return $this->db->getObject($sql, $this->getEntityClass(), [':id' => $id]);
    }

    /**
     * Получение всех записей
     *
     * @return array
     */
    public function getAll()
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table}";
        return $this->db->getObjects($sql, $this->getEntityClass());
    }

    public function getAllByPagination(PaginatorDTO $paginatorDTO)
    {
        $table = $this->getTableName();
        $offset = (int)$paginatorDTO->offset;
        $countInPage = (int)$paginatorDTO->countInPage;
        $sortBy = $paginatorDTO->sortBy;
        $direction = $paginatorDTO->direction;

        $sql = "SELECT * FROM {$table} ORDER BY {$sortBy} {$direction} LIMIT $offset, $countInPage";
        return $this->db->getObjects($sql, $this->getEntityClass());
    }

    /**
     * Удаление сущности
     *
     * @param Entity $entity
     * @return int
     */
    public function delete(Entity $entity)
    {
        $table = $this->getTableName();
        $sql = "DELETE FROM {$table} WHERE id = :id";
        return $this->db->execute($sql, [':id' => $entity->id]);
    }

    /**
     * Добавление сущности
     *
     * @param Entity $entity
     */
    protected function insert(Entity $entity)
    {
        $columns = [];
        $params = [];

        foreach ($entity as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $columns[] = $key;
            $params[":{$key}"] = $value;
        }

        $columns = implode(', ', $columns);
        $placeholders = implode(', ', array_keys($params));

        $table = $this->getTableName();
        $sql = "INSERT INTO {$table}
                ({$columns}) 
                VALUES ({$placeholders})";
        $this->db->execute($sql, $params);
        $entity->id = (integer)$this->db->getLastId();
    }

    /**
     * Изменение сущности
     *
     * @param Entity $entity
     */
    protected function update(Entity $entity)
    {
        $placeholders = [];
        $params = [];

        foreach ($entity as $key => $value) {
            $params[":{$key}"] = $value;
            if ($key == 'id' || is_null($value)) {
                continue;
            }
            $placeholders[] = "{$key} = :{$key}";
        }

        $placeholders = implode(', ', $placeholders);

        $table = $this->getTableName();
        $sql = "UPDATE {$table} SET {$placeholders} WHERE id = :id";
        $this->db->execute($sql, $params);
    }

    /**
     * Сохранение сущности
     *
     * @param Entity $entity
     */
    public function save(Entity $entity)
    {
        if (empty($entity->id)) {
            $this->insert($entity);
        } else {
            $this->update($entity);
        }
    }

    /**
     * Возвращает массив с данными о количестве строк в таблице
     *
     * @return array
     */
    public function getCount()
    {
        $table = $this->getTableName();
        $sql = "SELECT COUNT(*) AS `count` FROM {$table}";
        return $this->db->find($sql);
    }
}
