<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
define('MyConst', TRUE);
session_start();
$carId= $_POST['carId'];


if(!$klijent){
    $klijent=0;
}
try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "SELECT * from vozilo where idVozila= :carId  ";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':carId', $carId, PDO::PARAM_STR);
    $results = $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);




}catch (PDOException $e)
{
    echo ($e->getMessage());
}
?>