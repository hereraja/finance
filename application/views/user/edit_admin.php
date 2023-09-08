<style>
    .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
    }
    .error{
        color: red;
    }
</style>

<style>
        .has-float-label {
            display: block;
            position: relative
        }

        .has-float-label label,
        .has-float-label>span {
            position: absolute;
            cursor: text;
            font-size: 75%;
            opacity: 1;
            -webkit-transition: all .2s;
            transition: all .2s;
            top: -.5em;
            left: .75rem;
            z-index: 3;
            line-height: 1;
            padding: 0 1px
        }

        .has-float-label label::after,
        .has-float-label>span::after {
            content: " ";
            display: block;
            position: absolute;
            background: #fff;
            height: 2px;
            top: 50%;
            left: -.2em;
            right: -.2em;
            z-index: -1
        }

        .has-float-label .form-control::-webkit-input-placeholder {
            opacity: 1;
            -webkit-transition: all .2s;
            transition: all .2s
        }

        .has-float-label .form-control:placeholder-shown:not(:focus)::-webkit-input-placeholder {
            opacity: 0
        }

        .has-float-label .form-control:placeholder-shown:not(:focus)+* {
            font-size: 150%;
            opacity: .5;
            top: .3em
        }

        .input-group .has-float-label {
            display: table-cell
        }

        .input-group .has-float-label .form-control {
            border-radius: .25rem
        }

        .input-group .has-float-label:not(:last-child),
        .input-group .has-float-label:not(:last-child) .form-control {
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            border-right: 0
        }

        .input-group .has-float-label:not(:first-child),
        .input-group .has-float-label:not(:first-child) .form-control {
            border-bottom-left-radius: 0;
            border-top-left-radius: 0
        }

        .has-float-label .form-control:placeholder-shown:not(:focus)+* {
            font-size: 100%;
            opacity: .7;
            top: 0.7em;
        }
		
		/* password validation */
		/* The message box is shown when the user clicks on the password field */
        #message {
            display: none;
            background: #f1f1f1;
            color: #000;
            position: relative;
            padding: 20px;
            margin-top: 10px;
        }

        #message p {
            padding: 10px 35px;
            font-size: 18px;
        }

        /* Add a green text color and a checkmark when the requirements are right */
        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        /* Add a red text color and an "x" when the requirements are wrong */
        .invalid {
            color: red;
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }
    </style>

 
