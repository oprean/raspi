import RPi.GPIO as GPIO ## Import GPIO library
import time ## Import 'time' library. Allows us to use 'sleep'
import sys ## for param

##### CONSTANTS ##########
LED_RED = 7
LED_BLUE = xx
LED_GREN = xx

ON = 'on';
OFF = 'off';
CLEAN = 'reset';

#################### SETUP ########################
GPIO.setmode(GPIO.BOARD) ## Use board pin numbering
###################################################

led = sys.argv[1];
action = sys.argv[2];

GPIO.setup(led, GPIO.OUT)

if action == CLEAN:
    GPIO.cleanup()
elif action == ON:
    GPIO.output(led,True)
elif action == OFF:
    GPIO.output(led,False)