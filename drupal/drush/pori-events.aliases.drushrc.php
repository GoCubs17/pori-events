<?php
// If the .vagrant folder exists find the ssh key for the virtual machine
if (file_exists(drush_server_home() . '/.vagrant.d')) {
  $home = drush_server_home();
  // Solve the key file to use
  $path = explode('/', dirname(__FILE__));
  array_pop($path);
  array_pop($path);
  $path[] = '.vagrant';
  $path = implode('/', $path);
  $key = shell_exec('find ' . $path . ' -iname private_key');
  if (!$key) {
    $key = $home . '/.vagrant.d/insecure_private_key';
  }
  $key = rtrim($key);

} else {
  // .vagrant directory doesn't exist, just use empty key
  $key = "";
}

$aliases['local'] = array(
  'parent' => '@parent',
  'site' => 'pori-events',
  'env' => 'vagrant',
  'root' => '/vagrant/drupal/web',
  'remote-host' => 'local.tapahtumat.pori.fi',
  'remote-user' => 'vagrant',
  'ssh-options' => '-i ' . $key,
  'path-aliases' => array(
    '%files' => '/vagrant/drupal/files',
    '%dump-dir' => '/home/vagrant',
  ),
);

$aliases['dev'] = array(
  'uri' => 'https://pori-events.dev.wunder.io',
  'remote-user' => 'www-admin',
  'remote-host' => '94.237.38.225',
  'root' => '/var/www/pori-events.dev.wunder.io/current/web',
  'path-aliases' => array(
    '%dump-dir' => '/home/www-admin',
  ),
  'command-specific' => array(
    'sql-sync' => array(
      'no-cache' => TRUE,
    ),
  ),
);

$aliases['stage'] = array(
  'uri' => 'https://tapahtumat-pori.stage.wunder.io',
  'remote-user' => 'www-admin',
  'remote-host' => '185.26.49.29',
  'root' => '/var/www/pori-events.stage.wunder.io/current/web',
  'path-aliases' => array(
    '%dump-dir' => '/home/www-admin',
  ),
  'command-specific' => array(
    'sql-sync' => array(
      'no-cache' => TRUE,
    ),
  ),
);

$aliases['prod'] = array(
  'uri' => 'https://tapahtumat.pori.fi',
  'remote-user' => 'www-admin',
  'remote-host' => '94.237.34.50',
  'root' => '/var/www/pori-events.prod.wunder.io/current/web',
  'path-aliases' => array(
    '%dump-dir' => '/home/www-admin',
  ),
  'command-specific' => array(
    'sql-sync' => array(
      'no-cache' => TRUE,
    ),
  ),
);
