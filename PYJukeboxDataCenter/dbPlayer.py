import mysql.connector
import pafy
import vlc
import time
from mysql.connector.errors import Error



url = "NULL"

try:
	connection = mysql.connector.connect(host='localhost',
					     database='DATABASE',
				 	     user='USER',
					     password='PASSWORD')
   	if connection.is_connected():
		db_Info = connection.get_server_info()
		print("Connected to MySQL Server version ", db_Info)
		cursor = connection.cursor()
		cursor = connection.cursor(buffered=True)
		connection.commit()
		while True:

			cursor.execute("SELECT Name FROM Source WHERE isActive=1")
			activeSrc = cursor.fetchall()
			connection.commit()

			print "checking LINK"
			cursor = connection.cursor()
			connection.commit()
			cursor.execute("SELECT Name FROM playlist Limit 1")
			record = cursor.fetchone()
			connection.commit()
			print type(record)
			print record
			if len(activeSrc) != 0:
				if 'YouTube' in activeSrc[0]:
					print "SRC: Youtube"
					if record != None:
						print record[0]
						
						
						if "youtube" in record[0] or "youtu.be" in record[0]:
							print record[0]
							print"link is good"
							url = record[0]
							video = pafy.new(url)
							best = video.getbestaudio()
							playurl = best.url
							Instance = vlc.Instance()
							player = Instance.media_player_new()
							Media = Instance.media_new(playurl)
							Media.get_mrl()
							player.set_media(Media)						
							player.play()
							playing = set([1])
							time.sleep(1.5)
							duration = player.get_length() / 1000
							time_left = True
							time.sleep(1.5)
							while time_left == True:
								song_time = player.get_state()
								print song_time
								if str(song_time) != "State.Playing":
									time_left = False
								cursor.execute("SELECT Name FROM playlist")	
								record = cursor.fetchall()
								connection.commit()
								print record
								print len(record)
								if record == None or len(record) == 0:
									player.pause()
									time_left = False
								if len(record) > 0:
									print len(record)
									if url not in record[0]:
										player.pause()
										time_left = False 
								cursor.execute("SELECT Name FROM Source Where isActive=1")	
								activeSrc = cursor.fetchall()
								connection.commit()
								if not'YouTube' in activeSrc[0]:
									player.pause()
									time_left = False
								
								time.sleep(1) # Performance Boost

							#time.sleep(duration)
						if record != None:
							cursor.execute("DELETE FROM playlist LIMIT 1")
							connection.commit()
								
						time.sleep(1.5)								
				elif 'Radio' in activeSrc[0]:
					print "SRC: Radio"
					cursor.execute("SELECT URL FROM WebRadio WHERE isSelected=1")
					record = cursor.fetchone()
					print record
					if record != None:
						url = record[0]
						player = vlc.MediaPlayer(url)
						player.play()
						while True:
							connection.commit()
							print "playing...."
							cursor.execute("SELECT Name FROM Source WHERE isActive=1")
							Status = cursor.fetchone()
							print Status
							connection.commit()
							if Status[0] == 'YouTube':
								print "Source Switch"
								player.stop()
								del player 
								break
							cursor.execute("SELECT URL FROM WebRadio WHERE isSelected=1")
							newRecord = cursor.fetchone()
							if newRecord != None:
								if len(newRecord) > 0:
									if newRecord[0] != record[0]:
										player.stop()
										del player
										break
							connection.commit()
							time.sleep(1.5)
except Error as e:
    print("Error while connecting to MySQL", e)
finally:
    if (connection.is_connected()):
        cursor.close()
        connection.close()
        print("MySQL connection is closed")
 
print "test"                      
