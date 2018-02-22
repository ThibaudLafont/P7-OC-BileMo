<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class NoticeType
 * Define differents types od ProductNotice
 *
 * @package AppBundle\Entity\Enumerations
 */
class NoticeType
{

    /**
     * Constants keys for DB persists
     */
    const INFO = "info";
    const ALERT = "alert";

    /**
     * @var array
     *
     * String to display by cont key
     */
    private static $values = [
        self::INFO => "Information",
        self::ALERT => "Alerte"
    ];

    /**
     * Permit to get a value related to a key
     *
     * @param $type
     * @return mixed|string
     */
    public static function getValue($type){
        if(!isset(static::$values[$type])) return "Unknow notice type";
        else return static::$values[$type];
    }

    /**
     * Return the differents availables keys
     *
     * @return array
     */
    public static function getAvailableTypes(){
        return [
            self::INFO,
            self::ALERT
        ];
    }
}