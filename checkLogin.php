<?php
require_once 'dbInfo.php';

session_start();
if(isset($_POST['username'])){
$username=$_POST['username'];
}
if(isset($_POST['password'])){
$password=$_POST['password'];
}
try{

        $conn = new PDO("mysql:host=" . HOST_NAME . ";dbname=" . DATABASE_NAME, USER_NAME, USER_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->exec("SET NAMES 'utf8'");
        $sql = "SELECT * FROM klijenti WHERE username= :username AND password= :password";
        $stm = $conn->prepare($sql);
        $stm->bindValue(':username', $username, PDO::PARAM_STR);
        $stm->bindValue(':password', $password, PDO::PARAM_STR);
        $results = $stm->execute();
        $data = $stm->fetch(PDO::FETCH_ASSOC);


        if($data['obrisan']===1){
            echo json_encode('Nepostojeci korisnik');
        }else {

            if (!empty($data)) {
                $_SESSION['username'] = $data['username'];
                $_SESSION['rights'] = $data['rights'];
                $_SESSION['klijentId'] = $data['idKlijent'];
                echo json_encode($data);
            }  else{
                echo json_encode('Nepostojeci korisnik');
            }
        }



}catch (PDOException $e)
{
    die($e->getTrace());
}





?>




