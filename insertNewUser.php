<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$ime= $_POST['ime'];
$prezime= $_POST['prezime'];
$jmbg= $_POST['jmbg'];
$username= $_POST['username'];
$password= $_POST['password'];
$rights= $_POST['rights'];
$idKlijent=$_POST['idKlijent'];
$obrisan= 0;

try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "INSERT INTO klijenti(ime, prezime, jmbg, username, password, rights, obrisan) VALUES(:ime, :prezime, :jmbg, :username, :password, :rights, :obrisan)";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':ime', $ime, PDO::PARAM_STR);
    $stm->bindValue(':prezime', $prezime, PDO::PARAM_STR);
    $stm->bindValue(':jmbg', $jmbg, PDO::PARAM_STR);
    $stm->bindValue(':username', $username, PDO::PARAM_STR);
    $stm->bindValue(':password', $password, PDO::PARAM_STR);
    $stm->bindValue(':rights', $rights, PDO::PARAM_STR);
    $stm->bindValue(':obrisan', $obrisan, PDO::PARAM_STR);
    $results = $stm->execute();
    $sql1="SELECT * FROM klijenti ORDER BY idKlijent DESC LIMIT 1;";
    $stm = $conn->prepare($sql1);
    $results = $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);




}catch (PDOException $e)
{
    echo ($e->getMessage());
}
?>