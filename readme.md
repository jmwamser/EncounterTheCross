# Encounter The Cross Website

TODO: description of the site here

## Production Setup
Here is the flow of a release from compile to installation.

** FOR PRODUCTION WE WILL NEED A UPGRADE.PHP SCRIPT **
FOLLOW THIS GUIDE FOR SETUP https://medium.com/@runawaycoin/deploying-symfony-4-application-to-shared-hosting-with-just-ftp-access-e65d2c5e0e3d

### Developer Actions
#### A. Create Release in Version Control
1. Merge `DEV` branch into `Master` branch
    - This should trigger GitHub action to create the Release as well as the ZIP File. !!TODO!! See below how to do manually

#### Creating the ZIP File (Manual Steps)
1. In new folder download lastest core code of the project
2. run `APP_ENV=prod composer install --no-dev -o`, to download PHP libraries and optimize autoloader
3. run `yarn`, to install ecmascript libraries
4. run `yarn build`, to build the production version of the ecmascripts
5. run `APP_ENV=prod composer symfony:dump-env`, to generate `.env.local.php` file. This will hold all production environment variables
    - This file will hold template strings. The installer file will need to help update these or will need manually updated.
6. Rename `.env.local.php` to `.env.local.dist.php`
7. ZIP Folder up

### Database Setup / Creating
this will just need done 1 time when initially setting up project

1. Create MySQL DB
2. Create User and Password for MySQL
3. Tie new User to the DB that was created

### Script Actions / Started by Person that is installing
To be ran on the server the site is, as well in the parent folder of where you want the site installed/updated. ALWAYS TAKE A FILE AND DATABASE BACKUP BEFORE RUNNING SCRIPTS!

#### B. Check Server Requirements
TODO: This still needs built into the project
This will check the server requirements before updating any code or files. This is to help prevent a fail over doing a update of the site. This doesn't 100% prevent but from a server level should help a lot.
1. Confirm user has taken back ups of the install folder files and the database. In the prompt tell user if they havn't all data could be lost. If they answer anything but `YES` then STOP SCRIPT!
    - !!TODO!! in the future have this script move the files up to a backup folder and into a folder with its version number. or have all versions install there then copy to install folder. That way this script can allow user to go up and down between versions. Maybe even look into a sqlite db to keep track of where the current installation is at.
2. Confirm the install folder of the code. *** Should be a subfolder of where this script is running***
3. Using the PHP health check Library, like what is on Vortex API (TODO update reference note once in project). Run `bin/console health:check` <- will change to just the file reference once in a script.

#### C. Install Code
if last step passed start this step

1. Get Latest Release Zip From GitHub.
    - If zip of release is not all files, follow the Manual process for creating the ZIP File
2. Unzip File into the install folder that was confirmed from last step.
    - Will need to figure out how to update the code, so we dont overwrite these files/folders: !!TODO!!
        - `.env.local.php` but still keep a list of the environment variables needed.
        - `./var`, this has the cache as well as the log files
3. Prompt User for environment Variables.
    - This will loop through the `.env.local.dist.php` file for prompts, but will also load in values from `.env.local.php` if it exists. 
    - One of these will ask what database version you are using. Using the `./migrations/{dbtype and version}` folders to choose from. If user chooses "other" then the script need to let user know that type is not supported and stop the script. 
4. Recreate the `.env.local.php` file with new variables and values

#### D. Configure or Update Database
1. Check if the database is reachable
2. check the status of migrations
3. if migrations need ran run them
4. Check that starting login details are created.
    - if not prompt user for super admin login details. (Ex: username prompt)
    - display out the generated password to use
5. Check that NGLayouts Migrations have ran 
6. If NGLayouts Migrations need ran run them

#### E. Clear Cache and Warmup
1. run `bin/console cache:clear`
2. run `bin/console cache:warmup`

#### F. Check Health Points
TODO: This still needs built into the project
This will check the site is up and running, but also that all the requirements are configured on the server.

1. Run Health Check Script
    - if one health check fails stop script and revert to old install version
2. Display to user that the site is not Installed/Updated


## Setting Up Project (Overview)
 Below you will find steps to help configure the project on a new server or even locally.

### Symfony CLI 
It is recommended to have the [Symfony CLI](https://symfony.com/download) installed to set this project up. You can follow [here](https://symfony.com/doc/current/setup.html) to see additional PHP, and Composer requirements.
 
### Symfony Config
This project is using Symfony as its core. You will want to make sure that is all added and ready to get. The best place to start is to make sure you have the [Symfony CLI](https://symfony.com/download). Once you have that installed you will have a lot more access to the Symfony magic.
Before going into the magic we will need to make sure our Environment Variables are all setup, follow the steps below to do this.

1. copy `.env` file to `.env.local`
    -  *IF RUNNING LOCALLY ELSE SETUP UP ENV VARS ON MACHINE (Windows Environment Variables or Apache Environment Variables) OR create the .env.local.php file (If using the install script this is what will happen)*
2. update variables for `.env.local` file for you site

### PHP External Libraries
To get the external libraries you will need [PHP Composer](https://getcomposer.org/download/). Once you have that follow the CLI step below. (If using install script this will already be done)

1. run `composer install`.
    -  This will install all required external libraries


### Database
This setup will require MySQL V8. You can run this externally where ever you want or follow the 
[Docker & Docker-Compose](#Docker--Docker-Compose) steps below.

#### Support Multiple Database Types
!!TODO!! Follow the steps [here](https://dev.to/rafaelberaldo/symfony-doctrine-migrations-for-multiple-databases-drivers-1a07) to support more than 1 database type

#### Initial Setup Steps
Follow these steps to set up the database for the first time, if it has not already been created. 

1. run `symfony console doctrine:database:create`
   - *This step may error our saying the database is already created if you are running with the docker-compose setup*
2. run `symfony console doctrine:migrations:migrate`
3. setup nglayouts database tables, run `symfony console doctrine:migrations:migrate --configuration=vendor/netgen/layouts-core/migrations/doctrine.yaml`

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