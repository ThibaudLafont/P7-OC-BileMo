<?php
namespace AppBundle\Entity\Enumerations;

class ProductCondition
{
    const NEW = "new";
    const REFURB = "refurb";
    const USED = "used";
    const DEFECTIVE = "defective";

    private static $values = [
        self::NEW => "Neuf",
        self::REFURB => "Reconditionné",
        self::USED => "Occasion",
        self::DEFECTIVE => "Défectueux"
    ];

    public static function getValue($conditionType)
    {
        if(!isset(static::$values[$conditionType])) return "Unknow condition";
        else return static::$values[$conditionType];
    }

    public static function getAvailableTypes(){
        return [
            self::NEW,
            self::REFURB,
            self::USED,
            self::DEFECTIVE
        ];
    }
}