<?php
namespace App\Models;

use Core\Models\Model;

/**
 * Class CommentModel
 * @package App\Models
 */
class CommentModel extends Model
{
    /**
     * CommentModel constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->_tableName   = $name;
        $this->_entityName  = $name;
        parent::__construct();
    }
}