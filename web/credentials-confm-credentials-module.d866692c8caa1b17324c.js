(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["credentials-confm-credentials-module"],{

/***/ "./src/app/views/pages/confmanager/settings/credentials/add/add.component.html":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/add/add.component.html ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-confm-credential-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-confm-credential-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add Credential</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/add/add.component.scss":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/add/add.component.scss ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2NvbmZtYW5hZ2VyL3NldHRpbmdzL2NyZWRlbnRpYWxzL2FkZC9hZGQuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/add/add.component.ts":
/*!***********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/add/add.component.ts ***!
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
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model Query
var confm_credential_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/confmanager/confm-credential-form/confm-credential.model */ "./src/app/views/partials/layout/tacgui/_forms/confmanager/confm-credential-form/confm-credential.model.ts");
//Service
var credential_service_1 = __webpack_require__(/*! ../credential.service */ "./src/app/views/pages/confmanager/settings/credentials/credential.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, service, router, route) {
        this.toastr = toastr;
        this.service = service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new confm_credential_model_1.ConfmCredential,
            old_data: new confm_credential_model_1.ConfmCredential
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
        // console.log(this.formParameters.data)
        var data = this.makeClone(this.formParameters.data);
        console.log(data);
        this.service.add(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.credential) {
                _this.toastr.success('Credential Added!');
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/confmanager/settings/credentials/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/confmanager/settings/credentials/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            credential_service_1.CredentialService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/confm-credentials.module.ts":
/*!******************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/confm-credentials.module.ts ***!
  \******************************************************************************************/
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
//Page Module
var pages_module_1 = __webpack_require__(/*! ../../../../pages/pages.module */ "./src/app/views/pages/pages.module.ts");
var confmanager_settings_module_1 = __webpack_require__(/*! ../confmanager-settings.module */ "./src/app/views/pages/confmanager/settings/confmanager-settings.module.ts");
var credentials_component_1 = __webpack_require__(/*! ./credentials.component */ "./src/app/views/pages/confmanager/settings/credentials/credentials.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/confmanager/settings/credentials/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.ts");
var ConfmCredentialsModule = /** @class */ (function () {
    function ConfmCredentialsModule() {
    }
    ConfmCredentialsModule = __decorate([
        core_1.NgModule({
            declarations: [
                credentials_component_1.CredentialsComponent,
                add_component_1.AddComponent,
                edit_component_1.EditComponent
            ],
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                pages_module_1.PagesModule,
                confmanager_settings_module_1.ConfmanagerSettingsModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: credentials_component_1.CredentialsComponent
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
    ], ConfmCredentialsModule);
    return ConfmCredentialsModule;
}());
exports.ConfmCredentialsModule = ConfmCredentialsModule;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/credential.service.ts":
/*!************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/credential.service.ts ***!
  \************************************************************************************/
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
var API_URL = 'api/confmanager/credentials/';
var CredentialService = /** @class */ (function () {
    function CredentialService(http) {
        this.http = http;
    }
    CredentialService.prototype.add = function (credential) {
        return this.http.post(API_URL + 'add/', credential)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    CredentialService.prototype.get = function (id) {
        var params = new http_1.HttpParams()
            .set('id', id.toString());
        return this.http.get(API_URL + 'edit/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.credential;
        }));
    };
    CredentialService.prototype.save = function (credential) {
        return this.http.post(API_URL + 'edit/', credential)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    CredentialService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], CredentialService);
    return CredentialService;
}());
exports.CredentialService = CredentialService;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/credentials.component.html":
/*!*****************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/credentials.component.html ***!
  \*****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/credentials.component.scss":
/*!*****************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/credentials.component.scss ***!
  \*****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2NvbmZtYW5hZ2VyL3NldHRpbmdzL2NyZWRlbnRpYWxzL2NyZWRlbnRpYWxzLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/credentials.component.ts":
/*!***************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/credentials.component.ts ***!
  \***************************************************************************************/
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
var CredentialsComponent = /** @class */ (function () {
    function CredentialsComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/confmanager/credentials/delete/',
                editBtn: true,
                selectable: true,
                preview: false,
                pagination: false,
                mainUrl: '/confmanager/credentials/datatables/',
                sort: {
                    column: 'name',
                    direction: 'asc'
                },
                editable: true,
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    name: { title: 'Name', show: true, sortable: true },
                    username: { title: 'Username', show: true, sortable: true },
                    ref_d: { title: 'Ref Devices', show: false, sortable: false },
                    ref_q: { title: 'Ref Queries', show: false, sortable: false },
                    created_at: { title: 'Created', show: false, sortable: true },
                    updated_at: { title: 'Updated', show: false, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: true,
                    name: 'Add Credential',
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
    CredentialsComponent.prototype.ngOnInit = function () {
    };
    CredentialsComponent = __decorate([
        core_1.Component({
            selector: 'kt-credentials',
            template: __webpack_require__(/*! ./credentials.component.html */ "./src/app/views/pages/confmanager/settings/credentials/credentials.component.html"),
            styles: [__webpack_require__(/*! ./credentials.component.scss */ "./src/app/views/pages/confmanager/settings/credentials/credentials.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], CredentialsComponent);
    return CredentialsComponent;
}());
exports.CredentialsComponent = CredentialsComponent;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.html":
/*!***************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.html ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-confm-credential-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-confm-credential-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Edit Credential</button>&nbsp;\n    <a routerLink=\"../..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.scss":
/*!***************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.scss ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2NvbmZtYW5hZ2VyL3NldHRpbmdzL2NyZWRlbnRpYWxzL2VkaXQvZWRpdC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.ts":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.ts ***!
  \*************************************************************************************/
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
//Model Query
var confm_credential_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/confmanager/confm-credential-form/confm-credential.model */ "./src/app/views/partials/layout/tacgui/_forms/confmanager/confm-credential-form/confm-credential.model.ts");
//Service
var credential_service_1 = __webpack_require__(/*! ../credential.service */ "./src/app/views/pages/confmanager/settings/credentials/credential.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, service, router, route) {
        this.toastr = toastr;
        this.service = service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new confm_credential_model_1.ConfmCredential,
            old_data: new confm_credential_model_1.ConfmCredential
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
        this.service.get(id).subscribe(function (data) {
            console.log(data);
            if (!data) {
                _this.toastr.error('Server Error!');
                _this.router.navigate(['../../'], { relativeTo: _this.route });
                return;
            }
            _this.formParameters.data = _this.makeClone(data);
            _this.formParameters.old_data = _this.makeClone(data);
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
        // let old_data = this.makeClone(this.formParameters.old_data)
        if (JSON.stringify(data) == JSON.stringify(this.formParameters.old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        if (data.password == this.formParameters.old_data.password)
            delete data.password;
        console.log(data);
        this.service.save(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('Credential Changed!');
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/confmanager/settings/credentials/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            credential_service_1.CredentialService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/confmanager/confm-credential-form/confm-credential.model.ts":
/*!*****************************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/confmanager/confm-credential-form/confm-credential.model.ts ***!
  \*****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var ConfmCredential = /** @class */ (function () {
    function ConfmCredential() {
    }
    ConfmCredential.prototype.empty = function () {
        this.id = undefined;
        this.name = '';
        this.username = '';
        this.password = '';
    };
    return ConfmCredential;
}());
exports.ConfmCredential = ConfmCredential;


/***/ })

}]);
//# sourceMappingURL=credentials-confm-credentials-module.d866692c8caa1b17324c.js.map