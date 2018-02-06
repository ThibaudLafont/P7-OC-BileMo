<?php
namespace AppBundle\Serializer\Normalizer;

use AppBundle\Entity\Guarantee\ProductGlobal;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\scalar;

class Product implements NormalizerInterface{

    /**
     * Product Instance witch call the normalizer
     *
     * @var \AppBundle\Entity\Product\Product
     */
    private $product;

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
        // Store Product instance
        $this->setProduct($object);

        // Init $product
        $product = [];

        // Get Product Properties though Normalizer subMethods
        $product['sell_infos'] = $this->productInfos();
        $product['state'] = $this->productState();
        $product['specifications'] = $this->productSpecs();

        // Check if product has notices, store them if it does
        if($this->shouldDisplayNotices())
            $product['state']['notices'] = $this->productNotices();

        // Check if product has a global guarantee, store it if it does
        if($this->shouldDisplayGlobalGuarantee())
            $product['guarantee']['global'] = $this->productGlobalGuarantee();
        // Check if product has a specific guarantees, store them if it does
        if($this->shouldDisplaySpecificGuarantees())
            $product['guarantee']['specific'] = $this->productSpecificGuarantees();

        // Return dynamic build array
        return $product;
    }

    public function productInfos(){
        $product = $this->getProduct();
        return [
            'title' => $product->getTitle(),
            'sellState' => $product->getState(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'available' => $product->getAvailable()
        ];
    }

    public function productState(){
        $product = $this->getProduct();
        return [
            'physicState' => $product->getCondition(),
            'boot_properly' => $product->getBootProperly(),
            'is_formatted' => $product->getFormatted(),
            'history' => $product->getHistory()
        ];
    }

    public function productSpecs(){
        $product = $this->getProduct();
        return [
            'imei' => $product->getImei(),
            'color' => $product->getColor(),
            'memory_size' => $product->getMemorySizeInGb(),
            'system_version' => $product->getSystemVersion()
        ];
    }

    public function shouldDisplayNotices()
    {
        return $this->getProduct()
            ->getNotices()->count() !== 0;
    }

    public function productNotices()
    {
        $return = [];
        foreach($this->getProduct()->getNotices() as $v)
        {
            $return[] = [
                'type' => $v->getType(),
                'content' => $v->getContent()
            ];
        }

        return $return;
    }

    public function shouldDisplayGlobalGuarantee(){
        return $this->getProduct()->getGlobalGuarantee() !== null;
    }

    public function productGlobalGuarantee()
    {
        $guar = $this->getProduct()->getGlobalGuarantee();

        return [
            'is_guaranteed' => $guar->isGuaranteed(),
            'guarantee_length' => $guar->getLengthInMonth(),
            'message' => $guar->getMessage()
        ];
    }

    public function shouldDisplaySpecificGuarantees(){
        return $this->getProduct()->getSpecificGuarantees()->count() !== 0;
    }

    public function productSpecificGuarantees(){
        $guars = $this->getProduct()->getSpecificGuarantees();
        $return = [];
        foreach($guars as $guar){
            $return[] = [
                'concern' => $guar->getFeature()->getName(),
                'is_guaranteed' => $guar->isGuaranteed(),
                'guarantee_length' => $guar->getLengthInMonth(),
                'message' => $guar->getMessage()
            ];
        }

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
        return $data instanceof \AppBundle\Entity\Product\Product;
    }

    /**
     * @return \AppBundle\Entity\Product\Product
     */
    public function getProduct(): \AppBundle\Entity\Product\Product
    {
        return $this->product;
    }

    /**
     * @param \AppBundle\Entity\Product\Product $product
     */
    public function setProduct(\AppBundle\Entity\Product\Product $product)
    {
        $this->product = $product;
    }

}