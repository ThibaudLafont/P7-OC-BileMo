<?php
namespace AppBundle\Entity\Service;

trait hydrate
{
	public function hydrate(array $datas)
	{
		foreach ($datas as $k => $v) {
			$setter = 'get' . ucfirst($k);
			if(method_exists($this, $setter))
			{
				$this->setter($v);
			}
		}
	}
}