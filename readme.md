# Encounter The Cross Website

TODO: description of the site here

## Setting Up Project
 Below you will find steps to help configure the project on a new server or even locally.
 
### Symfony Config
This project is using Symfony as its core. You will want to make sure that is all added and ready to get. The best place to start is to make sure you have the [Symfony CLI](https://symfony.com/download). Once you have that installed you will have a lot more access to the Symfony magic.
Before going into the magic we will need to make sure our Environment Variables are all setup, follow the steps below to do this.

1. copy `.env` file to `.env.local`
    -  *IF RUNNING LOCALLY ELSE SETUP UP ENV VARS ON MACHINE*
2. update variables for `.env.local` file for you site

### PHP External Libraries
To get the external libraries you will need [PHP Composer](https://getcomposer.org/download/). Once you have that follow the CLI step below. 

1. run `composer install`.
    -  This will install all required external libraries


### Database
This setup will require MySQL V8. You can run this externally where ever you want or follow the 
[Docker & Docker-Compose](#Docker--Docker-Compose) steps below.

#### Initial Setup Steps
Follow these steps to setup the database for the first time, if it has not already been created. 

1. run `symfony console doctrine:database:create`
   - *This step may error our saying the database is already created if you are running with the docker-compose setup*
2. run `symfony console doctrine:migrations:diff`
3. run `symfony console doctrine:migrations:migrate`

#### Docker & Docker-Compose
If you are going to us Docker for your database here are the setup steps. You do not need to do this but it allows for quicker development. All docker files are included in project for *DEV* setup. If you plan to use it in production you may want to do some additional updates to the docker files. 
If you have questions about this configuration, outside of the notes below, take a look at this [Symfony 6 - docker-compose & Exposed Ports Tutorial](https://symfonycasts.com/screencast/symfony-doctrine/docker-compose) from [SymfonyCasts](https://www.symfonycasts.com).
You can also take a look as this [Symfony 6 - Docker & Environment Variables Tutorial](https://symfonycasts.com/screencast/symfony-doctrine/docker-env-vars) this will go over the magic the Symfony CLI does when docker is running.

1. run `docker-compose up -d`. 
    - This will launch all the docker files in the background.
2. run `docker-compose ps`. 
   - This will give you the information about what ports from your machine are tied to the docker image.
   - The port that is tied will change almost everytime you relaunch the docker image
3. Use the port numbers from here to make Env Var URL if not using the Symfony CLI