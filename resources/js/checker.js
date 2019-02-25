export default class Checker {

  constructor(table, api) {
     this.table = table;
     this.api = api;
     this.possibleMoves = false;
     this.selectedChecker = false;
  }

  isSquareFilled(el) {
    return el.querySelector('img') ? true : false;
  }

  makeCheckerActive(el) {
    let activeChecker = this.table.querySelector('.checker-col-active');

    if(activeChecker) {
      activeChecker.classList.remove('checker-col-active');
    }

    el.classList.add('checker-col-active');
  }

  removeActiveSquare() {
    let activeSquares = this.table.querySelectorAll('.checker-col-possible');
    if(activeSquares.length > 0) {
      activeSquares.forEach((square) => {
        square.classList.remove('checker-col-possible');
      })
    }
  }

  makeSquarePossible(coordinates) {
    let selector = `.checker-col[data-x="${coordinates.x}"][data-y="${coordinates.y}"]`,
        square = this.table.querySelector(selector);

        square.classList.add('checker-col-possible');
  }

  removeActiveSquares() {
    let activeSquares = window.table.querySelectorAll('.checker-col-possible');
    if(activeSquares.length > 0) {
      activeSquares.forEach((square) => {
        square.classList.remove('checker-col-possible');
      })
    }
  }

  isFightHappening(x, y) {
    let isFightHappening = false,
        data = JSON.parse(this.possibleMoves.data);

    data.forEach((item) => {
      if( item.x == x &&
          item.y == y &&
          item.fight === true) {
        isFightHappening = true;
        this.removeChecker(item.enemy.x, item.enemy.y);
      }
    })
    return isFightHappening;
  }

  moveChecker(from, to) {

    this.api.moveChecker({  x1: from.dataset.x, y1: from.dataset.y,
                              x2: to.dataset.x,   y2: to.dataset.y,
                              fight: this.isFightHappening(to.dataset.x, to.dataset.y)},
                              (response) => {

        let activeChecker = this.table.querySelector('.checker-col-active'),
            activeImg = activeChecker.querySelector('img'),
            img = document.createElement('img');

            img.className = "checker";
            img.src = activeImg.src;
            img.dataset.x = to.dataset.x;
            img.dataset.y = to.dataset.y;

        activeChecker.classList.remove('checker-col-active');

        activeImg.remove();

        to.appendChild(img);

        this.removeActiveSquares();
    });
  }

  removeChecker(x, y) {

    this.table.querySelector(`img[data-x="${x}"][data-y="${y}"]`).remove();

  }

  canMove(el){
    let isColPossible = el.classList.contains('checker-col-possible');
    return isColPossible ? true : false;
  }

  selectChecker(el) {

    let activeChecker = this.table.querySelector('.checker-col-active'),
        checkerImg = el.querySelector('img');

    if(this.isSquareFilled(el)) { // square filled, means that we are selecting checker
      this.makeCheckerActive(el); // makes selected checker active and removes active class from the rest of the checker

      this.api.getMoves(el.dataset.x, el.dataset.y, (response) => {
        let data = response.data;

        response.data = JSON.stringify(response.data); // solves the mutating x, y values
        this.possibleMoves = response;
        this.removeActiveSquares();

        if(data.length > 0) {
          data.forEach((coordinates) => {
            this.makeSquarePossible(coordinates);
          });
        }
      });

      if(checkerImg) { this.selectedChecker = checkerImg; }
      // console.log(this.selectedChecker);
      // 1. zingsnis, saskes paselektinimas
      // 2. turi vykti fetchas ir turi grazinti possible ejimus
      // 3 kai grazina possible ejimus uzdeda klases checker-col-possible

    } else { // square is empty, means that we are moving the checker
      // 2. saskes permetimas, taciau permetam tik ten kur yra checker-col-possible

      if(this.canMove(el)) {
        this.moveChecker(this.selectedChecker, el);
      }

    }
  }
}
