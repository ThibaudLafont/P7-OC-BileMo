<?php
namespace AppBundle\Entity\Enumerations;

class ProductSoftStatus
{
    const BOOT_PROPERLY = "boot_properly";
    const SOFT_DEFECT = "soft_defect";
    const SOFT_BRICK = "soft_brick";
    const UNKNOW = "unknow";

    private static $values = [
        self::BOOT_PROPERLY => "Démarre normalement",
        self::SOFT_DEFECT => "Problème soft",
        self::SOFT_BRICK => "Brick logiciel - Ne démarre pas",
        self::UNKNOW => "Non testé / Inconnu"
    ];

    public static function getValue($type)
    {
        if(!isset(static::$values[$type])) return "Unknow soft status";
        else return static::$values[$type];
    }

    public static function getAvailableTypes(){
        return [
            self::BOOT_PROPERLY,
            self::SOFT_DEFECT,
            self::SOFT_BRICK,
            self::UNKNOW
        ];
    }
}