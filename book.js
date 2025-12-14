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

    // Helpers
    const pad = n => String(n).padStart(2, '0');
    const toValue = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    const toLabel = d => d.toLocaleString(); // human readable

    const select = document.getElementById('date-time');
    const preview = document.getElementById('preview');

    // Build tomorrow at 00:00 and add options every 30 minutes
    const now = new Date();
    const tomorrowStart = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0, 0, 0);
    const tomorrowAt10 = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 10, 0, 0, 0);

    for (let minutes = 0; minutes < 24 * 60; minutes += 30) {
      const d = new Date(tomorrowStart.getTime() + minutes * 60000);
      const opt = document.createElement('option');
      opt.value = toValue(d);      // YYYY-MM-DDTHH:MM (compatible with datetime-local)
      opt.textContent = toLabel(d); // readable label
      select.appendChild(opt);
    }

    // Explicitly select tomorrow at 10:00 (ensures the value is set even if the loop order changes)
    select.value = toValue(tomorrowAt10);

    // Update preview area
    function updatePreview() {
      const val = select.value;
      if (!val) {
        preview.innerHTML = 'Selected (human): —<br>Selected (value): —';
        return;
      }
      // Parse YYYY-MM-DDTHH:MM back into a Date in local timezone
      const [datePart, timePart] = val.split('T');
      const [y, m, d] = datePart.split('-').map(Number);
      const [hh, mm] = timePart.split(':').map(Number);
      const dateObj = new Date(y, m - 1, d, hh, mm, 0, 0);

      preview.innerHTML = `Selected (human): <strong>${dateObj.toLocaleString()}</strong><br>Selected (value): <code>${val}</code>`;
    }

    // Initialize preview
    updatePreview();

    // Update preview when user picks a different option
    select.addEventListener('change', updatePreview);


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


