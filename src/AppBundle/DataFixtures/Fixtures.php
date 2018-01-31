<?php
namespace AppBundle\DataFixtures;


use AppBundle\Entity\Feature\Feature;
use AppBundle\Entity\Feature\ModelFeature;
use AppBundle\Entity\Feature\Spec;
use AppBundle\Entity\Feature\SpecValue;
use AppBundle\Entity\Product\Brand;
use AppBundle\Entity\Product\Family;
use AppBundle\Entity\Product\Model;
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
        $models = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Models/Apple.yaml'));

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
}