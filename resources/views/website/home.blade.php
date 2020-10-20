<!DOCTYPE html>
<html>
<head>
    <title>CropQR: QRCodes as per MOA Guidelines</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style type="text/css">.img-100{max-width:100%;height: 250px;}</style>
</head>
<body>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-180289566-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-180289566-1');
</script>
<div class="fix_container">
    <div class="row_margin ">
        <div class="top_headr">
            <div class="full_width w_f_color f_box f_btwn top_head">
                <div class="offic_timing_info f_box f_btwn">
                    <div class="office_sddress">
<span> <i class="fa fa-map-marker" aria-hidden="true"></i>
</span>
                        <label for="" class="f_13">C-125, Sector Swarn Nagri, Gr. Noida</label>
                    </div>
{{--                    <div class="off_timing row_padding">--}}
{{--                        <span> <i class="fa fa-clock-o" aria-hidden="true"></i></span>--}}
{{--                        <label for="" class="f_13">Anmoore Road Brooklyn, NY 11230</label>--}}
{{--                    </div>--}}
                </div>
                <div class="social_medi_con row_padding f_box f_btwn">
                    <div class="social_icon_cont">
                        <ul class="f_box">
                            <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-linkedin" aria-hidden="true"></i>

                                </a></li>
                        </ul>
                    </div>
                    <div class="get_qoute_btn">
{{--                        <a href="" class="get_started">GET A QUOTE</a>--}}
                        @if(auth()->user())
                            <a href="{{route('home')}}" class="get_started">My Account</a>
                        @else
                            <a href="{{route('login')}}" class="get_started">Login</a>
                        @endif
                    </div>
                    <div class="my_muneu_con">
                        <span class="my_men"><i class="fa fa-bars" aria-hidden="true"></i></span>
                        <div class="mobile_menu">
                        <div class="in_menu row_padding">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Service</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact Us</a></li>

                </ul>
            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="logo_header full_width row_padding box_sizzing">
            <div class="second_heade full_width f_box f_btwn">
                <div class="logo_container">
                    <a href="">
                        <img src="/images/new-logo.jpeg" alt="">
                    </a>
                </div>
                <div class="contact_info">
                    <div class="contat_in_info">
                        <ul>
                            <li>
                                <div class="call_ico"><i class="fa fa-phone" aria-hidden="true"></i>
                                </div>
                                <div class="call_info">
                                    <label for="">Call Us Now</label>
                                    <span>0120-3514741</span>
                                </div>
                            </li>
                            <li class="p_zero_b">
                                <div class="call_ico"><i class="fa fa-envelope" aria-hidden="true"></i>

                                </div>
                                <div class="call_info">
                                    <label for="">Email Us</label>
                                    <a href="">info@cropqr.com</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="full_width menu_container">
            <div class="in_menu row_padding">
                <ul>
                <li><a href="#home">Home</a></li>
                    <li><a href="#services">Service</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact Us</a></li>

                </ul>
            </div>
        </div>
        <div class="slider_box full_width">
            <div class="in_slider full_width">
                <ul class="bxslider top_slider">
                    <li>
                        <!-- <div class="overlay_cont"></div> -->
                        <div class="slider_cotant full_width">
                            <!-- <div class="slider_info">Hello</div> -->
                            <div class="slider_images_con">
                               <img src="images/banner1.jpeg" alt="">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="slider_cotant full_width">
                            <!-- <div class="slider_info">Hello</div> -->
                            <div class="slider_images_con">
                               <img src="images/banner2.jpeg" alt="">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="slider_cotant full_width">
                            <!-- <div class="slider_info">Hello</div> -->
                            <div class="slider_images_con">
                               <img src="images/banner3.jpeg" alt="">
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="slider_cotant full_width">
                            <!-- <div class="slider_info">Hello</div> -->
                            <div class="slider_images_con">
                              <img src="images/banner4.jpeg" alt="">
                            </div>
                        </div>
                    </li>

                </ul>

            </div>
        </div>

        <div class="full_width service_continer row_padding box_sizzing service_bg" id="services">
            <div class="inner_content_con commp_padd">
                <div class="heading_con">
                    <h2 class="ht-title">Our <strong>Services</strong></h2>
                    <div class="bottom_bar"></div>

                </div>

                <div class="full_width servie_lisit f_box">
                    <div class="common_serv_box">
                        <div class="featured-icon">
                            <span class="fa fa-home"></span>
                        </div>
                        <h5 class="text">Pesticide Registration</h5>
                        <p>
                            Pesticide Registration with CIB & RC                        </p>
                    </div>
{{--                    <div class="common_serv_box">--}}
{{--                        <div class="featured-icon">--}}
{{--                            <span class="fa fa-home"></span>--}}
{{--                        </div>--}}
{{--                        <h5 class="text">Pesticide Sample Work</h5>--}}
{{--                        <p>--}}
{{--                            Pesticide Sample Work with Central Insecticides Lab                        </p>--}}
{{--                    </div>--}}
                    <div class="common_serv_box">
                        <div class="featured-icon">
                            <span class="fa fa-home"></span>
                        </div>
                        <h5 class="text">Label Printing</h5>
                        <p>
                            Label Printing with QR Codes                        </p>
                    </div>
                    <div class="common_serv_box">
                        <div class="featured-icon">
                            <span class="fa fa-home"></span>
                        </div>
                        <h5 class="text">QR Code Generate</h5>
                        <p>
                            QR Code Generate For Excel Downloads                        </p>
                    </div>
{{--                    <div class="common_serv_box">--}}
{{--                        <div class="featured-icon">--}}
{{--                            <span class="fa fa-home"></span>--}}
{{--                        </div>--}}
{{--                        <h5 class="text">Apartment Cleaning</h5>--}}
{{--                        <p>--}}
{{--                            We have many clients that use our services weekly, and some that just call on an...                            </p>--}}
{{--                    </div>--}}
{{--                    <div class="common_serv_box">--}}
{{--                        <div class="featured-icon">--}}
{{--                            <span class="fa fa-home"></span>--}}
{{--                        </div>--}}
{{--                        <h5 class="text">Apartment Cleaning</h5>--}}
{{--                        <p>--}}
{{--                            We have many clients that use our services weekly, and some that just call on an...                            </p>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>



        <div class="full_width service_continer row_padding box_sizzing feature_bg">
            <div class="inner_content_con commp_padd">
                <div class="heading_con">
                    <h2 class="ht-title">How To Print <strong>QR Codes</strong>?</h2>
                    <div class="bottom_bar"></div>

                </div>

                <div class="full_width servie_lisit f_box our_feature_box">
                    <div class="feature_bof">
                        <div class="featurednew-icon" style="text-align: center">
                            <img src="images/batch-print.jpg" class="img-responsive img-100">
                        </div>
                        <h5 class="txt_center">Print With Batch Coding Machine</h5>
                        <div class="featurednew-excerpt txt_center">
                            A good company will be able to train and build up teams of good performing staff to ensure an excellent job will be carried out according to the company’s vision and goal.													</div>
                        <div class="featurednew-readmore txt_center">
                            <a class="btn" href="#">Read More														</a>
                        </div>
                    </div>
                    <div class="feature_bof">
                        <div class="featurednew-icon" style="text-align: center">
                            <img src="images/packaging.png" class="img-responsive img-100">
                        </div>
                        <h5 class="txt_center">Pre Printed Packaging Material</h5>
                        <div class="featurednew-excerpt txt_center">
                            A good company will be able to train and build up teams of good performing staff to ensure an excellent job will be carried out according to the company’s vision and goal.													</div>
                        <div class="featurednew-readmore txt_center">
                            <a class="btn" href="#">Read More														</a>
                        </div>
                    </div>
                    <div class="feature_bof">
                        <div class="featurednew-icon" style="text-align: center">
                            <img src="images/stickers.jpg" class="img-responsive img-100">
                        </div>
                        <h5 class="txt_center">Pre Printed Stickers</h5>
                        <div class="featurednew-excerpt txt_center">
                            A good company will be able to train and build up teams of good performing staff to ensure an excellent job will be carried out according to the company’s vision and goal.													</div>
                        <div class="featurednew-readmore txt_center">
                            <a class="btn" href="#">Read More														</a>
                        </div>
                    </div>



                </div>
            </div>
        </div>



        <!-----------------------------------About Us---------------------------->
        <div class="full_width service_continer row_padding box_sizzing service_bg">
            <div class="inner_content_con commp_padd">

                <div class="about_us_con full_width f_box">
                    <div class="about_us_img_con my_abut">
                        <img src="images/1-1.jpg" class="img-responsive img-100" />
                    </div>
                    <div class="about_info">
                        <div class="heading_con abot_us">
                            <h2 class="ht-title"><strong>About Us</strong></h2>
                            <div class="bottom_bar"></div>

                        </div>

                        <div class="lz-about-subheading ppoins_fonts">Domestic Registration, Generation of Data, Maintainence Services,                            Prepration of Documents</div>
                        <div class="ht-content lz-about-text">
                            CropQR is one of the best consultants of Pesticides Regitration in Greater Noida and in India as well.
                            We are the business of registration of pesticides and other customized nutritional products for plants and animals. We started our activity by registering of formulations of pesticides & bio pesticides, technical, import, export, endorsement, shelf life, alternet packing under various categories and under section 9(3)/9(3b)/9(4) & legal, and then diversified into mineral additives for the agriculture use.&nbsp;
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <!------------------------------------About_us--------------------------->

        <!------------------------------------how-itswork------------------------>
        <div class="full_width service_continer row_padding box_sizzing feature_bg">
            <div class="inner_content_con commp_padd">
                <div class="heading_con">
                    <h2 class="ht-title">See <strong>How Works</strong></h2>
                    <div class="bottom_bar"></div>

                </div>

                <div class="full_width servie_lisit f_box our_feature_box">
                    <div class="feature_bof txt_center">
                        <div class="work-num">1</div>
                        <h5 class="txt_center ppoins_fonts step_count">Login To CropQR</h5>
                        <div class="featurednew-excerpt txt_center">with Minimum Info</div>

                    </div>
                    <div class="feature_bof txt_center">
                        <div class="work-num">2</div>
                        <h5 class="txt_center ppoins_fonts step_count">Generate QR Codes</h5>
                        <div class="featurednew-excerpt txt_center">with Minimum Clicks</div>

                    </div>
                    <div class="feature_bof txt_center">
                        <div class="work-num">3</div>
                        <h5 class="txt_center ppoins_fonts step_count">Download QR Codes</h5>
                        <div class="featurednew-excerpt txt_center">provide these codes for printing</div>

                    </div>



                </div>
            </div>
        </div>
        <!------------------------------------how-itswork------------------------>

        <!------------------------------------how-itswork------------------------>
        <div class="full_width service_continer row_padding box_sizzing how_its">
            <div class="overlay_cont"></div>
            <div class="inner_content_con commp_padd">
                <ul class="my_facility">
                    <li>
                        <div class="facility-icon">
                            <div class="sheild">
                                <i class="fa fa-shield" aria-hidden="true"></i>
                            </div>
                            <div class="bottom_bar"></div>
                        </div>
                        <div class="facility-num txt_center">100% </div>
                        <h5 class="ppoins_fonts  txt_center">Uptime </h5>

                    </li>
                    <li>
                        <div class="facility-icon">
                            <div class="sheild">
                                <i class="fa fa-shield" aria-hidden="true"></i>
                            </div>
                            <div class="bottom_bar"></div>
                        </div>
                        <div class="facility-num txt_center">24 X 7</div>
                        <h5 class="ppoins_fonts  txt_center">Support</h5>

                    </li>
                    <li>
                        <div class="facility-icon">
                            <div class="sheild">
                                <i class="fa fa-shield" aria-hidden="true"></i>
                            </div>
                            <div class="bottom_bar"></div>
                        </div>
                        <div class="facility-num txt_center">Cloud</div>
                        <h5 class="ppoins_fonts  txt_center">Technology
                        </h5>

                    </li>
                    <li>
                        <div class="facility-icon">
                            <div class="sheild">
                                <i class="fa fa-shield" aria-hidden="true"></i>
                            </div>
                            <div class="bottom_bar"></div>
                        </div>
                        <div class="facility-num txt_center">200+</div>
                        <h5 class="ppoins_fonts  txt_center">Happy Clients</h5>

                    </li>
                </ul>
            </div>
        </div>
        <!------------------------------------how-itswork------------------------>



        <!--------------------------Our Gallery---------------------->
{{--        <div class="full_width service_continer row_padding box_sizzing  our_gallery">--}}
{{--        <div class="inner_content_con commp_padd">--}}
{{--                <div class="heading_con">--}}
{{--                    <h2 class="ht-title">Our<strong>Gallery</strong></h2>--}}
{{--                    <div class="bottom_bar"></div>--}}

{{--                </div>--}}
{{--        <div class="slider_box full_width">--}}
{{--            <div class="in_slider full_width our_gallery_img">--}}
{{--                <ul class="bxslider top_slider">--}}
{{--                    <li>--}}
{{--                        <!-- <div class="overlay_cont"></div> -->--}}
{{--                        <div class="slider_cotant full_width">--}}
{{--                            <!-- <div class="slider_info">Hello</div> -->--}}
{{--                            <div class="slider_images_con">--}}
{{--                               <img src="images/banner1.jpeg" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <div class="slider_cotant full_width">--}}
{{--                            <!-- <div class="slider_info">Hello</div> -->--}}
{{--                            <div class="slider_images_con">--}}
{{--                               <img src="images/banner2.jpeg" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}
{{--                    <li>--}}
{{--                        <div class="slider_cotant full_width">--}}
{{--                            <!-- <div class="slider_info">Hello</div> -->--}}
{{--                            <div class="slider_images_con">--}}
{{--                               <img src="images/banner3.jpeg" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}

{{--                    <li>--}}
{{--                        <div class="slider_cotant full_width">--}}
{{--                            <!-- <div class="slider_info">Hello</div> -->--}}
{{--                            <div class="slider_images_con">--}}
{{--                              <img src="images/banner4.jpeg" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </li>--}}

{{--                </ul>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--</div>--}}
{{--</div>--}}
</div>
        <!--------------------------Our Gallery---------------------->

        <!------------------------------------our_plan--------------------------->

        <div class="full_width service_continer row_padding box_sizzing feature_bg" id="pricing">
            <div class="inner_content_con commp_padd">
                <div class="heading_con">
                    <h2 class="ht-title">Our <strong>Packages</strong></h2>
                    <div class="bottom_bar"></div>

                </div>

                <div class="full_width servie_lisit f_box our_feature_box">
                    <div class="our_plan_con">
                        <div class="ht-princing-title ppoins_fonts">Silver Plan </div>
                        <div class="amount-box">
                            <div class="plan-amount">
                                <span><sup>Rs.</sup> 899</span>
                                <br>
                                <span style="text-decoration:line-through;font-size: 20px;">Rs. 1000</span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="plan-starts">Per Month </div>
                        </div>

                        <div class="ht-princing-excerpt">
                            <ul>
                                <li>No product Limit</li>
                                <li>25000 QR Codes Can Be Generated Every Month</li>
                            </ul>                                 </div>
                        <div class="ht-princing-link">
                            <a class="btn" href="{{route('subscribe.now', ['id'=>2])}}">Subscribe Now                                    </a>
                        </div>
                    </div>
                    <div class=" our_plan_con">
                        <div class="ht-princing-title ppoins_fonts">Gold Plan </div>
                        <div class="amount-box">
                            <div class="plan-amount">
                                <span><sup>Rs.</sup> 2499</span>
                                <br>
                                <span style="text-decoration:line-through;font-size: 20px;">Rs. 3000</span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="plan-starts">Per Month </div>
                        </div>

                        <div class="ht-princing-excerpt">
                            <ul>
                                <li>No product Limit</li>
                                <li>100000 QR Codes Can Be Generated Every Month</li>
                            </ul>                                 </div>
                        <div class="ht-princing-link">
                            <a class="btn" href="{{route('subscribe.now', ['id'=>3])}}">Subscribe Now                                    </a>
                        </div>
                    </div>
                    <div class=" our_plan_con">
                        <div class="ht-princing-title ppoins_fonts">Platinum Plan </div>
                        <div class="amount-box">
                            <div class="plan-amount">
                                <span><sup>Rs.</sup> 4499</span>
                                <br>
                                <span style="text-decoration:line-through;font-size: 20px;">Rs. 5000</span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="plan-starts">Per Month </div>
                        </div>

                        <div class="ht-princing-excerpt">
                            <ul>
                                <li>No product Limit</li>
                                <li>200000 QR Codes Can Be Generated Every Month</li>
                            </ul>                                 </div>
                        <div class="ht-princing-link">
                            <a class="btn" href="{{route('subscribe.now', ['id'=>4])}}">Subscribe Now                                    </a>
                        </div>
                    </div>
                    <div class=" our_plan_con">
                        <div class="ht-princing-title ppoins_fonts">Diamond Plan </div>
                        <div class="amount-box">
                            <div class="plan-amount">
                                <span><sup>Rs.</sup> 8999</span>
                                <br>
                                <span style="text-decoration:line-through;font-size: 20px;">Rs. 10000</span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="plan-starts">Per Month </div>
                        </div>

                        <div class="ht-princing-excerpt">
                            <ul>
                                <li>No product Limit</li>
                                <li>500000 QR Codes Can Be Generated Every Month</li>
                            </ul>                                 </div>
                        <div class="ht-princing-link">
                            <a class="btn" href="{{route('subscribe.now', ['id'=>2])}}">Subscribe Now                                    </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!------------------------------------our_plan--------------------------->


        <!------------------------FAQ Section------------------------------------>

        <div class="full_width service_continer row_padding box_sizzing feature_bg">
            <div class="inner_content_con commp_padd">
                <div class="heading_con">
                    <h2 class="ht-title">Frequently<strong> Asked Questions</strong></h2>
                    <div class="bottom_bar"></div>

                </div>

                <div class="full_width servie_lisit f_box our_feature_box">
                    <div class="width_100 txt_center accord_con">

                <div class="width_100 f_box accord_con">
                    <!------------------left_accord------------>
                    <div class="accord_box">
                    <div class="accordion-container">
  <div class="set">
    <a href="javascript:void(0)">
      How to use codes?
      <i class="fa fa-plus"></i>
    </a>
    <div class="content_one">
      <p>Generate QRCodes in your account after providing required information. These codes can be dowloaded as excel sheet. There are 3 techniques to print QR codes which are Batch coding machines, packaging material or sticker labels</p>
    </div>
  </div>
  <div class="set">
    <a href="javascript:void(0)">
      Can I customize the information display and format?
      <i class="fa fa-plus"></i>
    </a>
    <div class="content_one">
      <p>We have followed guidelines to display the information. But you can raise a request to info@cropqr.com to discuss the required customizations</p>
    </div>
  </div>
{{--  <div class="set">--}}
{{--    <a href="javascript:void(0)">--}}
{{--      Praesent--}}
{{--      <i class="fa fa-plus"></i>--}}
{{--    </a>--}}
{{--    <div class="content_one">--}}
{{--      <p>Pellentesque aliquam ligula libero, vitae imperdiet diam porta vitae. sed do eiusmod tempor incididunt ut labore et dolore magna.</p>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--  <div class="set">--}}
{{--    <a href="javascript:void(0)">--}}
{{--      Curabitur--}}
{{--      <i class="fa fa-plus"></i>--}}
{{--    </a>--}}
{{--    <div class="content_one">--}}
{{--      <p> Donec tincidunt consectetur orci at dignissim. Proin auctor aliquam justo, vitae luctus odio pretium scelerisque. </p>--}}
{{--    </div>--}}
{{--  </div>--}}
</div>
                    </div>
                    <!----------------Left_accrod-------------->

                    <!---------------right_accord-------------->
                    <div class="accord_box">
                    <div class="accordion-container">
  <div class="set">
    <a href="javascript:void(0)">
      How long codes will be valid?
      <i class="fa fa-plus"></i>
    </a>
    <div class="content_one">
      <p>These codes will be valid till expiry date of product.</p>
    </div>
  </div>
  <div class="set">
    <a href="javascript:void(0)">
      Account Subscription Expiry
      <i class="fa fa-plus"></i>
    </a>
    <div class="content_one">
      <p>We have various subscription plans which are valid for 1 month. After that subscription renewal will be required to continue using service. If subscription is expired, new codes cannot be generated or mapped, but already generated codes can be downloaded anytime and wil remain valid.</p>
    </div>
  </div>
{{--  <div class="set">--}}
{{--    <a href="javascript:void(0)">--}}
{{--      Praesent--}}
{{--      <i class="fa fa-plus"></i>--}}
{{--    </a>--}}
{{--    <div class="content_one">--}}
{{--      <p>Pellentesque aliquam ligula libero, vitae imperdiet diam porta vitae. sed do eiusmod tempor incididunt ut labore et dolore magna.</p>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--  <div class="set">--}}
{{--    <a href="javascript:void(0)">--}}
{{--      Curabitur--}}
{{--      <i class="fa fa-plus"></i>--}}
{{--    </a>--}}
{{--    <div class="content_one">--}}
{{--      <p> Donec tincidunt consectetur orci at dignissim. Proin auctor aliquam justo, vitae luctus odio pretium scelerisque. </p>--}}
{{--    </div>--}}
{{--  </div>--}}
</div>

                    </div>

                    <!------------------Right_accord----------->
                </div>
</div>
</div>
</div>
</div>
</div>
        <!------------------------FAQ Section------------------------------------>



        <!------------------------------------client_tetimonials------------------------>
{{--        <div class="full_width service_continer row_padding box_sizzing trstimonials_bg">--}}
{{--            <div class="overlay_cont"></div>--}}

{{--            <div class="inner_content_con commp_padd">--}}
{{--                <div class="heading_con">--}}
{{--                    <h2 class="ht-title">Client <strong>Testimonials</strong></h2>--}}
{{--                    <div class="bottom_bar"></div>--}}

{{--                </div>--}}
{{--                <div class="my_tetsimonials">--}}
{{--                    <ul class="bxslider my_testimonal">--}}
{{--                        <li>--}}
{{--                            <div class="ht-test-member-image">--}}
{{--                                <div class="testefferct">--}}
{{--                                    <img src="images/t1.jpg" class="img-responsive" alt="Jerimiah D.">--}}
{{--                                </div>--}}
{{--                                <div class="test-content">--}}
{{--                                    Let me say something. You have an amazing theme and amazing/awesome support. They helped me on weekend. This is what I call an “extra mile” in customer relationship. So I gave 5 stars for the theme and if I could, I’d give 10 stars for support.                        </div>--}}
{{--                                <h6 class="member-name">Jerimiah D.</h6>--}}
{{--                                <div class="text-designation">United States                            </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <div class="ht-test-member-image">--}}
{{--                                <div class="testefferct">--}}
{{--                                    <img src="images/t1.jpg" class="img-responsive" alt="Jerimiah D.">--}}
{{--                                </div>--}}
{{--                                <div class="test-content">--}}
{{--                                    Let me say something. You have an amazing theme and amazing/awesome support. They helped me on weekend. This is what I call an “extra mile” in customer relationship. So I gave 5 stars for the theme and if I could, I’d give 10 stars for support.                        </div>--}}
{{--                                <h6 class="member-name">Jerimiah D.</h6>--}}
{{--                                <div class="text-designation">United States                            </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <div class="ht-test-member-image">--}}
{{--                                <div class="testefferct">--}}
{{--                                    <img src="images/t1.jpg" class="img-responsive" alt="Jerimiah D.">--}}
{{--                                </div>--}}
{{--                                <div class="test-content">--}}
{{--                                    Let me say something. You have an amazing theme and amazing/awesome support. They helped me on weekend. This is what I call an “extra mile” in customer relationship. So I gave 5 stars for the theme and if I could, I’d give 10 stars for support.                        </div>--}}
{{--                                <h6 class="member-name">Jerimiah D.</h6>--}}
{{--                                <div class="text-designation">United States                            </div>--}}
{{--                            </div>--}}
{{--                        </li>--}}

{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!------------------------------------client_tetimonials------------------------>

        <!------------------------------------our_plan--------------------------->

        <div class="full_width service_continer row_padding box_sizzing feature_bg get_qote" id="contact">
            <div class="inner_content_con commp_padd">


                <div class="get_aqoute_con full_width f_box">
                    <div class="get_c_con">
                        <img src="images/appointment.jpeg" alt="">
                    </div>
                    <div class="form_container">
                        <div class="heading_con">
                            <h2 class="ht-title">Get <strong>A Quote </strong></h2>
                            <div class="bottom_bar"></div>

                        </div>
                        <form>
                        <div class="form_box full_width f_box">
                            <div class="input_fld_con">
                                <input type="text" name="name" id="" placeholder="Name" class="inpt_fld">
                            </div>
                            <div class="input_fld_con">
                                <input type="text" name=email" id="" placeholder="Email" class="inpt_fld">
                            </div>
                        </div>
                        <div class="form_box full_width f_box">
                            <div class="input_fld_con">
                                <input type="text" name="phone" id="" placeholder="Phone" class="inpt_fld">
                            </div>
                        </div>
                        <div class="form_box full_width f_box">
                            <textarea name="message" id="" cols="30" rows="10" class="inpt_fld" placeholder="Message"></textarea>
                        </div>
                        <div class="request_call">
                            <input type="submit" value="Request a Call" class="solid_btn">
                        </div>
                        </form>
                        <div class="bottom_socail txt_center">
                            <ul class="f_box">
                                <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a></li>
                                <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i>
                                    </a></li>
                                <li><a href=""><i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                    </a></li>
                                <li><a href=""><i class="fa fa-linkedin" aria-hidden="true"></i>

                                    </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------our_plan--------------------------->

        <div class="full_width service_continer row_padding box_sizzing get_a_call">
            <div class="inner_content_con commp_padd">
                <div class="banner-heading txt_center ppoins_fonts">Get Free Estimate</div>
                <div class="banner-subheading txt_center">
                    CALL NOW<span class="blink">0120-3514741</span>
                </div>
            </div>
        </div>

        <!------------------------------------footer--------------------------->
        <div class="ull_width service_continer row_padding box_sizzing footer_container">
            <div class="inner_content_con commp_padd">

                <div class="footer_colm full_width f_box f_btwn">
                    <div class="footer_col about_us_bx">
                        <p>We are the best Pesticides consultants in India. We provide best services in industry. Our organization only provides pesticides registration in INDIA. No One else can provide the best consultancy of pesticides in India.</p>
                    </div>
                    <div class="footer_col">
                        <h4 class="widget-title ppoins_fonts">Quick LInks</h4>
                        <ul class="links_art"><li ><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="#" aria-current="page">Home</a></li>
                            <li><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="">Services</a></li>
                            <li ><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="">Contact</a></li>
                            <li ><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="">Prices</a></li>
                            <li  ><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="">Site Map</a></li>
                        </ul>
                    </div>
                    <div class="footer_col">
                        <h4 class="widget-title ppoins_fonts">Recent Articles</h4>
                        <ul class="links_art"><li ><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="#" aria-current="page">Home</a></li>
                            <li><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="">Services</a></li>
                            <li ><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="">Contact</a></li>
                            <li ><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="">Prices</a></li>
                            <li  ><i class="fa fa-paint-brush" aria-hidden="true"></i><a href="">Site Map</a></li>
                        </ul>
                    </div>
                    <div class="footer_col">
                        <h4 class="widget-title ppoins_fonts">Follow Us</h4>
                        <ul class="f_box socai_botom">
                            <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-instagram" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                </a></li>
                            <li><a href=""><i class="fa fa-linkedin" aria-hidden="true"></i>

                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------footer--------------------------->


    </div>
</div>
</div>

<link href="css/jquery.bxslider.min.css" rel="stylesheet" />
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/jquery.bxslider.min.js"></script>
<script>
    $(document).ready(function(){
        $('.top_slider').bxSlider({
            mode: 'horizontal',
            moveSlides: 1,
            slideMargin: 40,
            infiniteLoop: true,
            slideWidth:1920,
            minSlides:1,
            maxSlides:1,
            speed: 800,
        });
        $('.my_testimonal').bxSlider({
            mode: 'horizontal',
            moveSlides: 1,
            slideMargin: 40,
            infiniteLoop: true,
            slideWidth:1920,
            minSlides:1,
            maxSlides:1,
            speed: 800,
        });
    });
</script>
<script>
$(document).ready(function() {
  $(".set > a").on("click", function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active");
      $(this)
        .siblings(".content_one")
        .slideUp(200);
      $(".set > a i")
        .removeClass("fa-minus")
        .addClass("fa-plus");
    } else {
      $(".set > a i")
        .removeClass("fa-minus")
        .addClass("fa-plus");
      $(this)
        .find("i")
        .removeClass("fa-plus")
        .addClass("fa-minus");
      $(".set > a").removeClass("active");
      $(this).addClass("active");
      $(".content_one").slideUp(200);
      $(this)
        .siblings(".content_one")
        .slideDown(200);
    }
  });
  $(".my_men").click(function(){
      $(".mobile_menu").toggle();
  });
});

</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/5f8b2641f91e4b431ec54f4c/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->
</body>
</html>
