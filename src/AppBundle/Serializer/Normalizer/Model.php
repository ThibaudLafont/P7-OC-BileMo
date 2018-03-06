<?php
namespace AppBundle\Serializer\Normalizer;

use AppBundle\Serializer\Normalizer\Traits\Normalizer;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;

/**
 * Class ModelNormalizer
 *
 * @package AppBundle\Serializer\Normalizer
 */
class Model implements NormalizerInterface, DenormalizerInterface, DenormalizerAwareInterface{

    // Traits
    use Normalizer;

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object Object to normalize
     * @param string $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|scalar
     *
     * @throws InvalidArgumentException   Occurs when the object given is not an attempted type for the normalizer
     * @throws CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws LogicException             Occurs when the normalizer is not called in an expected context
     */
    public function normalize($object, $format = null, array $context = array())
    {

        // Init empty array
        $return = [];

        // Case of collection request
        if($this->belongToSerializeGroup(['brand_show', 'family_show', 'model_list', 'model_products'], $context))
        {
            // Get collection array from object
            $return = $object->normalizeModelCollection(false, false, false);

        }
        // Case of item request
        elseif($this->belongToSerializeGroup(['model_show'], $context)){

            // Get model item infos
            $return = $object->normalizeModelItem(false, false, false);

        }

        // Case of model_products subresource
        if($this->belongToSerializeGroup(['model_products'], $context)){

            $return['products'] = $object->normalizeModelProducts();

        }

        // Set links and embedded
        $return['_links'] = $object->normalizeModelLinks();
        $return['_embedded'] = $object->normalizeModelEmbedded();

        // Return build array
        return $return;

    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof \AppBundle\Entity\Product\Model;
    }

    /**
     * Sets the owning Denormalizer object.
     *
     * @param DenormalizerInterface $denormalizer
     */
    public function setDenormalizer(DenormalizerInterface $denormalizer)
    {
        return;
    }

    /**
     * Denormalizes data back into an object of the given class.
     *
     * @param mixed $data Data to restore
     * @param string $class The expected class to instantiate
     * @param string $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     *
     * @return object
     *
     * @throws BadMethodCallException   Occurs when the normalizer is not called in an expected context
     * @throws InvalidArgumentException Occurs when the arguments are not coherent or not supported
     * @throws UnexpectedValueException Occurs when the item cannot be hydrated with the given data
     * @throws ExtraAttributesException Occurs when the item doesn't have attribute to receive given data
     * @throws LogicException           Occurs when the normalizer is not supposed to denormalize
     * @throws RuntimeException         Occurs if the class cannot be instantiated
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        return;
    }

    /**
     * Checks whether the given class is supported for denormalization by this normalizer.
     *
     * @param mixed $data Data to denormalize from
     * @param string $type The class to which the data should be denormalized
     * @param string $format The format being deserialized from
     *
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return;
    }

}
