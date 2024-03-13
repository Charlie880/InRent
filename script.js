//Change color on scroll
window.addEventListener('scroll', function () {
    var navbar = document.querySelector('.nav-container');
    // Change color based on scroll position
    if (window.scrollY > 500) { // Adjust the scroll threshold as needed
        navbar.style.backgroundColor = 'rgba(0, 0, 0, 0.3)'; // New background color when scrolled
    } else {
        navbar.style.backgroundColor = 'transparent'; // Initial background color when not scrolled
    }
});

const dropdown = document.querySelector('.drop-sign');
const sign = document.querySelector('.sign');
const dropdownContent = document.querySelector('.drop-form-sign');

// Toggle the dropdown content when the dropdown button is clicked
sign.addEventListener('click', function (event) {
    if (dropdownContent.style.display === 'block') {
        dropdownContent.style.display = 'none';
    } else {
        dropdownContent.style.display = 'block';
    }
});
// Close the dropdown if the user clicks outside of it
window.addEventListener('click', function (event) {
    if (!dropdown.contains(event.target) && !dropdownContent.contains(event.target)) {
        dropdownContent.style.display = 'none';
    }
});

const dropdown1 = document.querySelector('.drop-log');
const log = document.querySelector('.log');
const dropdownContent1 = document.querySelector('.drop-form-log');

// Toggle the dropdown content when the dropdown button is clicked
log.addEventListener('click', function (event) {
    if (dropdownContent1.style.display === 'block') {
        dropdownContent1.style.display = 'none';
    } else {
        dropdownContent1.style.display = 'block';
    }
});
// Close the dropdown if the user clicks outside of it
window.addEventListener('click', function (event) {
    if (!dropdown1.contains(event.target) && !dropdownContent1.contains(event.target)) {
        dropdownContent1.style.display = 'none';
    }
});

// Toggle the visibility of the navigation menu when the hamburger button is clicked
document.querySelector('.hamburger').addEventListener('click', function() {
    document.querySelector('.nav-container').classList.toggle('show');
});

function navigateToSection(sectionClass) {
    const section = document.getElementById(sectionClass);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
}

// Get all the quantity input fields
const quantityInputs = document.querySelectorAll('.quantity');

// Loop through each input field and attach the event listener
quantityInputs.forEach((input) => {
    input.addEventListener('input', () => {
        const card = input.closest('.grid-items'); // Find the parent card element
        const priceSpan = card.querySelector('.price'); // Find the price span within the same card

        const days = parseInt(input.value);
        if (!isNaN(days)) {
            const price = calculatePrice(days); // Function to calculate price based on days
            priceSpan.textContent = price;
        } else {
            priceSpan.textContent = '0'; // Reset price if input is invalid
        }
    });
});


// Function to calculate price based on days
function calculatePrice(days) {
    const pricePerDay = 1000;
    return days * pricePerDay;
}

//Button animation
const cardButtons = document.querySelectorAll('.card-btn');

cardButtons.forEach(button => {
    button.addEventListener('click', function () {
        button.classList.add('jump');

        // Remove the jump class after the animation finishes
        setTimeout(function () {
            button.classList.remove('jump');
        }, 500); // Adjust this time to match the animation duration
    });
});
