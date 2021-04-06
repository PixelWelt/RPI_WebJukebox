<!DOCTYPE html>
<html lang="de">
<head>

    <meta charset="UTF-8">
    <title>GOFI-JukeBox</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="Controls">
        
        <form action="index.php" method='get'>
        
        <fieldset>
                <h1>YouTube</h1>
                <input type="url" name="url"></input> 
                <input type="submit" value="Abspielen"></input>
        
            
            
            <input type="submit" name="clearFirstChild" value="Ersten Song von Playlist löschen">    
            <input type="submit" class="button" name="clearList" value="Playlist leeren" />
    
    
    <table class="Playlist">
    
        <?php
            $servername = "localhost";
            $username = "USER";
            $password = "PASSWORD"; 
            $dbname = "DATABASE";
            $conn = new mysqli($servername,$username, $password,$dbname );
            
            if(isset($_GET["url"])){
                
                $sqlCommand = "INSERT INTO `playlist` (`Name`) Values ('".$_GET["url"]."');";
                $sqlCommandResult = $conn->query($sqlCommand);
                $sqlCommand = "UPDATE `Source` SET isActive=1 Where Name='YouTube'; ";
                $sqlCommandResult = $conn->query($sqlCommand);
                $sqlCommand = "UPDATE `Source` SET isActive=0 Where Name='Radio';";
                $sqlCommandResult = $conn->query($sqlCommand);
            }
            if(isset($_GET["clearList"])){
                $sqlCommand = "DELETE FROM `playlist`;";
                $sqlCommandResult = $conn->query($sqlCommand);
            }
            if(isset($_GET["clearFirstChild"])){
                $sqlCommand = "DELETE FROM `playlist` Limit 1;";
                $sqlCommandResult = $conn->query($sqlCommand);
            }
            
            if(isset($_GET["ChannelName"])){
                $sqlCommand = "UPDATE `Source` SET isActive=0 Where Name='YouTube'; ";
                $sqlCommandResult = $conn->query($sqlCommand);
                $sqlCommand = "UPDATE `Source` SET isActive=1 Where Name='Radio';";
                $sqlCommandResult = $conn->query($sqlCommand);
                $sqlCommand = "UPDATE `WebRadio` SET `isSelected`=0 WHERE 1;";
                $sqlCommandResult = $conn->query($sqlCommand);   
                $sqlCommand = "UPDATE `WebRadio` SET `isSelected`=1 WHERE Name='".$_GET["ChannelName"]."';";
                $sqlCommandResult = $conn->query($sqlCommand);
                
            }else if(isset($_GET["ChannelURL"])&& $_GET["ADDEDChannelName"] != ""){
                $sqlCommand = "INSERT INTO `WebRadio`(`Name`, `URL`, `isSelected`) VALUES ('". $_GET["ADDEDChannelName"] ."','".$_GET["ChannelURL"]."',0)";
                $sqlCommandResult = $conn->query($sqlCommand);
                
                
            }
            


            $sqlCommand = "SELECT * FROM `playlist`;";
            $sqlCommandResult = $conn->query($sqlCommand);
            
	
            if($sqlCommandResult->num_rows > 0){
                
                echo " <tr> <td> # </td> <td>Name</td> </tr>";
                $rowCount = 0;
                while($row = $sqlCommandResult->fetch_assoc()) 
                {
                    echo "<tr> <td> #".$rowCount ."</td> <td>". $row["Name"] . "</td> </tr> " ;
                    $rowCount ++;
                }
                
                
            }
	//$url = strtok($url, '?');
        
    echo"</table>";
    echo"    </fieldset>
    </form>
</div>";
    
    echo"<fieldset>";
    echo"<table>";
    echo "<h1>Radio</h1>";
    echo"<form action='index.php' method='get'>";           
                    $sqlCommand = "SELECT * FROM `WebRadio`;";
                    $sqlCommandResult = $conn->query($sqlCommand);
                    if($sqlCommandResult->num_rows > 0){
                                
                        echo " <tr> <td></td><td> Name</td> <td>URL</td> </tr>";
                        while($row = $sqlCommandResult->fetch_assoc()) 
                        {
                            echo "<tr> <td><input type='radio' name='ChannelName' name='RadioChannel' value='".$row["Name"]."'</td><td> ".$row["Name"]."</td> <td>".$row["URL"]. "</td> </tr> " ;
                        }
                        
                        echo"</input> <br> Name: <input type='Text' name='ADDEDChannelName'></input>
                        </input> <br> URL: <input type='url' name='ChannelURL'></input>"; 
              
                    echo" <input type='submit'></input> <br>";  
                    }
                    echo"<tr>";
    
             
                    
    echo "</form>";
    echo"</table></fieldset>
        ";
    ?>    
</body>
</html>
