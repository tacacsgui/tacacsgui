(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["users-users-module"],{

/***/ "./src/app/views/pages/tacacs/users/add/add.component.html":
/*!*****************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/add/add.component.html ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-user-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-tac-user-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add User</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/users/add/add.component.scss":
/*!*****************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/add/add.component.scss ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "qrcode img {\n  margin: auto; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYWdlcy90YWNhY3MvdXNlcnMvYWRkL2FkZC5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLFlBQVksRUFBQSIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy91c2Vycy9hZGQvYWRkLmNvbXBvbmVudC5zY3NzIiwic291cmNlc0NvbnRlbnQiOlsicXJjb2RlIGltZyB7XHJcbiAgbWFyZ2luOiBhdXRvO1xyXG59XHJcbiJdfQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/users/add/add.component.ts":
/*!***************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/add/add.component.ts ***!
  \***************************************************************/
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
//Router
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model Device
var user_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-user-form/user.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/user.model.ts");
//Service//
var user_service_1 = __webpack_require__(/*! ../user.service */ "./src/app/views/pages/tacacs/users/user.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, usr_service, router, route) {
        this.toastr = toastr;
        this.usr_service = usr_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new user_model_1.User,
            old_data: new user_model_1.User
        };
    }
    AddComponent.prototype.ngOnInit = function () {
        this.formParameters.data.empty();
        this.formParameters.old_data.empty();
    };
    AddComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    AddComponent.prototype.add = function () {
        var _this = this;
        this.loadingForm.next(true);
        console.log(this.formParameters.data);
        var data = this.makeClone(this.formParameters.data);
        console.log(data);
        data.service = (data.service[0] && data.service[0].id) ? data.service[0].id : null;
        data.group = (data.group[0] && data.group[0].id) ? data.group.map(function (x) { return x.id; }) : null;
        data.acl = (data.acl[0] && data.acl[0].id) ? data.acl[0].id : null;
        data.device_list = (data.device_list[0] && data.device_list[0].id) ? data.device_list.map(function (x) { return x.id; }) : null;
        data.device_group_list = (data.device_group_list[0] && data.device_group_list[0].id) ? data.device_group_list.map(function (x) { return x.id; }) : null;
        if (data.valid_from && data.valid_from.year) {
            var month = (data.valid_from.month.toString().length == 2) ? data.valid_from.month.toString() : '0' + data.valid_from.month.toString();
            var day = (data.valid_from.day.toString().length == 2) ? data.valid_from.day.toString() : '0' + data.valid_from.day.toString();
            data.valid_from = data.valid_from.year + '-' + month + '-' + day;
        }
        if (data.valid_until && data.valid_until.year) {
            var month = (data.valid_until.month.toString().length == 2) ? data.valid_until.month.toString() : '0' + data.valid_until.month.toString();
            var day = (data.valid_until.day.toString().length == 2) ? data.valid_until.day.toString() : '0' + data.valid_until.day.toString();
            data.valid_until = data.valid_until.year + '-' + month + '-' + day;
        }
        // this.toastr.success('Hello world!', 'Toastr fun!');
        this.usr_service.add(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.user) {
                _this.toastr.success('User Added!');
                _this.router.navigate(['../'], { relativeTo: _this.route });
            }
            else {
                _this.toastr.error('Unknown server error');
            }
            _this.loadingForm.next(false);
        });
    };
    AddComponent = __decorate([
        core_1.Component({
            selector: 'kt-add',
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/tacacs/users/add/add.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/tacacs/users/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            user_service_1.UserService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/users/edit/edit.component.html":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/edit/edit.component.html ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-user-form [options]=\"formParameters\" [validation]=\"validation\"  [loading]=\"loadingForm\">\n</kt-tac-user-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n    [disabled]=\"(loadingForm | async)\">Edit User</button>&nbsp;\n    <a routerLink=\"../../\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/users/edit/edit.component.scss":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/edit/edit.component.scss ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy91c2Vycy9lZGl0L2VkaXQuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/users/edit/edit.component.ts":
/*!*****************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/edit/edit.component.ts ***!
  \*****************************************************************/
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
//Router
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model Device
var user_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-user-form/user.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/user.model.ts");
//Service//
var user_service_1 = __webpack_require__(/*! ../user.service */ "./src/app/views/pages/tacacs/users/user.service.ts");
var preload_service_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_fields/field-general-list/preload.service */ "./src/app/views/partials/layout/tacgui/_fields/field-general-list/preload.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, usr_service, router, route, pre) {
        this.toastr = toastr;
        this.usr_service = usr_service;
        this.router = router;
        this.route = route;
        this.pre = pre;
        this.formParameters = {
            action: 'add',
            data: new user_model_1.User,
            old_data: new user_model_1.User
        };
        // preload = new BehaviorSubject({})
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
    }
    EditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.formParameters.data.empty();
        this.formParameters.old_data.empty();
        this.route.paramMap.pipe(operators_1.first()).subscribe(function (params) {
            _this.fillForm(+params.get('id'));
        });
    };
    EditComponent.prototype.fillForm = function (id) {
        var _this = this;
        // console.log(id)
        this.usr_service.get(id).subscribe(function (data) {
            // console.log(data)
            if (!data) {
                _this.toastr.error('Server Error!');
                _this.router.navigate(['../../'], { relativeTo: _this.route });
                return;
            }
            if (!Array.isArray(data.group))
                data.group = [(data.group) ? data.group : 0];
            if (!Array.isArray(data.service))
                data.service = [(data.service) ? data.service : 0];
            if (!Array.isArray(data.acl))
                data.acl = [(data.acl) ? data.acl : 0];
            if (!Array.isArray(data.device_list))
                data.device_list = [(data.device_list) ? data.device_list : 0];
            if (!Array.isArray(data.device_group_list))
                data.device_group_list = [(data.device_group_list) ? data.device_group_list : 0];
            Object.assign(_this.formParameters.data, data);
            Object.assign(_this.formParameters.old_data, data);
            if (_this.formParameters.data.valid_from) {
                var tempDate = _this.formParameters.data.valid_from.split(' ')[0].split('-');
                if (tempDate.length) {
                    _this.formParameters.data.valid_from = {};
                    if (tempDate[0])
                        _this.formParameters.data.valid_from.year = parseInt(tempDate[0]);
                    if (tempDate[1])
                        _this.formParameters.data.valid_from.month = parseInt(tempDate[1]);
                    if (tempDate[2])
                        _this.formParameters.data.valid_from.day = parseInt(tempDate[2]);
                }
            }
            if (_this.formParameters.data.valid_until) {
                var tempDate = _this.formParameters.data.valid_until.split(' ')[0].split('-');
                if (tempDate.length) {
                    _this.formParameters.data.valid_until = {};
                    if (tempDate[0])
                        _this.formParameters.data.valid_until.year = parseInt(tempDate[0]);
                    if (tempDate[1])
                        _this.formParameters.data.valid_until.month = parseInt(tempDate[1]);
                    if (tempDate[2])
                        _this.formParameters.data.valid_until.day = parseInt(tempDate[2]);
                }
            }
            //console.log(data)
            rxjs_1.forkJoin(_this.pre.get('/tacacs/user/group/list/', data.group.join(',') || 0, { type: 'user', id: data.id }), _this.pre.get('/tacacs/service/list/', data.service.join(',')), _this.pre.get('/tacacs/acl/list/', data.acl.join(',')), _this.pre.get('/tacacs/device/list/', data.device_list.join(',') || 0), _this.pre.get('/tacacs/device/group/list/', data.device_group_list.join(',') || 0)).pipe(operators_1.map(function (_a) {
                var group = _a[0], service = _a[1], acl = _a[2], device_list = _a[3], device_group_list = _a[4];
                // console.log(group, service, acl, device_list, device_group_list)
                var returnData = {};
                if (group)
                    returnData['group'] = group;
                if (service)
                    returnData['service'] = service;
                if (acl)
                    returnData['acl'] = acl;
                if (device_list)
                    returnData['device_list'] = device_list;
                if (device_group_list)
                    returnData['device_group_list'] = device_group_list;
                return returnData;
            })).subscribe(function (data) {
                // console.log(data)
                // console.log(this.formParameters.data)
                if (data['group']) {
                    _this.formParameters.data.group = JSON.parse(JSON.stringify(data['group']));
                    _this.formParameters.old_data.group = JSON.parse(JSON.stringify(data['group']));
                }
                if (data['service']) {
                    _this.formParameters.data.service = JSON.parse(JSON.stringify(data['service']));
                    _this.formParameters.old_data.service = JSON.parse(JSON.stringify(data['service']));
                }
                if (data['acl']) {
                    _this.formParameters.data.acl = JSON.parse(JSON.stringify(data['acl']));
                    _this.formParameters.old_data.acl = JSON.parse(JSON.stringify(data['acl']));
                }
                if (data['device_list']) {
                    _this.formParameters.data.device_list = JSON.parse(JSON.stringify(data['device_list']));
                    _this.formParameters.old_data.device_list = JSON.parse(JSON.stringify(data['device_list']));
                }
                if (data['device_group_list']) {
                    _this.formParameters.data.device_group_list = JSON.parse(JSON.stringify(data['device_group_list']));
                    _this.formParameters.old_data.device_group_list = JSON.parse(JSON.stringify(data['device_group_list']));
                }
                // console.log(this.formParameters.data)
                _this.loadingForm.next(false);
            });
        });
    };
    EditComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    EditComponent.prototype.save = function () {
        var _this = this;
        this.loadingForm.next(true);
        var data = this.makeClone(this.formParameters.data);
        var old_data = this.makeClone(this.formParameters.old_data);
        if (data.valid_from && data.valid_from.year) {
            var month = (data.valid_from.month.toString().length == 2) ? data.valid_from.month.toString() : '0' + data.valid_from.month.toString();
            var day = (data.valid_from.day.toString().length == 2) ? data.valid_from.day.toString() : '0' + data.valid_from.day.toString();
            data.valid_from = data.valid_from.year + '-' + month + '-' + day + ' 00:00:00';
        }
        if (data.valid_until && data.valid_until.year) {
            var month = (data.valid_until.month.toString().length == 2) ? data.valid_until.month.toString() : '0' + data.valid_until.month.toString();
            var day = (data.valid_until.day.toString().length == 2) ? data.valid_until.day.toString() : '0' + data.valid_until.day.toString();
            data.valid_until = data.valid_until.year + '-' + month.toString() + '-' + day + ' 00:00:00';
        }
        // console.log(this.formParameters.data)
        if (JSON.stringify(data) == JSON.stringify(old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        if (data.enable == old_data.enable)
            delete data.enable;
        if (data.pap == old_data.pap)
            delete data.pap;
        if (data.login == old_data.login)
            delete data.login;
        console.log(data);
        data.group = (data.group[0] && data.group[0].id) ? data.group.map(function (x) { return x.id; }) : null;
        data.service = (data.service[0] && data.service[0].id) ? data.service[0].id : null;
        data.acl = (data.acl[0] && data.acl[0].id) ? data.acl[0].id : null;
        data.device_list = (data.device_list[0] && data.device_list[0].id) ? data.device_list.map(function (x) { return x.id; }) : null;
        data.device_group_list = (data.device_group_list[0] && data.device_group_list[0].id) ? data.device_group_list.map(function (x) { return x.id; }) : null;
        this.usr_service.save(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('User Changed!');
                _this.router.navigate(['../../'], { relativeTo: _this.route });
            }
            else {
                _this.toastr.error('Unknown server error');
            }
            _this.loadingForm.next(false);
        });
    };
    EditComponent = __decorate([
        core_1.Component({
            selector: 'kt-edit',
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/tacacs/users/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/tacacs/users/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            user_service_1.UserService,
            router_1.Router,
            router_1.ActivatedRoute,
            preload_service_1.PreloadService])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/users/user.service.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/user.service.ts ***!
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
var http_1 = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var API_URL = 'api/tacacs/user';
var UserService = /** @class */ (function () {
    function UserService(http) {
        this.http = http;
    }
    UserService.prototype.add = function (user) {
        return this.http.post(API_URL + '/add/', user)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UserService.prototype.get = function (id) {
        var params = new http_1.HttpParams()
            .set('id', id.toString());
        return this.http.get(API_URL + '/edit/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.user;
        }));
    };
    UserService.prototype.save = function (user) {
        return this.http.post(API_URL + '/edit/', user)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UserService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], UserService);
    return UserService;
}());
exports.UserService = UserService;


/***/ }),

