<header class="app-header">
    <a class="app-header__logo"
        href="<?= base_url(); ?>"><?= (getSystemInfo()) ? getSystemInfo()["c_name"] : getSystemName(); ?></a>
    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"> <i
            class="fa fa-bars"></i> </a>

    <!-- Navbar Right Menu-->
    <ul class="app-nav">


        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i
                    class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="<?= base_url() ?>/users/profile"><i class="fa fa-user fa-lg"></i>
                        Perfil</a></li>
                <li><a class="dropdown-item" href="<?= base_url() ?>/LogOut"><i class="fa fa-sign-out fa-lg"></i> Cerrar
                        Sesión</a>
                </li>
            </ul>
        </li>
    </ul>
</header>