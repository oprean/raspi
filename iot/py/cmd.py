#!/usr/bin/python
# usage: send_and_receive_arduino <DEVICE> <BAUDRATE> <TEXT>
# where <DEVICE> is typically some /dev/ttyfoobar
# and where <BAUDRATE> is the baudrate
# and where <TEXT> is a text, e.g. "Hello"
import sys
import serial
import time
#ser = serial.Serial(sys.argv[1], sys.argv[2], timeout=None)
ser = serial.Serial(dsrdtr=0)
ser.port=sys.argv[1]
ser.baudrate=sys.argv[2]
#time.sleep(5)
ser.open()
ser.open()
print('opened')
#ser.setDTR(1)
#ser.setRTS(False)
#print(ser.isOpen())
#ser.open()
time.sleep(1)
ser.write(sys.argv[3])
print('writen')
#time.sleep(2)
ser.close()