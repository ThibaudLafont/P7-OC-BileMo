<?php
namespace AppBundle\Entity\Traits;

trait Hydrate
{
    public function hydrate($datas)
    {
        foreach($datas as $k => $v)
        {
            $setter = "set" . ucfirst($k);
            if(method_exists($this, $setter))
            {
                $this->$setter($v);
            }
        }
    }
}