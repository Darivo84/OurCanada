<style>
    .spinner-border.spinner-border-sm.temp {
        position: absolute;
        top: 0;
        right: 0;
        color: blue;
    }

    .form-group {
        position: relative;
    }
    .form-group.notes {

        background: aliceblue;
        padding: 15px;

    }
    .custom-control.custom-checkbox {

        margin-bottom: 10px;

    }
    .logo-lg img
    {
        width: 75px;
        height: 75px;
    }
    .logo-sm img
    {
        width: 75px;
        height: 75px;
    }
</style>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.php" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="../img/ourcanada.png" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="../img/ourcanada.png" alt="" height="17">
                                </span>
                    Our Canada
                </a>


                <a href="index.php" class="logo logo-light" style="color: white">
                                <span class="logo-sm">
                                    <img src="../img/ourcanada.png" alt="" height="22">
                                </span>
                    <span class="logo-lg">
                                    <img src="../img/ourcanada.png" alt="" height="19">
                                </span>
                    Our Canada

                </a>

            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                    data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>


            <!-- App Search-->
<!--            <form class="app-search d-none d-lg-block">-->
<!--                <div class="position-relative">-->
<!--                    <input type="text" class="form-control" placeholder="Search...">-->
<!--                    <span class="bx bx-search-alt"></span>-->
<!--                </div>-->
<!--            </form>-->


        </div>

        <div class="d-flex">


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="assets/images/users/admin.png"
                         alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ml-1">Admin</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-right">

                    <a class="dropdown-item " href="/admin/logout.php"><i
                                class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout</a>
                </div>
            </div>


        </div>
    </div>
</header>

<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">
                            <i class="bx bx-home-circle mr-2"></i>Dashboard
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="/admin/users">
                            <i class="bx bx-user mr-2"></i>Users
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="/admin/fields">
                            <i class="bx bx-tone mr-2"></i>Field Types
                        </a>

                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link " href="/admin/questions?id=10">
                            <i class="bx bx-customize mr-2"></i>Form
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="/admin/scoring">
                            <i class="bx bx-customize mr-2"></i>Scoring
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="/admin/global_rule">
                            <i class="bx bx-customize mr-2"></i>Global Rules
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="/admin/submited_forms">
                            <i class="bx bx-customize mr-2"></i>Submitted Forms
                        </a>

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link " href="/admin/auto-save-forms">
                            <i class="bx bx-customize mr-2"></i>Auto Saved Forms
                        </a>

                    </li>

                    <?php if($_SESSION['adminid']==1 || $_SESSION['adminid']==2) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link " href="/admin/activity">
                                <i class="bx bx-customize mr-2"></i>Activities
                            </a>

                        </li>
                    <?php } ?>

                </ul>
            </div>
        </nav>
    </div>
</div>