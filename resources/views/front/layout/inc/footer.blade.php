    <!-- Footer -->
    <footer class="text-center text-lg-start text-white" style="background-color: #929fba">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Links -->
            <section>
                <!-- Grid row -->
                <div class="row mx-1">
                    <!-- Company Info -->
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">
                            {{ get_settings()->site_name }}
                        </h6>
                        <p class="text-justify">
                            {{ get_settings()->site_meta_description }}
                        </p>
                    </div>
                    <!-- Products -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Quick Links</h6>
                        <p><a href="/" class="text-white">Home</a></p>
                        <p><a href="/shop" class="text-white">Shop</a></p>
                        <p><a href="/cart" class="text-white">Cart</a></p>
                        <p><a href="/contact" class="text-white">Contact Us</a></p>
                    </div>
                    <!-- Contact Info -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
                        <p><i class="fas fa-home mr-3"></i> {{ get_settings()->site_address }}</p>
                        <p><i class="fas fa-envelope mr-3"></i> {{ get_settings()->site_email }}</p>
                        <p><i class="fas fa-phone mr-3"></i> {{ get_settings()->site_phone }}</p>
                    </div>
                    <!-- Follow Us -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Follow Us</h6>
                        <a href="{{ get_social_network()->facebook_url }}" target="_blank"
                            class="btn btn-primary btn-floating m-1" style="background-color: #3b5998"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="{{ get_social_network()->twitter_url }}" target="_blank"
                            class="btn btn-primary btn-floating m-1" style="background-color: #55acee"><i
                                class="fab fa-twitter"></i></a>
                        <a href="{{ get_social_network()->instagram_url }}" target="_blank"
                            class="btn btn-primary btn-floating m-1" style="background-color: #ac2bac"><i
                                class="fab fa-instagram"></i></a>
                        <a href="{{ get_social_network()->youtube_url }}" target="_blank"
                            class="btn btn-primary btn-floating m-1" style="background-color: #dd4b39"><i
                                class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <!-- Grid row -->
            </section>
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            ©
            <script>
                document.write(new Date().getFullYear());
            </script> {{ get_settings()->site_name }}. All rights reserved.
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
