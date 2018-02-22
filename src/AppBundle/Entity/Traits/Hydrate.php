<?php
namespace AppBundle\Entity\Traits;

/**
 * Trait Hydrate
 * Parse index and call setter of the class if exists
 *
 * @package AppBundle\Entity\Traits
 */
trait Hydrate
{
    /**
     * Hydrate an entity from array
     *
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach($data as $k => $v)
        {
            $setter = "set" . ucfirst($k);
            if(method_exists($this, $setter))
            {
                $this->$setter($v);
            }
        }
    }

}