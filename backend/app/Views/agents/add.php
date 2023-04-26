<?php

use App\Libraries\Hash;
?>
<div class="main-wrapper">
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <?= view('common/header1') ?>
    <div class="page-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
        <div class="container-fluid">
            <div class="row">
                <h4 class="page-title"><a href="<?= site_url() ?>agents/<?= Hash::path('index') ?>">Agents List</a></h4>
            </div>
            <div class="row">
                <div class="col-12">
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
                            <form action="<?= site_url() ?>agents/<?= Hash::path('addAction') ?>" method="post" role="form" class="php-email-form" enctype="multipart/form-data">
                                <div class="form-group mt-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" value="<?= set_value('name') ?>">
                                    <small class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'name') : '' ?></small>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="username" class="form-label">Phone Number</label>
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Phone Number" value="<?= set_value('username') ?>">
                                    <small class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'username') : '' ?></small>
                                </div>
                                <div class="text-center"><button type="submit" class="btn btn-success">Save</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= view('common/footer') ?>
</div>