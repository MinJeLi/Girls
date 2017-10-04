import requests
from bs4 import BeautifulSoup
import mysql.connector as mariadb

from SQLInfo import UserName, Passowrd, DBName

mariadb_connection = mariadb.connect(user=UserName, password=Passowrd, database=DBName)
cursor = mariadb_connection.cursor()
cursor.execute("TRUNCATE TABLE ImgLink")

re=requests.get('https://ptt-beauty-images.herokuapp.com')

soup=BeautifulSoup(re.text.encode('utf-8'), "html.parser")

for link in soup.findAll('a', class_='img-thumbnail'):
    try:
        cursor.execute("INSERT INTO ImgLink (ImagesLink) VALUES ('{0}')".format(link['href']))	
        print link['href']
    except mariadb.Error as error:
        print("Error: {}".format(error))
    mariadb_connection.commit()

mariadb_connection.close()
