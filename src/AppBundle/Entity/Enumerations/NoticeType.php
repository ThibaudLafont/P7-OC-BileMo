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

    // Traits
    use Traits\Enumeration;

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
