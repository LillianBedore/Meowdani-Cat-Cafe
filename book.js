/* Cat Slideshow*/
let slideIndex = 0;

function showSlides() {
    const slides = document.getElementsByClassName("mySlides");

    // Hide all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    slides[slideIndex - 1].style.display = "inline";

    setTimeout(showSlides, 1500); // change speed here
}

// Start slideshow once page loads
document.addEventListener("DOMContentLoaded", showSlides);


/* date/time booking slots */
const select = document.getElementById("date-time");

const now = new Date();
const start = new Date(
    now.getFullYear(),
    now.getMonth(),
    now.getDate() + 1,
    10,
    0
);

function pad(n) {
    return n.toString().padStart(2, "0");
}

function formatValue(d) {
    return (
        d.getFullYear() + "-" +
        pad(d.getMonth() + 1) + "-" +
        pad(d.getDate()) + " " +
        pad(d.getHours()) + ":" +
        pad(d.getMinutes())
    );
}

function formatLabel(d) {
    return d.toLocaleString();
}

for (let i = 0; i < 16; i++) {
    const d = new Date(start.getTime() + i * 30 * 60000);

    const opt = document.createElement("option");
    opt.value = formatValue(d);   
    opt.textContent = formatLabel(d); 

    select.appendChild(opt);
}


/* Math/Calculating Pricing */
const BASE = 15;
const CAT_PRICE = 5;
const FEE = 2.5;

const checkboxes = document.querySelectorAll('input[name="cats[]"]');
const totalDisplay = document.getElementById("totalDisplay");
const totalInput = document.getElementById("totalInput");

//force price to reset to 0.00 when page loads
checkboxes.forEach(cb => cb.checked = false);
totalDisplay.textContent = "0.00";
totalInput.value = "0.00";

function updateTotal() {
    let count = document.querySelectorAll('input[name="cats[]"]:checked').length;

    let total = 0;
    if (count > 0) {
        total = BASE + (count * CAT_PRICE) + FEE;
    }

    totalDisplay.textContent = total.toFixed(2);
    totalInput.value = total.toFixed(2);
}

checkboxes.forEach(cb => cb.addEventListener("change", updateTotal));


/* Prevent form submission if total is $0.00 */
const form = document.querySelector("form");

form.addEventListener("submit", function (e) {
    if (parseFloat(totalInput.value) === 0) {
        e.preventDefault();
        alert("Please select at least one cat before booking.");
    }
});
