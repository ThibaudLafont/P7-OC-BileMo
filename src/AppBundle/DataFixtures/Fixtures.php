<?php
namespace AppBundle\DataFixtures;


use AppBundle\Entity\Feature\Feature;
use AppBundle\Entity\Feature\ModelFeature;
use AppBundle\Entity\Feature\ProductTest;
use AppBundle\Entity\Feature\Spec;
use AppBundle\Entity\Feature\SpecValue;
use AppBundle\Entity\Guarantee\ProductSpecific;
use AppBundle\Entity\Product\Brand;
use AppBundle\Entity\Product\Family;
use AppBundle\Entity\Product\Model;
use AppBundle\Entity\Product\Notice;
use AppBundle\Entity\Product\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class Fixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadBrands($manager);
        $this->loadFamilies($manager);
        $this->loadModels($manager);
        $this->loadProducts($manager);
    }

    public function loadBrands(ObjectManager $manager)
    {
        // First get and parse the yaml file
        $brands = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Brand.yaml'));
        foreach($brands as $k => $v)
        {
            $brand = new Brand();
            $brand->setName($k);
            $brand->setDescription($v['description']);
            $brand->setWebsiteUrl($v['website_url']);
            $manager->persist($brand);
        }

        $manager->flush();

    }

    public function loadFamilies(ObjectManager $manager)
    {

        // First get and parse the yaml file
        $families = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Family.yaml'));
        foreach($families as $k => $v)
        {
            $brand = $manager->getRepository('AppBundle:Product\Brand')->findOneBy(['name' => $v['brand']]);
            $family = new Family();
            $family->setName($k);
            $family->setDescription($v['description']);
            $family->setBrand($brand);

            $manager->persist($family);
        }

        $manager->flush();

    }

    public function loadModels(ObjectManager $manager)
    {

        // First get and parse the yaml file
        $models = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Models.yaml'));


        foreach($models as $k => $v)
        {
            // Get family if exists, and brand of model
            if($v['family'] !== null)
            {
                $family = $manager->getRepository('AppBundle:Product\Family')
                    ->findOneBy(['name' => $v['family']]);
                $brand = $family->getBrand();
            }else{
                $family = $v['family'];
                $brand =  $manager->getRepository('AppBundle:Product\Brand')
                    ->findOneBy(['name' => $v['brand']]);
            }

            $model = new Model();
            $model->setName($k);
            $model->setBrand($brand);
            $model->setFamily($family);
            $model->setDescription($v['description']);
            $model->setConstructorUrl($v['constructor_page']);
            $model->setReleaseYear($v['release_year']);

            foreach($v['features'] as $fk => $fv)
            {
                // Check if feature is in DDB
                $feature = $manager->getRepository('AppBundle:Feature\Feature')
                    ->findOneBy(['name' => $fk]);

                // If not create and persist it
                if(is_null($feature))
                {
                    $feature = new Feature();
                    $feature->setName($fk);

                    $manager->persist($feature);
                }

                // Loop on feature specifications
                foreach($fv as $fsk => $fsv)
                {
                    // Check if spec exists in DDB
                    $spec = $manager->getRepository('AppBundle:Feature\Feature')
                        ->findOneBy(['name' => $fsk]);

                    // If not, create and persist
                    if(is_null($spec)){
                        $spec = new Spec();
                        $spec->setName($fsk);
                        $spec->setFeature($feature);

                        $manager->persist($spec);
                    }

                    // With every spec, set&link model value
                    $specValue = new SpecValue();
                    $specValue->setSpec($spec);
                    $specValue->setModel($model);
                    $specValue->setValue($fsv);

                    $manager->persist($specValue);
                }
            }
            $manager->persist($model);

            $manager->flush();
        }

    }

    public function loadProducts(ObjectManager $manager)
    {
        // First get and parse the yaml file
        $products = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Products.yaml'));

        foreach($products as $k => $v)
        {
            $model = $manager->getRepository('AppBundle:Product\Model')
                ->findOneBy(['name' => $v['model']]);

            $product = new Product();
            $product->setName($k);
            $product->setModel($model);
            $product->setDescription($v['description']);
            $product->setPrice($v['price']);
            $product->setCondition($v['condition']);
            $product->setState($v['state']);
            $product->setHistory($v['history']);
            $product->setAvailable($v['available']);
            $product->setImei($v['IMEI']);
            $product->setMemorySizeInGb($v['memorySize']);
            $product->setColor($v['color']);
            $product->setOperatorLock($v['operatorLock']);
            $product->setSystemVersion($v['systemVersion']);
            $product->setFormatted($v['formatted']);
            $product->setBootProperly($v['bootProperly']);

            if(isset($v['notices']))
            {
                foreach($v['notices'] as $nk => $nv)
                {
                    $notice = new Notice();
                    $notice->setType($nk);
                    $notice->setProduct($product);
                    $notice->setContent($nv);

                    $manager->persist($notice);
                }
            }

            if(isset($v['tests']))
            {
                foreach($v['tests'] as $tk => $tv)
                {
                    // Get related feature in DB
                    $feature = $manager->getRepository('AppBundle:Feature\Feature')
                        ->findOneBy(['name' => $tk]);

                    $test = new ProductTest();
                    $test->setMessage($tv['message']);
                    $test->setIsWorking($tv['isWorking']);
                    $test->setPhyDamage($tv['phyDamage']);
                    $test->setProduct($product);
                    $test->setFeature($feature);

                    $manager->persist($test);
                }
            }

            if(isset($v['guarantees']))
            {
                foreach($v['guarantees'] as $gk => $gv)
                {
                    $feature = $manager->getRepository('AppBundle:Feature\Feature')
                        ->findOneBy(['name' => $gk]);

                    $guarantee = new ProductSpecific();
                    $guarantee->setFeature($feature);
                    $guarantee->setProduct($product);
                    $guarantee->setGuaranteed($gv['isGuaranteed']);
                    $guarantee->setLengthInMonth($gv['lengthInMonth']);
                    $guarantee->setMessage($gv['message']);

                    $manager->persist($guarantee);
                }
            }

            $manager->persist($product);
        }

        $manager->flush();
    }
}