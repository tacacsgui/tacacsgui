(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["services-services-module"],{

/***/ "./src/app/views/pages/tacacs/access-control/services/add/add.component.html":
/*!***********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/add/add.component.html ***!
  \***********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-service-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-tac-service-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add Service</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/add/add.component.scss":
/*!***********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/add/add.component.scss ***!
  \***********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9hY2Nlc3MtY29udHJvbC9zZXJ2aWNlcy9hZGQvYWRkLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/add/add.component.ts":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/add/add.component.ts ***!
  \*********************************************************************************/
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
var service_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/tac-service-form/service.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/service.model.ts");
//Service//
var service_service_1 = __webpack_require__(/*! ../service.service */ "./src/app/views/pages/tacacs/access-control/services/service.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, s_service, router, route) {
        this.toastr = toastr;
        this.s_service = s_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new service_model_1.Service,
            old_data: new service_model_1.Service
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
        var data = this.makeClone(this.formParameters.data);
        data.cisco_rs_cmd = (data.cisco_rs_cmd[0] && data.cisco_rs_cmd[0].id) ? data.cisco_rs_cmd.map(function (x) { return x.id; }) : null;
        data.h3c_cmd = (data.h3c_cmd[0] && data.h3c_cmd[0].id) ? data.h3c_cmd.map(function (x) { return x.id; }) : null;
        data.junos_cmd_ac = (data.junos_cmd_ac[0] && data.junos_cmd_ac[0].id) ? data.junos_cmd_ac.map(function (x) { return x.id; }) : null;
        data.junos_cmd_dc = (data.junos_cmd_dc[0] && data.junos_cmd_dc[0].id) ? data.junos_cmd_dc.map(function (x) { return x.id; }) : null;
        data.junos_cmd_ao = (data.junos_cmd_ao[0] && data.junos_cmd_ao[0].id) ? data.junos_cmd_ao.map(function (x) { return x.id; }) : null;
        data.junos_cmd_do = (data.junos_cmd_do[0] && data.junos_cmd_do[0].id) ? data.junos_cmd_do.map(function (x) { return x.id; }) : null;
        console.log(data);
        this.s_service.add(data).subscribe(function (data) {
            // console.log(data)
            _this.validation.next(data.error.validation);
            // console.log(this.validation.getValue())
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.service) {
                _this.toastr.success('Service Added!');
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/tacacs/access-control/services/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/tacacs/access-control/services/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            service_service_1.ServiceService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/edit/edit.component.html":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/edit/edit.component.html ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-service-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-tac-service-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Edit Service</button>&nbsp;\n    <a routerLink=\"../..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/edit/edit.component.scss":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/edit/edit.component.scss ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9hY2Nlc3MtY29udHJvbC9zZXJ2aWNlcy9lZGl0L2VkaXQuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/edit/edit.component.ts":
/*!***********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/edit/edit.component.ts ***!
  \***********************************************************************************/
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
var service_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/tac-service-form/service.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/service.model.ts");
//Service//
var service_service_1 = __webpack_require__(/*! ../service.service */ "./src/app/views/pages/tacacs/access-control/services/service.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, s_service, router, route) {
        this.toastr = toastr;
        this.s_service = s_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.formParameters = {
            action: 'add',
            data: new service_model_1.Service,
            old_data: new service_model_1.Service
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
        this.s_service.get(id).subscribe(function (data) {
            console.log(data);
            if (!data) {
                _this.toastr.error('Server Error!');
                _this.router.navigate(['../../'], { relativeTo: _this.route });
                return;
            }
            Object.assign(_this.formParameters.data, _this.makeClone(data));
            Object.assign(_this.formParameters.old_data, _this.makeClone(data));
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
        if (JSON.stringify(data) == JSON.stringify(old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        data.cisco_rs_cmd = (data.cisco_rs_cmd[0] && data.cisco_rs_cmd[0].id) ? data.cisco_rs_cmd.map(function (x) { return x.id; }) : null;
        data.h3c_cmd = (data.h3c_cmd[0] && data.h3c_cmd[0].id) ? data.h3c_cmd.map(function (x) { return x.id; }) : null;
        data.junos_cmd_ac = (data.junos_cmd_ac[0] && data.junos_cmd_ac[0].id) ? data.junos_cmd_ac.map(function (x) { return x.id; }) : null;
        data.junos_cmd_dc = (data.junos_cmd_dc[0] && data.junos_cmd_dc[0].id) ? data.junos_cmd_dc.map(function (x) { return x.id; }) : null;
        data.junos_cmd_ao = (data.junos_cmd_ao[0] && data.junos_cmd_ao[0].id) ? data.junos_cmd_ao.map(function (x) { return x.id; }) : null;
        data.junos_cmd_do = (data.junos_cmd_do[0] && data.junos_cmd_do[0].id) ? data.junos_cmd_do.map(function (x) { return x.id; }) : null;
        console.log(data);
        this.s_service.save(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('Service Changed!');
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/tacacs/access-control/services/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/tacacs/access-control/services/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            service_service_1.ServiceService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/service.service.ts":
/*!*******************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/service.service.ts ***!
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
var http_1 = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var API_URL = 'api/tacacs/service';
var ServiceService = /** @class */ (function () {
    function ServiceService(http) {
        this.http = http;
        this.objectKeys = Object.keys;
    }
    ServiceService.prototype.add = function (service) {
        //let message = ''
        return this.http.post(API_URL + '/add/', service)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ServiceService.prototype.get = function (id) {
        var params = new http_1.HttpParams()
            .set('id', id.toString());
        //let message = ''
        return this.http.get(API_URL + '/edit/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.service;
        }));
    };
    ServiceService.prototype.save = function (service) {
        //let message = ''
        return this.http.post(API_URL + '/edit/', service)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ServiceService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], ServiceService);
    return ServiceService;
}());
exports.ServiceService = ServiceService;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/services.component.html":
/*!************************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/services.component.html ***!
  \************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/services.component.scss":
/*!************************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/services.component.scss ***!
  \************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9hY2Nlc3MtY29udHJvbC9zZXJ2aWNlcy9zZXJ2aWNlcy5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/services.component.ts":
/*!**********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/services.component.ts ***!
  \**********************************************************************************/
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
var ServicesComponent = /** @class */ (function () {
    function ServicesComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/tacacs/service/delete/',
                editBtn: true,
                selectable: true,
                preview: {
                    target: 'service'
                },
                pagination: false,
                mainUrl: '/tacacs/service/datatables/',
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
                    name: 'Add Service',
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
    ServicesComponent.prototype.ngOnInit = function () {
    };
    ServicesComponent = __decorate([
        core_1.Component({
            selector: 'kt-services',
            template: __webpack_require__(/*! ./services.component.html */ "./src/app/views/pages/tacacs/access-control/services/services.component.html"),
            styles: [__webpack_require__(/*! ./services.component.scss */ "./src/app/views/pages/tacacs/access-control/services/services.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], ServicesComponent);
    return ServicesComponent;
}());
exports.ServicesComponent = ServicesComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/services/services.module.ts":
/*!*******************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/services/services.module.ts ***!
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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
//Form
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
//PortletModule
var portlet_module_1 = __webpack_require__(/*! ../../../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
// Core Module
var core_module_1 = __webpack_require__(/*! ../../../../../core/core.module */ "./src/app/core/core.module.ts");
var partials_module_1 = __webpack_require__(/*! ../../../../partials/partials.module */ "./src/app/views/partials/partials.module.ts");
var pages_module_1 = __webpack_require__(/*! ../../../pages.module */ "./src/app/views/pages/pages.module.ts");
var menu_1 = __webpack_require__(/*! @angular/material/menu */ "./node_modules/@angular/material/esm5/menu.es5.js");
//Form
var tac_service_form_module_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-service-form/tac-service-form.module */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.module.ts");
// import { FieldGeneralListComponent } from '../../../../partials/layout/tacgui/_fields/field-general-list/field-general-list.component';
var services_component_1 = __webpack_require__(/*! ./services.component */ "./src/app/views/pages/tacacs/access-control/services/services.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/tacacs/access-control/services/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/tacacs/access-control/services/edit/edit.component.ts");
var ServicesModule = /** @class */ (function () {
    function ServicesModule() {
    }
    ServicesModule = __decorate([
        core_1.NgModule({
            declarations: [services_component_1.ServicesComponent, add_component_1.AddComponent, edit_component_1.EditComponent],
            imports: [
                common_1.CommonModule,
                ng_bootstrap_1.NgbModule,
                partials_module_1.PartialsModule,
                forms_1.FormsModule,
                portlet_module_1.PortletModule,
                core_module_1.CoreModule,
                pages_module_1.PagesModule,
                tac_service_form_module_1.TacServiceFormModule,
                menu_1.MatMenuModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: services_component_1.ServicesComponent
                    },
                    {
                        path: 'add',
                        component: add_component_1.AddComponent
                    },
                    {
                        path: 'edit/:id',
                        component: edit_component_1.EditComponent
                    },
                ])
            ]
        })
    ], ServicesModule);
    return ServicesModule;
}());
exports.ServicesModule = ServicesModule;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.html":
/*!*****************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.html ***!
  \*****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n   <ngb-tabset type=\"pills\">\n      <ngb-tab title=\"General\">\n        <ng-template ngbTabContent>\n          <div class=\"row\">\n            <div class=\"col-6\">\n              <div class=\"form-group row\">\n                <div class=\"col-2\">\n                  <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n                    <label>\n                      <input type=\"checkbox\" checked [(ngModel)]=\"options.data.cisco_rs_enable\">\n                      <span></span>\n                    </label>\n                  </span>\n                </div>\n                <label class=\"col-10 col-form-label\">Pattern Activated</label>\n              </div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-4\">\n              <div class=\"form-group\">\n                <label>Privilege Level</label>\n                <input type=\"number\" class=\"form-control form-control-sm\"\n                    [ngClass]=\"{ 'is-invalid' : (validation | async)?.cisco_rs_privlvl }\"\n                    [(ngModel)]=\"options.data.cisco_rs_privlvl\" placeholder=\"Privilege Level\">\n                    <!-- is-invalid -->\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.cisco_rs_privlvl;\">{{message}}</p>\n                </div>\n                <span class=\"form-text text-muted\"></span>\n              </div>\n            </div>\n            <div class=\"col-4\">\n\n                  <div class=\"form-group\">\n          \t\t\t\t\t<label style=\"width: 100%;\">Default command</label>\n          \t\t\t\t\t\t<span class=\"kt-switch kt-switch--icon kt-switch--outline kt-switch--success\">\n          \t\t\t\t\t\t\t<label>\n          \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"options.data.cisco_rs_def_cmd\">\n          \t\t\t\t\t\t\t\t<span></span>\n          \t\t\t\t\t\t\t</label>\n          \t\t\t\t\t\t</span>\n          \t\t\t\t</div>\n\n            </div>\n            <div class=\"col-4\">\n\n                  <div class=\"form-group\">\n          \t\t\t\t\t<label style=\"width: 100%;\">Default attribute</label>\n          \t\t\t\t\t\t<span class=\"kt-switch kt-switch--icon kt-switch--outline kt-switch--success\">\n          \t\t\t\t\t\t\t<label>\n          \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"options.data.cisco_rs_def_attr\">\n          \t\t\t\t\t\t\t\t<span></span>\n          \t\t\t\t\t\t\t</label>\n          \t\t\t\t\t\t</span>\n          \t\t\t\t</div>\n\n            </div>\n          </div>\n          <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n              <div class=\"card\">\n                  <div class=\"card-header\">\n                      <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMCG }\" data-toggle=\"collapse\" (click)=\"notCollapsedMCG = !notCollapsedMCG\"\n                              [attr.aria-expanded]=\"!notCollapsedMCG\">Manual Configuration</div>\n                  </div>\n                  <div [ngbCollapse]=\"!notCollapsedMCG\">\n                      <div class=\"card-body\">\n                        <div class=\"form-group\">\n                          <label class=\"pull-right\">Manual Configuration</label>\n                          <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.cisco_rs_manual\" rows=\"5\"></textarea>\n                        </div>\n                      </div>\n                  </div>\n              </div>\n          </div>\n        </ng-template>\n      </ngb-tab>\n\n      <ngb-tab title=\"CMD Set\">\n        <ng-template ngbTabContent>\n          <div class=\"row\">\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n                <kt-field-general-list [data]=\"options.data.cisco_rs_cmd\"\n                  [params]=\"list.cisco_rs_cmd\"\n                  [errors]=\"(validation | async)?.cisco_rs_cmd\"\n                  (returnData)=\"setCmdSet($event)\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.cisco_rs_cmd }\" >\n                </kt-field-general-list>\n                <span class=\"form-text text-muted\"></span>\n\n              </div>\n            </div>\n          </div>\n        </ng-template>\n      </ngb-tab>\n\n      <ngb-tab title=\"Auto CMD\">\n        <ng-template ngbTabContent>\n          <div class=\"form-group form-group-last\">\n\t\t\t\t\t\t<label for=\"exampleTextarea\">Auto Commands</label>\n\t\t\t\t\t\t<textarea class=\"form-control\" [(ngModel)]=\"options.data.cisco_rs_autocmd\" rows=\"3\"></textarea>\n            <span class=\"form-text text-muted\">set semicolon sepparated commands, e.g. <i>show version; show clock</i></span>\n\t\t\t\t\t</div>\n        </ng-template>\n      </ngb-tab>\n\n      <ngb-tab title=\"Nexus Roles\">\n        <ng-template ngbTabContent>\n          <div class=\"form-group form-group-last\">\n\t\t\t\t\t\t<label for=\"exampleTextarea\">Nexus Roles</label>\n\t\t\t\t\t\t<textarea class=\"form-control\" [(ngModel)]=\"options.data.cisco_rs_nexus_roles\" rows=\"3\"></textarea>\n            <span class=\"form-text text-muted\">set space sepparated roles, e.g. <i>network-admin vdc-admin vdc-operator</i></span>\n\t\t\t\t\t</div>\n        </ng-template>\n      </ngb-tab>\n    </ngb-tabset>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.scss":
/*!*****************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.scss ***!
  \*****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vY2lzY28tZ2VuZXJhbC9jaXNjby1nZW5lcmFsLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.ts":
/*!***************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.ts ***!
  \***************************************************************************************************************/
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
var CiscoGeneralComponent = /** @class */ (function () {
    function CiscoGeneralComponent() {
        this.list = {
            cisco_rs_cmd: {
                multiple: true,
                title: 'Command Sets',
                title_sidebar: 'Command Sets',
                search: true,
                apiurl: 'api/obj/cmd/list/',
                addNew: 'cmd',
                type: 0
            },
        };
    }
    CiscoGeneralComponent.prototype.ngOnInit = function () {
    };
    CiscoGeneralComponent.prototype.setCmdSet = function (data) {
        this.options.data.cisco_rs_cmd = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], CiscoGeneralComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], CiscoGeneralComponent.prototype, "validation", void 0);
    CiscoGeneralComponent = __decorate([
        core_1.Component({
            selector: 'kt-cisco-general',
            template: __webpack_require__(/*! ./cisco-general.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.html"),
            styles: [__webpack_require__(/*! ./cisco-general.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], CiscoGeneralComponent);
    return CiscoGeneralComponent;
}());
exports.CiscoGeneralComponent = CiscoGeneralComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.html":
/*!*********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.html ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group row\">\n      <div class=\"col-2\">\n        <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n          <label>\n            <input type=\"checkbox\" checked [(ngModel)]=\"options.data.cisco_wlc_enable\">\n            <span></span>\n          </label>\n        </span>\n      </div>\n      <label class=\"col-10 col-form-label\">Pattern Activated</label>\n    </div>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"form-group col-sm-5 col-md-4\">\n    <label>Role List</label>\n    <select multiple class=\"form-control\" size=\"10\">\n      <ng-container *ngFor=\"let role of wlc_roles\">\n        <option *ngIf=\"!this.options.data.cisco_wlc_roles.includes(role.value)\" (click)=\"selectRole(role.value)\">{{role.title}}</option>\n      </ng-container>\n    </select>\n    <input type=\"hidden\" name=\"cisco_wlc_roles\" data-type=\"input\" data-default=\"\" data-pickup=\"true\">\n    <input type=\"hidden\" name=\"cisco_wlc_roles_native\">\n  </div>\n  <div class=\"form-group col-md-4 col-sm-5\">\n    <label>Selected Roles</label>\n    <select multiple=\"\" class=\"form-control\" size=\"10\">\n      <ng-container *ngFor=\"let role of wlc_roles\">\n        <option *ngIf=\"this.options.data.cisco_wlc_roles.includes(role.value)\" (click)=\"deselectRole(selected.indexOf(role.value))\">{{role.title}}</option>\n      </ng-container>\n    </select>\n  </div>\n</div>\n\n<div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n    <div class=\"card\">\n        <div class=\"card-header\">\n            <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMCWLC }\" data-toggle=\"collapse\" (click)=\"notCollapsedMCWLC = !notCollapsedMCWLC\"\n                    [attr.aria-expanded]=\"!notCollapsedMCWLC\">Manual Configuration</div>\n        </div>\n        <div [ngbCollapse]=\"!notCollapsedMCWLC\">\n            <div class=\"card-body\">\n              <div class=\"form-group\">\n                <label class=\"pull-right\">Manual Configuration</label>\n                <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.cisco_wlc_manual\" rows=\"5\"></textarea>\n              </div>\n            </div>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.scss":
/*!*********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.scss ***!
  \*********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vY2lzY28td2xjL2Npc2NvLXdsYy5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.ts":
/*!*******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.ts ***!
  \*******************************************************************************************************/
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
var CiscoWlcComponent = /** @class */ (function () {
    function CiscoWlcComponent() {
        this.wlc_roles = [
            { title: 'Admin (0)', value: 0 },
            { title: 'LOBBY (2)', value: 2 },
            { title: 'MONITOR (4)', value: 4 },
            { title: 'WLAN (8)', value: 8 },
            { title: 'CONTROLLER (10)', value: 10 },
            { title: 'WIRELESS (20)', value: 20 },
            { title: 'SECURITY (40)', value: 40 },
            { title: 'MANAGEMENT (80)', value: 80 },
            { title: 'COMMANDS (100)', value: 100 },
        ];
        this.selected = [];
    }
    CiscoWlcComponent.prototype.ngOnInit = function () {
        console.log(this.options.data.cisco_wlc_roles);
    };
    CiscoWlcComponent.prototype.selectRole = function (e) {
        this.options.data.cisco_wlc_roles.push(e);
    };
    CiscoWlcComponent.prototype.deselectRole = function (i) {
        this.options.data.cisco_wlc_roles.splice(i, 1);
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], CiscoWlcComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], CiscoWlcComponent.prototype, "validation", void 0);
    CiscoWlcComponent = __decorate([
        core_1.Component({
            selector: 'kt-cisco-wlc',
            template: __webpack_require__(/*! ./cisco-wlc.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.html"),
            styles: [__webpack_require__(/*! ./cisco-wlc.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], CiscoWlcComponent);
    return CiscoWlcComponent;
}());
exports.CiscoWlcComponent = CiscoWlcComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.html":
/*!*********************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.html ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group row\">\n      <div class=\"col-2\">\n        <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n          <label>\n            <input type=\"checkbox\" checked [(ngModel)]=\"options.data.fortios_enable\">\n            <span></span>\n          </label>\n        </span>\n      </div>\n      <label class=\"col-10 col-form-label\">Pattern Activated</label>\n    </div>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label>Admin Profile</label>\n      <input type=\"text\" class=\"form-control form-control-sm\"\n          [ngClass]=\"{ 'is-invalid' : (validation | async)?.fortios_admin_prof }\"\n          [(ngModel)]=\"options.data.fortios_admin_prof\" placeholder=\"Admin Profile\">\n          <!-- is-invalid -->\n      <div class=\"invalid-feedback\">\n        <p *ngFor=\"let message of (validation | async)?.fortios_admin_prof;\">{{message}}</p>\n      </div>\n      <span class=\"form-text text-muted\">admin_prof attribute, pre-configured administrator profile name</span>\n    </div>\n  </div>\n</div>\n\n<div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n    <div class=\"card\">\n        <div class=\"card-header\">\n            <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMFOS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMFOS = !notCollapsedMFOS\"\n                    [attr.aria-expanded]=\"!notCollapsedMFOS\">Manual Configuration</div>\n        </div>\n        <div [ngbCollapse]=\"!notCollapsedMFOS\">\n            <div class=\"card-body\">\n              <div class=\"form-group\">\n                <label class=\"pull-right\">Manual Configuration</label>\n                <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.fortios_manual\" rows=\"5\"></textarea>\n              </div>\n            </div>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.scss":
/*!*********************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.scss ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vZm9ydGlvcy1nZW5lcmFsL2ZvcnRpb3MtZ2VuZXJhbC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.ts":
/*!*******************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.ts ***!
  \*******************************************************************************************************************/
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
var FortiosGeneralComponent = /** @class */ (function () {
    function FortiosGeneralComponent() {
    }
    FortiosGeneralComponent.prototype.ngOnInit = function () {
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], FortiosGeneralComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], FortiosGeneralComponent.prototype, "validation", void 0);
    FortiosGeneralComponent = __decorate([
        core_1.Component({
            selector: 'kt-fortios-general',
            template: __webpack_require__(/*! ./fortios-general.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.html"),
            styles: [__webpack_require__(/*! ./fortios-general.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], FortiosGeneralComponent);
    return FortiosGeneralComponent;
}());
exports.FortiosGeneralComponent = FortiosGeneralComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.html":
/*!*************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.html ***!
  \*************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n   <ngb-tabset type=\"pills\">\n      <ngb-tab title=\"General\">\n        <ng-template ngbTabContent>\n          <div class=\"row\">\n            <div class=\"col-6\">\n              <div class=\"form-group row\">\n                <div class=\"col-2\">\n                  <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n                    <label>\n                      <input type=\"checkbox\" checked [(ngModel)]=\"options.data.h3c_enable\">\n                      <span></span>\n                    </label>\n                  </span>\n                </div>\n                <label class=\"col-10 col-form-label\">Pattern Activated</label>\n              </div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-4\">\n              <div class=\"form-group\">\n                <label>Privilege Level</label>\n                <input type=\"number\" class=\"form-control form-control-sm\"\n                    [ngClass]=\"{ 'is-invalid' : (validation | async)?.h3c_privlvl }\"\n                    [(ngModel)]=\"options.data.h3c_privlvl\" placeholder=\"Privilege Level\">\n                    <!-- is-invalid -->\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.h3c_privlvl;\">{{message}}</p>\n                </div>\n                <span class=\"form-text text-muted\"></span>\n              </div>\n            </div>\n            <div class=\"col-4\">\n\n                  <div class=\"form-group\">\n          \t\t\t\t\t<label style=\"width: 100%;\">Default command</label>\n          \t\t\t\t\t\t<span class=\"kt-switch kt-switch--icon kt-switch--outline kt-switch--success\">\n          \t\t\t\t\t\t\t<label>\n          \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"options.data.h3c_def_cmd\">\n          \t\t\t\t\t\t\t\t<span></span>\n          \t\t\t\t\t\t\t</label>\n          \t\t\t\t\t\t</span>\n          \t\t\t\t</div>\n\n            </div>\n            <div class=\"col-4\">\n\n                  <div class=\"form-group\">\n          \t\t\t\t\t<label style=\"width: 100%;\">Default attribute</label>\n          \t\t\t\t\t\t<span class=\"kt-switch kt-switch--icon kt-switch--outline kt-switch--success\">\n          \t\t\t\t\t\t\t<label>\n          \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"options.data.h3c_def_attr\">\n          \t\t\t\t\t\t\t\t<span></span>\n          \t\t\t\t\t\t\t</label>\n          \t\t\t\t\t\t</span>\n          \t\t\t\t</div>\n\n            </div>\n          </div>\n          <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n              <div class=\"card\">\n                  <div class=\"card-header\">\n                      <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMH3C }\" data-toggle=\"collapse\" (click)=\"notCollapsedMH3C = !notCollapsedMH3C\"\n                              [attr.aria-expanded]=\"!notCollapsedMH3C\">Manual Configuration</div>\n                  </div>\n                  <div [ngbCollapse]=\"!notCollapsedMH3C\">\n                      <div class=\"card-body\">\n                        <div class=\"form-group\">\n                          <label class=\"pull-right\">Manual Configuration</label>\n                          <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.h3c_manual\" rows=\"5\"></textarea>\n                        </div>\n                      </div>\n                  </div>\n              </div>\n          </div>\n        </ng-template>\n      </ngb-tab>\n\n      <ngb-tab title=\"CMD Set\">\n        <ng-template ngbTabContent>\n          <div class=\"row\">\n            <div class=\"col-6\">\n              <div class=\"form-group usergroup-list\">\n                <kt-field-general-list [data]=\"options.data.h3c_cmd\"\n                  [params]=\"list.h3c_cmd\"\n                  [errors]=\"(validation | async)?.h3c_cmd\"\n                  (returnData)=\"setCmdSet($event)\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.h3c_cmd }\" >\n                </kt-field-general-list>\n                <span class=\"form-text text-muted\"></span>\n\n              </div>\n            </div>\n          </div>\n        </ng-template>\n      </ngb-tab>\n\n    </ngb-tabset>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.scss":
/*!*************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.scss ***!
  \*************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vaDNjLWdlbmVyYWwvaDNjLWdlbmVyYWwuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.ts":
/*!***********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.ts ***!
  \***********************************************************************************************************/
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
var H3cGeneralComponent = /** @class */ (function () {
    function H3cGeneralComponent() {
        this.list = {
            h3c_cmd: {
                multiple: true,
                title: 'Command Sets',
                title_sidebar: 'Command Sets',
                search: true,
                apiurl: 'api/obj/cmd/list/',
            },
        };
    }
    H3cGeneralComponent.prototype.ngOnInit = function () {
    };
    H3cGeneralComponent.prototype.setCmdSet = function (data) {
        this.options.data.h3c_cmd = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], H3cGeneralComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], H3cGeneralComponent.prototype, "validation", void 0);
    H3cGeneralComponent = __decorate([
        core_1.Component({
            selector: 'kt-h3c-general',
            template: __webpack_require__(/*! ./h3c-general.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.html"),
            styles: [__webpack_require__(/*! ./h3c-general.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], H3cGeneralComponent);
    return H3cGeneralComponent;
}());
exports.H3cGeneralComponent = H3cGeneralComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.html":
/*!*******************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.html ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<p>\n  huawei-general works!\n</p>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.scss":
/*!*******************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.scss ***!
  \*******************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vaHVhd2VpLWdlbmVyYWwvaHVhd2VpLWdlbmVyYWwuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.ts":
/*!*****************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.ts ***!
  \*****************************************************************************************************************/
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
var HuaweiGeneralComponent = /** @class */ (function () {
    function HuaweiGeneralComponent() {
    }
    HuaweiGeneralComponent.prototype.ngOnInit = function () {
    };
    HuaweiGeneralComponent = __decorate([
        core_1.Component({
            selector: 'kt-huawei-general',
            template: __webpack_require__(/*! ./huawei-general.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.html"),
            styles: [__webpack_require__(/*! ./huawei-general.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], HuaweiGeneralComponent);
    return HuaweiGeneralComponent;
}());
exports.HuaweiGeneralComponent = HuaweiGeneralComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.html":
/*!*********************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.html ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n   <ngb-tabset type=\"pills\">\n      <ngb-tab title=\"General\">\n        <ng-template ngbTabContent>\n          <div class=\"row\">\n            <div class=\"col-6\">\n              <div class=\"form-group row\">\n                <div class=\"col-2\">\n                  <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n                    <label>\n                      <input type=\"checkbox\" checked [(ngModel)]=\"options.data.junos_enable\">\n                      <span></span>\n                    </label>\n                  </span>\n                </div>\n                <label class=\"col-10 col-form-label\">Pattern Activated</label>\n              </div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n                <label>Local User Name</label>\n                <input type=\"text\" class=\"form-control form-control-sm\"\n                    [ngClass]=\"{ 'is-invalid' : (validation | async)?.junos_username }\"\n                    [(ngModel)]=\"options.data.junos_username\" placeholder=\"local-user-name\">\n                    <!-- is-invalid -->\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.junos_username;\">{{message}}</p>\n                </div>\n                <span class=\"form-text text-muted\">local-user-name attribute</span>\n              </div>\n            </div>\n          </div>\n          <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n              <div class=\"card\">\n                  <div class=\"card-header\">\n                      <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMJOS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMJOS = !notCollapsedMJOS\"\n                              [attr.aria-expanded]=\"!notCollapsedMJOS\">Manual Configuration</div>\n                  </div>\n                  <div [ngbCollapse]=\"!notCollapsedMJOS\">\n                      <div class=\"card-body\">\n                        <div class=\"form-group\">\n                          <label class=\"pull-right\">Manual Configuration</label>\n                          <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.junos_manual\" rows=\"5\"></textarea>\n                        </div>\n                      </div>\n                  </div>\n              </div>\n          </div>\n        </ng-template>\n      </ngb-tab>\n\n      <ngb-tab title=\"Operational mode\">\n        <ng-template ngbTabContent>\n\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group\">\n                <small>Here you can allow/deny commands inside of operational mode ( <kbd>&gt;</kbd> ).</small>\n              </div>\n            </div>\n            <br>\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n                <kt-field-general-list [data]=\"options.data.junos_cmd_ao\"\n                  [params]=\"list.junos_cmd_ao\"\n                  [errors]=\"(validation | async)?.junos_cmd_ao\"\n                  (returnData)=\"setAOSet($event)\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.junos_cmd_ao }\" >\n                </kt-field-general-list>\n                <span class=\"form-text text-muted\">list of command sets, that will be used to allow commands inside of the operation mode</span>\n\n              </div>\n            </div>\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n                <kt-field-general-list [data]=\"options.data.junos_cmd_do\"\n                  [params]=\"list.junos_cmd_do\"\n                  [errors]=\"(validation | async)?.junos_cmd_do\"\n                  (returnData)=\"setDOSet($event)\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.junos_cmd_do }\" >\n                </kt-field-general-list>\n                <span class=\"form-text text-muted\">list of command sets, that will be used to deny commands inside of the operation mode</span>\n\n              </div>\n            </div>\n          </div>\n        </ng-template>\n      </ngb-tab>\n\n      <ngb-tab title=\"Configuration mode\">\n        <ng-template ngbTabContent>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group\">\n                <small>Here you can allow/deny commands inside of configuration mode ( <kbd>#</kbd> ).</small>\n              </div>\n            </div>\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n                <kt-field-general-list [data]=\"options.data.junos_cmd_ac\"\n                  [params]=\"list.junos_cmd_ac\"\n                  [errors]=\"(validation | async)?.junos_cmd_ac\"\n                  (returnData)=\"setACSet($event)\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.junos_cmd_ac }\" >\n                </kt-field-general-list>\n                <span class=\"form-text text-muted\">list of command sets, that will be used to allow commands inside of the configuration mode</span>\n\n              </div>\n            </div>\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n                <kt-field-general-list [data]=\"options.data.junos_cmd_dc\"\n                  [params]=\"list.junos_cmd_dc\"\n                  [errors]=\"(validation | async)?.junos_cmd_dc\"\n                  (returnData)=\"setDCSet($event)\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.junos_cmd_dc }\" >\n                </kt-field-general-list>\n                <span class=\"form-text text-muted\">list of command sets, that will be used to deny commands inside of the configuration mode</span>\n\n              </div>\n            </div>\n          </div>\n        </ng-template>\n      </ngb-tab>\n\n    </ngb-tabset>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.scss":
/*!*********************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.scss ***!
  \*********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vanVuaXBlci1nZW5lcmFsL2p1bmlwZXItZ2VuZXJhbC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.ts":
/*!*******************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.ts ***!
  \*******************************************************************************************************************/
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
var JuniperGeneralComponent = /** @class */ (function () {
    function JuniperGeneralComponent() {
        this.list = {
            junos_cmd_ao: {
                multiple: true,
                title: 'Allow Command Sets',
                title_sidebar: 'JunOS CMD Sets',
                search: true,
                apiurl: 'api/obj/cmd/list/junos/',
                addNew: 'cmd',
                type: 1
            },
            junos_cmd_do: {
                multiple: true,
                title: 'Deny Command Sets',
                title_sidebar: 'JunOS CMD Sets',
                search: true,
                apiurl: 'api/obj/cmd/list/junos/',
                addNew: 'cmd',
                type: 1
            },
            junos_cmd_ac: {
                multiple: true,
                title: 'Allow Configuration Command Sets',
                title_sidebar: 'JunOS CMD Sets',
                search: true,
                apiurl: 'api/obj/cmd/list/junos/',
                addNew: 'cmd',
                type: 1
            },
            junos_cmd_dc: {
                multiple: true,
                title: 'Deny Configuration Command Sets',
                title_sidebar: 'JunOS CMD Sets',
                search: true,
                apiurl: 'api/obj/cmd/list/junos/',
                addNew: 'cmd',
                type: 1
            },
        };
    }
    JuniperGeneralComponent.prototype.ngOnInit = function () {
    };
    JuniperGeneralComponent.prototype.setAOSet = function (data) {
        this.options.data.junos_cmd_ao = data;
    };
    JuniperGeneralComponent.prototype.setDOSet = function (data) {
        this.options.data.junos_cmd_do = data;
    };
    JuniperGeneralComponent.prototype.setACSet = function (data) {
        this.options.data.junos_cmd_ac = data;
    };
    JuniperGeneralComponent.prototype.setDCSet = function (data) {
        this.options.data.junos_cmd_dc = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], JuniperGeneralComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], JuniperGeneralComponent.prototype, "validation", void 0);
    JuniperGeneralComponent = __decorate([
        core_1.Component({
            selector: 'kt-juniper-general',
            template: __webpack_require__(/*! ./juniper-general.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.html"),
            styles: [__webpack_require__(/*! ./juniper-general.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], JuniperGeneralComponent);
    return JuniperGeneralComponent;
}());
exports.JuniperGeneralComponent = JuniperGeneralComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.html":
/*!***********************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.html ***!
  \***********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group row\">\n      <div class=\"col-2\">\n        <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n          <label>\n            <input type=\"checkbox\" checked [(ngModel)]=\"options.data.paloalto_enable\">\n            <span></span>\n          </label>\n        </span>\n      </div>\n      <label class=\"col-10 col-form-label\">Pattern Activated</label>\n    </div>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label>PaloAlto Admin Role</label>\n      <div class=\"input-group\">\n        <div class=\"input-group-prepend\">\n          <button class=\"btn btn-default btn-sm btn-icon\"\n            ngbPopover=\"a default (dynamic) administrative role name or a custom administrative role name on the firewall\"\n            triggers=\"mouseenter:mouseleave\">\n            <i class=\"fa fa-info\"></i>\n          </button>\n        </div>\n        <input type=\"text\" class=\"form-control form-control-sm\"\n            [ngClass]=\"{ 'is-invalid' : (validation | async)?.paloalto_admin_role }\"\n            [(ngModel)]=\"options.data.paloalto_admin_role\" placeholder=\"PaloAlto Admin Role\">\n      </div>\n\n      <div class=\"invalid-feedback\">\n        <p *ngFor=\"let message of (validation | async)?.paloalto_admin_role;\">{{message}}</p>\n      </div>\n      <span class=\"form-text text-muted\"></span>\n    </div>\n  </div>\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label>PaloAlto Admin Access Domain</label>\n      <div class=\"input-group\">\n        <div class=\"input-group-prepend\">\n          <button class=\"btn btn-default btn-sm btn-icon\"\n            ngbPopover=\"the name of an access domain for firewall administrators (configured in the DeviceAccess Domains page). Define this VSA if the firewall has multiple virtual systems\"\n            triggers=\"mouseenter:mouseleave\">\n            <i class=\"fa fa-info\"></i>\n          </button>\n        </div>\n        <input type=\"text\" class=\"form-control form-control-sm\"\n            [ngClass]=\"{ 'is-invalid' : (validation | async)?.paloalto_admin_domain }\"\n            [(ngModel)]=\"options.data.paloalto_admin_domain\" placeholder=\"PaloAlto Admin Access Domain\">\n      </div>\n      <div class=\"invalid-feedback\">\n        <p *ngFor=\"let message of (validation | async)?.paloalto_admin_domain;\">{{message}}</p>\n      </div>\n      <span class=\"form-text text-muted\"></span>\n    </div>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label>PaloAlto Panorama Admin Role</label>\n      <div class=\"input-group\">\n        <div class=\"input-group-prepend\">\n          <button class=\"btn btn-default btn-sm btn-icon\"\n            ngbPopover=\"a default (dynamic) administrative role name or a custom administrative role name on Panorama\"\n            triggers=\"mouseenter:mouseleave\">\n            <i class=\"fa fa-info\"></i>\n          </button>\n        </div>\n        <input type=\"text\" class=\"form-control form-control-sm\"\n            [ngClass]=\"{ 'is-invalid' : (validation | async)?.paloalto_panorama_admin_role }\"\n            [(ngModel)]=\"options.data.paloalto_panorama_admin_role\" placeholder=\"PaloAlto Admin Role\">\n      </div>\n\n      <div class=\"invalid-feedback\">\n        <p *ngFor=\"let message of (validation | async)?.paloalto_panorama_admin_role;\">{{message}}</p>\n      </div>\n      <span class=\"form-text text-muted\"></span>\n    </div>\n  </div>\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label>PaloAlto Panorama Admin Access Domain</label>\n      <div class=\"input-group\">\n        <div class=\"input-group-prepend\">\n          <button class=\"btn btn-default btn-sm btn-icon\"\n            ngbPopover=\"the name of an access domain for Device Group and Template administrators (configured in the PanoramaAccess Domains page)\"\n            triggers=\"mouseenter:mouseleave\">\n            <i class=\"fa fa-info\"></i>\n          </button>\n        </div>\n        <input type=\"text\" class=\"form-control form-control-sm\"\n            [ngClass]=\"{ 'is-invalid' : (validation | async)?.paloalto_panorama_admin_domain }\"\n            [(ngModel)]=\"options.data.paloalto_panorama_admin_domain\" placeholder=\"PaloAlto Admin Access Domain\">\n      </div>\n      <div class=\"invalid-feedback\">\n        <p *ngFor=\"let message of (validation | async)?.paloalto_panorama_admin_domain;\">{{message}}</p>\n      </div>\n      <span class=\"form-text text-muted\"></span>\n    </div>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label>PaloAlto User Group</label>\n      <div class=\"input-group\">\n        <div class=\"input-group-prepend\">\n          <button class=\"btn btn-default btn-sm btn-icon\"\n            ngbPopover=\"the name of a user group in the Allow List of an authentication profile\"\n            triggers=\"mouseenter:mouseleave\">\n            <i class=\"fa fa-info\"></i>\n          </button>\n        </div>\n        <input type=\"text\" class=\"form-control form-control-sm\"\n            [ngClass]=\"{ 'is-invalid' : (validation | async)?.paloalto_user_group }\"\n            [(ngModel)]=\"options.data.paloalto_user_group\" placeholder=\"PaloAlto Admin Role\">\n      </div>\n\n      <div class=\"invalid-feedback\">\n        <p *ngFor=\"let message of (validation | async)?.paloalto_user_group;\">{{message}}</p>\n      </div>\n      <span class=\"form-text text-muted\"></span>\n    </div>\n  </div>\n</div>\n\n<div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n    <div class=\"card\">\n        <div class=\"card-header\">\n            <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMFOS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMFOS = !notCollapsedMFOS\"\n                    [attr.aria-expanded]=\"!notCollapsedMFOS\">Manual Configuration</div>\n        </div>\n        <div [ngbCollapse]=\"!notCollapsedMFOS\">\n            <div class=\"card-body\">\n              <div class=\"form-group\">\n                <label class=\"pull-right\">Manual Configuration</label>\n                <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.paloalto_manual\" rows=\"5\"></textarea>\n              </div>\n            </div>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.scss":
/*!***********************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.scss ***!
  \***********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vcGFsb2FsdG8tZ2VuZXJhbC9wYWxvYWx0by1nZW5lcmFsLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.ts":
/*!*********************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.ts ***!
  \*********************************************************************************************************************/
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
var PaloaltoGeneralComponent = /** @class */ (function () {
    function PaloaltoGeneralComponent() {
    }
    PaloaltoGeneralComponent.prototype.ngOnInit = function () {
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], PaloaltoGeneralComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], PaloaltoGeneralComponent.prototype, "validation", void 0);
    PaloaltoGeneralComponent = __decorate([
        core_1.Component({
            selector: 'kt-paloalto-general',
            template: __webpack_require__(/*! ./paloalto-general.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.html"),
            styles: [__webpack_require__(/*! ./paloalto-general.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], PaloaltoGeneralComponent);
    return PaloaltoGeneralComponent;
}());
exports.PaloaltoGeneralComponent = PaloaltoGeneralComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/service.model.ts":
/*!***************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/service.model.ts ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var Service = /** @class */ (function () {
    function Service() {
    }
    Service.prototype.empty = function () {
        //General Config
        this.id = undefined;
        this.name = '';
        this.manual = '';
        this.manual_conf_only = 0;
        //Service Start
        //Activated//
        this.cisco_rs_enable = 0;
        this.cisco_wlc_enable = 0;
        this.fortios_enable = 0;
        this.h3c_enable = 0;
        this.junos_enable = 0;
        this.paloalto_enable = 0;
        this.silverpeak_enable = 0;
        //Manual//
        this.cisco_rs_manual = '';
        this.cisco_wlc_manual = '';
        this.fortios_manual = '';
        this.h3c_manual = '';
        this.junos_manual = '';
        this.paloalto_manual = '';
        this.silverpeak_manual = '';
        //WLC
        this.cisco_wlc_roles = [];
        //Cisco general
        this.cisco_rs_def_attr = 1;
        this.cisco_rs_def_cmd = 1;
        this.cisco_rs_privlvl = 15;
        this.cisco_rs_cmd = [];
        this.cisco_rs_autocmd = '';
        this.cisco_rs_nexus_roles = '';
        //Juniper
        this.junos_username = '';
        this.junos_cmd_ac = [];
        this.junos_cmd_ao = [];
        this.junos_cmd_dc = [];
        this.junos_cmd_do = [];
        //H3C
        this.h3c_cmd = [];
        this.h3c_privlvl = 15;
        this.h3c_def_attr = 1;
        this.h3c_def_cmd = 1;
        //FortiOS
        this.fortios_admin_prof = '';
        //Silver Peak
        this.silverpeak_role = 'admin';
        //paloalto
        this.paloalto_admin_domain = '';
        this.paloalto_admin_role = '';
        this.paloalto_panorama_admin_domain = '';
        this.paloalto_panorama_admin_role = '';
        this.paloalto_user_group = '';
    };
    return Service;
}());
exports.Service = Service;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.html":
/*!***************************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.html ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group row\">\n      <div class=\"col-2\">\n        <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--success\">\n          <label>\n            <input type=\"checkbox\" checked [(ngModel)]=\"options.data.silverpeak_enable\">\n            <span></span>\n          </label>\n        </span>\n      </div>\n      <label class=\"col-10 col-form-label\">Pattern Activated</label>\n    </div>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label>Role</label>\n      <select class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.silverpeak_role\">\n        <option value=\"admin\" selected=\"\">admin</option>\n        <option value=\"monitor\">monitor</option>\n      </select>\n    </div>\n  </div>\n</div>\n\n<div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n    <div class=\"card\">\n        <div class=\"card-header\">\n            <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMFOS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMFOS = !notCollapsedMFOS\"\n                    [attr.aria-expanded]=\"!notCollapsedMFOS\">Manual Configuration</div>\n        </div>\n        <div [ngbCollapse]=\"!notCollapsedMFOS\">\n            <div class=\"card-body\">\n              <div class=\"form-group\">\n                <label class=\"pull-right\">Manual Configuration</label>\n                <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.silverpeak_manual\" rows=\"5\"></textarea>\n              </div>\n            </div>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.scss":
/*!***************************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.scss ***!
  \***************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vc2lsdmVycGVhay1nZW5lcmFsL3NpbHZlcnBlYWstZ2VuZXJhbC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.ts":
/*!*************************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.ts ***!
  \*************************************************************************************************************************/
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
var SilverpeakGeneralComponent = /** @class */ (function () {
    function SilverpeakGeneralComponent() {
    }
    SilverpeakGeneralComponent.prototype.ngOnInit = function () {
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], SilverpeakGeneralComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], SilverpeakGeneralComponent.prototype, "validation", void 0);
    SilverpeakGeneralComponent = __decorate([
        core_1.Component({
            selector: 'kt-silverpeak-general',
            template: __webpack_require__(/*! ./silverpeak-general.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.html"),
            styles: [__webpack_require__(/*! ./silverpeak-general.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], SilverpeakGeneralComponent);
    return SilverpeakGeneralComponent;
}());
exports.SilverpeakGeneralComponent = SilverpeakGeneralComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.html":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.html ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <button class=\"btn btn-sm btn-dark\" mat-button [matMenuTriggerFor]=\"animals\">Service Patterns</button>\n\n            <mat-menu #animals=\"matMenu\">\n              <a class=\"kt-menu__link\" mat-menu-item [matMenuTriggerFor]=\"ciscosys\">Cisco Systems</a>\n              <a mat-menu-item [matMenuTriggerFor]=\"juniper\">Juniper</a>\n              <a mat-menu-item [matMenuTriggerFor]=\"h3c\">H3C</a>\n              <a mat-menu-item (click)=\"trigger('huawei_enable')\">\n                <i class=\"la\" [ngClass]=\"{ 'la-check-circle' : options.data.huawei_enable, 'la-circle' : !options.data.huawei_enable}\"></i> Huawei\n              </a>\n              <a mat-menu-item (click)=\"trigger('paloalto_enable')\">\n                <i class=\"la\" [ngClass]=\"{ 'la-check-circle' : options.data.paloalto_enable, 'la-circle' : !options.data.paloalto_enable}\"></i> Palo Alto\n              </a>\n              <a mat-menu-item (click)=\"trigger('fortios_enable')\">\n                <i class=\"la\" [ngClass]=\"{ 'la-check-circle' : options.data.fortios_enable, 'la-circle' : !options.data.fortios_enable}\"></i> FortiOS\n              </a>\n              <a mat-menu-item (click)=\"trigger('silverpeak_enable')\">\n                <i class=\"la\" [ngClass]=\"{ 'la-check-circle' : options.data.silverpeak_enable, 'la-circle' : !options.data.silverpeak_enable}\"></i> Silver Peak\n              </a>\n            </mat-menu>\n\n            <mat-menu #ciscosys=\"matMenu\">\n              <a mat-menu-item (click)=\"trigger('cisco_rs_enable')\">\n                <i class=\"la\" [ngClass]=\"{ 'la-check-circle' : options.data.cisco_rs_enable, 'la-circle' : !options.data.cisco_rs_enable}\"></i> Cisco General\n              </a>\n              <a mat-menu-item (click)=\"trigger('cisco_wlc_enable')\">\n                <i class=\"la\" [ngClass]=\"{ 'la-check-circle' : options.data.cisco_wlc_enable, 'la-circle' : !options.data.cisco_wlc_enable}\"></i> Cisco WLC\n              </a>\n            </mat-menu>\n\n            <mat-menu #juniper=\"matMenu\">\n              <a mat-menu-item (click)=\"trigger('junos_enable')\">\n                <i class=\"la\" [ngClass]=\"{ 'la-check-circle' : options.data.junos_enable, 'la-circle' : !options.data.junos_enable}\"></i> Juniper General\n              </a>\n            </mat-menu>\n\n            <mat-menu #h3c=\"matMenu\">\n              <a mat-menu-item (click)=\"trigger('h3c_enable')\">\n                <i class=\"la\" [ngClass]=\"{ 'la-check-circle' : options.data.h3c_enable, 'la-circle' : !options.data.h3c_enable}\"></i> H3C General\n              </a>\n            </mat-menu>\n\n          </div>\n        </div>\n        <br>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <ngb-tabset #t_main>\n              <ngb-tab title=\"General\" id=\"general-main\">\n                <ng-template ngbTabContent>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <label>Name</label>\n                        <input type=\"text\" class=\"form-control form-control-sm\"\n                            [ngClass]=\"{ 'is-invalid' : (validation | async)?.name }\"\n                            [(ngModel)]=\"options.data.name\" placeholder=\"Service Name\">\n                            <!-- is-invalid -->\n                        <div class=\"invalid-feedback\">\n                          <p *ngFor=\"let message of (validation | async)?.name;\">{{message}}</p>\n                        </div>\n                        <span class=\"form-text text-muted\">it should be unique, but you can change it later</span>\n                      </div>\n                    </div>\n                  </div>\n                  <!-- <div class=\"row\">\n                    <div class=\"col-6\"> -->\n                      <div class=\"form-group row\">\n                        <div class=\"col-2\">\n                          <span class=\"kt-switch kt-switch--sm kt-switch--outline kt-switch--warning\">\n                            <label>\n                              <input type=\"checkbox\" checked [(ngModel)]=\"options.data.manual_conf_only\">\n                              <span></span>\n                            </label>\n                          </span>\n                        </div>\n                        <label class=\"col-10 col-form-label\">Only manual configuration</label>\n                        <div class=\"col-12\">\n                          <span class=\"form-text text-muted\">if checked, only manual configuration will be used</span>\n                        </div>\n                      </div>\n                    <!-- </div>\n                  </div> -->\n                  <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n                      <div class=\"card\">\n                          <div class=\"card-header\">\n                              <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMS = !notCollapsedMS\"\n                                      [attr.aria-expanded]=\"!notCollapsedMS\">Manual Configuration</div>\n                          </div>\n                          <div [ngbCollapse]=\"!notCollapsedMS\">\n                              <div class=\"card-body\">\n                                <div class=\"form-group\">\n                                  <label class=\"pull-right\">Manual Configuration</label>\n                                  <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.manual\" rows=\"5\"></textarea>\n                                </div>\n                              </div>\n                          </div>\n                      </div>\n                  </div>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab title=\"Cisco General\" *ngIf=\"options.data.cisco_rs_enable\">\n                <ng-template ngbTabContent>\n                  <kt-cisco-general [options]=\"options\" [validation]=\"validation\">\n                  </kt-cisco-general>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab title=\"Cisco WLC\" *ngIf=\"options.data.cisco_wlc_enable\">\n                <ng-template ngbTabContent>\n                  <kt-cisco-wlc [options]=\"options\" [validation]=\"validation\">\n                  </kt-cisco-wlc>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab title=\"Juniper\" *ngIf=\"options.data.junos_enable\">\n                <ng-template ngbTabContent>\n                  <kt-juniper-general [options]=\"options\" [validation]=\"validation\">\n                  </kt-juniper-general>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab title=\"H3C\" *ngIf=\"options.data.h3c_enable\">\n                <ng-template ngbTabContent>\n                  <kt-h3c-general [options]=\"options\" [validation]=\"validation\">\n                  </kt-h3c-general>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab title=\"Huawei\" *ngIf=\"options.data.huawei_enable\">\n                <ng-template ngbTabContent>\n                  Soon...\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab title=\"Palo Alto\" *ngIf=\"options.data.paloalto_enable\">\n                <ng-template ngbTabContent>\n                  <kt-paloalto-general [options]=\"options\" [validation]=\"validation\">\n                  </kt-paloalto-general>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab title=\"FortiOS\" *ngIf=\"options.data.fortios_enable\">\n                <ng-template ngbTabContent>\n                  <kt-fortios-general [options]=\"options\" [validation]=\"validation\">\n                  </kt-fortios-general>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab title=\"Silver Peak\" *ngIf=\"options.data.silverpeak_enable\">\n                <ng-template ngbTabContent>\n                  <kt-silverpeak-general [options]=\"options\" [validation]=\"validation\">\n                  </kt-silverpeak-general>\n                </ng-template>\n              </ngb-tab>\n            </ngb-tabset>\n          </div>\n        </div>\n\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.scss":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.scss ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1zZXJ2aWNlLWZvcm0vdGFjLXNlcnZpY2UtZm9ybS5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.ts":
/*!****************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.ts ***!
  \****************************************************************************************************/
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
var TacServiceFormComponent = /** @class */ (function () {
    function TacServiceFormComponent(toastr) {
        this.toastr = toastr;
    }
    TacServiceFormComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.validation.subscribe(function (data) {
            //console.log(data)
            for (var key in data) {
                if (key == 'ace') {
                    _this.toastr.error('ACE Error!');
                    continue;
                }
                if (data[key]) {
                    //console.log(data[key])
                    for (var i = 0; i < data[key].length; i++) {
                        _this.toastr.error(data[key][i]);
                    }
                }
            }
        });
    };
    TacServiceFormComponent.prototype.trigger = function (section) {
        // console.log(this.options.data[section])
        // console.log(section)
        this.options.data[section] = +!this.options.data[section];
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacServiceFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacServiceFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacServiceFormComponent.prototype, "loading", void 0);
    TacServiceFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-tac-service-form',
            template: __webpack_require__(/*! ./tac-service-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.html"),
            styles: [__webpack_require__(/*! ./tac-service-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService])
    ], TacServiceFormComponent);
    return TacServiceFormComponent;
}());
exports.TacServiceFormComponent = TacServiceFormComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.module.ts":
/*!*************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.module.ts ***!
  \*************************************************************************************************/
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
//Material
var menu_1 = __webpack_require__(/*! @angular/material/menu */ "./node_modules/@angular/material/esm5/menu.es5.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
//Form
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
//PortletModule
var portlet_module_1 = __webpack_require__(/*! ../../../../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
var pages_module_1 = __webpack_require__(/*! ../../../../../pages/pages.module */ "./src/app/views/pages/pages.module.ts");
var cisco_general_component_1 = __webpack_require__(/*! ./cisco-general/cisco-general.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-general/cisco-general.component.ts");
var tac_service_form_component_1 = __webpack_require__(/*! ./tac-service-form.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/tac-service-form.component.ts");
var cisco_wlc_component_1 = __webpack_require__(/*! ./cisco-wlc/cisco-wlc.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/cisco-wlc/cisco-wlc.component.ts");
var juniper_general_component_1 = __webpack_require__(/*! ./juniper-general/juniper-general.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/juniper-general/juniper-general.component.ts");
var h3c_general_component_1 = __webpack_require__(/*! ./h3c-general/h3c-general.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/h3c-general/h3c-general.component.ts");
var huawei_general_component_1 = __webpack_require__(/*! ./huawei-general/huawei-general.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/huawei-general/huawei-general.component.ts");
var paloalto_general_component_1 = __webpack_require__(/*! ./paloalto-general/paloalto-general.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/paloalto-general/paloalto-general.component.ts");
var silverpeak_general_component_1 = __webpack_require__(/*! ./silverpeak-general/silverpeak-general.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/silverpeak-general/silverpeak-general.component.ts");
var fortios_general_component_1 = __webpack_require__(/*! ./fortios-general/fortios-general.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-service-form/fortios-general/fortios-general.component.ts");
var TacServiceFormModule = /** @class */ (function () {
    function TacServiceFormModule() {
    }
    TacServiceFormModule = __decorate([
        core_1.NgModule({
            declarations: [
                tac_service_form_component_1.TacServiceFormComponent,
                cisco_general_component_1.CiscoGeneralComponent,
                cisco_wlc_component_1.CiscoWlcComponent,
                juniper_general_component_1.JuniperGeneralComponent,
                h3c_general_component_1.H3cGeneralComponent,
                huawei_general_component_1.HuaweiGeneralComponent,
                paloalto_general_component_1.PaloaltoGeneralComponent,
                silverpeak_general_component_1.SilverpeakGeneralComponent,
                fortios_general_component_1.FortiosGeneralComponent,
            ],
            exports: [
                common_1.CommonModule,
                tac_service_form_component_1.TacServiceFormComponent,
            ],
            imports: [
                common_1.CommonModule,
                menu_1.MatMenuModule,
                ng_bootstrap_1.NgbModule,
                forms_1.FormsModule,
                portlet_module_1.PortletModule,
                pages_module_1.PagesModule
            ]
        })
    ], TacServiceFormModule);
    return TacServiceFormModule;
}());
exports.TacServiceFormModule = TacServiceFormModule;


/***/ })

}]);
//# sourceMappingURL=services-services-module.js.map