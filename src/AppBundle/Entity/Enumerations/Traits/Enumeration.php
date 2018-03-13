<?php
namespace AppBundle\Entity\Enumerations\Traits;

/**
 * Trait Enumeration
 *
 * @package AppBundle\Entity\Enumerations
 */
trait Enumeration
{

    /**
     * Permit to get a value related to a key
     *
     * @param $key string
     *
     * @return mixed|string
     */
    public static function getValue(string $key) : string
    {
        if (!isset(static::$values[$key])) {
            return "Unknow " . get_called_class();
        } else {
            return static::$values[$key];
        }
    }

    /**
     * Return all values
     *
     * @return array
     */
    abstract public function getValues() : array;

}
