
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.table = document.querySelector('#checkers');
window.selectedChecker = false;
window.moves = false;

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

window.removePossibleMovements = function() {

  let activeSquares = window.table.querySelectorAll('.checker-col-possible');
  // console.log(activeSquares);
  if(activeSquares.length > 0) {
    activeSquares.forEach((square) => {
      square.classList.remove('checker-col-possible');
    });
  }
}


window.getPossibleMoves = function(x, y, callback) {
  let game_hash = window.table.dataset.hash;

  window.axios.get('/api/checker/moves', {
    params: { game_hash, x, y }
  })
  .then(function(response) {
      // console.log(response);
      callback(response);
  });

  // return response;
}

window.moveChecker = function(x1, y1, x2, y2, callback) {
  let game_hash = window.table.dataset.hash;

  window.axios.get('/api/checker/move', {
    params: { game_hash, x1, y1, x2, y2 }
  })
  .then(function(response) {
      callback(response);
  });

  // return response;
}

window.findChecker = function(x, y) {
  let checker = window.table.querySelector(`.checker[data-x="${x}"][data-y="${y}"]`);
  return checker ? checker : false;
}

window.isPossible = function(element) {
  return element.classList.contains('checker-col-possible');
}

window.moveCheckerOnDOM = function(response) {
  console.log(response);
  let data = response.data.data;

  if(data.enemy !== false) {
    findChecker(data.enemy.x, data.enemy.y).remove();
  }

  removePossibleMovements();

  let appendTo = window.table.querySelector(`.checker-col[data-x="${data.x}"][data-y="${data.y}"]`),
      activeChecker = window.table.querySelector('.checker-col-active'),
      activeImg = activeChecker.querySelector('img');

      console.log(appendTo);
      img = document.createElement('img');

      img.className = "checker";
      img.src = activeImg.src;
      img.dataset.x = data.x;
      img.dataset.y = data.y;

  activeChecker.classList.remove('checker-col-active');
  activeImg.remove();

  appendTo.appendChild(img);
}

window.selectChecker = function(element) {

  let activeChecker = window.table.querySelector('.checker-col-active'),
      checker = element.querySelector('img');

  if(isSquareFilled(element)) { // square filled
    window.selectedChecker = checker;
    makeCheckerActive(element); // makes selected checker active and removes active class from the rest of the checker

    getPossibleMoves( checker.dataset.x,
                      checker.dataset.y,
                      function(response) {

      // console.log(response);
      removePossibleMovements();
      response.data.data.map((item) => {
      let square = window.table.querySelector(`div.checker-col[data-x="${item.x}"][data-y="${item.y}"]`)

        square.classList.add('checker-col-possible');
      })
      window.moves = response.data.data;
   });

    // 1. zingsnis, saskes paselektinimas
    // 2. turi vykti fetchas ir turi grazinti possible ejimus
    // 3 kai grazina possible ejimus uzdeda klases checker-col-possible



  } else { // square empty
    // 2. saskes permetimas, taciau permetam tik ten kur yra checker-col-possible
    // console.log(window.selectedChecker);
    if(isPossible(element)) { // if square has class checker-col-possible then move it there
      moveChecker( window.selectedChecker.dataset.x,
            window.selectedChecker.dataset.y,
            element.dataset.x,
            element.dataset.y,
            function(response) {

              moveCheckerOnDOM(response);
              
        })

    }
  }
}
