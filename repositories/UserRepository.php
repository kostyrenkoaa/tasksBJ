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
}
