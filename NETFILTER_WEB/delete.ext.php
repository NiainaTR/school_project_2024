<?php
    session_start();

    if(isset($_SESSION['id']) && isset($_SESSION['pwd'])){
        $post_data = $_POST;

        foreach ($post_data as $key => $value) {
            $tab = explode('+' , $value);
            $num = $tab[0];
            $chain = $tab[1];
            $cmd = "sudo iptables -D $chain $num";
            shell_exec($cmd);
        }
        header("Location:http://localhost/iptables/dashboard.php");
    } 
    else{
        header("Location:http://localhost/iptables");
    }

?>