<?php
// appointment.php
require_once "session.php";

// Department-wise doctors and services
$hospital_data = [
    "Cardiology" => [
        "doctors" => ["Dr. Arif Rahman", "Dr. Maya Das"],
        "services" => ["ECG", "Echocardiogram", "Angiography"]
    ],
    "Neurology" => [
        "doctors" => ["Dr. Hossain Kabir"],
        "services" => ["EEG", "Stroke Management", "Neuro Imaging"]
    ],
    "Pediatrics" => [
        "doctors" => ["Dr. Rita Sultana", "Dr. Noman Akter"],
        "services" => ["Child Vaccination", "Growth Monitoring"]
    ],
    "Orthopedics" => [
        "doctors" => ["Dr. Amina Karim", "Dr. Jamal Uddin"],
        "services" => ["Fracture Treatment", "Joint Replacement"]
    ],
    "Gynecology & Obstetrics" => [
        "doctors" => ["Dr. Shabnam Noor"],
        "services" => ["Prenatal Checkup", "Delivery", "Ultrasound"]
    ],
    "Dermatology" => [
        "doctors" => ["Dr. Fahim Rahman"],
        "services" => ["Skin Biopsy", "Allergy Test", "Laser Treatment"]
    ],
];
$departments = array_keys($hospital_data);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShasthoBondhu</title>
    <link rel="icon" href="assets/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    #fc {
        background: linear-gradient(135deg, #f3f9f8, #d6f0ed);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .appointment-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-top: 40px;
    }

    .form-title img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .form-title h2 {
        font-size: 1.8rem;
    }

    .btn-primary {
        background-color: #198754;
        border-color: #198754;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background-color: #146c43;
        border-color: #146c43;
    }

    #preview {
        max-height: 150px;
        display: none;
        border-radius: 8px;
        margin-top: 10px;
    }
    </style>
</head>

