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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Appointment - ShasthoBondhu</title>
    <link rel="icon" href="assets/img/logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style.css">
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
                    <img src="assets/img/logo_bg.png" alt="Logo" /> Make an Appointment
                </h2>
                <h5 class="text-info">Free Health Consultation</h5>
            </div>
            <form class="row g-3 needs-validation" novalidate action="submit_appointment_u.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email (Gmail only) *</label>
                    <input type="email" name="email" class="form-control" required pattern="[a-z0-9._%+-]+@gmail\\.com$" />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Upload Image *</label>
                    <input type="file" name="image" id="imageUpload" class="form-control" accept="image/*" required />
                    <img id="preview" class="img-thumbnail" alt="Preview" />
                </div>
                <div class="col-12">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" />
                </div>
                <div class="col-md-6">
                    <label class="form-label">City *</label>
                    <input type="text" name="city" class="form-control" required />
                </div>
                <div class="col-md-3">
                    <label class="form-label">State *</label>
                    <select name="state" class="form-select" required>
                        <option selected disabled value="">Choose...</option>
                        <option>Bangladesh</option>
                        <option>USA</option>
                        <option>UK</option>
                        <option>India</option>
                        <option>Pakistan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Zip *</label>
                    <input type="text" name="zip" class="form-control" required />
                </div>
                <div class="col-md-6">
                    <label class="form-label">Select Department *</label>
                    <select name="department" id="departments" class="form-select" required>
                        <option selected disabled value="">Choose Department...</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= htmlspecialchars($dept) ?>"><?= htmlspecialchars($dept) ?></option>
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
                    <select name="service" id="service" class="form-select" required>
                        <option selected disabled value="">Choose Service...</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date & Time *</label>
                    <input type="datetime-local" name="appointment_datetime" class="form-control" required />
                </div>
                <div class="col-12">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="3"></textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="terms" required />
                        <label class="form-check-label">Agree to terms and conditions *</label>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button class="btn btn-primary" type="submit">Make Appointment</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const hospitalData = <?= json_encode($hospital_data) ?>;
        const departmentSelect = document.getElementById("departments");
        const doctorSelect = document.getElementById("doctor");
        const serviceSelect = document.getElementById("service");

        function updateDropdown(selectElement, items, placeholder) {
            selectElement.innerHTML = `<option selected disabled value="">${placeholder}</option>`;
            items.forEach(item => {
                const option = document.createElement("option");
                option.value = item;
                option.textContent = item;
                selectElement.appendChild(option);
            });
            selectElement.disabled = false;
        }

        departmentSelect.addEventListener("change", function () {
            const dept = this.value;
            if (dept && hospitalData[dept]) {
                updateDropdown(doctorSelect, hospitalData[dept].doctors, "Choose Doctor...");
                updateDropdown(serviceSelect, hospitalData[dept].services, "Choose Service...");
            } else {
                doctorSelect.innerHTML = '<option selected disabled value="">Choose Doctor...</option>';
                doctorSelect.disabled = true;
                serviceSelect.innerHTML = '<option selected disabled value="">Choose Service...</option>';
                serviceSelect.disabled = true;
            }
        });

        doctorSelect.disabled = true;
        serviceSelect.disabled = true;

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
    </script>
</body>

</html>
