<?php
    session_start();
    echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <link rel='stylesheet' href='style.css'>
            <title>Document</title>
        </head>
        <body>    
    ";

    $_SESSION['indexModify'] = isset($_GET['indexModify']) ? $_GET['indexModify'] : null;

    if($_SESSION['indexModify'] != null){
        echo "
        <section class='container-modify'>
            <div class='modify'>
            <p>Modification du ligne : {$_SESSION['indexModify']}</p>
            <form action='http://localhost/php_school/modifyExtern.php' method='get'>
                <div class='input-control'>
                    <div>a</div>
                    <input type='number' name='c' value='{$_SESSION['A'][$_SESSION['indexModify']]}' required>
                </div> 
                <div class='input-control'>
                    <div>b</div>
                    <input type='number' name='d' value='{$_SESSION['B'][$_SESSION['indexModify']]}' required>
                </div>
                <input type='hidden' name='index' value='{$_SESSION['indexModify']}' required>
                <button type='submit' id='submit'>submit</button>
            </form>
            </div>
        </section>
        ";
    }
    

    echo "
    </body>
    </html>
    ";
?>


