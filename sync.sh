rsync --progress -rvht --delete-after  root@volt.monteops.com:/var/www/vhosts/volt.monteops.com/* ./
rsync --progress -rvht --delete-after  root@volt.monteops.com:/var/www/vhosts/volt.monteops.com/.[^.]* ./
rsync --progress -rvht --delete-after  root@volt.monteops.com:/var/www/vhosts/volt.monteops.com/.git/* ./.git/