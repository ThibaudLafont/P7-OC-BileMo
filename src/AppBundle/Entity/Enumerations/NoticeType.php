<?php
namespace AppBundle\Entity\Enumerations;

class NoticeType
{

    const INFO = "info";
    const ALERT = "alert";

    private static $values = [
        self::INFO => "Information",
        self::ALERT => "Alerte"
    ];

    public static function getValue($type){
        if(!isset(static::$values[$type])) return "Unknow notice type";
        else return static::$values[$type];
    }

    public static function getAvailableTypes(){
        return [
            self::INFO,
            self::ALERT
        ];
    }
}