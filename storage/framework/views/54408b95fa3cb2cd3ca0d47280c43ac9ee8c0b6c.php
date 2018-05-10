<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo e(trans('text.change_password')); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo e(trans('text.dashboard')); ?></a></li>      
      <li class="active"><?php echo e(trans('text.change_password')); ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">    
    <form role="form" method="POST" action="<?php echo e(route('account.store-pass')); ?>" id="formData">
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
               <?php if(Session::has('message')): ?>
              <p class="alert alert-info" ><?php echo e(Session::get('message')); ?></p>
              <?php endif; ?>
              <?php if(count($errors) > 0): ?>
                  <div class="alert alert-danger">
                      <ul>
                          <?php foreach($errors->all() as $error): ?>
                              <li><?php echo e($error); ?></li>
                          <?php endforeach; ?>
                      </ul>
                  </div>
              <?php endif; ?>
                 
                 <!-- text input -->
                <div class="form-group">
                  <label><?php echo e(trans('text.current_password')); ?><span class="red-star">*</span></label>
                  <input type="password" class="form-control" name="old_pass" id="old_pass" value="">
                </div>
                 <div class="form-group">
                  <label><?php echo e(trans('text.new_password')); ?> <span class="red-star">*</span></label>
                  <input type="password" class="form-control" name="new_pass" id="new_pass" value="">
                </div>  
                <div class="form-group">
                  <label><?php echo e(trans('text.confirm_password')); ?> <span class="red-star">*</span></label>
                  <input type="password" class="form-control" name="new_pass_re" id="new_pass_re" value="">
                </div>                
                
            </div>
            <div class="box-footer">
              <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave"><?php echo e(trans('text.save')); ?></button>             
            </div>
            
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script type="text/javascript">
    $(document).ready(function(){
      $('#formData').submit(function(){
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
    });
    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>