<?php 
defined('BASEPATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMP UNIFORM REPORTS</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Mozilla+Headline:wght@200..700&family=Noto+Sans+Mono:wght@100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Zen+Dots&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <!-- DataTables Bootstrap 5 CSS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/emp_entry.css?v=365">

</head>

<!-- <?php echo '<pre>'; print_r($results);?> -->

<body style='background-color:whitesmoke;'>

    <!-- <div id="overlay">
        <lottie-player id='lottie' src="<?php echo base_url()?>assets/gif/loading.json" background='transparent'
            speed='1' style='width:200px; height:200px;' loop='False'>
        </lottie-player>
        <p id='save_label' class='p text-center text-white fw-bold fs-3' style='font-family:Poppins,sans-serif;'>Saving
        </p>

    </div> -->

    <div class="container-fluid">

        <div class="row">

            <!-- NAVIGATION -->
            <div class="col-12 p-0">

                <nav id='navbar' class="navbar navbar-light bg-light shadow-sm p-2">


                    <img class="ms-1" width="35" height="40" src="<?php echo base_url()?>assets/images/crlogo.png"
                        alt="crlogo" style="filter:invert(0%);">


                    <span class="navbar-brand fs-5" style="font-family:Mozilla Headline,sans-serif;">EMP WITHOUT UNIFORM</span>

                    <div class="dropdown">
                        <button class="btn btn-outline-none bg-light fw-bold my-0 py-0 fs-5" data-bs-toggle="dropdown">⋮</button>

                        <ul class="dropdown-menu dropdown-menu-end text-center p-0 m-0 shadow">
                            <li><a href="<?= base_url()?>Main" class="dropdown-item py-2 m-0 border-bottom border-1" style="font-family:Poppins, sans-serif; font-size:14px;">Home</a></li>
                            <li><a href="<?= base_url()?>Main/unif_daily_rep_page" class="dropdown-item py-2 m-0" style="font-family:Poppins, sans-serif; font-size:14px;">Reports</a></li>
                        </ul>

                    </div>

                </nav>

            </div>

        </div>

        <!-- CONTENTS -->
        <div class="row">

            <div class="col-12 mt-3">
                
                <a href="#" onclick="window.history.back()" role='button' aria-label="back" class="">
                    <img width='25' height='25' src="<?= base_url()?>assets/images/previous.png" alt="">
                </a>
                
                <div id='content_box' class="col-12 mt-3">
                    <h5 id='h5' class="h5 fs-6 " style='font-family:Poppins,sans-serif;'>Uniform Entry Report</h5>
                </div>
                
                <div class="rounded-3 bg-light">

                    <div class="w-auto d-flex justify-content-evenly py-2">
                        <input style='font-family:Poppins,sans-serif; font-size:13px; text-align:center;' class="text-center border-1 border-secondary bg-transparent py-1 rounded-pill px-1 text-center" type="date" name="frm_dt" id='from_dt' value="<?= date('Y-m-d')?>">
                        <img width='20' height='15' class="my-auto" src="<?= base_url()?>assets/images/darrows1.png" alt="">
                        <input style='font-family:Poppins,sans-serif; font-size:13px; text-align:center;' class="text-center border-1 border-secondary bg-transparent py-1 rounded-pill px-1 text-center" type="date" name="to_dt" id="to_dt" value="<?= date('Y-m-d')?>">
                    </div>

                    <div class="w-100 d-flex justify-content-center ">
                        <button id='get_btn' role="button" style="font-family:Poppins, sans-serif; font-size:14px; font-weight:450;" class="btn btn-outilne-none rounded-3 shadow-sm bg-success text-white m-0 py-1 px-3">Get</button>
                    </div>

                    <div id='table_result' class="table-responsive mt-2 shadow-sm">
                
                        <table id='table1' class="table table-align-middle bg-none">
                            <thead >
                                <tr>
                                    <th class="text-center align-middle">Sl.No</th>
                                    <th class="text-center align-middle">Name</th>
                                    <th style='white-space:nowrap;' class="text-center align-middle">MC Code</th>
                                    <th class="text-center align-middle">Entry Log</th>
                                    <th class="text-center align-middle">Department</th>
                                    <th class="text-center align-middle">Designation</th>
                                    <th class="text-center align-middle">Division</th>
                                    <th style="white-space:wrap;" class="text-center align-middle">Prepared By</th>
                                    <th class="text-center align-middle">Remarks</th>
                                    <th class="text-center align-middle">Photo</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <!-- <tr>
                                    <td class="text-center align-middle">1</td>
                                    <td class="text-center align-middle">Marshal Augustine</td>
                                    <td class="text-center align-middle">HOS42245</td>
                                    <td class="text-center align-middle">03/03/2026 09:59:14</td>
                                    <td class="text-center align-middle">ERP</td>
                                    <td class="text-center align-middle">Software Developer</td>
                                    <td class="text-center align-middle">C.R.Garments</td>
                                    <td class="text-center align-middle"><img class="img-fluid rounded-2 shadow-sm" src="<?= base_url()?>assets/images/person.jpg" alt=""></td>
                                </tr> -->
                            </tbody>

                        </table>
                    </div>

                    <div id='entryInfo' class="modal fade">
                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">

                                <div class="modal-header py-2">
                                    <h3 class="modal-title text-center h3 fs-5 w-100 text-center ps-4">Entry Info</h3>
                                    <button data-bs-dismiss="modal" class="btn btn-close"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="row d-flex justify-content-evenly">

                                        <!-- PROFILE IMG -->
                                        <div style='width:110px; height:125px;' class="card rounded-3 shadow px-0 mx-0">
                                                <img id='ent_emp_img' class="card-img-top rounded-top-3 " 
                                                style='width:100%; min-height:100px; border-bottom:1px solid grey; object-fit:cover; object-position:50% 28%; transform:scale(1);'
                                                src="<?php echo base_url()?>assets/images/person.jpg" alt="user_prof_pic">
                                            <div class="card-body p-0 bg-light rounded-bottom h-100 d-flex justify-content-center align-items-center">
                                                <p class="card-text text-center" style='font-family:Poppins,sans-serif; font-size:12px; color:grey;'>Profile Img</p>
                                            </div>
                                        </div>

                                        <!-- CAPTURED IMG -->
                                        <div style='width:110px; height:125px;' class="card rounded-3 shadow px-0 mx-0">
                                                <img id='ent_cap_img' class="card-img-top rounded-top-3 " 
                                                style='width:100%; min-height:100px; border-bottom:1px solid grey; object-fit:cover; object-position:50% 28%; transform:scale(1);'
                                                src="<?php echo base_url()?>assets/images/person.jpg" alt="user_cap_pic">
                                            <div class="card-body p-0 bg-light rounded-bottom h-100 d-flex justify-content-center align-items-center">
                                                <p class="card-text text-center" style='font-family:Poppins,sans-serif; font-size:12px; color:grey;'>Captured Img</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="card rounded-3 mt-3 shadow-sm">

                                        <div class="card-body d-flex justify-content-between align-items-end  py-2 px-2">
                                            <label class="card-text fw-semibold" for="">Name</label>
                                            <p id='ent_name' class="card-text">Marshal Augustine A</p>
                                        </div>
                                        <hr class="p-0 m-0">
                                        <div class="card-body d-flex justify-content-between py-2 px-2">
                                            <label class="card-text fw-semibold" for="">MC Code</label>
                                            <p id='ent_mcempid' class="card-text">HOS42245</p>
                                        </div>
                                        <hr class="p-0 m-0 ">
                                        <div class="card-body d-flex justify-content-between py-2 px-2">
                                            <label class="card-text fw-semibold" for="">Department</label>
                                            <p id='ent_dept' class="card-text">ERP</p>
                                        </div>
                                        <hr class="p-0 m-0 ">
                                        <div class="card-body d-flex justify-content-between py-2 px-2">
                                            <label class="card-text fw-semibold" for="">Designation</label>
                                            <p id='ent_design' class="card-text">Software Developmen</p>
                                        </div>
                                        <hr class="p-0 m-0 ">
                                        <div class="card-body d-flex justify-content-between py-2 px-2">
                                            <label class="card-text fw-semibold" for="">Division</label>
                                            <p id='ent_div' class="card-text">C.R.Garments</p>
                                        </div>
                                        <hr class="p-0 m-0 ">
                                        <div class="card-body d-flex justify-content-between py-2 px-2">
                                            <label class="card-text fw-semibold" for="">Entry Log</label>
                                            <p id='ent_log' class="card-text">06/03/2026 15:17:32</p>
                                        </div>
                                        <hr class="p-0 m-0 ">
                                        <div class="card-body d-flex justify-content-between py-2 px-2">
                                            <label class="card-text fw-semibold" for="">Prepared By</label>
                                            <p id='ent_prepby' class="card-text">HR</p>
                                        </div>
                                        <hr class="p-0 m-0 ">
                                        <div class="card-body d-flex justify-content-between py-2 px-2">
                                            <label class="card-text fw-semibold" for="">Remarks</label>
                                            <p id='ent_rem' class="card-text">Test 1</p>
                                        </div>

                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12 d-flex justify-content-center">
                                            <button data-bs-dismiss="modal" style="font-family:Poppins,sans-serif; font-size:14px; font-weight:450;" class="btn btn-outline-none bg-info text-white">Close</button>
                                        </div>
                                    </div>
                                    
                                </div>

                            </div>

                        </div>

                        <!-- IMG PREVIEW MODAL -->
                         <div id='imgPrev' class="modal bg-dark fade">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header py-2 bg-light">
                                        <h3 id='prev_head' class="modal-title fs-5 w-100 text-center ms-4">Capture Img</h3>
                                        <button data-bs-dismiss="modal" class="btn btn-close bg-light"></button>
                                    </div>
                                    <div class="modal-body bg-light rounded-bottom-3 pt-1">

                                        <div class="card rounded-3">
                                             <img id='prev_img' class="rounded-3 img-fluid shadow" src="<?= base_url()?>assets/images/person.jpg" alt="">
                                        </div>

                                    </div>
                                </div>
                            </div>

                         </div>

                    </div>

                </div>
                
            </div>

        </div>

    </div>

    <!-- jQuery (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        let base_url = "<?php echo base_url()?>";
    </script>

    <script src="<?php echo base_url()?>assets/js/emp_daily_rep.js?v=587"></script>
</body>

</html>