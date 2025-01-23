import speech_recognition as sr
import time
import unidecode
import sys

resp = ""
npar = len(sys.argv)
pin = sys.argv [1]
if npar == 3:
    dato1 = sys.argv [2]
elif npar == 4:
    dato1 = sys.argv [2]
    dato2 = sys.argv [3]
elif npar == 5:
    dato1 = sys.argv [2]
    dato2 = sys.argv [3]
    dato3 = sys.argv [4]
elif npar == 6:
    dato1 = sys.argv [2]
    dato2 = sys.argv [3]
    dato3 = sys.argv [4]
    dato4 = sys.argv [5]
elif npar == 7:
    dato1 = sys.argv [2]
    dato2 = sys.argv [3]
    dato3 = sys.argv [4]
    dato4 = sys.argv [5]
    dato5 = sys.argv [6]

r = sr.Recognizer()

with sr.AudioFile("/opt/opt" + pin + ".wav") as source:
    audio = r.listen(source)

try:
    text = r.recognize_google(audio, language='es-MX')
    text = text.lower()
    if npar == 3:
        if text.find(dato1) != -1:
            resp = "1"
        else:
            resp = "2"
    elif npar == 4:
        if text.find(dato1) != -1:
            resp = "1"
        elif text.find(dato2) != -1:
            resp = "1"
        else:
            resp = "2"
    elif npar == 5:
        if text.find(dato1) != -1:
            resp = "1"
        elif text.find(dato2) != -1:
            resp = "1"
        elif text.find(dato3) != -1:
            resp = "1"
        else:
            resp = "2"
    elif npar == 6:
        if text.find(dato1) != -1:
            resp = "1"
        elif text.find(dato2) != -1:
            resp = "1"
        elif text.find(dato3) != -1:
            resp = "1"
        elif text.find(dato4) != -1:
            resp = "1"
        else:
            resp = "2"
    elif npar == 7:
        if text.find(dato1) != -1:
            resp = "1"
        elif text.find(dato2) != -1:
            resp = "1"
        elif text.find(dato3) != -1:
            resp = "1"
        elif text.find(dato4) != -1:
            resp = "1"
        elif text.find(dato5) != -1:
            resp = "1"
        else:
            resp = "2"
    else:
        resp = "2"

    if text.find("no") != -1:
        resp = "0"
    elif text.find("equivocado") != -1:
        resp = "0"
    else:
        resp = "1"

    print(resp + "/" + text)
#    time.sleep(1.5)
#    print(unidecode.unidecode(text.replace(' ','')))
except:
    print("2/")
