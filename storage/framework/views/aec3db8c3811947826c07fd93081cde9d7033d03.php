<header class="main-header">
  <!-- Logo -->
  <a href="<?php echo e(Auth::user()->id != 5 ? route('book.index') : route('orders.index')); ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>KHMERBETA</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>KHMERBETA</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
   
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">     
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">            
            <i class="fa fa-gears"></i><span class="hidden-xs"><?php echo e(trans('text.hello')); ?> <?php echo e(Auth::user()->full_name); ?></span>
          </a>
          <ul class="dropdown-menu">            
            <li class="user-footer">
            <div class="pull-left">
                <a href="<?php echo e(route('account.change-pass')); ?>" class="btn btn-success btn-flat"><?php echo e(trans('text.change_password')); ?></a>
              </div>             
              <div class="pull-right">

                <a href="<?php echo e(route('backend.logout')); ?>" class="btn btn-danger btn-flat"><?php echo e(trans('text.sign_out')); ?></a>
              </div>
            </li>
          </ul>
        </li>          
      </ul>
    </div>
  </nav>
</header>