/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// require('./bootstrap');
// require('./api');
window.table = document.querySelector('.table');
window.possibleMoves = false;
window.selectedChecker = false;

window.isSquareFilled = function (el) {
  return el.querySelector('img') ? true : false;
};

window.makeCheckerActive = function (element) {
  var activeChecker = window.table.querySelector('.checker-col-active');

  if (activeChecker) {
    activeChecker.classList.remove('checker-col-active');
  }

  element.classList.add('checker-col-active');
};

window.removeActiveSquares = function () {
  var activeSquares = window.table.querySelectorAll('.checker-col-possible');

  if (activeSquares.length > 0) {
    activeSquares.forEach(function (square) {
      square.classList.remove('checker-col-possible');
    });
  }
};

window.makeSquareActive = function (coordinates) {
  coordinates.x += 1;
  coordinates.y += 1;
  var square = window.table.querySelector('.checker-row:nth-child(' + coordinates.y + ') .checker-col:nth-child(' + coordinates.x + ')');
  square.classList.add('checker-col-possible');
};

window.isFightHappening = function (x, y) {
  var isFightHappening = false;
  window.possibleMoves.data.forEach(function (item) {
    console.log(item.x);

    if (item.x == x && item.y == y) {
      isFightHappening = true;
    }
  });
  return isFightHappening;
};

window.moveChecker = function (element) {
  var from = {
    x: window.selectedChecker.dataset.x,
    y: window.selectedChecker.dataset.y
  },
      to = {
    x: element.dataset.x,
    y: element.dataset.y
  };
  console.log(isFightHappening(from.x, from.y)); // console.log(window.p)

  APImoveChecker(from, to);
  var activeChecker = window.table.querySelector('.checker-col-active'),
      activeImg = activeChecker.querySelector('img');
  img = document.createElement('img');
  img.className = "checker";
  img.src = activeImg.src;
  img.dataset.x = to.x;
  img.dataset.y = to.y;
  activeChecker.classList.remove('checker-col-active');
  activeImg.remove();
  element.appendChild(img);
  removeActiveSquares();
};

window.APImoveChecker = function (from, to, fight) {
  fetch('http://talents.test/api/checker/move?game_hash=b13daaf7427cdb741d58349c9212c599&x1=' + from.x + '&y1=' + from.y + '&x2=' + to.x + '&y2=' + to.y, {
    method: 'GET',
    headers: new Headers()
  }).then(function (res) {
    return res.json();
  }).then(function (response) {
    console.log(response);
  }).catch(function (err) {
    return console.log(err);
  });
};

window.getPossibleMoves = function (x, y) {
  console.log('x:' + x + ' y:' + y);
  fetch('http://talents.test/api/checker/moves?game_hash=b13daaf7427cdb741d58349c9212c599&x=' + x + '&y=' + y, {
    method: 'GET',
    headers: new Headers()
  }).then(function (res) {
    return res.json();
  }).then(function (response) {
    window.possibleMoves = response;
    removeActiveSquares();

    if (response.data.length > 0) {
      response.data.map(function (coordinates) {
        // console.log(coordinates);
        makeSquareActive(coordinates);
      });
    }
  }).catch(function (err) {
    return console.log(err);
  });
};

window.canMove = function (element) {
  var isColPossible = element.classList.contains('checker-col-possible');
  return isColPossible ? true : false;
};

window.selectChecker = function (element) {
  var activeChecker = window.table.querySelector('.checker-col-active'),
      checkerImg = element.querySelector('img'); // console.log(checkerImg);

  if (checkerImg) {
    window.selectedChecker = checkerImg;
  }

  if (isSquareFilled(element)) {
    // square filled
    // window.selectedChecker = activeChecker.querySelector('img');
    makeCheckerActive(element); // makes selected checker active and removes active class from the rest of the checker
    // console.log(element);
    // console.log(window.selectedChecker.dataset.x);

    getPossibleMoves(window.selectedChecker.dataset.x, window.selectedChecker.dataset.y); // 1. zingsnis, saskes paselektinimas
    // 2. turi vykti fetchas ir turi grazinti possible ejimus
    // 3 kai grazina possible ejimus uzdeda klases checker-col-possible
  } else {
    // square empty
    // 2. saskes permetimas, taciau permetam tik ten kur yra checker-col-possible
    // console.log(element);
    if (canMove(element)) {
      moveChecker(element);
    }
  }
};

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/viktoras/Code/Homestead/talents/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /home/viktoras/Code/Homestead/talents/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });