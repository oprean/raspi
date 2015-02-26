#include <SPI.h>
#include <Adafruit_WS2801.h>
#include <LiquidCrystal.h>

String content = "";
char character;

int dataPin = 2;      
int clockPin = 3;  

const int numPixels = 25;  // Change this if using more than one strand
int stepInterval = 1;
long lastStep = 0;

int op = 1; // for pulse;
int m_intensity = 10;
int program = 0;
int m_red;  // RGB components of the color
int m_green;
int m_blue;
int i=0;
int inc = 1;

Adafruit_WS2801 strip = Adafruit_WS2801(numPixels, dataPin, clockPin);

// select the pins used on the LCD panel
LiquidCrystal lcd(8, 9, 4, 5, 6, 7);

void setup()
{
 lcd.begin(16, 2);              // start the library
 lcd.setCursor(0,0);
 lcd.print("Serial Ledstrip"); // print a simple message
 Serial.begin(9600);
 strip.begin();
 strip.show();
 randomSeed(analogRead(0));
}
 
void loop()
{
 lcd.setCursor(13,1);            // move cursor to second line "1" and 9 spaces over
 lcd.print(millis()/1000);      // display seconds elapsed since power-up
 lcd.setCursor(0,1);
 
  while(Serial.available()) {
   character = Serial.read();
   if (character == ';') {
     lcd.setCursor(0,0);
     lcd.print("cmd: " + content);
     processCommand(content);
     content ="";
   } else {
    content.concat(character);     
   }
 }
 runProgram();
}

/************* Utils Functions ***************/
void processCommand(String command) {
 if (command[1]=='!') {
    switch (command[0]) {
      case 'c': {
        String color = command.substring(2);
        setColor(color);
        break;
      }
      case 'i': {
        String intensity = command.substring(2);
        setIntensity(intensity);
        break;
      }
      case 'p': {
        String program = command.substring(2);
        setProgram(program);
        break;
      }
      
      case 's': {
        String stepInterval = command.substring(2);
        setStep(stepInterval);
        break;
      }
    };
 }  
}

void runProgram() {
  switch (program) {
    case 0: {
      fixcolorProgram();
      break;
    }
    case 1: {
      randomcolorProgram();
      break;
    }
    case 2: {
      pulseProgram();
      break;
    }
    case 3: {
      alternateProgram();
      break;
    }
    case 4: {
      rainbow(stepInterval);
      break;
    }
    case 5: {
      rainbowCycle(stepInterval);
      break;
    }
    default: {
      fixcolorProgram();
    }
  };  
}
 
void setIntensity(String intensity) {
  if (intensity == "up") {
    if (m_intensity < 100) m_intensity +=10;
  } 
  if (intensity == "down") {
    if (m_intensity >= 10) m_intensity -=10;
  } 
  if (intensity != "down" && intensity != "up") {
    m_intensity = intensity.toInt();
  }
  lcd.setCursor(0,1);
  lcd.print("i:" + intensity + "v:"+ m_intensity);
}

void setProgram(String progid) {
  program = progid.toInt();
}

void setStep(String stepVal) {
  stepInterval = stepVal.toInt();
}

void setColor(String color) {
  long number = (long) strtol( &color[0], NULL, 16);
  m_red = number >> 16;
  m_green = number >> 8 & 0xFF;
  m_blue = number & 0xFF;
}

// Create a 24 bit color value from R,G,B
uint32_t Color(byte r, byte g, byte b)
{
  uint32_t c;
  c = r;
  c <<= 8;
  c |= g;
  c <<= 8;
  c |= b;
  return c;
}

//Input a value 0 to 255 to get a color value.
//The colours are a transition r - g -b - back to r
uint32_t Wheel(byte WheelPos)
{
  if (WheelPos < 85) {
    return Color(WheelPos * 3, 255 - WheelPos * 3, 0);
  } else if (WheelPos < 170) {
  WheelPos -= 85;
    return Color(255 - WheelPos * 3, 0, WheelPos * 3);
  } else {
    WheelPos -= 170;
    return Color(0, WheelPos * 3, 255 - WheelPos * 3);
  }
}

