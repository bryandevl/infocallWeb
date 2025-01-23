#!/usr/local/bin/python3
import os
import time
import unidecode
import sys
import pathlib
import mysql.connector as mysql
import json
from datetime import datetime
try:
    import speech_recognition as sr
except Exception as e:
    raise e

def translateFileToText(voicePath, txtTranslatePath):
    r = sr.Recognizer()
    result = ""
    with sr.AudioFile(voicePath) as source:
            audio = r.listen(source)
    try:
        text = r.recognize_google(audio, language='es-MX', show_all=False)
        if type(text) is list:
            text = str(text)
        else:
            text = str(text).upper()
        currentDirectoryFile = os.path.dirname(voicePath)
        fileName = os.path.basename(voicePath)
        nowFormat = dateTimeNow()

        fh = open(txtTranslatePath, "a")
        lineTmp = "["+nowFormat+"]|["+fileName+"]:"+text
        fh.write(lineTmp)
        fh.write("\n")
        fh.close()
        
        print(text)
        print("----------------------\n")
        result = 1
    except sr.UnknownValueError:
        print(sr.UnknownValueError)
        print("Could not understand audio")
        result = 0

    except sr.RequestError as e:
        print("Could not request results. check your internet connection")
        result = -1
    return result

def dateTimeNow():
    dateTimeTmp = ""
    now = datetime.now()
    dateTimeTmp = now.strftime("%Y-%m-%d %H:%M:%S")
    return dateTimeTmp

pathCurrent = pathlib.Path(__file__).parent.resolve()
#Read DB Credentials
with open(str(pathCurrent)+'/dbCredentials.json') as f:
    jsonString = json.load(f)

#DB Connection
connection = mysql.connect(
    host = jsonString["host"],
    user = jsonString["user"],
    passwd = jsonString["password"],
    database = jsonString["database"]
)
cursor = connection.cursor(dictionary=True)
#Load Upload Latest
queryLastUploadTranslate = "SELECT * FROM upload_process_translate WHERE is_process = 0 LIMIT 5"
cursor.execute(queryLastUploadTranslate)
uploadTranslateHeader = cursor.fetchall()

for record in uploadTranslateHeader:
    #Process Record By Record
    queryDetail = "SELECT * FROM upload_process_translate_detail WHERE upload_process_translate_id = "+str(record["id"])+" AND process_status = 'REGISTER' "
    cursor.execute(queryDetail)
    uploadTranslateDetail = cursor.fetchall()
    totalProcess = 0
    totalFailed = 0
    startProcess = dateTimeNow()

    queryUpdate = "UPDATE upload_process_translate SET date_start_process='"+str(startProcess)+"' WHERE id='"+str(record["id"])+"' "
    try:
        cursor.execute(queryUpdate)
        connection.commit()
    except Exception as e:
        connection.rollback()

    for recordTwo in uploadTranslateDetail:
        tmpTranslate = translateFileToText(recordTwo["file_path"], record["translate_path"])
        print("translate = "+str(tmpTranslate))

        tmpStatus = "REGISTER"
        if tmpTranslate == 1:
            tmpStatus = "PROCESS"
            totalProcess+=1
        else:
            tmpStatus = "FAILED"
            totalFailed+=1
        
        queryUpdate = "UPDATE upload_process_translate_detail SET translate_text='"+str(tmpTranslate)+"', process_status='"+tmpStatus+"', updated_at='"+dateTimeNow()+"' WHERE id = '"+str(recordTwo["id"])+"'"
        try:
            cursor.execute(queryUpdate)
            connection.commit()
        except:
            connection.rollback()
    
    finishProcess = dateTimeNow()
    queryUpdateHeader = "UPDATE upload_process_translate SET is_process='1', date_finish_process='"+finishProcess+"', total_files_process='"+str(totalProcess)+"', total_files_failed='"+str(totalFailed)+"' WHERE id='"+str(record["id"])+"'"
    try:
        cursor.execute(queryUpdateHeader)
        connection.commit()
    except Exception as e:
        connection.rollback()
connection.close()