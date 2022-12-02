<?php
require_once 'dbInfo.php';
include "includeRights.php";
session_start();
$datumOd= $_POST['datumOd'];
$datumDo= $_POST['datumDo'];
$raspolozivaVozila = array();
try{

    $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    $sqlVozilo = "SELECT * FROM vozilo";
    $stm = $conn->prepare($sqlVozilo);
    $results = $stm->execute();
    $vozila = $stm->fetchAll(PDO::FETCH_ASSOC);
    $sqlRent = "SELECT * FROM rent";
    $stm = $conn->prepare($sqlRent);
    $results = $stm->execute();
    $rentData = $stm->fetchAll(PDO::FETCH_ASSOC);
    $countVozila= count($vozila);
    $countRent= count($rentData);

    $sqlServisiranje = "SELECT * FROM servisiranje";
    $stm = $conn->prepare($sqlServisiranje);
    $results = $stm->execute();
    $dataServisiranje = $stm->fetchAll(PDO::FETCH_ASSOC);
    $countServisiranje= count($dataServisiranje);

    for($j=0; $j<$countVozila; $j++){
        $raspoloziv = true;
        $ikadRentiran = false;
        for($i=0; $i<$countRent; $i++){
            if($vozila[$j]['idVozila'] == $rentData[$i]['idVozilo']){
                $ikadRentiran = true;
                if($rentData[$i]['pocetniDatum'] < $datumOd){
                    if($rentData[$i]['krajnjiDatum'] < $datumOd){

                    }else{
                        $raspoloziv = false;
                        break;
                    }
                }else{
                    if($rentData[$i]['pocetniDatum'] < $datumDo){
                        $raspoloziv = false;
                        break;
                    }
                }
                if($rentData[$i]['krajnjiDatum'] < $datumDo){
                    if($rentData[$i]['krajnjiDatum'] < $datumOd){

                    }else{
                        $raspoloziv = false;
                        break;
                    }
                }else{
                    if($rentData[$i]['pocetniDatum'] > $datumDo){

                    }else{
                        $raspoloziv = false;
                        break;
                    }
                }
            }else{
                continue;
            }if($vozila[$j]['obrisan']==1){
                $raspoloziv=false;
            }

        }
        for($s=0; $s<$countServisiranje; $s++) {
            if ($vozila[$j]['idVozila'] == $dataServisiranje[$s]['idVozila']) {
                $ikadRentiran = true;
                if ($dataServisiranje[$s]['pocetniDatum'] < $datumOd) {
                    if ($dataServisiranje[$s]['krajnjiDatum'] < $datumOd) {

                    } else {
                        $raspoloziv = false;
                        break;
                    }
                } else {
                    if ($dataServisiranje[$s]['pocetniDatum'] < $datumDo) {
                        $raspoloziv = false;
                        break;
                    }
                }
                if ($dataServisiranje[$s]['krajnjiDatum'] < $datumDo) {
                    if ($dataServisiranje[$s]['krajnjiDatum'] < $datumOd) {

                    } else {
                        $raspoloziv = false;
                        break;
                    }
                } else {
                    if ($dataServisiranje[$s]['pocetniDatum'] > $datumDo) {

                    } else {
                        $raspoloziv = false;
                        break;
                    }
                }

            }else{
                continue;
            }
        }


        if($raspoloziv == true){
            array_push($raspolozivaVozila, $vozila[$j]);
            continue;
        }
        if($ikadRentiran == false){
            array_push($raspolozivaVozila, $vozila[$j]);
            continue;
        }
    }
    $prava=$_SESSION['rights'];
    if($prava==1){
        $prava=1;
    }else{
        $prava=2;
    }

    echo json_encode(array($raspolozivaVozila,$prava));



}catch (PDOException $e)
{
    echo($e->getMessage());
}
?>

