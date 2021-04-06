import mysql.connector
import pafy
import vlc
import time
from mysql.connector.errors import Error

try:
    connection = mysql.connector.connect(host='localhost',
    				     database='DATABASE',
    			 	     user='USER',
    				     password='PASSWORD')
    if connection.is_connected():
        cursor = connection.cursor()
	record = cursor.fetchone()
        cursor.execute("SELECT Name FROM playlist")
        record = cursor.fetchone()
        print record[0]
        print "lost"
except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if (connection.is_connected()):
        cursor.close()
        connection.close()
        print("MySQL connection is closed")
