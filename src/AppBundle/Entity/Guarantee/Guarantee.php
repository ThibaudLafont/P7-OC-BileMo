<?php
namespace AppBundle\Entity\Guarantee;

use AppBundle\Entity\Traits\Hydrate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Guarantee
 * @package AppBundle\Entity\Guarantee
 *
 * @ORM\MappedSuperclass()
 */
abstract class Guarantee
{

    /**
     * Primary Index
     * @var int
     *
     * Doctrine
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Does product feature is guaranteed
     * @var bool
     *
     * Doctrine
     * @ORM\Column(name="guaranteed", type="boolean")
     *
     * Serialization
     * @Groups({"product_show"})
     */
    private $guaranteed;

    /**
     * Guarantee length in month
     * @var float
     *
     * Doctrine
     * @ORM\Column(name="month_length", type="float")
     *
     * Serialization
     * @Groups({"product_show"})
     */
    private $lengthInMonth;

    /**
     * Inform message
     * @var String|null
     *
     * Doctrine
     * @ORM\Column(name="message", type="text", nullable=true)
     *
     * Serialization
     * @Groups({"product_show"})
     */
    private $message;

    // Traits
    use Hydrate;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
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
     */
    public function setGuaranteed(bool $guaranteed){
        $this->guaranteed = $guaranteed;
    }

    /**
     * Get lengthInMonth
     *
     * @return float
     */
    public function getLengthInMonth()
    {
        return $this->lengthInMonth;
    }

    /**
     * Set lengthInMonth
     *
     * @param $length
     */
    public function setLengthInMonth($length)
    {
        $this->lengthInMonth = $length;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }
}