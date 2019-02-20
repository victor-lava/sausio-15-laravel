
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
window.table = document.querySelector('.table');
window.possibleMoves = false;

window.isSquareFilled = function (el) {
  return el.querySelector('img') ? true : false;
}

window.makeCheckerActive = function (element) {
  let activeChecker = window.table.querySelector('.checker-col-active');

  if(activeChecker) {
    activeChecker.classList.remove('checker-col-active');
  }

  element.classList.add('checker-col-active');
}

window.removeActiveSquares = function() {
  let activeSquares = window.table.querySelectorAll('.checker-col-possible');
  if(activeSquares.length > 0) {
    activeSquares.forEach((square) => {
      square.classList.remove('checker-col-possible');
    })
  }
}

window.makeSquareActive = function(coordinates) {

  coordinates.x += 1;
  coordinates.y += 1;

  let square = window.table.querySelector('.checker-row:nth-child('+coordinates.y+') .checker-col:nth-child('+coordinates.x+')');

  square.classList.add('checker-col-possible');
}

window.moveChecker = function(element) {

  let activeChecker = window.table.querySelector('.checker-col-active'),
      activeImg = activeChecker.querySelector('img');

      img = document.createElement('img');

      img.className = "checker";
      img.src = activeImg.src;

  activeChecker.classList.remove('checker-col-active');

  activeImg.remove();

  element.appendChild(img);

  removeActiveSquares();
}

window.getPossibleMoves = function(x, y) {
  fetch('http://talents.test/api/checker/moves?game_hash=7290cae1b164dde41cd2ec108f043d25&x=' + x + '&y=' + y, {
       method: 'GET',
       headers : new Headers()
   }).then((res) => res.json())
   .then((response) => {
     window.possibleMoves = response;
     removeActiveSquares();
     if(response.data.length > 0) {
       response.data.map((coordinates) => {
         makeSquareActive(coordinates);
       });
     }
   })
   .catch((err)=>console.log(err))
}

window.canMove = function(element) {
  return element.classList.contains('checker-col-possible') ? true : false;
}

window.selectChecker = function(element) {

  let activeChecker = window.table.querySelector('.checker-col-active'),
      checker = element.querySelector('img');

  if(isSquareFilled(element)) { // square filled
    makeCheckerActive(element); // makes selected checker active and removes active class from the rest of the checker

    getPossibleMoves( checker.dataset.x,
                      checker.dataset.y);
    // 1. zingsnis, saskes paselektinimas
    // 2. turi vykti fetchas ir turi grazinti possible ejimus
    // 3 kai grazina possible ejimus uzdeda klases checker-col-possible



  } else { // square empty
    // 2. saskes permetimas, taciau permetam tik ten kur yra checker-col-possible
    // console.log(element);
    if(canMove(element)) {
      moveChecker(element);
    }

  }
}
