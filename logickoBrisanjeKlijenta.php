<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$obrisan= $_POST['idObrisan'];
$klijentId= $_POST['klijentId'];
try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql = "UPDATE klijenti SET obrisan= :obrisan WHERE idKlijent= :klijentId";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':klijentId', $klijentId, PDO::PARAM_STR);
    $stm->bindValue(':obrisan', $obrisan, PDO::PARAM_STR);
    $results = $stm->execute();
    $sql1="SELECT * FROM klijenti WHERE idKlijent= :idKlijent";
    $stm = $conn->prepare($sql1);
    $stm->bindValue(':idKlijent', $klijentId, PDO::PARAM_STR);
    $results = $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);


}catch (PDOException $e)
{
    echo($e->getMessage());
}





?>




