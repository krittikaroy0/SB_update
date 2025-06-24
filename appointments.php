<?php
// appointment.php
require_once "session.php";

// Sample data for departments and doctors (replace with DB queries if needed)
$departments = [
    "Cardiology" => ["Dr. Arif Rahman", "Dr. Maya Das"],
    "Neurology" => ["Dr. Hossain Kabir"],
    "Pediatrics" => ["Dr. Rita Sultana", "Dr. Noman Akter"],
    "Orthopedics" => ["Dr. Amina Karim", "Dr. Jamal Uddin"],
    "Gynecology & Obstetrics" => ["Dr. Shabnam Noor"],
    "Dermatology" => ["Dr. Fahim Rahman"],
    // Add more if needed
];

// Flatten services from departments for service dropdown (or define separately if different)
$services = [
    "Neurology",
    "Orthopedics",
    "Cardiology",
    "Pediatrics",
    "Gynecology & Obstetrics",
    "Dermatology",
    "Gastroenterology",
    "Pulmonology",
    "Oncology",
    "Urology",
    "Nephrology",
    "Ophthalmology"
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Appointment - ShasthoBondhu</title>
    <link rel="icon" href="assets/img/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
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

        .form-section label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #198754;
            border-color: #198754;
            transition: background-color 0.3s ease;
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

    <div class="container">
        <div class="col-lg-8 col-md-10 mx-auto appointment-card">
            <div class="text-center mb-4 form-title">
                <h2 class="text-success fw-bold mb-2 h1 font-times">
                    <img src="assets/img/logo_bg.png" alt="Logo" class="w-15 d-inline-block" />
                    Make an Appointment
                </h2>
                <h5 class="text-info">Free Health Consultation</h5>
            </div>

            <form class="row g-3 needs-validation form-section" novalidate
                action="submit_appointment_u.php" method="POST" enctype="multipart/form-data">

                <div class="col-md-6">
                    <label for="firstName" class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control" id="firstName" placeholder="Enter your first name" required />
                    <div class="invalid-feedback">Please enter your first name.</div>
                </div>

                <div class="col-md-6">
                    <label for="lastName" class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" id="lastName" placeholder="Enter your last name" required />
                    <div class="invalid-feedback">Please enter your last name.</div>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email (Gmail only) *</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com" required pattern="[a-z0-9._%+-]+@gmail\.com$" />
                    <div class="invalid-feedback">Please enter a valid Gmail address.</div>
                </div>

                <div class="col-md-6">
                    <label for="imageUpload" class="form-label">Upload Image *</label>
                    <input type="file" name="image" class="form-control" id="imageUpload" accept="image/*" required />
                    <img id="preview" class="img-thumbnail" alt="Preview" />
                    <div class="invalid-feedback">Please upload an image.</div>
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St" />
                </div>

                <div class="col-md-6">
                    <label for="city" class="form-label">City *</label>
                    <input type="text" name="city" class="form-control" id="city" required />
                    <div class="invalid-feedback">Please provide a valid city.</div>
                </div>

                <div class="col-md-3">
                    <label for="state" class="form-label">State *</label>
                    <select name="state" class="form-select" id="state" required>
                        <option selected disabled value="">Choose...</option>
                        <option>Bangladesh</option>
                        <option>USA</option>
                        <option>UK</option>
                        <option>India</option>
                        <option>Pakistan</option>
                    </select>
                    <div class="invalid-feedback">Please select a valid state.</div>
                </div>

                <div class="col-md-3">
                    <label for="zip" class="form-label">Zip *</label>
                    <input type="text" name="zip" class="form-control" id="zip" required />
                    <div class="invalid-feedback">Please provide a valid zip.</div>
                </div>

                <div class="col-md-6">
                    <label for="department" class="form-label">Select Department *</label>
                    <select name="department" id="department" class="form-select" required>
                        <option selected disabled value="">Choose Department...</option>
                        <?php foreach ($departments as $dept => $doctors): ?>
                            <option value="<?= htmlspecialchars($dept) ?>"><?= htmlspecialchars($dept) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a department.</div>
                </div>

                <div class="col-md-6">
                    <label for="doctor" class="form-label">Select Doctor *</label>
                    <select name="doctor" id="doctor" class="form-select" required>
                        <option selected disabled value="">Choose Doctor...</option>
                        <!-- Populated dynamically via JS -->
                    </select>
                    <div class="invalid-feedback">Please select a doctor.</div>
                </div>

                <div class="col-md-6">
                    <label for="service" class="form-label">Select Service *</label>
                    <select name="service" id="service" class="form-select" required>
                        <option selected disabled value="">Choose service...</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= htmlspecialchars($service) ?>"><?= htmlspecialchars($service) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a service.</div>
                </div>

                <div class="col-md-6">
                    <label for="appointment_datetime" class="form-label">Date & Time *</label>
                    <input type="datetime-local" name="appointment_datetime" id="appointment_datetime" class="form-control" required />
                    <div class="invalid-feedback">Please choose date and time.</div>
                </div>

                <div class="col-12">
                    <label for="message" class="form-label">Message</label>
                    <textarea name="message" id="message" class="form-control" rows="3" placeholder="Describe your problem..."></textarea>
                </div>

                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required />
                        <label class="form-check-label" for="terms">Agree to terms and conditions *</label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                    </div>
                </div>

                <div class="col-12 d-grid gap-2 col-sm-6 mx-auto mt-3">
                    <button class="btn btn-primary" type="submit">Make Appointment</button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Image preview on file select
        document.getElementById("imageUpload").addEventListener("change", function () {
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

        // Populate doctors dropdown based on department selection
        const departments = <?= json_encode($departments, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
        const departmentSelect = document.getElementById("department");
        const doctorSelect = document.getElementById("doctor");

        departmentSelect.addEventListener("change", function () {
            const selectedDept = this.value;
            doctorSelect.innerHTML = '<option selected disabled value="">Choose Doctor...</option>';
            if (selectedDept && departments[selectedDept]) {
                departments[selectedDept].forEach(function (doctor) {
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

        // Disable doctor dropdown initially
        doctorSelect.disabled = true;

        // Bootstrap form validation
        (() => {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    // Gmail validation
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
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>

</body>

</html>
