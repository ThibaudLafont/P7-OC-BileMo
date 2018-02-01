<?php
namespace AppBundle\Entity\Guarantee;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Guarantee
 * @package AppBundle\Entity\Guarantee
 *
 * @ORM\MappedSuperclass()
 */
abstract class Guarantee
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var bool
     *
     * @ORM\Column(name="guaranteed", type="boolean")
     */
    private $guaranteed;

    /**
     * @var float
     *
     * @ORM\Column(name="month_length", type="float")
     */
    private $lengthInMonth;
    /**
     * @var String|null
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function isGuaranteed() : bool
    {
        return $this->guaranteed;
    }
    public function setGuaranteed(bool $guaranteed){
        $this->guaranteed = $guaranteed;
    }

    public function setLengthInMonth($length)
    {
        $this->lengthInMonth = $length;
    }
    public function getLengthInMonth()
    {
        return $this->lengthInMonth;
    }

    public function getMessage()
    {
        return $this->string;
    }
    public function setMessage(string $message)
    {
        $this->message = $message;
    }
}