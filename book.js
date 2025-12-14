// Slideshow js

let slideIndex = 0;
showSlides(slideIndex);

showSlides();

function showSlides() {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
  slides[slideIndex-1].style.display = "block";
  setTimeout(showSlides, 1000);
}

// Generate date and time for booking

document.addEventListener('DOMContentLoaded', () => {
  const dt = document.getElementById('date-time');
  if (!dt) return;

  // Helper to zero-pad
  const pad = n => String(n).padStart(2, '0');

  // Format a Date as "YYYY-MM-DDTHH:MM" (local)
  function toDateTimeLocalValue(d) {
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
  }

  // Build tomorrow at 10:00 local time and set as value/min (so picker starts aligned)
  const now = new Date();
  const tomorrowStart = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0, 0, 0);
  const tomorrowAt10 = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 10, 0, 0, 0);

  dt.step = 1800;                // 30 minutes in seconds (tells the browser to present 30-minute steps)
  dt.min = toDateTimeLocalValue(tomorrowStart); // optional: restrict selection to tomorrow onward
  dt.value = toDateTimeLocalValue(tomorrowAt10); // set initial value to tomorrow 10:00

  // Validation: allow only minutes 00 or 30 (no snapping, only reject invalid on form submit)
  function isValid30MinuteBoundary(value) {
    if (!value) return false;
    const [datePart, timePart] = value.split('T');
    if (!datePart || !timePart) return false;
    const minutes = Number(timePart.split(':')[1] ?? -1);
    return minutes === 0 || minutes === 30;
  }

  // Show a helpful message and prevent form submission if invalid
  const invalidMessage = 'Please choose a time on a 30‑minute boundary (minutes must be :00 or :30).';

  // Validate on input (so the browser can show built-in UI) and on form submit
  dt.addEventListener('input', () => {
    if (!dt.value) {
      dt.setCustomValidity('');
      return;
    }
    dt.setCustomValidity(isValid30MinuteBoundary(dt.value) ? '' : invalidMessage);
  });

  // If this input is inside a form, also validate on form submit to block submission
  const form = dt.form;
  if (form) {
    form.addEventListener('submit', (e) => {
      if (!isValid30MinuteBoundary(dt.value)) {
        // prevent submission and show message
        dt.reportValidity(); // shows the custom validity message
        e.preventDefault();
      }
    });
  }
});

// Live update receipt (struggled to get it to work using JS, commenting it out until next report)
  // const STARTING = 15.0;
  // const selectCats = $('#cats');
  // const subtotalEl = $('#subtotal');
  // const multipliedEl = $('#multiply-math');
  // const startingEl = $('#starting');
  // const finalEl = $('#final');
  // const itemsList = $('#items-list');
  // const bookingForm = document.querySelector('form.auth-form');
  // const currentDateEl = document.querySelector('.current-date');
  // const checkedCat = form.querySelector('option[value="1"]:checked');
 
  // function calculateReceipt() {
    //const selected = Array.from(selectCats.selectedOptions);
    // }

   // const multiplied = subtotal * 5;
    // const finalTotal = STARTING + multiplied;

    // Update UI
   // subtotalEl.textContent = fmt(subtotal);
   // multipliedEl.textContent = fmt(multiplied);
    // finalEl.textContent = fmt(finalTotal);


