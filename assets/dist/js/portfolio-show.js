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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/src/scripts/portfolio-show.js":
/*!**********************************************!*\
  !*** ./assets/src/scripts/portfolio-show.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

document.addEventListener('DOMContentLoaded', function (e) {
  //Global variables
  var active = {
    navSlide: null,
    mainSlide: null,
    dotSlide: null
  };
  var nextSlide = {
    navSlide: null,
    mainSlide: null,
    dotSlide: null
  };
  var prevButton = document.querySelector('.carousel__button--left');
  var nextButton = document.querySelector('.carousel__button--right');

  var navSlides = _toConsumableArray(document.querySelectorAll('.carousel__logo__indicator'));

  var trackSlides = document.querySelectorAll('.carousel__slide'); // const mainSlides = Array.from(trackSlides);
  //OR

  var mainSlides = _toConsumableArray(trackSlides);

  var dotSlides = _toConsumableArray(document.querySelectorAll('.carousel_indicator')); //Sliding Function


  initSlider(); //Event Listeners

  nextButton.addEventListener('click', function () {
    moveSlides(true);
  });
  prevButton.addEventListener('click', function () {
    moveSlides(false);
  });
  jumpToSlide(navSlides);
  jumpToSlide(dotSlides);

  function initSlider() {
    /**
     * Add active class to the first slide
     */
    navSlides[0].classList.add('is-active');
    mainSlides[0].classList.add('is-active');
    dotSlides[0].classList.add('is-active');
  }

  function moveSlides(forward) {
    // console.log(forward);

    /**
           * Moving forward:
           * get the active slide/nav/dot
           * get the indexes of these active slide/nav/dot
           * remove active class from it
           * get the next slide
           * add active class to it
           * if we reach end of the road, get the first slide and make it new active
           * 
           * 
           * Moving Backward
           * get the active slide
           * remove active class from it
           * get the previous slide
           * add active class to it
           * if we reach start, get the last slide and make it new active
           */
    //active slide/nav/dot
    active.navSlide = document.querySelector('.carousel__logo__indicator.is-active');
    active.mainSlide = document.querySelector('.carousel__slide.is-active');
    active.dotSlide = document.querySelector('.carousel_indicator.is-active'); //indexes of these active slide/nav/dot

    var activeNav = navSlides.indexOf(active.navSlide);
    var activeSlide = mainSlides.indexOf(active.mainSlide);
    var activeDot = dotSlides.indexOf(active.dotSlide);

    if (forward) {
      nextSlide.navSlide = navSlides[(activeNav + 1) % navSlides.length];
      active.navSlide.classList.remove('is-active');
      nextSlide.navSlide.classList.add('is-active');
      nextSlide.mainSlide = mainSlides[(activeSlide + 1) % mainSlides.length];
      active.mainSlide.classList.remove('is-active');
      nextSlide.mainSlide.classList.add('is-active');
      nextSlide.dotSlide = dotSlides[(activeDot + 1) % dotSlides.length];
      active.dotSlide.classList.remove('is-active');
      nextSlide.dotSlide.classList.add('is-active');
    } else {
      nextSlide.navSlide = navSlides[(activeNav - 1 + navSlides.length) % navSlides.length];
      active.navSlide.classList.remove('is-active');
      nextSlide.navSlide.classList.add('is-active');
      nextSlide.mainSlide = mainSlides[(activeSlide - 1 + mainSlides.length) % mainSlides.length];
      active.mainSlide.classList.remove('is-active');
      nextSlide.mainSlide.classList.add('is-active');
      nextSlide.dotSlide = dotSlides[(activeDot - 1 + dotSlides.length) % dotSlides.length];
      active.dotSlide.classList.remove('is-active');
      nextSlide.dotSlide.classList.add('is-active');
    }
  }

  function jumpToSlide(slides) {
    slides.forEach(function (slide, index) {
      slide.addEventListener('click', function () {
        active.navSlide = document.querySelector('.carousel__logo__indicator.is-active');
        active.mainSlide = document.querySelector('.carousel__slide.is-active');
        active.dotSlide = document.querySelector('.carousel_indicator.is-active');

        if (!slide.classList.contains('is-active')) {
          active.navSlide.classList.remove('is-active');
          active.mainSlide.classList.remove('is-active');
          active.dotSlide.classList.remove('is-active');
          navSlides[index].classList.add('is-active');
          mainSlides[index].classList.add('is-active');
          dotSlides[index].classList.add('is-active');
        }
      });
    });
  }
});

/***/ }),

/***/ 1:
/*!****************************************************!*\
  !*** multi ./assets/src/scripts/portfolio-show.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\maccX.dev\wp-content\plugins\seedwps-plugin\assets\src\scripts\portfolio-show.js */"./assets/src/scripts/portfolio-show.js");


/***/ })

/******/ });