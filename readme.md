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
Follow these steps to set up the database for the first time, if it has not already been created. 

1. run `symfony console doctrine:database:create`
   - *This step may error our saying the database is already created if you are running with the docker-compose setup*
2. run `symfony console doctrine:migrations:diff`
3. run `symfony console doctrine:migrations:migrate`

#### Docker & Docker-Compose
If you are going to us Docker for your database here are the setup steps. You do not need to do this, but it allows for quicker development. All docker files are included in project for *DEV* setup. If you plan to use it in production you may want to do some additional updates to the docker files. 
If you have questions about this configuration, outside the notes below, take a look at this [Symfony 6 - docker-compose & Exposed Ports Tutorial](https://symfonycasts.com/screencast/symfony-doctrine/docker-compose) from [SymfonyCasts](https://www.symfonycasts.com).
You can also take a look as this [Symfony 6 - Docker & Environment Variables Tutorial](https://symfonycasts.com/screencast/symfony-doctrine/docker-env-vars) this will go over the magic the Symfony CLI does when docker is running.

1. run `docker-compose up -d`. 
    - This will launch all the docker files in the background.
2. run `docker-compose ps`. 
   - This will give you the information about what ports from your machine are tied to the docker image.
   - The port that is tied will change almost everytime you relaunch the docker image
3. Use the port numbers from here to make Env Var URL if not using the Symfony CLI

### Entities
All Entities are found in the Entity Directory `src/Entity`. Common fields used between entities we will use Traits so we can minimize the amount of code needed to maintain. Trais will be found in `src/Entity/Traits`
Some entities will have a field called `type` this field will be used for a dual-purpose entity. For example `EventParticipant` can be 2 different types. `EventAttendee` or `EventServer`. The Entity will have all the fields for both types but only require the field that are required between the two types.
We will then use `DTO's` to use with the symfony forms. This will allow us to restructure what is required on the fields with more control, while minimizing code for maintainability. You can think of the `DTO` as a model that then transforms into the entity, you can find more information about `DTO's` in the
[Symfony Documentation](https://symfony.com/doc/current/form/data_transformers.html) or even watch this [SymfonyCast](https://symfonycasts.com/screencast/symfony-forms/form-dto) about them. (_Note the Cast is in Symfony 4_)

#### Doctrine Extensions
We will also use [Doctrine Extensions](https://symfony.com/bundles/StofDoctrineExtensionsBundle/current/index.html) to help manage the entities.
You can look at basic [configuration options](https://symfony.com/bundles/StofDoctrineExtensionsBundle/current/configuration.html#use-the-doctrineextensions-library) or look at [advance configuration](https://github.com/doctrine-extensions/DoctrineExtensions/tree/main/doc).
By default, we add these in the `CoreEntityTrait` as noted [above](#entities), see below for list:
- SoftDeletable
- TimeStampable

#### Dual-Purpose Entities
Below you will find the list of entities that are dual-purpose and the types each has.

- Location
  - Event:

    This is the location for the event that is being hosted.
  - Launch

    This is the location for the launch point Attendee's & Server's.
- EventParticipant
  - Server

    This type is for an Event Server, the persons that are behind the scenes.
  - Attendee

    This type is for an Event Attendee, the person that the event is for.

## Testing
TODO List:
- [ ] Entity Core Doctrine Extension Tests to make sure they are working correctly.
- [ ] Entity Class Managers? Still need to decide which ones we want. Im thinking the entities that are dual-purpose.