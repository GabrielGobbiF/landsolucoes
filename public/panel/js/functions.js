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

/***/ "./resources/assets/lib/js/functions.js":
/*!**********************************************!*\
  !*** ./resources/assets/lib/js/functions.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("(function ($) {\n  console.log('init global functions');\n  $('.btn-delete').on('click', function () {\n    var href = $(this).attr('data-href');\n    var text = $(this).attr('data-title');\n\n    if (text != null) {\n      $('.modal-title').html(text);\n      $('.btn-danger').html(text);\n      $('.modal-text-body').html('Tem certeza que deseja ' + text + '?');\n    }\n\n    $('#form-delete').attr('action', href);\n    $('#modal-delete').modal('show');\n  });\n  $('.btn-submit').on('click', function () {\n    var text = $(this).attr('data-btn-text');\n    text = text != null ? text : 'Salvando...';\n    $(this).html(\"<i class='fa fa-spinner fa-spin'></i> \" + text);\n    $(this).prop('disabled', true);\n    $(this).closest(\"form\").submit();\n  });\n  $('.select2').select2({\n    width: '100%'\n  });\n  $('.date').mask('00/00/0000');\n  $('.money').mask('000.000.000.000.000,00', {\n    reverse: true\n  });\n  $('.rg').mask('00000000-0');\n  $('[data-toggle=\"tooltip\"]').tooltip();\n  $('.date_time').mask('00/00/0000 00:00');\n  $('.game_type').mask('0v0');\n  $('.phone').mask('(00)  0000-0000');\n\n  var SPMaskBehavior = function SPMaskBehavior(val) {\n    return val.replace(/\\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';\n  },\n      spOptions = {\n    onKeyPress: function onKeyPress(val, e, field, options) {\n      field.mask(SPMaskBehavior.apply({}, arguments), options);\n    }\n  };\n\n  $('.sp_celphones').mask(SPMaskBehavior, spOptions);\n})(jQuery);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2xpYi9qcy9mdW5jdGlvbnMuanM/MjM0OCJdLCJuYW1lcyI6WyIkIiwiY29uc29sZSIsImxvZyIsIm9uIiwiaHJlZiIsImF0dHIiLCJ0ZXh0IiwiaHRtbCIsIm1vZGFsIiwicHJvcCIsImNsb3Nlc3QiLCJzdWJtaXQiLCJzZWxlY3QyIiwid2lkdGgiLCJtYXNrIiwicmV2ZXJzZSIsInRvb2x0aXAiLCJTUE1hc2tCZWhhdmlvciIsInZhbCIsInJlcGxhY2UiLCJsZW5ndGgiLCJzcE9wdGlvbnMiLCJvbktleVByZXNzIiwiZSIsImZpZWxkIiwib3B0aW9ucyIsImFwcGx5IiwiYXJndW1lbnRzIiwialF1ZXJ5Il0sIm1hcHBpbmdzIjoiQUFDQSxDQUFDLFVBQVVBLENBQVYsRUFBYTtBQUVWQyxTQUFPLENBQUNDLEdBQVIsQ0FBWSx1QkFBWjtBQUVBRixHQUFDLENBQUMsYUFBRCxDQUFELENBQWlCRyxFQUFqQixDQUFvQixPQUFwQixFQUE2QixZQUFZO0FBQ3JDLFFBQUlDLElBQUksR0FBR0osQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRSyxJQUFSLENBQWEsV0FBYixDQUFYO0FBQ0EsUUFBSUMsSUFBSSxHQUFHTixDQUFDLENBQUMsSUFBRCxDQUFELENBQVFLLElBQVIsQ0FBYSxZQUFiLENBQVg7O0FBQ0EsUUFBSUMsSUFBSSxJQUFJLElBQVosRUFBa0I7QUFDZE4sT0FBQyxDQUFDLGNBQUQsQ0FBRCxDQUFrQk8sSUFBbEIsQ0FBdUJELElBQXZCO0FBQ0FOLE9BQUMsQ0FBQyxhQUFELENBQUQsQ0FBaUJPLElBQWpCLENBQXNCRCxJQUF0QjtBQUNBTixPQUFDLENBQUMsa0JBQUQsQ0FBRCxDQUFzQk8sSUFBdEIsQ0FBMkIsNEJBQTRCRCxJQUE1QixHQUFtQyxHQUE5RDtBQUNIOztBQUNETixLQUFDLENBQUMsY0FBRCxDQUFELENBQWtCSyxJQUFsQixDQUF1QixRQUF2QixFQUFpQ0QsSUFBakM7QUFDQUosS0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQlEsS0FBbkIsQ0FBeUIsTUFBekI7QUFDSCxHQVZEO0FBWUFSLEdBQUMsQ0FBQyxhQUFELENBQUQsQ0FBaUJHLEVBQWpCLENBQW9CLE9BQXBCLEVBQTZCLFlBQVk7QUFDckMsUUFBSUcsSUFBSSxHQUFHTixDQUFDLENBQUMsSUFBRCxDQUFELENBQVFLLElBQVIsQ0FBYSxlQUFiLENBQVg7QUFDQUMsUUFBSSxHQUFHQSxJQUFJLElBQUksSUFBUixHQUFlQSxJQUFmLEdBQXNCLGFBQTdCO0FBQ0FOLEtBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUU8sSUFBUixDQUFhLDJDQUEyQ0QsSUFBeEQ7QUFDQU4sS0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRUyxJQUFSLENBQWEsVUFBYixFQUF5QixJQUF6QjtBQUNBVCxLQUFDLENBQUMsSUFBRCxDQUFELENBQVFVLE9BQVIsQ0FBZ0IsTUFBaEIsRUFBd0JDLE1BQXhCO0FBQ0gsR0FORDtBQVFBWCxHQUFDLENBQUMsVUFBRCxDQUFELENBQWNZLE9BQWQsQ0FBc0I7QUFDbEJDLFNBQUssRUFBRTtBQURXLEdBQXRCO0FBSUFiLEdBQUMsQ0FBQyxPQUFELENBQUQsQ0FBV2MsSUFBWCxDQUFnQixZQUFoQjtBQUVBZCxHQUFDLENBQUMsUUFBRCxDQUFELENBQVljLElBQVosQ0FBaUIsd0JBQWpCLEVBQTJDO0FBQUVDLFdBQU8sRUFBRTtBQUFYLEdBQTNDO0FBRUFmLEdBQUMsQ0FBQyxLQUFELENBQUQsQ0FBU2MsSUFBVCxDQUFjLFlBQWQ7QUFFQWQsR0FBQyxDQUFDLHlCQUFELENBQUQsQ0FBNkJnQixPQUE3QjtBQUVBaEIsR0FBQyxDQUFDLFlBQUQsQ0FBRCxDQUFnQmMsSUFBaEIsQ0FBcUIsa0JBQXJCO0FBRUFkLEdBQUMsQ0FBQyxZQUFELENBQUQsQ0FBZ0JjLElBQWhCLENBQXFCLEtBQXJCO0FBRUFkLEdBQUMsQ0FBQyxRQUFELENBQUQsQ0FBWWMsSUFBWixDQUFpQixpQkFBakI7O0FBRUEsTUFBSUcsY0FBYyxHQUFHLFNBQWpCQSxjQUFpQixDQUFVQyxHQUFWLEVBQWU7QUFDaEMsV0FBT0EsR0FBRyxDQUFDQyxPQUFKLENBQVksS0FBWixFQUFtQixFQUFuQixFQUF1QkMsTUFBdkIsS0FBa0MsRUFBbEMsR0FBdUMsaUJBQXZDLEdBQTJELGlCQUFsRTtBQUNILEdBRkQ7QUFBQSxNQUdJQyxTQUFTLEdBQUc7QUFDUkMsY0FBVSxFQUFFLG9CQUFVSixHQUFWLEVBQWVLLENBQWYsRUFBa0JDLEtBQWxCLEVBQXlCQyxPQUF6QixFQUFrQztBQUMxQ0QsV0FBSyxDQUFDVixJQUFOLENBQVdHLGNBQWMsQ0FBQ1MsS0FBZixDQUFxQixFQUFyQixFQUF5QkMsU0FBekIsQ0FBWCxFQUFnREYsT0FBaEQ7QUFDSDtBQUhPLEdBSGhCOztBQVNBekIsR0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQmMsSUFBbkIsQ0FBd0JHLGNBQXhCLEVBQXdDSSxTQUF4QztBQUdILENBdERELEVBc0RHTyxNQXRESCIsImZpbGUiOiIuL3Jlc291cmNlcy9hc3NldHMvbGliL2pzL2Z1bmN0aW9ucy5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbIlxuKGZ1bmN0aW9uICgkKSB7XG5cbiAgICBjb25zb2xlLmxvZygnaW5pdCBnbG9iYWwgZnVuY3Rpb25zJyk7XG5cbiAgICAkKCcuYnRuLWRlbGV0ZScpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIGhyZWYgPSAkKHRoaXMpLmF0dHIoJ2RhdGEtaHJlZicpO1xuICAgICAgICB2YXIgdGV4dCA9ICQodGhpcykuYXR0cignZGF0YS10aXRsZScpXG4gICAgICAgIGlmICh0ZXh0ICE9IG51bGwpIHtcbiAgICAgICAgICAgICQoJy5tb2RhbC10aXRsZScpLmh0bWwodGV4dCk7XG4gICAgICAgICAgICAkKCcuYnRuLWRhbmdlcicpLmh0bWwodGV4dCk7XG4gICAgICAgICAgICAkKCcubW9kYWwtdGV4dC1ib2R5JykuaHRtbCgnVGVtIGNlcnRlemEgcXVlIGRlc2VqYSAnICsgdGV4dCArICc/Jyk7XG4gICAgICAgIH1cbiAgICAgICAgJCgnI2Zvcm0tZGVsZXRlJykuYXR0cignYWN0aW9uJywgaHJlZilcbiAgICAgICAgJCgnI21vZGFsLWRlbGV0ZScpLm1vZGFsKCdzaG93Jyk7XG4gICAgfSk7XG5cbiAgICAkKCcuYnRuLXN1Ym1pdCcpLm9uKCdjbGljaycsIGZ1bmN0aW9uICgpIHtcbiAgICAgICAgdmFyIHRleHQgPSAkKHRoaXMpLmF0dHIoJ2RhdGEtYnRuLXRleHQnKTtcbiAgICAgICAgdGV4dCA9IHRleHQgIT0gbnVsbCA/IHRleHQgOiAnU2FsdmFuZG8uLi4nO1xuICAgICAgICAkKHRoaXMpLmh0bWwoXCI8aSBjbGFzcz0nZmEgZmEtc3Bpbm5lciBmYS1zcGluJz48L2k+IFwiICsgdGV4dClcbiAgICAgICAgJCh0aGlzKS5wcm9wKCdkaXNhYmxlZCcsIHRydWUpO1xuICAgICAgICAkKHRoaXMpLmNsb3Nlc3QoXCJmb3JtXCIpLnN1Ym1pdCgpO1xuICAgIH0pO1xuXG4gICAgJCgnLnNlbGVjdDInKS5zZWxlY3QyKHtcbiAgICAgICAgd2lkdGg6ICcxMDAlJ1xuICAgIH0pO1xuXG4gICAgJCgnLmRhdGUnKS5tYXNrKCcwMC8wMC8wMDAwJyk7XG5cbiAgICAkKCcubW9uZXknKS5tYXNrKCcwMDAuMDAwLjAwMC4wMDAuMDAwLDAwJywgeyByZXZlcnNlOiB0cnVlIH0pO1xuXG4gICAgJCgnLnJnJykubWFzaygnMDAwMDAwMDAtMCcpO1xuXG4gICAgJCgnW2RhdGEtdG9nZ2xlPVwidG9vbHRpcFwiXScpLnRvb2x0aXAoKVxuXG4gICAgJCgnLmRhdGVfdGltZScpLm1hc2soJzAwLzAwLzAwMDAgMDA6MDAnKTtcblxuICAgICQoJy5nYW1lX3R5cGUnKS5tYXNrKCcwdjAnKTtcblxuICAgICQoJy5waG9uZScpLm1hc2soJygwMCkgIDAwMDAtMDAwMCcpO1xuXG4gICAgdmFyIFNQTWFza0JlaGF2aW9yID0gZnVuY3Rpb24gKHZhbCkge1xuICAgICAgICByZXR1cm4gdmFsLnJlcGxhY2UoL1xcRC9nLCAnJykubGVuZ3RoID09PSAxMSA/ICcoMDApIDAwMDAwLTAwMDAnIDogJygwMCkgMDAwMC0wMDAwOSc7XG4gICAgfSxcbiAgICAgICAgc3BPcHRpb25zID0ge1xuICAgICAgICAgICAgb25LZXlQcmVzczogZnVuY3Rpb24gKHZhbCwgZSwgZmllbGQsIG9wdGlvbnMpIHtcbiAgICAgICAgICAgICAgICBmaWVsZC5tYXNrKFNQTWFza0JlaGF2aW9yLmFwcGx5KHt9LCBhcmd1bWVudHMpLCBvcHRpb25zKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfTtcblxuICAgICQoJy5zcF9jZWxwaG9uZXMnKS5tYXNrKFNQTWFza0JlaGF2aW9yLCBzcE9wdGlvbnMpO1xuXG5cbn0pKGpRdWVyeSlcblxuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/assets/lib/js/functions.js\n");

/***/ }),

/***/ 1:
/*!****************************************************!*\
  !*** multi ./resources/assets/lib/js/functions.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\__Wamp\htdocs\Projetos\Trabalho\Landsolucoes\app_land\resources\assets\lib\js\functions.js */"./resources/assets/lib/js/functions.js");


/***/ })

/******/ });