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

/***/ "./src/custom-fields/frontend.js":
/*!***************************************************!*\
  !*** ./src/custom-fields/frontend.js + 6 modules ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("// ESM COMPAT FLAG\n__webpack_require__.r(__webpack_exports__);\n\n;// CONCATENATED MODULE: external \"React\"\nconst external_React_namespaceObject = window[\"React\"];\n;// CONCATENATED MODULE: ./src/custom-fields/block.json\nconst block_namespaceObject = JSON.parse('{\"$schema\":\"https://schemas.wp.org/trunk/block.json\",\"apiVersion\":2,\"name\":\"wt-pdf-blocks/custom-fields\",\"version\":\"1.0.0\",\"title\":\"Invoice Custom fileds\",\"category\":\"woocommerce\",\"parent\":[\"woocommerce/checkout-billing-address-block\"],\"attributes\":{\"lock\":{\"type\":\"object\",\"default\":{\"remove\":true,\"move\":true}}},\"textdomain\":\"wt_woocommerce_invoice_addon\",\"editorScript\":\"file:./index.js\"}');\n;// CONCATENATED MODULE: external [\"wp\",\"i18n\"]\nconst external_wp_i18n_namespaceObject = window[\"wp\"][\"i18n\"];\n;// CONCATENATED MODULE: external [\"wp\",\"element\"]\nconst external_wp_element_namespaceObject = window[\"wp\"][\"element\"];\n;// CONCATENATED MODULE: external [\"wc\",\"blocksCheckout\"]\nconst external_wc_blocksCheckout_namespaceObject = window[\"wc\"][\"blocksCheckout\"];\n;// CONCATENATED MODULE: ./src/custom-fields/form.tsx\n\n\n\nconst WtPdfBlocksCustomFieldsForm = ({\n  attributes,\n  setAttributes\n}) => {\n  const dataObject = wt_pdf_blocks_custom_fields_params.custom_fields_arr;\n  const parsedData = JSON.parse(dataObject);\n  const onInputChange = (0,external_wp_element_namespaceObject.useCallback)((fieldName, value) => {\n    setAttributes(prevValues => ({\n      ...prevValues,\n      [fieldName]: value\n    }));\n  }, [setAttributes]);\n  return Object.keys(parsedData).map((key, index) => {\n    const field = parsedData[key];\n    const {\n      name,\n      type,\n      label,\n      placeholder,\n      required,\n      class: classes\n    } = field;\n    return (0,external_React_namespaceObject.createElement)(\"div\", {\n      className: 'wt_pdf_blocks_custom_fields_elm',\n      key: index\n    }, (0,external_React_namespaceObject.createElement)(external_wc_blocksCheckout_namespaceObject.ValidatedTextInput, {\n      label: label,\n      type: type,\n      name: name,\n      id: name,\n      required: !!required,\n      className: classes ? classes.join(' ') : '',\n      onChange: e => onInputChange(name, e),\n      value: attributes[name] || ''\n    }));\n  });\n};\n;// CONCATENATED MODULE: ./src/custom-fields/frontend.js\n\n\n\n\n\nconst {\n  registerCheckoutBlock\n} = wc.blocksCheckout;\nconst Block = ({\n  children,\n  checkoutExtensionData\n}) => {\n  const wt_checkout_fields = wt_pdf_blocks_custom_fields_params.custom_fields_arr;\n  const parse_wt_checkout_fields = JSON.parse(wt_checkout_fields);\n  const initialState = Object.keys(parse_wt_checkout_fields).reduce((acc, key) => {\n    acc[key] = '';\n    return acc;\n  }, {});\n  const [attributes, setAttributes] = (0,external_wp_element_namespaceObject.useState)(JSON.stringify(initialState));\n  const {\n    setExtensionData\n  } = checkoutExtensionData;\n  if (Object.keys(parse_wt_checkout_fields).length > 0) {\n    Object.keys(parse_wt_checkout_fields).forEach((key, value) => {\n      (0,external_wp_element_namespaceObject.useEffect)(() => {\n        setExtensionData('wt_pdf_blocks', key, attributes[key]);\n      }, [attributes]);\n    });\n  }\n  return (0,external_React_namespaceObject.createElement)(\"div\", {\n    className: 'wt_pdf_blocks_custom_fields_wrap'\n  }, (0,external_React_namespaceObject.createElement)(WtPdfBlocksCustomFieldsForm, {\n    attributes: attributes,\n    setAttributes: setAttributes\n  }));\n};\nconst frontend_option = {\n  metadata: block_namespaceObject,\n  component: Block\n};\nregisterCheckoutBlock(frontend_option);\n\n//# sourceURL=webpack://wt-pdf-blocks/./src/custom-fields/frontend.js_+_6_modules?");

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
/******/ 	__webpack_modules__["./src/custom-fields/frontend.js"](0, __webpack_exports__, __webpack_require__);
/******/ 	
/******/ })()
;