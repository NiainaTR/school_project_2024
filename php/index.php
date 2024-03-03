<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <form action='http://localhost/php_school/index.php' method='get'>
        <div class='input-control'>
            <div>a</div>
            <input type='number' name='a' required>
        </div> 
        <div class='input-control'>
            <div>b</div>
            <input type='number' name='b' required>
        </div>
        <button type='submit' id='submit'>submit</button>
    </form>

    <?php
        session_start();
        $_SESSION['a'] = isset($_GET['a']) ? $_GET['a'] : null;
        $_SESSION['b'] = isset($_GET['b']) ? $_GET['b'] : null;
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
                if($_SESSION['a'] && $_SESSION['b']){ 
                        for($i=0;$i<$_SESSION['b'];$i++)
                        {
                            $_SESSION['A'][$i] = $i+1;
                            $_SESSION['B'][$i] = $_SESSION['a'];
                            $_SESSION['r'][$i] = $_SESSION['A'][$i] * $_SESSION['B'][$i];
                            
                            $background_color = $i % 2 == 0 ? "bisque" : "pink";
                            
                            $a = $_SESSION['A'][$i];
                            $b  = $_SESSION['B'][$i];
                            $r = $_SESSION['r'][$i];
                            
                            echo "
                            <div class='lines' style='background-color: $background_color;'>
                                <div class='columns'><p>$a</p></div>
                                <div class='columns'><p>$b</p></div>
                                <div class='columns'><p>$r</p></div>
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