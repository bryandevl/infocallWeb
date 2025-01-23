#!/usr/local/bin/python3
import os
import time
import unidecode
import sys

try:
    import speech_recognition as sr
except Exception as e:
    raise e

from datetime import datetime
#from datetime import datetime

npar = len(sys.argv)
pathFile = sys.argv [1]
now = datetime.now()
nowFormat = now.strftime("%Y-%m-%d %H:%M:%S")

#yearFolder = sys.arg [2]
#monthFolder = sys.arg [3]
#dayFolder = sys.arg [4]

#print(pathFile)
r = sr.Recognizer()

#with sr.AudioFile("/opt/opt" + pin + ".wav") as source:
with sr.AudioFile(pathFile) as source:
    audio = r.listen(source)

try:
    text = r.recognize_google(audio, language='es-MX')
    text = text.lower()
    #fh = open("translate.txt", "w+")
    #fh = open("translate.txt", "a")
    #fh.write(dt_string)
    #fh.write(text)
    #fh.write("\n")
    print(text)
    #fh.close()
#    time.sleep(1.5)
#    print(unidecode.unidecode(text.replace(' ','')))
except:
    print("2/")
