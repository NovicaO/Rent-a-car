<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$klijent= $_SESSION['klijentId'];
$cena= $_POST['cena'];
$promena= $_POST['promene'];
$pocetniDatum= $_POST['pocetniDatum'];
$idKola=$_POST['idKola'];
$krajnjiDatum= date("Y-m-d");

try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "INSERT INTO servisiranje(pocetniDatum, krajnjiDatum, promene, cena, idVozila) VALUES(:pocetniDatum, :krajnjiDatum, :promene, :cena, :idVozila)";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':pocetniDatum', $pocetniDatum, PDO::PARAM_STR);
    $stm->bindValue(':krajnjiDatum', $krajnjiDatum, PDO::PARAM_STR);
    $stm->bindValue(':cena', $cena, PDO::PARAM_STR);
    $stm->bindValue(':promene', $promena, PDO::PARAM_STR);
    $stm->bindValue(':idVozila', $idKola, PDO::PARAM_STR);
    $results = $stm->execute();
    $sql1= "UPDATE rent SET vracen=1, krajnjiDatum=:krajnjiDatum WHERE idVozilo=:idVozilo";
    $stm = $conn->prepare($sql1);
    $stm->bindValue(':idVozilo', $idKola, PDO::PARAM_STR);
    $stm->bindValue(':krajnjiDatum', $krajnjiDatum, PDO::PARAM_STR);
    $results = $stm->execute();
    echo json_encode("SUCCESS");




}catch (PDOException $e)
{

    echo ($e->getMessage());
}
?>