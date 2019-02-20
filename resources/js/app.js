
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
window.table = document.querySelector('.table');

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

window.moveChecker = function(element) {
  let activeChecker = window.table.querySelector('.checker-col-active'),
      activeImg = activeChecker.querySelector('img');

      img = document.createElement('img');

      img.className = "checker";
      img.src = activeImg.src;

  activeChecker.classList.remove('checker-col-active');
  activeImg.remove();

  element.appendChild(img);
}

window.getPossibleMoves = function(x, y) {
  let moves = [];

  alert('x: ' + x + ' y: ' + y);

  return moves;
}

window.selectChecker = function(element) {

  let activeChecker = window.table.querySelector('.checker-col-active'),
      checker = element.querySelector('img');

  if(isSquareFilled(element)) { // square filled
    makeCheckerActive(element); // makes selected checker active and removes active class from the rest of the checker
    
    moves = getPossibleMoves( checker.dataset.x,
                              checker.dataset.y);
    console.log(moves);
    // 1. zingsnis, saskes paselektinimas
    // 2. turi vykti fetchas ir turi grazinti possible ejimus
    // 3 kai grazina possible ejimus uzdeda klases checker-col-possible



  } else { // square empty
    // 2. saskes permetimas, taciau permetam tik ten kur yra checker-col-possible

    moveChecker(element);
  }
}
