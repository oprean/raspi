import serial
ser = serial.Serial('/dev/ttyACM0', 9600)
while 1 :
	if (ser.inWaiting()>0):
		ser.readline()