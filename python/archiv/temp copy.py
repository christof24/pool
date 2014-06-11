#!/usr/bin/env python
# -*- coding: utf-8 -*-

# Import sys module
import sys
import time

# Open 1-wire slaves list for reading
file = open('/sys/devices/w1_bus_master1/w1_master_slaves')

# Read 1-wire slaves list
w1_slaves = file.readlines()

# Close 1-wire slaves list
file.close()

	# Print header for results table
print('Sensor ID       | Temperature')
print('-----------------------------')

while 1:
	# Repeat following steps with each 1-wire slave
	for line in w1_slaves:

	  # Extract 1-wire slave
	  w1_slave = line.split("\n")[0]
	
	  # Open 1-wire slave file
  	file = open('/sys/bus/w1/devices/' + str(w1_slave) + '/w1_slave')

  	# Read content from 1-wire slave file
  	filecontent = file.read()

  	# Close 1-wire slave file
  	file.close()

  	# Extract temperature string
  	stringvalue = filecontent.split("\n")[1].split(" ")[9]
	
  	# Convert temperature value
  	temperature = float(stringvalue[2:]) / 1000
	
  	# Print temperature
  	print(str(w1_slave) + ' | %5.3f °C' % temperature)
	time.sleep(1)
# Quit python script
sys.exit(0)