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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/src/scripts/contactform.js":
/*!*******************************************!*\
  !*** ./assets/src/scripts/contactform.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener('DOMContentLoaded', function (e) {
  console.log('Contact form is ready!');
});
jQuery(document).ready(function ($) {
  $('#paragonContactForm').on('submit', function (e) {
    e.preventDefault();
    $('.has-error').removeClass('has-error');
    $('.js-show-feedback').removeClass('js-show-feedback');
    var form = $(this),
        name = form.find('#name').val(),
        email = form.find('#email').val(),
        message = form.find('#message').val(),
        ajaxurl = form.data('url');

    if (name === '') {
      $('#name').parent('.form-group').addClass('has-error');
      return;
    }

    if (email === '') {
      $('#email').parent('.form-group').addClass('has-error');
      return;
    }

    if (message === '') {
      $('#message').parent('.form-group').addClass('has-error');
      return;
    }

    form.find('input, button, textarea').attr('disabled', 'disabled');
    $('.js-form-submission').addClass('js-show-feedback');
    $.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
        name: name,
        email: email,
        message: message,
        action: 'paragon_save_user_contact_form'
      },
      error: function error(response) {
        $('.js-form-submission').removeClass('js-show-feedback');
        $('.js-form-error').addClass('js-show-feedback');
        form.find('input, button, textarea').removeAttr('disabled');
      },
      success: function success(response) {
        if (response == 0) {
          setTimeout(function () {
            $('.js-form-submission').removeClass('js-show-feedback');
            $('.js-form-error').addClass('js-show-feedback');
            form.find('input, button, textarea').removeAttr('disabled');
          }, 1500);
        } else {
          setTimeout(function () {
            $('.js-form-submission').removeClass('js-show-feedback');
            $('.js-form-success').addClass('js-show-feedback');
            form.find('input, button, textarea').removeAttr('disabled').val('');
          }, 1500);
        }
      }
    });
  });
});

/***/ }),

/***/ 5:
/*!*************************************************!*\
  !*** multi ./assets/src/scripts/contactform.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\maccX.dev\wp-content\plugins\seedwps-plugin\assets\src\scripts\contactform.js */"./assets/src/scripts/contactform.js");


/***/ })

/******/ });