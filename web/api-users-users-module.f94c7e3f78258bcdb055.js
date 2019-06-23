(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["api-users-users-module"],{

/***/ "./src/app/views/pages/gui/api-users/add/add.component.html":
/*!******************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/add/add.component.html ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-api-user-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-api-user-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add User</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/api-users/add/add.component.scss":
/*!******************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/add/add.component.scss ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9hcGktdXNlcnMvYWRkL2FkZC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/gui/api-users/add/add.component.ts":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/add/add.component.ts ***!
  \****************************************************************/
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
var apiuser_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/api-user-form/apiuser.model */ "./src/app/views/partials/layout/tacgui/_forms/api-user-form/apiuser.model.ts");
//Service//
var user_service_1 = __webpack_require__(/*! ../user.service */ "./src/app/views/pages/gui/api-users/user.service.ts");
var AddAPIComponent = /** @class */ (function () {
    function AddAPIComponent(toastr, u_service, router, route) {
        this.toastr = toastr;
        this.u_service = u_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new apiuser_model_1.ApiUser,
            old_data: new apiuser_model_1.ApiUser
        };
    }
    AddAPIComponent.prototype.ngOnInit = function () {
        this.formParameters.data.empty();
        this.formParameters.old_data.empty();
    };
    AddAPIComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    AddAPIComponent.prototype.add = function () {
        var _this = this;
        this.loadingForm.next(true);
        console.log(this.formParameters.data);
        var data = this.makeClone(this.formParameters.data);
        console.log(data);
        data.group = (data.group[0] && data.group[0].id) ? data.group[0].id : null;
        // this.toastr.success('Hello world!', 'Toastr fun!');
        this.u_service.add(data).subscribe(function (data) {
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
    AddAPIComponent = __decorate([
        core_1.Component({
            selector: 'kt-add',
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/gui/api-users/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/gui/api-users/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            user_service_1.UserService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddAPIComponent);
    return AddAPIComponent;
}());
exports.AddAPIComponent = AddAPIComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/api-users/edit/edit.component.html":
/*!********************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/edit/edit.component.html ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-api-user-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-api-user-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Edit User</button>&nbsp;\n    <a routerLink=\"../..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/api-users/edit/edit.component.scss":
/*!********************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/edit/edit.component.scss ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9hcGktdXNlcnMvZWRpdC9lZGl0LmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/gui/api-users/edit/edit.component.ts":
/*!******************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/edit/edit.component.ts ***!
  \******************************************************************/
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
var apiuser_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/api-user-form/apiuser.model */ "./src/app/views/partials/layout/tacgui/_forms/api-user-form/apiuser.model.ts");
//Service//
var user_service_1 = __webpack_require__(/*! ../user.service */ "./src/app/views/pages/gui/api-users/user.service.ts");
var EditAPIComponent = /** @class */ (function () {
    function EditAPIComponent(toastr, u_service, router, route) {
        this.toastr = toastr;
        this.u_service = u_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new apiuser_model_1.ApiUser,
            old_data: new apiuser_model_1.ApiUser
        };
    }
    EditAPIComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.formParameters.data.empty();
        this.formParameters.old_data.empty();
        this.route.paramMap.pipe(operators_1.first()).subscribe(function (params) {
            _this.fillForm(+params.get('id'));
        });
    };
    EditAPIComponent.prototype.fillForm = function (id) {
        var _this = this;
        console.log(id);
        this.u_service.get(id).subscribe(function (data) {
            console.log(data);
            if (!data) {
                _this.toastr.error('Server Error!');
                _this.router.navigate(['../../'], { relativeTo: _this.route });
                return;
            }
            Object.assign(_this.formParameters.data, data);
            Object.assign(_this.formParameters.old_data, data);
            console.log(_this.formParameters.data);
            _this.loadingForm.next(false);
        });
    };
    EditAPIComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    EditAPIComponent.prototype.save = function () {
        var _this = this;
        this.loadingForm.next(true);
        var data = this.makeClone(this.formParameters.data);
        var old_data = this.makeClone(this.formParameters.old_data);
        console.log(this.formParameters.data);
        if (JSON.stringify(data) == JSON.stringify(old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        data.group = (data.group[0] && data.group[0].id) ? data.group[0].id : null;
        if (!data.password && data.password == '')
            delete data.password;
        if (!data.repassword && data.repassword == '')
            delete data.repassword;
        console.log(data);
        this.u_service.save(data).subscribe(function (data) {
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
    EditAPIComponent = __decorate([
        core_1.Component({
            selector: 'kt-edit',
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/gui/api-users/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/gui/api-users/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            user_service_1.UserService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], EditAPIComponent);
    return EditAPIComponent;
}());
exports.EditAPIComponent = EditAPIComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/api-users/user.service.ts":
/*!***********************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/user.service.ts ***!
  \***********************************************************/
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
var API_URL = 'api/user';
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

/***/ "./src/app/views/pages/gui/api-users/users.component.html":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/users.component.html ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/api-users/users.component.scss":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/users.component.scss ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9hcGktdXNlcnMvdXNlcnMuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/api-users/users.component.ts":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/users.component.ts ***!
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
var UsersAPIComponent = /** @class */ (function () {
    function UsersAPIComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/user/delete/',
                editBtn: true,
                selectable: true,
                preview: false,
                pagination: false,
                mainUrl: '/user/datatables/',
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
    UsersAPIComponent.prototype.ngOnInit = function () {
    };
    UsersAPIComponent = __decorate([
        core_1.Component({
            selector: 'kt-users',
            template: __webpack_require__(/*! ./users.component.html */ "./src/app/views/pages/gui/api-users/users.component.html"),
            styles: [__webpack_require__(/*! ./users.component.scss */ "./src/app/views/pages/gui/api-users/users.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], UsersAPIComponent);
    return UsersAPIComponent;
}());
exports.UsersAPIComponent = UsersAPIComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/api-users/users.module.ts":
/*!***********************************************************!*\
  !*** ./src/app/views/pages/gui/api-users/users.module.ts ***!
  \***********************************************************/
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
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
//Form
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
//PortletModule
var portlet_module_1 = __webpack_require__(/*! ../../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
var pages_module_1 = __webpack_require__(/*! ../../pages.module */ "./src/app/views/pages/pages.module.ts");
//Form
var api_user_form_component_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_forms/api-user-form/api-user-form.component */ "./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/gui/api-users/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/gui/api-users/edit/edit.component.ts");
var users_component_1 = __webpack_require__(/*! ./users.component */ "./src/app/views/pages/gui/api-users/users.component.ts");
var UsersModule = /** @class */ (function () {
    function UsersModule() {
    }
    UsersModule = __decorate([
        core_1.NgModule({
            declarations: [
                add_component_1.AddAPIComponent,
                edit_component_1.EditAPIComponent,
                users_component_1.UsersAPIComponent,
                api_user_form_component_1.ApiUserFormComponent
            ],
            imports: [
                common_1.CommonModule,
                pages_module_1.PagesModule,
                ng_bootstrap_1.NgbModule,
                forms_1.FormsModule,
                portlet_module_1.PortletModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: users_component_1.UsersAPIComponent
                    },
                    {
                        path: 'add',
                        component: add_component_1.AddAPIComponent,
                    },
                    {
                        path: 'edit/:id',
                        component: edit_component_1.EditAPIComponent
                    },
                ]),
            ]
        })
    ], UsersModule);
    return UsersModule;
}());
exports.UsersModule = UsersModule;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.html":
/*!************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.html ***!
  \************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Username</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.username }\"\n                  [(ngModel)]=\"options.data.username\" placeholder=\"Username\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.username;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">it will be used for authorization and you can't change it further time</span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"options.data.group\"\n                [params]=\"list.group\"\n                [errors]=\"(validation | async)?.group\"\n                (returnData)=\"setGroup($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.group }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Password</label>\n  \t\t\t\t\t\t<input type=\"password\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.password }\"\n                  [(ngModel)]=\"options.data.password\" placeholder=\"Password\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.password;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Repeat Password</label>\n  \t\t\t\t\t\t<input type=\"password\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.repassword }\"\n                  [(ngModel)]=\"options.data.repassword\" placeholder=\"Repeat Password\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.repassword;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"options.data.changePasswd\"> Change password in next login\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">user must change password in next login</span>\n            </div>\n          </div>\n        </div>\n\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Firstname</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.firstname }\"\n                  [(ngModel)]=\"options.data.firstname\" placeholder=\"Firstname\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.firstname;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">Optional</span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Surename</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.surname }\"\n                  [(ngModel)]=\"options.data.surname\" placeholder=\"Surename\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.surname;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">Optional</span>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Email</label>\n  \t\t\t\t\t\t<input type=\"email\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.email }\"\n                  [(ngModel)]=\"options.data.email\" placeholder=\"Email\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.email;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">Optional</span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Position</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.position }\"\n                  [(ngModel)]=\"options.data.position\" placeholder=\"Position\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.position;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">Optional</span>\n            </div>\n          </div>\n        </div>\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.scss":
/*!************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.scss ***!
  \************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL2FwaS11c2VyLWZvcm0vYXBpLXVzZXItZm9ybS5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.ts":
/*!**********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.ts ***!
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
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var ApiUserFormComponent = /** @class */ (function () {
    function ApiUserFormComponent(toastr) {
        this.toastr = toastr;
        this.list = {
            group: {
                multiple: false,
                title: 'User Group',
                title_sidebar: 'User Groups List',
                search: true,
                apiurl: 'api/user/group/list/',
            }
        };
    }
    ApiUserFormComponent.prototype.ngOnInit = function () {
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
    ApiUserFormComponent.prototype.setGroup = function (data) {
        //console.log(data)
        this.options.data.group = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ApiUserFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ApiUserFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ApiUserFormComponent.prototype, "loading", void 0);
    ApiUserFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-api-user-form',
            template: __webpack_require__(/*! ./api-user-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.html"),
            styles: [__webpack_require__(/*! ./api-user-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/api-user-form/api-user-form.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService])
    ], ApiUserFormComponent);
    return ApiUserFormComponent;
}());
exports.ApiUserFormComponent = ApiUserFormComponent;


/***/ })

}]);
//# sourceMappingURL=api-users-users-module.f94c7e3f78258bcdb055.js.map