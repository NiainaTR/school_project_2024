<?php
    session_start();

    if(isset($_SESSION['id']) && isset($_SESSION['pwd'])){
        $num = $_POST['num'];
        $chain = $_POST['chain'];
        $target = $_POST['target'];
        $protocol = $_POST['protocol'];
        $option = $_POST['option'];
        $source = $_POST['source'];
        $destination = $_POST['destination'];
        
        if($destination == "anywhere" && $source == "anywhere"){
            $cmd = "sudo iptables -R ".$chain." ".$num." -p ".$protocol." -j ".$target;
        }
        else if($destination == "anywhere" || $source == "anywhere"){
            $cmd = $destination == "anywhere" ? "sudo iptables -R ".$chain." ".$num." -p ".$protocol." -s ".$source." -j ".$target : "sudo iptables -R ".$chain." ".$num." -p ".$protocol." -d ".$destination." -j ".$target;
        }        
        else{
            $cmd = "sudo iptables -R ".$chain." ".$num." -p ".$protocol." -s ".$source." -d ".$destination." -j ".$target;
        }
        
        echo "$cmd";
        
        $result = shell_exec($cmd);

        header("Location:http://localhost/iptables/dashboard.php");
     }
    else{
        header("Location:http://localhost/iptables");
    }



?>

