export default class Game {

  constructor(api) {
     this.api = api;
     this.action = document.querySelector('#join-game');
  }

  unseat(color) {

    let wrapper = this.action.querySelector(`.join-${color}`),
        badge = wrapper.querySelector('.badge'),
        btn = wrapper.querySelector('button'),
        fontAwesome = document.createElement('i'),
        badgeName = document.createElement('span');

        fontAwesome.className = "fa fa-user";

        badgeName.classList.add('badge-name');

        badge.innerHTML = '';

        badge.classList.remove('badge-success')
        badge.classList.add('badge-warning');
        badge.innerHTML = 'empty';

        btn.classList.remove('btn-secondary');
        btn.classList.add('btn-success');
        btn.innerHTML = 'Join';
        btn.setAttribute('onclick', `game.join('${color}')`);


        badge.appendChild(badgeName);
        badge.appendChild(fontAwesome);

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

        badge.classList.remove('badge-warning')
        badge.classList.add('badge-secondary');
        badge.innerHTML = userName;

        btn.classList.remove('btn-success');
        btn.classList.add('btn-secondary');
        btn.innerHTML = 'Leave';
        btn.setAttribute('onclick', `game.leave('${color}')`);

        badge.appendChild(badgeName);
        badge.appendChild(fontAwesome);

  }

  toggleSeat(data) {
    let color;

    if(data.action === 'game-join') { // i am joing for first time?
      this.seat(data.seat,
                data.user_name);

    } else if(data.action === 'game-switch') {
      color = (data.color === 'black') ? 'white' : 'black';

      this.seat(data.seat,
                data.user_name);

      this.unseat(color);
    }
  }

  join(color, broadcasted = false) {

    this.api.joinGame(color, (response) => {
      // console.log(response);
      this.toggleSeat(response.data);

    });
  }

  leave(color, broadcasted = false) {

    this.api.leaveGame(color, (response) => {

        this.unseat(color);


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
