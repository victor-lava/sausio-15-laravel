
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import API from "./api.js";

window.table = document.querySelector('.table');
window.api = new API(window.table);
window.possibleMoves = false;
window.selectedChecker = false;

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

window.makeSquarePossible = function(coordinates) {
  let selector = `.checker-col[data-x="${coordinates.x}"][data-y="${coordinates.y}"]`;

      square = window.table.querySelector(selector).classList.add('checker-col-possible');
}

window.isFightHappening = function(x, y) {
  let isFightHappening = false,
      data = JSON.parse(window.possibleMoves.data);

  data.forEach((item) => {
    if( item.x == x &&
        item.y == y &&
        item.fight === true) {
      isFightHappening = true;
      removeChecker(item.enemy.x, item.enemy.y);
    }
  })
  return isFightHappening;
}

window.moveChecker = function(from, to) {

  window.api.moveChecker({  x1: from.dataset.x, y1: from.dataset.y,
                            x2: to.dataset.x,   y2: to.dataset.y,
                            fight: isFightHappening(to.dataset.x, to.dataset.y)},
                            (response) => {
      console.log(response);
      let activeChecker = window.table.querySelector('.checker-col-active'),
          activeImg = activeChecker.querySelector('img'),
          img = document.createElement('img');

          img.className = "checker";
          img.src = activeImg.src;
          img.dataset.x = to.dataset.x;
          img.dataset.y = to.dataset.y;

      activeChecker.classList.remove('checker-col-active');

      activeImg.remove();

      to.appendChild(img);

      removeActiveSquares();
  });
}

window.removeChecker = function(x, y) {

  window.table.querySelector(`img[data-x="${x}"][data-y="${y}"]`).remove();

}

window.canMove = function(element) {
  let isColPossible = element.classList.contains('checker-col-possible');
  return isColPossible ? true : false;
}

window.selectChecker = function(element) {

  let activeChecker = window.table.querySelector('.checker-col-active'),
      checkerImg = element.querySelector('img');
      // console.log(window.selectedChecker);

  if(isSquareFilled(element)) { // square filled
    // window.selectedChecker = activeChecker.querySelector('img');
    makeCheckerActive(element); // makes selected checker active and removes active class from the rest of the checker
    // console.log(element);
    // console.log(window.selectedChecker.dataset.x);
    // getPossibleMoves( element.dataset.x,
    //                   element.dataset.y);

    window.api.getMoves(element.dataset.x, element.dataset.y, (response) => {
      let data = response.data;

      response.data = JSON.stringify(response.data); // solves the mutating x, y values
      window.possibleMoves = response;

      removeActiveSquares();
      if(data.length > 0) {
        data.forEach((coordinates) => {
          // console.log(coordinates);
          makeSquarePossible(coordinates);
        });
      }
    });

    if(checkerImg) { window.selectedChecker = checkerImg; }
    // console.log(window.selectedChecker);
    // 1. zingsnis, saskes paselektinimas
    // 2. turi vykti fetchas ir turi grazinti possible ejimus
    // 3 kai grazina possible ejimus uzdeda klases checker-col-possible

  } else { // square empty
    // 2. saskes permetimas, taciau permetam tik ten kur yra checker-col-possible
    // console.log(element);
    // console.log(window.selectedChecker);
    // console.log(canMove(window.selectedChecker));
    if(canMove(element)) {
      moveChecker(window.selectedChecker, element);
    }

  }
}
