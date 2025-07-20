<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        <a href="index-2.html" class="logo-dark">
            <img src="{{ asset('admin/assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
            <img src="{{ asset('admin/assets/images/logo-dark.png') }}" class="logo-lg" alt="logo dark">
        </a>

        <a href="index-2.html" class="logo-light mt-3">
            <img src="{{ asset('admin/assets/images/logo-sm.png') }}" class="logo-sm" alt="logo sm">
            <img src="{{ asset('admin/assets/images/logo-light.png') }}" class="logo-lg" alt="logo light">
        </a>
    </div>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content"
                        style="height: auto; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <ul class="navbar-nav" id="navbar-nav">

                                <li class="menu-title">General</li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin') }}">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Dashboard </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarProducts" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarProducts">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Products </span>
                                    </a>
                                    <div class="collapse" id="sidebarProducts">
                                        <ul class="nav sub-navbar-nav">
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="{{ route('products.index') }}">List</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="{{ route('products.create') }}">Create</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link"
                                                    href="{{ route('products.images.list') }}">Product Images</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarSellers" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarSellers">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:shop-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Brands </span>
                                    </a>
                                    <div class="collapse" id="sidebarSellers">
                                        <ul class="nav sub-navbar-nav">
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="{{ route('brands.index') }}">List</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="{{ route('brands.create') }}">Create</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarCategory" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarCategory">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:clipboard-list-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Category </span>
                                    </a>
                                    <div class="collapse" id="sidebarCategory">
                                        <ul class="nav sub-navbar-nav">
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link"
                                                    href="{{ route('categories.index') }}">List</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link"
                                                    href="{{ route('categories.create') }}">Create</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarOrders" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarOrders">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Orders </span>
                                    </a>
                                    <div class="collapse" id="sidebarOrders">
                                        <ul class="nav sub-navbar-nav">

                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="orders-list.html">List</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="order-detail.html">Details</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="order-cart.html">Cart</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="order-checkout.html">Check Out</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarPurchases" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarPurchases">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:card-send-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Purchases </span>
                                    </a>
                                    <div class="collapse" id="sidebarPurchases">
                                        <ul class="nav sub-navbar-nav">
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="purchase-list.html">List</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="purchase-order.html">Order</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="purchase-returns.html">Return</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarAttributes"
                                        data-bs-toggle="collapse" role="button" aria-expanded="false"
                                        aria-controls="sidebarAttributes">
                                        <span class="nav-icon">
                                            <iconify-icon
                                                icon="solar:confetti-minimalistic-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Attributes </span>
                                    </a>
                                    <div class="collapse" id="sidebarAttributes">
                                        <ul class="nav sub-navbar-nav">
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link"
                                                    href="{{ route('attributes.index') }}">List</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link"
                                                    href="{{ route('attributes.create') }}">Create</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link"
                                                    href="{{ route('attributeValues.list') }}">Attribute Value</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarVariants" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarVariants">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:ufo-2-bold-duotone"></iconify-icon>
                                       </span>
                                        <span class="nav-text"> Variants </span>
                                    </a>
                                    <div class="collapse" id="sidebarVariants">
                                        <ul class="nav sub-navbar-nav">
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="{{ route('variants.index') }}">List</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="{{ route('variants.create') }}">Create</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="{{ route('variants.trash') }}">Trash</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarCustomers" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarCustomers">
                                        <span class="nav-icon">
                                            <iconify-icon
                                                icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Customers </span>
                                    </a>
                                    <div class="collapse" id="sidebarCustomers">
                                        <ul class="nav sub-navbar-nav">

                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link"
                                                    href="{{ route('customers.index') }}">List</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarRoles" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarRoles">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:shield-user-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Admins </span>
                                    </a>
                                    <div class="collapse" id="sidebarRoles">
                                        <ul class="nav sub-navbar-nav">

                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="{{ route('admin.list') }}">List</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="menu-title mt-2">Other</li>

                                <li class="nav-item">
                                    <a class="nav-link menu-arrow" href="#sidebarCoupons" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarCoupons">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:leaf-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Coupons </span>
                                    </a>
                                    <div class="collapse" id="sidebarCoupons">
                                        <ul class="nav sub-navbar-nav">
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="coupons-list.html">List</a>
                                            </li>
                                            <li class="sub-nav-item">
                                                <a class="sub-nav-link" href="coupons-add.html">Add</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="pages-review.html">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:chat-square-like-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Reviews </span>
                                    </a>
                                </li>

                                <li class="menu-title mt-2">Support</li>

                                <li class="nav-item">
                                    <a class="nav-link" href="help-center.html">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:help-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Help Center </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="pages-faqs.html">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:question-circle-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> FAQs </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="privacy-policy.html">
                                        <span class="nav-icon">
                                            <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                                        </span>
                                        <span class="nav-text"> Privacy Policy </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 1661px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar"
                style="height: 25px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </div>
</div>
