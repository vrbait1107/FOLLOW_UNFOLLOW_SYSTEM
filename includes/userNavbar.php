<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <a class="navbar-brand" href="#"><i class="fa fa-twitter fa-2x ml-5" aria-hidden="true"></i></a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search"
                aria-describedby="basic-addon2" />
            <div class="input-group-append">
                <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
</nav>



<!-- Side Navbar-->
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav text-center mt-4">
                    <a class="nav-link" href="index.php"><h5><i class="fa fa-home mx-2"></i>Home</h5></a>
                    <a class="nav-link" href="#"><h5><i class="fa fa-hashtag mx-2"></i>Explore</h5></a>
                    <a class="nav-link" href="#"><h5><i class="fa fa-bell mx-2"></i> Notification</h5></a>
                    <a class="nav-link" href="userProfile.php"><h5><i class="fa fa-user mx-2"></i>Profile</h5></a>
                </div>

                <div class="text-center mt-4">
                <button class="btn btn-primary px-5 rounded-pill">Tweet</button>
                </div>

                    <a class="nav-link collapsed mt-3 text-center" href="#" data-toggle="collapse" data-target="#options"
                        aria-expanded="false" aria-controls="options">
                        <h6 class="text-center"> Logged in By </h6>
                        <h5>@<?php echo $_SESSION['username']; ?>  <i class="fa fa-angle-down ml-2"></i> </h5>

                    </a>

                    <div class="collapse" id="options">
                        <nav class="sb-sidenav-menu-nested nav">
                           <a class="dropdown-item" href="userAccount.php">Account</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" id="logout" href="#">Log out</a>
                        </nav>
                    </div>

        </nav>
    </div>