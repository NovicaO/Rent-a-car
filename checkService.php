<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
define('MyConst', TRUE);
session_start();

$date= date("Y-m-d");
$cars= array();
try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "SELECT * from servisiranje";
    $stm = $conn->prepare($sql);
    $results = $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($data as $currentService){
        if($currentService['pocetakServisiranja']==$date){
            $selectCar="SELECT * from vozilo where idVozila = :idVozila";
            $stm = $conn->prepare($selectCar);
            $stm->bindValue(':idVozila', $currentService['idVozila'], PDO::PARAM_STR);
            $results = $stm->execute();
            $dataSelected = $stm->fetch(PDO::FETCH_ASSOC);
            array_push($cars, $dataSelected);
        }else{

        }

    }
    if(count($cars)!=0){
        echo json_encode($cars);
    }else{
        echo json_encode("NO");
    }
}catch (PDOException $e)
{
    echo ($e->getMessage());
}
?>