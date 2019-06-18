(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["access-control-access-control-module"],{

/***/ "./src/app/views/pages/tacacs/access-control/access-control.component.html":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/access-control.component.html ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<p>\n  access-control works!\n</p>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/access-control.component.scss":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/access-control.component.scss ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9hY2Nlc3MtY29udHJvbC9hY2Nlc3MtY29udHJvbC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/access-control.component.ts":
/*!*******************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/access-control.component.ts ***!
  \*******************************************************************************/
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
var AccessControlComponent = /** @class */ (function () {
    function AccessControlComponent() {
    }
    AccessControlComponent.prototype.ngOnInit = function () {
    };
    AccessControlComponent = __decorate([
        core_1.Component({
            selector: 'kt-access-control',
            template: __webpack_require__(/*! ./access-control.component.html */ "./src/app/views/pages/tacacs/access-control/access-control.component.html"),
            styles: [__webpack_require__(/*! ./access-control.component.scss */ "./src/app/views/pages/tacacs/access-control/access-control.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], AccessControlComponent);
    return AccessControlComponent;
}());
exports.AccessControlComponent = AccessControlComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/access-control.module.ts":
/*!****************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/access-control.module.ts ***!
  \****************************************************************************/
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
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
var access_control_component_1 = __webpack_require__(/*! ./access-control.component */ "./src/app/views/pages/tacacs/access-control/access-control.component.ts");
var AccessControlModule = /** @class */ (function () {
    function AccessControlModule() {
    }
    AccessControlModule = __decorate([
        core_1.NgModule({
            declarations: [access_control_component_1.AccessControlComponent],
            imports: [
                common_1.CommonModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: access_control_component_1.AccessControlComponent
                    },
                    {
                        path: 'acl',
                        loadChildren: './acl/acl.module#AclModule'
                    },
                    {
                        path: 'services',
                        loadChildren: './services/services.module#ServicesModule'
                    },
                ]),
            ]
        })
    ], AccessControlModule);
    return AccessControlModule;
}());
exports.AccessControlModule = AccessControlModule;


/***/ })

}]);
//# sourceMappingURL=access-control-access-control-module.js.map