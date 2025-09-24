/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/wt-initial-load/frontend.js":
/*!*****************************************************!*\
  !*** ./src/wt-initial-load/frontend.js + 3 modules ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("// ESM COMPAT FLAG\n__webpack_require__.r(__webpack_exports__);\n\n;// CONCATENATED MODULE: ./src/wt-initial-load/block.json\nconst block_namespaceObject = JSON.parse('{\"$schema\":\"https://schemas.wp.org/trunk/block.json\",\"apiVersion\":2,\"name\":\"wt-pdf-blocks/wt-initial-load\",\"version\":\"1.0.0\",\"title\":\"\",\"category\":\"woocommerce\",\"parent\":[\"woocommerce/checkout-fields-block\"],\"attributes\":{\"lock\":{\"type\":\"object\",\"default\":{\"remove\":true,\"move\":true}}},\"textdomain\":\"wt_woocommerce_invoice_addon\",\"editorScript\":\"file:./index.js\"}');\n;// CONCATENATED MODULE: external [\"wp\",\"i18n\"]\nconst external_wp_i18n_namespaceObject = window[\"wp\"][\"i18n\"];\n;// CONCATENATED MODULE: external [\"wp\",\"element\"]\nconst external_wp_element_namespaceObject = window[\"wp\"][\"element\"];\n;// CONCATENATED MODULE: ./src/wt-initial-load/frontend.js\n\n\n\nconst {\n  registerCheckoutBlock\n} = wc.blocksCheckout;\nconst Block = ({\n  children,\n  checkoutExtensionData\n}) => {\n  const [attributes, setAttributes] = (0,external_wp_element_namespaceObject.useState)();\n  const {\n    setExtensionData\n  } = checkoutExtensionData;\n  (0,external_wp_element_namespaceObject.useEffect)(() => {\n    setExtensionData('wt_pdf_blocks');\n  }, [attributes]);\n  return '';\n};\nconst frontend_option = {\n  metadata: block_namespaceObject,\n  component: Block\n};\nregisterCheckoutBlock(frontend_option);\n\n//# sourceURL=webpack://wt-pdf-blocks/./src/wt-initial-load/frontend.js_+_3_modules?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The require scope
/******/ 	var __webpack_require__ = {};
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/wt-initial-load/frontend.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;