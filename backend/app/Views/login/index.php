<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template" />
    <meta name="description" content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework" />
    <meta name="robots" content="noindex,nofollow" />
    <title><?= $pageTitle ?></title>
    <!-- Favicon icon -->
    <link rel="icon" sizes="16x16" href="<?= site_url() ?>favicon.ico" />
    <!-- Custom CSS -->
    <link href="<?= site_url() ?>assets/dist/css/style.min.css" rel="stylesheet" />
    <!-- Theme Style CSS -->
    <link href="<?= site_url() ?>assets/custom-libs/theme-style.css" rel="stylesheet" />
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div class="text-center pt-3 pb-3">
                </div>
                <div id="loginform">
                    <div class="text-center">
                        <span class="text-dark">Enter your correct username, password below and you will go to admin dashboard.</span>
                    </div>
                    <div class="row mt-3">
                        <!-- Form -->
                        <form class="col-12" id="loginform" action="<?= site_url() ?>check" method="post">
                            <?= csrf_field(); ?>
                            <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                            <?php elseif (!empty(session()->getFlashdata('success'))) : ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                            <?php endif ?>
                            <div class="row pb-4">
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-success text-white h-100" id="basic-addon1"><i class="mdi mdi-lock fs-4"></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" />
                                        <div class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'username') : '' ?></div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-warning text-white h-100" id="basic-addon2"><i class="mdi mdi-lock fs-4"></i></span>
                                        </div>
                                        <input type="password" class="form-control form-control-lg" id="password" name="password" value="<?= set_value('password') ?>" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" />
                                        <div class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'password') : '' ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top border-secondary">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="pt-3">
                                            <button class="btn btn-info" id="to-recover" type="button">
                                                <i class="mdi mdi-lock fs-4 me-1"></i> Lost password?
                                            </button>
                                            <button class="btn btn-success float-end text-white" type="submit">
                                                Login
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="recoverform">
                    <div class="text-center">
                        <span class="text-dark">Enter your username below and we will send you
                            instructions how to recover a password.</span>
                    </div>
                    <div class="row mt-3">
                        <!-- Form -->
                        <form class="col-12" id="recoverform" action="<?= site_url() ?>recover" method="post" onsubmit="if (! confirm('Confirm to recover your password?')) { return false; }">
                            <?= csrf_field(); ?>
                            <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                            <?php elseif (!empty(session()->getFlashdata('success'))) : ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                            <?php endif ?>
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white h-100" id="basic-addon1"><i class="mdi mdi-email fs-4"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" value="<?= set_value('username') ?>" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" />
                                <div class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'username') : '' ?></div>
                            </div>
                            <!-- pwd -->
                            <div class="row mt-3 pt-3 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success text-white" href="#" id="to-login" name="action">Back To Login</a>
                                    <button class="btn btn-info float-end" type="submit" name="action">
                                        Recover
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="<?= site_url() ?>assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= site_url() ?>assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $(".preloader").fadeOut();
        $("#recoverform").hide();
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $("#to-recover").on("click", function() {
            $("#loginform").hide();
            $("#recoverform").fadeIn();
        });
        $("#to-login").click(function() {
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });
    </script>
</body>

</html>