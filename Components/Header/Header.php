<nav class="navbar navbar-expand-lg bg-body-tertiary bg-opacity-50 bg-blur-3 border-bottom shadow-sm fixed-top">
    <div class="container-fluid">
        <div class="col-md-3 mb-2 mb-md-0">
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-inline-flex link-body-emphasis text-decoration-none">
                <img class="mx-3" src="../../Assets/Images/Logo_1.png" height="40">
            </a>
        </div>
        <button class="navbar-toggler nb-t" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="nav me-auto mb-2 mb-lg-0">
                <li><a href="#" class="nav-link px-2 link-hover active-tab"><svg class="mb-1" width="16" height="16" role="img" aria-label="Home">
                            <use xlink:href="#home" />
                        </svg> Home</a></li>
                <li><a href="#" class="nav-link px-2 link-hover"><svg class="mb-1" width="16" height="16" role="img" aria-label="Shop">
                            <use xlink:href="#Shop" />
                        </svg> Shop All</a></li>
                <li><a href="#" class="nav-link px-2 link-hover"><svg class="mb-1" width="16" height="16" role="img" aria-label="Size">
                            <use xlink:href="#Cloth" />
                        </svg> Playaz Tees</a></li>
                <li><a href="#" data-bs-target="#Sizechart" data-bs-toggle="modal" class="nav-link px-2 link-hover"><svg class="mb-1" width="16" height="16" role="img" aria-label="Size">
                            <use xlink:href="#Size" />
                        </svg> Size Guide</a></li>
                <li><a id="Hsearch" href="#" data-bs-target="#searchModal" data-bs-toggle="modal" class="nav-link px-2 link-hover"><svg class="mb-1" width="18" height="18" role="img" aria-label="Search">
                            <use xlink:href="#Search" />
                        </svg> Search</a></li>
            </ul>

            <!-- For Testing Only -->
            <div class="d-flex justify-content-end">
                <a href=" #" data-bs-target="#SignIN" data-bs-toggle="modal" class="d-block link-body-emphasis text-decoration-none" id="Log-In">
                    <svg class="bi mx-1" width="16" height="16" role="img" aria-label="Register">
                        <use xlink:href="#Login" />
                    </svg> Sign In / Register
                </a>
                <div class="hstack gap-3 visually-hidden" id="Log-Out">
                    <div class="me-3" id="Cart-Empty" title="Cart is empty">
                        <a class="d-block link-body-emphasis text-decoration-none mt-1">
                            <svg class="mb-1" width="24" height="24" role="img" aria-label="Cart is empty">
                                <use xlink:href="#NoCart" />
                            </svg>
                        </a>
                    </div>
                    <div class="me-3 position-relative visually-hidden" id="Cart-Not-Empty">
                        <a class="d-block link-body-emphasis text-decoration-none mt-1" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-2 text-bg-primary bg-opacity-75">
                                99+
                                <span class="visually-hidden">Items in cart</span>
                            </span>
                            <svg class="mb-1" width="24" height="24" role="img" aria-label="Cart">
                                <use xlink:href="#Cart" />
                            </svg>
                        </a>
                    </div>
                    <div>
                        <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small shadow dropdown-menu-end">
                            <li>
                                <p class="dropdown-header">Welcome,</p>
                                <p class="dropdown-item-text px-2">Lorem Ipsum Dolor</p>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">About Us</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end visually-hidden">
                <?php
                $isLogin = true; // true - if user is logged in
                $haveCart = true; // true - if user have items in cart
                $CartItem = 5; // Number of items in cart

                if (!$isLogin) { ?>
                    <a href=" #" data-bs-target="#SignIN" data-bs-toggle="modal" class="d-block link-body-emphasis text-decoration-none">
                        <svg class="" width="16" height="16" role="img" aria-label="Register">
                            <use xlink:href="#Login" />
                        </svg> Sign In / Register
                    </a>
                <?php } else { ?>
                    <!-- If Login-->
                    <div class="hstack gap-3">
                        <?php if ($haveCart) { ?>
                            <div class="me-3 position-relative">
                                <a class="d-block link-body-emphasis text-decoration-none mt-1" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-2 text-bg-primary bg-opacity-75">
                                        99+
                                        <span class="visually-hidden">Items in cart</span>
                                    </span>
                                    <svg class="mb-1" width="24" height="24" role="img" aria-label="Cart">
                                        <use xlink:href="#Cart" />
                                    </svg>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="me-3" title="Cart is empty">
                                <a href="#" class="d-block link-body-emphasis text-decoration-none mt-1">
                                    <svg class="mb-1" width="24" height="24" role="img" aria-label="Cart is empty">
                                        <use xlink:href="#Cart" />
                                    </svg>
                                </a>
                            </div>
                        <?php } ?>
                        <div>
                            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                            </a>
                            <ul class="dropdown-menu text-small shadow dropdown-menu-end">
                                <li>
                                    <p class="dropdown-header">Welcome,</p>
                                    <p class="dropdown-item-text px-2">Lorem Ipsum Dolor</p>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">About Us</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>
<div class="offcanvas-size offcanvas offcanvas-end bg-blur-10 bg-opacity-50 bg-body-tertiary" data-bs-backdrop="static" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Items in Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <small class="text-muted text-center">*Note: initial design only</small>
    <div class="offcanvas-body">
        <div class="vstack gap-5">
            <?php
            if ($CartItem != 0) { ?>
                <ol class="list-group list-group-numbered list-group-flush rounded-2">
                    <?php for ($i = 0; $i < $CartItem; $i++) { ?>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <input class="form-check-input mx-2" type="checkbox" value="" id="firstCheckbox">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Product Name</div>
                                <div class="hstack gap-2">
                                    <small class="text-muted">
                                        <select class="form-select form-select-sm" aria-label="Select Size">
                                            <option selected disabled hidden>Select Size</option>
                                            <option value="1">Small</option>
                                            <option value="2">Medium</option>
                                            <option value="3">Large</option>
                                        </select>
                                    </small>
                                    <small class="text-muted">
                                        <input type="number" class="form-control form-control-sm" value="1" min="1" max="99" placeholder="Quantity">
                                    </small>
                                </div>
                            </div>
                            <span class="badge bg-primary rounded-2">₱ 199.98</span>
                        </li>
                    <?php }
                } else { ?>
                </ol>
                <div class="text-center">
                    <svg class="mb-1" width="64" height="64" role="img" aria-label="Cart">
                        <use xlink:href="#Cart" />
                    </svg>
                    <h3 class="text-muted">Cart is Empty</h3>
                </div>
            <?php } ?>
            <!-- Cart Total -->
            <div class="hstack gap-3">
                <div class="hstack gap-2">
                    <h3 class="text-muted">Total:</h3>
                    <h2>₱ 999.99</h2>
                </div>
            </div>
            <div class="hstack gap-3">
                <button class="btn btn-sm btn-primary w-50 me-3" type="button">Checkout</button>
                <div class="vr"></div>
                <button class="btn btn-danger" type="button">Clear Selected Items</button>
            </div>
        </div>
    </div>
</div>
<hr style="height: 64px; margin: 0;">