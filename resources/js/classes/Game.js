export default class Game {

  constructor(api) {
     this.api = api;
     this.action = document.querySelector('#join-game');
  }

  unseat(color) {


  }

  seat(color, userName) {
    let wrapper = this.action.querySelector(`.join-${color}`),
        badge = wrapper.querySelector('.badge'),
        btn = wrapper.querySelector('button'),
        fontAwesome = document.createElement('i'),
        badgeName = document.createElement('span');


        fontAwesome.className = "fa fa-user";

        badgeName.classList.add('badge-name');

        badge.innerHTML = '';
        if(btn.classList.contains('btn-secondary')) { // leaving

          badge.classList.remove('badge-success')
          badge.classList.add('badge-warning');
          badge.innerHTML = 'empty';

          btn.classList.remove('btn-secondary');
          btn.classList.add('btn-success');
          btn.innerHTML = 'Join';
          btn.setAttribute('onclick', `game.join('${color}')`);
        } else { // joining

          badge.classList.remove('badge-warning')
          badge.classList.add('badge-success');
          badge.innerHTML = userName;

          btn.classList.remove('btn-success');
          btn.classList.add('btn-secondary');
          btn.innerHTML = 'Leave';
          btn.setAttribute('onclick', `game.join('${color}')`);
        }

        badge.appendChild(fontAwesome);
        badge.appendChild(badgeName);
  }

  join(color, broadcasted = false) {

    this.api.joinGame(color, function(response) {
        console.log(response);

        this.seat(response.color, response.user_name);
        // this.unseat(response)

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
