<?php 
    session_start();

    $username = $_POST['id'];
    $pwd = $_POST['pwd'];
    
    if($username && $pwd){
        if($username == "tsanta" && $pwd == "azerty"){
            $_SESSION['id'] = $username;
            $_SESSION['pwd'] = $pwd;
            header("Location:http://localhost/iptables/dashboard.php");
        }
        else{
            header("Location:http://localhost/iptables/");
        }
    }

?>