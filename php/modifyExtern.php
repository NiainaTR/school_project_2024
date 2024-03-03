<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    
    <?php
        session_start();
                
        $_SESSION['c'] = isset($_GET['c']) ? $_GET['c'] : null;
        $_SESSION['d'] = isset($_GET['d']) ? $_GET['d'] : null;
        
        if($_SESSION['c'] != null && $_SESSION['d'] != null && $_SESSION['indexModify'] != null){    
            $_SESSION['A'][$_SESSION['indexModify']] = $_SESSION['c'];
            $_SESSION['B'][$_SESSION['indexModify']] = $_SESSION['d'];
            $_SESSION['r'][$_SESSION['indexModify']] = $_SESSION['c'] * $_SESSION['d'];    
        }
    ?>
    <section class='container'>
        <section class='lines' id='table-title'>
           <div class='columns'><p>A</p></div>
            <div class='columns'><p>B</p></div>
            <div class='columns'><p>A X B</p></div>
            <div class='columns'><p>Action</p></div>
        </section>
        <section id='container-list'>
            <?php     
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
            ?>  
    </section>    
</section>

</body>
</html>

