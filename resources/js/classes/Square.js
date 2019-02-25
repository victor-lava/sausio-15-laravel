export default class Square {

  constructor(table) {
     this.table = table;
  }

  findActive() {
    let active = this.table.querySelector('.checker-col-active');
    return active ? active : false;
  }

  removeActive() {
    let active = this.table.querySelector('.checker-col-active');
    return active ? active.classList.remove('checker-col-active') : false;
  }

  setActive(element) {
    this.removeActive(); // removes active, because there can't be 2 selected checkers
    element.classList.add('checker-col-active');
  }

  setPossible(coordinates) {
    let selector = `.checker-col[data-x="${coordinates.x}"][data-y="${coordinates.y}"]`,
        square = this.table.querySelector(selector);

        square.classList.add('checker-col-possible');
  }

  setPossibles(moves) {
    if(moves.length > 0) {
      moves.forEach((coordinates) => {
        this.setPossible(coordinates);
      });
    }
  }

  removePossibles() {
    let activeSquares = this.table.querySelectorAll('.checker-col-possible');
    if(activeSquares.length > 0) {
      activeSquares.forEach((square) => {
        square.classList.remove('checker-col-possible');
      })
    }
  }

  isEmpty(square) {
    return square.querySelector('img') ? false : true;
  }

  isPossible(square) {
    return square.classList.contains('checker-col-possible') ? true : false;
  }


}
