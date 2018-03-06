<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class ProductCondition
 *
 * Define different sell status for Product
 *
 * @package AppBundle\Entity\Enumerations
 */
class ProductCondition
{

    /**
     * Constants keys for DB persists
     */
    const NEW = "new";
    const REFURB = "refurb";
    const USED = "used";
    const DEFECTIVE = "defective";

    /**
     * @var array
     *
     * String to display by cont key
     */
    private static $values = [
        self::NEW => "Neuf",
        self::REFURB => "Reconditionné",
        self::USED => "Occasion",
        self::DEFECTIVE => "Défectueux"
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
        if (!isset(static::$values[$key])) {
            return "Unknow condition";
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
            self::NEW,
            self::REFURB,
            self::USED,
            self::DEFECTIVE
        ];
    }
}
