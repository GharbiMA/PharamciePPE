<?php 
use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager;

class Doctrine
{

    public $em;

    public function __construct()
    {
        require_once __DIR__ . '/Doctrine/ORM/Tools/Setup.php';
        Setup::registerAutoloadDirectory(__DIR__);
        
        // Load the database configuration from CodeIgniter
        require APPPATH . 'config/database.php';
        require_once APPPATH.'libraries/Doctrine/Common/ClassLoader.php';

        $connection_options = array(
            'driver'        => 'pdo_mysql',
            'user'          => $db['default']['username'],
            'password'      => $db['default']['password'],
            'host'          => $db['default']['hostname'],
            'dbname'        => $db['default']['database'],
            'charset'       => $db['default']['char_set'],
            'driverOptions' => array(
                'charset'   => $db['default']['char_set'],
            ),
        );

        // With this configuration, your model files need to be in application/models/Entity
        // e.g. Creating a new Entity\User loads the class from application/models/Entity/User.php
        $models_namespace = 'Entity';
        $models_path = APPPATH . 'models';
        $proxies_dir = APPPATH . 'models/Proxies';
        $metadata_paths = array(APPPATH . 'models/Entity');
        //$Driver = new \Doctrine\ORM\Mapping\Driver\YamlDriver(APPPATH.'models/Mappings');§
        //$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver("sim")
        //$config->setMetadataDriverImpl($yamlDriver);

        // Set $dev_mode to TRUE to disable caching while you develop
        $config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode = true, $proxies_dir, null,true);
        $this->em = EntityManager::create($connection_options, $config);

        $loader = new ClassLoader($models_namespace, $models_path);
        $loader->register();
    }

}




///********************************

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
class Doctrine
{
    // the Doctrine entity manager
    public $em = null;

    public function __construct()
    {
        // include our CodeIgniter application's database configuration
        require_once APPPATH.'config/database.php';
        
        // include Doctrine's fancy ClassLoader class
        require_once APPPATH.'libraries/Doctrine/Common/ClassLoader.php';

        // load the Doctrine classes
        $doctrineClassLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPPATH.'libraries');
        $doctrineClassLoader->register();
        
        // load Symfony2 helpers
        // Don't be alarmed, this is necessary for YAML mapping files
        $symfonyClassLoader = new \Doctrine\Common\ClassLoader('Symfony', APPPATH.'libraries/Doctrine');
        $symfonyClassLoader->register();

        // load the entities
        $entityClassLoader = new \Doctrine\Common\ClassLoader('Entities', APPPATH.'models');
        $entityClassLoader->register();

        // load the proxy entities
        $proxyClassLoader = new \Doctrine\Common\ClassLoader('Proxies', APPPATH.'models');
        $proxyClassLoader->register();

        // set up the configuration 
        $config = new \Doctrine\ORM\Configuration;
    
        if(ENVIRONMENT == 'development')
            // set up simple array caching for development mode
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        else
            // set up caching with APC for production mode
            $cache = new \Doctrine\Common\Cache\ApcCache;
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        // set up proxy configuration
        $config->setProxyDir(APPPATH.'models/Proxies');
        $config->setProxyNamespace('Proxies');
        
        // auto-generate proxy classes if we are in development mode
        $config->setAutoGenerateProxyClasses(ENVIRONMENT == 'development');

        // set up annotation driver
        //$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver();
        //driver = $config->newDefaultAnnotationDriver('application/models/Entity');
        //$driver =  \Doctrine\ORM\Mapping\Driver\AnnotationDriver::create();
        //$config->setMetadataDriverImpl($driver);                
        
        //config->setMetadataDriverImpl($yamlDriver);
        // Database connection information
        $connectionOptions = array(
            'driver' => 'pdo_mysql',
            'user' => $db['default']['username'],
            'password' => $db['default']['password'],
            'host' => $db['default']['hostname'],
            'dbname' => $db['default']['database']
        );
        
        //$paths = array("application/models/Entity");
//        $isDevMode = TRUE;
//        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
//        $em = EntityManager::create($connectionOptions, $config);

        // create the EntityManager
        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
        $driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver('applicaion/models/Entity');
        $em->getConfiguration()->setMetadataDriverImpl($driver);
        // store it as a member, for use in our CodeIgniter controllers.
        $this->em = $em;
    }
}


