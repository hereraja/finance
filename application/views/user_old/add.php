<style>
.field-icon {
  float: right;
  margin-left: -25px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}
</style>
<div class="wraper">      

        <form method="POST" 
            id="form"
            action="<?php echo site_url("admins/user_add");?>" >

            <div class="col-md-6 container form-wraper" style="margin-left: 0px;">

                <div class="form-header">
                
                    <h4>User Entry</h4>
                
                </div>

                <div class="form-group row">

                    <label for="user_id" class="col-sm-2 col-form-label">User ID:</label>

                    <div class="col-sm-10">

                        <input type="text"
                                class="form-control required"
                                name="user_id"
                                id="user_id"
                            />

                    </div>

                </div>
				<div class="form-group row">

                    <label for="user_id" class="col-sm-2 col-form-label">Employee Code:</label>

                    <div class="col-sm-10">

                        <input type="text"
                                class="form-control required"
                                name="emp_code"
                                id="emp_code"
                            />

                    </div>

                </div>
                
                <div class="form-group row">

                    <label for="pass" class="col-sm-2 col-form-label">Password:</label>
						<div class="col-sm-10">
                        <input  type="password"
                                class="form-control"
                                name="pass"
                                id="pass"
                                value="123"
                            />
						<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
						</div>

                </div>
				<?php if($this->session->userdata['loggedin']['ho_flag']=="Y") {   ?>
                <div class="form-group row">
				<label for="name" class="col-sm-2 col-form-label">User Type:</label>
				<div class="col-sm-10">
					<select class="form-control" name="user_type" required>
						 <option value="U">General User</option>
						 <option value="M">Manager</option>
						 <option value="A">Administator</option>
					</select>
				</div>

				</div> 
                <?php  } ?>
                <div class="form-group row">

                    <label for="name" class="col-sm-2 col-form-label">User Name:</label>

                    <div class="col-sm-10">
                    <input type="text"
                                class="form-control required"
                                name="user_name"
                                id="emp_cd"
                            />
                    </div>

                </div>
				<div class="form-group row">

                    <label for="name" class="col-sm-2 col-form-label">Designation:</label>

                    <div class="col-sm-10">
                    <input type="text"
                                class="form-control required"
                                name="designation"
                                id="designation"
                            />
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-sm-10">

                        <input type="submit" class="btn btn-info" value="Save" />

                    </div>

                </div>

            </div>
                
           <!-- <div class="col-md-5 container form-wraper" style="margin-left: 10px; width: 48%;">            

                <div class="form-header">
                    
                    <h4>Allot Departments</h4>
                
                </div>

                <table class="table table-bordered table-hover">

                    <tbody> 

                        <tr>
                            <td><input type="checkbox" name="depts[]" value="f" /> Accounts & Finance</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="depts[]" value="pr" /> Payroll</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="depts[]" value="pd" /> Paddy</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="depts[]" value="d" /> Disaster Management</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="depts[]" value="s" /> Social welfare</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox" name="depts[]" value="st" /> Stationary</td>
                        </tr>

                    </tbody>

                </table>

            </div> -->
        </form>

    </div>

<script>

    $("#form").validate();
	
	
    $(".toggle-password").click(function() {
        var pass = $('#pass').attr('type');
        $(this).toggleClass("fa-eye fa-eye-slash");
		var input = $($(this).attr("toggle"));
		if (pass == "password") {
			
			$('#pass').attr('type', "text");
			
		}else {
			
			$('#pass').attr('type', "password");
		}
    });

</script>

