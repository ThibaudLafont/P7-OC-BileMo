<?php
namespace AppBundle\Entity\Enumerations;

/**
 * Class ProductCondition
 *
 * Define different sell status for Product
 *
 * @package AppBundle\Entity\Enumerations
 */
class SellState
{

    /**
     * Constants keys for DB persists
     */
    const NEW = "new";
    const REFURB = "refurb";
    const USED = "used";
    const DEFECTIVE = "defective";

    /**
     * @var array
     *
     * String to display by cont key
     */
    private static $values = [
        self::NEW => "Neuf",
        self::REFURB => "Reconditionné",
        self::USED => "Occasion",
        self::DEFECTIVE => "Défectueux"
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
            self::NEW,
            self::REFURB,
            self::USED,
            self::DEFECTIVE
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getValues(): array
    {
        return self::$values;
    }
}
