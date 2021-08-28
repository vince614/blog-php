<?php
namespace App\Models;

use App\Entity\UserEntity;
use Core\Models\Model;

/**
 * Class UserModel
 * @package App\Models
 */
class UserModel extends Model
{
    /**
     * UserModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->_tableName   = 'users';
        $this->_entityName  = 'user';
    }

    /**
     * @param $id
     * @param null $field
     * @return bool|UserEntity
     */
    public function load($id, $field = null)
    {
        return parent::load($id, $field = null);
    }
}