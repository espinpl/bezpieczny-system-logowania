<?php
 
/* login.php */
 
if (isset($_POST["submit"])) { // jeżeli kliknięto przycisk formularza
 
connect(); // nawiązujemy połączenie z bazą
require_once 'class.Authorization.php'; // dołączamy klasę
 
// pobieramy dane z pól formularza (user i password)
$user = strip_tags(trim($_POST["user"]));
$password = strip_tags(trim($_POST["password"]));
 
// tworzymy egzemplarz klasy i ustawiamy zmienne do przetwarzania
$log = new Authorization();
$log->setUser($user);
$log->setPassword($password);
 
// walidujemy dane
if (!$log->validateUsr()) {
echo '<p class="error">Wprowadź login i hasło!</p>'; 
} else if (!$log->Login()) {
echo '<p class="error">Nieprawidłowy login i/lub hasło!</p>'; 
} else {
session_start();
header('Location: main.phtml'); 
// jeśli autoryzacja jest poprawna robimy przekierowanie na stronę main.phtml
// lub cokolwiek innego... 
}
 
}
 
?>