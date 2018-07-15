<header class="main-header">

    <!-- Logo -->
    <a href="/sys-pat/pages/index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>PAT</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Sys-PAT Macapá</b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <ul class="nav navbar-nav navbar-left">
        <li>
          <a href="/sys-pat/pages/acao/listar.php"><icon class="fa fa-archive"></icon> Listar Todas as Ações </a>
        </li>
    </ul>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
                    
            </a>
          </li>
          <li class="dropdown user user-menu">
            <a href="#">
              <icon class="fa fa-user"></icon> <?php echo $_SESSION['email'] . ' - ' . $_SESSION['perfil']; ?>
            </a>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="/sys-pat/controllers/LogoutController.php">
              <i class="fa fa-sign-out"></i> Sair
            </a>
          </li>
        </ul>
      </div>

    </nav>
  </header>