<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>The Lynx School</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Shelly - Website" />
    <meta name="author" content="merkulove">
    <meta name="keywords" content="" />
    <link rel="icon" href="assets/img/lnxlogo-removebg-preview-icon.png">
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        #network .classes-col .class-thumb {
            position: relative;
            height: 100px !important;
            background-color: grey;
        }

        #network .classes-col .class-info {
            padding: 24px 15px 27px;
            border: 1px solid #d6d6d6;
            border-top: 0;
            border-radius: 0 0 10px 10px;
            height: 310px;
        }

        #network .classes-col .class-info h1 a {
            color: #575757;
        }

        .networks .card-header {
            padding: .75rem 1.25rem;
            margin-bottom: 0;
            height: 100px;
            width: auto;
            background-color: rgb(242, 247, 253);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-header h1 {
            color: black;
            font-weight: 700;
            text-align: center;
        }

        .card {
            position: relative;
            border: none !important;
        }

        .classes-carousel .card-header {
            /* background-color: rgba(0,0,1, 25%); */
            color: black;
        }

        .bld {
            color: black;
            font-weight: 500;
        }

        .social-icons {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .social-icons .icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #f4f4f4;
            color: #555;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icons .icon.facebook:hover {
            background-color: #1877f2;
            /* Facebook blue */
            color: #fff;
            transform: scale(1.1);
        }

        .social-icons .icon.website:hover {
            background-color: #0d6efd;
            /* Bootstrap blue for Website */
            color: #fff;
            transform: scale(1.1);
        }

        .social-icons .icon.instagram:hover {
            background: radial-gradient(circle at 30% 30%, #f58529, #dd2a7b, #8134af, #515bd4);
            color: #fff;
            transform: scale(1.1);
        }

        .card-footer {
            padding: 1rem 0;
            background-color: #ffffff;
            border-top: none;
        }

        .bot {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 85%;
            bottom: 1px;
        }

        .readmoreBtnMD:hover {
            color: #F32C2E !important;
        }

        .mdmsg {
            cursor: pointer;
        }

        @media (min-width: 600px) and (max-width: 1024px) {
            .teacher-img {
                height: 450px !important;
                width: 450px;
            }

            .teacher-img img {
                width: 100%;
                height: 450px !important;
            }
        }

        @media (max-width: 599px) {
            .teacher-img {
                height: auto !important;
            }

            .teacher-img img {
                width: 100%;
            }

            .lgocnt img {
                padding: 0px !important;
            }
        }

        /* Tree structure styles */
        .tree-container {
            position: relative;
            z-index: 2;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        /* Main School Node */
        .main-school {
            color: white;
            padding: 20px 40px;
            border-radius: 15px;
            margin-bottom: 50px;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        /* Network Headers */
        .network-header {
            color: white;
            padding: 15px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .network-header:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .node-card {
            background: white;
            border-radius: 10px;
            padding: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            margin-bottom: 20px;
            position: relative;
            z-index: 10;
        }

        .node-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
            border-color: #667eea;
        }

        .node-logo {
            text-align: center;
            padding-bottom: 14px;
        }

        .node-logo img {
            border-radius: 150px;
            width: 170px;
        }

        .node-title {
            color: #333;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            padding-bottom: 8px;
            line-height: 1.3;
        }

        /* SVG for connecting lines */
        .tree-lines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        /* SVG styles for lines */
        .connection-line {
            stroke: #e70e0e;
            stroke-width: 3;
            fill: none;
            opacity: 0.8;
        }

        .connection-dot {
            fill: #f09433;
            opacity: 0.9;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .main-school {
                padding: 15px 25px;
                margin-bottom: 30px;
            }

            .network-header {
                padding: 12px 20px;
                margin-bottom: 20px;
            }

            .node-card {
                padding: 15px;
            }

            .node-title {
                font-size: 1rem;
            }
        }
    </style>
</head>


<body>
    <div class="wrapper" style="padding-top: 0;">

        <div class="main-section" style="padding-top: 100px;">

            <header
                style="position: fixed; top: 0; left: 50%; transform: translateX(-50%); width: 100%; z-index: 9999999; transition: all 0.4s; height:100px;">
                <div class="container" style=" width:100% !important;  max-width:100% !important;
    height: 100%;
">
                    <div class="row  md-center" style=" width:100% !important;  max-width:100% !important;">
                        <!-- <div " row "> -->
                        <div class="col-lg-3   col  logo">
                            <a href="index.html" title="">

                                <!-- <img src="assets/img/logo.png" alt="" srcset="assets/img/01_Logo_2x.png 2x"> -->
                                <div class="lgocnt" style="
    height: 100px;
    /* width: 300px !important; */
">
                                    <img src="assets/img/lnxlogo-removebg-preview.png" alt=" " style="
										height: 100%;
										/* width: 100%; */
										padding: 20px 0px 20px 20px;
									">
                                </div>
                            </a>
                        </div>
                        <!--logo end-->


                        <!-- <ul class="contact-add d-flex flex-wrap"> -->



                        <div class="col-9 navigation-bar   align-items-center   text-center ">
                            <nav>
                                <ul>
                                    <!-- <li><a class="active" href="index.html" title="">Home</a></li> -->
                                    <li><a href="about.html" title="">About</a></li>
                                    <li><a href="academics.html" title="">Academics</a></li>
                                    <li><a href="affiliations.html" title="">Affiliations</a></li>
                                    <li><a href="gallery.html" title="">Gallery</a></li>
                                    <li class="#">
                                        <a href="career.html" title="">Careers</a>
                                    </li>
                                    <li><a href="alumni.html" title="">Alumni</a></li>
                                    <li><a href="contacts.html" title="">Contact Us</a></li>
                                    <li class="#">
                                        <a href="admissions.html" title="" class="admissions">Admissions</a>
                                    </li>
                                    <li class="#">
                                    <a href="fee-challan.html" title="" class="fee-challan-btn"
                                      >Fee Challan</a
                                    >
                  </li>
                                </ul>
                            </nav>
                            <!--nav end-->

                        </div>
                        <!--navigation-bar end-->




                        <div class="col-md-2 menu-btn">
                            <a href="#">
                                <span class="bar1"></span>
                                <span class="bar2"></span>
                                <span class="bar3"></span>
                            </a>
                        </div>

                    </div>


                    <!--menu-btn end-->
                </div>
            </header>

            <div class="responsive-menu">
                <ul>
                    <li><a href="index.html" title="">Home</a></li>
                    <li><a href="about.html" title="">About</a>
                    <li><a href="career.html" title="">Careers</a>
                    <li><a href="admissions.html" title="">Admissions </a>
                    <li><a href="affiliations.html" title="">Affiliations</a>
                    <li><a href="gallery.html" title="">Gallery</a>
                    <li><a href="academics.html" title="">Academics</a>
                    <li><a href="alumni.html" title="">Alumni</a>
                    <li><a href="contacts.html" title="">Contact Us</a>
                </ul>
            </div>
            <!--responsive-menu end-->

            <section class="main-banner">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-md-7">
                            <div class="banner-text wow fadeInLeft" data-wow-duration="1000ms">
                                <h2 style="color:#2b2b2b;">We Teach the Way to<span
                                        style="color:#F32C2E;">&nbsp;Learn&nbsp;</span></h2>
                                <p>“To provide a secure and nurturing environment where children are valued as unique,
                                    independent and confident learners with ‘CAN DO’ attitude, by giving them
                                    stimulating and equal opportunities to excel and achieve their full potential”</p>
                                <!-- <button style=" margin-bottom: 50px ; background-color: white;"> <a href="about.html"
										style="background: black;border-radius: 40px; padding: 10px 30px ;color: white;">Explore
										more</a>
								</button> -->
                                <a href="about.html" title="" class="btn-default">Explore more <i
                                        class="fa fa-long-arrow-alt-right"></i></a>
                                <form class="search-form">
                                    <!-- <input type="text" name="search" placeholder="Search Class"> -->
                                    <!-- <button><i class="fa fa-search"></i></button> -->

                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5">
                            <div class="banner-img wow zoomIn" data-wow-duration="1000ms">
                                <img src="./assets/newimgs/banner-imgmain.png" alt="" style="width: 100%;">
                            </div>
                            <!--banner-img end-->
                            <div class="elements-bg wow zoomIn" data-wow-duration="1000ms"></div>
                        </div>
                    </div>
                </div>
            </section>
            <!--main-banner end-->

            <!-- <h2 class="main-title">Shelly</h2> -->

        </div>
        <!--main-section end-->

        <section class="about-us-section">
            <div class="container">
                <div class="section-title text-center">
                    <h2>Welcome to the<span style="color:#F32C2E;"> Lynx School</span></h2>
                    <p>The Lynx School is a hub of innovation, creativity, and holistic learning, dedicated to nurturing
                        young minds and shaping a bright future.</p>
                </div>
                <!--section-title end-->
                <div class="about-sec">
                    <div class="container">
                        <div class="row classes-carousel">
                            <div class="col-lg-3 col-md-6 col-sm-6 " style="height: 250px; width: 332px;">
                                <div class="abt-col wow fadeInUp classes-col  flogo" data-wow-duration="1000ms"
                                    data-wow-delay="400ms" style="visibility: visible; padding: 24px; height: 96%;">
                                    <!-- <img src="assets/img/icon7.png" alt=""> -->
                                    <i class="fa fa-child"></i>
                                    <h3>Early Years</h3>
                                    <p>Building strong foundations through play, curiosity, and nurturing early
                                        childhood development.</p>
                                </div>
                                <!--abt-col end-->
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 " style="height: 250px; width: 332px;">
                                <div class="abt-col wow fadeInUp classes-col  flogo" data-wow-duration="1000ms"
                                    data-wow-delay="400ms" style="visibility: visible; padding: 24px; height: 96%;">
                                    <!-- <img src="assets/img/icon8.png" alt=""> -->
                                    <i class="fa fa-pencil-alt" style="color: #0d0c71;"></i>
                                    <h3>Juniors</h3>
                                    <p>Fostering growth, creativity, and confidence in every step of their learning
                                        journey.</p>
                                </div>
                                <!--abt-col end-->
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 " style="height: 250px; width: 332px;">
                                <div class="abt-col wow fadeInUp classes-col  flogo" data-wow-duration="1000ms"
                                    data-wow-delay="400ms" style="visibility: visible; padding: 24px; height: 96%;">
                                    <!-- <img src="assets/img/icon9.png" alt=""> -->
                                    <i class="fa fa-book"></i>
                                    <h3>Primary</h3>
                                    <p>Empowering young minds with knowledge, values, and skills for a brighter future.
                                    </p>
                                </div>
                                <!--abt-col end-->
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 " style="height: 250px; width: 332px;">
                                <div class="abt-col wow fadeInUp classes-col  flogo" data-wow-duration="1000ms"
                                    data-wow-delay="400ms" style="visibility: visible; padding: 24px; height: 96%;">
                                    <!-- <img src="assets/img/icon9.png" alt=""> -->
                                    <i class="fa fa-school" style="color: #0d0c71;"></i>
                                    <h3>Elementary</h3>
                                    <p>Inspiring curiosity, building character, and nurturing a lifelong love for
                                        learning.</p>
                                </div>
                                <!--abt-col end-->
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 " style="height: 250px; width: 332px;">
                                <div class="abt-col wow fadeInUp classes-col  flogo" data-wow-duration="1000ms"
                                    data-wow-delay="400ms" style="visibility: visible; padding: 24px; height: 96%;">
                                    <!-- <img src="assets/img/icon9.png" alt=""> -->
                                    <i class="fa fa-user-graduate"></i>
                                    <h3>Senior</h3>
                                    <p>Preparing leaders of tomorrow with knowledge, integrity, and a vision for
                                        success.</p>
                                </div>
                                <!--abt-col end-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--about-rw end-->
                <div class="abt-img">
                    <ul class="masonary">
                        <li class="width1 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/SFTM4147.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/SFTM4147.JPG" alt=""></a></li>
                        <li class="width2 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/TXCI5091.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/TXCI5091.JPG" alt=""></a></li>
                        <li class="width3 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/ONWQ2586.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/ONWQ2586.JPG" alt=""></a></li>
                        <li class="width4 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/HWPF5551.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/HWPF5551.JPG" alt=""></a></li>
                        <li class="width5 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/BUKM1087.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/BUKM1087.JPG" alt=""></a></li>
                        <li class="width6 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/UBFJ8097.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/UBFJ8097.JPG" alt=""></a></li>
                        <li class="width7 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/AKGP4523.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/AKGP4523.JPG" alt=""></a></li>
                        <li class="width8 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/WQYS4287.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/WQYS4287.JPG" alt=""></a></li>
                        <li class="width9 wow zoomIn" data-wow-duration="1000ms"><a href="./assets/newimgs/ACLP6665.JPG"
                                data-group="set1" title="" class="html5lightbox"><img
                                    src="./assets/newimgs/ACLP6665.JPG" alt=""></a></li>
                        <li class="width10 wow zoomIn" data-wow-duration="1000ms"><a
                                href="./assets/newimgs/RELA2319.JPG" data-group="set1" title=""
                                class="html5lightbox"><img src="./assets/newimgs/RELA2319.JPG" alt=""></a></li>
                    </ul>
                </div><!-- abt-img end-->
            </div>
        </section>
        <!--about-us-section end-->

        <section class="classes-section">
            <div class="container">
                <div class="sec-title  ">
                    <h2>Our Affiliations</h2>
                    <p>The Affiliations section on The Lynx School website showcases our esteemed partnerships with
                        renowned organizations, enhancing credibility and trust.</p>
                </div>
                <!--sec-title end-->
                <div class="classes-sec">
                    <div class="row classes-carousel">
                        <div class="col-lg-3">
                            <div class="classes-col wow fadeInUp" data-wow-duration="1000ms">
                                <div class="class-thumb">
                                    <img src="assets\img\img1.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post.html" title="">Cambridge International</a></h3>

                                    <div class="d-flex flex-wrap align-items-center">

                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="200ms">
                                <div class="class-thumb">
                                    <img src="assets\img\image.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post2.html" title="">FBISE Islamabad</a>
                                    </h3>


                                    <div class="d-flex flex-wrap align-items-center">
                                        <p></p>

                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                                <div class="class-thumb">
                                    <img src="assets\img\img\1.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post3.html" title="">Punjab Boys Scouts Association</a>
                                    </h3>

                                    <div class="d-flex flex-wrap align-items-center">


                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="600ms">
                                <div class="class-thumb">
                                    <img src="assets\img\img\2.2.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post4.html" title="">Chinese Confucius Institute</a>
                                    </h3>

                                    <div class="d-flex flex-wrap align-items-center">


                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col">
                                <div class="class-thumb">
                                    <img src="assets\img\img\4.1.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post5.html" title="">WWF Pakistan</a></h3>

                                    <div class="d-flex flex-wrap align-items-center">

                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col">
                                <div class="class-thumb">
                                    <img src="assets\img\img\3.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post6.html" title="">National Book Foundation</a>
                                    </h3>

                                    <div class="d-flex flex-wrap align-items-center">

                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col">
                                <div class="class-thumb">
                                    <img src="assets\img\img\5.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post7.html" title="">Oxford University Press</a>
                                    </h3>

                                    <div class="d-flex flex-wrap align-items-center">


                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col">
                                <div class="class-thumb">
                                    <img src="assets\img\img\6.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post8.html" title="">Paramount Books</a>
                                    </h3>

                                    <div class="d-flex flex-wrap align-items-center">


                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col">
                                <div class="class-thumb">
                                    <img src="assets\img\img\7.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post9.html" title="">HRCA</a>
                                    </h3>

                                    <div class="d-flex flex-wrap align-items-center">


                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col">
                                <div class="class-thumb">
                                    <img src="assets\img\img\8.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post10.html" title="">IKLC</a>
                                    </h3>

                                    <div class="d-flex flex-wrap align-items-center">


                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                        <div class="col-lg-3">
                            <div class="classes-col">
                                <div class="class-thumb">
                                    <img src="assets\img\img\9.png" alt="" class="w-100">

                                </div>
                                <div class="class-info">
                                    <h3><a href="post11.html" title="">IKMC</a>
                                    </h3>

                                    <div class="d-flex flex-wrap align-items-center">


                                    </div>
                                </div>
                            </div>
                            <!--classes-col end-->
                        </div>
                    </div>
                    <div class="lnk-dv text-center">
                        <a href="affiliations.html" title="" class="btn-default">Affiliations <i
                                class="fa fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
                <!--classes-sec end-->
            </div>
        </section>
        <!--classes-section end-->

        <!-- School Network Tree Structure -->
        <section class="classes-section">
            <div class="container">
                <div class="sec-title">
                    <h2>Our Network</h2>
                    <p>The Lynx School is part of a thriving network of educational institutions dedicated to shaping
                        the leaders of tomorrow.
                        Our network spans multiple campuses, each committed to providing top-tier education and
                        resources.</p>
                </div>

                <!--Tree / Hierarchy-->
                <section class="management-hierarchy">
                    <div class="hv-container">
                        <div class="hv-wrapper">

                            <!-- Key component -->
                            <div class="hv-item">

                                <div class="hv-item-parent">
                                    <div class="person">
                                        <img src="assets/img/lynxLogoBG.png" alt="">
                                        <p class="name">
                                            The Lynx Head Office
                                        </p>
                                    </div>
                                </div>

                                <div class="hv-item-children">

                                    <!-- Islamabad Network -->
                                    <div class="hv-item-child">
                                        <div class="hv-item">
                                            <div class="hv-item-parent">
                                                <div class="person">
                                                    <img src="assets/img/lynxLogoBG.png" alt="">
                                                    <p class="name">
                                                        Islamabad Network
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="hv-item-children">

                                                <div class="hv-item-child">
                                                    <div class="person">
                                                        <img src="assets/img/lynxLogoBG.png" alt="">
                                                        <p class="name">
                                                            The Lynx <br> Daycare Islamabad
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="hv-item-child">
                                                    <div class="person">
                                                        <img src="assets/img/lynxLogoBG.png" alt="">
                                                        <p class="name">
                                                            The Lynx Nursery Islamabad
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="hv-item-child">
                                                    <div class="person">
                                                        <img src="assets/img/lynxLogoBG.png" alt="">
                                                        <p class="name">
                                                            The Lynx Primary Branch Islamabad
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Rawalpindi Network -->
                                    <div class="hv-item-child">
                                        <div class="hv-item">
                                            <div class="hv-item-parent">
                                                <div class="person">
                                                    <img src="assets/img/lynxLogoBG.png" alt="">
                                                    <p class="name">
                                                        Rawalpindi Network
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="hv-item-children">

                                                <div class="hv-item-child">
                                                    <div class="person">
                                                        <img src="assets/img/lynxLogoBG.png" alt="">
                                                        <p class="name">
                                                            The Lynx Daycare Rawalpindi
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="hv-item-child">
                                                    <div class="person">
                                                        <img src="assets/img/lynxLogoBG.png" alt="">
                                                        <p class="name">
                                                            The Lynx Nursery Rawalpindi
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="hv-item-child">
                                                    <div class="person">
                                                        <img src="assets/img/lynxLogoBG.png" alt="">
                                                        <p class="name">
                                                            The Lynx Secondary Branch Rawalpindi
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </section>

            </div>
        </section>

        <section class="teachers-section">
            <div class="container">
                <div class="sec-title  ">
                    <h2>MD's Message</h2>
                </div>
                <!--sec-title end-->
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <img src="assets\img\MDs_Picture.jpg" alt="" class="md-img">
                    </div>
                    <a class="col-lg-6 col-md-6 col-12 mdmsg" href="mdsmsg.html">
                        <p style="line-height: 34px; font-size: 16.23px; text-align: justify;">
                            Welcome to The Lynx School – where learning meets purpose, and every child’s potential is
                            our promise. <br />

                            It is with immense pride and joy that I welcome you to The Lynx School, an institution
                            founded on the principles of excellence, integrity, and innovation in education. As the
                            Managing Director, it is both an honor and a responsibility to lead a school that is
                            committed to shaping the future generation with a strong foundation of knowledge, character,
                            and vision. <br />

                            At The Lynx School, we believe that education is more than just academics—it is the art of
                            nurturing minds, cultivating values, and igniting a passion for lifelong learning. Our aim
                            is not only to prepare students for exams, but to prepare them for life. <br />

                            <p class="md-hidden" style="line-height: 34px; font-size: 16.23px; text-align: justify;">
                                From the Early Years to the Senior Level, our academic framework is
                                designed to cater to the
                                holistic development of every learner.
                            </p>
                            <p class="lg-hidden" style="line-height: 34px; font-size: 16.23px; text-align: justify;">
                                We provide a
                                safe, inclusive, and stimulating environment that encourages curiosity, critical
                                thinking,
                                creativity, and compassion. Our curriculum is carefully structured to ensure a balance
                                between core subjects, life skills, extracurriculars, and character-building
                                experiences. We
                                are proud to integrate modern teaching methodologies with traditional values, creating a
                                learning culture that is both progressive and grounded.
                            </p>
                        </p>
                        <div class="p-4"
                            style="width: 100%; position: relative; top: -22px; background-image: linear-gradient(0deg, #ffffff00, #ffffff, #ffffff7a); padding-left: 0px!important;">

                            <button class="readmoreBtnMD"
                                style="background-color: transparent; color: gray; padding-left: 0px;">
                                Read More <i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
                        </div>
                    </a>
                    <!-- <div class="col-lg-12 col-md-12 col-12 ">
						<P style="line-height: 34px; font-size: 16.23px; text-align: justify;">

							<span class="md-show lg-hidden">Each child who arrives in The Lynx School comes with their own individual challenges,
							and our task during their time in school is to build their self-confidence so that they
							are unafraid to take the risk of attempting new challenges, to help them blossom and
							grow as individuals and to give them the academic, social and emotional skills to enable
							them to better apprehend their various potential.</span><br>

							Hence our motto of the school for the following years is "Constructing a Homely School
							Environment Together With the Family and School to enrich the Aggregate Development of
							the Child". As I personally think that "What our kids are going to be in future is what
							we create of them".

							It is above all else a true sense of community, where each member/teacher makes his or
							her own remarkable contribution, and where all experience the exhilarations and scuffles
							of working & growing conjointly and successively , which makes The Lynx School truly a
							special place.

							If you would like to hear more about our school, or arrange a visit, please follow the
							contact links and rest assured you will be more than welcome.<br><br>

							<span style="font-style: italic; font-weight: bold; ">Thank You</span><br>

							<span style="font-weight: bolder; font-size: 15px;">Mrs. Misbak Khurshid</span>

						</P>
					</div> -->
                </div>
                <!-- <div class="teachers" >
					<div class="row">
						<div class="col-lg-6 col-md-12  col-12">
								<img src="assets\img\MDs_Picture.jpeg" alt="" class="">
						</div>
						<div class="col-lg-6 col-md-12 col-12">
							<P style="text-align: justify;">
								As a Managing directress/Principal of The Lynx School, it is my gratification to welcome
								you to our school website. We anticipate providing you worthwhile information.<br>

								The website showcases the wealth of experiences we offer the children and give them a
								wider audience for their wonderful work. We hope you enjoy your visit and return
								regularly to check out our latest news.<br>

								We have a passion and "To Create the Right Environment and Atmosphere That Will
								Facilitate, The Nurturing and Training of Children Who Will Have "Character", "Purpose"
								and "Skill" for This Life and Eternity. And our vision is to develop good study habits,
								moral values, reflective ability, self-discipline, and the basic learning skills, i.e.
								literacy, numeracy, Critical thinking and IT skills.<br>

								Each child who arrives in The Lynx School comes with their own individual challenges,
								and our task during their time in school is to build their self-confidence so that they
								are unafraid to take the risk of attempting new challenges, to help them blossom and
								grow as individuals and to give them the academic, social and emotional skills to enable
								them to better apprehend their various potential.<br>
							</P>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-12 ">
							<P style="text-align: justify;">
								
								Hence our motto of the school for the following years is "Constructing a Homely School
								Environment Together With the Family and School to enrich the Aggregate Development of
								the Child". As I personally think that "What our kids are going to be in future is what
								we create of them".<br>

								It is above all else a true sense of community, where each member/teacher makes his or
								her own remarkable contribution, and where all experience the exhilarations and scuffles
								of working & growing conjointly and successively , which makes The Lynx School truly a
								special place.<br>

								If you would like to hear more about our school, or arrange a visit, please follow the
								contact links and rest assured you will be more than welcome.<br><br>

								<span style="font-style: italic; font-weight: bold; ">Thank You</span><br>

								<span style="font-weight: bolder; font-size: 15px;">Mrs. Misbak Khurshid</span>

							</P>
						</div>
					</div>
				</div> -->
            </div>
        </section>


        <!-- Upcoming Events Section -->
        <section class="course-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="sec-title">
                            <h2>Upcoming Events</h2>
                            <p>The Lynx School offers enriching events for a well-rounded 2025-26 academic experience.
                            </p>
                        </div>

                        <!-- Swiper Slider for Event Images -->
                        <div class="find-course">
                            <div class="swiper myEventSwiper">
                                <div class="swiper-wrapper" id="event-images">
                                    <!-- Images will be injected dynamically -->
                                </div>
                                <!-- Pagination -->
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="courses-list" id="events-list">
                            <!-- Event cards will be injected dynamically -->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                fetch("https://thelynxschool.edu.pk/lynxadmin/public/api/upcoming-events/latest")
                    .then(res => res.json())
                    .then(events => {
                        const imagesContainer = document.getElementById("event-images");
                        const eventsList = document.getElementById("events-list");

                        events.forEach((event, index) => {
                            // Add to Swiper slider
                            imagesContainer.innerHTML += `
                    <div class="swiper-slide">
                        <a href="event-single.html?id=${event.id}">
                            <img src="${event.main_image_url}" alt="${event.title}">
                        </a>
                    </div>
                `;

                            // Add to Events List (keeping design)
                            eventsList.innerHTML += `
                    <div class="course-card wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="${index * 200}ms">
                        <div class="d-flex flex-wrap align-items-center">
                            <ul class="course-meta imgclr">
                                <li>
                                    <img src="assets/img/icon12.png" alt="">
                                    ${new Date(event.date).toLocaleDateString("en-GB")}
                                </li>
                                <li>
                                    ${event.time_label}
                                </li>
                            </ul>
                        </div>
                        <h3>
                            <a href="event-single.html?id=${event.id}" title="${event.title}">${event.title}</a>
                        </h3>
                        <div class="d-flex flex-wrap">
                            <span class="locat"><img src="assets/img/loct.png" alt="" />${event.location}</span>
                        </div>
                    </div>
                `;
                        });

                        // Initialize Swiper
                        new Swiper(".myEventSwiper", {
                            loop: true,
                            autoplay: {
                                delay: 2500,
                                disableOnInteraction: false,
                            },
                            pagination: {
                                el: ".swiper-pagination",
                                clickable: true,
                            },
                        });
                    })
                    .catch(err => console.error("Error loading events:", err));
            });
        </script>

        <style>
            /* Active navigation color */
            /* nav ul li a.active {
                color: #f6521f !important;
            } */
            .swiper-pagination-bullet {
                background: #f6521f;
            }

            .myEventSwiper {
                width: 100%;
                height: 100%;
            }

            .myEventSwiper .swiper-slide {
                display: flex;
                justify-content: center;
                align-items: center;
                /* Ensure slides don't have padding or margins */
                padding: 0;
                margin: 0;
            }

            .myEventSwiper .swiper-slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                /* Makes sure images fill without distortion */
                display: block;
            }
        </style>


        <!--course-section end-->


        <!--blog-section end-->


        <!--Blog Section Dynamic-->
        <section class="blog-section">
            <div class="container">
                <div class="section-title text-center">
                    <h2>From the News</h2>
                </div>

                <!-- Swiper -->
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper" id="news-container">
                        <!-- JS will inject slides here -->
                    </div>

                    <!-- Navigation -->
                    <!--<div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div> -->
                </div>
            </div>
        </section>


        <script>
            async function loadNews() {
                try {
                    const response = await fetch("https://thelynxschool.edu.pk/lynxadmin/public/api/news");
                    let news = await response.json();
                    // news = [...news, ...news]; // duplicate array to test with 6 items
                    const container = document.getElementById("news-container");
                    container.innerHTML = "";

                    news.forEach(item => {
                        const slide = document.createElement("div");
                        slide.className = "swiper-slide";

                        slide.innerHTML = `
          <div class="blog-post">
            <div class="blog-thumbnail">
              <img src="${item.image_url}" alt="${item.title}" class="w-100">
            </div>
            <div class="blog-info">
              <h3><a href="news-details.html?id=${item.id}" title="" style="color:black; font-size: 20px; font-weight: 500px;">${item.title}</a></h3>
              <p>${item.excerpt}</p>
              <a href="news-details.html?id=${item.id}" class="read-more">Read <i class="fa fa-long-arrow-alt-right"></i></a>
            </div>
          </div>
        `;

                        container.appendChild(slide);
                    });

                    // Initialize Swiper after content is injected
                    new Swiper(".mySwiper", {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        loop: true,
                        pagination: {
                            el: ".swiper-pagination",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        breakpoints: {
                            0: { slidesPerView: 1 },      // mobile
                            768: { slidesPerView: 2 },    // tablets
                            1024: { slidesPerView: 3 }    // desktops
                        }
                    });
                } catch (error) {
                    console.error("Failed to load news:", error);
                }
            }

            loadNews();
        </script>

        <style>
            .blog-post .read-more {
                display: inline-block;
                color: #120D52;
                font-size: 14.23px;
                font-weight: 600;
                transition: all 0.5s;
            }

            .blog-post .read-more:hover {
                color: #F32C2E;
            }
        </style>

        <!--Blog Section Dynamic End-->

        <section class="newsletter-section" style="margin-top: 80px">
            <div class="container">
                <div class="newsletter-sec">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="newsz-ltr-text">
                                <h2>
                                    Join us <br />
                                    and stay tuned!
                                </h2>
                                <a href="contacts.html" title="" class="btn-default">Join Us <i
                                        class="fa fa-long-arrow-alt-right"></i></a>
                            </div>
                            <!--newsz-ltr-text end-->
                        </div>
                        <div class="col-lg-8">
                            <form id="career-form" class="newsletter-form" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="name" placeholder="Name" />
                                        </div>
                                        <!--form-group end-->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="email" name="email" placeholder="Email" />
                                        </div>
                                        <!--form-group end-->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="phone" placeholder="Phone Number" />
                                        </div>
                                        <!--form-group end-->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select name="career" class="form-control">
                                                <option value="" disabled selected>
                                                    Select a Career
                                                </option>
                                                <option value="Academics">Academics</option>
                                                <option value="Administration">Administration</option>
                                            </select>
                                        </div>
                                        <!--form-group end-->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="upload-resume" class="custom-upload-label">Upload Resume</label>
                                            <input type="file" id="upload-resume" name="cv" style="display: none" />
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-4">
										<div class="form-group select-tg">
											<select>
												<option>Class</option>
												<option>Class</option>
												<option>Class</option>
												<option>Class</option>
												<option>Class</option>
												<option>Class</option>
											</select>
										</div>
									</div> -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" placeholder="Message"></textarea>
                                        </div>
                                        <!--form-group end-->
                                    </div>
                                </div>
                                <div class="lnk-dv text-center">
                                    <button title="" type="submit" role="button" class="btn-default">
                                        Submit <i class="fa fa-long-arrow-alt-right"></i>
                                    </button>
                                </div>
                                <!-- <div class="form-group">
									<button type="submit" class="btn btn-primary">
										<style padding: 30px></style>Submit</button>
								</div> -->
                            </form>
                            <!--newsletter-form end-->
                        </div>
                    </div>
                </div>
                <!--newsletter-sec end-->
            </div>
        </section>
        <!--newsletter-sec end-->

        <script>
            document
                .getElementById("career-form")
                .addEventListener("submit", async function (e) {
                    e.preventDefault();

                    const form = e.target;
                    const formData = new FormData(form);
                    for (let [key, value] of formData.entries()) {
                        console.log(key, value);
                    }
                    try {
                        const response = await fetch(
                            "https://thelynxschool.edu.pk/lynxadmin/public/api/career-applications",
                            {
                                method: "POST",
                                body: formData,
                            }
                        );

                        const result = await response.json();

                        if (response.ok) {
                            alert("✅ Application submitted successfully!");
                            window.location.reload();
                            form.reset();
                        } else {
                            alert("Error: " + (result.message || "Something went wrong."));
                        }
                    } catch (error) {
                        console.error("Error submitting application:", error);
                        alert("Network error. Please try again later.");
                    }
                });
        </script>

        <footer>
            <div class="container">
                <div class="top-footer">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="lgocnt">
                                <img src="assets/img/lnxlogo-removebg-preview.png" alt=" " style="height: 100%;
									width: 100%;
									padding: 0px 0px 20px 20px;
								">
                                <!-- <p
									style="font-family:Edwardian Script ITC; font-size:32px; font-weight: 1000;  text-align: center; ">
									<b>The Lynx School </b>
								</p> -->
                            </div>
                            <div>

                                <p style="padding: 0px 19px 0px 19px; text-align: justify;">The Lynx School is a
                                    distinguished educational institution committed to providing a
                                    holistic and enriching learning experience with a focus on academic excellence,
                                    character building, and skill development. </p>
                            </div>

                        </div>
                        <!-- <div class="col-lg-3 col-md-6 col-sm-6">
							<div class="widget widget-contact">
								<ul class="contact-add">
									<li>
										<div class="contact-info">
											<img src="assets/img/icon1.png" alt="">
											<div class="contact-tt">
												<h4>Call</h4>
												<span>+92 51 4901010</span>
											</div>
										</div>
									</li>
									<li>
										<div class="contact-info">
											<img src="assets/img/icon2.png" alt="">
											<div class="contact-tt">
												<h4>Work Time</h4>
												<span>Mon - Fri 8 AM - 5 PM</span>
											</div>
										</div>
									</li>
									<li>
										<div class="contact-info">
											<img src="assets/img/icon3.png" alt="">
											<div class="contact-tt">
												<h4>Head Office</h4>
												<span>House 931, Street 91 Sector I-8/4 Islamabad.</span>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div> -->

                        <div class="col-lg-3 col-md-6 col-sm-6 footer-links-1">
                            <div class="widget widget-links">
                                <h3 class="widget-title" style="padding-top: 60px;"></h3>
                                <ul>
                                    <li><a href="about.html" title="">About</a>
                                    <li><a href="career.html" title="">Careers</a>
                                    <li><a href="admissions.html" title="">Admissions </a>
                                    <li><a href="affiliations.html" title="">Affiliations</a>
                                        <!-- <li><a href="gallery.html" title="">Gallery</a>
									<li><a href="academics.html" title="">Academics</a>
									<li><a href="alumni.html" title="">Alumni</a>
									<li><a href="contacts.html" title="">Contact Us</a> -->
                                </ul>
                            </div>
                            <!--widget-links end-->
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 footer-links-2">
                            <div class="widget widget-links">
                                <h3 class="widget-title" style="
    padding-top: 60px;
"></h3>
                                <ul>

                                    <li><a href="gallery.html" title="">Gallery</a>
                                    <li><a href="academics.html" title="">Academics</a>
                                    <li><a href="alumni.html" title="">Alumni</a>
                                    <li><a href="contacts.html" title="">Contact Us</a>
                                </ul>
                            </div>
                            <!--widget-links end-->
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget widget-contact">
                                <ul class="contact-add" style="
    padding-top: 80px;
">

                                    <li>
                                        <div class="contact-info">
                                            <!-- <img src="assets/img/icon2.png" alt=""> -->
                                            <div class="contact-tt">
                                                <h4>Work Time</h4>
                                                <span>Mon - Fri 8 AM - 5 PM</span>
                                            </div>
                                        </div>
                                    </li>


                                    <li>
                                        <div class="contact-info">
                                            <!-- <img src="assets/img/icon2.png" alt=""> -->
                                            <div class="contact-tt">
                                                <h4>Social</h4>
                                                <ul class="social-links" style="
    display: flex; margin-top: 10px;
">
                                                    <li><a href="https://www.facebook.com/profile.php?id=100089523870242"
                                                            title=""><i class="fab fa-facebook-f"></i></a></li>
                                                    <!-- <li><a href="#" title=""><i class="fab fa-linkedin-in"></i></a></li> -->
                                                    <li><a href="https://www.instagram.com/the_lynx_school/" title=""><i
                                                                class="fab fa-instagram"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>


                                </ul>
                            </div>
                        </div>

                        <!-- 
						<div class="col-lg-3 col-md-6 col-sm-6">
							<div class="widget widget-iframe">
								<iframe
									src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13282.94423024342!2d73.07252444011125!3d33.66400030856211!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38df95226e356f43%3A0xe681edb45923603!2sDAYCARE%20(THE%20LYNX%20SCHOOL%20SMC%20PVT%20LTD)!5e0!3m2!1sen!2s!4v1734169452664!5m2!1sen!2s"
									width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
									referrerpolicy="no-referrer-when-downgrade"></iframe>
								<iframe src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
							</div>widget-iframe end
						</div> -->
                    </div>
                </div>
                <!--top-footer end-->
                <div class="bottom-footer">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <p>© Copyrights 2024 The Lynx School</p>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <ul class="social-links">
                                <p>All rights reserved</p>
                                <!-- <li><a href="https://www.facebook.com/profile.php?id=100089523870242" title=""><i
											class="fab fa-facebook-f"></i></a></li> -->
                                <!-- <li><a href="#" title=""><i class="fab fa-linkedin-in"></i></a></li> -->
                                <!-- <li><a href="https://www.instagram.com/the_lynx_school/" title=""><i
											class="fab fa-instagram"></i></a></li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                <!--bottom-footer end-->
            </div>
        </footer>
        <!--footer end-->
        <!--footer end-->


        <!--back to top begin-->
        <button class="back-to-top">
            <i class="fas fa-arrow-up"></i>
        </button>
        <!--back to top end-->

    </div>



    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/html5lightbox.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/tweenMax.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/scripts.js"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cards = document.querySelectorAll(".course-card");
            const images = {
                "course-card1": document.querySelector(".imgone"),
                "course-card2": document.querySelector(".imgtwo"),
                "course-card3": document.querySelector(".imgthree")
            };

            // Hide all except imgone initially
            Object.entries(images).forEach(([key, img]) => {
                img.style.display = (key === "course-card1") ? "block" : "none";
            });

            cards.forEach(card => {
                card.addEventListener("mouseenter", () => {
                    // Find the class that matches the images' keys
                    const className = [...card.classList].find(cls => images.hasOwnProperty(cls));
                    if (className) {
                        Object.entries(images).forEach(([key, img]) => {
                            img.style.display = (key === className) ? "block" : "none";
                        });
                    }
                });

                card.addEventListener("mouseleave", () => {
                    // Reset to imgone after leaving
                    Object.entries(images).forEach(([key, img]) => {
                        img.style.display = (key === "course-card1") ? "block" : "none";
                    });
                });
            });
        });
    </script>

</body>

</html>