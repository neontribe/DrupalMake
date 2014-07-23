<?php
// TODO: Read.php -- Searchs for match of neontribe repos, removes url from [tabs] and [ntch]

// OAUTH_TOKEN for access to Github API
define('OAUTH_TOKEN', 'd5588f96e85a798c3cac9c2cb6e73b46b5437611');

// Directory to search for make files (For use on the index page to populate the dropdown box
$modify_directory = '/home/adam/Documents/DrupalMake/*.make';

// Default template to use when create NEW make files
$config_default_template = 'template.tpl';

// Template to use when modifying an existing make file
$config_modify_template = 'modify_template.tpl';

// Location of drush installation
$drush_path = '/usr/local/share/drush';

// Where to build the project to (is fed into ntdc)
$build_target = '/var/www/html/drupal-make-build';

$mysql_root_pass = 'password';
?>