<?php
require_once 'dbInfo.php';
include "includeRights.php";
include "adminAccess.php";
session_start();
$datumOd= $_POST['datumOd'];
$datumDo= $_POST['datumDo'];

try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sql = "SELECT * FROM  vozilo
    WHERE EXISTS (SELECT * FROM rent WHERE ((pocetniDatum > :pocetniDatum AND pocetniDatum <:krajnjiDatum)
    OR (krajnjiDatum < :pocetniDatum AND krajnjiDatum > :krajnjiDatum)) AND vozilo.idVozila=rent.idVozilo)
    OR NOT EXISTS (SELECT * FROM rent WHERE vozilo.idVozila=rent.idVozilo) ";
    $stm = $conn->prepare($sql);
    $stm->bindValue(':krajnjiDatum', $datumDo, PDO::PARAM_STR);
    $stm->bindValue(':pocetniDatum', $datumOd, PDO::PARAM_STR);
    $results = $stm->execute();
    $data = $stm->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);

}catch (PDOException $e)
{
    echo($e->getMessage());
}
?>

