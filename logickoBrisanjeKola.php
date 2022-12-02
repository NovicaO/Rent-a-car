<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$obrisan= $_POST['idObrisan'];
$carId= $_POST['carId'];
try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql = "UPDATE vozilo SET obrisan= :obrisan WHERE idVozila= :carId";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':carId', $carId, PDO::PARAM_STR);
    $stm->bindValue(':obrisan', $obrisan, PDO::PARAM_STR);
    $results = $stm->execute();
    $sql1="SELECT * FROM vozilo WHERE idVozila= :idCar";
    $stm = $conn->prepare($sql1);
    $stm->bindValue(':idCar', $carId, PDO::PARAM_STR);
    $results = $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);


}catch (PDOException $e)
{
    echo($e->getMessage());
}





?>




