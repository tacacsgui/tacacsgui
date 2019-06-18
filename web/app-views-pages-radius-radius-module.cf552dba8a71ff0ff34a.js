(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app-views-pages-radius-radius-module"],{

/***/ "./src/app/views/pages/radius/radius.component.html":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/radius/radius.component.html ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"alert alert-success\" role=\"alert\">\n  <div class=\"alert-text\">\n      <h4 class=\"alert-heading\">Hello my Friend!</h4>\n      <p>Yes, I also want to add that module to the project. But I need a little support to make it better.</p>\n      <p>I will very appreciate if you will drop me some buks via <a href=\"https://www.patreon.com/tacacsgui\" target=\"_blank\">Patreon</a>.</p>\n      <hr>\n      <p>Regards, Aleksey</p>\n  </div>\n</div>"

/***/ }),

/***/ "./src/app/views/pages/radius/radius.component.scss":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/radius/radius.component.scss ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3JhZGl1cy9yYWRpdXMuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/radius/radius.component.ts":
/*!********************************************************!*\
  !*** ./src/app/views/pages/radius/radius.component.ts ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var RadiusComponent = /** @class */ (function () {
    function RadiusComponent() {
    }
    RadiusComponent.prototype.ngOnInit = function () {
    };
    RadiusComponent = __decorate([
        core_1.Component({
            selector: 'kt-radius',
            template: __webpack_require__(/*! ./radius.component.html */ "./src/app/views/pages/radius/radius.component.html"),
            styles: [__webpack_require__(/*! ./radius.component.scss */ "./src/app/views/pages/radius/radius.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], RadiusComponent);
    return RadiusComponent;
}());
exports.RadiusComponent = RadiusComponent;


/***/ }),

/***/ "./src/app/views/pages/radius/radius.module.ts":
/*!*****************************************************!*\
  !*** ./src/app/views/pages/radius/radius.module.ts ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var radius_component_1 = __webpack_require__(/*! ./radius.component */ "./src/app/views/pages/radius/radius.component.ts");
var RadiusModule = /** @class */ (function () {
    function RadiusModule() {
    }
    RadiusModule = __decorate([
        core_1.NgModule({
            declarations: [radius_component_1.RadiusComponent],
            imports: [
                common_1.CommonModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: radius_component_1.RadiusComponent
                    },
                ]),
            ]
        })
    ], RadiusModule);
    return RadiusModule;
}());
exports.RadiusModule = RadiusModule;


/***/ })

}]);
//# sourceMappingURL=app-views-pages-radius-radius-module.cf552dba8a71ff0ff34a.js.map