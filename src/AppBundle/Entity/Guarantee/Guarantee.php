<?php
namespace AppBundle\Entity\Guarantee;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Guarantee
 *
 * Used for ProductGlobal and ProductSpecific
 *
 * @package AppBundle\Entity\Guarantee
 *
 * @ORM\MappedSuperclass()
 */
abstract class Guarantee
{

    /**
     * Primary Index of resource
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Does product feature is guaranteed
     *
     * @var bool
     *
     * @ORM\Column(name="guaranteed", type="boolean")
     */
    private $guaranteed;

    /**
     * Guarantee length in month
     *
     * @var float
     *
     * @ORM\Column(name="month_length", type="float")
     */
    private $lengthInMonth;

    /**
     * Information about guarantee
     *
     * @var String|null
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    // Traits
    use Hydrate;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get guaranteed
     *
     * @return bool
     */
    public function isGuaranteed() : bool
    {
        return $this->guaranteed;
    }

    /**
     * Set guaranteed
     *
     * @param bool $guaranteed
     *
     * @return Guarantee
     */
    public function setGuaranteed(bool $guaranteed) : Guarantee
    {
        $this->guaranteed = $guaranteed;

        return $this;
    }

    /**
     * Get lengthInMonth
     *
     * @return float
     */
    public function getLengthInMonth() : float
    {
        return $this->lengthInMonth;
    }

    /**
     * Set lengthInMonth
     *
     * @param $length
     *
     * @return Guarantee
     */
    public function setLengthInMonth($length) : Guarantee
    {
        $this->lengthInMonth = $length;

        return $this;
    }

    /**
     * Get message
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Guarantee
     */
    public function setMessage(string $message) : Guarantee
    {
        $this->message = $message;

        return $this;
    }
}
