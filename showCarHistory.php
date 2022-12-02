<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$carID= $_POST['carId'];


try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql = "SELECT idKlijent from rent where idVozilo= :idVozila GROUP by idKlijent";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':idVozila', $carID, PDO::PARAM_STR);
    $results = $stm->execute();
    $iData = $stm->fetchAll(PDO::FETCH_ASSOC);
    $lista= array();
    foreach($iData as $klijent){
        $k= $klijent['idKlijent'];
        $sql1= "select * from klijenti WHERE idKlijent='$k'";
        $stm = $conn->prepare($sql1);
        $results = $stm->execute();
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        array_push($lista, $data);


    }

    echo json_encode($lista);


}catch (PDOException $e)
{
    echo($e->getMessage());
}
?>