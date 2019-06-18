(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["user-groups-user-groups-module"],{

/***/ "./src/app/views/pages/tacacs/user-groups/add/add.component.html":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/add/add.component.html ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-user-group-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-tac-user-group-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add User Group</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/add/add.component.scss":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/add/add.component.scss ***!
  \***********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy91c2VyLWdyb3Vwcy9hZGQvYWRkLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/add/add.component.ts":
/*!*********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/add/add.component.ts ***!
  \*********************************************************************/
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
//Model UserGroup
var user_group_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-user-group-form/user-group.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/user-group.model.ts");
//Service//
var user_group_service_1 = __webpack_require__(/*! ../user-group.service */ "./src/app/views/pages/tacacs/user-groups/user-group.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, usrGrp_service, router, route) {
        this.toastr = toastr;
        this.usrGrp_service = usrGrp_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new user_group_model_1.UserGroup,
            old_data: new user_group_model_1.UserGroup
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
        // this.loadingForm.next(true)
        console.log(this.formParameters.data);
        var data = this.makeClone(this.formParameters.data);
        console.log(data);
        data.service = (data.service[0] && data.service[0].id) ? data.service[0].id : null;
        data.acl = (data.acl[0] && data.acl[0].id) ? data.acl[0].id : null;
        data.device_list = (data.device_list[0] && data.device_list[0].id) ? data.device_list.map(function (x) { return x.id; }) : null;
        data.device_group_list = (data.device_group_list[0] && data.device_group_list[0].id) ? data.device_group_list.map(function (x) { return x.id; }) : null;
        data.ldap_groups = (data.ldap_groups[0] && data.ldap_groups[0].id) ? data.ldap_groups.map(function (x) { return x.id; }) : null;
        if (data.valid_from && data.valid_from.year) {
            data.valid_from = data.valid_from.year + '-' + data.valid_from.month + '-' + data.valid_from.day;
        }
        if (data.valid_until && data.valid_until.year) {
            data.valid_until = data.valid_until.year + '-' + data.valid_until.month + '-' + data.valid_until.day;
        }
        // this.toastr.success('Hello world!', 'Toastr fun!');
        this.usrGrp_service.add(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.group) {
                _this.toastr.success('User Group Added!');
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/tacacs/user-groups/add/add.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/tacacs/user-groups/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            user_group_service_1.UserGroupService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/edit/edit.component.html":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/edit/edit.component.html ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-user-group-form [options]=\"formParameters\" [validation]=\"validation\"  [loading]=\"loadingForm\">\n</kt-tac-user-group-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n    [disabled]=\"(loadingForm | async)\">Edit User Group</button>&nbsp;\n    <a routerLink=\"../../\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/edit/edit.component.scss":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/edit/edit.component.scss ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy91c2VyLWdyb3Vwcy9lZGl0L2VkaXQuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/edit/edit.component.ts":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/edit/edit.component.ts ***!
  \***********************************************************************/
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
var user_group_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-user-group-form/user-group.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/user-group.model.ts");
//Service//
var user_group_service_1 = __webpack_require__(/*! ../user-group.service */ "./src/app/views/pages/tacacs/user-groups/user-group.service.ts");
var preload_service_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_fields/field-general-list/preload.service */ "./src/app/views/partials/layout/tacgui/_fields/field-general-list/preload.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, usrGrp_service, router, route, pre) {
        this.toastr = toastr;
        this.usrGrp_service = usrGrp_service;
        this.router = router;
        this.route = route;
        this.pre = pre;
        this.formParameters = {
            action: 'add',
            data: new user_group_model_1.UserGroup,
            old_data: new user_group_model_1.UserGroup
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
        console.log(id);
        this.usrGrp_service.get(id).subscribe(function (data) {
            console.log(data);
            if (!data) {
                _this.toastr.error('Server Error!');
                _this.router.navigate(['../../'], { relativeTo: _this.route });
                return;
            }
            if (!Array.isArray(data.ldap_groups))
                data.ldap_groups = [(data.ldap_groups) ? data.ldap_groups : 0];
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
            console.log(data);
            rxjs_1.forkJoin(_this.pre.get('/mavis/ldap/group/list/', data.ldap_groups.join(',') || 0), _this.pre.get('/tacacs/service/list/', data.service.join(',')), _this.pre.get('/tacacs/acl/list/', data.acl.join(',')), _this.pre.get('/tacacs/device/list/', data.device_list.join(',') || 0), _this.pre.get('/tacacs/device/group/list/', data.device_group_list.join(',') || 0)).pipe(operators_1.map(function (_a) {
                var ldap_groups = _a[0], service = _a[1], acl = _a[2], device_list = _a[3], device_group_list = _a[4];
                console.log(ldap_groups, service, acl, device_list, device_group_list);
                var returnData = {};
                if (ldap_groups)
                    returnData['ldap_groups'] = ldap_groups;
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
                console.log(_this.formParameters.data);
                if (data['ldap_groups']) {
                    _this.formParameters.data.ldap_groups = JSON.parse(JSON.stringify(data['ldap_groups']));
                    _this.formParameters.old_data.ldap_groups = JSON.parse(JSON.stringify(data['ldap_groups']));
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
                console.log(_this.formParameters.data);
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
        // console.log(JSON.stringify(data), JSON.stringify(old_data))
        if (JSON.stringify(data) == JSON.stringify(old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        if (data.enable == old_data.enable)
            delete data.enable;
        console.log(data);
        data.ldap_groups = (data.ldap_groups[0] && data.ldap_groups[0].id) ? data.ldap_groups.map(function (x) { return x.id; }) : null;
        data.service = (data.service[0] && data.service[0].id) ? data.service[0].id : null;
        data.acl = (data.acl[0] && data.acl[0].id) ? data.acl[0].id : null;
        data.device_list = (data.device_list[0] && data.device_list[0].id) ? data.device_list.map(function (x) { return x.id; }) : null;
        data.device_group_list = (data.device_group_list[0] && data.device_group_list[0].id) ? data.device_group_list.map(function (x) { return x.id; }) : null;
        this.usrGrp_service.save(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('User Group Changed!');
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/tacacs/user-groups/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/tacacs/user-groups/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            user_group_service_1.UserGroupService,
            router_1.Router,
            router_1.ActivatedRoute,
            preload_service_1.PreloadService])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/user-group.service.ts":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/user-group.service.ts ***!
  \**********************************************************************/
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
var API_URL = 'api/tacacs/user/group';
var UserGroupService = /** @class */ (function () {
    function UserGroupService(http) {
        this.http = http;
    }
    UserGroupService.prototype.add = function (user) {
        return this.http.post(API_URL + '/add/', user)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UserGroupService.prototype.get = function (id) {
        var params = new http_1.HttpParams()
            .set('id', id.toString());
        return this.http.get(API_URL + '/edit/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.group;
        }));
    };
    UserGroupService.prototype.save = function (user) {
        return this.http.post(API_URL + '/edit/', user)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UserGroupService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], UserGroupService);
    return UserGroupService;
}());
exports.UserGroupService = UserGroupService;


/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/user-groups.component.html":
/*!***************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/user-groups.component.html ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/user-groups.component.scss":
/*!***************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/user-groups.component.scss ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy91c2VyLWdyb3Vwcy91c2VyLWdyb3Vwcy5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/user-groups.component.ts":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/user-groups.component.ts ***!
  \*************************************************************************/
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
var UserGroupsComponent = /** @class */ (function () {
    function UserGroupsComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/tacacs/user/group/delete/',
                editBtn: true,
                selectable: true,
                preview: {
                    target: 'userGrp'
                },
                pagination: false,
                sort: {
                    column: 'name',
                    direction: 'asc'
                },
                editable: true,
                mainUrl: '/tacacs/user/group/datatables/',
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    name: { title: 'Name', show: true, sortable: true },
                    created_at: { title: 'Created', show: false, sortable: true },
                    updated_at: { title: 'Updated', show: false, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: true,
                    name: 'Add User Group',
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
    UserGroupsComponent.prototype.ngOnInit = function () {
    };
    UserGroupsComponent = __decorate([
        core_1.Component({
            selector: 'kt-user-groups',
            template: __webpack_require__(/*! ./user-groups.component.html */ "./src/app/views/pages/tacacs/user-groups/user-groups.component.html"),
            styles: [__webpack_require__(/*! ./user-groups.component.scss */ "./src/app/views/pages/tacacs/user-groups/user-groups.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], UserGroupsComponent);
    return UserGroupsComponent;
}());
exports.UserGroupsComponent = UserGroupsComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/user-groups/user-groups.module.ts":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/user-groups/user-groups.module.ts ***!
  \**********************************************************************/
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
// Core Module
var core_module_1 = __webpack_require__(/*! ../../../../core/core.module */ "./src/app/core/core.module.ts");
var partials_module_1 = __webpack_require__(/*! ../../../partials/partials.module */ "./src/app/views/partials/partials.module.ts");
var pages_module_1 = __webpack_require__(/*! ../../pages.module */ "./src/app/views/pages/pages.module.ts");
//Form
var tac_user_group_form_component_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.ts");
//Compoents
var user_groups_component_1 = __webpack_require__(/*! ./user-groups.component */ "./src/app/views/pages/tacacs/user-groups/user-groups.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/tacacs/user-groups/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/tacacs/user-groups/edit/edit.component.ts");
var UserGroupsModule = /** @class */ (function () {
    function UserGroupsModule() {
    }
    UserGroupsModule = __decorate([
        core_1.NgModule({
            declarations: [
                user_groups_component_1.UserGroupsComponent,
                add_component_1.AddComponent,
                edit_component_1.EditComponent,
                tac_user_group_form_component_1.TacUserGroupFormComponent
            ],
            imports: [
                common_1.CommonModule,
                ng_bootstrap_1.NgbModule,
                forms_1.FormsModule,
                core_module_1.CoreModule,
                partials_module_1.PartialsModule,
                pages_module_1.PagesModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: user_groups_component_1.UserGroupsComponent
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
    ], UserGroupsModule);
    return UserGroupsModule;
}());
exports.UserGroupsModule = UserGroupsModule;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.html":
/*!************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.html ***!
  \************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Name</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.name }\"\n                  [(ngModel)]=\"options.data.name\" placeholder=\"User Group Name\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.name;\">{{message}}</p>\n              </div>\n\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"options.data.ldap_groups\"\n                [params]=\"list.ldap_groups\"\n                [errors]=\"(validation | async)?.ldap_groups\"\n                (returnData)=\"setLdap($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.ldap_groups }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Enable Password</label>\n              <div class=\"input-group\">\n                <input type=\"{{(options.data.enable_flag == 1) ? 'password' : 'text'}}\"\n                  class=\"form-control form-control-sm\"\n                  [(ngModel)]=\"options.data.enable\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.enable }\"\n                  [disabled]=\"(options.data.enable_flag == 4)\"\n                  autocomplete=\"new-password\"\n                  placeholder=\"Enable Password\" >\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.enable;\">{{message}}</p>\n                </div>\n              </div>\n\n              <div class=\"invalid-feedback\">\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n           </div>\n          <div class=\"col-6\">\n            <label>Type</label>\n            <select [(ngModel)]=\"options.data.enable_flag\" class=\"form-control form-control-sm\" (change)=\" options.data.enable=''\">\n              <option value=\"0\">Clear Text</option>\n              <option value=\"1\">MD5</option>\n              <option value=\"4\">Clone Login password</option>\n            </select>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"options.data.service\"\n                [params]=\"list.service\"\n                [errors]=\"(validation | async)?.service\"\n                (returnData)=\"setSevice($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.service }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"options.data.acl\"\n                [params]=\"list.acl\"\n                [errors]=\"(validation | async)?.acl\"\n                (returnData)=\"setAcl($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.acl }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n        </div>\n        <!-- <div class=\"row\">\n          <div class=\"col-6\"> -->\n            <div class=\"form-group row\">\n              <div class=\"col-2\">\n                <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n    \t\t\t\t\t\t\t<label>\n    \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"options.data.default_service\">\n    \t\t\t\t\t\t\t\t<span></span>\n    \t\t\t\t\t\t\t</label>\n    \t\t\t\t\t\t</span>\n              </div>\n    \t\t\t\t\t<label class=\"col-10 col-form-label\">Default Service Permit</label>\n    \t\t\t\t</div>\n          <!-- </div>\n        </div> -->\n        <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedM }\" data-toggle=\"collapse\" (click)=\"notCollapsedM = !notCollapsedM\"\n                            [attr.aria-expanded]=\"!notCollapsedM\">Message</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedM\">\n                  <div class=\"card-body\">\n                    <div class=\"form-group\">\n                      <label class=\"pull-right\">Message</label>\n                      <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.message\" rows=\"5\"></textarea>\n                    </div>\n                  </div>\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedAC }\" data-toggle=\"collapse\" (click)=\"notCollapsedAC = !notCollapsedAC\"\n                            [attr.aria-expanded]=\"!notCollapsedAC\">Access Control</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedAC\">\n                  <div class=\"form-group row\">\n                    <div class=\"col-2\">\n                      <span class=\"kt-switch kt-switch--sm\" [ngClass]=\"{'kt-switch--danger': !options.data.device_list_action, 'kt-switch--success': options.data.device_list_action}\">\n          \t\t\t\t\t\t\t<label>\n          \t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"options.data.device_list_action\">\n          \t\t\t\t\t\t\t<span></span>\n          \t\t\t\t\t\t\t</label>\n          \t\t\t\t\t\t</span>\n                    </div>\n                    <label class=\"col-10 col-form-label\">Action For The List Below</label>\n                    <span class=\"col-12 form-text text-muted\">Action: {{ (options.data.device_list_action) ? 'Permit ONLY below list' : 'Permit all except list below'}}</span>\n                  </div>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <kt-field-general-list [data]=\"options.data.device_list\"\n                          [params]=\"list.device_list\"\n                          [errors]=\"(validation | async)?.device_list\"\n                          (returnData)=\"setDeviceList($event)\"\n                          [ngClass]=\"{ 'is-invalid' : (validation | async)?.device_list }\" >\n                        </kt-field-general-list>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <kt-field-general-list [data]=\"options.data.device_group_list\"\n                          [params]=\"list.device_group_list\"\n                          [errors]=\"(validation | async)?.device_group_list\"\n                          (returnData)=\"setDevGroupList($event)\"\n                          [ngClass]=\"{ 'is-invalid' : (validation | async)?.device_group_list }\" >\n                        </kt-field-general-list>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMS = !notCollapsedMS\"\n                            [attr.aria-expanded]=\"!notCollapsedMS\">Manual Configuration</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedMS\">\n                    <div class=\"card-body\">\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Manual Configuration</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.manual\" rows=\"5\"></textarea>\n                      </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <label>Valid From</label>\n              <div class=\"input-group\">\n                <div class=\"input-group-prepend\">\n                  <button class=\"btn btn-sm btn-default btn-icon\" (click)=\"vf.toggle()\" type=\"button\"><i class=\"fa fa-calendar-alt\"></i></button>\n                </div>\n                <input class=\"form-control form-control-sm\" placeholder=\"yyyy-mm-dd\" (click)=\"vf.toggle()\"\n                       [(ngModel)]=\"options.data.valid_from\" ngbDatepicker #vf=\"ngbDatepicker\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-sm btn-default btn-icon\" (click)=\"options.data.valid_from=null\" type=\"button\"><i class=\"fa fa-trash-alt\"></i></button>\n                </div>\n              </div>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <label>Valid Until</label>\n              <div class=\"input-group\">\n                <div class=\"input-group-prepend\">\n                  <button class=\"btn btn-sm btn-default btn-icon\" (click)=\"vu.toggle()\" type=\"button\"><i class=\"fa fa-calendar-alt\"></i></button>\n                </div>\n                <input class=\"form-control form-control-sm\" placeholder=\"yyyy-mm-dd\" (click)=\"vu.toggle()\"\n                       [(ngModel)]=\"options.data.valid_until\" ngbDatepicker #vu=\"ngbDatepicker\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-sm btn-default btn-icon\" (click)=\"options.data.valid_until=null\" type=\"button\"><i class=\"fa fa-trash-alt\"></i></button>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.scss":
/*!************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.scss ***!
  \************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy11c2VyLWdyb3VwLWZvcm0vdGFjLXVzZXItZ3JvdXAtZm9ybS5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.ts":
/*!**********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.ts ***!
  \**********************************************************************************************************/
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
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var TacUserGroupFormComponent = /** @class */ (function () {
    function TacUserGroupFormComponent(toastr) {
        this.toastr = toastr;
        this.list = {
            ldap_groups: {
                multiple: true,
                title: 'LDAP Group',
                title_sidebar: 'LDAP Group List',
                search: true,
                apiurl: 'api/mavis/ldap/group/list/',
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
    TacUserGroupFormComponent.prototype.ngOnInit = function () {
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
    };
    TacUserGroupFormComponent.prototype.setSevice = function (data) {
        // console.log(data)
        this.options.data.service = data;
    };
    TacUserGroupFormComponent.prototype.setAcl = function (data) {
        // console.log(data)
        this.options.data.acl = data;
    };
    TacUserGroupFormComponent.prototype.setDeviceList = function (data) {
        // console.log(data)
        this.options.data.device_list = data;
    };
    TacUserGroupFormComponent.prototype.setDevGroupList = function (data) {
        // console.log(data)
        this.options.data.device_group_list = data;
    };
    TacUserGroupFormComponent.prototype.setLdap = function (data) {
        // console.log(data)
        this.options.data.ldap_groups = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacUserGroupFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacUserGroupFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacUserGroupFormComponent.prototype, "loading", void 0);
    TacUserGroupFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-tac-user-group-form',
            template: __webpack_require__(/*! ./tac-user-group-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./tac-user-group-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/tac-user-group-form.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService])
    ], TacUserGroupFormComponent);
    return TacUserGroupFormComponent;
}());
exports.TacUserGroupFormComponent = TacUserGroupFormComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/user-group.model.ts":
/*!*********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-user-group-form/user-group.model.ts ***!
  \*********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var UserGroup = /** @class */ (function () {
    function UserGroup() {
    }
    UserGroup.prototype.empty = function () {
        this.acl = [];
        // client_ip: null
        this.created_at = undefined;
        this.default_flag = undefined;
        this.default_service = 1;
        this.device_group_list = [];
        this.device_list = [];
        this.device_list_action = undefined;
        this.enable = undefined;
        this.enable_flag = 1;
        this.id = undefined;
        this.ldap_groups = [];
        this.manual = undefined;
        // manual_beginning: null
        this.message = undefined;
        this.name = undefined;
        // priv-lvl: -1
        // server_ip: null
        this.service = [];
        this.updated_at = undefined;
        this.valid_from = undefined;
        this.valid_until = undefined;
    };
    return UserGroup;
}());
exports.UserGroup = UserGroup;


/***/ })

}]);
//# sourceMappingURL=user-groups-user-groups-module.js.map