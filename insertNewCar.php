<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$klijent= 0;
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
    $sql= "INSERT INTO vozilo(nazivVozila, godisteVozila, opisVozila) VALUES(:nazivVozila, :godisteVozila, :ov)";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':nazivVozila', $naziv, PDO::PARAM_STR);
    $stm->bindValue(':godisteVozila', $godiste, PDO::PARAM_STR);
    $stm->bindValue(':ov', $ov, PDO::PARAM_STR);
    $results = $stm->execute();
    $sql1="SELECT * FROM vozilo ORDER BY idVozila DESC LIMIT 1;";
    $stm = $conn->prepare($sql1);
    $results = $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);




}catch (PDOException $e)
{

    echo ($e->getMessage());
}
?>