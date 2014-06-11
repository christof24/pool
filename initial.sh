#!/bin/sh

echo "17" > /sys/class/gpio/export
echo "22" > /sys/class/gpio/export
echo "23" > /sys/class/gpio/export
echo "24" > /sys/class/gpio/export
echo "25" > /sys/class/gpio/export
echo "27" > /sys/class/gpio/export


echo "out" > /sys/class/gpio/gpio17/direction
echo "out" > /sys/class/gpio/gpio22/direction
echo "out" > /sys/class/gpio/gpio23/direction
echo "out" > /sys/class/gpio/gpio24/direction
echo "out" > /sys/class/gpio/gpio25/direction
echo "out" > /sys/class/gpio/gpio27/direction

sleep 30

wget -q -O /dev/null localhost/python/initial.php
