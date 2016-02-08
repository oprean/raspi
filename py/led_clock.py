import time
initialLED = 1
totalLED = 24
def getHourLed(hour):
	led = initialLED + hour * 2
	if (hour>12): led = led - totalLED
	
	led1 = led-1
	led2 = led
	led3 = led+1
	
	if (led1 < initialLED): led1 = totalLED
	if (led2 > totalLED): led2 =  led2 - totalLED
	if (led3 > totalLED): led3 =  led3 - totalLED

	led1 = [led1, 50]
	led2 = [led2, 100]
	led3 = [led3, 50]

	return [led1, led2, led3]

def getMinLed1(min):
	led = initialLED + min * 24/60
	if (min%5 == 0): leds = [[led, 100]]
	if (min%5 == 1 or min%5 == 3): leds = [[led, 75], [led+1, 25]]
	if (min%5 == 2 or min%5 == 4): leds = [[led, 25], [led+1, 75]]
	
	return leds

def getMinLed(min):
	led = initialLED + min * 24/60

	return [led]

def getSecLed(sec):
	led = initialLED + sec * 24/60
	led1 = led
	led2 = led+1
	if (led2 > totalLED): led2 =  led2 - totalLED
	if (sec%5 == 0): leds = [[led, 100]]
	if (sec%5 == 1 or sec%5 == 3): leds = [[led1, 75], [led2, 25]]
	if (sec%5 == 2 or sec%5 == 4): leds = [[led1, 25], [led2, 75]]
	
	return leds
	
def updateClock():
	localtime = time.localtime(time.time())
	# print "Local current time :", localtime	
	print localtime.tm_hour, "hour leds: ",getHourLed(localtime.tm_hour)
	print localtime.tm_min, "min leds: ",getMinLed(localtime.tm_min)
	print localtime.tm_sec, "sec leds: ",getSecLed(localtime.tm_sec)

while True:
	time.sleep(1)
	updateClock()
# print "------ HOURs: --------"
# for h in range(0,24):
	# print h, " hour leds: ",getHourLed(h)
# print "------ MINs: --------"
# for m in range(0,60):
	# print m, " min leds: ",getMinLed(m)
# print "------ SECs --------"
# for s in range(0,60):
	# print s, " sec leds: ",getSecLed(s)
