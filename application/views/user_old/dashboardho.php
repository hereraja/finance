    <div class="wraper">      
        <div class="row"> 
            <div class="col-lg-9 col-sm-12">
                <h1><strong>User List</strong></h1>
            </div>
        </div>
        <div class="col-lg-12 container contant-wraper">    
            <h3>

                <small><a href="<?php echo site_url("user_add");?>" class="btn btn-primary" style="width: 100px;">Add</a>
				<center><input type="radio" id="html" name="user_status" value="U">
				<label for="approve">Unapprove</label>
				<input type="radio" id="css" name="user_status" value="A"> <label for="html">Approve</label></center>
				
				</small>
				
                <span class="confirm-div" style="float:right; color:green;"></span>

            </h3>

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>
                    
                        <th>Sl. No.</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>User Id</th>
                        <th>Option</th>

                    </tr>

                </thead>

                <tbody id='user_list'> 

                    <?php 
                    
                    if($user_dtls) {

                        $i = 0;
                        
                            foreach($user_dtls as $u_dtls) {

                    ?>

                            <tr>
                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $u_dtls->user_name; ?></td>
								
                                <td><?php if($u_dtls->user_type == 'A'){
                                            echo '<span class="badge badge-success">Admin</span>';
                                          }
                                          elseif ($u_dtls->user_type == 'M') {
                                            echo '<span class="badge badge-warning">Manager</span>';
                                          }elseif ($u_dtls->user_type == 'D') {
                                            echo '<span class="badge badge-warning">Accountant</span>';
                                          }elseif ($u_dtls->user_type == 'U') {
                                            echo '<span class="badge badge-dark">General User</span>';
                                          }
                                            ?>
                                </td>
                                <td><?php echo $u_dtls->user_id; ?></td>
                                <td>
                                    <a href="admins/user_edit?user_id=<?php echo $u_dtls->user_id; ?>" 
                                        data-toggle="tooltip"
                                        data-placement="bottom" 
                                        title="Edit">
                                        <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                    </a>
                                </td>
                            </tr>
                    <?php
                            
                            }

                        }

                        else {

                            echo "<tr><td colspan='6' style='text-align: center;'>No data Found</td></tr>";

                        }
                    ?>
                
                </tbody>

                <tfoot>

                    <tr>
                    
                        <th>Sl. No.</th>
                        <th>Name</th>
                        <th>User Type</th>
                        <th>User Id</th>
                        <th>Option</th>

                    </tr>
                
                </tfoot>

            </table>
            
        </div>

    </div>

<script>

    $(document).ready( function (){

        $('.delete').click(function () {

            var id = $(this).attr('id');

            var result = confirm("Do you really want to delete this record?");

            if(result) {

                window.location = "<?php echo site_url('admin/user/delete?user_id="+id+"');?>";

            }
            
        });

    });

</script>

<script>
   
    $(document).ready(function() {

    $('.confirm-div').hide();

    <?php if($this->session->flashdata('msg')){ ?>

    $('.confirm-div').html('<?php echo $this->session->flashdata('msg'); ?>').show();
	
	<?php } ?>

    });
	
	$(document).ready( function (){

        $('input[type=radio][name=user_status]').on('change', function() {
			
			$.ajax({
				type: "GET",
				url: "<?php echo site_url('admins/get_userlist'); ?>",
				data: {
					user_status: $(this).val()
				},
				success: function(result) {
				   
					  var string = '';
					  var sl_no = 1;
					  var  utype = '';
					$.each(JSON.parse(result), function( index, value ) {
						
						if(value.user_type == 'A'){
                          utype = '<span class="badge badge-success">Admin</span>';
					    }else if (value.user_type == 'M') {
                            utype = '<span class="badge badge-warning">Manager</span>';
                        }else if (value.user_type == 'U') {
                             utype = '<span class="badge badge-dark">General User</span>';
                            }

						string += '<tr><td>'+ sl_no++ +'</td><td>' + value.user_name + '</td><td>' + utype + '</td><td>' + value.branch_name + '</td><td><a href="admins/user_edit?user_id=' + value.user_id + '" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-edit fa-2x" style="color: #007bff"></i></a></td></tr>'
                     
					});
					$('#user_list').html();
					$('#user_list').html(string);
					
				}
            });
		  
		});

    });
	

    
</script>
