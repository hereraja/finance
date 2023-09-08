    <div class="wraper">      
        <div class="row"> 
            <div class="col-lg-9 col-sm-12">
                <h1><strong>User List</strong></h1>
            </div>
        </div>
        <div class="col-lg-12 container contant-wraper">    
            <h3>

                <small><a href="<?php echo site_url("user_add");?>" class="btn btn-primary" style="width: 100px;">Add</a></small>
                <span class="confirm-div" style="float:right; color:green;"></span>

            </h3>

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>
                    
                        <th>Sl. No.</th>
                        <th>Name</th>
						<th>Employee code</th>
                        <th>User Type</th>
                        <th>User Id</th>
                        <th>Option</th>

                    </tr>

                </thead>

                <tbody> 

                    <?php 
                    
                    if($user_dtls) {

                        $i = 0;
                        
                            foreach($user_dtls as $u_dtls) {

                    ?>

                            <tr>

                                <td><?php echo ++$i; ?></td>
                                <td><?php echo $u_dtls->user_name; ?></td>
								<td><?php echo $u_dtls->emp_code; ?></td>
                                <td><?php if($u_dtls->user_type == 'A'){
                                            echo '<span class="badge badge-success">Admin</span>';
                                          }
                                          elseif ($u_dtls->user_type == 'M') {
                                            echo '<span class="badge badge-warning">Super User</span>';
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
                                        title="Edit"
                                    >

                                        <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                        
                                    </a>

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                 <!--   <button 
                                        type="button"
                                        class="delete"
                                        id="<?php //echo $u_dtls->user_id; ?>"
                                        data-toggle="tooltip"
                                        data-placement="bottom" 
                                        title="Delete"
                                        >

                                        <i class="fa fa-trash-o fa-2x" style="color: #bd2130"></i>
                                    </button> -->
                                    
                                </td>

                            </tr>

                    <?php
                            
                            }

                        }

                        else {

                            echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";

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

    });

    <?php } ?>
</script>
