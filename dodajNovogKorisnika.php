<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$name= $_POST['name'];
$prezime= $_POST['lastname'];
$jmbg= $_post['jmbg'];
$username= $_POST['username'];
$password= $_POST['pwd'];
$rights= $_POST['rights'];


try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "INSERT INTO klijenti (ime, prezime, jmbg, username, password, rights) VALUES (:ime,:prezime,:jmbg, :username, :password, :rights)";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':ime', $name, PDO::PARAM_STR);
    $stm->bindValue(':prezime', $prezime, PDO::PARAM_STR);
    $stm->bindValue(':jmbg', $jmbg, PDO::PARAM_STR);
    $stm->bindValue(':username', $username, PDO::PARAM_STR);
    $stm->bindValue(':password', $password, PDO::PARAM_STR);
    $stm->bindValue(':rights', $rights, PDO::PARAM_STR);
    $results = $stm->execute();
    echo json_encode("SUCCESS");




}catch (PDOException $e)
{
    die($e->getTrace());
}
?>