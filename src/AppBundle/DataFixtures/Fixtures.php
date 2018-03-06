<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Feature\Feature;
use AppBundle\Entity\Feature\ModelFeature;
use AppBundle\Entity\Feature\ProductTest;
use AppBundle\Entity\Feature\Spec;
use AppBundle\Entity\Feature\SpecValue;
use AppBundle\Entity\Feature\Test;
use AppBundle\Entity\Guarantee\ProductGlobal;
use AppBundle\Entity\Guarantee\ProductSpecific;
use AppBundle\Entity\Product\Brand;
use AppBundle\Entity\Product\Family;
use AppBundle\Entity\Product\Model;
use AppBundle\Entity\Product\Notice;
use AppBundle\Entity\Product\Product;
use AppBundle\Entity\User\Client;
use AppBundle\Entity\User\Company;
use AppBundle\Entity\User\Partner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

/**
 * Class for Fixtures
 *
 * This class parse YAML and treats datas in order to persist objects in DB
 *
 * @package AppBundle\DataFixtures
 */
class Fixtures extends Fixture
{

    /**
     * Load data fixtures by calling load methods
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $this->loadBrands($manager);
        $this->loadFamilies($manager);
        $this->loadModels($manager);
        $this->loadProducts($manager);
        $this->loadUsers($manager);
    }

    /**
     * Parse and process YAML file to persist phone brands
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    private function loadBrands(ObjectManager $manager)
    {
        // First get and parse the yaml file
        $brands = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Brand.yaml'));

        // Loop on every index found
        foreach($brands as $k => $v)
        {

            // Create new Brand object
            $brand = new Brand();
            // Hydrate object with founded datas
            $brand->setName($k);
            $brand->hydrate($v);
            // Then persist the build entity
            $manager->persist($brand);

        }

        $manager->flush();

    }
  
    /**
     * Parse and process YAML file for Families persist
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    private function loadFamilies(ObjectManager $manager)
    {

        // First get and parse the yaml file
        $families = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Family.yaml'));

        // Loop on every family
        foreach($families as $k => $v)
        {
            // With brand_name, find the object in DB
            $brand = $manager->getRepository('AppBundle:Product\Brand')->findOneBy(['name' => $v['brand']]);

            // Create and hydrate a new Family Object
            $family = new Family();
            $family->setName($k);
            $family->setDescription($v['description']);
            $family->setBrand($brand);
            // Persist build object
            $manager->persist($family);
        }

        // When loop is done, flush datasr
        $manager->flush();

    }

    /**
     * Parse and process YAML file for Families persist
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    private function loadModels(ObjectManager $manager)
    {

        // First get and parse the yaml file
        $models = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Models.yaml'));

        // Loop en every entry of yaml
        foreach($models as $k => $v){

            // Get family object in DB from given name
            $family = $manager->getRepository('AppBundle:Product\Family')
                ->findOneBy(['name' => $v['family_name']]);

            // Create new model object and hydrate
            $model = new Model();
            $model->setName($k);
            $model->setFamily($family);
            $model->hydrate($v);

            // Loop on every feature given for this model
            foreach($v['features'] as $fk => $fv)
            {
                // Check if feature is already in DDB
                $feature = $manager->getRepository('AppBundle:Feature\Feature')
                    ->findOneBy(['name' => $fk]);

                // If not knowed, create and persist it
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
                    $spec = $manager->getRepository('AppBundle:Feature\Spec')
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

                    // Finally persist the spec value
                    $manager->persist($specValue);
                }
            }

            // One features and specs are stored, persist the model
            $manager->persist($model);

            $manager->flush();
        }

    }

    /**
     * Parse Yaml and perform Product persist
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    private function loadProducts(ObjectManager $manager)
    {
        // First get and parse the yaml file
        $products = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Products.yaml'));

        // Loop on every index
        foreach($products as $k => $v)
        {

            // Find the Model Object from given name
            $model = $manager->getRepository('AppBundle:Product\Model')
                ->findOneBy(['name' => $v['model_name']]);

            // Create a new product and assign first datas
            $product = new Product();
            $product->setTitle($k);
            $product->setModel($model);
            $product->hydrate($v);

            // If Notices are given, loop assign and persist them
            if(isset($v['notices']))
            {
                foreach($v['notices'] as $nk => $nv)
                {
                    // Create, hydrate and persist new Notice Object
                    $notice = new Notice();
                    $notice->setType($nk);
                    $notice->setProduct($product);
                    $notice->setMessage($nv);
                    $manager->persist($notice);
                }
            }

            // If Guarantees are given, loop assign and persist them
            if(isset($v['guarantees']))
            {
                foreach($v['guarantees'] as $gk => $gv)
                {
                    // Check if guarantee is link to product or feature
                    if($gk === 'global'){
                        // If ProductGuarantee, create new Object
                        $guarantee = new ProductGlobal();
                    }else{
                        // If FeatureGuarantee, first find related feature
                        $feature = $manager->getRepository('AppBundle:Feature\Feature')
                            ->findOneBy(['name' => $gk]);
                        // Then create & hydrate ProductSpecific Object
                        $guarantee = new ProductSpecific();
                        $guarantee->setFeature($feature);
                        $guarantee->setProduct($product);
                    }

                    // Then hydrate guarantee whatever it's type
                    $guarantee->hydrate($gv);

                    // If is GlobalGuarantee, link product to it
                    if($gk === 'global'){
                        $product->setGlobalGuarantee($guarantee);
                    }

                    // Persist the guarantee
                    $manager->persist($guarantee);
                }
            }

            // Persist product at end of loop
            $manager->persist($product);
        }

        // Flush all persisted datas
        $manager->flush();
    }

    /**
     * Parse Yaml and perform Users persist
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    private function loadUsers(ObjectManager $manager){

        // First get and parse the yaml file, only contain clients users
        $companies = Yaml::parse(file_get_contents(__DIR__ . '/datas/yml/Clients.yaml'));

        // Foreach company found, loop
        foreach($companies as $name => $workers)
        {
            // Create object and assign name
            $company = new Company();
            $company->setName($name);

            // Persist object in DB for Client assignation
            $manager->persist($company);

            // Foreach workers found, loop
            foreach($workers as $k => $v)
            {
                // Create and hydrate new Client object
                $user = new Client();
                $user->setCompany($company);
                $user->setUsername($k);
                $user->setPwd($k);
                $user->hydrate($v);

                // Persist it in DB
                $manager->persist($user);
            }
        }

        // Now create Partner users
        foreach(['jean', 'murielle', 'thib'] as $admin){
            // Create and hydrate new Partner object
            $user = new Partner();
            $user->setUsername($admin);
            $user->setPwd($admin);

            // Persist Partner in DB
            $manager->persist($user);
        }

        // Flush all changes
        $manager->flush();

    }
}