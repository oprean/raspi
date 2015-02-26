#!/usr/bin/python
# usage: send_and_receive_arduino <DEVICE> <BAUDRATE> <TEXT>
# where <DEVICE> is typically some /dev/ttyfoobar
# and where <BAUDRATE> is the baudrate
# and where <TEXT> is a text, e.g. "Hello"
import sys
import serial
import time
ser = serial.Serial()
ser.port=sys.argv[1]
ser.baudrate=sys.argv[2]
ser.open()
print('opened')
ser.write(sys.argv[3])
print('writen')
ser.close()