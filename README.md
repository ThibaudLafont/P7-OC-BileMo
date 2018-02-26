# Bilemo API
This project will create an API for Bilemo company. Clients of Bilemo will be able to 
list smartphones products and Bilemo partners will be able to add/edit/delete/list API
users


## Informations
This project use ApiPlatform bundle with Symfony framework. 

### Object model
You can find the object model in this repository

    /assets/ddb_diagramm.png

### Serialization of resources
ApiPlatform handle the serialization of resources process, though a configuration 
witch is explained here.
#### Routing
Resources routes are defined and configured in :
    
    /app/config/api_platform/resources/
    
Some specials roads are also build in :
    
    /src/AppBundle/Action/
    
#### Serialization groups
Serialization groups are defined though YAML configuration, find them here :

    /app/config/api_platform/serialization/
    
#### Normalization
A custom normalizer have been created foreach resource. You can find them in 
    
    /src/AppBundle/Serializer/Normalizer/
    
### Resource Models
Resource models are used for swagger documentation, though `@ApiProperty` in each
Entity object

### Authentication
The provider was settled up though DoctrineUserProvider. The main class is 
`AppBundle\Entity\User\User`, Partner and Client extend of it.    
The project use JWT for authentication, witch create a token used for 
authenticate http requests before delivering resources.   
Always thanks to Doctrine a authorization had been settled with two types of
users : clients and coworkers of Bilemo.   
Users passwords are bcrypt crypted in DB.

## Installation
### Summary
  - Install and configure the project  
  - Load a dataset with DoctrineFixtures
  - Switch in production 
  - opt: Varnish implement
    
#### Install and configure the project
The PHP version need to bee > 7 cause of usage of new array syntax []   

First of all, you will need Composer and the most recent source code from this repository.  
Once it's done, open a terminal and go to the project folder. Then run a composer install  

    composer install

This command will load the required dependencies and re-create the symfony's parameters file.
Open this file and adapt it to your configuration

    # /app/config/parameters.yml
        
    parameters:
        
        database_host:      DB_IP_ADDRESS
        database_port:      DB_PORT
        
        database_name:      DB_NAME
        database_user:      DB_USER
        database_password:  DB_PASSWORD
        
        mailer_transport:   MAILER_PROTOCOL
        mailer_host:        MAILER_SERVER_URL
        mailer_user:        APP_SEND_MAIL
        mailer_password:    SEND_MAIL_PASSWORD
        secret:             CHANGE_BY_RANDOM_STRING
        
        varnish_urls:       ARRAY WITH VARNISH URLS
        
Now database host connection is set, we can init the base and the tables. Go to project folder
with a terminal and launch these commands
        
        bin/console doctrine:database:create   # Create the base
        bin/console doctrine:schema:create     # Execute SQL queries for build tables
        
This project initially use Varnish as cache server, if you decide to use it complete
the `VARNISH_URLS` parameter with your url. You can leave it blank if you don't have 
utility of it.

#### Load dataset from DoctrineFixtures
Really simple ! launch `bin/console doctrine:fixtures:load` from the project folder

#### Switch in production
Once again, really simple. Open `/web/.htaccess` and find the above line. Change `app.php`
to `app_dev.php`
        
    <IfModule mod_rewrite.c>
    
        // Stuff
        
        RewriteRule ^ %{ENV:BASE}/app.php [L]
    </IfModule>
    
Once it's done, launch `bin/console cache:clear --env=prod` from the project folder
