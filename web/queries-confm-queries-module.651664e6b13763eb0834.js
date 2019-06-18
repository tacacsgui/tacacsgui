(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["queries-confm-queries-module"],{

/***/ "./src/app/views/pages/confmanager/settings/queries/add/add.component.html":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/add/add.component.html ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-confm-query-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-confm-query-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add Query</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/add/add.component.scss":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/add/add.component.scss ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2NvbmZtYW5hZ2VyL3NldHRpbmdzL3F1ZXJpZXMvYWRkL2FkZC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/add/add.component.ts":
/*!*******************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/add/add.component.ts ***!
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
//Router
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model Query
var conf_query_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/confmanager/confm-query-form/conf-query.model */ "./src/app/views/partials/layout/tacgui/_forms/confmanager/confm-query-form/conf-query.model.ts");
//Service
var queries_service_1 = __webpack_require__(/*! ../queries.service */ "./src/app/views/pages/confmanager/settings/queries/queries.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, service, router, route) {
        this.toastr = toastr;
        this.service = service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.configPreview = new rxjs_1.BehaviorSubject('');
        this.formParameters = {
            action: 'add',
            data: new conf_query_model_1.ConfQuery,
            old_data: new conf_query_model_1.ConfQuery
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
        data.credential = (data.credential[0] && data.credential[0].id) ? data.credential[0].id : null;
        data.f_group = (data.f_group[0] && data.f_group[0].id) ? data.f_group[0].id : '';
        data.model = (data.model[0] && data.model[0].id) ? data.model[0].id : null;
        data.devices = (data.devices[0] && data.devices[0].id) ? data.devices.map(function (x) { return x.id; }) : null;
        console.log(data);
        this.service.add(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.query) {
                _this.toastr.success('Query Added!');
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/confmanager/settings/queries/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/confmanager/settings/queries/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            queries_service_1.QueriesService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/confm-queries.module.ts":
/*!**********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/confm-queries.module.ts ***!
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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
//Page Module
var pages_module_1 = __webpack_require__(/*! ../../../../pages/pages.module */ "./src/app/views/pages/pages.module.ts");
var confmanager_settings_module_1 = __webpack_require__(/*! ../confmanager-settings.module */ "./src/app/views/pages/confmanager/settings/confmanager-settings.module.ts");
var queries_component_1 = __webpack_require__(/*! ./queries.component */ "./src/app/views/pages/confmanager/settings/queries/queries.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/confmanager/settings/queries/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/confmanager/settings/queries/edit/edit.component.ts");
var ConfmQueriesModule = /** @class */ (function () {
    function ConfmQueriesModule() {
    }
    ConfmQueriesModule = __decorate([
        core_1.NgModule({
            declarations: [
                queries_component_1.QueriesComponent,
                add_component_1.AddComponent,
                edit_component_1.EditComponent
            ],
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                pages_module_1.PagesModule,
                ng_bootstrap_1.NgbModule,
                confmanager_settings_module_1.ConfmanagerSettingsModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: queries_component_1.QueriesComponent
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
    ], ConfmQueriesModule);
    return ConfmQueriesModule;
}());
exports.ConfmQueriesModule = ConfmQueriesModule;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/edit/edit.component.html":
/*!***********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/edit/edit.component.html ***!
  \***********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-confm-query-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-confm-query-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Edit Query</button>&nbsp;\n    <a routerLink=\"../../\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/edit/edit.component.scss":
/*!***********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/edit/edit.component.scss ***!
  \***********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2NvbmZtYW5hZ2VyL3NldHRpbmdzL3F1ZXJpZXMvZWRpdC9lZGl0LmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/edit/edit.component.ts":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/edit/edit.component.ts ***!
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
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model Query
var conf_query_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/confmanager/confm-query-form/conf-query.model */ "./src/app/views/partials/layout/tacgui/_forms/confmanager/confm-query-form/conf-query.model.ts");
//Service
var queries_service_1 = __webpack_require__(/*! ../queries.service */ "./src/app/views/pages/confmanager/settings/queries/queries.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, service, router, route) {
        this.toastr = toastr;
        this.service = service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.formParameters = {
            action: 'add',
            data: new conf_query_model_1.ConfQuery,
            old_data: new conf_query_model_1.ConfQuery
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
        console.log(this.formParameters.data);
        console.log(JSON.stringify(data), JSON.stringify(this.formParameters.old_data));
        if (JSON.stringify(data) == JSON.stringify(this.formParameters.old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        data.credential = (data.credential[0] && data.credential[0].id) ? data.credential[0].id : null;
        data.f_group = (data.f_group[0] && data.f_group[0].id) ? data.f_group[0].id : '';
        data.model = (data.model[0] && data.model[0].id) ? data.model[0].id : null;
        data.devices = (data.devices[0] && data.devices[0].id) ? data.devices.map(function (x) { return x.id; }) : null;
        console.log(data);
        this.service.save(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('Query Changed!');
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/confmanager/settings/queries/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/confmanager/settings/queries/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            queries_service_1.QueriesService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/queries.component.html":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/queries.component.html ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/queries.component.scss":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/queries.component.scss ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2NvbmZtYW5hZ2VyL3NldHRpbmdzL3F1ZXJpZXMvcXVlcmllcy5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/queries.component.ts":
/*!*******************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/queries.component.ts ***!
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
var QueriesComponent = /** @class */ (function () {
    function QueriesComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/confmanager/queries/delete/',
                editBtn: true,
                selectable: true,
                preview: false,
                pagination: false,
                mainUrl: '/confmanager/queries/datatables/',
                sort: {
                    column: 'name',
                    direction: 'asc'
                },
                editable: true,
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    name: { title: 'Name', show: true, sortable: true },
                    model: { title: 'Model', show: true, sortable: true },
                    creden_name: { title: 'Credential', show: true, sortable: true },
                    path: { title: 'Path', show: true, sortable: false },
                    devices: { title: 'Devices', show: true, sortable: false },
                    created_at: { title: 'Created', show: false, sortable: true },
                    updated_at: { title: 'Updated', show: false, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: true,
                    name: 'Add Query',
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
    QueriesComponent.prototype.ngOnInit = function () {
    };
    QueriesComponent = __decorate([
        core_1.Component({
            selector: 'kt-queries',
            template: __webpack_require__(/*! ./queries.component.html */ "./src/app/views/pages/confmanager/settings/queries/queries.component.html"),
            styles: [__webpack_require__(/*! ./queries.component.scss */ "./src/app/views/pages/confmanager/settings/queries/queries.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], QueriesComponent);
    return QueriesComponent;
}());
exports.QueriesComponent = QueriesComponent;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/queries/queries.service.ts":
/*!*****************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/queries/queries.service.ts ***!
  \*****************************************************************************/
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
var API_URL = 'api/confmanager/queries/';
var QueriesService = /** @class */ (function () {
    function QueriesService(http) {
        this.http = http;
    }
    QueriesService.prototype.add = function (query) {
        return this.http.post(API_URL + 'add/', query)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    QueriesService.prototype.get = function (id) {
        var params = new http_1.HttpParams()
            .set('id', id.toString());
        return this.http.get(API_URL + 'edit/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.query;
        }));
    };
    QueriesService.prototype.save = function (query) {
        return this.http.post(API_URL + 'edit/', query)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    QueriesService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], QueriesService);
    return QueriesService;
}());
exports.QueriesService = QueriesService;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/confmanager/confm-query-form/conf-query.model.ts":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/confmanager/confm-query-form/conf-query.model.ts ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var ConfQuery = /** @class */ (function () {
    function ConfQuery() {
    }
    ConfQuery.prototype.empty = function () {
        this.id = undefined;
        this.name = '';
        this.disabled = 0;
        this.devices = [];
        this.credential = [];
        this.f_group = [];
        this.model = [];
        this.path = '/';
        this.omit_lines = '';
    };
    return ConfQuery;
}());
exports.ConfQuery = ConfQuery;


/***/ })

}]);
//# sourceMappingURL=queries-confm-queries-module.651664e6b13763eb0834.js.map