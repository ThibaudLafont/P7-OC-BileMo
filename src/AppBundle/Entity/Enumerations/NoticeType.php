<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class NoticeType
 *
 * Define different types od ProductNotice
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
     * @param $key string
     *
     * @return mixed|string
     */
    public static function getValue(string $key) : string
    {
        if (!isset(static::$values[$key])) {
            return "Unknow notice type";
        } else {
            return static::$values[$key];
        }
    }

    /**
     * Return the differents availables keys
     *
     * @return array
     */
    public static function getAvailableTypes() : array
    {
        return [
            self::INFO,
            self::ALERT
        ];
    }
}
