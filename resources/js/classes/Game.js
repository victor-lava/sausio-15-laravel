export default class Game {

  constructor(api) {
     this.api = api;
  }

  join(color, broadcasted = false) {

    this.api.joinGame(color, function(response) {
        console.log(response);

       // 1. switched, 2. game starting, 3.
    });
  }

  leave(color, broadcasted = false) {

    this.api.leaveGame(color, function(response) {
        console.log(response);


    });

    // let data = response.data;
    // if(data.status === 200) { // can join
    //   let joinDiv = document.querySelector('#join-game');
    //
    //
    //       if(data.data.seated == 'white' ||
    //          data.data.seated == 'black') {
    //         toggleBadge(joinDiv, data.data.seated_user);
    //       }
    //
    // }
  }

}
