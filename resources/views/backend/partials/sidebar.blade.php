<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ URL::asset('public/admin/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->display_name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->    
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
     
      <li class="treeview {{ in_array($routeName, ['book.index', 'book.create', 'book.edit']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>{{ trans('text.book') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array($routeName, ['book.index', 'book.edit']) ? "class=active" : "" }}><a href="{{ route('book.index') }}"><i class="fa fa-circle-o"></i> {{ trans('text.the_list') }}</a></li>
          <li {{ in_array($routeName, ['book.create']) ? "class=active" : "" }}><a href="{{ route('book.create') }}"><i class="fa fa-circle-o"></i> {{ trans('text.add_new') }}</a></li>          
        </ul>
      </li>  
      <li class="treeview {{ in_array($routeName, ['chapter.index', 'chapter.create', 'chapter.edit']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>{{ trans('text.chapter') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array($routeName, ['chapter.index', 'chapter.edit']) ? "class=active" : "" }}><a href="{{ route('chapter.index') }}"><i class="fa fa-circle-o"></i> {{ trans('text.the_list') }}</a></li>
          <li {{ in_array($routeName, ['chapter.create']) ? "class=active" : "" }}><a href="{{ route('chapter.create') }}"><i class="fa fa-circle-o"></i> {{ trans('text.add_new') }}</a></li>          
        </ul>
      </li>
      <li class="treeview {{ in_array($routeName, ['author.index', 'author.create', 'author.edit']) ? 'active' : '' }}">
        <a href="#">
          <i class="fa fa-twitch"></i> 
          <span>{{ trans('text.author') }}</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {{ in_array($routeName, ['author.index', 'author.edit']) ? "class=active" : "" }}><a href="{{ route('author.index') }}"><i class="fa fa-circle-o"></i> {{ trans('text.the_list') }}</a></li>
          <li {{ in_array($routeName, ['author.create']) ? "class=active" : "" }}><a href="{{ route('author.create') }}"><i class="fa fa-circle-o"></i> {{ trans('text.add_new') }}</a></li>          
        </ul>
      </li>
      <li class="{{ in_array($routeName, ['page.index', 'page.create', 'page.edit']) ? 'active' : '' }}">
        <a href="{{ route('page.index') }}">
          <i class="fa fa-twitch"></i> 
          <span>{{ trans('text.page') }}</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<style type="text/css">
  .skin-blue .sidebar-menu>li>.treeview-menu{
    padding-left: 15px !important;
  }
</style>