import Point from "./Point.js";
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

  getMoves() {
    return JSON.parse(this.moves);
  }

  setActive(checker) {
    this.activeChecker = checker;
  }

  create(location, src) {
    let checker = document.createElement('img');

        checker.className = "checker";
        checker.src = src;
        checker.dataset.x = location.x;
        checker.dataset.y = location.y;

    return checker;
  }

  createFrom(location, checker) {
    return this.create(location, checker.src);;
  }

  remove(location) {
    this.table.querySelector(`img[data-x="${location.x}"][data-y="${location.y}"]`).remove();
  }

  isFightHappening(location) {
    let isFightHappening = false,
        data = this.getMoves();

    data.forEach((item) => {
      if( item.x == location.x &&
          item.y == location.y &&
          item.fight === true) {
        isFightHappening = true;
        this.remove(new Point(item.enemy.x, item.enemy.y));
      }
    })
    return isFightHappening;
  }

  move(from, to) {

    this.api.moveChecker(   {   from: new Point(from.dataset.x, from.dataset.y),
                                to: new Point(to.dataset.x, to.dataset.y),
                                fight: this.isFightHappening(
                                  new Point(to.dataset.x, to.dataset.y)
                                )
                            },
                          (response) => {
                            // console.log(response);
        let newChecker = this.createFrom(new Point( to.dataset.x,
                                                    to.dataset.y), from); // Create new checker from the old one, however with the new location

        from.remove(); // remove checker from where it was moved
        to.appendChild(newChecker); // append checker copy to where we want to move

        this.square.removeActive();
        this.square.removePossibles();
    });
  }

  select(el) {
    // alert('selected');
    let activeChecker = this.table.querySelector('.checker-col-active'),
        checkerImg = el.querySelector('img');

    /* 2. If square is possible, then it means that we already have
          an activeChecker and we are moving the checker to this position. */
          // console.log(this.square.isPossible(el));
    if(this.square.isPossible(el)) {
        this.move(this.activeChecker, el);
    } /* 1. If square is not empty, then we are selecting it, thus we need to
            get possible movement of the checker from the database. */
    else if(!this.square.isEmpty(el)) {

      this.square.setActive(el); // make square active
      this.setActive(checkerImg); // make checker active

      this.api.getMoves(new Point(el.dataset.x, el.dataset.y),
                        (response) => {

        this.setMoves(response.data); // save current moves in the class property

        this.square.removePossibles(); // remove old possible movements
        this.square.setPossibles(response.data); // add new ones
      });
    }
  }
}
