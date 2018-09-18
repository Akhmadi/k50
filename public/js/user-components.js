webpackJsonp([1],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/dashboard/student-editpanel.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'student-editpanel',
    props: ['options', 'crud', 'item'],
    data: function data() {
        return {};
    },
    computed: {
        printUrl: function printUrl() {
            return App.baseUrl + '/student/print/' + (this.item ? this.item.id : '');
        }
    }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/dashboard/students.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'students',
    props: ['options'],
    data: function data() {
        return {
            program: null,
            loading: false
        };
    },
    computed: {},
    methods: {
        removeStudent: function removeStudent(student) {
            this.program.students = _.filter(this.program.students, function (s) {
                return s.id !== student.id;
            });
        },
        approveStudent: function approveStudent(student) {
            var _this = this;

            this.loading = true;
            axios.post(App.baseUrl + '/api/students/approve', { student: student }).then(function () {
                AdminManager.showSuccess('\u0421\u0442\u0443\u0434\u0435\u043D\u0442 ' + student.name + ' \u043F\u043E\u0434\u0432\u0435\u0440\u0436\u0434\u0435\u043D');
                _this.removeStudent(student);
                _this.loading = false;
            }).catch(function (err) {
                AdminManager.showError('Ошибка действия');
                console.log(err);
                _this.loading = false;
            });
        },
        rejectStudent: function rejectStudent(student) {
            var _this2 = this;

            this.loading = true;
            axios.post(App.baseUrl + '/api/students/reject', { student: student }).then(function () {
                AdminManager.showSuccess('\u0421\u0442\u0443\u0434\u0435\u043D\u0442 ' + student.name + ' \u0443\u0434\u0430\u043B\u0435\u043D');
                _this2.removeStudent(student);
                _this2.loading = false;
            }).catch(function (err) {
                AdminManager.showError('Ошибка действия');
                console.log(err);
                _this2.loading = false;
            });
        },
        getProgram: function getProgram() {
            var _this3 = this;

            this.loading = true;
            axios.get(App.baseUrl + '/api/students').then(function (res) {

                res.data.program.students = _.map(res.data.program.students, function (s) {

                    s.meta = JSON.parse(s.meta);

                    s.printUrl = App.baseUrl + '/student/print/' + s.id;

                    s.meta.files = s.meta.files ? _.map(JSON.parse(s.meta.files), function (f) {
                        return App.baseUrl + f;
                    }) : [];

                    return s;
                });

                _this3.program = res.data.program;

                _this3.loading = false;
            }).catch(function (err) {
                AdminManager.showError('Ошибка загрузки списка');
                console.log(err);
                _this3.loading = false;
            });
        }
    },
    beforeMount: function beforeMount() {
        this.getProgram();
    }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/component-normalizer.js":
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0889d6e5\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/dashboard/students.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-layout",
    { attrs: { column: "", "fill-height": "", "justify-start": "" } },
    [
      _c(
        "v-flex",
        { staticClass: "layout align-center" },
        [
          _c("p", { staticClass: "title" }, [
            _vm._v("Программа " + _vm._s(_vm.program ? _vm.program.title : ""))
          ]),
          _vm._v(" "),
          _c("v-spacer"),
          _vm._v(" "),
          _c(
            "v-btn",
            {
              attrs: {
                disabled: _vm.loading,
                color: "accent",
                flat: "",
                loading: _vm.loading
              },
              on: { click: _vm.getProgram }
            },
            [_vm._v("\n            Обновить список\n        ")]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-flex",
        {
          staticStyle: { position: "relative" },
          attrs: { xs12: "", "fill-height": "" }
        },
        [
          _c(
            "div",
            { staticClass: "scroll-container layout row wrap align-start" },
            [
              _c(
                "v-flex",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value:
                        _vm.program &&
                        _vm.program.students.length === 0 &&
                        !_vm.loading,
                      expression:
                        "program && program.students.length === 0 && !loading"
                    }
                  ],
                  attrs: { xs12: "" }
                },
                [_c("v-subheading", [_vm._v("Список пуст")])],
                1
              ),
              _vm._v(" "),
              _vm.program
                ? _c(
                    "v-flex",
                    { staticClass: "layout row wrap", attrs: { xs12: "" } },
                    _vm._l(_vm.program.students, function(student) {
                      return _c(
                        "v-flex",
                        {
                          key: student.id,
                          staticClass: "px-1 py-1",
                          attrs: { xs12: "", md3: "" }
                        },
                        [
                          _c(
                            "v-card",
                            [
                              _c("v-card-title", [
                                _vm._v(
                                  "\n                            " +
                                    _vm._s(student.name) +
                                    "\n                        "
                                )
                              ]),
                              _vm._v(" "),
                              _c(
                                "v-card-actions",
                                [
                                  _c(
                                    "v-menu",
                                    { attrs: { "offset-y": "" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            slot: "activator",
                                            disabled: _vm.loading,
                                            icon: ""
                                          },
                                          slot: "activator"
                                        },
                                        [
                                          _c(
                                            "v-icon",
                                            { attrs: { color: "accent" } },
                                            [_vm._v("more_vert")]
                                          )
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c(
                                        "v-list",
                                        [
                                          _c(
                                            "v-list-tile",
                                            [
                                              _c("v-list-tile-title", [
                                                _c(
                                                  "a",
                                                  {
                                                    attrs: {
                                                      href: student.printUrl,
                                                      target: "_blank"
                                                    }
                                                  },
                                                  [_vm._v("Печать анкеты")]
                                                )
                                              ])
                                            ],
                                            1
                                          ),
                                          _vm._v(" "),
                                          _vm._l(student.meta.files, function(
                                            file,
                                            index
                                          ) {
                                            return _c(
                                              "v-list-tile",
                                              { key: file },
                                              [
                                                _c("v-list-tile-title", [
                                                  _c(
                                                    "a",
                                                    {
                                                      attrs: {
                                                        href: file,
                                                        target: "_blank",
                                                        download:
                                                          student.name +
                                                          "_file_" +
                                                          (index + 1)
                                                      }
                                                    },
                                                    [
                                                      _vm._v(
                                                        "Файл " +
                                                          _vm._s(index + 1)
                                                      )
                                                    ]
                                                  )
                                                ])
                                              ],
                                              1
                                            )
                                          })
                                        ],
                                        2
                                      )
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c("v-spacer"),
                                  _vm._v(" "),
                                  _c(
                                    "v-tooltip",
                                    { attrs: { top: "" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            slot: "activator",
                                            disabled: _vm.loading,
                                            icon: ""
                                          },
                                          on: {
                                            click: function($event) {
                                              _vm.approveStudent(student)
                                            }
                                          },
                                          slot: "activator"
                                        },
                                        [
                                          _c(
                                            "v-icon",
                                            { attrs: { color: "success" } },
                                            [_vm._v("done")]
                                          )
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c("span", [_vm._v("Подтвердить")])
                                    ],
                                    1
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-tooltip",
                                    { attrs: { top: "" } },
                                    [
                                      _c(
                                        "v-btn",
                                        {
                                          attrs: {
                                            slot: "activator",
                                            disabled: _vm.loading,
                                            icon: ""
                                          },
                                          on: {
                                            click: function($event) {
                                              _vm.rejectStudent(student)
                                            }
                                          },
                                          slot: "activator"
                                        },
                                        [
                                          _c(
                                            "v-icon",
                                            { attrs: { color: "error" } },
                                            [_vm._v("clear")]
                                          )
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _c("span", [_vm._v("Отказать")])
                                    ],
                                    1
                                  )
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ],
                        1
                      )
                    })
                  )
                : _vm._e()
            ],
            1
          )
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-0889d6e5", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5a0418ab\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/dashboard/student-editpanel.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-layout",
    { attrs: { row: "", color: "primary" } },
    [
      _c(
        "v-flex",
        { staticClass: "layout", attrs: { xs12: "" } },
        [
          _c("v-spacer"),
          _vm._v(" "),
          _c(
            "v-btn",
            {
              attrs: { href: _vm.printUrl, color: "accent", target: "_blank" }
            },
            [_vm._v("Печать анкеты")]
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5a0418ab", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/dashboard/student-editpanel.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/dashboard/student-editpanel.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-5a0418ab\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/dashboard/student-editpanel.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/dashboard/student-editpanel.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5a0418ab", Component.options)
  } else {
    hotAPI.reload("data-v-5a0418ab", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/dashboard/students.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/dashboard/students.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-0889d6e5\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/dashboard/students.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/dashboard/students.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0889d6e5", Component.options)
  } else {
    hotAPI.reload("data-v-0889d6e5", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/assets/js/dashboard/user-components.js":
/***/ (function(module, exports, __webpack_require__) {

Vue.component('students', __webpack_require__("./resources/assets/js/dashboard/students.vue"));
Vue.component('student-editpanel', __webpack_require__("./resources/assets/js/dashboard/student-editpanel.vue"));

AdminManager.registerMiddleware(function (event, options, next) {

    if (event == 'editpanel:on:mount' && options.crud.code == 'students') {

        options.addComponents([{
            id: 'student-editpanel-1',
            name: 'student-editpanel',
            options: {}
        }]);
    }

    next();
});

var userComponent = {
    id: 'students-1',
    name: 'students',
    options: {
        isModal: false
    }
};

Bus.$on('user:students:mount', function () {
    return AdminManager.mountComponent(userComponent, true);
});

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__("./resources/assets/js/dashboard/user-components.js");


/***/ })

},[2]);