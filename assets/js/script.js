// navbar scroll background change code start
const navbar = document.querySelector('#navbar');
window.onscroll = () => {
    if (window.scrollY > 100) {
        navbar.classList.add('nav-active');
    } else {
        navbar.classList.remove('nav-active');
    }
};
// navbar scroll background change code end

// function updateDateTime() {
//     const now = new Date();
//     const formatted = now.toLocaleString(); // e.g., "6/23/2025, 3:45:12 PM"
//     document.getElementById("datetime").textContent = formatted;
// }

// // Call once when page loads
// updateDateTime();

// // Optionally update every second
// setInterval(updateDateTime, 1000);



document.getElementById("emailForm").addEventListener("submit", function (e) {
    const emailInput = document.getElementById("inputEmail4").value.trim();
    const errorMsg = document.getElementById("errorMsg");
    const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

    if (!gmailRegex.test(emailInput)) {
        e.preventDefault();
        errorMsg.style.display = "block";
    } else {
        errorMsg.style.display = "none";
    }
});
// search code
const form = document.getElementById('searchForm');
form.addEventListener('submit', function (e) {
    e.preventDefault();
    const query = document.getElementById('searchQuery').value;

    fetch('search.php?q=' + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            document.getElementById('results').innerHTML = data;
        });
});


// Check URL params
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('error') === 'upload_image') {
    const alertDiv = document.createElement('div');
    alertDiv.style.color = 'red';
    alertDiv.style.backgroundColor = '#ffe5e5';
    alertDiv.style.padding = '10px';
    alertDiv.style.marginBottom = '15px';
    alertDiv.style.border = '1px solid red';
    alertDiv.style.borderRadius = '4px';
    alertDiv.textContent = 'Please upload your image before submitting the form.';
    // Insert alert at top of form container (change '#fc' if needed)
    const formContainer = document.getElementById('fc');
    if (formContainer) {
        formContainer.insertBefore(alertDiv, formContainer.firstChild);
    }
}
// Remove error query param from URL without reloading
window.history.replaceState({}, document.title, window.location.pathname);
