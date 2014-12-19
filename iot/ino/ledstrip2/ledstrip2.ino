#include <SPI.h>
#include <Adafruit_WS2801.h>
#include <LiquidCrystal.h>

String content = "";
char character;

int dataPin = 2;      
int clockPin = 3;  

const int numPixels = 25;  // Change this if using more than one strand
const int stepInterval = 1;
long lastStep = 0;

int m_intensity = 10;
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
 updateLedstrip();
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
    };
 }  
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

void setProgram(String program) {
  lcd.setCursor(0,1);
  lcd.print(program);lcd.print(" ");
}

void setColor(String color) {
  long number = (long) strtol( &color[0], NULL, 16);
  m_red = number >> 16;
  m_green = number >> 8 & 0xFF;
  m_blue = number & 0xFF;
}

void updateLedstrip() {
  if (millis() - lastStep > stepInterval) {
    lastStep = millis();
    
    i += inc;
    if (i == numPixels) inc = -1;
    if (i == 0 ) inc = 1;

    int r =  map(m_red, 0, 255, 0, m_intensity);
    int g =  map(m_green, 0, 255, 0, m_intensity);
    int b =  map(m_blue, 0, 255, 0, m_intensity);
    uint32_t color = Color(r, g, b);

    strip.setPixelColor(i, color);
    strip.show();
  } 
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
