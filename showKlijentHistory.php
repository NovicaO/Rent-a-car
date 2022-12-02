<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$klijentId= $_POST['klijentId'];


try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql = "SELECT idVozilo from rent where idKlijent= :idKlijent GROUP by idVozilo";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':idKlijent', $klijentId, PDO::PARAM_STR);
    $results = $stm->execute();
    $iData = $stm->fetchAll(PDO::FETCH_ASSOC);
    $lista= array();
    foreach($iData as $car){
        $c= $car['idVozilo'];
        $sql1= "select * from vozilo WHERE idVozila='$c'";
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