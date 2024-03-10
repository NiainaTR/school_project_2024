<?php
    function get_policy($n){
        if($n == 1) $result = shell_exec("sudo iptables -L INPUT | grep 'Chain' | awk '{print $4}'");
        if($n == 2) $result = shell_exec("sudo iptables -L FORWARD | grep 'Chain' | awk '{print $4}'");
        if($n == 3) $result = shell_exec("sudo iptables -L OUTPUT | grep 'Chain' | awk '{print $4}'");
        
        if($result[0] == 'A') return "ACCEPT";
        if($result[0] == 'R') return "REJECT";
        
        return "DROP";
    }
    
    function get_nbr($n){
        if($n == 1) $result = shell_exec("sudo iptables -L INPUT |wc -l");
        if($n == 2) $result = shell_exec("sudo iptables -L FORWARD |wc -l");
        if($n == 3) $result = shell_exec("sudo iptables -L OUTPUT |wc -l");
        return (int)$result - 2;
    }

    function getAllUtils(){
        shell_exec("./code");
    }


    function displayInterfaceAdd($chain , $policy){
            
        $tabPolicy = ["ACCEPT" , "DROP" , "REJECT"];

        echo "
        <header>  
            <form action='http://localhost/iptables/logout.php' method='post'>
            <button type='submit'>LOGOUT</button>
            </form>
        </header>        
        ";
        
        echo "
            <section>
            <form action='http://localhost/iptables/add.ext.php' method='post'>
            <h2>ADD RULE</h2>
            <div>
                <span>CHAIN : </span><h3 style='margin-left:10px;'>$chain</h3>
            </div>    
        ";    
        
        echo "
            <div>
            <p>DEFAULT POLICY :</p>
            <select name='defaultTarget' id=''>
        ";    
        
        foreach ($tabPolicy as $t) {
            if($t == trim($policy)) {
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
                <p>PROTOCOLES : </p>
                <input type='checkbox' id='protocol-check' name='protocol-check'>
            </div>
        ";
        
        echo "
            <section class='list-protocol'>
                <select name='protocol' id=''>
                    <option value='all'>ALL</option>
                    <option value='tcp'>TCP</option>
                    <option value='udp'>UDP</option>
                    <option value='icmp'>ICMP</option>
                </select>
            </section>
        ";
        
    
        echo "
        <div>
            <p>MATCH : </p>
            <input type='checkbox' id='match-check' name='match-check'>
        </div>
        ";

        echo "
            <section class='list-match'>
                <div>
                    <p>MAC : </p>
                    <input type='checkbox' name='mac-check' id='mac-check'>    
                </div>
                <div>
                    <p>MULTIPORT : </p>
                    <input type='checkbox' name='multiport-check' id='multiport-check'>    
                </div>
            </section>
        ";

        echo "
            <section class='list-mac-source'>
                <div>
                    <p>MAC SOURCE : </p>
                    <input type='text' name='mac'>    
                </div>
            </section>
        ";
        

        echo "
            <section class='list-multiport'>
                <div>
                    <p>Source Port : </p>
                    <input type='checkbox' name='port-source-check' id='port-source-check'>    
                </div>
                <div>
                    <p>Destination Port : </p>
                    <input type='checkbox' name='port-destination-check' id='port-destination-check'>    
                </div>
            </section>
        ";
        
        echo "
            <section class='list-sports'>
                <div>
                    <p>SPORTS : </p>
                    <input type='text' name='sports'>    
                </div>
            </section>
        ";
        echo "
            <section class='list-dports'>
                <div>
                    <p>DPORTS : </p>
                    <input type='text' name='dports'>    
                </div>
            </section>
        ";
        
        

        echo "
        <div>
            <p>DESTINATION : </p>
            <input type='checkbox' name='dest-check' id='dest-check'>
        </div>
        ";
        echo "
            <section class='input-destination'>
                <div>
                    <input type='text' name='destination'>    
                </div>
            </section>
        ";

        echo "
        <div>
            <p>SOURCE : </p>
            <input type='checkbox' name='source-check' id='source-check'>
        </div>
        ";

        



        echo "
            <section class='input-source'>
                <div>
                    <input type='text' name='source'>    
                </div>
            </section>
        ";

        echo "
        <div>
            <p>INPUT INTERFACE : </p>
            <input type='checkbox' name='input-interface-check' id='input-interface-check'>
        </div>
        ";
        

        echo "
            <section class='input-interface '>
                <div>
                <select name='input' id=''> 
            ";
            $fp = fopen('./files/interfaces.txt' , "r");
            
            if ($fp) {
                while (($interface = fgets($fp)) !== false) {
                    $interface = substr($interface , 0 , -2);
                    echo "<option value='$interface'>$interface</option>";
                }
                
                fclose($fp);
            } else {
                echo "Impossible d'ouvrir le fichier.";
            }
            echo "  
                    </select>
                    </div>
                </section>
            ";

        echo "
        <div>
            <p>OUTPUT INTERFACE : </p>
            <input type='checkbox' name='output-interface-check' id='output-interface-check'>
        </div>
        ";
        
        echo "
            <section class='output-interface'>
                <div>
                <select name='output' id=''> 
            ";
            $fp = fopen('./files/interfaces.txt' , "r");
            
            if ($fp) {
                while (($interface = fgets($fp)) !== false) {
                    $interface = substr($interface , 0 , -2);
                    echo "<option value='$interface'>$interface</option>";
                }
                
                fclose($fp);
            } else {
                echo "Impossible d'ouvrir le fichier.";
            }
            echo "  
                    </select>
                    </div>
                </section>
            ";        
            echo "                                
                <div>
                <p>TARGET : </p>
                <select name='target' id=''>
                    <option value='ACCEPT'>ACCEPT</option>
                    <option value='DROP'>DROP</option>
                    <option value='REJECT'>REJECT</option>
                </select>
                </div>
                    <input type='hidden' name='chain' value='$chain'>
                <div>
                    <button type='submit'>ADD</button> 
                </div>
                </form>  
                </section>                  
            ";
    }

?>