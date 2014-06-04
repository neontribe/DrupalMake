DrupalMake
==========

Install composer (why?)

    https://github.com/drush-ops/drush#installupdate---composer

INstall Drush v7+

    composer.phar global require drush/drush:dev-master

Use a make file to create a site framework

	drush make wightlocations.make wightlocations

Use a profile to enable modules/create db

    drush -y si neontabs_profile --db-url=mysql://delme:delme@localhost/delme --account-name=superadmin --account-pass=b191wkm --db-su=root --db-su-pw=$MYSQL_ROOTPASS --site-name=delmesite

Compile the style sheets

    compass compile sites/all/themes/neontabs
    compass compile sites/all/themes/ntwl

If you want to clone a remote site first get the database:

    ssh root@stagingNeontabs drush -r /home/wightlocations/www/NeonTABS/demosite sql-dump > dump.sql

Then overwrite the database

    drush sqlq "source dump.sql"

Then rsync the files folder

    rsync --delete --progress -a root@stagingNeontabs:/home/wightlocations/www/NeonTABS/demosite/sites/default/files sites/default
