<?php
// echo $captcha;
// echo $header;
$grades = unserialize(GRADES);
$months = unserialize(MONTHS);
$days = unserialize(DAYS);
$times = unserialize(TIMES);
$timezone = unserialize(TIMEZONE);
$attributes = array('enctype' => 'multipart/form-data');
?>
<div class="innerPage">
	<div class="wrapper">
		<div class="col-sm-12">
			<div class="loginBox">
				<div class="loginWraper">
					<?php echo form_open('login/register', $attributes); ?>
	                <div class="col-sm-12">
                        <?= strlen($this->session->flashdata('msg')) > 0 ? $this->session->flashdata('msg') : ''; ?>
		                <h1><?= $header; ?></h1>
                        <div class="form-group">
                            <label class="inputWraper">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <input type="text" class="form-control" name="name" placeholder="Your Name" autocomplete="off" required>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="inputWraper">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email id" autocomplete="off" required>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="inputWraper">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <input type="text" class="form-control" name="phone" placeholder="Phone Number With Country Code" autocomplete="off" require>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="inputWraper">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                                <select class="form-control" name="time_zone" id="time_zone" require>
                                    <option>Time Zone</option>
                                    <?php 
                                        foreach($timezone as $k => $v){
                                            echo '<option value="'. $v .'">'. $v .'</option>';
                                        }
                                    ?>
                                </select>
                            </label>
                        </div>
                        <div class="captureMain">
                            <div class="captureCode">
                            <span id="image" ><?php if (isset($image)) echo $image; ?></span> 
                            <a class="refreshCapBtn" href="javascript:void(0);" title="Refresh Captcha Access code">
                                <i class="fa fa-refresh"></i>
                            </a>
                        </div>
                        <div class="captureInput">
                            <label class="inputWraper">
                            <input type="text" class="form-control" name="captcha" id="captcha" placeholder="Captcha" autocomplete="off" required></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <span id="msg"></span>
                        <button type="submit" id="submit" class="btn btnRed widthFull">Register Now</button>
                    </div>
	            </div>
	            <?php echo form_close(); ?>
	        </div>
        </div>
    </div>
</div>
<!-- </div> -->

<script>
    var captcha = "<?= $_SESSION['captcha'] ?>";
    $(document).ready(function () {
        $('.refreshCapBtn').on('click', function () {
            $.get('<?php echo site_url("login/captcha_refresh"); ?>', function (data) {
            $('#image').html(data);
            get_captcha_dtls();
            });
        });
    });
    function get_captcha_dtls(){
        $.get('<?php echo site_url("login/captcha_dtls"); ?>', function (data) {
            captcha = data;
        });
    }
    $('#captcha').change(function(){
        if(captcha != $('#captcha').val()){
            $('#msg').empty();
            $('#msg').append('<div class="alert alert-danger text-center">Invalid Captcha..</div>');
        }else{
            $('#msg').empty();
        }
    })
    $('#submit').on('click', function(){
        if(captcha != $('#captcha').val()){
            $('#msg').empty();
            $('#msg').append('<div class="alert alert-danger text-center">Invalid Captcha..</div>');
            return false;
        }else{
            $('#msg').empty();
            return true;
        }
    })
</script>

<script>
    $('#email').on('change', function(){
        $.get('<?php echo site_url("index.php/login/check_email"); ?>', {email: $(this).val()}). done(function (data) {
            // console.log(data);
            if(data > 0){
                $('#submit').removeAttr('disabled');
            }else{
                alert("Email ID Already Exist !!!");
                $('#submit').attr('disabled', 'disabled');
            }
            // $('#image').html(data);
        });
    })
</script>