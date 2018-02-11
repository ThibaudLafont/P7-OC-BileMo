<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class ProductState
 * Define different physic states for Product
 *
 * @package AppBundle\Entity\Enumerations
 */
class ProductState
{

    /**
     * Constants keys for DB persists
     */
    const UNUSED = "unused";
    const LIKE_NEW = "like_new";
    const GOOD = "good";
    const AVERAGE = "average";
    const BAD = "bad";

    /**
     * @var array
     *
     * String to display by cont key
     */
    private static $values = [
        self::UNUSED => "Jamais utilisé",
        self::LIKE_NEW => "Comme neuf",
        self::GOOD => "Bon",
        self::AVERAGE => "Moyen",
        self::BAD => "Mauvais"
    ];

    /**
     * Permit to get a value related to a key
     *
     * @param $type
     * @return mixed|string
     */
    public static function getValue($type){
        if(!isset(static::$values[$type])) return "Unknow state type";
        else return static::$values[$type];
    }

    /**
     * Return the differents availables keys
     *
     * @return array
     */
    public static function getAvailableTypes(){
        return [
            self::UNUSED,
            self::LIKE_NEW,
            self::GOOD,
            self::AVERAGE,
            self::BAD
        ];
    }
}