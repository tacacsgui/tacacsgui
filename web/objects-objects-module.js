(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["objects-objects-module"],{

/***/ "./src/app/views/pages/tacacs/objects/objects.module.ts":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/objects.module.ts ***!
  \**************************************************************/
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
var ObjectsModule = /** @class */ (function () {
    function ObjectsModule() {
    }
    ObjectsModule = __decorate([
        core_1.NgModule({
            declarations: [],
            imports: [
                common_1.CommonModule,
                router_1.RouterModule.forChild([
                    {
                        path: 'addresses',
                        loadChildren: './addresses/addresses.module#AddressesModule'
                    },
                    {
                        path: 'commands',
                        loadChildren: './command-sets/command-sets.module#CommandSetsModule'
                    },
                ]),
            ]
        })
    ], ObjectsModule);
    return ObjectsModule;
}());
exports.ObjectsModule = ObjectsModule;


/***/ })

}]);
//# sourceMappingURL=objects-objects-module.js.map