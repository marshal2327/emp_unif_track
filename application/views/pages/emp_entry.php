<?php 
defined('BASEPATH') or exit('NO DIRECT SCRIPT ACCESS ALLOWED');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMP UNIFORM ENTRY</title>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/emp_entry.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Mozilla+Headline:wght@200..700&family=Noto+Sans+Mono:wght@100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Zen+Dots&display=swap"
        rel="stylesheet">
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>

<!-- <?php echo '<pre>'; print_r($emp_datas);?> -->

<body class='bg-light'>

    <div id="overlay">
        <lottie-player
        id='lottie'
        src="<?php echo base_url()?>assets/gif/loading.json"
        background='transparent'
        speed='1'
        style='width:200px; height:200px;'
        loop='False';
        >
        </lottie-player>
        <p class='p text-center text-white fw-bold fs-3' style='font-family:Poppins,sans-serif;'>Saved</p>

    </div>

    <div class="container-fluid">

        <div class="row">

            <!-- NAVIGATION -->
            <div class="col-12 p-0">

                <nav id='navbar' class="navbar navbar-light shadow-sm p-2 d-flex justify-content-center">

                    <img class="ms-1" width="35" height="40" src="<?php echo base_url()?>assets/images/crlogo.png"
                        alt="crlogo" style="filter:invert(0%);">
                    <span class="navbar-brand h3 fs-5 m-0" style="font-family:Mozilla Headline,sans-serif;">EMP
                        UNIFORM ENTRY</span>

                </nav>

            </div>

        </div>

        <!-- CONTENTS -->
        <div class="row">

            <div id='content_box' class="col-12 px-2 mt-4">

                <h5 class="h5 fs-6 px-1">Select Employee</h5>

                <div class="px-2 py-1 w-100" id="emp_selectbox">
                    <div id="input_box">
                        <img width='23' height='23' src="<?php echo base_url()?>assets/Images/downarrow.png" alt="down">
                        <input class='w-100' type="text" id='emp_sel' placeholder="e.g. MCEMPID / NAME" autocomplete='off'>
                    </div>

                    <div class="mt-1 rounded-1 emp_options shadow-sm" id='emp_options'>
                        <!-- <p>HOS42245 / Marshal Augustine A</p>
                        <p>HOS42245 / Marshal Augustine A</p>
                        <p>HOS42245 / Marshal Augustine A</p>
                        <p>HOS42245 / Marshal Augustine A</p>
                        <p>HOS42245 / Marshal Augustine A</p>
                        <p>HOS42245 / Marshal Augustine A</p>
                        <p>HOS42245 / Marshal Augustine A</p>
                        <p>HOS42245 / Marshal Augustine A</p> -->
                    </div>

                </div>

                <div id='emp_card' class="card shadow border-1 mx-2 mt-2 rounded-3">
                    <!-- <div class="card-title"> -->
                    <!-- <h5 class='h5 fs-6'>Employee Details</h5> -->
                    <!-- </div> -->
                    <div class="card-title d-flex justify-content-center pt-3">
                        <img id='emp_img' src="<?php echo base_url()?>assets/images/nouserimg.jpg" alt="user_prof_pic">
                    </div>

                    <div id='emp_info_box' class="card-body px-3 ps-4 pt-1 d-flex flex-column gap-2">

                        <div id='name_box' class="emp_box">
                            <label for="">Name</label>
                            <span>:</span>
                            <p id='empid_val' style='margin:0; padding:0px 10px;'>-</p>
                        </div>
                        <div id='mcempid_box' class="emp_box">
                            <label for="">MCEMPID</label>
                            <span>:</span>
                            <p id='mcempid_val' style='margin:0; padding:0px 5px;'>-</p>
                        </div>
                        <div id='dept_box' class="emp_box">
                            <label for="">Department</label>
                            <span>:</span>
                            <p id='dept_val' style='margin:0; padding:0px 5px;'>-</p>
                        </div>
                        <div id='design_box' class="emp_box">
                            <label for="">Designation</label>
                            <span>:</span>
                            <p id='design_val' style='margin:0; padding:0px 5px;'>-</p>
                        </div>
                    </div>
                </div>

                <div id="entry_card" class="card shadow mx-2  mt-3 rounded-3">

                    <div class="card-body">

                        <div id='prepby_box'>
                            <p class="col-12 p m-0 p-0" style='font-family:Poppins,sans-serif; font-size:13px;'>Prepared
                                By*</p>
                            <input disabled class="col-12 px-1 mt-1 disable" type="text" id='prepby_val' required>
                        </div>

                        <div id='remarks_box' class="mt-3">
                            <p class="col-12 p m-0 p-0" style='font-family:Poppins,sans-serif; font-size:13px;'>Remarks*
                            </p>
                            <textarea disabled rows="3" class='w-100 rounded-2 mt-2 p-1 disable' name="" id="remarks_val" required></textarea>
                        </div>

                        <div id='capture_box' class="row m-0 mt-1 d-flex justify-content-between">

                            <button disabled id='pic_btn' class=" disable btn btn-outline-none bg-primary shadow-sm text-white fw-bold "
                                data-bs-toggle="modal" data-bs-target="#takePic"
                                style='width:49%; font-size:14px; font-family:Poppins,sans-serif;'>Take Photo</button>
                            <button disabled id='save_entry_btn' class="disable btn btn-outline-none bg-success shadow-sm text-white fw-bold "
                                style='width:49%; font-size:14px; font-family:Poppins,sans-serif;'>Submit</button>

                        </div>

                    </div>

                </div>

                <!-- FOR TAKE PICTURE BOX -->

                <div class="modal fade mt-5 px-2" id="takePic">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title h3 fs-5 w-100 text-center ms-1">Take Picture</h3>
                                <button class="btn-close fs-5" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body" style='box-sizing:border-box;'>
                                <!-- FOR FRONT CAMERA : CAPTURE = USER -->
                                <div class="card">

                                    <div class="card-titile">
                                        <input class='form-control' type="file" id='upic_img_inp' name='upic_img'
                                            accept="image/*" capture="environment">
                                    </div>

                                    <div id='upic_box' class="card-body pb-2">
                                        <img id='upic_img_val' class='rounded-3 shadow-sm'
                                            style='width:100%; height:100%;' src="" alt="">

                                        <div  class="btn_box w-100 d-flex justify-content-center pt-2">
                                            <button data-bs-dismiss="modal" class="btn w-25 1 rounded-3 shadow-sm text-center"
                                                style='background:#3fe397;'>Ok</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
    let base_url = "<?php echo base_url()?>";
    let emp_datas = <?php echo json_encode($emp_datas)?>;
    </script>
    <script src="<?php echo base_url()?>assets/js/emp_entry.js"></script>
</body>

</html>