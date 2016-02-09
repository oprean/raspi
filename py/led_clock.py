from bibliopixel.led import *
from bibliopixel.animation import StripChannelTest
from bibliopixel.drivers.WS2801 import *
from bibliopixel import LEDStrip
import bibliopixel.colors as colors
import time
import sys ## for param

class LED:
	index = 0
	color = (255, 255, 255)
	type = ""
	
	def __init__(self, index, color, type):
		self.index = index
		self.color = color
		self.type = type

class LEDClock:
	'LEDClock'

	debug = True
	shadow = True
	
	totalLED = 25 
	startLED = 1
	endLED = 25

	hour = 0
	min = 0
	sec = 0

	hColor = (255, 255, 255)
	mColor = (128, 0, 0)
	sColor = (0, 0, 64)
   
	def __init__(self):
		driver = DriverWS2801(self.totalLED, c_order = ChannelOrder.RGB)
		self.LEDStrip = LEDStrip(driver)
		self.aLEDs =[]
		self.updateTime()
       
	def setHourLEDs(self):
		idx = self.startLED + self.hour * 2
		if (self.hour>=12): idx = idx - self.endLED + 1
		if (idx > self.endLED): idx =  idx - self.endLED
		self.aLEDs.append(LED(idx, self.hColor, "h")) 

	def setMinLEDs(self):
		idx = self.startLED + self.min * 24/60
		if (idx >= self.endLED): idx =  idx - self.endLED
		self.aLEDs.append(LED(idx, self.mColor, "m"))

	def setSecLEDs(self):
		idx = self.startLED + self.sec * 24/60
		if (idx >= self.endLED): idx =  idx - self.endLED
		self.aLEDs.append(LED(idx, self.sColor, "s"))        

	def updateLEDs(self):
		self.LEDStrip.all_off()
		del self.aLEDs[:]

		self.setHourLEDs()
		self.setMinLEDs()
		self.setSecLEDs()

		if (self.debug):
			print self.hour,":", self.min,":",self.sec
		
		for led in self.aLEDs:
			if (self.shadow):
				print "original: ",led.index
			led.index = self.endLED-led.index
			self.LEDStrip.set(led.index, led.color)
			
			if (self.debug):
				print led.type,":", led.index

		
		self.LEDStrip.update()
		
	def updateTime(self): 
		t = time.localtime(time.time())
		self.hour = t.tm_hour
		self.min = t.tm_min
		self.sec = t.tm_sec
		
	def update(self):
		time.sleep(2)
		self.updateTime()
		self.updateLEDs()

cnt = int(sys.argv[1])

clock = LEDClock()
while cnt > 0:
	clock.update()
	cnt -=1
clock.LEDStrip.all_off()
clock.LEDStrip.update()

# clock.hour = 0
# clock.min = 15
# clock.sec = 30
# clock.updateLEDs()

# clock.LEDStrip.all_off()
# clock.LEDStrip.set(1, clock.hColor)
# clock.LEDStrip.update()