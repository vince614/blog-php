<?php

namespace Core\Entity;

/**
 * Class Entity
 * @package Core\Entity
 */
class Entity
{

    /**
     * @var array
     */
    private $_attributes = [];

    /**
     * Entity constructor.
     * @param array $datas
     */
    public function __construct(Array $datas)
    {
        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    /**
     * Get magic method
     *
     * @param  string $key
     * @return string getter
     */
    public function get($key)
    {
        $method = 'get' . ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }

    /**
     * Hydrate entity
     *
     * @param $datas
     */
    public function hydrate($datas)
    {
        foreach ($datas as $attribut => $value) {
            $this->_attributes[] = $attribut;
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));
            if (is_callable([$this, $method])) {
                $this->$method($value);
            }
        }
    }

    /**
     * Get entity attribut
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->_attributes;
    }

}