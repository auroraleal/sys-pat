<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Opções</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-building-o"></i> <span>Ação</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            
          </a>
          <ul class="treeview-menu">
          <?php if ($_SESSION['perfil'] == 'Administrador' || $_SESSION['perfil'] =='Técnico') { ?>
            <li><a href="/sys-pat/pages/acao/nova.php"><i class="fa fa-edit"></i>Nova Ação</a></li>
          <?php } ?>
            <li><a href="/sys-pat/pages/acao/listar.php"><i class="fa fa-list"></i> Listar</a></li>
          </ul>
        </li>

        <?php if ($_SESSION['perfil'] == 'Administrador') { ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i> <span>Usuários</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="/sys-pat/pages/usuarios/novo.php"><i class="fa  fa-user-plus "></i> Cadastrar</a></li>
              <li><a href="/sys-pat/pages/usuarios/listar.php"><i class="fa fa-users"></i> Listar</a></li>
              <li><a href="/sys-pat/pages/usuarios/listar_operacoes.php"><i class="fa fa-users"></i> Listar Operações</a></li>

              <?php } ?>
              <li><a href="/sys-pat/pages/usuarios/alterar-senha.php"><i class="fa fa-key"></i>Alterar senha</a></li>
            </ul>
          </li>
          <?php if ($_SESSION['perfil'] == 'Administrador') { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-briefcase"></i> <span>Administração</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <ul class="treeview-menu">
            <li><a href="/sys-pat/pages/relatorios/listar.php"><i class="fa   fa-filter"></i> Relatórios</a></li>
            <li class="treeview">
            <a href="#">
            <i class="fa   fa-archive"></i> <span>Programas</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <ul class="treeview-menu">
              <li><a href="/sys-pat/pages/programa/novo_tipo.php"><i class="fa  fa-pencil"></i>Cadastrar Programa</a></li>
              <li><a href="/sys-pat/pages/programa/listar.php"><i class="fa fa-list"></i>Listar Programas</a></li>
            </ul>
            <a href="#">
            <i class="fa fa-usd"></i> <span>Recurso</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <ul class="treeview-menu">
              <li><a href="/sys-pat/pages/recurso/novo_tipo.php"><i class="fa  fa-pencil"></i>Cadastrar Fonte</a></li>
              <li><a href="/sys-pat/pages/recurso/listar.php"><i class="fa fa-list"></i>Listar Fontes</a></li>
            </ul>

            <a href="#">
            <i class="fa   fa-thumb-tack"></i> <span>Função</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <ul class="treeview-menu">
              <li><a href="/sys-pat/pages/funcao/novo_tipo.php"><i class="fa  fa-pencil"></i>Cadastrar Função</a></li>
              <li><a href="/sys-pat/pages/funcao/listar.php"><i class="fa fa-list"></i>Listar Função</a></li>
            </ul>
            <a href="#">
            <i class="fa   fa-tasks"></i> <span>SubFunção</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <ul class="treeview-menu">
              <li><a href="/sys-pat/pages/subfuncao/novo_tipo.php"><i class="fa  fa-pencil"></i>Cadastrar SubFunção</a></li>
              <li><a href="/sys-pat/pages/subfuncao/listar.php"><i class="fa fa-list"></i>Listar SubFunções</a></li>
            </ul>

            <a href="#">
            <i class="fa   fa-building"></i> <span>Órgãos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <ul class="treeview-menu">
            <li><a href="/sys-pat/pages/orgao/novo.php"><i class="fa fa-edit"></i>Cadastrar Orgãos</a></li>
              <li><a href="/sys-pat/pages/orgao/listar.php"><i class="fa fa-list"></i>Listar Orgãos</a></li>
            </ul>

            <a href="#">
            <i class="fa   fa-money "></i> <span>Unidade Orçamentária</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <ul class="treeview-menu">
            <li><a href="/sys-pat/pages/unidade-orcamentaria/novo.php"><i class="fa fa-edit"></i>Cadastrar Unidade</a></li>
              <li><a href="/sys-pat/pages/unidade-orcamentaria/listar.php"><i class="fa fa-list"></i>Listar Unidades</a></li>
            </ul>
            </ul>
        </li>
      <?php } ?>
    </section>
    <!-- /.sidebar -->
  </aside>