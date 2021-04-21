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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/src/scripts/auth.js":
/*!************************************!*\
  !*** ./assets/src/scripts/auth.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener('DOMContentLoaded', function () {
  var showAuthBtn = document.getElementById('seedwps-show-auth-form'),
      authContainer = document.getElementById('seedwps-auth-container'),
      closeBtn = document.getElementById('seedwps-auth-close'),
      loginOverlay = document.querySelector('.site-login-overlay'),
      authForm = document.getElementById('seedwps-auth-form'),
      status = authForm.querySelector('[data-message="status"]');
  showAuthBtn.addEventListener('click', function () {
    authContainer.classList.add('show');
    loginOverlay.classList.add('show');
    showAuthBtn.parentElement.classList.add('hide');
  });
  closeBtn.addEventListener('click', function () {
    authContainer.classList.remove('show');
    loginOverlay.classList.remove('show');
    showAuthBtn.parentElement.classList.remove('hide');
  });
  authForm.addEventListener('submit', function (e) {
    e.preventDefault(); //Rest the form message

    resetMessages(); //Collect all the data from the form

    var data = {
      name: authForm.querySelector('[name="username"]').value,
      password: authForm.querySelector('[name="password"]').value,
      nonce: authForm.querySelector('[name="seedwps_auth"]').value
    }; //validation of the form

    if (!data.name || !data.password) {
      status.innerHTML = "Missing data";
      status.classList.add('error');
      return;
    } //ajax http post request


    var url = authForm.dataset.url;
    var params = new URLSearchParams(new FormData(authForm));
    authForm.querySelector('[name="submit"]').value = "Logging in...";
    authForm.querySelector('[name="submit"]').disable = true;
    fetch(url, {
      method: "POST",
      body: params
    }).then(function (res) {
      return res.json();
    })["catch"](function (error) {
      resetMessages();
    }).then(function (response) {
      resetMessages();

      if (response === 0 || !response.status) {
        status.innerHTML = response.message;
        status.classList.add('error');
        return;
      }

      status.innerHTML = response.message;
      status.classList.add('success');
      authForm.reset();
      window.location.reload();
    });
  });

  function resetMessages() {
    //reset all the messages
    status.innerHTML = "";
    status.classList.remove('success', 'error');
    authForm.querySelector('[name="submit"]').value = "Login";
    authForm.querySelector('[name="submit"]').disable = false;
  }
});

/***/ }),

/***/ 3:
/*!******************************************!*\
  !*** multi ./assets/src/scripts/auth.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\maccX.dev\wp-content\plugins\seedwps-plugin\assets\src\scripts\auth.js */"./assets/src/scripts/auth.js");


/***/ })

/******/ });