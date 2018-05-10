<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo e(trans('text.chapter')); ?>      
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo e(trans('text.dashboard')); ?></a></li>
      <li><a href="<?php echo e(route('chapter.index')); ?>"><?php echo e(trans('text.chapter')); ?></a></li>
      <li class="active"><?php echo e(trans('text.add_new')); ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="<?php echo e(route('chapter.index')); ?>" style="margin-bottom:5px"><?php echo e(trans('text.back')); ?></a>
    <form role="form" method="POST" action="<?php echo e(route('chapter.store')); ?>">
    <div class="row">
      <!-- left column -->

      <div class="col-md-7">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><?php echo e(trans('text.add_new')); ?></h3>
          </div>
          <!-- /.box-header -->               
            <?php echo csrf_field(); ?>


            <div class="box-body">
              <?php if(count($errors) > 0): ?>
                  <div class="alert alert-danger">
                      <ul>
                          <?php foreach($errors->all() as $error): ?>
                              <li><?php echo e($error); ?></li>
                          <?php endforeach; ?>
                      </ul>
                  </div>
              <?php endif; ?>           
               <div class="form-group">
                    <label for="email"><?php echo e(trans('text.folder')); ?> <span class="red-star">*</span></label>
                    <select class="form-control req" name="folder_id" id="folder_id">
                        <option value="">-- <?php echo e(trans('text.choose')); ?> --</option>
                        <?php foreach( $folderList as $value ): ?>
                        <option value="<?php echo e($value->id); ?>"
                        <?php echo e(old('folder_id', $folder_id) == $value->id ? "selected" : ""); ?>                           
                        ><?php echo e($value->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>   
                <div class="form-group">
                    <label for="email"><?php echo e(trans('text.book')); ?> <span class="red-star">*</span></label>
                    <select class="form-control req" name="book_id" id="book_id">
                        <option value="">-- <?php echo e(trans('text.choose')); ?> --</option>
                        <?php foreach( $bookList as $value ): ?>
                        <option value="<?php echo e($value->id); ?>"
                        <?php echo e(old('book_id', $book_id) == $value->id ? "selected" : ""); ?>                           
                        ><?php echo e($value->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>   
                 <!-- text input -->
                <div class="form-group">
                  <label><?php echo e(trans('text.name')); ?><span class="red-star">*</span></label>
                  <input type="text" class="form-control" name="name" id="name" value="<?php echo e(old('name')); ?>">
                </div>
            </div>
            <!-- /.box-body -->
            
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm"><?php echo e(trans('text.save')); ?></button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="<?php echo e(route('chapter.index')); ?>"><?php echo e(trans('text.cancel')); ?></a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-5">
        
        </div>
        <!-- /.box -->     

      </div>
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<style type="text/css">
  .checkbox+.checkbox, .radio+.radio{
    margin-top: 10px !important;
  }
</style>
<input type="hidden" id="route_upload_tmp_image" value="<?php echo e(route('image.tmp-upload')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script type="text/javascript">
var h = screen.height;
var w = screen.width;
var left = (screen.width/2)-((w-300)/2);
var top = (screen.height/2)-((h-100)/2);
function openKCFinder_singleFile() {
      window.KCFinder = {};
      window.KCFinder.callBack = function(url) {
         $('#image_url').val(url);
         $('#thumbnail_image').attr('src', $('#app_url').val() + url);
          window.KCFinder = null;
      };
      window.open('<?php echo e(URL::asset("public/admin/dist/js/kcfinder/browse.php?type=images")); ?>', 'kcfinder_single','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
  }

    $(document).ready(function(){
       $('#folder_id').change(function(){       
        $.ajax({
                url : '<?php echo e(route('get-child')); ?>',
                data : {
                  mod : 'book',
                  col : 'folder_id',              
                  id : $(this).val()
                },
                type : 'POST',
                dataType : 'html',
                success : function(data){
                  $('#book_id').html(data);                                             
                }
              });
          });     
      $('#btnUploadImage').click(function(){        
        //$('#file-image').click();
        openKCFinder_singleFile();
      });     
      
      var files = "";
      $('#file-image').change(function(e){
         files = e.target.files;
         
         if(files != ''){
           var dataForm = new FormData();        
          $.each(files, function(key, value) {
             dataForm.append('file', value);
          });   
          
          dataForm.append('date_dir', 1);
          dataForm.append('folder', 'tmp');

          $.ajax({
            url: $('#route_upload_tmp_image').val(),
            type: "POST",
            async: false,      
            data: dataForm,
            processData: false,
            contentType: false,
            success: function (response) {
              if(response.image_path){
                $('#thumbnail_image').attr('src',$('#upload_url').val() + response.image_path);
                $( '#image_url' ).val( response.image_path );
                $( '#image_name' ).val( response.image_name );
              }
            }
          });
        }
      });
      
      $('#name').change(function(){
         var name = $.trim( $(this).val() );
        
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug').val( response.str );
                }                
              }
            });        
      });

    });
    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>