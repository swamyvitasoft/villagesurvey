<?php

use App\Libraries\Hash;

$data = session()->getFlashdata('data');
$data = explode("@", '' . $data);
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
            <div class="row text-center">
                <?= csrf_field(); ?>
                <?php if (!empty(session()->getFlashdata('fail'))) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
                <?php elseif (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
                <?php endif ?>
            </div>
            <div class="row justify-content-md-center">
                <div class="col col-2">
                    <div class="form-group mt-3">
                        <input type="text" name="eId" class="form-control form-control-lg bg-white eId" id="eId" placeholder="Employee ID" value="<?= set_value('eId') ?>" required>
                        <span class="text-danger span" style="display: none;">Employee Id required</span>
                    </div>
                    <button type="button" class="btn btn-outline-primary col-12 mt-3 register" id="register" onclick="captureFP()" style="display: none;"> Fingerprint Scanner </button>
                    <button type="button" class="btn btn-outline-primary col-12 mt-3 login" id="login" onclick="MatchFP()" style="display: none;"> Fingerprint Scanner </button>
                    <form action="<?= site_url() ?>dashboard/<?= Hash::path('regAction') ?>" method="post" role="form" class="php-email-form" enctype="multipart/form-data" id="regForm" style="display: none;">
                        <input type="text" name="empId" class="form-control form-control-lg bg-white empIdR" id="empIdR" placeholder="Employee Id" required readonly>
                        <textarea id="tmplval" name="tmplval" cols="100" rows="10" style="display: none;"></textarea>
                        <input type="hidden" name="serialNumber" id="serialNumber">
                        <input type="hidden" name="imageHeight" id="imageHeight">
                        <input type="hidden" name="imageWidth" id="imageWidth">
                        <input type="hidden" name="imageDPI" id="imageDPI">
                        <input type="hidden" name="nFIQ" id="nFIQ">
                        <textarea id="templateBase64" name="templateBase64" cols="100" rows="10" style="display: none;"></textarea>
                        <textarea id="isoImgBase64" name="isoImgBase64" cols="100" rows="10" style="display: none;"></textarea>
                        <input type="hidden" name="sessionKey" id="sessionKey">
                        <textarea id="encryptedPidXml" name="encryptedPidXml" cols="100" rows="10" style="display: none;"></textarea>
                        <input type="hidden" name="encryptedHmac" id="encryptedHmac">
                        <input type="hidden" name="clientIP" id="clientIP">
                        <input type="hidden" name="timestamp" id="timestamp">
                        <input type="hidden" name="fdc" id="fdc">
                        <button type="submit" class="btn btn-outline-success col-12 mt-3">Save Employee Data</button>
                    </form>
                    <textarea id="tmplval1" name="tmplval1" cols="100" rows="10" style="display: none;"></textarea>
                    <form action="<?= site_url() ?>dashboard/<?= Hash::path('logAction') ?>" method="post" role="form" class="php-email-form" enctype="multipart/form-data" id="logForm" style="display: none;">
                        <input type="text" name="empId" class="form-control form-control-lg bg-white empIdL" id="empIdL" placeholder="Employee Id" required readonly>
                        <button type="submit" class="btn btn-outline-success col-12 mt-3">Show Employee Data</button>
                    </form>
                    <div class="form-group mt-3">
                        <div class="text-center">
                            <img id="FPImage1" alt="Fingerpint Image" src="<?= site_url() ?>assets/images/finger.gif" class="img-fluid border rounded-circle" style="display: none;">
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
        $(document).on("blur", ".eId", function(e) {
            e.preventDefault();
            var eId = $(this).val();
            if (eId.trim().length === 0) {
                $('.span').show();
                return true;
            }
            $.ajax({
                type: "POST",
                url: "<?= site_url() ?>dashboard/<?= Hash::path('auth1') ?>",
                data: {
                    eId: eId
                },
                success: function(data) {
                    $('.eId').attr('readonly', 'true');
                    $('.span').hide();
                    $('#empIdR').val(data.empId);
                    $('#empIdL').val(data.empId);
                    if ($.trim(data.tmplval) == '') {
                        $('.register').show();
                    } else {
                        $("#tmplval1").val(data.tmplval);
                        $('.login').show();
                    }
                },
                error: function(data) {
                    alert('network error try again.');
                },
            });
        });
    });
