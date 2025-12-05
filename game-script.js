/*accessing elements on the page*/
const gameCenterScreen = document.getElementById("game-center-screen");
const memoryGameScreen = document.getElementById("memory-game-screen");

const memoryButton = document.getElementById("memory-game-btn");
const returnGameButton = document.getElementById("return-game-center");
const difficultySelect = document.getElementById("difficulty-select");
const memoryTime = document.getElementById("memory-time");
const startMemoryBtn = document.getElementById("start-memory-game");

const memoryContainer = document.getElementById("memory-container");

/*sounds*/
let correctSound = new Audio("img/memory-game/correct.mp3");
let wrongSound   = new Audio("img/memory-game/wrong.mp3");

/*timer variables*/
let timeCount = 0;
let timer = null;

/*difficulty grid sizes (default easy)*/
let rows = 3;
let cols = 4;

/*logic variables*/
let firstCard = null;
let secondCard = null;
let clickable = true;
let matchesMade = 0;
let totalMatchesNeeded = 0;

/*cat images*/
const catImages = [
  "img/memory-game/black-cat.png",
  "img/memory-game/bi-cat.png",
  "img/memory-game/bibrown-cat.png",
  "img/memory-game/brown-cat.png",
  "img/memory-game/grey-cat.png","img/memory-game/greyear-cat.png",
  "img/memory-game/mono-cat.png",
  "img/memory-game/monobrown-cat.png",
  "img/memory-game/oreo-cat.png",
  "img/memory-game/pink-cat.png",
  "img/memory-game/solidb-cat.png",
  "img/memory-game/white-cat.png"
];

const cardBack = "img/memory-game/back.png";

/*event listeners*/
memoryButton.addEventListener("click", showMemoryGame);
returnGameButton.addEventListener("click", returnGameScreen);

startMemoryBtn.addEventListener("click", function() {
  startTimer();
  setUpMemoryGame();
});

difficultySelect.addEventListener("change", function() {
  if (difficultySelect.value === "easy") {
    rows = 3; cols = 4;
  }
  else if (difficultySelect.value === "medium") {
    rows = 4; cols = 5;
  }
  else if (difficultySelect.value === "hard") {
    rows = 4; cols = 6;
  }
});


/* switch to mem game screen */
function showMemoryGame() {
  gameCenterScreen.classList.remove("unhide");
  gameCenterScreen.classList.add("hide");

  memoryGameScreen.classList.remove("hide");
  memoryGameScreen.classList.add("unhide");

  memoryTime.textContent = 0;
}


/* start timer */
function startTimer() {
  timeCount = 0;
  memoryTime.textContent = 0;

  if (timer) { clearInterval(timer); }

  timer = setInterval(function() {
    timeCount++;
    memoryTime.textContent = timeCount;
  }, 1000);
}


/* set up memory game board */
function setUpMemoryGame() {

  /*clear previous board*/
  memoryContainer.innerHTML = "";

  memoryContainer.style.display = "grid";
  memoryContainer.style.gridTemplateColumns = "repeat(" + cols + ", 100px)";
  memoryContainer.style.gap = "10px";

  let cardCount = rows * cols;
  totalMatchesNeeded = cardCount / 2;

  /*select random images with no duplicates*/
  let selected = [];
  while (selected.length < totalMatchesNeeded) {
    let index = parseInt(Math.random() * catImages.length);
    let img = catImages[index];

    if (!selected.includes(img)) {
      selected[selected.length] = img;
    }
  }

  /*duplicate to make pairs*/
  let gameImages = [];
  for (let i = 0; i < selected.length; i++) {
    gameImages[gameImages.length] = selected[i];
    gameImages[gameImages.length] = selected[i];
  }

  /*shuffle*/
  for (let i = 0; i < gameImages.length; i++) {
    let r = parseInt(Math.random() * gameImages.length);
    let temp = gameImages[i];
    gameImages[i] = gameImages[r];
    gameImages[r] = temp;
  }

  firstCard = null;
  secondCard = null;
  clickable = true;
  matchesMade = 0;

  /*place cards on the screen*/
  for (let i = 0; i < gameImages.length; i++) {
    let card = document.createElement("img");
    card.src = cardBack;
    card.className = "memory-card";
    card.setAttribute("data-secret", gameImages[i]);

    card.addEventListener("click", function() {
      flipCard(card);
    });

    memoryContainer.appendChild(card);
  }
}


/* flip card */
function flipCard(card) {

  if (!clickable) return;
  if (card === firstCard) return;

  card.src = card.getAttribute("data-secret");

  if (firstCard === null) {
    firstCard = card;
    return;
  }

  secondCard = card;
  clickable = false;

  checkMatch();
}


/* check for a match */
function checkMatch() {

  let img1 = firstCard.getAttribute("data-secret");
  let img2 = secondCard.getAttribute("data-secret");

  if (img1 === img2) {

    correctSound.play();

    firstCard = null;
    secondCard = null;
    clickable = true;

    matchesMade++;

    if (matchesMade === totalMatchesNeeded) {
      gameOver();
    }
  }
  else {

    wrongSound.play();

    setTimeout(function() {
      firstCard.src = cardBack;
      secondCard.src = cardBack;

      firstCard = null;
      secondCard = null;
      clickable = true;

    }, 900);
  }
}


/* game over */
function gameOver() {
  clearInterval(timer);
  alert("You win! Time: " + timeCount + " seconds");
}


/*return to game center*/
function returnGameScreen() {

  clearInterval(timer);

  memoryGameScreen.classList.remove("unhide");
  memoryGameScreen.classList.add("hide");

  gameCenterScreen.classList.remove("hide");
  gameCenterScreen.classList.add("unhide");
}








