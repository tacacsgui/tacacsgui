(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["api-user-groups-user-groups-module"],{

/***/ "./src/app/views/pages/gui/api-user-groups/add/add.component.html":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/add/add.component.html ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-api-user-group-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-api-user-group-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add User Group</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/api-user-groups/add/add.component.scss":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/add/add.component.scss ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9hcGktdXNlci1ncm91cHMvYWRkL2FkZC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/gui/api-user-groups/add/add.component.ts":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/add/add.component.ts ***!
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
//Router
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model Device
var api_user_group_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/api-user-group-form/api-user-group.model */ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group.model.ts");
//Service//
var user_group_service_1 = __webpack_require__(/*! ../user-group.service */ "./src/app/views/pages/gui/api-user-groups/user-group.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, ug_service, router, route) {
        this.toastr = toastr;
        this.ug_service = ug_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new api_user_group_model_1.ApiUserGroup,
            old_data: new api_user_group_model_1.ApiUserGroup,
            rights: []
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
        this.ug_service.add(data).subscribe(function (data) {
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/gui/api-user-groups/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/gui/api-user-groups/add/add.component.scss")]
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

/***/ "./src/app/views/pages/gui/api-user-groups/edit/edit.component.html":
/*!**************************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/edit/edit.component.html ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-api-user-group-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-api-user-group-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Edit User Group</button>&nbsp;\n    <a routerLink=\"../..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/api-user-groups/edit/edit.component.scss":
/*!**************************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/edit/edit.component.scss ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9hcGktdXNlci1ncm91cHMvZWRpdC9lZGl0LmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/gui/api-user-groups/edit/edit.component.ts":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/edit/edit.component.ts ***!
  \************************************************************************/
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
var api_user_group_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/api-user-group-form/api-user-group.model */ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group.model.ts");
//Service//
var user_group_service_1 = __webpack_require__(/*! ../user-group.service */ "./src/app/views/pages/gui/api-user-groups/user-group.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, ug_service, router, route) {
        this.toastr = toastr;
        this.ug_service = ug_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new api_user_group_model_1.ApiUserGroup,
            old_data: new api_user_group_model_1.ApiUserGroup,
            rights: []
        };
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
        this.ug_service.get(id).subscribe(function (data) {
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
    EditComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    EditComponent.prototype.save = function () {
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
        console.log(data);
        this.ug_service.save(data).subscribe(function (data) {
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/gui/api-user-groups/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/gui/api-user-groups/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            user_group_service_1.UserGroupService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/api-user-groups/user-group.service.ts":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/user-group.service.ts ***!
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
var http_1 = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var API_URL = 'api/user/group';
var UserGroupService = /** @class */ (function () {
    function UserGroupService(http) {
        this.http = http;
    }
    UserGroupService.prototype.add = function (group) {
        return this.http.post(API_URL + '/add/', group)
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
    UserGroupService.prototype.save = function (group) {
        return this.http.post(API_URL + '/edit/', group)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UserGroupService.prototype.rights = function () {
        return this.http.post(API_URL + '/rights/', {})
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.rights;
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

/***/ "./src/app/views/pages/gui/api-user-groups/user-groups.component.html":
/*!****************************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/user-groups.component.html ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/api-user-groups/user-groups.component.scss":
/*!****************************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/user-groups.component.scss ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9hcGktdXNlci1ncm91cHMvdXNlci1ncm91cHMuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/api-user-groups/user-groups.component.ts":
/*!**************************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/user-groups.component.ts ***!
  \**************************************************************************/
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
                delBtn: '/user/group/delete/',
                editBtn: true,
                selectable: true,
                preview: false,
                pagination: false,
                mainUrl: '/user/group/datatables/',
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
            template: __webpack_require__(/*! ./user-groups.component.html */ "./src/app/views/pages/gui/api-user-groups/user-groups.component.html"),
            styles: [__webpack_require__(/*! ./user-groups.component.scss */ "./src/app/views/pages/gui/api-user-groups/user-groups.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], UserGroupsComponent);
    return UserGroupsComponent;
}());
exports.UserGroupsComponent = UserGroupsComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/api-user-groups/user-groups.module.ts":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/gui/api-user-groups/user-groups.module.ts ***!
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
var api_user_group_form_component_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component */ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.ts");
var user_groups_component_1 = __webpack_require__(/*! ./user-groups.component */ "./src/app/views/pages/gui/api-user-groups/user-groups.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/gui/api-user-groups/edit/edit.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/gui/api-user-groups/add/add.component.ts");
var UserGroupsModule = /** @class */ (function () {
    function UserGroupsModule() {
    }
    UserGroupsModule = __decorate([
        core_1.NgModule({
            declarations: [
                user_groups_component_1.UserGroupsComponent,
                edit_component_1.EditComponent,
                add_component_1.AddComponent,
                api_user_group_form_component_1.ApiUserGroupFormComponent
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
                        component: user_groups_component_1.UserGroupsComponent
                    },
                    {
                        path: 'add',
                        component: add_component_1.AddComponent,
                    },
                    {
                        path: 'edit/:id',
                        component: edit_component_1.EditComponent
                    },
                ])
            ]
        })
    ], UserGroupsModule);
    return UserGroupsModule;
}());
exports.UserGroupsModule = UserGroupsModule;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.html":
/*!************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.html ***!
  \************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Name</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.name }\"\n                  [(ngModel)]=\"options.data.name\" placeholder=\"Name\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.name;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n\n        <div class=\"row\">\n          <div class=\"form-group col-5\">\n            <label>Role List</label>\n            <select class=\"form-control rights-list scroll-bar style-11\" size=\"15\">\n              <ng-container *ngFor=\"let role of rights | async\">\n                <option *ngIf=\"!roleChecker(role.value)\" (click)=\"addRole(role.value)\">{{role.name}}</option>\n              </ng-container>\n            </select>\n            <input type=\"hidden\" name=\"cisco_wlc_roles\" data-type=\"input\" data-default=\"\" data-pickup=\"true\">\n            <input type=\"hidden\" name=\"cisco_wlc_roles_native\">\n          </div>\n          <div class=\"form-group col-5\">\n            <label>Selected Roles</label>\n            <select class=\"form-control rights-list\" size=\"15\" [ngClass]=\"{ 'is-invalid' : (validation | async)?.rights }\">\n              <ng-container *ngFor=\"let role of rights | async\">\n                <option *ngIf=\"roleChecker(role.value)\" (click)=\"delRole(role.value)\">{{role.name}}</option>\n              </ng-container>\n            </select>\n            <div class=\"invalid-feedback\">\n              <p *ngFor=\"let message of (validation | async)?.rights;\">{{message}}</p>\n            </div>\n          </div>\n        </div>\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.scss":
/*!************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.scss ***!
  \************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".rights-list {\n  overflow-y: hidden;\n  overflow-x: scroll; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYXJ0aWFscy9sYXlvdXQvdGFjZ3VpL19mb3Jtcy9hcGktdXNlci1ncm91cC1mb3JtL2FwaS11c2VyLWdyb3VwLWZvcm0uY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7RUFDRSxrQkFBa0I7RUFDbEIsa0JBQWtCLEVBQUEiLCJmaWxlIjoic3JjL2FwcC92aWV3cy9wYXJ0aWFscy9sYXlvdXQvdGFjZ3VpL19mb3Jtcy9hcGktdXNlci1ncm91cC1mb3JtL2FwaS11c2VyLWdyb3VwLWZvcm0uY29tcG9uZW50LnNjc3MiLCJzb3VyY2VzQ29udGVudCI6WyIucmlnaHRzLWxpc3Qge1xyXG4gIG92ZXJmbG93LXk6IGhpZGRlbjtcclxuICBvdmVyZmxvdy14OiBzY3JvbGw7XHJcbn1cclxuIl19 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.ts":
/*!**********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.ts ***!
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
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Service//
var user_group_service_1 = __webpack_require__(/*! ../../../../../pages/gui/api-user-groups/user-group.service */ "./src/app/views/pages/gui/api-user-groups/user-group.service.ts");
var ApiUserGroupFormComponent = /** @class */ (function () {
    function ApiUserGroupFormComponent(toastr, service) {
        this.toastr = toastr;
        this.service = service;
        this.rights = new rxjs_1.BehaviorSubject([]);
    }
    ApiUserGroupFormComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.service.rights().subscribe(function (data) {
            _this.rights.next(data);
            console.log(data);
        });
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
    ApiUserGroupFormComponent.prototype.addRole = function (index) {
        this.options.data.rights += Math.pow(2, index);
    };
    ApiUserGroupFormComponent.prototype.delRole = function (index) {
        this.options.data.rights -= Math.pow(2, index);
    };
    ApiUserGroupFormComponent.prototype.roleChecker = function (index) {
        var tempStr = this.options.data.rights.toString(2).split("").reverse();
        return tempStr[index] && tempStr[index] == 1;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ApiUserGroupFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ApiUserGroupFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ApiUserGroupFormComponent.prototype, "loading", void 0);
    ApiUserGroupFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-api-user-group-form',
            template: __webpack_require__(/*! ./api-user-group-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.html"),
            styles: [__webpack_require__(/*! ./api-user-group-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group-form.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            user_group_service_1.UserGroupService])
    ], ApiUserGroupFormComponent);
    return ApiUserGroupFormComponent;
}());
exports.ApiUserGroupFormComponent = ApiUserGroupFormComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group.model.ts":
/*!*************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/api-user-group-form/api-user-group.model.ts ***!
  \*************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var ApiUserGroup = /** @class */ (function () {
    function ApiUserGroup() {
    }
    ApiUserGroup.prototype.empty = function () {
        this.id = undefined;
        this.name = '';
        this.rights = 0;
    };
    return ApiUserGroup;
}());
exports.ApiUserGroup = ApiUserGroup;


/***/ })

}]);
//# sourceMappingURL=api-user-groups-user-groups-module.e367e3b794452bb2cbce.js.map