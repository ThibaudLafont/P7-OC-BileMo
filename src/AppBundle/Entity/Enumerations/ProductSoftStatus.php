<?php
namespace AppBundle\Entity\Enumerations;
/**
 * Class ProductSoftStatus
 * Define different software status for Product
 *
 * @package AppBundle\Entity\Enumerations
 */
class ProductSoftStatus
{

    /**
     * Constants keys for DB persists
     */
    const BOOT_PROPERLY = "boot_properly";
    const SOFT_DEFECT = "soft_defect";
    const SOFT_BRICK = "soft_brick";
    const UNKNOW = "unknow";

    /**
     * @var array
     *
     * String to display by cont key
     */
    private static $values = [
        self::BOOT_PROPERLY => "Démarre normalement",
        self::SOFT_DEFECT => "Problème soft",
        self::SOFT_BRICK => "Brick logiciel - Ne démarre pas",
        self::UNKNOW => "Non testé / Inconnu"
    ];

    /**
     * Permit to get a value related to a key
     *
     * @param $type
     * @return mixed|string
     */
    public static function getValue($type)
    {
        if(!isset(static::$values[$type])) return "Unknow soft status";
        else return static::$values[$type];
    }

    /**
     * Return the differents availables keys
     *
     * @return array
     */
    public static function getAvailableTypes(){
        return [
            self::BOOT_PROPERLY,
            self::SOFT_DEFECT,
            self::SOFT_BRICK,
            self::UNKNOW
        ];
    }
}