<div class="wraper">

    <form method="POST" id="form" action="<?php echo site_url("admins/user_edit_admin");?>" id="commentForm" enctype="multipart/form-data">

    <input type="hidden" name="user_id"  value="<?php echo $user_dtls->user_id;?>"
				/>
        <div class="col-md-6 container form-wraper" style="margin-left: 0px;">

            <div class="form-header">

                <h4>User Entry</h4>

            </div>

            <div class="form-group row">

                <!-- <label for="user_id" class="col-sm-2 col-form-label">User ID:</label>

                <div class="col-sm-10">

                    <input type="text" class="form-control" name="user_id" id="user_id" />

                </div> -->

                <label for="name" class="col-sm-2 col-form-label">Name:</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="user_name" name="user_name" id="emp_cd" value="<?php echo $user_dtls->user_name; ?>" readonly/>
                </div>

            </div>


            <!-- <div class="form-group row">

                <label for="pass" class="col-sm-2 col-form-label">Password:</label>
                <div class="col-sm-4">
              
                <div class="input-group" id="show_hide_password">
                    <input class="form-control password" type="password" name="password" id="password">
                    <div class="input-group-addon">
                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                    </div>
                    </div>
                </div>


                <label for="name" class="col-sm-2 col-form-label">Confirm Password :</label>

                <div class="col-sm-4">
                    <input type="password" class="form-control confirm_password" name="confirm_password" id="confirm_password" />
                </div>

            </div> -->
            <!-- <?php if ($this->session->userdata['loggedin']['ho_flag'] == "Y") {   ?>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">User Type:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="user_type">
                            <option value="U">General User</option>
                            <option value="M">Manager</option>
                            <option value="A">Administator</option>
                        </select>
                    </div>

                </div>
            <?php  } ?> -->
            <div class="form-group row">

                <label for="name" class="col-sm-2 col-form-label">Employee Code:</label>

                <div class="col-sm-4">
                    <input type="text" class="form-control" name="employ_code" id="emp_cd" value="<?php echo $user_dtls->emp_code; ?>" readonly/>
                </div>

                <!-- <label for="name" class="col-sm-2 col-form-label">Name:</label>

                <div class="col-sm-4">
                    <input type="text" class="form-control" id="user_name" name="user_name" id="emp_cd" />
                </div> -->

            </div>


            <div class="form-group row">

                <label for="name" class="col-sm-2 col-form-label">Mobile No:</label>

                <div class="col-sm-4">
                    <input type="text" class="form-control" name="mobile_no" id="emp_cd"  value="<?php echo $user_dtls->phone_no; ?>" readonly/>
                </div>

                <label for="name" class="col-sm-2 col-form-label">Email:</label>

                <div class="col-sm-4">
                    <input type="email" class="form-control" name="email" id="emp_cd" value="<?php echo $user_dtls->email; ?>" readonly/>
                </div>

            </div>

            <div class="form-group row">

                <label for="name" class="col-sm-2 col-form-label">User Type:</label>

                <div class="col-sm-4">
                    <select name="userType" id="" class="form-control">
                        <option value="0">Select User Type</option>
                        <option value="U" <?php if($user_dtls->user_type=='U'){echo 'selected';} ?>>User</option>
                        <!-- <option value="M" <?php if($user_dtls->user_type=='M'){echo 'selected';} ?>>Manager</option>
                        <option value="A" <?php if($user_dtls->user_type=='A'){echo 'selected';} ?>>Admin</option>
                        <option value="C" <?php if($user_dtls->user_type=='C'){echo 'selected';} ?>>Accountant</option> -->
                        <?php if($this->session->userdata['loggedin']['branch_id'] == 342){ ?>
                           
                           <option value="S" <?php if($user_dtls->user_type=='S'){echo 'selected';} ?>>Super User</option>
   
                           <?php } ?>
                    </select>
                </div>

                <label for="name" class="col-sm-2 col-form-label">User Status:</label>

                <div class="col-sm-4">
                <select name="userStatus" id="userStatus" class="form-control">
                        <option value="">Select User Status</option>
                        <option value="U" <?php if($user_dtls->user_status=='U'){echo 'selected';} ?>>Pending</option>
                        <option value="A" <?php if($user_dtls->user_status=='A'){echo 'selected';} ?>>Active</option>
                        <option value="D" <?php if($user_dtls->user_status=='D'){echo 'selected';} ?>>Inactive</option>
                       
   
                </select>                
                </div>

            </div>

            <div class="form-group row remarks">

                <label for="name" class="col-sm-2 col-form-label">Remarks</label>

                <div class="col-sm-10">
                    <!-- <input type="text" class="form-control" name="remarks" id="remarks"  value=""/> -->
                    <textarea class="form-control" name="remarks" id="remarks"  rows="2"><?php echo $user_dtls->remarks; ?></textarea>
                </div>

            </div>




        

            <!-- <div class="form-group row">

                <label for="name" class="col-sm-2 col-form-label">Profile Pic:</label>

                <div class="col-sm-10">
                    <input type="file" class="form-control" name="pic" id="pic" />
                </div>

            </div> -->
            <input type="hidden" name="imgh" value="<?php echo $user_dtls->profile_pic; ?>">

            <!-- <img src="<?php echo base_url(); ?>/assets/uploads/<?php echo $user_dtls->profile_pic; ?>" alt="no image" width="100px" > -->
            <img src="https://benfed.in/benfed_fertilizer/assets/uploads/<?php if(!empty($user_dtls->profile_pic)){echo $user_dtls->profile_pic;}else{echo "avtar.png";}  ?>" alt="no image" width="100px" >
            <br>
            <br>
            

            <div class="form-group row">

                <div class="col-sm-10">

                    <input type="submit" class="btn btn-info" value="Update" id="signupForm" onclick="return checking();"/>

                </div>

            </div>

        </div>
        <div class="col-md-6 container" style="margin-left: 0px;">
        <div id="message">
                                            <h3>Password must contain the following:</h3>
                                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                            <p id="number" class="invalid">A <b>number</b></p>
                                            <p id="char" class="invalid">A <b>special character</b></p>
                                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                        </div>
        </div>

        
    </form>

