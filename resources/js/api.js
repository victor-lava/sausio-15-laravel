class API {

  constructor(table) {
     this.table = table;
     this.game_hash = table.dataset.hash;
     this.url = table.dataset.api;
  }

  getMoves(x, y) {

    fetch('http://talents.test/api/checker/moves?game_hash=7290cae1b164dde41cd2ec108f043d25&x=' + x + '&y=' + y, {
         method: 'GET',
         headers : new Headers()
     }).then((res) => res.json())
     .then((response) => {
       window.possibleMoves = response;

       removeActiveSquares();

       if(response.data.length > 0) {
         response.data.map((coordinates) => {
           // console.log(coordinates);
           makeSquareActive(coordinates);
         });
       }
     })
     .catch((err)=>console.log(err));
  }

}
