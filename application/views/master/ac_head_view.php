<div class="wraper">

    <div class="row">

        <div class="col-lg-9 col-sm-12">

            <h1><strong>A/C Head Master</strong></h1>

        </div>

        <!-- </div> -->

        <div class="col-lg-12 container contant-wraper">

            <h3>
                <a href="<?php echo site_url("achead/entry"); ?>?id=" class="btn btn-primary" style="width: 100px;">Add</a>
                <span class="confirm-div" style="float:right; color:green;"></span>
            </h3>

            <div class="form-group row">

				<label for="ac_type" class="col-sm-1 col-form-label">Search :</label>

				<div class="col-sm-5">

                    <input type="text" class="form-control serch" id="serch" placeholder="Search" >
                </div>
            </div>

            <table class="table table-bordered table-hover" id="example">

                <thead>

                    <tr>
                        <th>Sl No.</th>
                        
                        <th>A/C Code</th>
                        <th>Branch</th>
                        <th>Group</th>
                        <th>Sub Group</th>
                        <th>A/C Head</th>
                        <th>Option</th>
                    </tr>

                </thead>

                <tbody id="stordata">

                    

                </tbody>

                <tfoot>

                    <tr>
                    <th>Sl No.</th>
                        
                        <th>A/C Code</th>
                        <th>Branch</th>
                        <th>Group</th>
                        <th>Sub Group</th>
                        <th>A/C Head</th>
                        <th>Option</th>
                    </tr>

                </tfoot>

            </table>
             <!-- ==================================== -->
        <div > </div>
        <nav aria-label="..." class="pagination_link">

</nav>






<!-- =================================== -->
        </div>
       
    </div>

</div>



<script>
	$(document).ready(function () {
				filter_test_data(1);

				function filter_test_data(page) {
					var action = 'fetch_data';
					
					let serch = $('#serch').val();
					


					$.ajax({
						url: "<?= site_url('Master/fetch_my_achead/') ?>" + page,
						method: "POST",
						dataType: "JSON",
						data: {
							action: action,
							serch: serch,
							
						},
						success: function (data) {

							$('#stordata').html(data.product_list);
							$('.pagination_link').html(data.pagination_link);
						}
					})
				}

        $(document).on('click', '.pagination_link li a', function(event){
        event.preventDefault();
        var page = $(this).data('ci-pagination-page');
        filter_test_data(page);
    	});

    // $('.common_selector').click(function(){
    //     filter_test_data(1);
    // });

	// $('.testSerch').click(function(){
    //     filter_test_data(1);
    // });
	// $('.payStatus').change(function(){
    //     filter_test_data(1);
    // });

	$('.serch').keyup(function(){
        filter_test_data(1);
    });
	// $('.stock').change(function(){
    //     filter_test_data(1);
    // });
	// $('.toDate').change(function(){
    //     filter_test_data(1);
    // });

});

</script>