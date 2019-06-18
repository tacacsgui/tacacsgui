(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["dev-groups-dev-groups-module"],{

/***/ "./src/app/views/pages/tacacs/dev-groups/add/add.component.html":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/add/add.component.html ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-device-group-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-tac-device-group-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add Device Group</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/add/add.component.scss":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/add/add.component.scss ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9kZXYtZ3JvdXBzL2FkZC9hZGQuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/add/add.component.ts":
/*!********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/add/add.component.ts ***!
  \********************************************************************/
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
var device_group_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-device-group-form/device-group.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/device-group.model.ts");
//Service//
var device_group_service_1 = __webpack_require__(/*! ../device-group.service */ "./src/app/views/pages/tacacs/dev-groups/device-group.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, devG_service, router, route) {
        this.toastr = toastr;
        this.devG_service = devG_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new device_group_model_1.DeviceGroup,
            old_data: new device_group_model_1.DeviceGroup
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
        // console.log(this.formParameters.data)
        var data = this.makeClone(this.formParameters.data);
        data.acl = (data.acl[0] && data.acl[0].id) ? data.acl[0].id : null;
        data.user_group = (data.user_group[0] && data.user_group[0].id) ? data.user_group[0].id : null;
        // console.log(data)
        this.loadingForm.next(true);
        this.devG_service.add(data).subscribe(function (data) {
            // console.log(data)
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.deviceGroup) {
                _this.toastr.success('Device Group Added!');
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/tacacs/dev-groups/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/tacacs/dev-groups/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            device_group_service_1.DeviceGroupService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/dev-groups.component.html":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/dev-groups.component.html ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/dev-groups.component.scss":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/dev-groups.component.scss ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9kZXYtZ3JvdXBzL2Rldi1ncm91cHMuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/dev-groups.component.ts":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/dev-groups.component.ts ***!
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
var DevGroupsComponent = /** @class */ (function () {
    function DevGroupsComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/tacacs/device/group/delete/',
                editBtn: true,
                selectable: true,
                preview: {
                    target: 'deviceGrp'
                },
                pagination: false,
                mainUrl: '/tacacs/device/group/datatables/',
                sort: {
                    column: 'name',
                    direction: 'asc'
                },
                editable: true,
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
                    name: 'Add Device Group',
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
    DevGroupsComponent.prototype.ngOnInit = function () {
    };
    DevGroupsComponent = __decorate([
        core_1.Component({
            selector: 'kt-dev-groups',
            template: __webpack_require__(/*! ./dev-groups.component.html */ "./src/app/views/pages/tacacs/dev-groups/dev-groups.component.html"),
            styles: [__webpack_require__(/*! ./dev-groups.component.scss */ "./src/app/views/pages/tacacs/dev-groups/dev-groups.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], DevGroupsComponent);
    return DevGroupsComponent;
}());
exports.DevGroupsComponent = DevGroupsComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/dev-groups.module.ts":
/*!********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/dev-groups.module.ts ***!
  \********************************************************************/
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
//PortletModule
var portlet_module_1 = __webpack_require__(/*! ../../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
// Core Module
var core_module_1 = __webpack_require__(/*! ../../../../core/core.module */ "./src/app/core/core.module.ts");
var partials_module_1 = __webpack_require__(/*! ../../../partials/partials.module */ "./src/app/views/partials/partials.module.ts");
var pages_module_1 = __webpack_require__(/*! ../../pages.module */ "./src/app/views/pages/pages.module.ts");
//Form
var tac_device_group_form_component_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/tacacs/dev-groups/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/tacacs/dev-groups/edit/edit.component.ts");
var dev_groups_component_1 = __webpack_require__(/*! ./dev-groups.component */ "./src/app/views/pages/tacacs/dev-groups/dev-groups.component.ts");
var DevGroupsModule = /** @class */ (function () {
    function DevGroupsModule() {
    }
    DevGroupsModule = __decorate([
        core_1.NgModule({
            declarations: [
                tac_device_group_form_component_1.TacDeviceGroupFormComponent,
                // FieldGeneralListComponent,
                add_component_1.AddComponent,
                edit_component_1.EditComponent,
                dev_groups_component_1.DevGroupsComponent
            ],
            imports: [
                common_1.CommonModule,
                partials_module_1.PartialsModule,
                forms_1.FormsModule,
                portlet_module_1.PortletModule,
                pages_module_1.PagesModule,
                core_module_1.CoreModule,
                ng_bootstrap_1.NgbModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: dev_groups_component_1.DevGroupsComponent
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
    ], DevGroupsModule);
    return DevGroupsModule;
}());
exports.DevGroupsModule = DevGroupsModule;


/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/device-group.service.ts":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/device-group.service.ts ***!
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
var API_URL = 'api/tacacs/device/group';
var DeviceGroupService = /** @class */ (function () {
    function DeviceGroupService(http) {
        this.http = http;
        this.objectKeys = Object.keys;
    }
    DeviceGroupService.prototype.add = function (group) {
        //let message = ''
        return this.http.post(API_URL + '/add/', group)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    DeviceGroupService.prototype.get = function (id) {
        var params = new http_1.HttpParams()
            .set('id', id.toString());
        //let message = ''
        return this.http.get(API_URL + '/edit/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.group;
        }));
    };
    DeviceGroupService.prototype.save = function (group) {
        //let message = ''
        return this.http.post(API_URL + '/edit/', group)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    DeviceGroupService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], DeviceGroupService);
    return DeviceGroupService;
}());
exports.DeviceGroupService = DeviceGroupService;


/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/edit/edit.component.html":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/edit/edit.component.html ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-device-group-form [options]=\"formParameters\" [validation]=\"validation\"  [loading]=\"loadingForm\">\n</kt-tac-device-group-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n    [disabled]=\"(loadingForm | async)\">Edit Device Group</button>&nbsp;\n    <a routerLink=\"../../\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/edit/edit.component.scss":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/edit/edit.component.scss ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9kZXYtZ3JvdXBzL2VkaXQvZWRpdC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/dev-groups/edit/edit.component.ts":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/dev-groups/edit/edit.component.ts ***!
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
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model Device
var device_group_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-device-group-form/device-group.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/device-group.model.ts");
//Service//
var device_group_service_1 = __webpack_require__(/*! ../device-group.service */ "./src/app/views/pages/tacacs/dev-groups/device-group.service.ts");
var preload_service_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_fields/field-general-list/preload.service */ "./src/app/views/partials/layout/tacgui/_fields/field-general-list/preload.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, devG_service, router, route, pre) {
        this.toastr = toastr;
        this.devG_service = devG_service;
        this.router = router;
        this.route = route;
        this.pre = pre;
        this.formParameters = {
            action: 'add',
            data: new device_group_model_1.DeviceGroup,
            old_data: new device_group_model_1.DeviceGroup
        };
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
        this.devG_service.get(id).subscribe(function (data) {
            // console.log(data)
            if (!data) {
                _this.toastr.error('Server Error!');
                _this.router.navigate(['../../'], { relativeTo: _this.route });
                return;
            }
            Object.assign(_this.formParameters.data, data);
            Object.assign(_this.formParameters.old_data, data);
            if (!Array.isArray(data.acl))
                data.acl = [(data.acl) ? data.acl : 0];
            if (!Array.isArray(data.user_group))
                data.user_group = [(data.user_group) ? data.user_group : 0];
            rxjs_1.forkJoin(_this.pre.get('/tacacs/acl/list/', data.acl.join(',')), _this.pre.get('/tacacs/user/group/list/', data.user_group.join(','))).pipe(operators_1.map(function (_a) {
                var acl = _a[0], user_group = _a[1];
                // console.log(acl, user_group)
                var returnData = {};
                if (acl)
                    returnData['acl'] = acl;
                if (user_group)
                    returnData['user_group'] = user_group;
                return returnData;
            })).subscribe(function (data) {
                // console.log(data)
                if (data['acl']) {
                    _this.formParameters.data.acl = JSON.parse(JSON.stringify(data['acl']));
                    _this.formParameters.old_data.acl = JSON.parse(JSON.stringify(data['acl']));
                }
                if (data['user_group']) {
                    _this.formParameters.data.user_group = JSON.parse(JSON.stringify(data['user_group']));
                    _this.formParameters.old_data.user_group = JSON.parse(JSON.stringify(data['user_group']));
                }
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
        // console.log(JSON.stringify(data))
        // console.log(JSON.stringify(old_data))
        if (JSON.stringify(data) == JSON.stringify(old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        data.acl = (data.acl[0] && data.acl[0].id) ? data.acl[0].id : null;
        data.user_group = (data.user_group[0] && data.user_group[0].id) ? data.user_group[0].id : null;
        this.devG_service.save(data).subscribe(function (data) {
            // console.log(data)
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('Device Group Changed!');
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/tacacs/dev-groups/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/tacacs/dev-groups/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            device_group_service_1.DeviceGroupService,
            router_1.Router,
            router_1.ActivatedRoute,
            preload_service_1.PreloadService])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/device-group.model.ts":
/*!*************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/device-group.model.ts ***!
  \*************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var DeviceGroup = /** @class */ (function () {
    function DeviceGroup() {
    }
    DeviceGroup.prototype.empty = function () {
        this.acl = [];
        this.default_flag = 0;
        this.banner_failed = '';
        this.banner_motd = '';
        this.banner_welcome = '';
        this.connection_timeout = undefined;
        this.created_at = '';
        this.enable = '';
        this.enable_flag = 1;
        this.id = undefined;
        this.key = '';
        this.manual = '';
        this.name = '';
        this.updated_at = '';
        this.user_group = [];
    };
    return DeviceGroup;
}());
exports.DeviceGroup = DeviceGroup;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.html":
/*!****************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.html ***!
  \****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Name</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.name }\"\n                  [(ngModel)]=\"options.data.name\" placeholder=\"Device Name\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.name;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">it should be unique, but you can change it later</span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Tacacs Key</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                [(ngModel)]=\"options.data.key\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.key }\"\n                placeholder=\"Tacacs Key\">\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.key;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Enable Password</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.enable\" placeholder=\"Enable Password\">\n              <div class=\"invalid-feedback\">\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n           </div>\n          <div class=\"col-6\">\n            <label>Type of storing</label>\n            <select [(ngModel)]=\"options.data.enable_flag\" class=\"form-control form-control-sm\">\n              <option value=\"0\">Clear Text</option>\n              <option value=\"1\">MD5</option>\n            </select>\n          </div>\n        </div>\n        <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedB }\" data-toggle=\"collapse\"(click)=\"notCollapsedB = !notCollapsedB\"\n                            [attr.aria-expanded]=\"!notCollapsedB\">Banners</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedB\">\n                  <ngb-tabset>\n                  <ngb-tab title=\"Welcome\">\n                    <ng-template ngbTabContent>\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Welcome Banner</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.banner_welcome\" rows=\"5\"></textarea>\n                      </div>\n                    </ng-template>\n                  </ngb-tab>\n                  <ngb-tab title=\"MOTD\">\n                    <ng-template ngbTabContent>\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Message Of The Day Banner</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.banner_motd\" rows=\"5\"></textarea>\n                      </div>\n                    </ng-template>\n                  </ngb-tab>\n                  <ngb-tab title=\"Failed Auth\">\n                    <ng-template ngbTabContent>\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Authentication Failed Banner</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.banner_failed\" rows=\"5\"></textarea>\n                      </div>\n                    </ng-template>\n                  </ngb-tab>\n                  </ngb-tabset>\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedACC }\" data-toggle=\"collapse\"(click)=\"notCollapsedACC = !notCollapsedACC\"\n                            [attr.aria-expanded]=\"!notCollapsedACC\">Access</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedACC\">\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <kt-field-general-list\n                          [data]=\"options.data.acl\"\n                          [params]=\"list.acl\"\n                          (returnData)=\"setAcl($event)\">\n                        </kt-field-general-list>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <kt-field-general-list\n                          [data]=\"options.data.user_group\"\n                          [params]=\"list.user_group\"\n                          (returnData)=\"setUserGroup($event)\">\n                        </kt-field-general-list>\n                      </div>\n                    </div>\n                  </div><!-- .row -->\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <label>Connection Timeout</label>\n                        <input type=\"number\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.connection_timeout\" placeholder=\"Connection Timeout\">\n                        <div class=\"invalid-feedback\">\n                        </div>\n                        <span class=\"form-text text-muted\"></span>\n                      </div>\n                    </div>\n                  </div><!-- .row -->\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMS }\" data-toggle=\"collapse\"(click)=\"notCollapsedMS = !notCollapsedMS\"\n                            [attr.aria-expanded]=\"!notCollapsedMS\">Manual Configuration</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedMS\">\n                    <div class=\"card-body\">\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Manual Configuration</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.manual\" rows=\"5\"></textarea>\n                      </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n        <!-- <div class=\"form-group row\">\n\t\t\t\t\t<label class=\"col-3 col-form-label\">Default Group</label>\n\t\t\t\t\t<div class=\"col-3\">\n\t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--icon kt-switch--success\">\n\t\t\t\t\t\t<label>\n\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"options.data.default_flag\">\n\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t</label>\n\t\t\t\t\t\t</span>\n\t\t\t\t\t</div>\n\t\t\t\t</div> -->\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.scss":
/*!****************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.scss ***!
  \****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1kZXZpY2UtZ3JvdXAtZm9ybS90YWMtZGV2aWNlLWdyb3VwLWZvcm0uY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.ts":
/*!**************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.ts ***!
  \**************************************************************************************************************/
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
var TacDeviceGroupFormComponent = /** @class */ (function () {
    function TacDeviceGroupFormComponent(toastr) {
        this.toastr = toastr;
        this.objectKeys = Object.keys;
        this.list = {
            acl: {
                multiple: false,
                title: 'Access Control List',
                title_sidebar: 'ACL List',
                search: true,
                apiurl: 'api/tacacs/acl/list/',
            },
            user_group: {
                multiple: false,
                title: 'Default User Group',
                title_sidebar: 'User Group List',
                search: true,
                apiurl: 'api/tacacs/user/group/list/',
            }
        };
    }
    TacDeviceGroupFormComponent.prototype.ngOnInit = function () {
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
    TacDeviceGroupFormComponent.prototype.setAcl = function (data) {
        // console.log(data)
        this.options.data.acl = data;
    };
    TacDeviceGroupFormComponent.prototype.setUserGroup = function (data) {
        //console.log(data)
        this.options.data.user_group = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacDeviceGroupFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacDeviceGroupFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacDeviceGroupFormComponent.prototype, "loading", void 0);
    TacDeviceGroupFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-tac-device-group-form',
            template: __webpack_require__(/*! ./tac-device-group-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./tac-device-group-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-group-form/tac-device-group-form.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService])
    ], TacDeviceGroupFormComponent);
    return TacDeviceGroupFormComponent;
}());
exports.TacDeviceGroupFormComponent = TacDeviceGroupFormComponent;


/***/ })

}]);
//# sourceMappingURL=dev-groups-dev-groups-module.js.map