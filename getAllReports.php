<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();


try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "select DISTINCT rent.idRent, rent.servis,  rent.krajnjiDatum, rent.pocetniDatum, klijenti.username, klijenti.idKlijent, vozilo.idVozila ,vozilo.nazivVozila from rent, klijenti, vozilo WHERE rent.idKlijent= klijenti.idKlijent AND rent.idVozilo=vozilo.idVozila ORDER BY rent.idRent ASC";
    $stm = $conn->prepare($sql);
    $results = $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);




}catch (PDOException $e)
{
    echo($e->getMessage());
}
?>