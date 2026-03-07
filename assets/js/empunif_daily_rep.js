document.addEventListener('DOMContentLoaded', ()=>{
    console.log('EMP UNIF DAILY REPORT PARSED');
    // console.log(base_url);


    
    // UTILS
    function dateForm(dt){
        
        let parts = dt.split(' ');
        let d = parts[0].split('/'); 
        let formatted = `${d[2]}/${d[1]}/${d[0]} ${parts[1]}`;

        let date = new Date(formatted); 

        // let date = new Date(dt);
        let day = String(date.getDate()).padStart(2,'0');
        let month = String(date.getMonth()+1).padStart(2,'0');
        let year = date.getFullYear();
        
        let hours = date.getHours();
        
        // console.log(hours);
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours == 0 ? 12 : hours;  

        hours = String(hours).padStart(2,'0');
        
        let minutes = String(date.getMinutes()).padStart(2,'0');
        let seconds = String(date.getSeconds()).padStart(2,'0');
    
        return `${day}/${month}/${year} ${hours}:${minutes}:${seconds} ${ampm}`;
    }
    
    console.log(dateForm('07/03/2026 09:58:04'));



    // FOR DATA TABLES
    let data_table = $('#table1').DataTable({
        paging:false,
        searching:false,
        ordering:true,
        info:false,
        autoWidth: false,  

        // INIT THE ROWID
        columnDefs:[

            {
                // INCREASE THE COLUMN WIDTH
                targets:1,
                width: "150px",
                className: "dt-body-nowrap"
            },

            {  
                // CHANGE DATE FORMAT FOR SORTING AND DISPLAY
                targets:3,
                width:"fit-content",
                className:"dt-body-nowrap",
                render:function(data, type, row){
                    if(type == 'display'){
                        return data.display;    
                    }
                    return data.sort;
                },

            },

            {
                targets:9,
                orderable:false,
                render:function(data, type, row){
                    if(type === 'display'){
                        return `<img 
                        src="https://erp.crgarments.com:8443/axpattach/CR/empunifhel/empunif/${data}" 
                        alt="No Image"
                        class="shadow-sm rounded-2"
                        style="border:1px solid lightgrey; width:60px; height:60px; object-fit:cover;">`;
                    }
                    return data;
                }

            }
           
        ]
        
    });

    // GET DATA PROCESS
    let from_dt = document.getElementById('from_dt');
    let to_dt = document.getElementById('to_dt');
    let get_btn = document.getElementById('get_btn');
    let table_result = document.getElementById('table_result');

    // GET RESULT INITIALLY
    get_res();

    // HIDE TABLE BOX WHEN DATE CHANGE
    from_dt.addEventListener('change', ()=>{
        table_result.style.opacity=0;
        setTimeout(() => {
            table_result.style.display='none';
        }, 200);

    });

    to_dt.addEventListener('change', ()=>{
        table_result.style.opacity=0;
        setTimeout(() => {
            table_result.style.display='none';
        }, 200);
    });


    async function get_res() {

        let fdate = from_dt.value;
        let tdate = to_dt.value;

        
        if(!fdate || !tdate){
            alert("Date Shouldn't be Empty !");
            return;
        }

        data_table.clear(); 


        // fdate='2026-03-01';

        try{

            const res = await fetch(base_url+`Main/unif_daily_rep?from_dt=${encodeURIComponent(fdate)}&to_dt=${encodeURIComponent(tdate)}`)
            const results = await res.json();

            if(!res.ok){
                throw new Error('Get Result Fetch Failed')
            }


            if(results){
                console.log(results);

                results.forEach((row,i) => {

                let newRow = data_table.row.add([
                        i+1,
                        row.EMPID,
                        row.MCEMPID,
                        {
                            display: row.CREATEDON ? dateForm(row.CREATEDON) : '-',
                            sort: row.CREATEDON ? new Date(row.CREATEDON).getTime() : 0
                        },
                        row.DEPT,
                        row.DESIGN,
                        row.DIVISION,
                        row.PREPBY,
                        row.REMARKS,
                        row.IMGNAME || 'do_not_delete/user.png'
                    ]);

                    // FOR STORE DATA ATTR FOR LATER RETRIVE
                    $(newRow.node()).data('row',row);
                    
                  
                });

                data_table.draw();


                // SHOW TABLE
                table_result.style.display='block';
                setTimeout(() => {
                    table_result.style.opacity=1;
                }, 200);
            }

        
        }
        catch(err){
            console.error('Get Result Erro :',err);
        }

    }

    get_btn.onclick = get_res;

    
    // CLICK TO SHOW THE ROW'S DETAILS
    let ent_emp_img = $('#ent_emp_img')[0];
    let ent_cap_img = $('#ent_cap_img')[0];
    let ent_name = $('#ent_name')[0];
    let ent_mcempid = $('#ent_mcempid')[0];
    let ent_dept = $('#ent_dept')[0];
    let ent_design = $('#ent_design')[0];
    let ent_div = $('#ent_div')[0];
    let ent_log = $('#ent_log')[0];
    let ent_prepby = $('#ent_prepby')[0];
    let ent_rem = $('#ent_rem')[0];


    $('#table1 tbody').on('click','tr', async function(){

        let row = $(this).data('row');  

        if(!row){
            return;
        }

        
        let mastid = row.MASTID;
        let docid = row.DOCID;
        let mcempid = row.MCEMPID;


        // console.log(mastid, docid, mcempid);
        ent_emp_img.src=''; ent_cap_img.src=''; ent_name.textContent=''; ent_mcempid.textContent=''; ent_dept.textContent='';
        ent_design.textContent=''; ent_div.textContent=''; ent_log.textContent=''; ent_prepby.textContent=''; ent_rem.textContent='';

        
        try{    

            const resp = await fetch(base_url + `Main/get_emp_entryinfo?mastid=${encodeURIComponent(mastid)}&docid=${encodeURIComponent(docid)}&mcempid=${encodeURIComponent(mcempid)}`);
            const res = await resp.json();

            if(!resp.ok) throw new Error('Fetching Error');

            if(!res['status']){
                console.log(res);

                let row = res['user_info'][0];

              
                ent_emp_img.src=res['user_img'] ? 'data:image/'+ res['user_img'].FTYPE+';base64,'+ res['user_img'].IMG : `https://erp.crgarments.com:8443/axpattach/CR/empunifhel/empunif/do_not_delete/user.png`;
                

                ent_cap_img.src= row.IMGNAME ? `https://erp.crgarments.com:8443/axpattach/CR/empunifhel/empunif/${row.IMGNAME}` : `https://erp.crgarments.com:8443/axpattach/CR/empunifhel/empunif/do_not_delete/user.png`;
                ent_name.textContent=row.EMPID;
                ent_mcempid.textContent=row.MCEMPID
                ent_dept.textContent=row.DEPT;
                ent_design.textContent=row.DESIGN;
                ent_div.textContent=row.DIVISION;
                ent_log.textContent=dateForm(row.CREATEDON);
                ent_prepby.textContent=row.PREPBY;
                ent_rem.textContent=row.REMARKS;

                let modalElem = document.getElementById('entryInfo');
                let ModalInstance = bootstrap.Modal.getOrCreateInstance(modalElem);
                ModalInstance.show();


                // PREVIEW FROM MODAL IMG
                let prev_head = $('#prev_head')[0];
                let prev_img = $('#prev_img')[0];

                prev_head.textContent='';

                // FOR EMP IMG PREVIEW
                $('#ent_emp_img').on('click', function(d){
                    d.stopPropagation();

                    prev_head.textContent='Profile Image';
                    prev_img.src= res['user_img'] ? 'data:image/'+ res['user_img'].FTYPE+';base64,'+ res['user_img'].IMG : `https://erp.crgarments.com:8443/axpattach/CR/empunifhel/empunif/do_not_delete/user.png`;
                    
                    let modInst = bootstrap.Modal.getOrCreateInstance(document.getElementById('imgPrev'));
                    modInst.show();
                
                    console.log(this);
                });
            
            
                // FOR CAP IMG PREVIEW
                $('#ent_cap_img').on('click', function(d){
                    d.stopPropagation();

                    prev_head.textContent='Captured Image';
                    prev_img.src= row.IMGNAME ? `https://erp.crgarments.com:8443/axpattach/CR/empunifhel/empunif/${row.IMGNAME}` : `https://erp.crgarments.com:8443/axpattach/CR/empunifhel/empunif/do_not_delete/user.png`
                
                    let modInst = bootstrap.Modal.getOrCreateInstance(document.getElementById('imgPrev'));
                    modInst.show();
                
                    console.log(this);
                });


            }

        }
        catch(err){
            console.error('Entry Fetch Error :', err);
        }



    });


});