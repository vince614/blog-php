<?php
namespace App\Models;

use Core\Models\Model;

/**
 * Class UserModel
 * @package App\Models
 */
class PostModel extends Model
{
    /**
     * PostModel constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->_tableName   = $name;
        $this->_entityName  = $name;
        parent::__construct();
    }
}