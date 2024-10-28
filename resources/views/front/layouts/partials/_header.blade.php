<!-- Header start  -->
<header class="ms-header">
    <!-- Header Top Start -->
    <div class="header-top bg-white">
        <div class="container">
            <div class="row align-items-center">
            
                <!-- Header Top responsive Action -->
                <div class="col header-top-res d-lg-none">
                    <div class="ms-header-bottons">
                        <!-- Category Toggle -->
                        <div class="col ms-category-icon-block "> 
                            <div class="ms-category-menu desktop-13">
                                <div class="ms-category-toggle2 " style="display: flex;">
                                    <a href="javascript:void(0)" class="ms-header-btn ms-site-menu-icon d-lg-none">
                                        <img src="{{asset('assets/img/icons/menu.svg')}}" class="svg_img" alt="menu">
                                    </a>
                                    <img src="{{asset('assets/images/logo.png')}}" class="svg_img header_svg svg_cat"
                                        alt="icon" style="width: 130px;
                                        height: auto;">
                                        
                                </div>
                            </div>
                        </div>
                        <div class="right-icons">
                            <!-- Header User Start -->
                            <a href="{{ route('login') }}" class="ms-header-btn ms-header-user">
                                <div class="header-icon"><img src="{{asset('assets/img/icons/user.svg')}}"
                                        class="svg_img header_svg" alt=""></div>
                            </a>
                            <!-- Header User End -->
                            <!-- Header Wishlist Start -->
                            <a href="javascript:void(0)" class="ms-header-btn ms-wish-toggle">
                                <div class="header-icon"><img src="{{asset('assets/img/icons/wishlist.svg')}}"
                                        class="svg_img header_svg" alt=""></div>
                                <span class="ms-header-count ms-wishlist-count">3</span>
                            </a>
                            <!-- Header Wishlist End -->
                            <!-- Header Cart Start -->
                            <a href="javascript:void(0)" class="ms-header-btn ms-cart-toggle">
                                <div class="header-icon"><img src="{{asset('assets/img/icons/pro_cart.svg')}}"
                                        class="svg_img header_svg" alt="">
                                    <span class="main-label-note-new"></span>
                                </div>
                                <span class="ms-header-count ms-cart-count">3</span>
                            </a>
                            <!-- Header Cart End -->
                        </div>
                    </div>
                </div>
                <!-- Header Top responsive Action -->
            </div>
        </div>
    </div>
    <!-- Header Top  End -->

    <!-- Header Bottom  Start -->
    <div class="ms-header-bottom d-none d-lg-block pt-0">
        <div class="container position-relative">
            <div class="row">
                <div class="ms-flex">
                    <!-- Header Logo Start -->
                    <div class="align-self-center ms-header-logo">
                        <div class="header-logo">
                            <a href="index.html"><img src="{{asset('assets/img/logo.png')}}" alt="Site Logo"></a>
                        </div>
                    </div>
                    <!-- Header Logo End -->

                    <!-- Header Search Start -->
                    <div class="align-self-center ms-header-search">
                        <div class="header-search">
                            <form class="ms-search-group-form" action="#">
                                <div class="ms-search-select-inner">
                                    <select class="ms-search-cat selectpicker" m>
                                        <option>Category</option>
                                        <option>Category</option>
                                        <option>Category</option>
                                        <option>Category</option>
                                        <option>Category</option>
                                    </select>
                                </div>
                                <input class="form-control ms-search-bar" placeholder="Search Products..."
                                    type="text">
                                <button class="search_submit btn btn-light" type="submit"><img src="{{asset('assets/img/icons/search.svg')}}"
                                        class="svg_img search_svg" alt=""></button>
                            </form>
                        </div>
                    </div>
                    <!-- Header Search End -->

                    <!-- Header Button Start -->
                    <div class="align-self-center">
                        <div class="ms-header-bottons">
                            <!-- Header User Start -->
                            <div class="ms-acc-drop">
                                <a href="javascript:void(0)"
                                    class="ms-header-btn ms-header-user dropdown-toggle ms-user-toggle"
                                    title="Account">
                                    <div class="header-icon">
                                        <img src="{{asset('assets/img/icons/user.svg')}}" class="svg_img header_svg" alt="">
                                    </div>
                                    <div class="ms-btn-desc">
                                        <span class="ms-btn-title">Account</span>
                                        <span class="ms-btn-stitle">Login</span>
                                    </div>
                                </a>
                                <ul class="ms-dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Register As User</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Register As Merchant</a></li>
                                   
                                </ul>
                            </div>
                            <!-- Header User End -->
                            <!-- Header wishlist Start -->
                            <a href="javascript:void(0)" class="ms-header-btn ms-wish-toggle" title="Wishlist">
                                <div class="header-icon">
                                    <img src="{{asset('assets/img/icons/wishlist.svg')}}" class="svg_img header_svg" alt="">
                                </div>
                                <div class="ms-btn-desc">
                                    <span class="ms-btn-title">Wishlist</span>
                                    <span class="ms-btn-stitle"><b class="ms-wishlist-count">3</b>-items</span>
                                </div>
                            </a>
                            <!-- Header wishlist End -->
                            <!-- Header Cart Start -->
                            <a href="javascript:void(0)" class="ms-header-btn ms-cart-toggle" title="Cart">
                                <div class="header-icon">
                                    <img src="{{asset('assets/img/icons/cart_5.svg')}}" class="svg_img header_svg" alt="">
                                    <span class="main-label-note-new"></span>
                                </div>
                                <div class="ms-btn-desc">
                                    <span class="ms-btn-title">Cart</span>
                                    <span class="ms-btn-stitle"><b class="ms-cart-count">3</b>-items</span>
                                </div>
                            </a>
                            <!-- Header Cart End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Button End -->

    <!-- Header menu -->
    <div class="ms-header-cat d-none d-lg-block">
        <div class="container position-relative">
            <div class="row justify-content-between">

                <!-- Category Toggle -->
                <div class="col ms-category-icon-block">
                    <div class="ms-category-menu">
                        <div class="ms-category-toggle">
                            <img src="{{asset('assets/img/list.png')}}" class="svg_img header_svg svg_cat"
                                alt="icon">
                        </div>
                    </div>
                </div>

                <!-- Main Menu Start -->
                <div id="ms-main-menu-desk" class="d-none d-lg-block sticky-nav">
                    <div class="position-relative nav-desk">
                        <div class="row">
                            <div class="col-md-12 align-self-center">
                                <div class="ms-main-menu">
                                    <ul>
                                        <li class="non-drop"><a href="{{ route('home') }}">Home</a></li>
                                        <li class="non-drop"><a href="{{ route('ebooks') }}">E-books</a></li>
                                        <li class="non-drop"><a href="{{ route('cheat-sheet') }}">Cheat sheets</a></li>
                                        <li class="non-drop"><a href="{{ route('it-certification') }}">IT Certification</a></li>
                                        <li class="non-drop"><a href="{{ route('exam-questions') }}">Exam Questions</a></li>
                                        <li class="non-drop"><a href="{{ route('faq') }}">FAQs</a></li>
                                        <li class="non-drop"><a href="{{ route('about-us')}}">About US</a></li>
                                        <li class="non-drop"><a href="{{ route('blog')}}">Blog</a></li>
                                        <li class="non-drop"><a href="{{ route('contact-us')}}">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main Menu End -->

             

            </div>
        </div>
    </div>
    <!-- Header menu End -->

    <!-- Mobile Menu sidebar Start -->
