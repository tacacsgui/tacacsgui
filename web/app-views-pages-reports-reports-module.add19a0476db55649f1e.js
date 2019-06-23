(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app-views-pages-reports-reports-module"],{

/***/ "./src/app/views/pages/reports/acc/acc.component.html":
/*!************************************************************!*\
  !*** ./src/app/views/pages/reports/acc/acc.component.html ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/reports/acc/acc.component.scss":
/*!************************************************************!*\
  !*** ./src/app/views/pages/reports/acc/acc.component.scss ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3JlcG9ydHMvYWNjL2FjYy5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/reports/acc/acc.component.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/reports/acc/acc.component.ts ***!
  \**********************************************************/
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
var AccComponent = /** @class */ (function () {
    function AccComponent() {
        this.tableOptions = {
            table: {
                selectable: false,
                preview: false,
                pagination: {
                    enable: true,
                    perpageItems: [30, 50, 100],
                    total: false
                },
                mainUrl: '/tacacs/reports/accounting/datatables/',
                sort: {
                    column: 'date',
                    direction: 'desc'
                },
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    date: { title: 'Date', show: true, sortable: true },
                    server: { title: 'Server', show: true, sortable: true },
                    nas: { title: 'Nas', show: true, sortable: true },
                    username: { title: 'Username', show: true, sortable: true },
                    'priv-lvl': { title: 'Privilege', show: false, sortable: false },
                    nac: { title: 'Nac', show: true, sortable: true },
                    line: { title: 'Line', show: false, sortable: true },
                    action: { title: 'Action', show: true, sortable: true },
                    cmd: { title: 'Command', show: true, sortable: true },
                    task_id: { title: 'Task id', show: false, sortable: true },
                    service: { title: 'Service', show: false, sortable: true },
                    stop_time: { title: 'Stop Time', show: false, sortable: true },
                    unknown: { title: 'Unknown', show: false, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: false,
                },
                filter: {
                    enable: false
                },
                actions: {
                    enable: false,
                    options: []
                },
                moreColumns: {
                    enable: true
                }
            },
            sfilter: {
                filters: [
                    { title: 'Date', type: 'date', queryName: 'date' },
                    { title: 'NAC (Client IP)', type: 'string', queryName: 'nac' },
                    { title: 'NAS (Device IP)', type: 'string', queryName: 'nas' },
                    { title: 'Username', type: 'string', queryName: 'username' },
                    { title: 'Command', type: 'string', queryName: 'cmd' },
                    { title: 'Action', type: 'string', queryName: 'action' },
                ]
            }
        };
    }
    AccComponent.prototype.ngOnInit = function () {
    };
    AccComponent = __decorate([
        core_1.Component({
            selector: 'kt-acc',
            template: __webpack_require__(/*! ./acc.component.html */ "./src/app/views/pages/reports/acc/acc.component.html"),
            styles: [__webpack_require__(/*! ./acc.component.scss */ "./src/app/views/pages/reports/acc/acc.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], AccComponent);
    return AccComponent;
}());
exports.AccComponent = AccComponent;


/***/ }),

/***/ "./src/app/views/pages/reports/api/api.component.html":
/*!************************************************************!*\
  !*** ./src/app/views/pages/reports/api/api.component.html ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/reports/api/api.component.scss":
/*!************************************************************!*\
  !*** ./src/app/views/pages/reports/api/api.component.scss ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3JlcG9ydHMvYXBpL2FwaS5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/reports/api/api.component.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/reports/api/api.component.ts ***!
  \**********************************************************/
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
var ApiComponent = /** @class */ (function () {
    function ApiComponent() {
        this.tableOptions = {
            table: {
                selectable: false,
                preview: false,
                pagination: {
                    enable: true,
                    perpageItems: [30, 50, 100],
                    total: false
                },
                mainUrl: '/logging/datatables/',
                sort: {
                    column: 'created_at',
                    direction: 'desc'
                },
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    created_at: { title: 'Date', show: true, sortable: true },
                    username: { title: 'Username', show: true, sortable: true },
                    uid: { title: 'UserID', show: false, sortable: true },
                    user_ip: { title: 'IP Address', show: true, sortable: true },
                    section: { title: 'Section', show: true, sortable: true },
                    obj_name: { title: 'Object Name', show: true, sortable: true },
                    obj_id: { title: 'Object ID', show: false, sortable: true },
                    action: { title: 'Action', show: true, sortable: true },
                    message: { title: 'Message', show: true, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: false,
                },
                filter: {
                    enable: true
                },
                actions: {
                    enable: false,
                    options: []
                },
                moreColumns: {
                    enable: true
                }
            },
        };
    }
    ApiComponent.prototype.ngOnInit = function () {
    };
    ApiComponent = __decorate([
        core_1.Component({
            selector: 'kt-api',
            template: __webpack_require__(/*! ./api.component.html */ "./src/app/views/pages/reports/api/api.component.html"),
            styles: [__webpack_require__(/*! ./api.component.scss */ "./src/app/views/pages/reports/api/api.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], ApiComponent);
    return ApiComponent;
}());
exports.ApiComponent = ApiComponent;


/***/ }),

/***/ "./src/app/views/pages/reports/authe/authe.component.html":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/reports/authe/authe.component.html ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/reports/authe/authe.component.scss":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/reports/authe/authe.component.scss ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3JlcG9ydHMvYXV0aGUvYXV0aGUuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/reports/authe/authe.component.ts":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/reports/authe/authe.component.ts ***!
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
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var AutheComponent = /** @class */ (function () {
    function AutheComponent() {
        this.tableOptions = {
            table: {
                selectable: false,
                preview: false,
                pagination: {
                    enable: true,
                    perpageItems: [30, 50, 100],
                    total: false
                },
                mainUrl: '/tacacs/reports/authentication/datatables/',
                sort: {
                    column: 'date',
                    direction: 'desc'
                },
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    date: { title: 'Date', show: true, sortable: true },
                    server: { title: 'Server', show: true, sortable: true },
                    nas: { title: 'Nas', show: true, sortable: true },
                    username: { title: 'Username', show: true, sortable: true },
                    nac: { title: 'Nac', show: true, sortable: true },
                    line: { title: 'Line', show: false, sortable: true },
                    action: { title: 'Action', show: true, sortable: true },
                    unknown: { title: 'Unknown', show: false, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: false,
                },
                filter: {
                    enable: false
                },
                actions: {
                    enable: false,
                    options: []
                },
                moreColumns: {
                    enable: true
                }
            },
            sfilter: {
                filters: [
                    { title: 'Date', type: 'date', queryName: 'date' },
                    { title: 'NAC (Client IP)', type: 'string', queryName: 'nac' },
                    { title: 'NAS (Device IP)', type: 'string', queryName: 'nas' },
                    { title: 'Username', type: 'string', queryName: 'username' },
                    { title: 'Action', type: 'string', queryName: 'action' },
                ]
            }
        };
    }
    AutheComponent.prototype.ngOnInit = function () {
    };
    AutheComponent = __decorate([
        core_1.Component({
            selector: 'kt-authe',
            template: __webpack_require__(/*! ./authe.component.html */ "./src/app/views/pages/reports/authe/authe.component.html"),
            styles: [__webpack_require__(/*! ./authe.component.scss */ "./src/app/views/pages/reports/authe/authe.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], AutheComponent);
    return AutheComponent;
}());
exports.AutheComponent = AutheComponent;


/***/ }),

/***/ "./src/app/views/pages/reports/autho/autho.component.html":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/reports/autho/autho.component.html ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/reports/autho/autho.component.scss":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/reports/autho/autho.component.scss ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3JlcG9ydHMvYXV0aG8vYXV0aG8uY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/reports/autho/autho.component.ts":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/reports/autho/autho.component.ts ***!
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
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var AuthoComponent = /** @class */ (function () {
    function AuthoComponent() {
        this.tableOptions = {
            table: {
                selectable: false,
                preview: false,
                pagination: {
                    enable: true,
                    perpageItems: [30, 50, 100],
                    total: false
                },
                mainUrl: '/tacacs/reports/authorization/datatables/',
                sort: {
                    column: 'date',
                    direction: 'desc'
                },
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    date: { title: 'Date', show: true, sortable: true },
                    server: { title: 'Server', show: true, sortable: true },
                    nas: { title: 'Nas', show: true, sortable: true },
                    username: { title: 'Username', show: true, sortable: true },
                    nac: { title: 'Nac', show: true, sortable: true },
                    line: { title: 'Line', show: false, sortable: true },
                    action: { title: 'Action', show: true, sortable: true },
                    cmd: { title: 'Command', show: true, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: false,
                },
                filter: {
                    enable: false
                },
                actions: {
                    enable: false,
                    options: []
                },
                moreColumns: {
                    enable: true
                }
            },
            sfilter: {
                filters: [
                    { title: 'Date', type: 'date', queryName: 'date' },
                    { title: 'NAC (Client IP)', type: 'string', queryName: 'nac' },
                    { title: 'NAS (Device IP)', type: 'string', queryName: 'nas' },
                    { title: 'Username', type: 'string', queryName: 'username' },
                    { title: 'Command', type: 'string', queryName: 'cmd' },
                    { title: 'Action', type: 'string', queryName: 'action' },
                ]
            }
        };
    }
    AuthoComponent.prototype.ngOnInit = function () {
    };
    AuthoComponent = __decorate([
        core_1.Component({
            selector: 'kt-autho',
            template: __webpack_require__(/*! ./autho.component.html */ "./src/app/views/pages/reports/autho/autho.component.html"),
            styles: [__webpack_require__(/*! ./autho.component.scss */ "./src/app/views/pages/reports/autho/autho.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], AuthoComponent);
    return AuthoComponent;
}());
exports.AuthoComponent = AuthoComponent;


/***/ }),

/***/ "./src/app/views/pages/reports/cm/cm.component.html":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/reports/cm/cm.component.html ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/reports/cm/cm.component.scss":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/reports/cm/cm.component.scss ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3JlcG9ydHMvY20vY20uY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/reports/cm/cm.component.ts":
/*!********************************************************!*\
  !*** ./src/app/views/pages/reports/cm/cm.component.ts ***!
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
var CmComponent = /** @class */ (function () {
    function CmComponent() {
        this.tableOptions = {
            table: {
                selectable: false,
                preview: false,
                pagination: {
                    enable: true,
                    perpageItems: [30, 50, 100],
                    total: false
                },
                mainUrl: '/confmanager/log/datatables/',
                sort: {
                    column: 'id',
                    direction: 'desc'
                },
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    date: { title: 'Date', show: true, sortable: true },
                    device_name: { title: 'Device', show: true, sortable: true },
                    device_id: { title: 'Device ID', show: false, sortable: true },
                    query_name: { title: 'Query', show: true, sortable: true },
                    query_id: { title: 'Query ID', show: false, sortable: true },
                    path: { title: 'Path', show: true, sortable: true },
                    protocol: { title: 'Protocol', show: false, sortable: true },
                    uname: { title: 'Username', show: false, sortable: true },
                    status: { title: 'Status', show: true, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: false,
                },
                filter: {
                    enable: true
                },
                actions: {
                    enable: false,
                    options: []
                },
                moreColumns: {
                    enable: true
                }
            },
        };
    }
    CmComponent.prototype.ngOnInit = function () {
    };
    CmComponent = __decorate([
        core_1.Component({
            selector: 'kt-cm',
            template: __webpack_require__(/*! ./cm.component.html */ "./src/app/views/pages/reports/cm/cm.component.html"),
            styles: [__webpack_require__(/*! ./cm.component.scss */ "./src/app/views/pages/reports/cm/cm.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], CmComponent);
    return CmComponent;
}());
exports.CmComponent = CmComponent;


/***/ }),

/***/ "./src/app/views/pages/reports/reports.component.html":
/*!************************************************************!*\
  !*** ./src/app/views/pages/reports/reports.component.html ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n\t<div class=\"col-md-3 col-sm-6\" *ngFor=\"let card of cards\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">{{card.title}}</h5>\n        <!-- <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6> -->\n        <div class=\"text-center\">\n          <p class=\"card-text\">\n            <a [routerLink]=\"card.list\">\n              <span style=\"font-size: 5em;\" [ngStyle]=\"{'color': card.icon_color}\">\n                <i class=\"{{card.icon}}\"></i>\n              </span>\n            </a>\n          </p>\n        </div>\n        <hr>\n        <div class=\"text-center\">\n          <a [routerLink]=\"card.list\" class=\"btn btn-warning btn-elevate btn-elevate-air\" *ngIf=\"card.list\">View</a>&nbsp;\n        </div>\n      </div>\n    </div>\n    <br>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/reports/reports.component.scss":
/*!************************************************************!*\
  !*** ./src/app/views/pages/reports/reports.component.scss ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3JlcG9ydHMvcmVwb3J0cy5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/reports/reports.component.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/reports/reports.component.ts ***!
  \**********************************************************/
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
var ReportsComponent = /** @class */ (function () {
    function ReportsComponent() {
        this.cards = [
            {
                title: 'Authentication',
                icon: 'fa fa-key',
                icon_color: '#FFD700',
                svg: 'fa-key',
                list: '/reports/authe',
            },
            {
                title: 'Authotization',
                icon: 'fa fa-user-shield',
                icon_color: '#FF6347',
                list: '/reports/autho',
            },
            {
                title: 'Accounting',
                icon: 'fa fa-search',
                icon_color: '#87CEEB',
                list: '/reports/acc',
            },
            {
                title: 'GUI Event Log',
                icon: 'fa fa-binoculars',
                icon_color: '#66CDAA',
                list: '/reports/gui',
            },
            {
                title: 'Configuration Manager Log',
                icon: 'fa fa-receipt',
                icon_color: '#FFD700',
                list: '/reports/cm',
            },
        ];
    }
    ReportsComponent.prototype.ngOnInit = function () {
    };
    ReportsComponent = __decorate([
        core_1.Component({
            selector: 'kt-reports',
            template: __webpack_require__(/*! ./reports.component.html */ "./src/app/views/pages/reports/reports.component.html"),
            styles: [__webpack_require__(/*! ./reports.component.scss */ "./src/app/views/pages/reports/reports.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], ReportsComponent);
    return ReportsComponent;
}());
exports.ReportsComponent = ReportsComponent;


/***/ }),

/***/ "./src/app/views/pages/reports/reports.module.ts":
/*!*******************************************************!*\
  !*** ./src/app/views/pages/reports/reports.module.ts ***!
  \*******************************************************/
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
var ng_inline_svg_1 = __webpack_require__(/*! ng-inline-svg */ "./node_modules/ng-inline-svg/lib/index.js");
var pages_module_1 = __webpack_require__(/*! ../pages.module */ "./src/app/views/pages/pages.module.ts");
var authe_component_1 = __webpack_require__(/*! ./authe/authe.component */ "./src/app/views/pages/reports/authe/authe.component.ts");
var autho_component_1 = __webpack_require__(/*! ./autho/autho.component */ "./src/app/views/pages/reports/autho/autho.component.ts");
var acc_component_1 = __webpack_require__(/*! ./acc/acc.component */ "./src/app/views/pages/reports/acc/acc.component.ts");
var reports_component_1 = __webpack_require__(/*! ./reports.component */ "./src/app/views/pages/reports/reports.component.ts");
var api_component_1 = __webpack_require__(/*! ./api/api.component */ "./src/app/views/pages/reports/api/api.component.ts");
var cm_component_1 = __webpack_require__(/*! ./cm/cm.component */ "./src/app/views/pages/reports/cm/cm.component.ts");
var ReportsModule = /** @class */ (function () {
    function ReportsModule() {
    }
    ReportsModule = __decorate([
        core_1.NgModule({
            declarations: [authe_component_1.AutheComponent, autho_component_1.AuthoComponent, acc_component_1.AccComponent, reports_component_1.ReportsComponent, api_component_1.ApiComponent, cm_component_1.CmComponent],
            imports: [
                common_1.CommonModule,
                pages_module_1.PagesModule,
                ng_inline_svg_1.InlineSVGModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: reports_component_1.ReportsComponent
                    },
                    {
                        path: 'authe',
                        component: authe_component_1.AutheComponent
                    },
                    {
                        path: 'autho',
                        component: autho_component_1.AuthoComponent
                    },
                    {
                        path: 'acc',
                        component: acc_component_1.AccComponent
                    },
                    {
                        path: 'gui',
                        component: api_component_1.ApiComponent
                    },
                    {
                        path: 'cm',
                        component: cm_component_1.CmComponent
                    },
                ]),
            ]
        })
    ], ReportsModule);
    return ReportsModule;
}());
exports.ReportsModule = ReportsModule;


/***/ })

}]);
//# sourceMappingURL=app-views-pages-reports-reports-module.add19a0476db55649f1e.js.map