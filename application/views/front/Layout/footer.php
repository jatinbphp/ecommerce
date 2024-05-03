<footer class="light-footer">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <img src="<?php echo base_url('images/logo.png')?>" class="img-footer small mb-2" alt="" />
                        <div class="address mt-3">
                        <a href="javaScript:;"><?php echo isset($footer_data['settingsData']['address']) ? $footer_data['settingsData']['address'] : ''; ?></a>
                        </div>
                        <div class="address mt-3">
                            <a href="tel:<?php echo isset($footer_data['settingsData']['phone_number']) ? $footer_data['settingsData']['phone_number'] : ''; ?>"><?php echo isset($footer_data['settingsData']['phone_number']) ? $footer_data['settingsData']['phone_number'] : ''; ?></a>
                            <br>
                            <a href="mailto:<?php echo isset($footer_data['settingsData']['email_address']) ? $footer_data['settingsData']['email_address'] : ''; ?>"><?php echo isset($footer_data['settingsData']['email_address']) ? $footer_data['settingsData']['email_address'] : ''; ?></a>
                        </div>
                        <div class="address mt-3">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['facebook_url']) ? $footer_data['settingsData']['facebook_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-facebook-filled"></i></a></li>
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['twitter_url']) ? $footer_data['settingsData']['twitter_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-twitter-filled"></i></a></li>
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['youtube_url']) ? $footer_data['settingsData']['youtube_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-youtube"></i></a></li>
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['instagram_url']) ? $footer_data['settingsData']['instagram_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-instagram-filled"></i></a></li>
                                <li class="list-inline-item"><a href="<?php echo isset($footer_data['settingsData']['linkedin_url']) ? $footer_data['settingsData']['linkedin_url'] : 'javascript:(0);'; ?>" target="_blank"><i class="lni lni-linkedin-original"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Supports</h4>
                        <ul class="footer-menu">
                            <li><a href="javaScript:;">Size Guide</a></li>
                            <li><a href="javaScript:;">Shipping & Returns</a></li>
                            <!-- <li><a href="javaScript:;">FAQ's Page</a></li>
                            <li><a href="javaScript:;">Privacy</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Shop</h4>
                        <ul class="footer-menu">
                            <?php if (isset($footer_data['footerMenuCategoriesNames']) && is_array($footer_data['footerMenuCategoriesNames'])): ?>
                                <?php foreach ($footer_data['footerMenuCategoriesNames'] as $key => $categoryName): ?>
                                    <li><a href="<?php echo base_url("shop/categories/$key") ?>" data-categoryId="<?php echo $key ?>"><?php echo $categoryName; ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Company</h4>
                        <ul class="footer-menu">
                            <li><a href="<?php echo base_url() ?>">Home</a></li>
                            <li><a href="about-us">About Us</a></li>
                            <li><a href="contact">Contact Us</a></li>
                            <li><a href="javaScript:;">FAQ's Page</a></li>
                            <li><a href="privecy-policy">Privacy Policy</a></li>
                            <li><a href="terms-conditions">Terms & Conditions</a></li>
                            <li><a href="signIn">Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                    <div class="footer_widget">
                        <h4 class="widget_title">Subscribe</h4>
                        <p>Receive updates, hot deals, discounts sent straignt in your inbox daily</p>
                        <div class="foot-news-last">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Email Address">
                                <div class="input-group-append">
                                    <button type="button" class="input-group-text bg-dark b-0 text-light"><i class="lni lni-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="address mt-3">
                            <h5 class="fs-sm">Secure Payments</h5>
                            <div class="scr_payment">
                                <img src="<?php echo base_url('images/card.png') ?>" class="img-fluid" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12 col-md-12 text-center">
                <p class="mb-0">© 2024 Ecommerce. Designd By <a href="javaScript:void(0)" target="_blank">Nxsol</a>.</p>
            </div>
        </div>
    </div>
   
</div>
</footer>

    <script>
      function AjaxUploadImage(obj,id){
        var file = obj.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg", 'image/webp'];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3])))
        {
            $('#previewing'+URL).attr('src', 'noimage.png');
            alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        } else{
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(obj.files[0]);
        }

        function imageIsLoaded(e){
            $('#DisplayImage').css("display", "block");
            $('#DisplayImage').css("margin-top", "1.5%");
            $('#DisplayImage').attr('src', e.target.result);
            $('#DisplayImage').attr('width', '150');
        }
    }
    $('.quick_view_slide').slick({
        slidesToShow: 1,
        arrows: true,
        dots: true,
        infinite: true,
        autoplaySpeed: 2000,
        autoplay: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    arrows: true,
                    dots: true,
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    arrows: true,
                    dots: true,
                    slidesToShow: 1
                }
            }
        ]
    });
</script>
