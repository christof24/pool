#! /usr/bin/env python

import RPIO
import sys

RPIO.setwarnings(False)

gpio = int(sys.argv[1])

RPIO.setup(gpio, RPIO.OUT)
input_value = RPIO.input(gpio)

print input_value