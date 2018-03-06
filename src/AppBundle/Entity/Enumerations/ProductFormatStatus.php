<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class ProductFormatStatus
 *
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
     * @param $key string
     *
     * @return string
     */
    public static function getValue(string $key) : string
    {
        if(!isset(static::$values[$key])) return "Unknow format status";
        else return static::$values[$key];
    }

    /**
     * Return the differents availables keys
     *
     * @return array
     */
    public static function getAvailableTypes() : array
    {
        return [
            self::FORMATTED,
            self::NOT_FORMATTED,
            self::UNKNOW
        ];
    }
}
