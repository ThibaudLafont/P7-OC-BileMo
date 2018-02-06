<?php
namespace AppBundle\Entity\Enumerations;

class ProductFormatStatus
{
    const FORMATTED = "formatted";
    const NOT_FORMATTED = "not_formatted";
    const UNKNOW = "unknow";

    private static $values = [
        self::FORMATTED => "Réinitialisé",
        self::NOT_FORMATTED => "Non réinitialisé",
        self::UNKNOW => "Non renseigné"
    ];

    public static function getValue($type)
    {
        if(!isset(static::$values[$type])) return "Unknow format status";
        else return static::$values[$type];
    }

    public static function getAvailableTypes(){
        return [
            self::FORMATTED,
            self::NOT_FORMATTED,
            self::UNKNOW
        ];
    }
}