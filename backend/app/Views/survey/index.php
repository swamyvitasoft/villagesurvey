<?php

use App\Libraries\Hash;
?>
<style>
    input.invalid {
        background-color: #ffdddd
    }

    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5
    }

    .step.active {
        opacity: 1
    }

    .step.finish {
        background-color: #4CAF50
    }

    .all-steps {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 30px
    }

    .thanks-message {
        display: none
    }

    .tab {
        display: none
    }
</style>
<script>
    //your javascript goes here
    var currentTab = 0;
    document.addEventListener("DOMContentLoaded", function(event) {
        showTab(currentTab);
    });

    function showTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
        }
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName("tab");
        if (n == 1 && !validateForm()) return false;
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {
            document.getElementById("surveyform").submit();
            return false;
            alert("sdf");
            document.getElementById("nextprevious").style.display = "none";
            document.getElementById("all-steps").style.display = "none";
            document.getElementById("survey").style.display = "none";
            document.getElementById("text-message").style.display = "block";
        }
        showTab(currentTab);
    }

    function validateForm() {
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        for (i = 0; i < y.length; i++) {
            if (y[i].value == "") {
                y[i].className += " invalid";
                valid = false;
            }
        }
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid;
    }

    function fixStepIndicator(n) {
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        x[n].className += " active";
    }
</script>
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <?php
                            csrf_field();
                            if (!empty(session()->getFlashdata('fail'))) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                            <?php elseif (!empty(session()->getFlashdata('success'))) : ?>
                                <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                            <?php endif ?>
                        </div>
                        <div class="card-body d-flex justify-content-center align-items-center">
                            <form action="<?= site_url() ?>survey/<?= Hash::path('addAction') ?>" method="post" role="form" id="surveyform" class="php-email-form" enctype="multipart/form-data">
                                <h3 class="text-center" id="survey">Survey Form</h3>
                                <div class="all-steps" id="all-steps">
                                    <span class="step"></span>
                                    <?php
                                    for ($i = 0; $i < $topicsCount; $i++) {
                                    ?>
                                        <span class="step"></span>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <div class="tab">
                                    <div class="form-group mt-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Full Name" value="<?= set_value('name') ?>">
                                        <small class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'name') : '' ?></small>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="ward">Ward</label>
                                        <input type="text" class="form-control" name="ward" id="ward" placeholder="Ward Number" value="<?= set_value('ward') ?>">
                                        <small class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'ward') : '' ?></small>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number" value="<?= set_value('phone') ?>">
                                        <small class="text-danger"><?= !empty(session()->getFlashdata('validation')) ? display_error(session()->getFlashdata('validation'), 'phone') : '' ?></small>
                                    </div>
                                </div>
                                <?php
                                foreach ($topicsInfo as $index => $row) {
                                ?>
                                    <div class="tab">
                                        <div class="form-group mt-3">
                                            <label for="topic_id"><?= $row['topic_name'] ?></label>
                                            <input type="hidden" name="topic_id[]" id="topic_id" value="<?= $row['topic_id'] ?>">
                                            <input type="radio" class="form-check-input" name="topic_replay_<?= $row['topic_id'] ?>" id="yes_<?= $row['topic_id'] ?>" value="Yes" checked>Yes
                                            <input type="radio" class="form-check-input" name="topic_replay_<?= $row['topic_id'] ?>" id="no_<?= $row['topic_id'] ?>" value="No">No
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
                                    <h3>Thanks for your Donation!</h3> <span>Your donation has been entered! We will contact you shortly!</span>
                                </div>
                                <div style="overflow:auto;" id="nextprevious">
                                    <div style="float:right;"> <button type="button" class="btn btn-primary" id="prevBtn" onclick="nextPrev(-1)">Previous</button> <button type="button" class="btn btn-success" id="nextBtn" onclick="nextPrev(1)">Next</button> </div>
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