<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class ProductFormatStatus
 *
 * Say if product is formatted or not or unknow
 *
 * @package AppBundle\Entity\Enumerations
 */
class ProductFormatStatus
{

    /**
     * Constants keys for DB persists
     */
    const FORMATTED = "formatted";
    const NOT_FORMATTED = "not_formatted";
    const UNKNOW = "unknow";

    /**
     * String to display by cont key
     *
     * @var array
     */
    private static $values = [
        self::FORMATTED => "Réinitialisé",
        self::NOT_FORMATTED => "Non réinitialisé",
        self::UNKNOW => "Inconnu"
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
            self::FORMATTED,
            self::NOT_FORMATTED,
            self::UNKNOW
        ];
    }
}
