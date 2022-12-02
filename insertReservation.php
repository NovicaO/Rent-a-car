<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$datumOd= $_POST['datumOd'];
$datumDo = $_POST['datumDo'];
$carId= $_POST['idCar'];
$klijent=$_SESSION['klijentId'];
$prava=$_SESSION['rights'];
$vr= 0;


try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    if($prava==1){
        $sql= "INSERT INTO rent(idKlijent, idVozilo, pocetniDatum, krajnjiDatum, vracen, servis) VALUES(:klijent, :carId, :sd, :ed, :vr, :servis) ";
        $stm = $conn->prepare($sql);
        $stm->bindValue(':servis', 1, PDO::PARAM_STR);
        $stm->bindValue(':sd', $datumOd, PDO::PARAM_STR);
        $stm->bindValue(':ed', $datumDo, PDO::PARAM_STR);
        $stm->bindValue(':klijent', $klijent, PDO::PARAM_STR);
        $stm->bindValue(':carId', $carId, PDO::PARAM_STR);
        $stm->bindValue(':vr', $vr, PDO::PARAM_STR);
        $results = $stm->execute();
    }else{
        $sql= "INSERT INTO rent(idKlijent, idVozilo, pocetniDatum, krajnjiDatum, vracen) VALUES(:klijent, :carId, :sd, :ed, :vr) ";
        $stm = $conn->prepare($sql);
        $stm->bindValue(':sd', $datumOd, PDO::PARAM_STR);
        $stm->bindValue(':ed', $datumDo, PDO::PARAM_STR);
        $stm->bindValue(':klijent', $klijent, PDO::PARAM_STR);
        $stm->bindValue(':carId', $carId, PDO::PARAM_STR);
        $stm->bindValue(':vr', $vr, PDO::PARAM_STR);
        $results = $stm->execute();
    }
    echo json_encode("Great");




}catch (PDOException $e)
{
    echo ($e->getMessage());
}
?>