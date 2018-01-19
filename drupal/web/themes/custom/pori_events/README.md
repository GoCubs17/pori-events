All style changes are done in the sass folder and generated into css automatically using grunt.
For everything to work correctly you need to install required modules. Run the following:

    npm install
    bower install

If the bower command gives you 'Command not found' run it from theme root like this:

    ./node_modules/bower/bin/bower install

After this you can run the command that compiles your sass files to css.

    gulp

If you want to compile the css into production form you can use the gulp --production

    gulp --production

### Good to know ###

#### Libraries ####

We use libraries so that each component on the site has their own sass-file and they are added as separate library
with their own dependencies and javascript files. All these libraries are then compiled into one global styling library
to avoid extra http-requests. However the structure is planned so that if needed, the global library can easily be
divided into separate libraries.

#### _dependencies.scss ####

All new files that wish to use shared resources such as variables and mixings need to have the _dependecies.scss file
imported at the beginning of the file for these resources to be available.

#### Templates structure ####

The theme uses Classy-theme as base theme so the templates folder structure is copied from that theme. Please refer to
Classy-themes structure if in need.

#### libSass ####

The theme is using libSass instead of regular compass due the performance benefits. Please read more about libSass if
its new to you <a href="http://sass-lang.com/libsass">here</a>.

#### ESlint ####

All custom javascript is validated using ESlint. Run the following to enable eslint on commandline when inside your
local vagrant machine:

    vagrant provision

After successfully provisioning the local machine, run the following in the vagrant machine, in the theme folder:

    ./node_modules/eslint/bin/eslint.js -c /vagrant/projects/druid.fi-d8/current/core/.eslintrc --global responsiveNav:true js/*

Fix the given errors if any and you are good to go.
