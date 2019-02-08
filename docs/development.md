# Development instructions
 
## Project directory structure
    .
    ├── ansible                 Contains ansible roles and related configuration (Cloned during  'vagrant up'.
    ├── ansible.cfg             Ansible configuration parameters.
    ├── build.sh                Main script for preparing and updating project tools.
    ├── CHANGELOG               Changelog for environment updates.
    ├── conf                    Project environment configurations.
    ├── docs                    Project documentation.
    ├── drupal                  Application directory.
    │   ├── builds              Previous application builds.
    │   ├── build.sh            Drupal build script.
    │   ├── composer.json       Project composer.json file.
    │   ├── composer.lock       Project composer.lock file.
    │   ├── conf                Drupal build configuration.
    │   ├── drush               Project drush scripts.
    │   ├── files               Files folder for local environments.
    │   ├── phpcs.xml           PHPCS configuration.
    │   ├── scripts             Various project scripts.
    │   ├── sync                Drupal configuration directory.
    │   ├── tests               Boilerplate Codeception test suite.
    │   ├── vendor              Composer libraries.
    │   └── web                 Drupal web root.
    ├── LICENSE.md              Licence file.
    ├── local_ansible_roles     Custom ansible roles goes here.
    ├── provision.sh            Wrapper script for provisioning vagrant box and servers (see ./provision.sh)
    ├── README.md               Main project README file.
    ├── syncdb_local.sh         Sync script helper.
    ├── syncdb.sh               Database syncronisation script. 
    ├── sync.sh                 Legacy sync script.
    ├── Vagrantfile             Main Vagrant configuration entry point.
    └── VERSION                 Environment version. 
 

## Working with Git

WunderFlow has been used to develop and maintain the project. See [WunderFlow](http://wunderkraut.github.io/WunderFlow) for reference.

## Using development tools with lando

Check out the extensive [Lando documentation](https://docs.devwithlando.io/tutorials/drupal8.html). Quick reference:

build.sh: ```$ lando build.sh [command]```

Composer: ```$ lando composer [command]```

Drush: ```$ lando drush [command]```

## Indexing Elastic Search.

Run the following to set up ES indexes.

`$ lando drush eshd -y && lando drush eshr event_index && lando drush queue-run elasticsearch_helper_indexing`
 
## Preparing production releases

- Merge all your feature branches to `master` branch. Preferably via pull requests.
- Merge `master` branch into `production` branch. Create a detailed release description containing released ticket numbers and short description about changes.

```
Week 1 release:
- EVENTS-1: updated the events content type.
- EVENTS-2: updated instructions for creating conte types.
- EVENTS-3: fixed bug with events content type.
```
