<?php
 
/* config.php */
 
// parametry połączenia z bazą
$db["Host"] = "localhost";
$db["User"] = "user";
$db["Password"] = "**********";
$db["Name"] = "baza";
 
function connect() {
global $pdo;
global $db; 
try {
// dzięki PDO możemy połączyć się z dowolną bazą :)
$pdo = new PDO('mysql:host='.$db["Host"].';dbname='.$db["Name"], $db["User"], $db["Password"]);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $error)
{
echo $error->getMessage();
}
}
 
?>