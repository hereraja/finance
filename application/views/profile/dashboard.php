<div class="wraper">      

<div class="col-md-6 container form-wraper">

    <div class="form-header">
        
        <h4 >Change Password</h4>
        <h5 style="padding: 0;" class="alert"></h5>
     
    </div>

    <form class="form-horizontal form-material" 
            method="post"
            action="<?php echo site_url('profiles/changepass')?>"
        >
        <div class="form-group">
            <label class="col-md-12">Old Password</label>
            <div class="col-md-12">
                <input type="password" name="old_pass" class="form-control form-control-line">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12">New Password</label>
            <div class="col-md-12">
                <input type="password" name="new_pass" id="new_pass" class="form-control form-control-line">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-12">Confirm Password</label>
            <div class="col-md-12">
                <input type="password" id="con_pass" class="form-control form-control-line">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <button class="btn btn-primary" id="btnSubmit">Update Password</button>
            </div>
        </div>
    </form>

    </div>

</div>

<script>

    $("#form").validate();

</script>

<script type="text/javascript">
    $("#btnSubmit").click(function () {
        var password = $("#new_pass").val();
        var confirmPassword = $("#con_pass").val();
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        else{
            document.getElementById("btnSubmit").type = 'submit';
            return true;
        }
        
    });
</script>

<script>
   
    $(document).ready(function() {

    $('.alert').hide();

        <?php if($this->session->flashdata('msg')['message']){ ?>

            $('.alert').html('<?php echo $this->session->flashdata('msg')['message']; ?> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>').show();

        <?php } ?>

        });
    
</script>