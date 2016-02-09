from bibliopixel.led import *
from bibliopixel.animation import StripChannelTest
from bibliopixel.drivers.WS2801 import *
from bibliopixel import LEDStrip
import bibliopixel.colors as colors
import time
import sys ## for param

numLeds = 25
initialLED = 1
totalLED = 24
shadow = True
driver = DriverWS2801(numLeds, c_order = ChannelOrder.RGB)
led = LEDStrip(driver)

hColor = (255, 255, 255)
mColor = (255, 0, 0)
sColor = (0, 255, 255)

def getHourLed(hour):
	led = initialLED + hour * 2
	if (hour>12): led = led - totalLED
	
	led1 = led-1
	led2 = led
	led3 = led+1
	
	if (led1 < initialLED): led1 = totalLED
	if (led2 > totalLED): led2 =  led2 - totalLED
	if (led3 > totalLED): led3 =  led3 - totalLED

	led1 = [led1, (128,128,128)]
	led2 = [led2, (255, 255, 255)]
	led3 = [led3, (128,128,128)]

	return [led1, led2, led3]

def getMinLed(min):
	led = initialLED + min * 24/60

	return [[led, (255, 0, 0)]]

def getSecLed(sec):
	led = initialLED + sec * 24/60
	if (led >= totalLED): led =  led - totalLED
	return [[led, sColor]]

def getMinLed1(min):
	led = initialLED + min * 24/60
	if (min%5 == 0): leds = [[led, (255, 255, 255)]]
	if (min%5 == 1 or min%5 == 3): leds = [[led, (192,192,192)], [led+1, (64, 64, 64)]]
	if (min%5 == 2 or min%5 == 4): leds = [[led, (64, 64, 64)], [led+1, (192,192,192)]]
	
	return leds
	
def getSecLed1(sec):
	led = initialLED + sec * 24/60
	led1 = led
	led2 = led+1
	if (led2 > totalLED): led2 =  led2 - totalLED
	if (sec%5 == 0): leds = [[led, (255, 255, 255)]]
	if (sec%5 == 1 or sec%5 == 3): leds = [[led1, (192,192,192)], [led2, (64, 64, 64)]]
	if (sec%5 == 2 or sec%5 == 4): leds = [[led1, (64, 64, 64)], [led2, (192,192,192)]]
	
	return leds

def updateLed(hLeds):
	for l in hLeds:
		if (shadow == True):
			lp = totalLED - l[0]
		else:
			lp = l[0]
		led.set(lp, l[1])
	
def updateClock():
	localtime = time.localtime(time.time())
	led.all_off()
	updateLed(getHourLed(localtime.tm_hour))
	updateLed(getMinLed(localtime.tm_min))
	updateLed(getSecLed(localtime.tm_sec))
	led.update()
	
while True:
	updateClock()

#led.all_off()	
#s = getSecLed(0)
#print s
#updateLed(s)
#led.set(1, hColor)
#led.update()

# print "------ HOURs: --------"
# for h in range(0,24):
	# print h, " hour leds: ",getHourLed(h)
# print "------ MINs: --------"
# for m in range(0,60):
	# print m, " min leds: ",getMinLed(m)
# print "------ SECs --------"
# for s in range(0,60):
	# print s, " sec leds: ",getSecLed(s)
