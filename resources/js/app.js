
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 // require('./bootstrap');
 window.table = document.querySelector('.table');

const API = require('./api'),
      DB = new API(window.table);

// console.log(DB.getMoves(6,1));

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

  coordinates.x += 1;
  coordinates.y += 1;

  let square = window.table.querySelector('.checker-row:nth-child('+coordinates.y+') .checker-col:nth-child('+coordinates.x+')');

  square.classList.add('checker-col-possible');
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

    let fromCoordinates = {
              x: from.dataset.x,
              y: from.dataset.y
           },
           toCoordinates = {
              x: to.dataset.x,
              y: to.dataset.y
            },
            isFight = isFightHappening(toCoordinates.x, toCoordinates.y);


  APImoveChecker(fromCoordinates, toCoordinates, isFight);

  let activeChecker = window.table.querySelector('.checker-col-active'),
      activeImg = activeChecker.querySelector('img');

      img = document.createElement('img');

      img.className = "checker";
      img.src = activeImg.src;
      img.dataset.x = toCoordinates.x;
      img.dataset.y = toCoordinates.y;

  activeChecker.classList.remove('checker-col-active');

  activeImg.remove();

  to.appendChild(img);

  removeActiveSquares();
}

window.removeChecker = function(x, y) {

  window.table.querySelector('img[data-x="' + x +'"][data-y="' + y + '"]').remove();

}

window.APImoveChecker = function(from, to, fight) {
  fetch('http://talents.test/api/checker/move?game_hash=f7d296315d57c3f7b56832a046f937f8&x1=' + from.x + '&y1=' + from.y + '&x2=' + to.x + '&y2=' + to.y + '&fight=' + fight, {
       method: 'GET',
       headers : new Headers()
   }).then((res) => res.json())
   .then((response) => {

     // console.log(response);
   })
   .catch((err)=>console.log(err))
}

window.getPossibleMoves = function(x, y) {
  // console.log('x:' + x + ' y:' + y);
  fetch('http://talents.test/api/checker/moves?game_hash=f7d296315d57c3f7b56832a046f937f8&x=' + x + '&y=' + y, {
       method: 'GET',
       headers : new Headers()
   }).then((res) => res.json())
   .then((response) => {
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
     console.log(response);

   })
   .catch((err)=>console.log(err))
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
    getPossibleMoves( element.dataset.x,
                      element.dataset.y);

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
      // console.log(element);
      // console.log('selected x: ' + window.selectedChecker.dataset.x);
      // console.log('selected y: ' + window.selectedChecker.dataset.y);
      // var isFight = isFightHappening(element.dataset.x, element.dataset.y);
      // console.log('isFight: ' + isFight);
      // console.log(window.possibleMoves.data[0].x);
      moveChecker(window.selectedChecker, element);
    }

  }
}
