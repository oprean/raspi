from bibliopixel.led import *
from bibliopixel.animation import StripChannelTest
from bibliopixel.drivers.WS2801 import *
from bibliopixel import LEDStrip
import bibliopixel.colors as colors

numLeds = 25
driver = DriverWS2801(numLeds, c_order = ChannelOrder.RGB)
led = LEDStrip(driver)


def rainbowCycle():

        for j in range(0,384,2):
                for i in range(0,numLeds):
                        led.set(i, Wheel( ((i * 384 / numLeds + j) % 384) ))
                led.update()


def Wheel(WheelPos):
        r = 0
        g = 0
        b = 0

        tmpVar = WheelPos/128
        if tmpVar == 0:
                r = 127 - WheelPos % 128        # red down
                g = WheelPos % 128              # green up
                b = 0                           # blue off
        elif tmpVar == 1:
                g = 127 - WheelPos % 128        # green down
                b = WheelPos % 128                      # blue up
                r = 0                                           # red off
        elif tmpVar == 2:
                b = 127 - WheelPos % 128;       #blue down
                r = WheelPos % 128;             #red up
                g = 0;                          #green off
        return(r,g,b)
cnt = 5    
while cnt>0:
    rainbowCycle()
    cnt -=1
led.all_off()
led.update()