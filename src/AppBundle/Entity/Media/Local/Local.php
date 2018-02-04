<?php

namespace AppBundle\Entity\Media\Local;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Media\File;

/**
 * Local
 *
 * @ORM\MappedSuperclass()
 */
abstract class Local extends File
{
    /**
     * @var string
     *
     * @ORM\Column(name="slug_name", type="string", length=255)
     */
    private $slugName;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=6)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * Set slugName.
     *
     * @param string $slugName
     *
     * @return Local
     */
    public function setSlugName($slugName)
    {
        $this->slugName = $slugName;

        return $this;
    }

    /**
     * Get slugName.
     *
     * @return string
     */
    public function getSlugName()
    {
        return $this->slugName;
    }

    /**
     * Set extension.
     *
     * @param string $extension
     *
     * @return Local
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return Local
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
