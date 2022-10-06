## Install project
- clone the project to local

## Reload env

- update env file 
- Run php artisan config:cache and npm run watch/dev
-  php artisan optimize


UPDATE mysql.user SET Super_Priv='Y' WHERE user='excelfxv_developer' AND host='%';

mysql -u developer_plex -p dev_my_plexus < /var/www/vhosts/dev.myplexus.com/httpdocs/all_store_procedures.sql
