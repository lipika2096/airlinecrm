<?php include('./layouts/head');?>

<body>
		<!-- start: Header -->
	<?php include('./layouts/header');?>
      
			<!-- start: Content -->
			<div id="content" class="span10" >
       
            <div class="alert alert-success">
                 session('success')   
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
        
			
		  <ul class="breadcrumb">
       <li>
					<i class="fa-solid fa-house"></i>
					<a href="index.html">Home</a> 
					<i class="fa-solid fa-angle-right"></i>
				</li>
        <li><a href="#">Dashboard</a></li>
      </ul> --  

      <div class="row-fluid hideInIE8 circleStats">
        <div class="row-fluid"> 

          <div class="row-fluid sortable">
        <div class="box span12">
          <div class="box-header" data-original-title>
            <h2><i class="halflings-icon edit"></i><span class="break"></span>Account / Address Detail</h2>
          <div class="box-icon">
							<a href="#" class="btn-setting"><i class="fa-solid fa-wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="fa-solid fa-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="fa-solid fa-xmark "></i></a>
						</div>
          </div>
          <div class="box-content">
            <form class="form-horizontal" action="{{route('admin-account.store')  " method="POST">
             
              <fieldset>
              <div class="control-group">
                <label class="control-label" for="typeahead">Account </label>
                <div class="controls">
                <textarea name="account" required="" class="span6 typeahead"></textarea>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="typeahead">Address </label>
                <div class="controls">
                <textarea name="address" required="" class="span6 typeahead"></textarea>
                </div>
              </div>

              <div class="form-actions">
                <input type="submit" class="btn btn-primary" name="submit" value="Submit"/>
                
              </div>
              </fieldset>
            </form>   

          </div>
        </div><!--/span-->
        <div class="box span12">
          <div class="box-header" data-original-title>
            <h2><i class="halflings-icon user"></i><span class="break"></span>Account / Address Detail</h2>
            
          </div>
          <div class="box-content" style="min-height: 1000px;">
            <table class="table table-bordered bootstrap-datatable datatable" data-url="{{route('admin-account.show',1)  ">
              <thead>
                <tr>
                  <th>Sr No.</th>
                  <th>Account</th>
                  <th>Address</th>
                 
                 
                  <th colspan="2">Actions</th>
                </tr>
              </thead>   
              <tbody>
                @foreach($accounts as $index => $account)
                    <tr>
                        <td> $index + 1   </td>
                        <td class="center"> $account->account   </td>
                        <td class="center"> $account->address   </td>
                        <td class="center">
                            <a class="btn btn-primary open-modal" data-target="#accountModal{{$account->id  " >
                                <i class="fa fa-pencil"></i>
                            </a>
                            <form action=" admin-account.destroy', $account->id)   " method="POST" onsubmit="return confirm('Are you sure you want to delete this account?');">
                               
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <div class="custom-modal" id="accountModal{{$account->id  ">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title">Edit Master Data</h5>
                              <button type="button" class="close-modal" data-target="#accountModal{{$account->id  ">
                                  <span>&times;</span>
                              </button>
                          </div>
                          <form method="POST" action=" admin-account.update', $account->id)   ">
                             
                              @method('PUT')
                              <div class="modal-body">
                                  <div class="row">
                                      <div class="col-md-6">
                                          <input type="hidden" name="_method" value="PUT">
                                          <div class="form-group">
                                              <label for="name">Account</label>
                                              <input type="text" name="account" id="account" class="form-control" value=" $account->account   " required>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                              <label for="name">Address</label>
                                              <input type="text" name="address" id="address" class="form-control" value=" $account->address   " required>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary close-modal" data-target="#accountModal{{$account->id  ">Close</button>
                                  <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                              </div>
                          </form>
                      </div>
                    </div>
                @endforeach
            </tbody>
            </table>            
          </div>
        </div><!--/span-->

      </div><!--/row-->
        
        
        <div class="clearfix"></div>
                
      </div><!--/row-->
      
       

  </div><!--/.fluid-container-->
  
      <!-- end: Content -->
    </div><!--/#content.span10-->
    </div><!--/fluid-row-->

  
  <div class="clearfix"></div>
  
  <?php include('./layouts/footer');?>
	
	<!-- start: JavaScript-->

		<?php include('./layouts/foot');?>

<!-- Custom CSS for Modal -->
<style>
.custom-modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
    background: rgba(0, 0, 0, 0.5);
}

.modal-content {
    position: relative;
    margin: 10% auto;
    padding: 20px;
    width: 80%;
    max-width: 500px;
    background: #fff;
    border-radius: 5px;
}

.modal-header, .modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
}
</style>

<!-- Custom JavaScript for Modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var openModalButtons = document.querySelectorAll('.open-modal');
    var closeModalButtons = document.querySelectorAll('.close-modal');

    openModalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var target = this.getAttribute('data-target');
            document.querySelector(target).style.display = 'block';
        });
    });

    closeModalButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var target = this.getAttribute('data-target');
            document.querySelector(target).style.display = 'none';
        });
    });
});
</script>