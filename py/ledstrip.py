from bibliopixel.led import *
from bibliopixel.animation import StripChannelTest
from bibliopixel.drivers.WS2801 import *
from bibliopixel import LEDStrip
import bibliopixel.colors as colors
import sys ## for param

numLeds = 25
driver = DriverWS2801(numLeds, c_order = ChannelOrder.RGB)
led = LEDStrip(driver)

r = int(sys.argv[1])
g = int(sys.argv[2])
b = int(sys.argv[3])

led.fillRGB(r,g,b)
led.update()