import speech_recognition as sr
import time
import unidecode
import sys

pin = sys.argv [1]
cadena1 = 'si'
cadena2 = 'no'
cadena3 = 'sip'
cadena4 = 'shi'

r = sr.Recognizer()

with sr.AudioFile("/opt/opt" + pin + ".wav") as source:
        audio = r.listen(source)
	
try:
		text = r.recognize_google(audio, language='es-PE')
		if cadena1 in text:
			print("1")
		elif cadena2 in text:
			print("0")
		elif cadena3 in text:
			print("1")
		elif cadena4 in text:
			print("1")
 
#                time.sleep(1.5)
#		print(unidecode.unidecode(text.replace(' ','')))
#
#			else:
#				print("0")
except:
	print("2")
