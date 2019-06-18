(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app-views-pages-tacacs-tacacs-module"],{

/***/ "./src/app/views/pages/tacacs/tacacs.component.html":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/tacacs/tacacs.component.html ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<!-- <div class=\"row\">\n\t<div class=\"col-md-4\" *ngFor=\"let portlet of portlets\">\n    <kt-portlet [ngClass]=\"'kt-portlet--ngviewer'\">\n    \t<kt-portlet-header [title]=\"portlet.title\" [icon]=\"portlet.icon\">\n    \t</kt-portlet-header>\n    \t<kt-portlet-body>\n        <div class=\"kt-section\">\n          <div class=\"kt-section__content text-center\">\n            <a [routerLink]=\"portlet.list\"> <img [src]=\"portlet.image\" style=\"width:50%\"></a>\n          <hr>\n            <a [routerLink]=\"portlet.list\" class=\"btn btn-warning btn-elevate btn-elevate-air\" *ngIf=\"portlet.list\">View List</a>&nbsp;\n            <a [routerLink]=\"portlet.add\" class=\"btn btn-success btn-elevate btn-elevate-air\" *ngIf=\"portlet.add\">Add New</a>\n          </div>\n        </div>\n    \t</kt-portlet-body>\n    </kt-portlet>\n  </div>\n</div> -->\n<div class=\"row\">\n\t<div class=\"col-md-3 col-sm-6\" *ngFor=\"let card of cards\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">{{card.title}}</h5>\n        <!-- <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6> -->\n        <div class=\"text-center\">\n          <p class=\"card-text\">\n            <a [routerLink]=\"card.list\">\n              <span style=\"font-size: 5em;\" [ngStyle]=\"{'color': card.icon_color}\">\n                <i class=\"{{card.icon}}\"></i>\n              </span>\n            </a>\n          </p>\n        </div>\n        <hr>\n        <div class=\"text-center\">\n          <a [routerLink]=\"card.list\" class=\"btn btn-warning btn-elevate btn-elevate-air\" *ngIf=\"card.list\">View</a>&nbsp;\n          <a [routerLink]=\"card.add\" class=\"btn btn-success btn-elevate btn-elevate-air\" *ngIf=\"card.add\">Add New</a>&nbsp;\n        </div>\n      </div>\n    </div>\n    <br>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/tacacs.component.scss":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/tacacs/tacacs.component.scss ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy90YWNhY3MuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/tacacs.component.ts":
/*!********************************************************!*\
  !*** ./src/app/views/pages/tacacs/tacacs.component.ts ***!
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
var TacacsComponent = /** @class */ (function () {
    function TacacsComponent() {
        this.cards = [
            {
                title: 'Tacacs Users',
                icon: 'fa fa-user',
                // image:'./assets/media/tacacs/user.png',
                list: 'users',
                add: 'users/add',
            },
            {
                title: 'Tacacs User Groups',
                icon: 'fa fa-users',
                // image:'./assets/media/tacacs/user_group.png',
                list: 'user-groups',
                add: 'user-groups/add',
            },
            {
                title: 'Tacacs Devices',
                icon: 'fa fa-hdd',
                // image:'./assets/media/tacacs/dev_r_big.png',
                list: 'devices',
                add: 'devices/add',
            },
            {
                title: 'Tacacs Device Groups',
                icon: 'fa fa-server',
                // image:'./assets/media/tacacs/dev_group.png',
                list: 'dev-groups',
                add: 'dev-groups/add',
            },
            {
                title: 'Services',
                icon: 'fa fa-user-shield',
                // image:'./assets/media/tacacs/service.png',
                list: 'access-control/services',
                add: 'access-control/services/add',
            },
            {
                title: 'ACL',
                icon: 'fa fa fa-user-times',
                // image:'./assets/media/tacacs/acl.png',
                list: 'access-control/acl',
                add: 'access-control/acl/add',
            },
        ];
    }
    TacacsComponent.prototype.ngOnInit = function () {
    };
    TacacsComponent = __decorate([
        core_1.Component({
            selector: 'kt-tacacs',
            template: __webpack_require__(/*! ./tacacs.component.html */ "./src/app/views/pages/tacacs/tacacs.component.html"),
            styles: [__webpack_require__(/*! ./tacacs.component.scss */ "./src/app/views/pages/tacacs/tacacs.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], TacacsComponent);
    return TacacsComponent;
}());
exports.TacacsComponent = TacacsComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/tacacs.module.ts":
/*!*****************************************************!*\
  !*** ./src/app/views/pages/tacacs/tacacs.module.ts ***!
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
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
// Core Module
var core_module_1 = __webpack_require__(/*! ../../../core/core.module */ "./src/app/core/core.module.ts");
var partials_module_1 = __webpack_require__(/*! ../../partials/partials.module */ "./src/app/views/partials/partials.module.ts");
var portlet_module_1 = __webpack_require__(/*! ../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
// Components
var tacacs_component_1 = __webpack_require__(/*! ./tacacs.component */ "./src/app/views/pages/tacacs/tacacs.component.ts");
var TacacsModule = /** @class */ (function () {
    function TacacsModule() {
    }
    TacacsModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule,
                partials_module_1.PartialsModule,
                core_module_1.CoreModule,
                portlet_module_1.PortletModule,
                ng_bootstrap_1.NgbModule,
                forms_1.FormsModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: tacacs_component_1.TacacsComponent
                    },
                    {
                        path: 'devices',
                        loadChildren: './devices/devices.module#DevicesModule'
                    },
                    {
                        path: 'dev-groups',
                        loadChildren: './dev-groups/dev-groups.module#DevGroupsModule'
                    },
                    {
                        path: 'users',
                        loadChildren: './users/users.module#UsersModule'
                    },
                    {
                        path: 'user-groups',
                        loadChildren: './user-groups/user-groups.module#UserGroupsModule'
                    },
                    {
                        path: 'access-control',
                        loadChildren: './access-control/access-control.module#AccessControlModule'
                    },
                    {
                        path: 'config',
                        loadChildren: './config/config.module#ConfigModule'
                    },
                    {
                        path: 'objects',
                        loadChildren: './objects/objects.module#ObjectsModule'
                    },
                ]),
            ],
            providers: [],
            declarations: [
                tacacs_component_1.TacacsComponent,
            ]
        })
    ], TacacsModule);
    return TacacsModule;
}());
exports.TacacsModule = TacacsModule;


/***/ })

}]);
//# sourceMappingURL=app-views-pages-tacacs-tacacs-module.f15a9db6b4dcb0f4e762.js.map