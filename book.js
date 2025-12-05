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

const time = new Date();
document.getElementById("current-date").innerHTML = time;

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


