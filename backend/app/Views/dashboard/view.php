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
    <div class="page-wrapper">
        <div class="container-fluid">
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
                            <div class="adv-table">
                                <table id="zero_config" class="table table-striped table-bordered w-100 d-md-table">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Father / Husband</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th class="none">Residential Address</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($registeredData as $index => $row) {
                                        ?>
                                            <tr>
                                                <td><?= $row['empId'] ?> </td>
                                                <td><?= $row['fullname'] ?> </td>
                                                <td><?= $row['fname'] ?> </td>
                                                <td><?= $row['email'] ?> </td>
                                                <td><?= $row['phone'] ?> </td>
                                                <td><?= $row['address'] ?> </td>
                                                <td>
                                                <button type="button" class="btn btn-success btn-sm rounded text-white show" value='{"register_id" :"<?= $row['register_id'] ?>"}'> View </button>
                                                    <button type="button" id="edit" class="btn btn-cyan btn-sm rounded text-white edit" value='{"register_id" :"<?= $row['register_id'] ?>"}'> Edit </button>
                                                    <button type="button" class="btn btn-danger btn-sm rounded text-white delete" value='{"register_id" :"<?= $row['register_id'] ?>"}'> Delete </button>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Father / Husband</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th class="none">Residential Address</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= view('common/footer') ?>
</div>
<script src="<?= site_url() ?>assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on("click", ".show", function(e) {
            var data = $(this);
            var values = JSON.parse(data.val());
            var register_id = values.register_id;
            location.replace("<?= site_url() ?>dashboard/<?= Hash::path('show') ?>/" + register_id);
        });
        $(document).on("click", ".edit", function(e) {
            var data = $(this);
            var values = JSON.parse(data.val());
            var register_id = values.register_id;
            location.replace("<?= site_url() ?>dashboard/<?= Hash::path('edit') ?>/" + register_id);
        });
        $(document).on("click", ".delete", function(e) {
            var data = $(this);
            var values = JSON.parse(data.val());
            var register_id = values.register_id;
            location.replace("<?= site_url() ?>dashboard/<?= Hash::path('delete') ?>/" + register_id);
        });
    });
</script>