import RPi.GPIO as GPIO ## Import GPIO library
import time ## Import 'time' library. Allows us to use 'sleep'
import sys ## for param

##### CONSTANTS ##########
LED_RED = 7
LED_BLUE = 11
LED_GREN = 14

ON = 'on';
OFF = 'off';
CLEAN = 'reset';

#################### SETUP ########################
GPIO.setmode(GPIO.BOARD) ## Use board pin numbering
GPIO.setwarnings(False)
###################################################

led = sys.argv[1];
action = sys.argv[2];

GPIO.setup(int(led), GPIO.OUT)

if action == CLEAN:
    GPIO.cleanup()
elif action == ON:
    GPIO.output(int(led),False)
elif action == OFF:
    GPIO.output(int(led),True)
