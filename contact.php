<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <?php include_once('partials/sitelinks.php'); ?>
</head>

<body>
 <?php include_once('includes/header.php'); ?>
    <!-- <div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact Us</h1>
                <ul class="breadcumb-menu">
                    <li><a href="index.php">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div> -->
 
 <div class="space">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-4 col-md-6 contact-info-size">
                    <div class="contact-info">
                        <div class="contact-info_icon">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="box-title">Our Office Address</h4>
                            <span class="contact-info_text">Bosco Soft Technologies Pvt. Ltd.<br>
No. 231/77, S.H.C Complex,<br> Tirupattur District Tamil Nadu,<br> India – 635 601</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 contact-info-size">
                    <div class="contact-info">
                        <div class="contact-info_icon"><i class="fas fa-phone"></i></div>
                        <div class="media-body">
                            <h4 class="box-title">Call Us Anytime</h4>
                            <span class="contact-info_text"><a href="tel:+91 9626800 800">+91 96 26 800 800</a>
                                <a href="tel:+91 9787721156">+91 97 87 721 156</a></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 contact-info-size">
                    <div class="contact-info">
                        <div class="contact-info_icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="box-title">Send An Email</h4>
                            <span class="contact-info_text"><a
                                    href="mailto:binfo@boscosofttech.com">binfo@boscosofttech.com</a>
                                <a href="mailto:chennaioffice@boscosofttech.com">higrade@boscosofttech.com</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="bg-smoke space" data-bg-src="assets/img/bg/contact_bg_1.png" id="contact-sec">
    <div class="container">
        <div class="row">
            <div class="col-xl-6">
                <div class="title-area mb-35 text-xl-start text-center">
                    <span class="sub-title">
                        <div class="icon-masking me-2">
                            <span class="mask-icon" data-mask-src="assets/img/theme-img/title_shape_2.svg"></span>
                        </div>
                        contact with us!
                    </span>
                    <h2 class="sec-title">Join Now for a Demo and Quote</h2>        
                </div>
                   <form id="contactForm">
                        <div class="row g-3 mb-5">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last Name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone Number" required minlength="10" maxlength="15" pattern="[0-9]{10,15}">
                                    </div>
                            <div class="col-12 mb-3">
                                <textarea name="address" id="address" class="form-control" placeholder="Your Address" rows="2"></textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <textarea name="message" id="message" class="form-control" placeholder="Your Message" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary submit-btn w-100 py-3" type="submit">Send Message</button>
                            </div>
                        </div>
                    </form>

                    <div id="loader" style="display:none;">Submitting...</div>
                    <div id="response"></div>
                
            </div>
        </div>
    </div>
</div>  
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3897.4567831978243!2d78.63016157411398!3d12.586120823214362!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3badaaea950786f3%3A0x5f3b489cca9a30a2!2sBosco%20Soft%20Technologies%20Pvt.%20Ltd.!5e0!3m2!1sen!2sin!4v1747895255639!5m2!1sen!2sin" width="600" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
<?php include_once('includes/footer.php'); ?>
<?php include_once('partials/sitejs.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#contactForm').on('submit', function (e) {
        e.preventDefault();
        $('#loader').show();

        $.ajax({
            type: 'POST',
            url: 'demoform.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                $('#loader').hide();
                if (response.status === 'success') {
                    $('#response').html('<div class="alert alert-success">' + response.message + '</div>');
                    $('#contactForm')[0].reset();
                } else {
                    $('#response').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function () {
                $('#loader').hide();
                $('#response').html('<div class="alert alert-danger">Something went wrong!</div>');
            }
        });
    });
});
</script>
</body>

</html>