<div class="ms-mobile-menu-overlay"></div>
<div id="ms-mobile-menu" class="ms-mobile-menu">
    <div class="ms-menu-title">
        <span class="menu_title">My Menu</span>
        <button class="ms-close-menu">×</button>
    </div>
    <div class="ms-menu-inner">
        <div class="ms-menu-content">
            <div class="ms-mobile-search">
                <form>
                    <input type="text" name="search" placeholder="Search..">
                    <button class="search_submit btn btn-light" type="submit"><img src="{{asset('assets/img/icons/search.svg')}}"
                            class="svg_img search_svg" alt=""></button>
                </form>
            </div>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="">E-books</a></li>
                <li><a href="">Cheat sheets</a></li>
                <li><a href="">IT Certification</a></li>
                <li><a href="">Exam Questions</a></li>
                <li><a href="">FAQs</a></li>
                <li><a href="">About US</a></li>
                <li><a href="">Blog</a></li>
                <li><a href="">Contact Us</a></li>
            </ul>
        </div>
        <div class="header-res-lan-curr">
            <!-- Social Start -->
            <div class="header-res-social">
                <div class="header-top-social">
                    <ul class="mb-0">
                        <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- Social End -->
        </div>
    </div>
</div>
<!-- Mobile Menu sidebar End -->


</header>