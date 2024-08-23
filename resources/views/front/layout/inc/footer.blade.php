<div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="" class="text-decoration-none">
                <img src="/images/site/{{ get_settings()->site_logo }}" class="lazyload" alt style="width: 150px; height: auto;">
            </a>
            <p>{{ get_settings()->site_meta_description }}</p>
            <ul class="address">
                <li>
                    <i data-feather="home"></i>
                    <a href="http://maps.google.com/maps?q=<?= urlencode(get_settings()->site_address) ?>" target="_blank">{{ get_settings()->site_address }}</a>
                </li>
                <li>
                    <i data-feather="mail"></i>
                    <a href="mailto:{{ get_settings()->site_email }}">{{ get_settings()->site_email }}</a>
                </li>
            </ul>

        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="index.html"><i class="fa-solid fa-house"></i>Home</a>
                        <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                        <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                        <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                        <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                        <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                        <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="footer-title">
                        <h4>Contact Us</h4>
                    </div>

                    <div class="footer-contact">
                        <p>Do you have any questions or suggestions?</p>
                        <ul>
                            <li>
                                <div class="footer-number">
                                    <i data-feather="phone"></i>
                                    <div class="contact-number">
                                        <h6 class="text-content">Hotline
                                            24/7 :</h6>
                                        <h5>{{ get_settings()->site_phone }}</h5>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="footer-number">
                                    <i data-feather="mail"></i>
                                    <div class="contact-number">
                                        <h6 class="text-content">Email
                                            Address :</h6>
                                        <h5>{{ get_settings()->site_email }}</h5>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="sub-footer section-small-space d-flex justify-content-between align-items-center">
            <div class="reserve">
                <h6 class="text-content">&copy; Copyright
                    <script>document.write(new Date().getFullYear());</script>
                    IjaboShop. All rights reserved
                </h6>
            </div>

            <div class="payment">
                <img src="/front/images/payments.png" class="" alt>
            </div>

            <div class="social-link text-right">
                <h6 class="text-content">Stay connected :</h6>
                <ul class="d-flex list-unstyled mb-0">
                    <li class="mr-3">
                        <a href="{{ get_social_network()->facebook_url }}" target="_blank">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </li>
                    <li class="mr-3">
                        <a href="{{ get_social_network()->twitter_url }}" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </li>
                    <li class="mr-3">
                        <a href="{{ get_social_network()->instagram_url }}" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ get_social_network()->youtube_url }}" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </div>

</div>
