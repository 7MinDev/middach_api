Middach Kantinen App API
========================

Current Build Status (develop Branch): [![Build Status](https://travis-ci.org/7MinDev/middach_api.svg?branch=develop)](https://travis-ci.org/7MinDev/middach_api)

# Installation

## Local development environment

(I recommend to work with vagrant and the laravel homestead box. You're saving time setting up & configuring a complete LAMP stack)

### VirtualBox
Install [VirtualBox](https://www.virtualbox.org/wiki/Downloads). 

### Vagrant
Install [Vagrant](http://www.vagrantup.com/downloads.html).

### Homestead

Add the homestead box

`vagrant box add laravel/homestead`

Install the new homestead CLI tool

`composer global require "laravel/homestead=~2.0"`

Make sure to place the `~/.composer/vendor/bin` directory in your PATH so the `homestead` executable is found when you run the `homestead` command in your terminal.

Once it is installed, run the `init` command to create the `Homestead.yaml` configuration file.

Open the `Homestead.yaml` file for editing by

`homestead edit`

### Set your SSH Key

```
authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa
```

### Set shared folders

```
folders:
    - map: /htdocs # path to your projects directory
      to: /home/vagrant/sites
```

### Configure sites

```
sites:
    - map: test.app
      to: /home/vagrant/sites/test/public
      hhvm: true
    - map: middach.dev
      to: /home/vagrant/sites/middach_api/public
```

### Set hosts

Open your `hosts` file and add a new domain pointing to the localhost.

```
vi /etc/hosts
```

```
127.0.0.1 middach.dev
```

### Start homestead

```
homestead up
```

Once the virtual machine is started, you can access the site via a webbrowser

`http://middach.dev:8000`

## Database

![](http://new.tinygrab.com/3f6ff94c6d7b165373151b858f4d8a246ad77527b0.png)

*Host:* 127.0.0.1  
*Benutzer:* Homestead _or_ root  
*Passwort:* secret  
*Port:* 33060  

### Create a new database

Create a new database with a arbitrary name (or just `middach`) and if you want a user with the rights to access this database.

### Database credential configuration

Create a file with the name `.env` in the project root directory (or copy the `.env.example file and rename it) 
and add your database credentials to that file.


```
APP_ENV=local
APP_DEBUG=true

DB_HOST=localhost
DB_USER=<dbusername or root/Homestead>
DB_PASS=<dbpassword oder secret>
DB_NAME<the name of the database you created>
```

## 2. Composer install

Log into your VM by

```
ssh vagrant@127.0.0.1 -p 2222
```

(You can also add an alias to your `.bash_profile` so you dont have to retype this everytime.  

```
alias vm=ssh vagrant@127.0.0.1 -p 2222
``` 

### Composer Packages installieren

_Before the first installation you need a GitHub API Token from my account, so that composer can access the two packages which are in a private repository by now. Just contact me._

```
cd /path/to/your/projects/middach_api
composer install
composer update
```


## 3. Migrations and seeds

```
php artisan migrate  
php artisan db:seed  
```


Now you're ready to hack!