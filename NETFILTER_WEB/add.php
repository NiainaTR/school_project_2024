<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/add.css">
    <title>Document</title>
</head>
<body>
<?php
    require_once("functions.php");

        if(isset($_SESSION['id']) && isset($_SESSION['pwd'])){    
            $chain = $_POST['chain'];
            $policy = $_POST['policy'];
            
            if($chain && $policy){
                displayInterfaceAdd($chain , $policy);
            }
            else{
                if(isset($_SESSION['chain']) && isset($_SESSION['policy'])){
                    $chain = $_SESSION['chain'];
                    $policy = $_SESSION['policy'];
                    displayInterfaceAdd($chain , $policy);
                }
            }
        }
        else{
            header("Location:http://localhost/iptables");
        }  
    ?>

<script src="./js/add.js"></script>
</body>
</html>

