<?php
 
/* geek.e-spin.pl */
/* class.Authorization.php */
 
class Authorization {
 
private $_user;
private $_password;
private $_dbpdo;
 
// konstruktor pobiera identyfikator połączenia z bazą
public function __construct() {
try
{
global $pdo;
$this->_dbpdo = $pdo;
} 
catch(PDOException $error)
{
return $error->getMessage();
}
}
 
// ustawiamy metody dostępowe set i get
public function setUser($user) {
$this->_user = $user;
}
 
public function setPassword($password) {
$this->_password = $password; 
}
 
public function getUser() {
return $this->_user;
}
 
public function getPassword() {
return $this->_password;
}
 
// walidujemy pola formularza
public function validateUsr() {
if ( ($this->getUser())=='' || ($this->getPassword())=='' ) {
return false;
} else {
return true;
}
}
 
// hashujemy hasło
public function Hash() {
return sha1(md5($this->getPassword().$this->getPassword()));
}
 
public function Login() 
{
$password = $this->Hash();
// sprawdzamy czy login i hasło są w tabeli users
$sql = $this->_dbpdo->prepare("SELECT * FROM users WHERE login=:user AND password=:password LIMIT 1");
$sql->bindValue(':user',$this->getUser(),PDO::PARAM_STR);
$sql->bindValue(':password',$password,PDO::PARAM_STR);
$sql->execute();
 
// jeżeli znaleziono rekord to ustawiamy sesje
if ($row = $sql->fetch()) 
{
session_start();
$_SESSION['id_usr'] = $row['id'];
$_SESSION['login_usr'] = $row['login'];
 
// dobrą praktyką jest ponowne wygenerowanie identyfikatora sesji 
// ochroni nas to przed atakami session fixation
ini_set('session.cookie_httponly', 1); 
return true; 
} else {
return false;
}
// zamykamy połączenie z bazą
$sql->closeCursor();
}
 
// metoda wylogowuje użytkownika
public function LogOut() {
session_start();
session_unset(); // usuwamy sesje
session_destroy(); // niszczymy sesje
}
 
}
 
?>