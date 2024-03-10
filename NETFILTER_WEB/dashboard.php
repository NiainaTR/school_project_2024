<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/dashboard.css">
    <title>Document</title>
</head>
<body>
    <?php
        require_once("functions.php");
    
        if(isset($_SESSION['id']) && isset($_SESSION['pwd'])){
            $username = $_SESSION['id'];    
            echo "
            <header>  
                <form action='http://localhost/iptables/logout.php' method='post'>
                <button type='submit'>LOGOUT</button>
                </form>
            </header>        
            ";
                
            echo 
            "<section class='greeting'>
                <h1>Hi ! $username  &#x1F44B;</h1>
                <h2>So , ready to secure your machine ! &#x1F5A5; &#x1F512;</h2>     
            </section>";
            $inputPolicy = get_policy(1);
            $inputNbr = get_nbr(1);

            $forwardPolicy = get_policy(2);
            $forwardNbr = get_nbr(2);

            $outputPolicy = get_policy(3);
            $outputNbr = get_nbr(3);

            echo "
                <section class='rule'>        
                    <div class='box' id='box1'>
                        <div><h4>CHAIN</h4><h1>INPUT</h1><h4 style='margin-top:5px;'>POLICY : $inputPolicy</h4><h4 style='margin-top:5px;'>RULES : $inputNbr</h4><form action='http://localhost/iptables/add.php' method='post'><input type='hidden' name='chain' value='INPUT'><input type='hidden' name='policy' value='$inputPolicy'><button><img src='./assets/plus.png'/>Add rule</button></form></div>
                    </div>
                    <div class='box' id='box2'>
                        <div><h4>CHAIN</h4><h1>FORWARD</h1><h4 style='margin-top:5px;'>POLICY : $forwardPolicy</h4><h4 style='margin-top:5px;'>RULES : $forwardNbr</h4><form action='http://localhost/iptables/add.php' method='post'><input type='hidden' name='chain' value='FORWARD'><input type='hidden' name='policy' value='$forwardPolicy'><button><img src='./assets/plus.png'/>Add rule</button></form></div>
                </div>
                    <div class='box' id='box3'>
                        <div><h4>CHAIN</h4><h1>OUTPUT</h1><h4 style='margin-top:5px;'>POLICY : $outputPolicy</h4><h4 style='margin-top:5px;'>RULES : $outputNbr</h4><form action='http://localhost/iptables/add.php' method='post'><input type='hidden' name='id' value='%s'><input type='hidden' name='chain' value='OUTPUT'><input type='hidden' name='policy' value='$outputPolicy'><button><img src='./assets/plus.png'/>Add rule</button></form></div>
                </div>
                </section>
            ";  

            getAllUtils();
           
            /*
            <th>N°</th>"
                        "<th>CHAIN</th>"
                        "<th>TARGET</th>"
                        "<th>PROTOCOL</th>"
                        "<th>OPTION</th>"
                        "<th>SOURCE</th>"
                        "<th>DESTINATION</th>"
                        "<th>OTHER</th>"
                        "<th>DELETE</th>"
            
            
            */
            echo 
            "
            <section class='container'>
                <section class='lines' id='table-title'>
                    <div class='columns'><p>Num</p></div>
                    <div class='columns'><p>CHAIN</p></div>
                    <div class='columns'><p>TARGET</p></div>
                    <div class='columns'><p>PROTOCOL</p></div>
                    <div class='columns'><p>OPTION</p></div>
                    <div class='columns'><p>SOURCE</p></div>
                    <div class='columns'><p>DESTINATION</p></div>
                    <div class='columns' id='column-other'><p>OTHER</p></div>
                    <div class='columns'><p>ACTION</p></div>
                </section>            
            ";
            echo "<section id='container-list'>";
            $pf = fopen("./files/rules.txt" , "r");
            
            while (!feof($pf)){
                $ligne = fgets($pf);
                if($ligne){
                    $columns = explode('  ' , $ligne);
                    echo "
                    <div class='lines'>
                    <div class='columns'><p>$columns[0]</p></div>
                    <div class='columns'><p>$columns[1]</p></div>
                    <div class='columns'><p>$columns[2]</p></div>
                    <div class='columns'><p>$columns[3]</p></div>
                    <div class='columns'><p>$columns[4]</p></div>
                    <div class='columns'><p>$columns[5]</p></div>
                    <div class='columns'><p>$columns[6]</p></div>
                    <div class='columns'><p>$columns[7]</p></div>
                    <div class='columns action'><button id='btn-edit'><img src='./assets/edit.png' alt='edit'></button><button id='btn-delete'><img src='./assets/trash.png' alt='delete'></button></div>
                    </div>
                    ";
                }
            }
            echo "
            </section>
            </section>
            ";
        }
        else{
            header("Location:http://localhost/iptables");
        }  
    ?>

<script src="./js/dashboard.js"></script>
</body>
</html>


