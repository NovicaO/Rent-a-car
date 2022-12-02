<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$currentSession= $_SESSION['klijentId'];
$currentDate= date("Y-m-d");
$idCar= $_POST['carId'];
$iz=0;
try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "UPDATE vozilo, rent SET krajnjiDatum= :krajnjiDatum, vracen= 1 WHERE idVozila= :idCar AND idKlijent= :klijent AND vracen =0";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':krajnjiDatum', $currentDate, PDO::PARAM_STR);
    $stm->bindValue(':idCar', $idCar, PDO::PARAM_STR);
    $stm->bindValue(':klijent', $currentSession, PDO::PARAM_STR);
    $results = $stm->execute();
    echo json_encode("Success");




}catch (PDOException $e)
{
    echo ($e->getMessage());
}
?>