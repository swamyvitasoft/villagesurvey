<?php

use App\Libraries\Hash;
?>
<div class="row pt-3 mt-3">
    <div class="col-10 text-center">
        <h3>MODIFIED VOLUNTARY RETIREMENT SCHEME -2022 OF AZAM MILL WORKERS</h3>
        <h5>(318) EX-EMPLOYEES OF A MILL COVERED UNDER HON'BLE SUPREM COURT OF INDIA ORADER DATED 26-10-2021</h5>
    </div>
    <div class="col-2 text-center">
        <?php
        if (!empty($loggedInfo['login_id'])) {
        ?>
            <header>
                <nav class="navbar navbar-expand-md">
                    <div class="navbar-collapse collapse">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url() ?>dashboard/<?= Hash::path('index') ?>">Home</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Settings
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item p-2" href="<?= site_url() ?>dashboard/<?= Hash::path('view') ?>"><i class="fa fa-list me-1 ms-1"></i> List</a>
                                    <a class="dropdown-item p-2" href="<?= site_url() ?>dashboard/<?= Hash::path('changepwd') ?>"><i class="fa fa-eye-slash me-1 ms-1"></i> Change Password</a>
                                    <a class="dropdown-item p-2" href="<?= site_url() ?>logout"><i class="fa fa-power-off me-1 ms-1"></i> Logout</a>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
        <?php
        }
        ?>
    </div>
</div>