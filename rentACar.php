<?php
require_once 'dbInfo.php';
include "includeRights.php";

session_start();
$datumKraj= $_POST['datum'];
$dateStart = date('Y-m-d');
$klijent=$_SESSION['klijentId'];
$carId= $_POST['carId'];
$iznajmljen=1;
$vracen=1;


try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "INSERT INTO rent(idKlijent, idVozilo, pocetniDatum, krajnjiDatum, vracen) VALUES(:klijent, :carId, :pocetniDatum, :datumKraj, :vracen) ";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':datumKraj', $datumKraj, PDO::PARAM_STR);
    $stm->bindValue(':pocetniDatum', $dateStart, PDO::PARAM_STR);
    $stm->bindValue(':klijent', $klijent, PDO::PARAM_STR);
    $stm->bindValue(':carId', $carId, PDO::PARAM_STR);
    $stm->bindValue(':vracen', $vracen, PDO::PARAM_STR);
    $results = $stm->execute();
    $sql1= "UPDATE vozilo SET iznajmljen=1 WHERE  idVozila = :carId";
    $stm = $conn->prepare($sql1);
    $stm->bindValue(':carId', $carId, PDO::PARAM_STR);

    $results = $stm->execute();
    echo json_encode("Great");




}catch (PDOException $e)
{
    echo ($e->getMessage());
}
?>