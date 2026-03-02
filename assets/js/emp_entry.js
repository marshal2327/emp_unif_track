document.addEventListener('DOMContentLoaded', ()=>{
    console.log('EMP ENTYR PAGE PARSED' );

    console.log(base_url);
    console.log(base_url+'assets/images/nouserimg.jpg');

    // GLOBAL VAR FOR SAVE ENTRY
    let form_datas = new FormData();

    // FOR SAVE TAGS
    let prebpy_val = document.getElementById('prepby_val');
    let remarks_val = document.getElementById('remarks_val');

    // POINT THE INPUT CURSOR INITIALLY
    remarks_val.onclick = ()=>{
        // remarks_val.setSelectionRange(0,0);
        // remarks_val.removeEventListener('click');
    }


    // UTILS

    async function compressImg(file) {
    
        const img = await createImageBitmap(file);
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        const maxWidth = 800;
        // const scale = maxWidth / img.width;

        canvas.width = img.width;
        canvas.height = img.height;

        ctx.drawImage(img, 0,0, canvas.width, canvas.height);

        return new Promise(resolve =>{
            canvas.toBlob(blob => {
                resolve(blob);
            },'image/jpeg', 0.2);
        });
        
    }
    
    // CLOSE OPTION BOX WHEN CLICK CLOSE BUTTON
    function closebyx(){   

        emp_option.classList.remove('show');
        emp_sel.value='';
        input_img.src = base_url+'assets/images/downarrow.png'; 
        emp_card.style.opacity=0;
        entry_card.style.opacity=0;
        pic_btn.textContent='Take Photo';
        cap_img.src='';
        prebpy_val.value='';
        remarks_val.value='';

        // CLEAR THE FORM DATAS
        form_datas.forEach((v,k) => {
            form_datas.delete(k);
        });

        console.log(form_datas);
        
        disables.forEach(dis => {
            dis.disabled = true;
        
        });

    }


    // SELECT EMP ID
    let emp_card = document.getElementById('emp_card');
    let entry_card = document.getElementById('entry_card');
    let emp_sel = document.getElementById('emp_sel');
    let emp_option = document.getElementById('emp_options');
    let input_img = document.querySelector('#input_box img');
    // let pic_btn = document.getElementById('pic_btn');
    let disables = document.querySelectorAll('.disable'); 

    let timeout;

    emp_sel.addEventListener('input', ()=>{

        clearTimeout(timeout);

        emp_card.style.opacity=0;
        entry_card.style.opacity=0;

        timeout = setTimeout(() => {

            if(emp_sel.value.trim() !== ''){

                input_img.src= base_url+'assets/images/closebox.png';

                input_img.addEventListener('click', closebyx);

                let query = emp_sel.value.trim().toLowerCase();
                emp_option.innerHTML='';
                
                // console.log(emp_sel.value);

                let matches = emp_datas.filter(itm => String(itm.MID).trim().toLowerCase().includes(query));
                // console.log(matches.length);

                if(matches.length !== 0){
                        
                    matches.forEach(res => {
                        let p = document.createElement('p');
                        p.textContent = res.MID;
                        p.id=res.CREMPSTMASTID;
                        emp_option.appendChild(p);
                        p.addEventListener('click',()=> fetch_emp(res));
                    });
                    
                }else{
                    let p = document.createElement('p');
                    p.textContent = 'No User Found !!'
                    p.style.color='#ff083f';
                    emp_option.appendChild(p);
                }

                if(emp_option.classList.contains('show')) emp_option.classList.remove('show'); emp_option.classList.add('close');
                if(emp_option.classList.contains('close')) emp_option.classList.remove('close'); emp_option.classList.add('show');

            }else{
                input_img.src=base_url+'assets/images/downarrow.png';
                emp_option.classList.remove('show');
            }

        }, 300);

    });

    // FOR SHOW THE CAPTURED IMG
    let upic_img_inp = document.getElementById('upic_img_inp');
    let cap_img = document.getElementById('cap_img');
    let pic_btn = document.getElementById('pic_btn');
    let cap_img_box = document.getElementById('cap_img_box');


    // WEBCAM PROCESS

    let camera_box = document.getElementById('camera_dis');
    // let cap_res = document.getElementById('cap_res');
    let capture = document.getElementById('capture');

    pic_btn.onclick = ()=>{

        cap_img.src= base_url+'assets/images/nouserimg.jpg';
        cap_img_box.style.display='none';
        capture.textContent='Capture';
        pic_btn.textContent='Take Photo';
        form_datas.set('uimg', null);


        Webcam.set({
            width:200,
            height:300,
            image_format:'jpeg',
            jpeg_quality:90,
            constraints:{
                // user -> FOR FRONT CAM
                facingMode:'environment'
            }
        });

        Webcam.attach('#camera_dis');

        capture.onclick = function(){
            Webcam.snap(function(data_uri){
                Webcam.reset();
                // console.log(data_uri);
                cap_img.src=data_uri;
                cap_img_box.style.display='flex';
                capture.textContent='Captured';
                pic_btn.textContent='Captured'

                // CONVERT BS4 STR TO BLOB
                fetch(data_uri)
                .then(res => res.blob())
                .then(blob => {
                    let imgFile = new File([blob], "cap.jpeg", {type:blob.type});
                    form_datas.set('uimg', imgFile);
                    console.log(imgFile);
                })

                // CLOSE MODAL
                let modalElement = document.getElementById('takePic');
                let modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();
            })
        }
    }


    // pic_btn.onclick = (d)=>{

    //     d.preventDefault();
    //     console.log(cap_img_box);

    //     upic_img_inp.click();

    //     upic_img_inp.addEventListener('change',async (d)=>{
            
    //         d.preventDefault();
    //         // cap_img.src=base_url+'assets/images/nouserimg.jpg';
    //         upic_img_inp.src='';

    //         let img = d.target.files[0];
    //         console.log();

    //         if(!img){
    //             pic_btn.textContent = 'Take Photo';
    //             cap_img.src=base_url+'assets/images/nouserimg.jpg';
    //             cap_img_box.style.display='none';
    //             img = '';
    //             form_datas.set('uimg', null);
    //             // cap_img_box.style.display='none';
    //             return;
    //         }

    //         let blob = await compressImg(img);
    //         let compImg = new File([blob], "cap.jpeg", {type: "image/jpeg"});
    //         console.log(compImg);


    //         const reader = new FileReader();

    //         reader.onload = ()=>{
    //             cap_img.src = URL.createObjectURL(compImg);
    //             cap_img_box.style.display="flex";
    //             form_datas.set('uimg', compImg);
    //             console.log(Object.fromEntries(form_datas.entries()))
    //             pic_btn.textContent = 'Captured';  
    //             URL.revokeObjectURL(compImg); 
    //         }

    //         reader.readAsDataURL(img);

    //     });
        
    // }


    // let upic_img_inp = document.getElementById('upic_img_inp');
    // let upic_box = document.getElementById('upic_box');
    // let upic_img_val = document.getElementById('upic_img_val');
    
    // upic_img_inp.addEventListener('change',async (d)=>{

    //     upic_img_val.src='';
    //     upic_box.style.display='none';

    //     const img = d.target.files[0];

    //     if(!img){
    //         pic_btn.textContent = 'Take Photo';
    //         return;
    //     }

    //     let blob = await compressImg(img);
    //     let compImg = new File([blob], "cap.jpeg", {type: "image/jpeg"});
    //     // console.log(compImg);


    //     // const reader = new FileReader();
        
    //     // reader.onload = ()=>{
    //         upic_img_val.src = URL.createObjectURL(compImg);
    //         upic_box.style.display = 'block';
    //         form_datas.set('uimg', compImg);
    //     //     // console.log(Object.fromEntries(form_datas.entries()))
    //         pic_btn.textContent = 'Captured';  
    //         URL.revokeObjectURL(compImg); 
    //     // }

    //     // reader.readAsDataURL(img);

    // });


    
    // SELECT EMP AND GET SHOW EMP DETAILS

    let emp_img = document.getElementById('emp_img');
    let empid_val = document.getElementById('empid_val');
    let mcempid_val = document.getElementById('mcempid_val');
    let dept_val = document.getElementById('dept_val');
    let design_val = document.getElementById('design_val');
    let div_val = document.getElementById('div_val');



    async function fetch_emp(res){

        console.log(res);   
        
        // CLOSE ANIMATION
        if(emp_option.classList.contains('show')) emp_option.classList.remove('show'); emp_option.classList.add('close');
        
        // PUT TEXT ON INPUT BOX
        emp_sel.value = res.MID;

        // GET USER DETAILS AND FILL ON UI
        const result = await fetch(base_url+`Main/get_user_det?recid=${encodeURIComponent(res.CREMPSTMASTID)}&docid=${encodeURIComponent(res.DOCID)}&mcempid=${encodeURIComponent(res.MCEMPID)}`);
        const data = await result.json();

        // console.log(data);
        // return
        
        if(data != null){   
            
            
            console.log(data);
            // return  
            
            emp_img.src = data['user_img'].IMG ? 'data:image/'+ data['user_img'].FTYPE + ';base64,' + data['user_img'].IMG : base_url + 'assets/images/nouserimg.jpg';
            empid_val.textContent = data['user_info'].EMPID ? String(data['user_info'].EMPID) : '-';
            mcempid_val.textContent = data['user_info'].MCEMPID ? data['user_info'].MCEMPID : '-';
            dept_val.textContent = data['user_info'].DEPT ? data['user_info'].DEPT : '-';
            design_val.textContent = data['user_info'].DESIGNATION ? data['user_info'].DESIGNATION : '-';
            div_val.textContent = data['user_info'].DIVISION ? data['user_info'].DIVISION : '-';


            if(data['user_info']['CREMPSTMASTID']){
                let user = data['user_info'];
                
                form_datas.set('recid', user.CREMPSTMASTID);
                form_datas.set('docid', user.DOCID);
                form_datas.set('empid', user.EMPID);
                form_datas.set('mcempid', user.MCEMPID);
                form_datas.set('dept', user.DEPT);
                form_datas.set('division', user.DIV_MASTID);
                form_datas.set('design', user.DESIGNATION);
                form_datas.set('uimg', null);
                
            }
            // form_datas = {
            //     recid: data['user_info'][0].CREMPSTMASTID,
            //     empid: data['user_info'][0].EMPID,
            //     mcempid: data['user_info'][0].MCEMPID,
            //     dept: data['user_info'][0].DEPT,
            //     design: data['user_info'][0].DESIGNATION
            // };

            // console.log(Object.fromEntries(form_datas.entries()));
            

            setTimeout(() => {
                emp_card.style.opacity=1;
                entry_card.style.opacity=1;

                disables.forEach(dis => {
                    dis.disabled = false;
                
                });

            }, 250);
        }
        
    }

    // SAVE CREDENTIALS ON DB

    let save_entry_btn = document.getElementById('save_entry_btn');
    let overlay = document.getElementById('overlay');
    let lottie = document.getElementById('lottie');
    let save_label = document.getElementById('save_label');

    save_entry_btn.addEventListener('click', async ()=>{


        if(!prebpy_val.value || !remarks_val.value){
            alert("Fields shouldn't be Empty !!");
            return
        }


        save_entry_btn.disabled=true;
        
        overlay.style.display='flex';
        // lottie.src=base_url+'assets/gif/loading.json';
        setTimeout(() => {
            lottie.play();
            overlay.style.opacity=1;
        }, 100);
        
    
        if(!form_datas){
            alert('Fill All Details !!');
            return
        }

        console.log(Object.fromEntries(form_datas.entries()));
        
        try{

            const resp = await fetch(base_url+'Main/unif_entry', {
                method :'POST',
                body : form_datas
            })

            if(!resp.ok){
                throw new Error('Post of Form Datas Failed!');
            }

            const result = await resp.json();
            console.log(result);

        
            if(result['status']){
                console.log('Save Success');

                save_entry_btn.disabled=false;

                // FOR ANIMATION
                setTimeout(() => {
                    lottie.load(base_url+'assets/gif/Success.json');
                    lottie.play();
                    save_label.textContent='Saved Successfully !';
                }, 100);
               
            
                setTimeout(() => {
                    overlay.style.opacity=0;
                }, 1900);
            
                setTimeout(() => {
                    window.location.reload();
                }, 2000);

                
            }else{
                alert('Save Failed : ', result['message']);
                return;
            }

            }
            catch(err){
                console.error('Post Failed', err);
                alert('Error Occured :', err);
                return;
            }



    });


})