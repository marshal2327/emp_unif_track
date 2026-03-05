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
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/emp_entry.css?v=123">
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


                    <span class="navbar-brand fs-5" style="font-family:Mozilla Headline,sans-serif;">EMP UNIFORM
                        ENTRY</span>

                    <div class="dropdown">
                        <button class="btn btn-outline-none bg-light fw-bold my-0 py-0 fs-5" data-bs-toggle="dropdown">⋮</button>

                        <ul class="dropdown-menu dropdown-menu-end text-center p-0 m-0">
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
                    <h5 class="h5 fs-6 " style='font-family:Poppins,sans-serif;'>Uniform Entry Report</h5>
                </div>
                
                <div class="rounded-3 bg-light">
                    <div class="w-auto d-flex justify-content-evenly py-2">
                        <input style='font-family:Poppins,sans-serif; font-size:13px;' class="border-1 border-secondary bg-transparent py-1 rounded-pill px-1 text-center" type="date" name="frm_dt" id='from_dt' value="<?= date('Y-m-d')?>">
                        <img width='20' height='15' class="my-auto" src="<?= base_url()?>assets/images/darrows1.png" alt="">
                        <input style='font-family:Poppins,sans-serif; font-size:13px;' class="border-1 border-secondary bg-transparent py-1 rounded-pill px-1 text-center" type="date" name="to_dt" id="to_dt" value="<?= date('Y-m-d')?>">
                    </div>

                    <div class="w-100 d-flex justify-content-center ">
                        <button id='get_btn' role="button" style="font-family:Poppins, sans-serif; font-size:14px; font-weight:450;" class="btn btn-outilne-none rounded-3 shadow-sm bg-success text-white m-0 py-1 px-3">Get</button>
                    </div>

                    <div id='table_result' class="table-responsive mt-2 shadow-sm">
                
                        <table id='table1' class="table table-hover table-align-middle bg-none">
                            <thead >
                                <tr>
                                    <th class="text-center align-middle">Sl.No</th>
                                    <th class="text-center align-middle">Name</th>
                                    <th class="text-center align-middle">MC Code</th>
                                    <th class="text-center align-middle">Entry Log</th>
                                    <th class="text-center align-middle">Department</th>
                                    <th class="text-center align-middle">Designation</th>
                                    <th class="text-center align-middle">Division</th>
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

    <script src="<?php echo base_url()?>assets/js/emp_daily_rep.js"></script>
</body>

</html>