<body>
    <!-- Header section start -->
    <header id="header" class="img-fluid">
        <!-- nav 1 section start -->
        <div class="container-fluid bg-transparent py-2">
            <div class="row align-items-center text-center text-md-start gy-3">
                <!-- Call Us -->
                <div class="col-12 col-md-3">
                    <a href="tel:+8801753594577" target="_blank"
                        class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 text-decoration-none fw-bold text-warning">
                        <i class="fa fa-phone text-info"></i>
                        <span class="text-uppercase fw-semibold">Call Us</span>
                    </a>
                </div>
                <!-- Email Us -->
                <div class="col-12 col-md-3">
                    <a href="mailto:krittikaroy2020@gmail.com" target="_blank"
                        class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 text-decoration-none fw-bold text-warning">
                        <i class="fa fa-envelope text-info"></i>
                        <span class="text-uppercase fw-semibold">Email Us</span>
                    </a>
                </div>
                <!-- Login / Registration -->
                <div class="col-12 col-md-6 d-flex justify-content-center justify-content-md-end gap-4">
                    <a href="login.php" class="text-uppercase text-warning text-decoration-none fw-bold">Login</a>
                    <a href="register.php"
                        class="text-uppercase text-warning text-decoration-none fw-bold">Registration</a>
                </div>
            </div>
        </div>
        <!-- nav 1 section end -->
        <!-- nav section start -->
        <nav id="navbar" class="navbar navbar-expand-lg pt-3">
            <a class="navbar-brand ms-5" href="index.html">
                <img src="assets/img/logo_bg.png" class="w-35 d-block img-fluid" alt="ShasthoBondhu Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 px-3">
                    <li class="nav-item">
                        <a class="nav-link active fs-5" aria-current="page" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="#service">Service</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="#doctors">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="#department">Department</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="#blog">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="#contact">contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger fs-5" href="#fc">Appoinment</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- nav section end -->
        <section class="container">
            <!-- slider section start -->
            <div id="carouselIndicators" class="carousel slide text-center py-5">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0"
                        class="active"></button>
                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2"></button>
                </div>
                <div class="carousel-inner text-center text-light py-5 my-3">
                    <div class="carousel-item active py-lg-2">
                        <h2 class="display-5 fw-semibold "> Welcome to <i class="fa fa-stethoscope text-info gap-2"></i>
                            ShasthoBondhu</h2>
                        <h1 class="display-1 fw-semibold border border-3 d-inline-block py-3 px-3 text-warning">
                            We are here for your Care!</h1>
                        <p class="fw-semibold h4">Far far away, behind the word mountains, far from the countries
                            Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
                            <br><br>
                            <a class="btn btn-primary" href="#fc">Make an appoinment</a>
                        </p>
                    </div>
                    <div class="carousel-item  py-lg-2">
                        <h2 class="display-5 fw-semibold "> Welcome to <i class="fa fa-stethoscope text-info gap-2"></i>
                            ShasthoBondhu</h2>
                        <h1 class="display-1 fw-semibold border border-3 d-inline-block py-3 px-3 text-primary">
                            We are here for your Care!</h1>
                        <p class="fw-semibold h4">Far far away, behind the word mountains, far from the countries
                            Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
                            <br><br>
                            <a class="btn btn-primary" href="#fc">Make an appoinment</a>
                        </p>
                    </div>
                    <div class="carousel-item py-lg-2">
                        <h2 class="display-5 fw-semibold "> Welcome to <i class="fa fa-stethoscope text-info gap-2"></i>
                            ShasthoBondhu</h2>
                        <h1 class="display-1 fw-semibold border border-3 d-inline-block py-3 px-3 text-success">
                            We are here for your Care!</h1>
                        <p class="fw-semibold h4">Far far away, behind the word mountains, far from the countries
                            Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove.
                            <br><br>
                            <a class="btn btn-primary" href="#fc">Make an appoinment</a>
                        </p>

                    </div>
                </div>
            </div>
            <!-- slider section end -->
        </section>
    </header>
    <!-- header section end -->
    <!-- about section start -->
    <section id="about" class="py-5 bg-light">
        <section class="container">
            <div class="row gy-4 align-items-center">
                <!-- Image Column -->
                <div class="col-lg-6 col-12 order-1 order-lg-1 text-center">
                    <img src="assets/img/about-374.jpg" alt="About Image" class="img-fluid w-75">
                </div>

                <!-- Text Content Column -->
                <div class="col-lg-6 col-12 order-2 order-lg-2">
                    <!-- <h1 class="text-warning  text-uppercase text-center"><u>About Us</u></h1> -->
                    <div class="px-3 px-lg-5">
                        <h1 class="text-primary mb-3">We Are ShasthoBondhu like A Medical Clinic.</h1>
                        <p class="mb-4">
                            Some quick example text to build on the card title and make up the bulk of the card’s
                            content.
                        </p>
                        <a href="#fc" class="btn btn-outline-success me-2">Make an Appointment</a>
                        <a href="#" class="btn btn-outline-danger">Contact Us</a>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <!-- about section end -->
    <!-- Service Section Start -->
    <section id="service" class="py-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-5 col-sm-12">
                    <h1 class="text-warning text-uppercase text-center mb-5 py-3"><u>Our Services</u></h1>
                    <div class="row g-4 pt-3">
                        <div class="col-md-6 text-center">
                            <i class="fa fa-truck-medical fa-5x mb-3 text-info"></i>
                            <h4 class="h2 text-primary">Emergency Services</h4>
                            <p class="fw-lighter">Emergency care at your service 24/7.</p>
                        </div>
                        <div class="col-md-6 text-center">
                            <i class="fa fa-user-doctor fa-5x mb-3 text-info"></i>
                            <h4 class="h2 text-primary">Qualified Doctors</h4>
                            <p class="fw-lighter">Highly skilled and certified professionals.</p>
                        </div>
                        <div class="col-md-6 text-center">
                            <i class="fa fa-stethoscope fa-5x mb-3 text-info"></i>
                            <h4 class="h2 text-primary">Advanced Equipment</h4>
                            <p class="fw-lighter">State-of-the-art diagnostic and surgical tools.</p>
                        </div>
                        <div class="col-md-6 text-center">
                            <i class="fa fa-clock fa-5x mb-3 text-info"></i>
                            <h4 class="h2 text-primary">24/7 Availability</h4>
                            <p class="fw-lighter">Healthcare around the clock.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="appointment-card">
                        <div class="text-center mb-4 form-title">
                            <h2 class="text-success fw-bold mb-2 h1 font-times">
                                <img src="assets/img/logo_bg.png" alt="Logo" />
                                Make an Appointment
                            </h2>
                            <h5 class="text-info">Free Health Consultation</h5>
                        </div>
                        <form class="row g-3 needs-validation" novalidate action="submit_appointment.php" method="POST"
                            enctype="multipart/form-data">
                            <div class="col-md-6">
                                <label class="form-label">First Name *</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name *</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email (Gmail only) *</label>
                                <input type="email" name="email" class="form-control" required
                                    pattern="[a-z0-9._%+-]+@gmail\\.com$">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload Image *</label>
                                <input type="file" name="image" id="imageUpload" class="form-control" accept="image/*"
                                    required>
                                <img id="preview" class="img-thumbnail mt-2" style="display:none" alt="Preview">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City *</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">State *</label>
                                <select name="state" class="form-select" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option>Bangladesh</option>
                                    <option>USA</option>
                                    <option>UK</option>
                                    <option>India</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Zip *</label>
                                <input type="text" name="zip" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Select Department *</label>
                                <select name="department" id="departments" class="form-select" required>
                                    <option selected disabled value="">Choose Department...</option>
                                    <?php foreach ($departments as $dept => $docs): ?>
                                    <option value="<?= htmlspecialchars($dept) ?>"><?= htmlspecialchars($dept) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Select Doctor *</label>
                                <select name="doctor" id="doctor" class="form-select" required>
                                    <option selected disabled value="">Choose Doctor...</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Select Service *</label>
                                <select name="service" class="form-select" required>
                                    <option selected disabled value="">Choose service...</option>
                                    <?php foreach ($services as $srv): ?>
                                    <option value="<?= htmlspecialchars($srv) ?>"><?= htmlspecialchars($srv) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date & Time *</label>
                                <input type="datetime-local" name="appointment_datetime" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="terms" required>
                                    <label class="form-check-label">Agree to terms and conditions *</label>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-primary" type="submit">Make Appointment</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Service Section End -->

    <!-- search section start -->
    <section id="search" class="py-5 bg-light img-fluid">
        <section class="container">
            <div class="row gy-4 align-items-center">
                <!-- Text Content Column -->
                <div class="col-lg-12 col-12 order-2 order-lg-2 p-5 mx-auto">
                    <!-- <h1 class="text-warning  text-uppercase text-center"><u>About Us</u></h1> -->
                    <div class="px-3 px-lg-5">
                        <h1 class="text-primary mb-3">Your Health is Our Priority</h1>
                        <p class="mb-4 fw-lighter text-light">
                            We can manage your dream building A small river named Duden flows by their place.
                        </p>
                        <!-- <h2>Search Doctors or Departments</h2> -->
                        <div class="col-6 rou">
                            <form id="searchForm" class="mb-3">
                                <input type="text" id="searchQuery" class="form-control"
                                    placeholder="Search Doctor name & department">
                            </form>
                            <div id="results"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <!-- search section end -->
    <!-- doctors section start -->
    <section id="doctors" class="py-3 py-lg-5 ">
        <section class="container py-3">
            <div class="row gy-4 align-items-center">
                <div class="col-12 text-center">
                    <h2 class="h1 text-uppercase playfair-display color-primary fw-bold text-warning mb-4"><u>Our
                            Qualified Doctors</u></h2>
                    <p class="fw-lighter mb-3">Separated they live in. A small river named Duden flows by their place
                        and supplies it with the necessary regelialia. It is a paradisematic country</p>
                </div>
                <!-- title end -->
                <div class="col-12 col-sm-6 col-lg-3 p-2 bg-warning shadow">
                    <div class="card  shadow">
                        <img src="assets/img/doc-1-463.jpg" class="card-img-top d-block w-100" alt="Dr. Lloyd Wilson"
                            title="Dr. Lloyd Wilson">
                        <div class="card-body text-center">
                            <h5 class="card-title">Dr. Lloyd Wilson</h5>
                            <h6 class="text-primary text-uppercase">Neurologist</h6>
                            <p class="card-text fw-lighter">I am an ambitious workaholic, but apart from that, pretty
                                simple person.</p>
                            <a href="#" class="btn btn-outline-primary">Book now</a>
                        </div>
                    </div>
                </div>
                <!-- doctor member 1 -->
                <div class="col-12 col-sm-6 col-lg-3 p-3 bg-info shadow">
                    <div class="card shadow">
                        <img src="assets/img/doc-2-107.jpg" class="card-img-top d-block w-100" alt="Dr. Rachel Parker"
                            title="Dr. Rachel Parker">
                        <div class="card-body text-center">
                            <h5 class="card-title h4">Dr. Rachel Parker</h5>
                            <h6 class="text-primary text-uppercase">Ophthalmologist</h6>
                            <p class="card-text fw-lighter">I am an ambitious workaholic, but apart from that, pretty
                                simple person.</p>
                            <a href="#" class="btn btn-outline-primary">Book now</a>
                        </div>
                    </div>
                </div>
                <!-- doctor member 2 -->
                <div class="col-12 col-sm-6 col-lg-3 p-3 bg-warning shadow">
                    <div class="card shadow">
                        <img src="assets/img/doc-3-29.jpg" class="card-img-top d-block w-100" alt="Dr. Ian Smith"
                            title="Dr. Ian Smith">
                        <div class="card-body text-center">
                            <h5 class="card-title h4">Dr. Ian Smith</h5>
                            <h6 class="text-primary text-uppercase">Dentist</h6>
                            <p class="card-text fw-lighter">I am an ambitious workaholic, but apart from that, pretty
                                simple person.</p>
                            <a href="#" class="btn btn-outline-primary">Book now</a>
                        </div>
                    </div>
                </div>
                <!-- doctor member 3 -->
                <div class="col-12 col-sm-6 col-lg-3 p-3 bg-info shadow">
                    <div class="card shadow">
                        <img src="assets/img/doc-4-439.jpg" class="card-img-top d-block w-100"
                            alt="Dr. Alicia Henderson" title="Dr. Alicia Henderson">
                        <div class="card-body text-center">
                            <h6 class="card-title h4">Dr. Alicia Henderson</h6>
                            <h6 class="text-primary text-uppercase">Pediatrician</h6>
                            <p class="card-text fw-lighter">I am an ambitious workaholic, but apart from that, pretty
                                simple person.</p>
                            <a href="#" class="btn btn-outline-primary">Book now</a>
                        </div>
                    </div>
                </div>
                <!-- doctor member 4 -->
            </div>
        </section>
    </section>
    <!-- doctors section end -->
    <!-- department section start -->
    <section class="py-5 bg-light" id="department">
        <div class="container">
            <!-- Section Heading -->
            <h1 class="text-warning text-uppercase text-center py-3 mb-4">
                <u>Our Departments</u>
            </h1>
            <!-- Departments Grid -->
            <div class="row g-4">
                <!-- Repeat this column structure for each department -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="department-wrap p-4 card text-center h-100">
                        <div class="icon mb-3">
                            <i class="fa fa-stethoscope text-info fa-3x"></i>
                        </div>
                        <h3><a href="#" class="text-decoration-none h4 text-uppercase text-primary">Neurology</a></h3>
                        <p>Specialized care for nervous system disorders.</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="department-wrap p-4 card text-center h-100">
                        <div class="icon mb-3">
                            <i class="fa fa-stethoscope text-info fa-3x"></i>
                        </div>
                        <h3><a href="#" class="text-decoration-none h4 text-uppercase text-primary">Surgical</a></h3>
                        <p>Advanced surgical treatments and care.</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="department-wrap p-4 card text-center h-100">
                        <div class="icon mb-3">
                            <i class="fa fa-stethoscope text-info fa-3x"></i>
                        </div>
                        <h3><a href="#" class="text-decoration-none h4 text-uppercase text-primary">Dental</a></h3>
                        <p>Comprehensive dental health solutions.</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="department-wrap p-4 card text-center h-100">
                        <div class="icon mb-3">
                            <i class="fa fa-stethoscope text-info fa-3x"></i>
                        </div>
                        <h3><a href="#" class="text-decoration-none h4 text-uppercase text-primary">Ophthalmology</a>
                        </h3>
                        <p>Expert eye and vision care services.</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="department-wrap p-4 card text-center h-100">
                        <div class="icon mb-3">
                            <i class="fa fa-stethoscope text-info fa-3x"></i>
                        </div>
                        <h3><a href="#" class="text-decoration-none h4 text-uppercase text-primary">Cardiology</a></h3>
                        <p>Heart care from diagnostics to surgery.</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="department-wrap p-4 card text-center h-100">
                        <div class="icon mb-3">
                            <i class="fa fa-stethoscope text-info fa-3x"></i>
                        </div>
                        <h3><a href="#" class="text-decoration-none h4 text-uppercase text-primary">Traumatology</a>
                        </h3>
                        <p>Emergency and trauma treatment center.</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="department-wrap p-4 card text-center h-100">
                        <div class="icon mb-3">
                            <i class="fa fa-stethoscope text-info fa-3x"></i>
                        </div>
                        <h3><a href="#" class="text-decoration-none h4 text-uppercase text-primary">Nuclear Magnetic</a>
                        </h3>
                        <p>Advanced MRI scanning and analysis.</p>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="department-wrap p-4 card text-center h-100">
                        <div class="icon mb-3">
                            <i class="fa fa-stethoscope text-info fa-3x"></i>
                        </div>
                        <h3><a href="#" class="text-decoration-none h4 text-uppercase text-primary">X-Ray</a></h3>
                        <p>Digital radiology and imaging services.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- department section end -->
    <!-- contact section start -->
    <section id="contact" class="py-5 bg-light">
        <section class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-12 text-center">
                    <h2 class="h1 text-uppercase playfair-display color-primary fw-bold text-warning mb-4"><u>Contact
                            Us</u></h2>
                    <p class="fw-lighter mb-3">Separated they live in. A small river named Duden flows by their place
                        and supplies it with the necessary regelialia. It is a paradisematic country</p>
                </div>
                <!-- Image Column -->
                <div class="col-lg-6 col-12 order-1 order-lg-1 text-center">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.241904909697!2d90.39106047516324!3d23.73875157867839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8c001d799a3%3A0x1fc742cf3feaf104!2sPG%20Hospital%2C%20Shahbagh%20Rd%2C%20Dhaka%201000!5e0!3m2!1sen!2sbd!4v1749399211449!5m2!1sen!2sbd"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

                <!-- Text Content Column -->
                <div class="col-lg-6 col-12 order-2 order-lg-2 card shadow p-4">
                    <h2 class="h5 playfair-display text-primary fw-bold text-center text-uppercase fs-5 mb-4">
                        Send your valuable message to us.
                    </h2>
                    <form class="row g-3 needs-validation" action="submit_message.php" method="POST" novalidate>
                        <!-- Full Name -->
                        <div class="col-md-12">
                            <label for="fullName" class="form-label fw-bold">Full name:</label>
                            <input type="text" class="form-control" id="fullName" name="full_name"
                                placeholder="Enter your Full name" required>
                            <div class="invalid-feedback">Please enter your full name.</div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-12">
                            <label for="email" class="form-label fw-bold">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="example@gmail.com" pattern="^[\w\.-]+@gmail\.com$" required>
                            <div class="invalid-feedback">Please enter a valid Gmail address.</div>
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label for="address" class="form-label fw-bold">Address:</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="1234 Main St" required>
                            <div class="invalid-feedback">Please enter your address.</div>
                        </div>

                        <!-- Comment -->
                        <div class="col-12">
                            <label for="comment" class="form-label fw-bold">Comment:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"
                                placeholder="Describe our service..." required></textarea>
                            <div class="invalid-feedback">Please write your message.</div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 d-grid gap-2 col-6 mx-auto">
                            <button class="btn btn-outline-danger" type="submit">Send message</button>
                        </div>
                    </form>
                </div>

            </div>
            </div>
        </section>
    </section>
    <!-- contact section end -->
    <!-- blog section start -->
    <section id="blog" class="py-4 py-lg-5 bg-light">
        <section class="container">
            <div class="row gy-4 align-items-center py-3">
                <div class="col-12">
                    <div class="col-12 text-center">
                        <h2 class="h1 text-uppercase playfair-display color-primary fw-bold text-warning mb-4"><u>Gets
                                Every Single Updates Here</u></h2>
                        <p class="fw-lighter mb-3">Far far away, behind the word mountains, far from the countries
                            Vokalia and Consonantia</p>
                    </div>
                </div>
                <div class="album col-sm-12 col-lg-4">
                    <div class="card bg-light shadow">
                        <img src="assets/img/image_2-434.jpg" alt="Our new hit" title="Our new hit"
                            class="w-100 d-block">
                        <div class="card-body text-center">
                            <a href="#" class="text-decoration-none text-warning"><i
                                    class="fas fa-clock text-info"></i><time datetime="2024-10-29"> October 29,
                                    2025</time></a>
                            <h5 class="h3 card-title text-bold text-primary">Scary Thing That You Don’t Get Enough Sleep
                            </h5>
                            <p class="card-text fw-lighter">Far far away, behind the word mountains, far from the
                                countries Vokalia and Consonantia, there live the blind texts.</p>
                            <a href="#" class="btn btn-outline-primary">Book now</a>
                        </div>
                    </div>
                </div>
                <!-- blog item 1 -->
                <div class="album col-sm-6 col-lg-4">
                    <div class="card bg-light shadow">
                        <img src="assets/img/image_3-459.jpg" alt="recieved the best music award"
                            title="recieved the best music award" class="w-100 d-block">
                        <div class="card-body text-center">
                            <a href="#" class="text-decoration-none text-warning"><i
                                    class="fas fa-clock text-info"></i><time datetime="2024-10-29"> October 29,
                                    2025</time></a>
                            <h5 class="h3 card-title text-bold text-primary">Scary Thing That You Don’t Get Enough Sleep
                            </h5>
                            <p class="card-text fw-lighter">Far far away, behind the word mountains, far from the
                                countries Vokalia and Consonantia, there live the blind texts.</p>
                            <a href="#" class="btn btn-outline-primary">Book now</a>
                        </div>
                    </div>
                </div>
                <!-- blog item 2 -->
                <div class=" album col-sm-6 col-lg-4">
                    <div class="card bg-light shadow">
                        <img src="assets/img/image_4-406.jpg" alt="Listen latest album released today"
                            title="Listen latest album released today" class="w-100 d-block">
                        <div class="card-body text-center">
                            <a href="#" class="text-decoration-none text-warning"><i
                                    class="fas fa-clock text-info"></i><time datetime="2024-10-29"> October 29,
                                    2025</time></a>
                            <h5 class="h3 card-title text-bold text-primary">Scary Thing That You Don’t Get Enough Sleep
                            </h5>
                            <p class="card-text fw-lighter">Far far away, behind the word mountains, far from the
                                countries Vokalia and Consonantia, there live the blind texts.</p>
                            <a href="#" class="btn btn-outline-primary">Book now</a>
                        </div>
                    </div>
                </div>
                <!-- blog item 3 -->
            </div>
        </section>
    </section>
    <!-- blog section end -->
    <!-- customer feedback section start -->
    <section id="cf" class="py-4 py-lg-5 bg-body-secondary ">
        <section class="container">
            <div class="row gy-4">
                <div class="col-12  ">
                    <div class="title-block text-center">
                        <h2 class="h1 text-uppercase playfair-display color-primary fw-bold text-warning mb-4">
                            <u>Customer Feedback</u>
                        </h2>
                    </div>
                </div>
                <!--title end-->
                <div class="col-sm-6  col-lg-4">
                    <div class="card border-light bg-light text-center">
                        <i class="fa fa-quote-left fa-3x card-img-top rounded-circle"></i>
                        <div class="card-body blockquote">
                            <p class="card-text ">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
                                bibendum enim eu nibh finibus</p>
                            <footer class="blockquote-footer"><cite title="Source Title">Mohamed Nady</cite></footer>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4">
                    <div class="card border-light bg-light text-center">
                        <i class="fa fa-quote-left fa-3x card-img-top rounded-circle" aria-hidden="true"></i>
                        <div class="card-body blockquote">
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
                                bibendum enim eu nibh finibus</p>
                            <footer class="blockquote-footer"><cite title="Source Title">Mohamed Reda</cite></footer>
                        </div>
                    </div>
                </div>

                <div class=" col-sm-12 col-lg-4">
                    <div class="card border-light bg-light text-center">
                        <i class="fa fa-quote-left fa-3x card-img-top rounded-circle" aria-hidden="true"></i>
                        <div class="card-body blockquote">
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer
                                bibendum enim eu nibh finibus</p>
                            <footer class="blockquote-footer"><cite title="Source Title">Mohamed Atef</cite></footer>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </section>
    <!-- customer feedback section end -->
    <!-- gallery section start -->
    <section id="gallery" class="py-4 py-lg-5 bg-light">
        <section class="container ">
            <div class="row gy-4 align-items-center">
                <div class="col-12 ">
                    <div class="title-block text-center">
                        <h2 class="h1 text-uppercase playfair-display color-primary fw-bold text-warning mb-4"><u>Our
                                Gallery</u></h2>
                    </div>
                </div>
                <!--title end-->
                <div class="col-6 col-lg-4">
                    <div class="gallery-poster">
                        <img src="assets/img/image_2-434.jpg" alt="music gallery" title="music gallery"
                            class="d-block w-100  rounded-3">
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="gallery-poster">
                        <img src="assets/img/image_3-459.jpg" alt="music gallery" title="music gallery"
                            class="d-block w-100  rounded-3">
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="gallery-poster">
                        <img src="assets/img/image_4-406.jpg" alt="music gallery" title="music gallery"
                            class="d-block w-100  rounded-3">
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="gallery-poster">
                        <img src="assets/img/image_6-997.jpg" alt="music gallery" title="music gallery"
                            class="d-block w-100  rounded-3">
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="gallery-poster">
                        <img src="assets/img/image_6-161.jpg" alt="music gallery" title="music gallery"
                            class="d-block w-100  rounded-3">
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="gallery-poster">
                        <img src="assets/img/image_5-472.jpg" alt="music gallery" title="music gallery"
                            class="d-block w-100  rounded-3">
                    </div>
                </div>

            </div>
        </section>
    </section>
    <!-- gallery section end -->
    <!-- footer section start -->
    <footer id="footer" class="py-4">
        <section class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-content text-center text-success">
                        <p class="lead m-0">Krittika Roy 2025 &copy Copyright</p>
                        <p class="lead m-0" id="datetime"></p>
                    </div>
                </div>
            </div>
        </section>
    </footer>
    <!-- footer section end -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <!-- default js -->
    <script src="assets/js/script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.getElementById("imageUpload").addEventListener("change", function() {
        const file = this.files[0];
        const preview = document.getElementById("preview");
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        } else {
            preview.src = "";
            preview.style.display = "none";
        }
    });
    const departments = <?= json_encode($departments, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    const departmentSelect = document.getElementById("departments");
    const doctorSelect = document.getElementById("doctor");
    departmentSelect.addEventListener("change", function() {
        const selectedDept = this.value;
        doctorSelect.innerHTML = '<option selected disabled value="">Choose Doctor...</option>';
        if (selectedDept && departments[selectedDept]) {
            departments[selectedDept].forEach(function(doctor) {
                const option = document.createElement("option");
                option.value = doctor;
                option.textContent = doctor;
                doctorSelect.appendChild(option);
            });
            doctorSelect.disabled = false;
        } else {
            doctorSelect.disabled = true;
        }
    });
    doctorSelect.disabled = true;
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                const emailInput = form.querySelector('input[name="email"]');
                const gmailPattern = /^[a-z0-9._%+-]+@gmail\.com$/i;
                if (!gmailPattern.test(emailInput.value)) {
                    emailInput.classList.add('is-invalid');
                    event.preventDefault();
                    event.stopPropagation();
                    return;
                } else {
                    emailInput.classList.remove('is-invalid');
                }
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
    </script>
</body>

</html>