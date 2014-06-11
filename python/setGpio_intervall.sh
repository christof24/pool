#!/bin/bash
# Aufruf mit Parameter
# 1: gpio
# 2: value
# 3: timeout
# Beispiel ./setGpio_intervall.sh 24 0 60

sleep $3

echo $2 >> /sys/class/gpio/gpio$1/value