/***/ "./src/app/views/pages/tacacs/users/users.component.html":
/*!***************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/users.component.html ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/users/users.component.scss":
/*!***************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/users.component.scss ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy91c2Vycy91c2Vycy5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/users/users.component.ts":
/*!*************************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/users.component.ts ***!
  \*************************************************************/
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
// import { first } from 'rxjs/operators';
var UsersComponent = /** @class */ (function () {
    function UsersComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/tacacs/user/delete/',
                editBtn: true,
                selectable: true,
                preview: {
                    target: 'user'
                },
                pagination: false,
                mainUrl: '/tacacs/user/datatables/',
                sort: {
                    column: 'username',
                    direction: 'asc'
                },
                editable: true,
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    username: { title: 'Username', show: true, sortable: true },
                    created_at: { title: 'Created', show: false, sortable: true },
                    updated_at: { title: 'Updated', show: false, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: true,
                    name: 'Add User',
                    link: 'add',
                },
                filter: {
                    enable: true
                },
                actions: {
                    enable: true,
                    options: []
                },
                moreColumns: {
                    enable: true
                }
            }
        };
    }
    UsersComponent.prototype.ngOnInit = function () {
    };
    UsersComponent = __decorate([
        core_1.Component({
            selector: 'kt-users',
            template: __webpack_require__(/*! ./users.component.html */ "./src/app/views/pages/tacacs/users/users.component.html"),
            styles: [__webpack_require__(/*! ./users.component.scss */ "./src/app/views/pages/tacacs/users/users.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], UsersComponent);
    return UsersComponent;
}());
exports.UsersComponent = UsersComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/users/users.module.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/tacacs/users/users.module.ts ***!
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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
//Form
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
var angularx_qrcode_1 = __webpack_require__(/*! angularx-qrcode */ "./node_modules/angularx-qrcode/dist/index.js");
// Core Module
var core_module_1 = __webpack_require__(/*! ../../../../core/core.module */ "./src/app/core/core.module.ts");
var partials_module_1 = __webpack_require__(/*! ../../../partials/partials.module */ "./src/app/views/partials/partials.module.ts");
var pages_module_1 = __webpack_require__(/*! ../../pages.module */ "./src/app/views/pages/pages.module.ts");
//Compoents
var users_component_1 = __webpack_require__(/*! ./users.component */ "./src/app/views/pages/tacacs/users/users.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/tacacs/users/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/tacacs/users/edit/edit.component.ts");
//Form
var tac_user_form_component_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.ts");
// import { DragDropModule } from '@angular/cdk/drag-drop';
var UsersModule = /** @class */ (function () {
    function UsersModule() {
    }
    UsersModule = __decorate([
        core_1.NgModule({
            declarations: [users_component_1.UsersComponent, add_component_1.AddComponent, edit_component_1.EditComponent, tac_user_form_component_1.TacUserFormComponent],
            imports: [
                common_1.CommonModule,
                core_module_1.CoreModule,
                partials_module_1.PartialsModule,
                pages_module_1.PagesModule,
                forms_1.FormsModule,
                angularx_qrcode_1.QRCodeModule,
                ng_bootstrap_1.NgbModule,
                // DragDropModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: users_component_1.UsersComponent
                    },
                    {
                        path: 'add',
                        component: add_component_1.AddComponent
                    },
                    {
                        path: 'edit/:id',
                        component: edit_component_1.EditComponent
                    },
                ]),
            ]
        })
    ], UsersModule);
    return UsersModule;
}());
exports.UsersModule = UsersModule;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.html":
/*!************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.html ***!
  \************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Username</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.username }\"\n                  [(ngModel)]=\"options.data.username\" placeholder=\"User Name\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.username;\">{{message}}</p>\n              </div>\n\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group usergroup-list\">\n              <kt-field-general-list [data]=\"options.data.group\"\n                [params]=\"list.group\"\n                [errors]=\"(validation | async)?.group\"\n                (returnData)=\"setGroup($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.group }\" >\n              </kt-field-general-list>\n              <span class=\"form-text text-muted\"><span class=\"kt-badge kt-badge--success kt-badge--square\">...</span> - default group for that user</span>\n\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <label>Login Password</label>\n\n              <div class=\"input-group\" *ngIf=\"!(options.data.login_flag == 30 || options.data.login_flag == 10)\">\n                <input type=\"{{ (options.data.login_flag == 1 || options.data.login_flag == 3) ? 'password' : 'text'}}\"\n                  class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.login }\"\n                  [(ngModel)]=\"options.data.login\"\n                  [disabled]=\"(options.data.login_flag == 20)\"\n                  autocomplete=\"new-password\"\n                  placeholder=\"Login Password\" autocomplete=\"new-password\">\n  \t\t\t\t\t\t\t<div class=\"input-group-append\" *ngIf=\"!(options.data.login_flag == 20)\">\n  \t\t\t\t\t\t\t\t<button class=\"btn btn-sm btn-icon btn-default\" ngbTooltip=\"Can user change password?\"\n                    type=\"button\" (click)=\"options.data.login_change=+!options.data.login_change; changePasswd('login')\">\n                    <i class=\"fa fa-minus-square\" [ngClass]=\"{'fa-minus-square':!options.data.login_change, 'fa-check-square': options.data.login_change}\"></i>\n                  </button>\n  \t\t\t\t\t\t\t</div>\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.login;\">{{message}}</p>\n                </div>\n\t\t\t\t\t\t  </div>\n\n\n  \t\t\t\t\t\t<input type=\"text\" *ngIf=\"options.data.login_flag == 30\"\n                class=\"form-control form-control-sm\"\n                [(ngModel)]=\"options.data.mavis_sms_number\"\n                placeholder=\"Phone Number\" autocomplete=\"off\">\n              <ng-container *ngIf=\"options.data.login_flag == 10\">\n                <qrcode [qrdata]=\"(otpSecretUrl | async)\" [size]=\"224\" [level]=\"'M'\"></qrcode>\n              </ng-container>\n              <div class=\"invalid-feedback\">\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n           </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <label>Type</label>\n              <select [(ngModel)]=\"options.data.login_flag\" class=\"form-control form-control-sm\" (change)=\" options.data.login='' \">\n                <option value=\"0\">Clear Text</option>\n                <option value=\"1\">MD5</option>\n                <option value=\"3\">Local Database (MAVIS)</option>\n                <option value=\"10\">Get from OTP (MAVIS)</option>\n                <option value=\"20\">Get from LDAP (MAVIS)</option>\n                <option value=\"30\">Get from SMS (MAVIS)</option>\n              </select>\n            </div>\n            <div class=\"form-group text-center\">\n              <input *ngIf=\"options.data.login_flag == 10\" class=\"btn btn-warning btn-sm\" type=\"button\" value=\"Refresh Key\" (click)=\"refresh()\"/>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Enable Password</label>\n              <div class=\"input-group\">\n                <input type=\"{{(options.data.enable_flag == 1) ? 'password' : 'text'}}\"\n                  class=\"form-control form-control-sm\"\n                  [(ngModel)]=\"options.data.enable\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.enable }\"\n                  [disabled]=\"(options.data.enable_flag == 4)\"\n                  autocomplete=\"new-password\"\n                  placeholder=\"Enable Password\" >\n                <!-- <div class=\"input-group-append\" *ngIf=\"!(options.data.enable_flag == 4)\">\n  \t\t\t\t\t\t\t\t<button class=\"btn btn-sm btn-icon btn-default\" placement=\"top\" ngbTooltip=\"Can user change password?\"\n                    type=\"button\" (click)=\"options.data.enable_change=+!options.data.enable_change; changePasswd('enable')\">\n                    <i class=\"fa fa-minus-square\" [ngClass]=\"{'fa-minus-square':!options.data.enable_change, 'fa-check-square': options.data.enable_change}\"></i>\n                  </button>\n  \t\t\t\t\t\t\t</div> -->\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.enable;\">{{message}}</p>\n                </div>\n              </div>\n\n              <div class=\"invalid-feedback\">\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n           </div>\n          <div class=\"col-6\">\n            <label>Type</label>\n            <select [(ngModel)]=\"options.data.enable_flag\" class=\"form-control form-control-sm\" (change)=\" options.data.enable=''\">\n              <option value=\"0\">Clear Text</option>\n              <option value=\"1\">MD5</option>\n              <option value=\"4\">Clone Login password</option>\n            </select>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"options.data.service\"\n                [params]=\"list.service\"\n                [errors]=\"(validation | async)?.service\"\n                (returnData)=\"setSevice($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.service }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"options.data.acl\"\n                [params]=\"list.acl\"\n                [errors]=\"(validation | async)?.acl\"\n                (returnData)=\"setAcl($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.acl }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n        </div>\n        <!-- <div class=\"row\">\n          <div class=\"col-6\"> -->\n            <div class=\"form-group row\">\n              <div class=\"col-2\">\n                <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n    \t\t\t\t\t\t\t<label>\n    \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"options.data.default_service\">\n    \t\t\t\t\t\t\t\t<span></span>\n    \t\t\t\t\t\t\t</label>\n    \t\t\t\t\t\t</span>\n              </div>\n    \t\t\t\t\t<label class=\"col-10 col-form-label\">Default Service Permit</label>\n    \t\t\t\t</div>\n          <!-- </div>\n        </div> -->\n        <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedM }\" data-toggle=\"collapse\" (click)=\"notCollapsedM = !notCollapsedM\"\n                            [attr.aria-expanded]=\"!notCollapsedM\">Message</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedM\">\n                  <div class=\"card-body\">\n                    <div class=\"form-group\">\n                      <label class=\"pull-right\">Message</label>\n                      <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.message\" rows=\"5\"></textarea>\n                    </div>\n                  </div>\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedAC }\" data-toggle=\"collapse\" (click)=\"notCollapsedAC = !notCollapsedAC\"\n                            [attr.aria-expanded]=\"!notCollapsedAC\">Access Control</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedAC\">\n                  <div class=\"form-group row\">\n                    <div class=\"col-2\">\n                      <span class=\"kt-switch kt-switch--sm\" [ngClass]=\"{'kt-switch--danger': !options.data.device_list_action, 'kt-switch--success': options.data.device_list_action}\">\n          \t\t\t\t\t\t\t<label>\n          \t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"options.data.device_list_action\">\n          \t\t\t\t\t\t\t<span></span>\n          \t\t\t\t\t\t\t</label>\n          \t\t\t\t\t\t</span>\n                    </div>\n                    <label class=\"col-10 col-form-label\">Action For The List Below</label>\n                    <span class=\"col-12 form-text text-muted\">Action: {{ (options.data.device_list_action) ? 'Permit ONLY below list' : 'Permit all except list below'}}</span>\n                  </div>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <kt-field-general-list [data]=\"options.data.device_list\"\n                          [params]=\"list.device_list\"\n                          [errors]=\"(validation | async)?.device_list\"\n                          (returnData)=\"setDeviceList($event)\"\n                          [ngClass]=\"{ 'is-invalid' : (validation | async)?.device_list }\" >\n                        </kt-field-general-list>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <kt-field-general-list [data]=\"options.data.device_group_list\"\n                          [params]=\"list.device_group_list\"\n                          [errors]=\"(validation | async)?.device_group_list\"\n                          (returnData)=\"setDevGroupList($event)\"\n                          [ngClass]=\"{ 'is-invalid' : (validation | async)?.device_group_list }\" >\n                        </kt-field-general-list>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedEO }\" data-toggle=\"collapse\" (click)=\"notCollapsedEO = !notCollapsedEO\"\n                            [attr.aria-expanded]=\"!notCollapsedEO\">Extra Options</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedEO\">\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <label>PAP Authentication</label>\n                        <input type=\"{{(options.data.pap_flag == 1) ? 'password' : 'text'}}\"\n                          class=\"form-control form-control-sm\"\n                          [(ngModel)]=\"options.data.pap\"\n                          [disabled]=\"(options.data.pap_flag == 4)\"\n                          autocomplete=\"new-password\"\n                          placeholder=\"PAP Password\" >\n                        <div class=\"invalid-feedback\">\n                        </div>\n                        <span class=\"form-text text-muted\"></span>\n                      </div>\n                     </div>\n                    <div class=\"col-6\">\n                      <label>Type</label>\n                      <select [(ngModel)]=\"options.data.pap_flag\" class=\"form-control form-control-sm\">\n                        <option value=\"0\">Clear Text</option>\n                        <option value=\"1\">MD5</option>\n                        <option value=\"4\">Clone Login password</option>\n                      </select>\n                    </div>\n                  </div>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <label>CHAP Authentication</label>\n                        <input type=\"password\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.chap\" autocomplete=\"new-password\" placeholder=\"CHAP Password\">\n                        <div class=\"invalid-feedback\">\n                        </div>\n                        <span class=\"form-text text-muted\"></span>\n                      </div>\n                     </div>\n                  </div>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <label>MS-CHAP Authentication</label>\n                        <input type=\"password\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.ms_chap\" autocomplete=\"new-password\" placeholder=\"MS-CHAP Password\">\n                        <div class=\"invalid-feedback\">\n                        </div>\n                        <span class=\"form-text text-muted\"></span>\n                      </div>\n                     </div>\n                  </div>\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMS = !notCollapsedMS\"\n                            [attr.aria-expanded]=\"!notCollapsedMS\">Manual Configuration</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedMS\">\n                    <div class=\"card-body\">\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Manual Configuration</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.manual\" rows=\"5\"></textarea>\n                      </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <label>Valid From</label>\n              <div class=\"input-group\">\n                <div class=\"input-group-prepend\">\n                  <button class=\"btn btn-sm btn-default btn-icon\" (click)=\"vf.toggle()\" type=\"button\"><i class=\"fa fa-calendar-alt\"></i></button>\n                </div>\n                <input class=\"form-control form-control-sm\" placeholder=\"yyyy-mm-dd\" (click)=\"vf.toggle()\"\n                       [(ngModel)]=\"options.data.valid_from\" ngbDatepicker #vf=\"ngbDatepicker\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-sm btn-default btn-icon\" (click)=\"options.data.valid_from=null\" type=\"button\"><i class=\"fa fa-trash-alt\"></i></button>\n                </div>\n              </div>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <label>Valid Until</label>\n              <div class=\"input-group\">\n                <div class=\"input-group-prepend\">\n                  <button class=\"btn btn-sm btn-default btn-icon\" (click)=\"vu.toggle()\" type=\"button\"><i class=\"fa fa-calendar-alt\"></i></button>\n                </div>\n                <input class=\"form-control form-control-sm\" placeholder=\"yyyy-mm-dd\" (click)=\"vu.toggle()\"\n                       [(ngModel)]=\"options.data.valid_until\" ngbDatepicker #vu=\"ngbDatepicker\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-sm btn-default btn-icon\" (click)=\"options.data.valid_until=null\" type=\"button\"><i class=\"fa fa-trash-alt\"></i></button>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n    \t\t\t\t\t<label style=\"width: 100%;\">Disabled</label>\n    \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--danger\">\n    \t\t\t\t\t\t\t<label>\n    \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"options.data.disabled\">\n    \t\t\t\t\t\t\t\t<span></span>\n    \t\t\t\t\t\t\t</label>\n    \t\t\t\t\t\t</span>\n    \t\t\t\t</div>\n          </div>\n        </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.scss":
/*!************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.scss ***!
  \************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".usergroup-list div.tgui-general-list div.tgui-general-list-item:first-child {\n  background-color: #0abb87;\n  color: #f7f8fa; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYXJ0aWFscy9sYXlvdXQvdGFjZ3VpL19mb3Jtcy90YWMtdXNlci1mb3JtL3RhYy11c2VyLWZvcm0uY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7RUFDRSx5QkFBeUI7RUFDekIsY0FBYyxFQUFBIiwiZmlsZSI6InNyYy9hcHAvdmlld3MvcGFydGlhbHMvbGF5b3V0L3RhY2d1aS9fZm9ybXMvdGFjLXVzZXItZm9ybS90YWMtdXNlci1mb3JtLmNvbXBvbmVudC5zY3NzIiwic291cmNlc0NvbnRlbnQiOlsiLnVzZXJncm91cC1saXN0IGRpdi50Z3VpLWdlbmVyYWwtbGlzdCBkaXYudGd1aS1nZW5lcmFsLWxpc3QtaXRlbTpmaXJzdC1jaGlsZCB7XHJcbiAgYmFja2dyb3VuZC1jb2xvcjogIzBhYmI4NztcclxuICBjb2xvcjogI2Y3ZjhmYTtcclxufVxyXG4iXX0= */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.ts":
/*!**********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.ts ***!
  \**********************************************************************************************/
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var tac_user_otp_service_1 = __webpack_require__(/*! ./tac-user-otp.service */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-otp.service.ts");
var TacUserFormComponent = /** @class */ (function () {
    // preloadGroup = new BehaviorSubject({})
    // preloadAcl = new BehaviorSubject({})
    function TacUserFormComponent(otp, toastr) {
        this.otp = otp;
        this.toastr = toastr;
        this.otpSecretUrl = new rxjs_1.BehaviorSubject('');
        this.list = {
            group: {
                multiple: true,
                title: 'User Group',
                title_sidebar: 'User Groups List',
                search: true,
                apiurl: 'api/tacacs/user/group/list/',
            },
            acl: {
                multiple: false,
                title: 'Access Control List',
                title_sidebar: 'ACL List',
                search: true,
                apiurl: 'api/tacacs/acl/list/',
            },
            service: {
                multiple: false,
                title: 'Service',
                title_sidebar: 'Service List',
                search: true,
                apiurl: 'api/tacacs/service/list/',
            },
            device_list: {
                multiple: true,
                title: 'Device List',
                title_sidebar: 'Device List',
                search: true,
                apiurl: 'api/tacacs/device/list/',
            },
            device_group_list: {
                multiple: true,
                title: 'Device Group List',
                title_sidebar: 'Device Group List',
                search: true,
                apiurl: 'api/tacacs/device/group/list/',
            }
        };
    }
    TacUserFormComponent.prototype.refresh = function () {
        if (!confirm('You will lost the old key, are you sure?'))
            return;
        this.otpSecretUrl.next(this.options.data.otpUpdate());
        this.getUrl();
    };
    TacUserFormComponent.prototype.getUrl = function () {
        var _this = this;
        var username = this.options.data.username;
        var secret = this.options.data.mavis_otp_secret;
        // console.log(secret)
        this.otp.getUrl(secret, username).subscribe(function (data) {
            // console.log(data)
            _this.otpSecretUrl.next(data);
        });
    };
    TacUserFormComponent.prototype.ngAfterViewInit = function () {
        var _this = this;
        console.log('after init');
        this.loading.subscribe(function () { return _this.getUrl(); });
    };
    TacUserFormComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.validation.subscribe(function (data) {
            //console.log(data)
            for (var key in data) {
                if (data[key]) {
                    //console.log(data[key])
                    for (var i = 0; i < data[key].length; i++) {
                        _this.toastr.error(data[key][i]);
                    }
                }
            }
        });
        console.log('init');
        this.otpSecretUrl.next(this.options.data.mavis_otp_secret);
    };
    TacUserFormComponent.prototype.changePasswd = function (section) {
        console.log(section);
        switch (section) {
            case 'login':
                if (this.options.data.login_change)
                    this.toastr.warning('User can change login password');
                else
                    this.toastr.warning('User can NOT change login password');
                break;
            case 'enable':
                if (this.options.data.enable_change)
                    this.toastr.warning('User can change enable password');
                else
                    this.toastr.warning('User can NOT change enable password');
                break;
            default:
                this.toastr.warning('Unknown parameter!');
        }
    };
    TacUserFormComponent.prototype.setGroup = function (data) {
        // console.log(data)
        this.options.data.group = data;
    };
    TacUserFormComponent.prototype.setSevice = function (data) {
        // console.log(data)
        this.options.data.service = data;
    };
    TacUserFormComponent.prototype.setAcl = function (data) {
        // console.log(data)
        this.options.data.acl = data;
    };
    TacUserFormComponent.prototype.setDeviceList = function (data) {
        // console.log(data)
        this.options.data.device_list = data;
    };
    TacUserFormComponent.prototype.setDevGroupList = function (data) {
        // console.log(data)
        this.options.data.device_group_list = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacUserFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacUserFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacUserFormComponent.prototype, "loading", void 0);
    TacUserFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-tac-user-form',
            template: __webpack_require__(/*! ./tac-user-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./tac-user-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-form.component.scss")]
        }),
        __metadata("design:paramtypes", [tac_user_otp_service_1.TacUserOtpService,
            ngx_toastr_1.ToastrService])
    ], TacUserFormComponent);
    return TacUserFormComponent;
}());
exports.TacUserFormComponent = TacUserFormComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-otp.service.ts":
/*!*******************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-form/tac-user-otp.service.ts ***!
  \*******************************************************************************************/
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
var http_1 = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var API_URL = '/mavis/otp/generate/secret/';
var TacUserOtpService = /** @class */ (function () {
    function TacUserOtpService(http) {
        this.http = http;
        this.objectKeys = Object.keys;
    }
    TacUserOtpService.prototype.getUrl = function (secret, username) {
        //let message = ''
        // console.log(username)
        return this.http.post('api' + API_URL, { secret: secret, username: username })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.url;
        }));
    };
    TacUserOtpService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], TacUserOtpService);
    return TacUserOtpService;
}());
exports.TacUserOtpService = TacUserOtpService;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-form/user.model.ts":
/*!*********************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-form/user.model.ts ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var User = /** @class */ (function () {
    function User() {
    }
    User.prototype.empty = function () {
        this.acl = [];
        this.chap = undefined;
        // this.client_ip = null
        this.created_at = undefined;
        this.default_service = 1;
        this.device_group_list = [];
        this.device_list = [];
        this.device_list_action = 0;
        this.disabled = 0;
        this.enable = undefined;
        this.enable_change = 0;
        this.enable_flag = 1;
        this.group = [];
        this.id = undefined;
        this.login = undefined;
        this.login_change = 0;
        this.login_flag = 3;
        this.manual = undefined;
        this.manual_beginning = undefined;
        // this.mavis_otp_digest = null
        // this.mavis_otp_digits = null
        // this.mavis_otp_enabled = null
        // this.mavis_otp_period = null
        this.mavis_otp_secret = this.newOtpKey();
        // this.mavis_sms_enabled = null
        this.mavis_sms_number = undefined;
        this.message = undefined;
        this.ms_chap = undefined;
        // nxos_support = undefined
        this.pap = undefined;
        // this.pap_clone = undefined
        this.pap_flag = 4;
        // priv-lvl = undefined
        // this.server_ip = undefined
        this.service = [];
        this.updated_at = undefined;
        this.username = undefined;
        this.valid_from = undefined;
        this.valid_until = undefined;
    };
    User.prototype.newOtpKey = function () {
        var length = 224;
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    };
    User.prototype.otpUpdate = function () {
        this.mavis_otp_secret = this.newOtpKey();
        return this.mavis_otp_secret;
    };
    return User;
}());
exports.User = User;


/***/ })

}]);
//# sourceMappingURL=users-users-module.41bf7e3b5515b2e1acd1.js.map