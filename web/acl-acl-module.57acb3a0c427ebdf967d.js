(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["acl-acl-module"],{

/***/ "./src/app/views/pages/tacacs/access-control/acl/acl.component.html":
/*!**************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/acl.component.html ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/acl.component.scss":
/*!**************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/acl.component.scss ***!
  \**************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9hY2Nlc3MtY29udHJvbC9hY2wvYWNsLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/acl.component.ts":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/acl.component.ts ***!
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
var AclComponent = /** @class */ (function () {
    function AclComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/tacacs/acl/delete/',
                editBtn: true,
                selectable: true,
                preview: {
                    target: 'acl'
                },
                pagination: false,
                mainUrl: '/tacacs/acl/datatables/',
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
                    name: 'Add ACL',
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
    AclComponent.prototype.ngOnInit = function () {
    };
    AclComponent = __decorate([
        core_1.Component({
            selector: 'kt-acl',
            template: __webpack_require__(/*! ./acl.component.html */ "./src/app/views/pages/tacacs/access-control/acl/acl.component.html"),
            styles: [__webpack_require__(/*! ./acl.component.scss */ "./src/app/views/pages/tacacs/access-control/acl/acl.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], AclComponent);
    return AclComponent;
}());
exports.AclComponent = AclComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/acl.module.ts":
/*!*********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/acl.module.ts ***!
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
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/tacacs/access-control/acl/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.ts");
var acl_component_1 = __webpack_require__(/*! ./acl.component */ "./src/app/views/pages/tacacs/access-control/acl/acl.component.ts");
//Form
var tac_acl_form_component_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.ts");
var drag_drop_1 = __webpack_require__(/*! @angular/cdk/drag-drop */ "./node_modules/@angular/cdk/esm5/drag-drop.es5.js");
var AclModule = /** @class */ (function () {
    function AclModule() {
    }
    AclModule = __decorate([
        core_1.NgModule({
            declarations: [
                add_component_1.AddComponent,
                edit_component_1.EditComponent,
                acl_component_1.AclComponent,
                tac_acl_form_component_1.TacAclFormComponent
            ],
            imports: [
                common_1.CommonModule,
                ng_bootstrap_1.NgbModule,
                partials_module_1.PartialsModule,
                forms_1.FormsModule,
                portlet_module_1.PortletModule,
                core_module_1.CoreModule,
                pages_module_1.PagesModule,
                drag_drop_1.DragDropModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: acl_component_1.AclComponent
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
    ], AclModule);
    return AclModule;
}());
exports.AclModule = AclModule;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/acl.service.ts":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/acl.service.ts ***!
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
var API_URL = 'api/tacacs/acl';
var ACLService = /** @class */ (function () {
    function ACLService(http) {
        this.http = http;
    }
    ACLService.prototype.add = function (acl) {
        return this.http.post(API_URL + '/add/', acl)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ACLService.prototype.get = function (id) {
        var params = new http_1.HttpParams()
            .set('id', id.toString());
        return this.http.get(API_URL + '/edit/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.acl;
        }));
    };
    ACLService.prototype.save = function (acl) {
        return this.http.post(API_URL + '/edit/', acl)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ACLService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], ACLService);
    return ACLService;
}());
exports.ACLService = ACLService;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/add/add.component.html":
/*!******************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/add/add.component.html ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-acl-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-tac-acl-form> \n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add ACL</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/add/add.component.scss":
/*!******************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/add/add.component.scss ***!
  \******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9hY2Nlc3MtY29udHJvbC9hY2wvYWRkL2FkZC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/add/add.component.ts":
/*!****************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/add/add.component.ts ***!
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
var acl_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/tac-acl-form/acl.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/acl.model.ts");
//Service//
var acl_service_1 = __webpack_require__(/*! ../acl.service */ "./src/app/views/pages/tacacs/access-control/acl/acl.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, aclservice, router, route) {
        this.toastr = toastr;
        this.aclservice = aclservice;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({ custom: [] });
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new acl_model_1.ACL,
            old_data: new acl_model_1.ACL
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
        var v_custom = {};
        this.loadingForm.next(true);
        var data = this.makeClone(this.formParameters.data);
        data.ace = (data.ace[0]) ? data.ace.map(function (x, i) {
            v_custom[i] = {};
            x.nac = (x.nac[0]) ? x.nac[0].id : null;
            if (!x.nac)
                v_custom[i].nac = 'NAC empty!';
            x.nas = (x.nas[0]) ? x.nas[0].id : null;
            if (!x.nas)
                v_custom[i].nas = 'NAS empty!';
            x.order = i + 1;
            return x;
        }) : [];
        // console.log(data)
        this.aclservice.add(data).subscribe(function (data) {
            // console.log(data)
            if (data.error.validation)
                data.error.validation.custom = v_custom;
            _this.validation.next(data.error.validation);
            // console.log(this.validation.getValue())
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.acl) {
                _this.toastr.success('ACL Added!');
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/tacacs/access-control/acl/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/tacacs/access-control/acl/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            acl_service_1.ACLService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.html":
/*!********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.html ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-acl-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-tac-acl-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Save ACL</button>&nbsp;\n    <a routerLink=\"../..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.scss":
/*!********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.scss ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9hY2Nlc3MtY29udHJvbC9hY2wvZWRpdC9lZGl0LmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.ts":
/*!******************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.ts ***!
  \******************************************************************************/
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
var acl_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/tac-acl-form/acl.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/acl.model.ts");
//Service//
var acl_service_1 = __webpack_require__(/*! ../acl.service */ "./src/app/views/pages/tacacs/access-control/acl/acl.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, aclservice, router, route) {
        this.toastr = toastr;
        this.aclservice = aclservice;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({ custom: [] });
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.formParameters = {
            action: 'add',
            data: new acl_model_1.ACL,
            old_data: new acl_model_1.ACL
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
        this.aclservice.get(id).subscribe(function (data) {
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
        var v_custom = {};
        var data = this.makeClone(this.formParameters.data);
        var old_data = this.makeClone(this.formParameters.old_data);
        console.log(JSON.stringify(this.formParameters.data), JSON.stringify(this.formParameters.old_data));
        if (JSON.stringify(data) == JSON.stringify(old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        data.ace = (data.ace[0]) ? data.ace.map(function (x, i) {
            v_custom[i] = {};
            x.nac = (x.nac[0]) ? x.nac[0].id : null;
            if (!x.nac)
                v_custom[i].nac = 'NAC empty!';
            x.nas = (x.nas[0]) ? x.nas[0].id : null;
            if (!x.nas)
                v_custom[i].nas = 'NAS empty!';
            x.order = i + 1;
            return x;
        }) : [];
        // console.log(data)
        this.aclservice.save(data).subscribe(function (data) {
            console.log(data);
            if (data.error.validation)
                data.error.validation.custom = v_custom;
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('ACL Changed!');
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/tacacs/access-control/acl/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            acl_service_1.ACLService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/acl.model.ts":
/*!*******************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/acl.model.ts ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var ACL = /** @class */ (function () {
    function ACL() {
    }
    ACL.prototype.empty = function () {
        this.id = undefined;
        this.name = '';
        this.ace = [
            { order: 1, nas: [], nac: [], action: 1 }
        ];
    };
    return ACL;
}());
exports.ACL = ACL;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.html":
/*!**********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.html ***!
  \**********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Name</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.name }\"\n                  [(ngModel)]=\"options.data.name\" placeholder=\"ACL Name\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.name;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">it should be unique, but you can change it later</span>\n            </div>\n          </div>\n        </div>\n        <div class=\"table-responsive\">\n          <table class=\"table table-striped\">\n            <thead>\n              <tr>\n                <th></th>\n                <th>Num</th>\n                <th>Action</th>\n                <th>NAS</th>\n                <th>NAC</th>\n                <th></th>\n              </tr>\n            </thead>\n            <tbody cdkDropList class=\"ace-full-list\" (cdkDropListDropped)=\"drop($event)\">\n              <tr *ngFor=\"let ace of options.data.ace; let i = index\" class=\"ace-line\" cdkDrag>\n                <td width=\"30px\" cdkDragHandle><i class=\"fa fa-arrows-alt\"></i> </td>\n                <td width=\"30px\">{{i+1}} <input type=\"hidden\" [(ngModel)]=\"ace.order\"> </td>\n                <td width=\"120px\">\n                  <select class=\"form-control form-control-sm\" style=\"max-width: 100px;\" [(ngModel)]=\"ace.action\">\n      \t\t\t\t\t\t\t<option value=\"1\">permit</option>\n      \t\t\t\t\t\t\t<option value=\"0\">deny</option>\n      \t\t\t\t\t\t</select>\n                </td>\n                <td>\n                  <kt-field-general-list [data]=\"ace.nas\"\n                    [params]=\"list.nas\"\n                    (returnData)=\"setNas($event, i)\"\n                    [ngClass]=\"{ 'is-invalid' : (validation | async)?.custom[i]?.nas }\" >\n                  </kt-field-general-list>\n                </td>\n                <td>\n                  <kt-field-general-list [data]=\"ace.nac\"\n                    [params]=\"list.nac\"\n                    (returnData)=\"setNac($event, i)\"\n                    [ngClass]=\"{ 'is-invalid' : (validation | async)?.custom[i]?.nac }\" >\n                  </kt-field-general-list>\n                </td>\n                <td class=\"text-center acl-action-btn\">\n                  <button class=\"btn btn-outline-hover-warning btn-icon btn-sm\" ngbTooltip=\"Clone\" (click)=\"cloneAce(i)\">\n                    <i class=\"fa fa-copy\"></i>\n                  </button>\n                  <button class=\"btn btn-outline-hover-danger btn-icon btn-sm\" ngbTooltip=\"Delete\" (click)=\"delAce(i)\">\n                    <i class=\"fa fa-trash-alt\"></i>\n                  </button>\n                </td>\n              </tr>\n            </tbody>\n          </table>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <div class=\"btn-group btn-group-sm pull-right\" role=\"group\" aria-label=\"Small button group\">\n                <button type=\"button\" class=\"btn btn-outline-success\"\n                  ngbTooltip=\"Add to the end\"\n                  (click)=\"options.data.ace.push({nas:[], nac:[], action:1, order:1})\">\n                  Add ACE <i class=\"fa fa-level-up-alt\"></i>\n                </button>\n                <button type=\"button\" class=\"btn btn-outline-success\"\n                  ngbTooltip=\"Add to the start\"\n                  (click)=\"options.data.ace.unshift({nas:[], nac:[], action:1, order:1})\">\n                  Add ACE <i class=\"fa fa-level-down-alt\"></i>\n                </button>\n            </div>\n          </div>\n        </div>\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.scss":
/*!**********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.scss ***!
  \**********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".cdk-drag-preview {\n  border: 1px solid #ebedf2;\n  padding: 7px;\n  margin: 3px;\n  box-sizing: border-box;\n  background-color: #fff; }\n\n.cdk-drag-preview span.del_item,\n.cdk-drag-preview .acl-action-btn {\n  display: none; }\n\n.cdk-drag-placeholder {\n  opacity: 0; }\n\n.cdk-drag-animating {\n  transition: -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1), -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1); }\n\n.cdk-drop-list-dragging {\n  transition: -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1), -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1); }\n\n.ace-full-list.cdk-drop-list-dragging .ace-line:not(.cdk-drag-placeholder) {\n  transition: -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1), -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1); }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYXJ0aWFscy9sYXlvdXQvdGFjZ3VpL19mb3Jtcy90YWMtYWNsLWZvcm0vdGFjLWFjbC1mb3JtLmNvbXBvbmVudC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBQ0UseUJBQXlCO0VBQ3pCLFlBQVk7RUFDWixXQUFXO0VBQ1gsc0JBQXNCO0VBQ3RCLHNCQUFzQixFQUFBOztBQUV4Qjs7RUFFRSxhQUFhLEVBQUE7O0FBR2Y7RUFDRSxVQUFVLEVBQUE7O0FBR1o7RUFDRSw4REFBc0Q7RUFBdEQsc0RBQXNEO0VBQXRELDBHQUFzRCxFQUFBOztBQUd4RDtFQUNFLDhEQUFzRDtFQUF0RCxzREFBc0Q7RUFBdEQsMEdBQXNELEVBQUE7O0FBRXhEO0VBQ0UsOERBQXNEO0VBQXRELHNEQUFzRDtFQUF0RCwwR0FBc0QsRUFBQSIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL3RhYy1hY2wtZm9ybS90YWMtYWNsLWZvcm0uY29tcG9uZW50LnNjc3MiLCJzb3VyY2VzQ29udGVudCI6WyIuY2RrLWRyYWctcHJldmlldyB7XHJcbiAgYm9yZGVyOiAxcHggc29saWQgI2ViZWRmMjtcclxuICBwYWRkaW5nOiA3cHg7XHJcbiAgbWFyZ2luOiAzcHg7XHJcbiAgYm94LXNpemluZzogYm9yZGVyLWJveDtcclxuICBiYWNrZ3JvdW5kLWNvbG9yOiAjZmZmO1xyXG59XHJcbi5jZGstZHJhZy1wcmV2aWV3IHNwYW4uZGVsX2l0ZW0sXHJcbi5jZGstZHJhZy1wcmV2aWV3IC5hY2wtYWN0aW9uLWJ0biB7XHJcbiAgZGlzcGxheTogbm9uZTtcclxufVxyXG5cclxuLmNkay1kcmFnLXBsYWNlaG9sZGVyIHtcclxuICBvcGFjaXR5OiAwO1xyXG59XHJcblxyXG4uY2RrLWRyYWctYW5pbWF0aW5nIHtcclxuICB0cmFuc2l0aW9uOiB0cmFuc2Zvcm0gMjUwbXMgY3ViaWMtYmV6aWVyKDAsIDAsIDAuMiwgMSk7XHJcbn1cclxuXHJcbi5jZGstZHJvcC1saXN0LWRyYWdnaW5nIHtcclxuICB0cmFuc2l0aW9uOiB0cmFuc2Zvcm0gMjUwbXMgY3ViaWMtYmV6aWVyKDAsIDAsIDAuMiwgMSk7XHJcbn1cclxuLmFjZS1mdWxsLWxpc3QuY2RrLWRyb3AtbGlzdC1kcmFnZ2luZyAuYWNlLWxpbmU6bm90KC5jZGstZHJhZy1wbGFjZWhvbGRlcikge1xyXG4gIHRyYW5zaXRpb246IHRyYW5zZm9ybSAyNTBtcyBjdWJpYy1iZXppZXIoMCwgMCwgMC4yLCAxKTtcclxufVxyXG4iXX0= */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.ts":
/*!********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.ts ***!
  \********************************************************************************************/
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
//CDK
var drag_drop_1 = __webpack_require__(/*! @angular/cdk/drag-drop */ "./node_modules/@angular/cdk/esm5/drag-drop.es5.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var TacAclFormComponent = /** @class */ (function () {
    function TacAclFormComponent(toastr) {
        this.toastr = toastr;
        this.objectKeys = Object.keys;
        this.list = {
            nas: {
                multiple: false,
                title: '',
                title_sidebar: 'Address List',
                search: true,
                apiurl: 'api/obj/address/list/',
                addNew: 'address'
            },
            nac: {
                multiple: false,
                title: '',
                title_sidebar: 'Address List',
                search: true,
                apiurl: 'api/obj/address/list/',
                addNew: 'address'
            },
        };
    }
    TacAclFormComponent.prototype.ngOnInit = function () {
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
    TacAclFormComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    TacAclFormComponent.prototype.cloneAce = function (index) {
        this.options.data.ace.splice(index + 1, 0, this.makeClone(this.options.data.ace[index]));
    };
    TacAclFormComponent.prototype.delAce = function (index) {
        if (this.options.data.ace.length == 1)
            return;
        this.options.data.ace.splice(index, 1);
    };
    TacAclFormComponent.prototype.drop = function (event) {
        drag_drop_1.moveItemInArray(this.options.data.ace, event.previousIndex, event.currentIndex);
    };
    TacAclFormComponent.prototype.setNas = function (data, index) {
        // console.log(data, index)
        this.options.data.ace[index].nas = data;
    };
    TacAclFormComponent.prototype.setNac = function (data, index) {
        // console.log(data, index)
        this.options.data.ace[index].nac = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacAclFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacAclFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacAclFormComponent.prototype, "loading", void 0);
    TacAclFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-tac-acl-form',
            template: __webpack_require__(/*! ./tac-acl-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./tac-acl-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-acl-form/tac-acl-form.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService])
    ], TacAclFormComponent);
    return TacAclFormComponent;
}());
exports.TacAclFormComponent = TacAclFormComponent;


/***/ })

}]);
//# sourceMappingURL=acl-acl-module.57acb3a0c427ebdf967d.js.map