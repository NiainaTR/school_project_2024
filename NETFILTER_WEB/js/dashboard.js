const listRule = document.querySelectorAll('#container-list .lines');
    const listBtnDelete = document.querySelectorAll('#container-list #btn-delete');
    const listBtnModify = document.querySelectorAll('#container-list #btn-edit');
    const btnSave = document.querySelector('#btn-save');
    const btnCancel = document.querySelector('#btn-cancel');
    
    let tabDataDelete = [];
    
    listBtnModify.forEach((btn , indexBtn) => {
        btn.addEventListener('click' , () => {
            const num = listRule[indexBtn].childNodes[1].textContent
            const chain = listRule[indexBtn].childNodes[3].textContent;
            const target = listRule[indexBtn].childNodes[5].textContent
            const protocol = listRule[indexBtn].childNodes[7].textContent;
            const option = listRule[indexBtn].childNodes[9].textContent
            const source = listRule[indexBtn].childNodes[11].textContent;
            const destination = listRule[indexBtn].childNodes[13].textContent
            const other = listRule[indexBtn].childNodes[15].textContent;

            const formData = {
                num:num,
                chain:chain,
                target:target,
                protocol:protocol,
                option:option,
                source:source,
                destination:destination,
                other:other
            };
            
            console.log(formData);
            
            const form = document.createElement('form');
        
            form.action = "http://localhost/iptables/modify.php";
            form.method = "POST";

            if(formData){
                const input1 = document.createElement('input');
                input1.type = "hidden";
                input1.name = `num`;
                input1.value = `${formData.num}`;
                
                const input2 = document.createElement('input');
                input2.type = "hidden";
                input2.name = `chain`;
                input2.value = `${formData.chain}`;
                
                const input3 = document.createElement('input');
                input3.type = "hidden";
                input3.name = `target`;
                input3.value = `${formData.target}`;
                
                const input4 = document.createElement('input');
                input4.type = "hidden";
                input4.name = `protocol`;
                input4.value = `${formData.protocol}`;
                
                const input5 = document.createElement('input');
                input5.type = "hidden";
                input5.name = `option`;
                input5.value = `${formData.option}`;
                
                const input6 = document.createElement('input');
                input6.type = "hidden";
                input6.name = `source`;
                input6.value = `${formData.source}`;
                
                const input7 = document.createElement('input');
                input7.type = "hidden";
                input7.name = `destination`;
                input7.value = `${formData.destination}`;

                const input8 = document.createElement('input');
                input8.type = "hidden";
                input8.name = "other";
                input8.value = `${formData.other}`;

                form.append(input1);
                form.append(input2);
                form.append(input3);
                form.append(input4);
                form.append(input5);
                form.append(input6);
                form.append(input7);
                form.append(input8);
                
                form.style.display = "none";
                document.body.appendChild(form);

                form.submit();  
            }
        })
    })


    listBtnDelete.forEach((btn , indexBtn) => {
        btn.addEventListener('click' , () => {
            console.log(indexBtn);
            let num = listRule[indexBtn].childNodes[1].textContent
            let chain = listRule[indexBtn].childNodes[3].textContent;
            
            tabDataDelete.push({num:num , chain:chain});
            
            if(confirm("Do you want to confirm your action ?")){
                const form = document.createElement('form');
                form.action = "http://localhost/iptables/delete.ext.php";
                form.method = "POST";

                if(tabDataDelete.length > 0){
                    tabDataDelete.forEach((data , index) => {
                        const input = document.createElement('input');
                        input.type = "hidden";
                        input.name = `input${index}`;
                        input.value = `${data.num}+${data.chain}`;
                        form.append(input);
                    })
                    
                    form.style.display = "none";
                    document.body.appendChild(form);

                    form.submit();  
                }
            }
            else{
                window.location.reload();
            }

        })
    })
