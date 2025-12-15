## About Yii2 Advance Tutorial

***compatible with Apple (Mac Silicon | Intel Silicon)***

PHP 8.4 | Yii 2.x | MySQL 8.0 | Docker Compose 3.8 | Composer 2.8 

#### Repository URL
````
git@github.com-third:aungkokoye/yii2-basic.git
````

#### how to start docker
````
cd docker
docker compose up --build -d
````
#### how to stop docker
````
cd docker
docker compose down
````
#### Inside app web container
````
docker exec -it yii_app bash
````
#### Debug Docker Containers
````
docker ps
docker logs <container_id>

OR 

cd docker && docker-compose logs --tail=50 app
````

#### Webpage, Gii & Debug Toolbar

Webpage is entry point to your Yii applications (bankend or frontend).
Gii is Yii's code generation tool. 
Debug Toolbar is Yii's debugging tool. 

````
Frontend:

http://localhost:8380

http://localhost:8380/gii

http://localhost:8380/debug
````

````
Backend:

http://localhost:8381

http://localhost:8381/gii

http://localhost:8381/debug
````

#### PHPStorm IDE
DB settings
````
host: 127.0.0.1
port: 3206
user: root
password: root
database: yii_advanced
````
#### Yii migration commands
```
 php yii migrate/create create_file_table
 php yii migrate/create create_file_table --fields="name:string:notNull,base_url:string:notNull,mime_type:string:notNull"
 php yii migrate/create create_project_image_table --fields="project_id:integer:notNull:foreignKey,file_id:integer:notNull:foreignKey"
 php yii  migrate/create create_testimonial_table --fields="project_id:integer:notNull:foreignKey,
    customer_image_id:integer:notNull:foreignKey(file),title:string:notNull,customerName:string:notNull,
    review:text:notNull,rating:integer:notNull"
```
