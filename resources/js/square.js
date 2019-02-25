export default class Square {

  constructor(table) {
     this.table = table;
  }

  setActive(element) {
    let activeChecker = this.table.querySelector('.checker-col-active');

    if(activeChecker) {
      activeChecker.classList.remove('checker-col-active');
    }

    element.classList.add('checker-col-active');
  }

  setPossible(coordinates) {
    let selector = `.checker-col[data-x="${coordinates.x}"][data-y="${coordinates.y}"]`,
        square = this.table.querySelector(selector);

        square.classList.add('checker-col-possible');
  }

  removeActiveAll() {
    let activeSquares = this.table.querySelectorAll('.checker-col-possible');
    if(activeSquares.length > 0) {
      activeSquares.forEach((square) => {
        square.classList.remove('checker-col-possible');
      })
    }
  }

  removePossible() {}

  isFilled(el) {
    return el.querySelector('img') ? true : false;
  }


}
