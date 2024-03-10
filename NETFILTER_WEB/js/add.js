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

