<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
        <section class='container'>
            <section class='lines' id='table-title'>
            <div class='columns'><p>A</p></div>
                <div class='columns'><p>B</p></div>
                <div class='columns'><p>A X B</p></div>
                <div class='columns'><p>Action</p></div>
            </section>
        <section id='container-list'>

    <?php

    session_start();
    
    $_SESSION["indexDelete"] = isset($_GET["indexDelete"]) ? $_GET["indexDelete"] : null;

    if($_SESSION["indexDelete"] !== null)
    {   
        unset($_SESSION['A'][$_SESSION['indexDelete']]);
        $_SESSION['A'] = array_values($_SESSION['A']);
        
        unset($_SESSION['B'][$_SESSION['indexDelete']]);
        $_SESSION['B'] = array_values($_SESSION['B']);
       
        unset($_SESSION['r'][$_SESSION['indexDelete']]);
        $_SESSION['r'] = array_values($_SESSION['r']);
        
        $_SESSION['b'] -= 1;
       
        for($i=0;$i<$_SESSION['b'];$i++)
        {
            echo "
            <div class='lines' style='background-color: $background_color;'>
                <div class='columns'><p>{$_SESSION['A'][$i]}</p></div>
                <div class='columns'><p>{$_SESSION['B'][$i]}</p></div>
                <div class='columns'><p>{$_SESSION['r'][$i]}</p></div>
                <div class='columns action'><a href='./modify.php?indexModify=$i' class='btn-edit'><img src='./edit.png' alt='edit'></a><a href='./delete.php?indexDelete=$i'><img src='./trash.png' alt='delete'></a></div>
            </div>
            ";                        
        }
    }

    ?>
    </section>
    </section>
</body>
</html>