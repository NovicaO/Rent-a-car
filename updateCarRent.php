<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";

session_start();
$klijent= $_SESSION['klijentId'];
$idCar= $_POST['carId'];
$endDate=$_POST['endDate'];
$dateStart= date("Y-m-d");
$ex=1;

try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "UPDATE vozilo SET krajnjiDatum= :endDate, klijent=:klijent WHERE idVozila= :idCar";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':endDate', $endDate, PDO::PARAM_STR);
    $stm->bindValue(':klijent', $klijent, PDO::PARAM_STR);
    $stm->bindValue(':idCar', $idCar, PDO::PARAM_STR);
    $results = $stm->execute();
    $sql2= "INSERT INTO izvestaj(idKlijent, idVozila, pocetniDatum, krajnjiDatum, Extended) VALUES(:klijent, :carId, :pocetniDatum, :datumKraj, :extended)";
    $stm = $conn->prepare($sql2);
    $stm->bindValue(':datumKraj', $endDate, PDO::PARAM_STR);
    $stm->bindValue(':pocetniDatum', $dateStart, PDO::PARAM_STR);
    $stm->bindValue(':klijent', $klijent, PDO::PARAM_STR);
    $stm->bindValue(':carId', $idCar, PDO::PARAM_STR);
    $stm->bindValue(':extended', $ex, PDO::PARAM_STR);
    $results = $stm->execute();
    $sql1= "SELECT krajnjiDatum from vozilo WHERE idVozila= :idCar";
    $stm = $conn->prepare($sql1);
    $stm->bindValue(':idCar', $idCar, PDO::PARAM_STR);
    $results = $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);




}catch (PDOException $e)
{
    echo($e->getMessage());
}
?>