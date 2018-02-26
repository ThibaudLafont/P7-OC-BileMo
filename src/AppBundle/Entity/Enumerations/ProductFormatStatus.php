<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class ProductFormatStatus
 * Say if product is formatted or not or unknow
 *
 * @package AppBundle\Entity\Enumerations
 */
class ProductFormatStatus
{

    /**
     * Constants keys for DB persists
     */
    const FORMATTED = "formatted";
    const NOT_FORMATTED = "not_formatted";
    const UNKNOW = "unknow";

    /**
     * @var array
     *
     * String to display by cont key
     */
    private static $values = [
        self::FORMATTED => "Réinitialisé",
        self::NOT_FORMATTED => "Non réinitialisé",
        self::UNKNOW => "Inconnu"
    ];

    /**
     * Permit to get a value related to a key
     *
     * @param $type
     * @return mixed|string
     */
    public static function getValue($type)
    {
        if(!isset(static::$values[$type])) return "Unknow format status";
        else return static::$values[$type];
    }

    /**
     * Return the differents availables keys
     *
     * @return array
     */
    public static function getAvailableTypes(){
        return [
            self::FORMATTED,
            self::NOT_FORMATTED,
            self::UNKNOW
        ];
    }
}