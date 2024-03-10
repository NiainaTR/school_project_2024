<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_SESSION['id']) && isset($_SESSION['pwd'])){
            
            $chain = $_POST['chain'];
            $defaultTarget = $_POST['defaultTarget'];
            
            $isProtocol = $_POST['protocol-check'];
            $protocol = $_POST['protocol'];


            $isMatch = $_POST['match-check'];
            $isMac = $_POST['mac-check'];

            $mac = $_POST['mac'];
            $isMultiport = $_POST['multiport-check'];
            
            $isPortSource = $_POST['port-source-check'];
            $sports = $_POST['sports'];

            $isPortDest = $_POST['port-destination-check'];
            $dports = $_POST['dports'];


            $isDestination = $_POST['dest-check'];
            $destination = $_POST['destination'];
            
            $isSource = $_POST['source-check'];
            $source = $_POST['source'];
            
            $isInput = $_POST['input-interface-check'];
            $input = $_POST['input'];
            
            $isOutput = $_POST['output-interface-check'];
            $output = $_POST['output'];
            
            $target = $_POST['target'];

            $cmd = "";
            
            if($chain && $defaultTarget){
                $cmd = "sudo iptables -P $chain $defaultTarget";
                shell_exec($cmd);
            }
            
            if($isProtocol){
                $cmd = "sudo iptables -A $chain -p $protocol";
            }
            
            if($isMatch){
                if($isMac && $mac){
                    $cmd = $cmd." -m mac --mac-source $mac";
                }
                
                if($isMultiport && $isPortSource && $sports){
                    $cmd = $cmd." -m multiport --sports $sports";
                }
                if($isMultiport && $isPortDest && $dports){
                    $cmd = $cmd." -m multiport --dports $dports";   
                }
            }

            if($isDestination && $destination){
                $cmd = $cmd." -d $destination";
            }

            if($isSource && $source){
                $cmd = $cmd." -s $source";
            }

            if($isInput && $input){
                $cmd = $cmd." -i $input";
            }


            if($isOutput && $output){
                $cmd = $cmd." -o $output";    
            }
            
            if($isProtocol || $isMatch || $isMultiport || $isDestination || $isSource || $isInput || $isOutput){
                $cmd = $cmd." -j $target 2> ./files/error.txt";    
            }

            $cmd = $cmd." 2> ./files/error.txt";

            shell_exec($cmd);

            $_SESSION['chain'] = $chain;
            $_SESSION['policy'] = $defaultTarget;
                
            $pf = fopen("./files/error.txt" , "r");
            
            while (!feof($pf)){
                $ligne = fgets($pf);
                if($ligne){
                    $error = $ligne;
                    break;
                } 
            }  
            
            
            $error = trim(explode(':' , $error)[1]);
            echo "<script>
                if(\"$error\"){
                    alert(\"$error\")
                    window.location.href = 'http://localhost/iptables/add.php'
                }
                else{
                    window.location.href = 'http://localhost/iptables/dashboard.php'    
                }
                </script>";
        
            fclose($pf);
            
            
        }
        else{
            header("Location:http://localhost/iptables/");
        }
    ?>
</body>
</html>