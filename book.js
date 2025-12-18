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

    const pad = n => String(n).padStart(2, '0');
    const toValue = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    const toLabel = d => d.toLocaleString(); // human readable

    const select = document.getElementById('date-time');
    
    const now = new Date();
    const tomorrowStart = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 0, 0, 0, 0);
    const tomorrowAt10 = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, 10, 0, 0, 0);

    for (let minutes = 0; minutes < 24 * 60; minutes += 30) {
      const d = new Date(tomorrowStart.getTime() + minutes * 60000);
      const opt = document.createElement('option');
      opt.value = toValue(d);      // YYYY-MM-DDTHH:MM
      opt.textContent = toLabel(d);
      select.appendChild(opt);
    }

    select.value = toValue(tomorrowAt10);

//update shopping cart information
function total() {
    const catPrice = 5.00; 
    const baseRate = 15.00;
    const processingFee = 2.50;

    const cats = document.getElementById("cats");
    const catQty = Array.from(cats.options).filter(opt => opt.selected).length;

    const catTotal = baseRate + (catQty * catPrice);
    const grandTotal = catTotal + processingFee; 

    document.getElementById("cat-total").innerText = (catQty > 0 ? catQty : 0); 
    document.getElementById("final-cost").innerText = grandTotal.toFixed(2);
}

document.getElementById("cats").addEventListener("change", total);

    
// creating unavailable dates
document.getElementById('auth-form').addEventListener('submit', function(e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('book.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      refreshUnavailableDates();
    }
  });
});

function refreshUnavailableDates() {
  fetch('get_unavailable.php')
    .then(res => res.json())
    .then(dates => {
      const dateInput = document.getElementById('datePicker');
      dateInput.addEventListener('input', function() {
        if (dates.includes(this.value)) {
          alert("This date is fully booked. Please choose another.");
          this.value = '';
        }
      });
    });
}

window.onload = refreshUnavailableDates;

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


