<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class ProductState
 *
 * Define different physic states for Product
 *
 * @package AppBundle\Entity\Enumerations
 */
class PhysicState
{

    /**
     * Constants keys for DB persists
     */
    const UNUSED = "unused";
    const LIKE_NEW = "like_new";
    const GOOD = "good";
    const AVERAGE = "average";
    const BAD = "bad";

    /**
     * String to display by cont key
     *
     * @var array
     */
    private static $values = [
        self::UNUSED => "Jamais utilisé",
        self::LIKE_NEW => "Comme neuf",
        self::GOOD => "Bon",
        self::AVERAGE => "Moyen",
        self::BAD => "Mauvais"
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
            self::UNUSED,
            self::LIKE_NEW,
            self::GOOD,
            self::AVERAGE,
            self::BAD
        ];
    }

}
