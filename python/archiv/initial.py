#! /usr/bin/env python

import RPIO

RPIO.setwarnings(False)

#initial Value
#Remember 1 is Relay OFF and 0 is Relay ON per default
value = 0

#set all the GPIOs that must be set to the value
gpios=[23,24,25]

for x in gpios:
	print "Setze GPIO %i auf value = %i" % (x,value)
	RPIO.setup(x, RPIO.OUT, initial=value)
