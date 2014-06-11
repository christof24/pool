Pool Steuerung

Make gpios accessible via www-data user
execute /install/install.sh


make cronjobs
0 0 * * * wget -q -O /dev/null localhost/python/crontab.php?func=midnight
0 * * * * wget -q -O /dev/null localhost/python/tempToDatabase.php

make crontab as root
@reboot /var/www/initial.sh &



edit file /etc/sudoers
www-data ALL=(ALL:ALL) NOPASSWD: ALL

