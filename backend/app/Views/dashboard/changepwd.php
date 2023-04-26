<?php

use App\Libraries\Hash;
?>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<div id="main">
    <?= view('common/header1') ?>
    <div class="page-wrapper pt-5">
        <div class="container-fluid">
            <div class="row justify-content-md-center">
                <div class="col col-8">
                    <div class="card">
                        <div class="card-header">
                            <?= csrf_field(); ?>
                            <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                            <?php elseif (!empty(session()->getFlashdata('success'))) : ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                            <?php endif ?>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url() ?>dashboard/<?= Hash::path('updatepwd') ?>" method="post" role="form" class="php-email-form" enctype="multipart/form-data">
                                <div class="col-8">
                                    <div class="form-group mt-3">
                                        <label for="username" class="form-label">Mail Id</label>
                                        <input type="text" name="username" class="form-control" id="username" placeholder="" value="<?= $loggedInfo['username'] ?>" readonly>
                                        <small class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'username') : '' ?></small>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" name="password" class="form-control" id="password" placeholder="" value="<?= set_value('password') ?>">
                                        <small class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'password') : '' ?></small>
                                    </div>
                                    <div class="text-center"><button type="submit" class="btn btn-success">Update</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= view('common/footer') ?>
</div>