<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";

session_start();
$name= $_POST['ime'];
$prezime= $_POST['prezime'];
$jmbg= $_POST['jmbg'];
$username= $_POST['username'];
$password= $_POST['password'];
$rights= $_POST['rights'];
$idKlijent=$_POST['idKlijent'];

try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "UPDATE klijenti set ime= :ime, prezime=:prezime, jmbg= :jmbg, username= :username, password= :password, rights= :rights WHERE idKlijent= :klijentId";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':ime', $name, PDO::PARAM_STR);
    $stm->bindValue(':prezime', $prezime, PDO::PARAM_STR);
    $stm->bindValue(':jmbg', $jmbg, PDO::PARAM_STR);
    $stm->bindValue(':username', $username, PDO::PARAM_STR);
    $stm->bindValue(':password', $password, PDO::PARAM_STR);
    $stm->bindValue(':rights', $rights, PDO::PARAM_STR);
    $stm->bindValue(':klijentId', $idKlijent, PDO::PARAM_STR);
    $results = $stm->execute();
    echo json_encode("Success");




}catch (PDOException $e)
{
    die($e->getTrace());
}
?>