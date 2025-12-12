## About Yii2 Basic Tutorial

***compatible with Apple (Mac Silicon | Intel Silicon)***

PHP 8.4 | Yii 2.x | MySQL 8.0 | Docker Compose 3.8 | Composer 2.8 

#### Repository URL
````
```git@github.com-third:aungkokoye/yii2-basic.git```

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

#### PHPStorm IDE
DB settings
````
host: 127.0.0.1
port: 3606
user: root
password: root
database: yii
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

#### Gii
Gii is Yii's code generation tool. You can access it by navigating to:

```
http://localhost:8375/gii
```