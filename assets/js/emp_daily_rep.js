document.addEventListener('DOMContentLoaded', ()=>{
    console.log('EMP DAILY REPORT PARSED');
    console.log(base_url+'assets/images/noimage.png');


    
    // UTILS
    function dateForm(dt){
        let date = new Date(dt);
    
        let day = String(date.getDate()).padStart(2,'0');
        let month = String(date.getMonth()+1).padStart(2,'0');
        let year = date.getFullYear();
    
        let hours = String(date.getHours()).padStart(2,'0');
        let minutes = String(date.getMinutes()).padStart(2,'0');
        let seconds = String(date.getSeconds()).padStart(2,'0');
    
        return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
    }
    
    console.log(dateForm('03/03/2026 09:59:14'));



    // FOR DATA TABLES
    let data_table = $('#table1').DataTable({
        paging:false,
        searching:false,
        ordering:true,
        info:false,
        autoWidth: false,  

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

            // {
            //     targets:7,
            //     orderable:false,
            //     render:function(data, type, row){
            //         if(type === 'display'){
            //             return `<img src='${data}' class='shadow-sm rounded-2' style='width:80px; height:80px;'>`
            //         }
            //         return data;
            //     }

            // }
           
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

                // results.forEach((res,i) => {

                //     data_table.row.add([
                //         i+1,
                //         res.EMPID,
                //         res.MCEMPID,
                //         {
                //             display: res.CREATEDON ? dateForm(res.CREATEDON) : '-',
                //             sort: res.CREATEDON ? new Date(res.CREATEDON).getTime() : 0
                //         },
                //         res.DEPT,
                //         res.DESIGN,
                //         res.DIVISION,
                //         res.IMGURL 
                        
                //     ])

                // });

                // data_table.draw();
               
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

    get_btn.onclick = get_res



});