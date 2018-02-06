<?php
namespace AppBundle\Entity\Enumerations;

class ProductState
{
    const UNUSED = "unused";
    const LIKE_NEW = "like_new";
    const GOOD = "good";
    const AVERAGE = "average";
    const BAD = "bad";

    private static $values = [
        self::UNUSED => "Jamais utilisé",
        self::LIKE_NEW => "Comme neuf",
        self::GOOD => "Bon",
        self::AVERAGE => "Moyen",
        self::BAD => "Mauvais"
    ];

    public static function getValue($stateType){
        if(!isset(static::$values[$stateType])) return "Unknow state type";
        else return static::$values[$stateType];
    }

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