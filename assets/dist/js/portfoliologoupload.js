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
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/src/scripts/portfoliologoupload.js":
/*!***************************************************!*\
  !*** ./assets/src/scripts/portfoliologoupload.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*====================
#Scripts for uploading a project logo in the portfolio
post type meta box
======================*/
jQuery(function ($) {
  /*
   * Select/Upload image(s) event
   */
  $('body').on('click', '.portfolio_upload_image_button', function (e) {
    e.preventDefault();
    var button = $(this),
        custom_uploader = wp.media({
      title: 'Insert image',
      library: {
        // comment the next line if you want not to attach image to the current post
        uploadedTo: wp.media.view.settings.post.id,
        type: 'image'
      },
      button: {
        text: 'Use this image' // button label text

      },
      multiple: false // for multiple image selection set to true

    }).on('select', function () {
      // it also has "open" and "close" events 
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();
      /* if you set multiple to true, here is some code for getting the image IDs
      var attachments = frame.state().get('selection'),
          attachment_ids = new Array(),
          i = 0;
      attachments.each(function(attachment) {
          attachment_ids[i] = attachment['id'];
          console.log( attachment );
          i++;
      });
      */
    }).open();
  });
  /*
  * Remove image event
  */

  $('body').on('click', '.portfolio_remove_image_button', function (e) {
    e.preventDefault();
    $(this).hide().prev().val('').prev().addClass('button').html('Upload image');
    return true;
  });
});

/***/ }),

/***/ 4:
/*!*********************************************************!*\
  !*** multi ./assets/src/scripts/portfoliologoupload.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\maccX.dev\wp-content\plugins\seedwps-plugin\assets\src\scripts\portfoliologoupload.js */"./assets/src/scripts/portfoliologoupload.js");


/***/ })

/******/ });