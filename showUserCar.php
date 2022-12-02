<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";

session_start();
$klijent=$_SESSION['klijentId'];

try{


    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql = "SELECT * FROM rent, vozilo  where idKlijent=:klijent AND rent.idVozilo= vozilo.idVozila AND vracen=0";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':klijent', $klijent, PDO::PARAM_STR);
    $results = $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);




}catch (PDOException $e)
{
    echo ($e->getMessage());
}
?>