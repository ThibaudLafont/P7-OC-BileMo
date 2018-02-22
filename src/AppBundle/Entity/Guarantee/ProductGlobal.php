<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 1/28/18
 * Time: 7:54 PM
 */

namespace AppBundle\Entity\Guarantee;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class ProductGlobal
 *
 * @ORM\Entity()
 * @ORM\Table(name="p_global_guarantee")
 */
class ProductGlobal extends Guarantee
{
}