/************** programs *****************/
void fixcolorProgram() {
  if (millis() - lastStep > stepInterval) {
    lastStep = millis();
    int r =  map(m_red, 0, 255, 0, m_intensity);
    int g =  map(m_green, 0, 255, 0, m_intensity);
    int b =  map(m_blue, 0, 255, 0, m_intensity);
    uint32_t color = Color(r, g, b);
    
    for(i=0;i<numPixels;i++) {
      strip.setPixelColor(i, color);     
    }
    strip.show();
  } 
}

void pulseProgram() {
  if (millis() - lastStep > stepInterval) {
    lastStep = millis();
    if (m_intensity <= 0) { op = 1; };
    if (m_intensity >= 100) { op = -1; };
    m_intensity += op;
    int r =  map(m_red, 0, 255, 0, m_intensity);
    int g =  map(m_green, 0, 255, 0, m_intensity);
    int b =  map(m_blue, 0, 255, 0, m_intensity);
    uint32_t color = Color(r, g, b);

    for(i=0;i<numPixels;i++) {
      strip.setPixelColor(i, color);     
    }
    strip.show();
  } 
}

void alternateProgram() {
  if (millis() - lastStep > stepInterval) {
    lastStep = millis();
    if (m_intensity == 0) { op = 1; };
    if (m_intensity == 100) { op = -1; };
    m_intensity += op;
    int r =  map(m_red, 0, 255, 0, m_intensity);
    int g =  map(m_green, 0, 255, 0, m_intensity);
    int b =  map(m_blue, 0, 255, 0, m_intensity);
    uint32_t color = Color(r, g, b);
    
    int ir =  map(255-m_red, 0, 255, 0, 100-m_intensity);
    int ig =  map(255-m_green, 0, 255, 0, 100-m_intensity);
    int ib =  map(255-m_blue, 0, 255, 0, 100-m_intensity);
    uint32_t icolor = Color(ir, ig, ib);

    for(i=0;i<numPixels;i++) {
      if (i % 2 == 0) {
        strip.setPixelColor(i, icolor);
      } else {
        strip.setPixelColor(i, color);        
      }

    }
    strip.show();
  } 
}

void randomcolorProgram() {
  if (millis() - lastStep > stepInterval) {
    lastStep = millis();
    
    i = random(numPixels + 1);
    m_red = random(256);
    m_green = random(256);
    m_blue = random(256);
    m_intensity = random(100);
    int r =  map(m_red, 0, 255, 0, m_intensity);
    int g =  map(m_green, 0, 255, 0, m_intensity);
    int b =  map(m_blue, 0, 255, 0, m_intensity);
    uint32_t color = Color(r, g, b);

    strip.setPixelColor(i, color);
    strip.show();
  } 
}

void rainbow(uint8_t wait) {
  int i, j;
  for (j=0; j < 256; j++) { // 3 cycles of all 256 colors in the wheel
    for (i=0; i < strip.numPixels(); i++) {
      strip.setPixelColor(i, Wheel( (i + j) % 255));
    }
    strip.show(); // write all the pixels out
    delay(wait);
  }
}

// Slightly different, this one makes the rainbow wheel equally distributed
// along the chain
void rainbowCycle(uint8_t wait) {
  int i, j;
  for (j=0; j < 256 * 5; j++) { // 5 cycles of all 25 colors in the wheel
    for (i=0; i < strip.numPixels(); i++) {
      // tricky math! we use each pixel as a fraction of the full 96-color wheel
      // (thats the i / strip.numPixels() part)
      // Then add in j which makes the colors go around per pixel
      // the % 96 is to make the wheel cycle around
      strip.setPixelColor(i, Wheel( ((i * 256 / strip.numPixels()) + j) % 256) );
    }
    strip.show(); // write all the pixels out
    delay(wait);
  }
}
