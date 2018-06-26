<!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>tgui</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">tacacs<b>gui</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Apply changes button -->
            <li class="updatesBtn bg-yellow" style="display: none;">
            <a href="./api_update.php">
              <i class="fa fa-line-chart" style="display: none;"></i>
              <i class="fa fa-meh-o text-black" style="display: none;"></i>
              <i class="fa fa-spinner fa-pulse fa-fw"></i>
              <text></text>
              <span class="label label-success">!</span>
            </a>
            </li>
            <!-- Apply changes button -->
		        <li class="applyBtn bg-red" style="display: none;">
            <a href="./tac_configuration.php">
              <i class="fa fa-refresh"></i> Apply Changes
              <span class="label label-warning">!</span>
            </a>
            </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="dist/img/User-icon-colored-3.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs username">username</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="dist/img/User-icon-colored-3.png" class="img-circle" alt="User Image">

                <p>
                  <firstname_info></firstname_info><surname_info></surname_info>
                  <small><position_info></position_info></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
				<div class="pull-left">
                  <a href="/lockscreen.php" class="btn btn-default btn-flat"><i class="fa fa-lock"></i> Lock</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat" onclick="tgui_apiUser.signout()">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
