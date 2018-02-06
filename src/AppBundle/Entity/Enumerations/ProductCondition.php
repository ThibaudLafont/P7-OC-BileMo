<?php
namespace AppBundle\Entity\Enumerations;

class ProductCondition
{
    const NEW = "new";
    const REFURB = "refurb";
    const USED = "used";
    const DEFECTIVE = "defective";

    private static $conditionValue = [
        self::NEW => "Neuf",
        self::REFURB => "Reconditionné",
        self::USED => "Occasion",
        self::DEFECTIVE => "Défectueux"
    ];

    public static function getValue($conditionType)
    {
        if(!isset(static::$conditionValue[$conditionType])) return "Unknow condition";
        else return static::$conditionValue[$conditionType];
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