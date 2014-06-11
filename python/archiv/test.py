#!/usr/bin/env python
# -*- coding: utf-8 -*-

import logging
from time import sleep
import time
import sys

timeformat = '%H:%M:%S'
print time.strftime(timeformat)

start = '21:04:10'
stop = '21:14:00'
now = time.strftime(timeformat)

sollTemp = '20.31'

def log( msg ):
	logging.basicConfig(filename='test.log',format='%(asctime)s %(message)s')
	logging.warning(msg)
	return;


def getTemp(w1_slave):
	#28-0000045d2690,28-00000472367d
	file = open('/sys/bus/w1/devices/' + str(w1_slave) + '/w1_slave')
  	filecontent = file.read()
  	file.close()
  	stringvalue = filecontent.split("\n")[1].split(" ")[9]
  	temperature = float(stringvalue[2:]) / 1000
  	# Print temperature
  	temp = '%5.2f' % temperature
  	
  	return temp


while 1:
	now = time.strftime(timeformat)
	istTemp = getTemp("28-00000472367d")
	
	if istTemp < sollTemp:
		print "IST: " + istTemp + "Soll: " + sollTemp +"HEIZEN!!!!"
			
	if now > start and now < stop:
		print "innerhalb der Zeit " + start + " - " + stop
	else:
		print "Ausserhalb der Zeit" + start + " - " + stop
	
	sleep(4)	
# while 1:
# 	log("test")
# 	sleep(2)

