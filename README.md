# Pori Events

Drupal 8 based event calendar site.

## Setting up

This repository comes with two options to run your local development environment - Lando and Vagrant. If you are starting a new project from this repository refer to the `docs/setup.md` for suggestions on preparing your own repository.

### Lando (Recommended)

#### Requirements

- Install [Lando](https://docs.devwithlando.io/) 3.0.0-rc.2 or greater

Start you environment by running:
    
```$ lando start```

#### If you are building the environment for an ongoing project 

Build the project by running:    
    
```$ lando build.sh build```

Import your existing database by running

```$ lando db-import [database-dump.sql]```

Run full build update

```$ lando build.sh update```
    
#### If you are using this repository to start a new project
    
Build the project by running:    
    
```$ lando build.sh create```

Known issues with configuration import:

> Error: Call to a member function getCacheTags() on null in /app/web/core/modules/shortcut/src/Entity/Shortcut.php

The default shortcut set causes issues when running the import for the first time. Run `$ lando drush cim` to restart the configuration import.
   
### Vagrant

#### Requirements

- Install [Vagrant](https://www.vagrantup.com/downloads.html) 1.9.2 or greater
- Install [vagrant-cachier](https://github.com/fgrehm/vagrant-cachier)
 `vagrant plugin install vagrant-cachier`
- Install [Virtualbox](https://www.virtualbox.org/wiki/Downloads) 5.1 or greater. Note version 5.1.24 has a known issue that breaks nfs, do not use it, version 5.1.22 s known to work.
- Make sure you have python2.7 also installed (For OS X should be default).

### 1. Setup local environment

```$ git clone git@github.com:City-of-Pori/pori-events.git```

```$ vagrant up``` 

```$ vagrant ssh```

```$ cd /vagrant/drupal/```

### 2.a Setting up an existing site

```$ ./build.sh build```

```$ exit```

```drush @pori-events.stage sql-dump | drush @pori-events.local sql-cli```

### 2.b First time setup

```$ vagrant ssh```

```$ cd /vagrant/drupal/```

```$ ./build.sh create```

Access your local environment at https://local.tapahtumat.pori.fi

Check `docs/development.md` for more info.

## Credits

This project is based on WunderTools: https://wundertools.wunder.io/#!index.md