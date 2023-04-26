<?php

use App\Libraries\Hash;
?>
<header class="header text-center pt-3">
    <h3>Village Survey</h3>
</header>
<?php
if (!empty($loggedInfo['login_id'])) {
?>
    <div class="container-fluid p-3">
        <div class="row justify-content-md-center">
            <div class="col">
                <a href="<?= site_url() ?>dashboard/<?= Hash::path('index') ?>" class="btn btn-primary w-100" role="button" aria-pressed="true"><i class="fa fa-home me-1 ms-1"></i></a>
            </div>
            <div class="col">
                <a href="<?= site_url() ?>dashboard/<?= Hash::path('changepwd') ?>" class="btn btn-primary w-100" role="button" aria-pressed="true"><i class="fa fa-eye-slash me-1 ms-1"></i></a>
            </div>
            <div class="col">
                <a href="<?= site_url() ?>logout" class="btn btn-primary w-100" role="button" aria-pressed="true"><i class="fa fa-power-off me-1 ms-1"></i></a>
            </div>
        </div>
    </div>
<?php
}
?>