</div>
<script>
    //  $('.remarks').hide();

     var userStatus = $("#userStatus").val();
        if(userStatus=='D'){
            $('.remarks').show();
        }else{
            $('.remarks').hide();
        }

    $('#userStatus').change(function(){
        var userStatus = $(this).val();
        if(userStatus=='D'){
            $('.remarks').show();
        }else{
            $('.remarks').hide();
        }
    });
</script>

<script>
    $("#form").validate();


    $(".toggle-password").click(function() {
        var pass = $('#pass').attr('type');
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (pass == "password") {

            $('#pass').attr('type', "text");

        } else {

            $('#pass').attr('type', "password");
        }
    });
</script>

<!-- password show and hide -->

<script>
      $(document).ready(function() {
      $("#show_hide_password i").on('click', function(event) {
          event.preventDefault();
          if($('#show_hide_password input').attr("type") == "text"){
              $('#show_hide_password input').attr('type', 'password');
              $('#show_hide_password i').addClass( "fa-eye-slash" );
              $('#show_hide_password i').removeClass( "fa-eye" );
          }else if($('#show_hide_password input').attr("type") == "password"){
              $('#show_hide_password input').attr('type', 'text');
              $('#show_hide_password i').removeClass( "fa-eye-slash" );
              $('#show_hide_password i').addClass( "fa-eye" );
          }
      });
  });
</script>
<script>
    $('#confirm_password').keyup(function(){
        var cpass=$(this).val();
        var pass=$('#password').val();
        var htmval='<label id="confirm_password-error" class="error" for="confirm_password">Please enter the same password as above.</label>';

    })
</script>

<!-- 
<script>
            var myInput = document.getElementById("password");
            var letter = document.getElementById("letter");
            var capital = document.getElementById("capital");
            var number = document.getElementById("number");
            var length = document.getElementById("length");
            var character = document.getElementById("char");
            var pass_val = false;

            $('#password').keyup(function () {
                // Validate lowercase letters
                var lowerCaseLetters = /[a-z]/g;
                if (myInput.value.match(lowerCaseLetters)) {
                    letter.classList.remove("invalid");
                    letter.classList.add("valid");
                } else {
                    letter.classList.remove("valid");
                    letter.classList.add("invalid");
                }

                // Validate capital letters
                var upperCaseLetters = /[A-Z]/g;
                if (myInput.value.match(upperCaseLetters)) {
                    capital.classList.remove("invalid");
                    capital.classList.add("valid");
                } else {
                    capital.classList.remove("valid");
                    capital.classList.add("invalid");
                }

                // Validate numbers
                var numbers = /[0-9]/g;
                if (myInput.value.match(numbers)) {
                    number.classList.remove("invalid");
                    number.classList.add("valid");
                } else {
                    number.classList.remove("valid");
                    number.classList.add("invalid");
                }

                // Special character
                var char = /[#?!@$%^&*-]/g;
                if (myInput.value.match(char)) {
                    character.classList.remove("invalid");
                    character.classList.add("valid");
                } else {
                    character.classList.remove("valid");
                    character.classList.add("invalid");
                }

                // Validate length
                if (myInput.value.length >= 8) {
                    length.classList.remove("invalid");
                    length.classList.add("valid");
                } else {
                    length.classList.remove("valid");
                    length.classList.add("invalid");
                }

                if (myInput.value.match(lowerCaseLetters) && myInput.value.match(upperCaseLetters) && myInput.value.match(numbers) && myInput.value.match(char) && myInput.value.length >= 8) {
                    pass_val = true;
                } else {
                    pass_val = false;
                }
            }).focus(function () {
                // focus code here
                $("#message").show();
            }).blur(function () {
                // blur code here
                $("#message").hide();
            });

        </script>
        <script>
            var pass_chk = false;
            $('#password').on('change', function(){
                var pass = $(this).val();
                var re_pass = $('#confirm_password').val();
                if(pass == re_pass) pass_chk = true;
                else pass_chk = false;
            })

            $('#confirm_password').on('change', function(){
                var re_pass = $(this).val();
                var pass = $('#password').val();
                if(pass == re_pass) pass_chk = true;
                else pass_chk = false;
            })
            function checking(){
             if(pass_val && pass_chk) return true;
             else 
             alert("password miss match");
             return false;
            }
        </script> -->

