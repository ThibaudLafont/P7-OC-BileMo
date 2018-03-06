<?php
namespace AppBundle\Serializer\Normalizer\Traits;

/**
 * Trait Normalizer
 *
 * Define belongToSerializeGroups
 *
 * @package AppBundle\Serializer\Normalizer\Traits
 */
trait Normalizer
{

    /**
     * Return true if serialization request belong to specified $groups
     *
     * @param $groups array Groups you want to check
     * @param $context array Context of normalization
     *
     * @return bool
     */
    private function belongToSerializeGroup(array $groups, $context)
    {
        $return = false;

        foreach ($groups as $group) {
            if (in_array($group, $context['groups'])) {
                $return = true;
            }
        }

        return $return;
    }
}
