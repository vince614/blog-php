<?php
namespace Core\Models;

use App\App;
use App_Core_Exception;
use PDO;

/**
 * Class Model
 * @package Core\Models
 */
class Model extends Database
{

    /**
     * Name of table
     * @var string
     */
    protected $_tableName;

    /**
     * Name of entity
     * @var string
     */
    protected $_entityName;

    /**
     * Load an object
     *
     * @param $id
     * @param $field
     * @return bool|mixed
     */
    public function load($id, $field = null)
    {
        $sql = "SELECT * FROM $this->_tableName WHERE id = ?";
        if ($field) $sql = "SELECT * FROM $this->_tableName WHERE $field = ?";
        $req = $this->pdo->prepare($sql);
        $req->execute([$id]);
        return Database::isSuccess($req) ?
            $this->getEntity($this->_entityName, $req->fetch()) :
            false;
    }

    /**
     * Get Collection
     *
     * @return array|bool
     */
    public function getCollection()
    {
        $result = [];
        $req = $this->pdo->prepare("SELECT * FROM $this->_tableName");
        $req->execute();
        if (Database::isSuccess($req)) {
            foreach ($req->fetchAll() as $datas) {
                $result[] = $this->getEntity($this->_entityName, $datas);
            }
            return $result;
        }
        return false;
    }

    /**
     * Save an object datas
     *
     * @param $object
     * @return bool
     * @throws App_Core_Exception
     */
    public function save($object)
    {
        $attributes = $object->getAttributes();
        if ($attributes) {
            $array = [];
            foreach ($attributes as $attribut) {
                $method = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
                if (is_callable([$object, $method])) {
                    $array[$attribut] = $object->$method();
                }
            }
            return Database::updateMultiple($this->_tableName, $array);
        }
        App::throwException("Erreur lors de la sauvegarde, pas d'attributs trouvés..");
    }

    /**
     * Get entity
     *
     * @param $entityName
     * @param $datas
     * @return bool
     */
    public function getEntity($entityName, $datas)
    {
        $entityName = ucfirst($entityName) . "Entity";
        require_once ROOT . '/App//Entity/' . $entityName . '.php';
        $className = "App\\Entity\\" . $entityName;
        if (class_exists($className)) {
            return new $className($datas);
        }
        return false;
    }
}