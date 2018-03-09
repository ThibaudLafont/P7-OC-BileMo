<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class ProductSoftStatus
 *
 * Define different software status for Product
 *
 * @package AppBundle\Entity\Enumerations
 */
class ProductSoftStatus
{

    /**
     * Constants keys for DB persists
     */
    const BOOT_PROPERLY = "boot_properly";
    const SOFT_DEFECT = "soft_defect";
    const SOFT_BRICK = "soft_brick";
    const UNKNOW = "unknow";

    /**
     * String to display by cont key
     *
     * @var array
     */
    private static $values = [
        self::BOOT_PROPERLY => "Démarre normalement",
        self::SOFT_DEFECT => "Problème soft",
        self::SOFT_BRICK => "Brick logiciel - Ne démarre pas",
        self::UNKNOW => "Non testé / Inconnu"
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
            self::BOOT_PROPERLY,
            self::SOFT_DEFECT,
            self::SOFT_BRICK,
            self::UNKNOW
        ];
    }

}
