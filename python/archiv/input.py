import RPIO

RPIO.setup(22, RPIO.OUT)

try:

	def do_something(gpio_id, value):
    	#print "New value for GPIO %s: %s" % (gpio_id, value)
		RPIO.output(22, not RPIO.input(22))
		print "New value for GPIO 22: %s" % (RPIO.input(22))


	RPIO.add_interrupt_callback(17, do_something, edge='rising', debounce_timeout_ms=2000, threaded_callback=True)
	RPIO.wait_for_interrupts()

except KeyboardInterrupt:         # trap a CTRL+C keyboard interrupt
    print "exit"