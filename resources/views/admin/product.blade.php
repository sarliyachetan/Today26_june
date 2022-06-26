@extends('admin.layouts.layout')
@section('title','Product')
@section('content')
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Product
      </h1>
      <ol class="breadcrumb">
         <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="{{url('users')}}">Manage Product</a></li>
         <li class="active">List</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row" style="display: none;">
         <!-- left column -->
         <div class="col-md-8">
            <div class="box box-primary box-solid">
               <div class="box-header with-border">
                  <h3 class="box-title">Add Product</h3>
                  <!-- /.box-tools -->
               </div>
            </div>
            <!-- /.box -->
         </div>
         <!--/.col (left) -->
      </div>
      <!-- /.row -->
      <div class="row">
         <div class="col-xs-12">
            <div class="box box-primary box-solid">
               <div class="box-header with-border">
                  <h3 class="box-title">Product List</h3>
                  <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="GalleryCall"><i class="fa fa-plus"></i>  Add Product</a>
               </div>
               <!-- /.box-header -->
               <div class="box-body table-responsive">
                  <table id="user_tbl" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>ID.No</th>
                           <th>Product Name</th>
                           <th>Product Price</th>
                           <th>Product Desccription</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody>
                     <tfoot>
                     </tfoot>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
      </div>
   </section>
   <!-- model -->
   <div class="modal fade " id="GalleryModel">
      <div class="modal-dialog modal-lg">
         <div class="modal-content card-dark">
            <div class="modal-header">
               <h4 class="modal-title" id="modelHeading"> Product </h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <form id="saveFrm" method="post">
               <div class="alert alert-danger" style="display:none">
                  <!-- <p>Required</p> -->
               </div>
               @csrf
               <input type="hidden" name="id" id="id" value="">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                           <label for="product_name">Product Name</label>
                           <input type="text" class="form-control" id="product_name" name="product_name">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                           <label for="product_price">Product Price</label>
                           <input type="text" class="form-control" id="product_price" name="product_price">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 col-lg-12">
                        <div class="form-group">
                           <label for="product_desccription">Product Desccription</label>
                           <textarea class="form-control" id="product_desccription" name="product_desccription" cols="30" rows="5"></textarea>
                        </div>
                     </div>
                  </div>
                  <!-- image mutiple Image -->
                  <div class="tab-pane" id="tab_3">
                     <table id="product_image_tbl" class="table table-striped table-bordered table-hover">
                        <thead>
                           <tr>
                              <td class="text-left">Image</td>
                              <td></td>
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                           <tr>
                              <td colspan="3"></td>
                              <td class="text-center"><button type="button" data-toggle="tooltip" title="" class="btn btn-primary addProductImgRow" data-counter="0" data-original-title="Add Image"><i class="fa fa-plus-circle"></i></button></td>
                           </tr>
                        </tfoot>
                     </table>
                  </div>
                  <!-- image mutiple Image -->
               </div>
               <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary productSaveBtn">Save</button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <!-- end -->
   <!-- /.content -->
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=" crossorigin="anonymous"></script>
<script>
      $(function () {
      
         $('table').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
         });
         $('.select2').select2();
         function readURL(input) {
            if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.onload = function (e) {
                  $('#describe_img').attr('src', e.target.result);
               }
               reader.readAsDataURL(input.files[0]);
            }
         }
         $("#image_input").change(function () {
            readURL(this);
         });
         $.ajaxSetup({
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

      });
      $(document).ready(function() {
      
          $('#user_tbl').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url:  BASE_URL + '/product',
              type: 'GET',
          },
          columns: [  
          { data: 'id', name: 'id' },
          { data: 'product_name', name: 'product_name' },
          { data: 'product_price', name: 'product_price' },
          { data: 'product_desccription', name: 'product_desccription' },
          { data: 'action', name: 'action', orderable: false },
   
          ],
          order: [[0, 'desc']]
          });
   
   
      });

      $(document).ready(function(){
         $('#GalleryCall').click(function () {
         $('#savePriceBtn').val("create-Price");
         $('#id').val('');
         $('#saveFrm').trigger("reset");
         $('#GalleryModel').modal('show');
         });
      });
   

   function ProductDelete(id) {
   swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover User this  Data!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
   })
      .then((willDelete) => {
          if (willDelete) {
              $.ajax({
                  url: BASE_URL+ '/ProductDelete',
                  type: 'POST',
                  data: { 'id': id },
                  
                  success: function (response) {
                      if (response.status == "0") {
                          swal("Done!", "It was succesfully User Data deleted!", "success");
                          var table = $('#user_tbl').DataTable();
                          table.ajax.reload();
   
                      } else {
                          alert(response.message);
                      }
                  }
              });
          } else {
              swal("Your Data is safe!");
          }
      });
   }
   
   $(document).on("click", ".productSaveBtn", function () {
   
   var form = $('#saveFrm')[0];
   var formData = new FormData(form);
   jQuery('.alert-danger').hide().html('');
   
   $.ajax({
      url: 'productSave',
      data: formData,
      type: 'POST',
      // dataType: 'json',
      contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
      processData: false, // NEEDED, DON'T OMIT THIS
      success: function (json) {
          if (json.success) {
              form.reset();
              $('#saveFrm').trigger("reset");
              $('#GalleryModel').modal('hide');
              var table = $('#user_tbl').DataTable();
              table.ajax.reload(null, false);
          }
          if (json.errors) {
              jQuery.each(json.errors, function (key, value) {
                  jQuery('.alert-danger').show();
                  jQuery('.alert-danger').append('<p>' + value + '</p>');
              });
          }
      }
   });
   });
  
   // Add
   $(document).on("click", ".addOptionRow", function () {
		var counter = $(this).data('counter');
		$("#option_value_tbl tbody").append('<tr id="option-value-row' + counter + '"><td class="text-center"><input type="hidden" name="option_value[' + counter + '][option_value_id]" value=""><input type="text" name="option_value[' + counter + '][name]" value="" placeholder="Option Value Name" class="form-control"></td><td class="text-right"><button type="button" onclick="$(\'#option-value-row' + counter + '\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td></tr>');
		counter++;
		$(this).data('counter', counter);
		$('[data-toggle="tooltip"]').tooltip();
	});
   // Add Product Multiple Image
	$(document).on("click", ".addProductImgRow", function () {
		var counter = $(this).data('counter');		
		$("#product_image_tbl tbody").append('<tr id="image-row' + counter + '"><td class="text-left"><label><input type="file" style="display:none" name="image_arr[' + counter + ']" class="fileUpload" data-row="' + counter + '"></lable><img class="img-thumbnail" id="productImg' + counter + '" src="'+BASE_URL+'/../public/app_img/default/no_image-100x100.png" alt="" title="" data-placeholder="https://demo.opencart.com/image/cache/no_image-100x100.png"></td><td class="text-right"><input type="hidden" name="product_image[' + counter + '][product_img_id]" value=""></td><td class="text-center"><button type="button" onclick="$(\'#image-row' + counter + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td></tr>');
		counter++;		
		$(this).data('counter', counter);
		$('[data-toggle="tooltip"]').tooltip();
		$('.select2').select2();
	});
   // Product Image Preview
	$(document).on("change", ".fileUpload", function () {
		var row = $(this).data("row");
		console.log("row", row);
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#productImg' + row).attr('src', e.target.result).height(100).width(100);
			}
			reader.readAsDataURL(this.files[0]);
		}
	});
   $(document).on("change", ".imageUpload", function () {	
		if (this.files && this.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {				
				$('#categoryImg').attr('src', e.target.result).height(100).width(100);
			}
			reader.readAsDataURL(this.files[0]);
		}
	});

   $(document).on("click", ".productEdit", function () {
		var id = $(this).data('id');
		$('#form_product_title').html('Edit Product');
		jQuery('.alert-danger').hide().html('');
		$.ajax(
			{
				url: "productEdit/" + id,
				type: 'GET',
				success: function (json) {
					if (json.success) {
						$("html, body").animate({ scrollTop: 0 }, "slow");
                  $("#GalleryModel").modal('show');

						jQuery('#id').val((json.data.id) ? json.data.id : '');
						jQuery('#product_name').val((json.data.product_name) ? json.data.product_name : '');
						jQuery('#product_price').val((json.data.product_price) ? json.data.product_price : '');
						jQuery('#product_desccription').val((json.data.product_desccription) ? json.data.product_desccription : '');

						// Images 
						if(json.images && json.images.length > 0){
							$("#product_image_tbl tbody").html('');
							$(json.images).each(function(index,el){

								//-------------------------------------
								var img_path = (el.img_path) ? el.img_path  : BASE_URL+'/../public/app_img/default/no_image-100x100.png"]';
								var active_status 	= (el.status && el.status==1) ? 'selected'  : '';
								var deactive_status = (!el.status && el.status==0) ? 'selected'  : '';
								var counter = $('.addProductImgRow').data('counter');								
								$("#product_image_tbl tbody").append('<tr id="image-row' + counter + '"><td class="text-left"><label><input type="file" style="display:none" name="image_arr[' + counter + ']" class="fileUpload" data-row="' + counter + '"></lable><img class="img-thumbnail" id="productImg' + counter + '" src="'+img_path+'" alt="" title="" data-placeholder="'+img_path+'"></td><td class="text-right"><input type="hidden" name="product_image[' + counter + '][product_img_id]" value="' + el.id + '"><input type="hidden" name="product_image[' + counter + '][product_img_value]" value="' + el.image + '"></td><td class="text-center"><button type="button" onclick="$(\'#image-row' + counter + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td></tr>');
								$('#productImg' + counter).height(100).width(100);
								counter++;
								$('.addProductImgRow').data('counter', counter);
								$('[data-toggle="tooltip"]').tooltip();
								$('.select2').select2();								
								//-------------------------------------
							});
						}
						
			
						
					}
				}
			});
	});
   
</script>   
@endsection