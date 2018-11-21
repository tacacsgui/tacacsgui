<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <!--<div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p> -->
          <!-- Status -->
       <!--  <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div> -->

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu" data-widget="tree">

    <?php function menu_constructor($menu = [], $ACTIVE_MENU_ID = []){
      if ( empty($menu) ) return false;
      foreach ($menu as $itemMenu) {
        if ($itemMenu['type'] == 1){
          echo '<li class="header '.$itemMenu['li-class'].'">'.$itemMenu['name'].'</li>';
          continue;
        }
        if ($itemMenu['submenuFlag'] == 1){
          echo '<li class="treeview grp_access_parent '.$itemMenu['li-class'].' '. ( ( in_array($itemMenu['id'], $ACTIVE_MENU_ID) ) ? 'active':'').'">
            <a href="#"><i class="'.$itemMenu['icon'].' '.$itemMenu['icon-class'].'"></i> <span>'.$itemMenu['name'].'</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i>
            </span></a>';
          echo '<ul class="treeview-menu">';
          menu_constructor($itemMenu['submenu'],$ACTIVE_MENU_ID);

          echo '</ul></li>';
        } else {
          echo '<li class=" grp_access '.$itemMenu['li-class'].' '. ( ( in_array($itemMenu['id'], $ACTIVE_MENU_ID) ) ? 'active':'').'"><a href="'.$itemMenu['href'].'"><i class="'.$itemMenu['icon'].' '.$itemMenu['icon-class'].'"></i> <span>'.$itemMenu['name'].'</span></a></li>';
        }
      }
    }
      menu_constructor($MAIN_MENU, $ACTIVE_MENU_ID);
    ?>

      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
