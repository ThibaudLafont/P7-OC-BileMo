# Bilemo API
This project will create an API for Bilemo company. Clients of Bilemo will be able to 
list smartphones products and Bilemo partners will be able to add/edit/delete/list API
users

## Installation
#### Summary
  - Install and configure the project  
  - Load a dataset with DoctrineFixtures
  - Switch in production 
  - opt: Varnish implement
    
#### Pull and configure the project

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
        
        varnish_urls:       VARNISH URLS
        
This project initially use Varnish as cache server, if you decide to use it complete
the `VARNISH_URLS` parameter with your url. You can leave it blank if you don't have 
utility of it.

#### Init database and load the dataset
        
Now database host connection is configured, we can init the base and tables. Go to project folder
with a terminal and launch these commands
        
        bin/console doctrine:database:create   # Create the base
        bin/console doctrine:schema:create     # Execute SQL queries for build tables
        
Now you can load a dataset with Doctrine DataFixtures :    
Really simple ! Launch `bin/console doctrine:fixtures:load`

#### JWT configuration

The project use JWT for authentication, and you need to generate your ssh keys. In order
to do that, you can follow this instructions picked 
[here](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md), 
in the JWT documentation.

With terminal reach your project root folder and execute commands above:

    mkdir var/jwt                                                       # Create the folder for keys
    openssl genrsa -out var/jwt/private.pem -aes256 4096                # Generate the private key
    openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem # Generate public key

During the keys generation, openssl will ask you for a pass phrase. 
You need to inquire it in `/app/config/config.php`
    
    lexik_jwt_authentication:
        ...
        pass_phrase:         'you_pass_phrase'       

#### Switch in production

> Note it is a better practice to configure apache virtual host than use .htaccess

Once again, really simple. Open `/web/.htaccess` and find the above line. Change `app.php`
to `app_dev.php`
        
    <IfModule mod_rewrite.c>
    
        // Stuff
        
        RewriteRule ^ %{ENV:BASE}/app.php [L]
    </IfModule>
    
Once it's done, launch `bin/console cache:clear --env=prod` from the project folder in order
to clear cache.


## Documentation
At any time you can check the path `/docs` witch contain a swagger documentation for this
API.    
You can also request the JSON_LD contexts routes for additionnal informations.
However I give you some tips : 

#### Get token
This project use a token authentication and handle authorizations.
You have to request `/login_check` in POST and send a JSON body with your credentials 
informations. For example:
    
    {
        "username": "johndoe",
        "pwd": "yourpassword"
    }

The response will be a JSON containing your private token

    {
        "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX0FETUlOIl0sInVzZXJuYW1lIjoidGhpYiIsImlhdCI6MTUyMDQzNzYzNywiZXhwIjoxNTIwNDQxMjM3fQ.gB4CcxT_XQIK4tXY8fny7PYNKwkac3thB3wbMLJejMspFoF4NGha9HlfW4KhpIwEbXthcbyqds8HKyPv1U21kwgOyeqElry9MG1xJS2T8hVSQpK_Bbcke3x3lxSsciLSA2ZKNssZ3U8ZRHRVvL6j6kV2NqeUIcQn_bqw9iZ8DswiswHvbEy3nJEamtCz3hWd4JGibQpZkkL4ecBoqEKx-B-eQdXOOtmc5HGfBLIJfK-8RJEmhwnCPaVo7ij1OWpOZlpu1eNA8ZT1g60m4VLkYUdJEJeaQYPAcPHzlvfVO43LLgZpgqTwpd0eJIB3y6x44P6kARUVeSuttr8LPE2R5lvn2UprFWmFC_9I5Ii5ByP_MYvs1VzurT35y-G8WbE-IaetBBlkVITxE06HwfbhsQd6TkygRpi29rUoSU1rdpgLvgyOWZVxCE54g14uxuimEUF44pbTS5uKyGtgfkGVG1TFZJh7RTl_fnK_O0VZHe3cY0_SKOwUe5N26yMgPtjZ_K_YDDy5ccH4ZvyIodPYuAbGrnWcVIZdNtIGsGFPxEucBWsBPw-awvnYWIfYLUodpxIcwoWRK5jAosaAFZxFfQpbzOxTJm1JZqTGK7zq3DIpNDarR9vdPsE9y7odhjhifgR82p1Wo-j6sJCYNVRvBQcvXOqNA-Om_fR1Cb3clmg"
    }
    
#### Request secure paths
You just have to set a `Authorization` header and paste the token as value.
Beware ! You have to prefix your token with `Bearer`

    Bearer MyApiKey

## Informations
This project use ApiPlatform bundle with Symfony framework. 

#### Object model
You can find the object model in this repository

    /assets/ddb_diagramm.png

#### Class diagramm
You can find the object model in this repository

    /assets/class_diagramm.png

#### Serialization of resources
ApiPlatform handle the serialization of resources process, though a configuration 
witch is explained here.

#### Resources declaration
Resources routes are defined and configured in :
    
    /app/config/api_platform/resources/
    
Some specials routes are also build in :
    
    /src/AppBundle/Action/
    
#### Serialization groups
Serialization groups are defined though YAML configuration, find them here :

    /app/config/api_platform/serialization/
    
#### Normalization
A custom normalizer have been created foreach resource. You can find them in 
    
    /src/AppBundle/Serializer/Normalizer/
    
#### Resource Models
Resource models are used for swagger documentation and jsonld-context, though 
`@ApiProperty` in each Entity object

#### Authentication
The provider was settled up though DoctrineUserProvider. The main class is 
`AppBundle\Entity\User\User`, Partner and Client extend of it.    
The project use JWT for authentication, witch create a token used for 
authenticate http requests before delivering resources.   
Always thanks to Doctrine a authorization had been settled with two types of
users : clients and coworkers of Bilemo.   
Users passwords are bcrypt crypted in DB.
