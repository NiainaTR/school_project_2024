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

    <script>
        
        const protocolCheck = document.querySelector('#protocol-check');
        const listProtocol = document.querySelector('.list-protocol');
        showHideDiv(protocolCheck , listProtocol);
        
        const matchCheck = document.querySelector("#match-check");
        const listMatch = document.querySelector('.list-match');
        showHideDiv(matchCheck , listMatch);
        


        const macCheck = document.querySelector('#mac-check');
        const listMacSource = document.querySelector(".list-mac-source");
        showHideDiv(macCheck , listMacSource);


        const multiportCheck = document.querySelector('#multiport-check');
        const listMultiport = document.querySelector('.list-multiport');
        showHideDiv(multiportCheck , listMultiport);

        const portSourceCheck = document.querySelector('#port-source-check');
        const listSports = document.querySelector('.list-sports');
        showHideDiv(portSourceCheck , listSports);

        const portDestinationCheck = document.querySelector('#port-destination-check');
        const listDports = document.querySelector('.list-dports');
        showHideDiv(portDestinationCheck , listDports);

        const destCheck = document.querySelector('#dest-check');
        const inputDestination = document.querySelector('.input-destination');
        showHideDiv(destCheck , inputDestination);
        
        const sourceCheck = document.querySelector('#source-check');
        const inputSource = document.querySelector('.input-source');
        showHideDiv(sourceCheck , inputSource);
        
        const inputInterfaceCheck = document.querySelector('#input-interface-check');
        const inputInterface = document.querySelector('.input-interface');
        showHideDiv(inputInterfaceCheck , inputInterface);
        
        
        const outputInterfaceCheck = document.querySelector('#output-interface-check');
        const outputInterface = document.querySelector('.output-interface');
        showHideDiv(outputInterfaceCheck , outputInterface);





        function showHideDiv(check , el){
            el.style.display = "none";
            check.addEventListener('change' , (e) =>{
                el.style.display = e.target.checked ? "block" : "none";
            })
        }


    </script>


</body>
</html>

