<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/modify.css">
    <title>Document</title>
</head>
<body>
    
    <?php
        if(isset($_SESSION['id']) && isset($_SESSION['pwd'])){
            $num = $_POST['num'];
            $chain = $_POST['chain'];
            $target = $_POST['target'];
            $protocol = $_POST['protocol'];
            $option = $_POST['option'];
            $source = $_POST['source'];
            $destination = $_POST['destination'];
            $other = $_POST['other'];


            $tabTarget = ["ACCEPT" , "DROP" , "REJECT"];
            $tabProtocol = ['tcp' , 'udp' , 'icmp'];

            echo "
            <header>  
                <form action='http://localhost/iptables/logout.php' method='post'>
                <button type='submit'>LOGOUT</button>
                </form>
            </header>        
            ";
            
            echo "
                <section>
                <form action='http://localhost/iptables/modify.ext.php' method='post'>
                 <h2>MODIFY RULE</h2>
                 <div>
                    <span>CHAIN : </span><h3>$chain</h3>
                 </div>    
            ";    

            echo "
            <div>
            <p>TARGET : </p>
            <select name='target' id=''>
            ";
            
            foreach ($tabTarget as $t) {
                if($t == trim($target)) {
                    echo "<option value='$t' selected>$t</option>";
                }
                else{
                    echo "<option value='$t'>$t</option>";
                }
            }
            
            echo "
            </select>
            </div>
            ";
            
            echo "
            <div>
            <p>PROTOCOLE : </p>
            <select name='protocol' id=''>
            ";
            
            foreach ($tabProtocol as $p) {
                if($p == $protocol) {
                    echo "<option value='$p' selected>$p</option>";
                }
                else{
                    echo "<option value='$p'>$p</option>";
                }
            }
            
            echo "
            </select>
            </div>
            ";

            echo "
            <div>
            <p>OPTION : </p>            
            <input type='text' value='$option' name='option' required>
            </div>
            <div>
            <p>SOURCE : </p>            
            <input type='text' value='$source' name='source' required>
            </div>
            <div>
            <p>DESTINATION : </p>            
            <input type='text' value='$destination' name='destination' required>
            </div>
            <input type='hidden' value='$chain' name='chain'>
            <input type='hidden' value='$num' name='num'>
            <button type='submit'>MODIFY</button>            
            ";
            
            
            echo "    
                </form>  
                </section>                  
            ";
        }
        else{
            header("Location:http://localhost/iptables");
        }  
    ?>


</body>
</html>

