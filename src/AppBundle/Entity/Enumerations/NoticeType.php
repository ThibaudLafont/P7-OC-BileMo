<?php
namespace AppBundle\Entity\Enumerations;

class NoticeType
{

    const INFO = "info";
    const ALERT = "alert";

    private static $noticeValue = [
        self::INFO => "Information",
        self::ALERT => "Alerte"
    ];

    public static function getValue($noticeType){
        if(!isset(static::$noticeValue[$noticeType])) return "Unknow notice type";
        else return static::$noticeValue[$noticeType];
    }

    public static function getAvailableTypes(){
        return [
            self::INFO,
            self::ALERT
        ];
    }
}