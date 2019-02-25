import Square from "./Square.js";

export default class Checker {

  constructor(table, api) {
     this.table = table;
     this.api = api;
     this.moves = false;
     this.activeChecker = false;
     this.square = new Square(this.table);
  }

  setMoves(moves) {
    this.moves = JSON.stringify(moves);
  }

  setActive(checker) {
    this.activeChecker = checker;
  }

  remove(x, y) {
    this.table.querySelector(`img[data-x="${x}"][data-y="${y}"]`).remove();
  }

  isFightHappening(x, y) {
    let isFightHappening = false,
        data = JSON.parse(this.moves);

    data.forEach((item) => {
      if( item.x == x &&
          item.y == y &&
          item.fight === true) {
        isFightHappening = true;
        this.remove(item.enemy.x, item.enemy.y);
      }
    })
    return isFightHappening;
  }

  move(from, to) {

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

        this.square.removePossibles();
    });
  }

  select(el) {
    let activeChecker = this.table.querySelector('.checker-col-active'),
        checkerImg = el.querySelector('img');

    /* 2. If square is possible, then it means that we already have
          an activeChecker and we are moving the checker to this position. */
    if(this.square.isPossible(el)) {
        this.move(this.activeChecker, el);
    } /* 1. If square is not empty, then we are selecting it, thus we need to
            get possible movement of the checker from the database. */
    else if(!this.square.isEmpty(el)) {

      this.square.setActive(el); // make square active
      this.setActive(checkerImg); // make checker active

      this.api.getMoves(el.dataset.x,
                        el.dataset.y,
                        (response) => {

        this.setMoves(response.data); // save current moves in the class property

        this.square.removePossibles(); // remove old possible movements
        this.square.setPossibles(response.data); // add new ones
      });
    }
  }
}
