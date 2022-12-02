<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$idCar= $_POST['idCar'];
$naziv= $_POST['naziv'];
$godiste= $_POST['godiste'];
$ov= $_POST['ov'];

if(!$klijent){
    $klijent=0;
}
try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "UPDATE vozilo SET nazivVozila= :nazivVozila, godisteVozila= :godisteVozila, opisVozila= :ov WHERE idVozila= :idCar";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':nazivVozila', $naziv, PDO::PARAM_STR);
    $stm->bindValue(':godisteVozila', $godiste, PDO::PARAM_STR);
    $stm->bindValue(':ov', $ov, PDO::PARAM_STR);
    $stm->bindValue(':idCar', $idCar, PDO::PARAM_STR);
    $results = $stm->execute();
    echo json_encode("Success");




}catch (PDOException $e)
{
    echo($e->getMessage());
}
?>