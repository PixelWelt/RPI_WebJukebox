# RPI_WebJukebox

Dieses Projekt ist ein Webbasierter Mediaplayer, welcher für das Jugendzentrum Gonsenheim entwickelt wurde.

## 1. install lamp stack and python
## 2. inside phpmyadmin create multiple tables 
    Source
        - Name (string)
        - isActive (bool)
    playlist
        - Name (string) 
    WebRadio
        -Name (string)
        - URL (string)
        - isSelected  (bool)

## 3. into Source insert following Data:
    INSERT INTO `Source` (`Name`, `isActive`) Values (`Radio`, `0`);
    INSERT INTO  `Source` (`Name`, `isActive`) Values (`YouTube`, `0`);
## 4. start dbPlayer.py on Startup