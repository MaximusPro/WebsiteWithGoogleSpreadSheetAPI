<?php
require("config.php");
$pageTitle = "Contact Us";
include(ROOT. "templates/head.tpl");
include(ROOT. "templates/preloader.tpl");
include(ROOT. "templates/header-menu.tpl");
//include(ROOT. "templates/banner.tpl");

?>

        <!-- HERO BANNER START -->
        <section class="title-banner">
            <div class="container">
                <div class="banner-wrapper">
                    <h2 class="h1 title-content">Contact Us</h2>
                </div>
            </div>
        </section>
        <!-- HERO BANNER END -->

        <!-- Case Study START -->
        <section class="contact-us">
            <div class="container">
                <div class="row py-80">
                    <div class="col-lg-4 col-md-5">
                        <div class="contact-wrapper">
                            <img class="mb-64" src="static/picture/prism-logo.png" alt="">
                            <h6 class="fw-700 black mb-12">We'll get your business set <br>up in less than 24 hours.
                            </h6>
                            <p class="subtitle light-black mb-36">Sounds impossible, right? Wait until you see how
                                easy it is to run your business on Prism.</p>
                            <form id="leadForm" method="POST" class="contact-form" action="submit.php">
                                <input type="text" name="name" id="text" class="form-control required mb-24" required placeholder="Name">
                                <input type="email" name="email" id="e-mail" class="form-control required mb-24" required placeholder="Email">
                                <div class="intl-tel-input allow-dropdown separate-dial-code iti-sdc-2 mb-24 required">
                                    <div class="flag-container">
                                        <div class="selected-flag" tabindex="0" title="United States: +1">
                                            <div class="iti-flag us"></div>
                                            <div class="selected-dial-code"></div>
                                            <div class="iti-arrow"></div>
                                        </div>
                                    </div><input type="tel" name="phone" id="mobile" class="form-control w-100" placeholder="+01 123 456 789" autocomplete="off">
                                </div>
                                <div class="input-block mb-64">
                                    <textarea name="message" id="comments" class="form-control" placeholder="How can we help?"></textarea>
                                    <input type="hidden" name="g-recaptcha-response" id="recaptchaToken">
                                </div>
                                <button type="submit" class="w-100 mb-24 cus-btn">
                                    <span class="text">Send Request</span>
                                    
                                </button>
                                <p class="subtitle light-black text-center">Prefer email? <a href="mailto:hello@mail.com" class="text-decoration-underline">
                                        office@prizm.com</a></p>

                                <div id="message" class="alert-msg"></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <img class="br-24" src="static/picture/contact-us.jpg" alt="">
                    </div>
                </div>
                <div class="row py-80">
                    <div class="col-12">
                        <h4 class="mb-48 black">Our Location</h4>
                        <!-- Location Map -->
                        <div class="map">
                            <div class="map-wrapper">
                                <iframe class="br-16" src="embed.html" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                        <!-- Location Map -->
                    </div>
                </div>
            </div>
        </section>
        <!-- Case Study END -->

        <?php include(ROOT. "templates/footer.tpl"); ?>

        <!-- Main Wrapper End -->
    </div>
    <!-- Back To Top Start -->
  <button class="scrollToTopBtn"><i class="fa fa-arrow-up"></i></button>

   
<?php include(ROOT. "templates/mobile-menu.tpl"); ?>

    <?php include(ROOT. "templates/jquery.tpl");?>

</body>

</html>