# Pori Events

Drupal 8 based event calendar site.

## Getting started

### Requirements
- [Vagrant](https://www.vagrantup.com/downloads.html) 1.9.2 or greater
- [vagrant-cachier](https://github.com/fgrehm/vagrant-cachier)
 `vagrant plugin install vagrant-cachier`
- Ansible version 2.1.2 or greater in host machine. For OS X:
 `brew install ansible`
- [Virtualbox](https://www.virtualbox.org/wiki/Downloads) 5.1 or greater 

### 1. Setup local environment

```$ git clone git@github.com:City-of-Pori/pori-events.git```

```$ vagrant up``` 

### 2. First time setup

```$ vagrant ssh```

```$ cd /vagrant/drupal/```

```$ composer update --with-dependencies```

```$ ./build.sh reset```

Access your local environment at https://local.tapahtumat.pori.fi

## Development workflow

Refer WunderFlow for branching: http://wunderkraut.github.io/WunderFlow

## Credits

This project is based on WunderTools: https://wundertools.wunder.io/#!index.md
