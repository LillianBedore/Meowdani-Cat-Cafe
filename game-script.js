/*accessing elements on the page*/
const gameCenterScreen = document.getElementById("game-center-screen");
const memoryGameScreen = document.getElementById("memory-game-screen");

const memoryButton = document.getElementById("memory-game-btn");
const returnGameButton = document.getElementById("return-game-center");

/*event listeners*/
memoryButton.addEventListener("click", showMemoryGame);
returnGameButton.addEventListener("click", returnGameScreen)

/*memory game set-up*/

  /*hide game center screen, show memory game screen*/
function showMemoryGame() {
  if (gameCenterScreen.classList.contains("unhide")) {
    /*hide game center*/
    gameCenterScreen.classList.remove("unhide");
    gameCenterScreen.classList.add("hide");

    /*show memory game*/
    memoryGameScreen.classList.remove("hide");
    memoryGameScreen.classList.add("unhide");
  }


}

/*return to game center screen*/
function returnGameScreen(){
  if (memoryGameScreen.classList.contains("unhide"))
  {
    memoryGameScreen.classList.remove("unhide");
    memoryGameScreen.classList.add("hide");

    gameCenterScreen.classList.remove("hide");
    gameCenterScreen.classList.add("unhide");
  }


}


