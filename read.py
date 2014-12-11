#!/usr/bin/env python

from time import sleep
import RPi.GPIO as GPIO
import sys
 
GPIO.setmode(GPIO.BOARD)

INPUT_PIN = int(sys.argv[1]);
GPIO.setup(INPUT_PIN, GPIO.IN)

# Create a function to run when the input is high
def inputLow(channel):
    print('0');

# Wait for the input to go low, run the function when it does
GPIO.add_event_detect(INPUT_PIN, GPIO.BOTH, callback=inputLow, bouncetime=200) 

# Start a loop that never ends
while True:
    print('3.3');
    sleep(1);           # Sleep for a full second before restarting our loop