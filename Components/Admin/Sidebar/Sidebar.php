<?php
$Dashboard = '../../Admin/Dashboard/Dashboard.php';
$Products = '../../Admin/Products/Product_Inv.php';
$SellerDashboard = '../../Seller/Dashboard/Dashboard.php';
$Home = '../../Home/Homepage.php';
$Filename = basename($_SERVER['PHP_SELF']);
$Filename = explode('.', $Filename)[0];
switch ($Filename) {
    case 'Dashboard':
        $Title = 'Dashboard';
        break;
    case 'Product_Inv':
        $Title = 'Products';
        break;
    case 'Account-Admin':
        $Title = 'Administrators';
        break;
    case 'Account-Seller':
        $Title = 'Sellers';
        break;
    case 'Account-Users':
        $Title = 'Users';
        break;
    default:
        $Title = 'Undefined';
        break;
}
?>
<!-- Navbar -->
<nav
    class="navbar navbar-expand-lg bg-body-tertiary bg-opacity-75 bg-blur-3 border-bottom shadow-sm fixed-top d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none">
    <div class="container-fluid">
        <div class="col-md-3 mb-2 mb-md-0 me-5">
            <a href="<?php $_SERVER['PHP_SELF']; ?>" class="d-inline-flex link-body-emphasis text-decoration-none">
                <svg class="bi my-1" width="40" height="32">
                    <use xlink:href="#Admin" />
                </svg>
                <span class="fs-4 my-1"><?php echo $Title; ?></span>
            </a>
        </div>
        <button class="navbar-toggler nb-t" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <?php if ($UserRole == 'admin') { ?>
                    <li class="nav-item">
                        <a href="<? echo $Dashboard ?>"
                            class="nlinks <?php echo $Title == 'Dashboard' ? 'nav-active' : 'link-body-emphasis'; ?>"
                            aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Dashboard" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                <?php } ?>
                <?php if ($UserRole == 'seller') { ?>
                    <li class="nav-item">
                        <a href="<?php echo $SellerDashboard; ?>"
                            class="nlinks <?php echo $Title == 'Dashboard' ? 'nav-active' : 'link-body-emphasis'; ?>"
                            aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Dashboard" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $Products; ?>"
                            class="nlinks <?php echo $Title == 'Products' ? 'nav-active' : 'link-body-emphasis'; ?>"
                            aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Products" />
                            </svg>
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nlinks active collapsed" data-bs-toggle="collapse"
                            data-bs-target="#orders-collapse">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Order" />
                            </svg>
                            <span class="d-inline-flex">
                                Orders
                                <svg class="pe-none NV-Icon" width="24" height="24">
                                    <use xlink:href="#Arrow-Down" />
                                </svg>
                            </span>
                        </a>
                        <div class="collapse" id="orders-collapse">
                            <ul class="nav nav-pills flex-column mb-auto list-unstyled fw-normal">
                                <li class="border-top"></li>
                                <li>
                                    <a href="#"
                                        class="nlinks <?php echo $Title == 'Status1' ? 'nav-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#grid" />
                                        </svg>
                                        Status 1
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="nlinks <?php echo $Title == 'Status2' ? 'nav-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#grid" />
                                        </svg>
                                        Status 2
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="nlinks <?php echo $Title == 'Status3' ? 'nav-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#grid" />
                                        </svg>
                                        Status 3
                                    </a>
                                </li>
                                <li class="border-top"></li>
                            </ul>
                        </div>
                    </li>
                <?php } ?>
                <?php if ($UserRole == 'admin') { ?>
                    <li class="nav-item">
                        <a href="#"
                            class="nlinks collapsed
                    <?php echo $Title == 'Administrators' || $Title == 'Sellers' || $Title == 'Users' ? 'nav-active' : 'link-body-emphasis'; ?>"
                            data-bs-toggle="collapse" data-bs-target="#account-collapse">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Account" />
                            </svg>
                            <span class="d-inline-flex">
                                Accounts
                                <svg class="pe-none NV-Icon" width="24" height="24">
                                    <use xlink:href="#Arrow-Down" />
                                </svg>
                            </span>
                        </a>
                        <div class="collapse" id="account-collapse">
                            <ul class="nav flex-column mb-auto list-unstyled fw-normal">
                                <li class="border-top"></li>
                                <li>
                                    <a href="../Accounts/Account-Admin.php"
                                        class="nlinks <?php echo $Title == 'Administrators' ? 'nav-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#Account" />
                                        </svg>
                                        Administrators
                                    </a>
                                </li>
                                <li>
                                    <a href="../Accounts/Account-Seller.php"
                                        class="nlinks <?php echo $Title == 'Sellers' ? 'nav-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#Account" />
                                        </svg>
                                        Sellers
                                    </a>
                                </li>
                                <li>
                                    <a href="../Accounts/Account-Users.php"
                                        class="nlinks <?php echo $Title == 'Users' ? 'nav-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#Account" />
                                        </svg>
                                        Users
                                    </a>
                                </li>
                                <li class="border-top"></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nlinks <?php echo $Title == 'Reports' ? 'nav-active' : 'link-body-emphasis'; ?>">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Reports" />
                            </svg>
                            Reports
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <hr>
            <div class="dropdown dropup">
                <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle 
                        " data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong><?php echo $Username; ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow">
                    <h3 class="dropdown-header">
                        <div class="d-flex justify-content-center">
                            <img src="https://github.com/mdo.png" alt="mdo" width="48" height="48"
                                class="rounded-circle">
                        </div>
                        <div class="d-flex justify-content-center" style="max-width: 200px;">
                            <p class="dropdown-item-text px-2 text-truncate fw-bold fs-6" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-trigger="hover" data-bs-title="Username">
                                <?php echo $Username; ?></p>
                        </div>
                        <div class="text-center" style="margin-top: -15px;">
                            <small class="text-muted">Administrator</small>
                        </div>
                    </h3>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="<?php echo $Home; ?>">Homepage</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-text text-center">
                            <svg class="my-1" width="16" height="16" role="img" aria-label="Logout">
                                <use xlink:href="#Logout" />
                            </svg> Sign out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<hr style="height: 66px; margin: 0;">
<!-- Sidebar -->
<main
    class="d-none d-sm-none d-md-block d-lg-block d-xl-block d-xxl-block shadow-sm bg-body-tertiary bg-opacity-75 bg-blur-3">
    <aside class="d-flex flex-nowrap sidebar-height border-end">
        <div class="d-flex flex-column flex-shrink-0 p-3" style="width: 250px;">
            <a href="<?php echo $Home; ?>"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <svg class="bi pe-none me-2" width="40" height="32">
                    <use xlink:href="#Admin" />
                </svg>
                <span class="fs-4"><?php echo $Title; ?></span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <?php if ($UserRole == 'admin') { ?>
                    <li class="nav-item">
                        <a href="<?php echo $Dashboard; ?>"
                            class="nav-link <?php echo $Title == 'Dashboard' ? 'side-active' : 'link-body-emphasis'; ?>"
                            aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Dashboard" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                <?php }
                if ($UserRole == 'seller') { ?>
                    <li>
                        <a href="<?php echo $SellerDashboard; ?>"
                            class="nav-link <?php echo $Title == 'Dashboard' ? 'nav-active' : 'link-body-emphasis'; ?>"
                            aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Dashboard" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $Products; ?>"
                            class="nav-link <?php echo $Title == 'Products' ? 'side-active' : 'link-body-emphasis'; ?>">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Products" />
                            </svg>
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis collapsed" data-bs-toggle="collapse"
                            data-bs-target="#orders-collapse">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Order" />
                            </svg>
                            <span class="d-inline-flex">
                                Orders
                                <svg class="pe-none NV-Icon" width="24" height="24">
                                    <use xlink:href="#Arrow-Down" />
                                </svg>
                            </span>
                        </a>
                        <div class="collapse" id="orders-collapse">
                            <ul class="nav nav-pills flex-column mb-auto list-unstyled fw-normal">
                                <li class="border-top"></li>
                                <li>
                                    <a href="#"
                                        class="nav-link <?php echo $Title == 'Status1' ? 'side-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#grid" />
                                        </svg>
                                        Status 1
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="nav-link <?php echo $Title == 'Status2' ? 'side-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#grid" />
                                        </svg>
                                        Status 2
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="nav-link <?php echo $Title == 'Status3' ? 'side-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#grid" />
                                        </svg>
                                        Status 3
                                    </a>
                                </li>
                                <li class="border-top"></li>
                            </ul>
                        </div>
                    </li>
                <?php }
                if ($UserRole == 'admin') { ?>
                    <li>
                        <a href="#"
                            class="nav-link collapsed
                    <?php echo $Title == 'Administrators' || $Title == 'Sellers' || $Title == 'Users' ? 'side-active' : 'link-body-emphasis'; ?>"
                            data-bs-toggle="collapse" data-bs-target="#account-collapse">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Account" />
                            </svg>
                            <span class="d-inline-flex">
                                Accounts
                                <svg class="pe-none NV-Icon" width="24" height="24">
                                    <use xlink:href="#Arrow-Down" />
                                </svg>
                            </span>
                        </a>
                        <div class="collapse" id="account-collapse">
                            <ul class="nav nav-pills flex-column mb-auto list-unstyled fw-normal">
                                <li class="border-top"></li>
                                <li>
                                    <a href="../Accounts/Account-Admin.php"
                                        class="nav-link <?php echo $Title == 'Administrators' ? 'side-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#Account" />
                                        </svg>
                                        Administrators
                                    </a>
                                </li>
                                <li>
                                    <a href="../Accounts/Account-Seller.php"
                                        class="nav-link <?php echo $Title == 'Sellers' ? 'side-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#Account" />
                                        </svg>
                                        Sellers
                                    </a>
                                </li>
                                <li>
                                    <a href="../Accounts/Account-Users.php"
                                        class="nav-link <?php echo $Title == 'Users' ? 'side-active' : 'link-body-emphasis'; ?>">
                                        <svg class="bi pe-none me-2" width="16" height="16">
                                            <use xlink:href="#Account" />
                                        </svg>
                                        Users
                                    </a>
                                </li>
                                <li class="border-top"></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#"
                            class="nav-link <?php echo $Title == 'Reports' ? 'side-active' : 'link-body-emphasis'; ?>">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#Reports" />
                            </svg>
                            Reports
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <hr>
            <div class="dropdown dropup">
                <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle 
                        " data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong><?php echo $Username; ?></strong>
                </a>
                <ul class="dropdown-menu text-small shadow">
                    <h3 class="dropdown-header">
                        <div class="d-flex justify-content-center">
                            <img src="https://github.com/mdo.png" alt="mdo" width="48" height="48"
                                class="rounded-circle">
                        </div>
                        <div class="d-flex justify-content-center" style="max-width: 200px;">
                            <p class="dropdown-item-text px-2 text-truncate fw-bold fs-6" data-bs-toggle="tooltip"
                                data-bs-placement="bottom" data-bs-trigger="hover" data-bs-title="Username">
                                <?php echo $Username; ?></p>
                        </div>
                        <?php if ($UserRole == 'admin') { ?>
                            <div class="text-center" style="margin-top: -15px;">
                                <small class="text-muted">Administrator</small>
                            </div>
                        <?php } else { ?>
                            <div class="text-center" style="margin-top: -15px;">
                                <small class="text-muted">Seller</small>
                            </div>
                        <?php } ?>
                    </h3>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../../Profile/General_Setting.php">Profile</a></li>
                    <li><a class="dropdown-item" href="<?php echo $Home; ?>">Homepage</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item dropdown-item-text text-center" href="../../Signout/Logout.php">
                            <svg class="my-1" width="16" height="16" role="img" aria-label="Logout">
                                <use xlink:href="#Logout" />
                            </svg> Sign out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</main>