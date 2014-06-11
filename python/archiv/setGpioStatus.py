#! /usr/bin/env python

import RPIO
import sys

RPIO.setwarnings(False)

gpio = int(sys.argv[1])
value = int(sys.argv[2])
RPIO.setup(gpio, RPIO.OUT)
RPIO.output(gpio, value)