</script>
<script>
    function captureFP() {
        document.getElementById("FPImage1").style.display = "block";
        jsonp("http://localhost:8090/FM220/gettmpl?callback=?",
            function(result) {
                SuccessFunc(result);
            });
    }

    function MatchFP() {
        document.getElementById("FPImage1").style.display = "block";
        jsonp("http://localhost:8090/FM220/GetMatchResult?MatchTmpl=" + encodeURIComponent(document.getElementById("tmplval1").value.toString()) + "&callback=?",
            function(result) {
                SuccessMatch(result);
            });
    }

    function jsonp(url, callback) {
        var id = "_" + (new Date()).getTime();
        window[id] = function(result) {
            if (callback)
                callback(result);
            var sc = document.getElementById(id);
            sc.parentNode.removeChild(sc);
            window[id] = null;
        }
        url = url.replace("callback=?", "callback=" + id);
        var script = document.createElement("script");
        script.setAttribute("id", id);
        script.setAttribute("src", url);
        script.onerror = ErrorFunc;
        script.setAttribute("type", "text/javascript");
        document.body.appendChild(script);
    }

    function SuccessFunc(result) {
        if (result.errorCode == 0) {
            if (result != null && result.bMPBase64.length > 0) {
                document.getElementById("FPImage1").src = "data:image/bmp;base64," + result.bMPBase64;
                document.getElementById("FPImage1").classList.add("border-5");
                document.getElementById("FPImage1").classList.add("border-dark");
                document.getElementById("FPImage1").style.width = "170px";
                document.getElementById("FPImage1").style.height = "170px";
            }
            document.getElementById("tmplval").value = result.templateBase64;
            document.getElementById("serialNumber").value = result.serialNumber;
            document.getElementById("imageHeight").value = result.imageHeight;
            document.getElementById("imageWidth").value = result.imageWidth;
            document.getElementById("imageDPI").value = result.imageDPI;
            document.getElementById("nFIQ").value = result.nFIQ;
            document.getElementById("templateBase64").value = result.templateBase64;
            document.getElementById("isoImgBase64").value = result.isoImgBase64;
            document.getElementById("sessionKey").value = result.sessionKey;
            document.getElementById("encryptedPidXml").value = result.encryptedPidXml;
            document.getElementById("encryptedHmac").value = result.encryptedHmac;
            document.getElementById("clientIP").value = result.clientIP;
            document.getElementById("timestamp").value = result.timestamp;
            document.getElementById("fdc").value = result.fdc;
            document.getElementById("eId").style.display = "none";
            document.getElementById("register").style.display = "none";
            document.getElementById("regForm").style.display = "block";
        } else {
            document.getElementById("FPImage1").style.display = "none";
            alert("Fingerprint Capture Error " + result.status);
        }
    }

    function SuccessMatch(result) {
        if (result.errorCode == 0) {
            if (result != null && result.bMPBase64.length > 0) {
                document.getElementById("FPImage1").src = "data:image/bmp;base64," + result.bMPBase64;
                document.getElementById("FPImage1").classList.add("border-5");
                document.getElementById("FPImage1").classList.add("border-dark");
                document.getElementById("FPImage1").style.width = "170px";
                document.getElementById("FPImage1").style.height = "170px";
            }
            document.getElementById("eId").style.display = "none";
            document.getElementById("login").style.display = "none";
            document.getElementById("logForm").style.display = "block";
        } else {
            document.getElementById("FPImage1").style.display = "none";
            alert("Fingerprint Capture Error " + result.status);
        }
    }

    function ErrorFunc(status) {
        alert("Check if ACPL FM220 service is running ");
    }
</script>