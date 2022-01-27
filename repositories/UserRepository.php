<?php
namespace App\repositories;

use App\entities\User;

/**
 * @method User getOne($id)
 */
class UserRepository extends Repository
{
    public function getTableName(): string
    {
        return 'users';
    }

    protected function getEntityClass()
    {
        return User::class;
    }

    /**
     * @param $login
     * @return \App\entities\Entity|null|User
     */
    public function getUserByLogin($login)
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM {$table} WHERE login = :login";
        return $this->db->getObject($sql, $this->getEntityClass(), [':login' => $login]);
    }
}
