## Starting a new Drupal 8 Event calendar Project with WunderTools

### Preparation

Start by downloading and unarchiving a zipball of the Pori Events as a base for your new project from
https://github.com/City-of-Pori/pori-events/archive/master.zip

##### a) if you already have git repo

* Move the content (with dotfiles) of WunderTools-master into your git repo directory.
  - `mv pori-events-master/{.[!.],}* ~/Projects/my-existing-project/`  
(works on OSX, but you should know how to copy if this is not a bulletproof one-liner on your system)

##### b) if you don't already have git

* Just rename pori-events-master to whatever project folder you have and init git inside it:
```
mv pori-events-master ~/Projects/my-new-project
cd ~/Projects/my-new-project
git init
```

## Configure WunderTools

* Edit `conf/vagrant.yml` and change `domain_name` variable to match your local domain.
* Edit `conf/vagrant_local.yml` and change:
  - `name` to the name of your project
  - `hostname` to a good hostname for your local environment (preferably replace *www* part of your production domain 
 with *local*)
  - `ip` to something that no other project in your company uses (increment the value by one and commit the new ip 
 address to project repository)

* Edit `conf/project.yml` and change the variables to something that makes sense for your project.
  - Minimally `project:name` to the name of your project

## Configure Drupal build

* Optionally edit `drupal/conf/site.yml`, to tailor the build steps to your needs.
* Rename `drupal/drush/pori-events.aliases.drushrc.php` to `drupal/drush/[PROJECT_NAME].aliases.drushrc.php` and 
configure it to fit your setup. 
  - this file will be automatically symlinked from `~/.drush` when running vagrant up
