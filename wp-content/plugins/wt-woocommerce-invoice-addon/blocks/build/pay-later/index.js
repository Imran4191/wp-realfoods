/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/pay-later/index.js":
/*!********************************!*\
  !*** ./src/pay-later/index.js ***!
  \********************************/
/***/ (() => {

eval("const settings = window.wc.wcSettings.getSetting('wf_pay_later_data', {});\nconst label = window.wp.htmlEntities.decodeEntities(settings.title) || window.wp.i18n.__('Pay later', 'wf_pay_later');\nconst Content = () => {\n  return window.wp.htmlEntities.decodeEntities(settings.description || '');\n};\nconst Block_Gateway = {\n  name: 'wf_pay_later',\n  label: label,\n  content: Object(window.wp.element.createElement)(Content, null),\n  edit: Object(window.wp.element.createElement)(Content, null),\n  canMakePayment: () => true,\n  ariaLabel: label,\n  supports: {\n    features: settings.supports\n  }\n};\nwindow.wc.wcBlocksRegistry.registerPaymentMethod(Block_Gateway);\n\n//# sourceURL=webpack://wt-pdf-blocks/./src/pay-later/index.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/pay-later/index.js"]();
/******/ 	
/******/ })()
;