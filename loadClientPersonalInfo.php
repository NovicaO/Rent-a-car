<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$idKlijent=$_SESSION['klijentId'];

try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql= "SELECT * from klijenti where idKlijent= :idKlijent";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':idKlijent', $idKlijent, PDO::PARAM_STR);
    $results = $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);




}catch (PDOException $e)
{
    die($e->getTrace());
}
?>