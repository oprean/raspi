import RPi.GPIO as GPIO ## Import GPIO library
import time
GPIO.cleanup()
GPIO.setmode(GPIO.BOARD) ## Use board pin numbering
GPIO.setup(11, GPIO.OUT) ## Setup GPIO Pin 7 to OUT
GPIO.output(11,True) ## Turn on GPIO pin 7
time.sleep(2)
GPIO.output(11,False)
time.sleep(2)
GPIO.cleanup()
