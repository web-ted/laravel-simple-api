# Purpose
This project has been built on `Laravel 8` and `PHP  7.3`. It aims to demonstrate the creation of a simple API project
that will be use all the important features and design patterns that Laravel provides. It implements an HR managing
API that handles users, departments, skills and other aspects of that domain.
This *NOT* a fully implemented and *NOT* a ready to use applications at any way but rather a demo on what this MVC 
can do in a elegant and expressive way.

# Prerequisites
In order to avoid installing all the prerequisites for this project to work we would use docker to do it for us.
So docker and docker-compose need to be installed for this project to work. Download and install from [here](https://www.docker.com/get-started)
the appropriate version for your system and follow the instructions to install it. Of course you will also need `git` 
installed on your system to be able to retrieve code.

# Getting started
Clone this project on your local machine using git:
```
git clone <repo>
``` 


Get in the project's root dir and copy the sample configuration to your own:
```
cp .env.example .env
```
Edit the `.env` file and make sure database config is something like this:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=pfizer
DB_USERNAME=root
DB_PASSWORD=root
```
Then get laradock (in the root dir of the project not outside):
```
git clone git@github.com:laradock/laradock.git
```
Then get in the laradock dir and start the project
```
cd laradock
docker-compose up -d nginx mysql phpmyadmin workspace
```
This will start as you can see the `nginx` web server with php-fpm, the MySQL relational database and a workspace
container that we can use to run cli tools like composer, artisan and other goodies laradock provides.
Pretty neat isn't it ? Having all that using a single command.

# Not there yet
For our app to work will need its plugins installed and some initial data. So to do that we will first need to 
get into the workspace:
```
docker ps
```
do the above and track down the container that contains the workspace and the databse. The output will be something like this:
```
CONTAINER ID        IMAGE                        COMMAND                  CREATED             STATUS              PORTS                                                                                                                            NAMES
c9519916d6e3        laradock_phpmyadmin          "/docker-entrypoint.…"   3 days ago          Up 19 minutes       0.0.0.0:8081->80/tcp                                                                                                             laradock_phpmyadmin_1
d8aac143845e        laradock_nginx               "/docker-entrypoint.…"   3 days ago          Up 19 minutes       0.0.0.0:80-81->80-81/tcp, 0.0.0.0:443->443/tcp                                                                                   laradock_nginx_1
7ca50faff114        laradock_php-fpm             "docker-php-entrypoi…"   3 days ago          Up 19 minutes       9000/tcp                                                                                                                         laradock_php-fpm_1
4b29eaadd81a        laradock_workspace           "/sbin/my_init"          3 days ago          Up 19 minutes       0.0.0.0:3000-3001->3000-3001/tcp, 0.0.0.0:4200->4200/tcp, 0.0.0.0:8080->8080/tcp, 0.0.0.0:2222->22/tcp, 0.0.0.0:8001->8000/tcp   laradock_workspace_1
58825430e381        laradock_mysql               "docker-entrypoint.s…"   3 days ago          Up 19 minutes       0.0.0.0:3306->3306/tcp, 33060/tcp                                                                                                laradock_mysql_1
4dc99928e819        docker:19.03-dind            "dockerd-entrypoint.…"   3 days ago          Up 19 minutes       2375-2376/tcp                                                                                                                    laradock_docker-in-docker_1
```
We need to create the database schema by hand. So we need to use the name of the database container and create our 
schema that we will call `pfizer`.
```
docker exec -it laradock_mysql_1 mysql -proot -e "create schema pfizer"
```
So most probably your container with the workspace will be `laradock_workspace_1` (if you are not running this multiple timess).
To enter the workspace you will be using its name:
```
docker exec -it laradock_workspace_1 bash
```
and then run composer and run the migrations (seeding sample data) to build the database:
```
composer install
php artisan migrate --seed
```
Now we are ready to go.

