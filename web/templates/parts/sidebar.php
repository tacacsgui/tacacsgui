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
		<?php foreach ($MAIN_MENU as $itemMenu){
				if ($itemMenu['type']){
					echo '<li class="header '.$itemMenu['li-class'].'">'.$itemMenu['name'].'</li>';
				} else {
					if ($itemMenu['submenuFlag']){
						echo '<li class="treeview grp_access_parent '.$itemMenu['li-class'].' '. (($itemMenu['id']==$ACTIVE_MENU_ID) ? 'active':'').'">
							<a href="#"><i class="'.$itemMenu['icon'].' '.$itemMenu['icon-class'].'"></i> <span>'.$itemMenu['name'].'</span>
							<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i>
							</span></a>';
						echo '<ul class="treeview-menu">';
						foreach ($itemMenu['submenu'] as $subitemMenu){
							echo '<li class=" grp_access '.$subitemMenu['li-class'].' '. (($subitemMenu['id']==$ACTIVE_SUBMENU_ID) ? 'active':'').'"><a href="'.$subitemMenu['href'].'"><i class="'.$subitemMenu['icon'].' '.$subitemMenu['icon-class'].'"></i> '.$subitemMenu['name'].'</a></li>';
						}
						echo '</ul></li>';
					} else {
						echo '<li class=" grp_access '.$itemMenu['li-class'].' '. (($itemMenu['id']==$ACTIVE_MENU_ID) ? 'active':'').'"><a href="'.$itemMenu['href'].'"><i class="'.$itemMenu['icon'].' '.$itemMenu['icon-class'].'"></i> <span>'.$itemMenu['name'].'</span></a></li>';
					}
				}
			}
		?>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
