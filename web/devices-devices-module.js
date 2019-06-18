(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["devices-devices-module"],{

/***/ "./src/app/views/pages/tacacs/devices/add/add.component.html":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/add/add.component.html ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-device-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\r\n</kt-tac-device-form>\r\n\r\n<div class=\"row\">\r\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\r\n    <button class=\"btn btn-success btn-elevate btn-sm\"\r\n      (click)=\"add()\"\r\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\" \r\n      [disabled]=\"(loadingForm | async)\">Add Device</button>&nbsp;\r\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\r\n  </div>\r\n</div>\r\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/add/add.component.scss":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/add/add.component.scss ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "mat-form-field {\n  width: 100%; }\n\nmat-form-field > * {\n  width: 100%; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYWdlcy90YWNhY3MvZGV2aWNlcy9hZGQvYWRkLmNvbXBvbmVudC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBQ0UsV0FDRixFQUFBOztBQUNBO0VBQ0UsV0FDRixFQUFBIiwiZmlsZSI6InNyYy9hcHAvdmlld3MvcGFnZXMvdGFjYWNzL2RldmljZXMvYWRkL2FkZC5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIm1hdC1mb3JtLWZpZWxkIHtcclxuICB3aWR0aDogMTAwJVxyXG59XHJcbm1hdC1mb3JtLWZpZWxkID4gKiB7XHJcbiAgd2lkdGg6IDEwMCVcclxufVxyXG4iXX0= */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/add/add.component.ts":
/*!*****************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/add/add.component.ts ***!
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
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model Device
var device_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-device-form/device.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/device.model.ts");
//Service//
var device_service_1 = __webpack_require__(/*! ../device.service */ "./src/app/views/pages/tacacs/devices/device.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, dev_service, router, route) {
        this.toastr = toastr;
        this.dev_service = dev_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new device_model_1.Device,
            old_data: new device_model_1.Device
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
        console.log(data);
        data.address = (data.address[0] && data.address[0].id) ? data.address[0].id : null;
        data.group = (data.group[0] && data.group[0].id) ? data.group[0].id : null;
        data.acl = (data.acl[0] && data.acl[0].id) ? data.acl[0].id : null;
        data.user_group = (data.user_group[0] && data.user_group[0].id) ? data.user_group[0].id : null;
        this.dev_service.add(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.device) {
                _this.toastr.success('Device Added!');
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/tacacs/devices/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/tacacs/devices/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            device_service_1.DeviceService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/device.service.ts":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/device.service.ts ***!
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
var http_1 = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var API_URL = 'api/tacacs/device';
var DeviceService = /** @class */ (function () {
    function DeviceService(http) {
        this.http = http;
        this.objectKeys = Object.keys;
    }
    DeviceService.prototype.add = function (device) {
        //let message = ''
        return this.http.post(API_URL + '/add/', device)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    DeviceService.prototype.get = function (id) {
        var params = new http_1.HttpParams()
            .set('id', id.toString());
        //let message = ''
        return this.http.get(API_URL + '/edit/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.device;
        }));
    };
    DeviceService.prototype.save = function (device) {
        //let message = ''
        return this.http.post(API_URL + '/edit/', device)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    DeviceService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], DeviceService);
    return DeviceService;
}());
exports.DeviceService = DeviceService;


/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/devices.component.html":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/devices.component.html ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/devices.component.scss":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/devices.component.scss ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".filter-container {\n  display: flex;\n  flex-direction: column; }\n\n.filter-container > * {\n  width: 100%; }\n\n.main-table-database {\n  width: 100%; }\n\n.main-table-database > tbody > tr:hover {\n  background-color: #ffb82257;\n  cursor: pointer; }\n\n.main-table-database > thead > tr i.fa {\n  cursor: pointer; }\n\n.icon::before {\n  display: inline-block;\n  font-style: normal;\n  font-variant: normal;\n  text-rendering: auto;\n  -webkit-font-smoothing: antialiased;\n  cursor: pointer; }\n\n.icon-sort::before {\n  font-family: \"Font Awesome 5 Free\";\n  font-weight: 900;\n  content: \"\\f0dc\"; }\n\n.icon-desc::before {\n  font-family: \"Font Awesome 5 Free\";\n  font-weight: 900;\n  content: \"\\f160\"; }\n\n.icon-asc::before {\n  font-family: \"Font Awesome 5 Free\";\n  font-weight: 900;\n  content: \"\\f161\"; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYWdlcy90YWNhY3MvZGV2aWNlcy9kZXZpY2VzLmNvbXBvbmVudC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBQ0UsYUFBYTtFQUNiLHNCQUFzQixFQUFBOztBQUd4QjtFQUNFLFdBQVcsRUFBQTs7QUFHYjtFQUNFLFdBQVcsRUFBQTs7QUFFYjtFQUNFLDJCQUEyQjtFQUMzQixlQUFlLEVBQUE7O0FBRWpCO0VBQ0UsZUFBZSxFQUFBOztBQUdqQjtFQUNFLHFCQUFxQjtFQUNyQixrQkFBa0I7RUFDbEIsb0JBQW9CO0VBQ3BCLG9CQUFvQjtFQUNwQixtQ0FBbUM7RUFDbkMsZUFBZSxFQUFBOztBQUdqQjtFQUNHLGtDQUFrQztFQUFFLGdCQUFnQjtFQUFFLGdCQUFnQixFQUFBOztBQUV6RTtFQUNHLGtDQUFrQztFQUFFLGdCQUFnQjtFQUFFLGdCQUFnQixFQUFBOztBQUV6RTtFQUNHLGtDQUFrQztFQUFFLGdCQUFnQjtFQUFFLGdCQUFnQixFQUFBIiwiZmlsZSI6InNyYy9hcHAvdmlld3MvcGFnZXMvdGFjYWNzL2RldmljZXMvZGV2aWNlcy5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIi5maWx0ZXItY29udGFpbmVyIHtcclxuICBkaXNwbGF5OiBmbGV4O1xyXG4gIGZsZXgtZGlyZWN0aW9uOiBjb2x1bW47XHJcbn1cclxuXHJcbi5maWx0ZXItY29udGFpbmVyID4gKiB7XHJcbiAgd2lkdGg6IDEwMCU7XHJcbn1cclxuXHJcbi5tYWluLXRhYmxlLWRhdGFiYXNlIHtcclxuICB3aWR0aDogMTAwJTtcclxufVxyXG4ubWFpbi10YWJsZS1kYXRhYmFzZSA+IHRib2R5ID4gdHI6aG92ZXIge1xyXG4gIGJhY2tncm91bmQtY29sb3I6ICNmZmI4MjI1NztcclxuICBjdXJzb3I6IHBvaW50ZXI7XHJcbn1cclxuLm1haW4tdGFibGUtZGF0YWJhc2UgPiB0aGVhZCA+IHRyIGkuZmEge1xyXG4gIGN1cnNvcjogcG9pbnRlcjtcclxufVxyXG5cclxuLmljb246OmJlZm9yZSB7XHJcbiAgZGlzcGxheTogaW5saW5lLWJsb2NrO1xyXG4gIGZvbnQtc3R5bGU6IG5vcm1hbDtcclxuICBmb250LXZhcmlhbnQ6IG5vcm1hbDtcclxuICB0ZXh0LXJlbmRlcmluZzogYXV0bztcclxuICAtd2Via2l0LWZvbnQtc21vb3RoaW5nOiBhbnRpYWxpYXNlZDtcclxuICBjdXJzb3I6IHBvaW50ZXI7XHJcbn1cclxuXHJcbi5pY29uLXNvcnQ6OmJlZm9yZSB7XHJcbiAgIGZvbnQtZmFtaWx5OiBcIkZvbnQgQXdlc29tZSA1IEZyZWVcIjsgZm9udC13ZWlnaHQ6IDkwMDsgY29udGVudDogXCJcXGYwZGNcIjtcclxuIH1cclxuLmljb24tZGVzYzo6YmVmb3JlIHtcclxuICAgZm9udC1mYW1pbHk6IFwiRm9udCBBd2Vzb21lIDUgRnJlZVwiOyBmb250LXdlaWdodDogOTAwOyBjb250ZW50OiBcIlxcZjE2MFwiO1xyXG4gfVxyXG4uaWNvbi1hc2M6OmJlZm9yZSB7XHJcbiAgIGZvbnQtZmFtaWx5OiBcIkZvbnQgQXdlc29tZSA1IEZyZWVcIjsgZm9udC13ZWlnaHQ6IDkwMDsgY29udGVudDogXCJcXGYxNjFcIjtcclxuIH1cclxuIl19 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/devices.component.ts":
/*!*****************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/devices.component.ts ***!
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
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var DevicesComponent = /** @class */ (function () {
    function DevicesComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/tacacs/device/delete/',
                editBtn: true,
                selectable: true,
                preview: {
                    target: 'device'
                },
                sort: {
                    column: 'name',
                    direction: 'asc'
                },
                editable: true,
                pagination: false,
                mainUrl: '/tacacs/device/datatables/',
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    name: { title: 'Name', show: true, sortable: true },
                    address: { title: 'Address', show: true, sortable: true },
                    address_name: { title: 'Address Name', show: false, sortable: true,
                        htmlPattern: function (data, column_name, index, all_data) {
                            //console.log(data, column_name, index);
                            var address = '';
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data) {
                                //console.log(data[index])
                                if (data[index].address)
                                    address = data[index].address;
                            });
                            return '<span title="' + address + '">' + data + '</span>';
                        }
                    },
                    group_name: { title: 'Group', show: true, sortable: true },
                    created_at: { title: 'Created', show: false, sortable: true },
                    updated_at: { title: 'Updated', show: false, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: true,
                    name: 'Add Device',
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
    DevicesComponent.prototype.ngOnInit = function () {
    };
    DevicesComponent = __decorate([
        core_1.Component({
            selector: 'kt-devices',
            template: __webpack_require__(/*! ./devices.component.html */ "./src/app/views/pages/tacacs/devices/devices.component.html"),
            styles: [__webpack_require__(/*! ./devices.component.scss */ "./src/app/views/pages/tacacs/devices/devices.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], DevicesComponent);
    return DevicesComponent;
}());
exports.DevicesComponent = DevicesComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/devices.module.ts":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/devices.module.ts ***!
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
//Components
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/tacacs/devices/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/tacacs/devices/edit/edit.component.ts");
var devices_component_1 = __webpack_require__(/*! ./devices.component */ "./src/app/views/pages/tacacs/devices/devices.component.ts");
//Form
var tac_device_form_component_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.ts");
// import { FieldGeneralListComponent } from '../../../partials/layout/tacgui/_fields/field-general-list/field-general-list.component';
//import { DevGroupsListComponent } from '../../../partials/layout/dev-groups-list'
var DevicesModule = /** @class */ (function () {
    function DevicesModule() {
    }
    DevicesModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                // ReactiveFormsModule,
                portlet_module_1.PortletModule,
                partials_module_1.PartialsModule,
                pages_module_1.PagesModule,
                core_module_1.CoreModule,
                ng_bootstrap_1.NgbModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: devices_component_1.DevicesComponent
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
            ],
            providers: [],
            declarations: [
                devices_component_1.DevicesComponent,
                tac_device_form_component_1.TacDeviceFormComponent,
                // FieldGeneralListComponent,
                // MainTableComponent,
                // NgbdSortableHeader,
                add_component_1.AddComponent,
                edit_component_1.EditComponent
            ]
        })
    ], DevicesModule);
    return DevicesModule;
}());
exports.DevicesModule = DevicesModule;


/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/edit/edit.component.html":
/*!*********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/edit/edit.component.html ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-tac-device-form [options]=\"formParameters\" [validation]=\"validation\"  [loading]=\"loadingForm\">\n</kt-tac-device-form>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n    [disabled]=\"(loadingForm | async)\">Edit Device</button>&nbsp;\n    <a routerLink=\"../../\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/edit/edit.component.scss":
/*!*********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/edit/edit.component.scss ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9kZXZpY2VzL2VkaXQvZWRpdC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/devices/edit/edit.component.ts":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/tacacs/devices/edit/edit.component.ts ***!
  \*******************************************************************/
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
var device_model_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/tac-device-form/device.model */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/device.model.ts");
//Service//
var device_service_1 = __webpack_require__(/*! ../device.service */ "./src/app/views/pages/tacacs/devices/device.service.ts");
var preload_service_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_fields/field-general-list/preload.service */ "./src/app/views/partials/layout/tacgui/_fields/field-general-list/preload.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, dev_service, router, route, pre) {
        this.toastr = toastr;
        this.dev_service = dev_service;
        this.router = router;
        this.route = route;
        this.pre = pre;
        this.formParameters = {
            action: 'add',
            data: new device_model_1.Device,
            old_data: new device_model_1.Device
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
        this.dev_service.get(id).subscribe(function (data) {
            console.log(data);
            if (!data) {
                _this.toastr.error('Server Error!');
                _this.router.navigate(['../../'], { relativeTo: _this.route });
                return;
            }
            if (!Array.isArray(data.group))
                data.group = [(data.group) ? data.group : 0];
            if (!Array.isArray(data.address))
                data.address = [(data.address) ? data.address : 0];
            if (!Array.isArray(data.acl))
                data.acl = [(data.acl) ? data.acl : 0];
            if (!Array.isArray(data.user_group))
                data.user_group = [(data.user_group) ? data.user_group : 0];
            Object.assign(_this.formParameters.data, data);
            Object.assign(_this.formParameters.old_data, data);
            rxjs_1.forkJoin(_this.pre.get('/tacacs/device/group/list/', data.group.join(',')), _this.pre.get('/obj/address/list/', data.address.join(',')), _this.pre.get('/tacacs/acl/list/', data.acl.join(',')), _this.pre.get('/tacacs/user/group/list/', data.user_group.join(','))).pipe(operators_1.map(function (_a) {
                var group = _a[0], address = _a[1], acl = _a[2], user_group = _a[3];
                console.log(group, address, acl, user_group);
                var returnData = {};
                if (group)
                    returnData['group'] = group;
                if (address)
                    returnData['address'] = address;
                if (acl)
                    returnData['acl'] = acl;
                if (user_group)
                    returnData['user_group'] = user_group;
                return returnData;
            })).subscribe(function (data) {
                // console.log(data)
                console.log(_this.formParameters.data);
                if (data['group']) {
                    _this.formParameters.data.group = JSON.parse(JSON.stringify(data['group']));
                    _this.formParameters.old_data.group = JSON.parse(JSON.stringify(data['group']));
                }
                if (data['address']) {
                    _this.formParameters.data.address = JSON.parse(JSON.stringify(data['address']));
                    _this.formParameters.old_data.address = JSON.parse(JSON.stringify(data['address']));
                }
                if (data['acl']) {
                    _this.formParameters.data.acl = JSON.parse(JSON.stringify(data['acl']));
                    _this.formParameters.old_data.acl = JSON.parse(JSON.stringify(data['acl']));
                }
                if (data['user_group']) {
                    _this.formParameters.data.user_group = JSON.parse(JSON.stringify(data['user_group']));
                    _this.formParameters.old_data.user_group = JSON.parse(JSON.stringify(data['user_group']));
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
        // console.log(JSON.stringify(this.formParameters.data), JSON.stringify(this.formParameters.old_data))
        if (JSON.stringify(data) == JSON.stringify(old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        console.log(data);
        data.group = (data.group[0] && data.group[0].id) ? data.group[0].id : null;
        data.address = (data.address[0] && data.address[0].id) ? data.address[0].id : null;
        data.acl = (data.acl[0] && data.acl[0].id) ? data.acl[0].id : null;
        data.user_group = (data.user_group[0] && data.user_group[0].id) ? data.user_group[0].id : null;
        this.dev_service.save(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('Device Changed!');
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/tacacs/devices/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/tacacs/devices/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            device_service_1.DeviceService,
            router_1.Router,
            router_1.ActivatedRoute,
            preload_service_1.PreloadService])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/device.model.ts":
/*!*************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-device-form/device.model.ts ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

Object.defineProperty(exports, "__esModule", { value: true });
var Device = /** @class */ (function () {
    function Device() {
    }
    Device.prototype.empty = function () {
        this.acl = [];
        this.banner_failed = '';
        this.banner_motd = '';
        this.banner_welcome = '';
        this.comment = '';
        this.connection_timeout = undefined;
        this.created_at = '';
        this.disabled = 0;
        this.enable = '';
        this.enable_flag = 1;
        this.group = [];
        this.id = undefined;
        this.address = [];
        this.key = '';
        this.manual = '';
        this.model = '';
        this.name = '';
        this.sn = '';
        this.type = '';
        this.updated_at = '';
        this.user_group = [];
        this.vendor = '';
    };
    return Device;
}());
exports.Device = Device;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.html":
/*!****************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.html ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Name</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.name }\"\n                  [(ngModel)]=\"options.data.name\" placeholder=\"Device Name\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.name;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">it should be unique, but you can change it later</span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <kt-field-general-list [data]=\"options.data.group\"\n              [params]=\"list.group\"\n              [errors]=\"(validation | async)?.group\"\n              (returnData)=\"setGroup($event)\"\n              [ngClass]=\"{ 'is-invalid' : (validation | async)?.group }\" >\n            </kt-field-general-list>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <kt-field-general-list [data]=\"options.data.address\"\n              [params]=\"list.address\"\n              [errors]=\"(validation | async)?.address\"\n              (returnData)=\"setAddr($event)\"\n              [ngClass]=\"{ 'is-invalid' : (validation | async)?.address }\" >\n            </kt-field-general-list>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Tacacs Key</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                [(ngModel)]=\"options.data.key\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.key }\"\n                placeholder=\"Tacacs Key\">\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.key;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Enable Password</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.enable\" placeholder=\"Enable Password\">\n              <div class=\"invalid-feedback\">\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n           </div>\n          <div class=\"col-6\">\n            <label>Type of storing</label>\n            <select [(ngModel)]=\"options.data.enable_flag\" class=\"form-control form-control-sm\">\n              <option value=\"0\">Clear Text</option>\n              <option value=\"1\">MD5</option>\n            </select>\n          </div>\n        </div>\n        <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedB }\" data-toggle=\"collapse\"(click)=\"notCollapsedB = !notCollapsedB\"\n                            [attr.aria-expanded]=\"!notCollapsedB\">Banners</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedB\">\n                  <ngb-tabset>\n                  <ngb-tab title=\"Welcome\">\n                    <ng-template ngbTabContent>\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Welcome Banner</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.banner_welcome\" rows=\"5\"></textarea>\n                      </div>\n                    </ng-template>\n                  </ngb-tab>\n                  <ngb-tab title=\"MOTD\">\n                    <ng-template ngbTabContent>\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Message Of The Day Banner</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.banner_motd\" rows=\"5\"></textarea>\n                      </div>\n                    </ng-template>\n                  </ngb-tab>\n                  <ngb-tab title=\"Failed Auth\">\n                    <ng-template ngbTabContent>\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Authentication Failed Banner</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.banner_failed\" rows=\"5\"></textarea>\n                      </div>\n                    </ng-template>\n                  </ngb-tab>\n                  </ngb-tabset>\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedACC }\" data-toggle=\"collapse\"(click)=\"notCollapsedACC = !notCollapsedACC\"\n                            [attr.aria-expanded]=\"!notCollapsedACC\">Access</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedACC\">\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <kt-field-general-list\n                          [data]=\"options.data.acl\"\n                          [params]=\"list.acl\"\n                          (returnData)=\"setAcl($event)\">\n                        </kt-field-general-list>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <kt-field-general-list\n                          [data]=\"options.data.user_group\"\n                          [params]=\"list.user_group\"\n                          (returnData)=\"setUserGroup($event)\">\n                        </kt-field-general-list>\n                      </div>\n                    </div>\n                  </div><!-- .row -->\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <label>Connection Timeout</label>\n                        <input type=\"number\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.connection_timeout\" placeholder=\"Connection Timeout\">\n                        <div class=\"invalid-feedback\">\n                        </div>\n                        <span class=\"form-text text-muted\"></span>\n                      </div>\n                    </div>\n                  </div><!-- .row -->\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedIn }\" data-toggle=\"collapse\"(click)=\"notCollapsedIn = !notCollapsedIn\"\n                            [attr.aria-expanded]=\"!notCollapsedIn\">Info</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedIn\">\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n            \t\t\t\t\t\t<label>Vendor</label>\n            \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.vendor\" placeholder=\"Vendor\">\n                        <div class=\"invalid-feedback\">\n                        </div>\n            \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n            \t\t\t\t\t\t<label>Model</label>\n            \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.model\" placeholder=\"Model\">\n                        <div class=\"invalid-feedback\">\n                        </div>\n            \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                      </div>\n                    </div>\n                  </div>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n            \t\t\t\t\t\t<label>Type</label>\n            \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.type\" placeholder=\"Type\">\n                        <div class=\"invalid-feedback\">\n                        </div>\n            \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n            \t\t\t\t\t\t<label>Serial Number</label>\n            \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.sn\" placeholder=\"Serial Number\">\n                        <div class=\"invalid-feedback\">\n                        </div>\n            \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n            </div>\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMS }\" data-toggle=\"collapse\"(click)=\"notCollapsedMS = !notCollapsedMS\"\n                            [attr.aria-expanded]=\"!notCollapsedMS\">Manual Configuration</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedMS\">\n                    <div class=\"card-body\">\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Manual Configuration</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.manual\" rows=\"5\"></textarea>\n                      </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n    \t\t\t\t\t<label style=\"width: 100%;\">Disabled</label>\n    \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--danger\">\n    \t\t\t\t\t\t\t<label>\n    \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"options.data.disabled\">\n    \t\t\t\t\t\t\t\t<span></span>\n    \t\t\t\t\t\t\t</label>\n    \t\t\t\t\t\t</span>\n    \t\t\t\t</div>\n          </div>\n        </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.scss":
/*!****************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.scss ***!
  \****************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".tacgui-blockui-main-message::before {\n  margin-left: 10px; }\n\n.tacgui-blockui-main-message > span {\n  padding-left: 15px; }\n\n.tacgui-blockui-main-message {\n  background-color: #fff;\n  position: absolute;\n  top: 50%;\n  left: 40%;\n  padding: 15px; }\n\n.tacgui-blockui-main {\n  background-color: #44444429;\n  position: absolute;\n  width: 100%;\n  height: 100%; }\n\n.tacgui-blockui-portlet {\n  position: relative; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYXJ0aWFscy9sYXlvdXQvdGFjZ3VpL19mb3Jtcy90YWMtZGV2aWNlLWZvcm0vdGFjLWRldmljZS1mb3JtLmNvbXBvbmVudC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBQ0UsaUJBQWlCLEVBQUE7O0FBRW5CO0VBQ0Usa0JBQWtCLEVBQUE7O0FBRXBCO0VBQ0Usc0JBQXNCO0VBQ3RCLGtCQUFrQjtFQUNsQixRQUFRO0VBQ1IsU0FBUztFQUNULGFBQWEsRUFBQTs7QUFFZjtFQUNFLDJCQUEyQjtFQUMzQixrQkFBa0I7RUFDbEIsV0FBVztFQUNYLFlBQVksRUFBQTs7QUFHZDtFQUNFLGtCQUFrQixFQUFBIiwiZmlsZSI6InNyYy9hcHAvdmlld3MvcGFydGlhbHMvbGF5b3V0L3RhY2d1aS9fZm9ybXMvdGFjLWRldmljZS1mb3JtL3RhYy1kZXZpY2UtZm9ybS5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIi50YWNndWktYmxvY2t1aS1tYWluLW1lc3NhZ2U6OmJlZm9yZSB7XHJcbiAgbWFyZ2luLWxlZnQ6IDEwcHg7XHJcbn1cclxuLnRhY2d1aS1ibG9ja3VpLW1haW4tbWVzc2FnZSA+IHNwYW4ge1xyXG4gIHBhZGRpbmctbGVmdDogMTVweDtcclxufVxyXG4udGFjZ3VpLWJsb2NrdWktbWFpbi1tZXNzYWdlIHtcclxuICBiYWNrZ3JvdW5kLWNvbG9yOiAjZmZmO1xyXG4gIHBvc2l0aW9uOiBhYnNvbHV0ZTtcclxuICB0b3A6IDUwJTtcclxuICBsZWZ0OiA0MCU7XHJcbiAgcGFkZGluZzogMTVweDtcclxufVxyXG4udGFjZ3VpLWJsb2NrdWktbWFpbiB7XHJcbiAgYmFja2dyb3VuZC1jb2xvcjogIzQ0NDQ0NDI5O1xyXG4gIHBvc2l0aW9uOiBhYnNvbHV0ZTtcclxuICB3aWR0aDogMTAwJTtcclxuICBoZWlnaHQ6IDEwMCU7XHJcbn1cclxuXHJcbi50YWNndWktYmxvY2t1aS1wb3J0bGV0IHtcclxuICBwb3NpdGlvbjogcmVsYXRpdmU7XHJcbn1cclxuIl19 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.ts":
/*!**************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.ts ***!
  \**************************************************************************************************/
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
var TacDeviceFormComponent = /** @class */ (function () {
    function TacDeviceFormComponent(toastr) {
        this.toastr = toastr;
        this.objectKeys = Object.keys;
        this.list = {
            group: {
                multiple: false,
                title: 'Device Group',
                title_sidebar: 'Device Groups List',
                search: true,
                apiurl: 'api/tacacs/device/group/list/',
            },
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
            },
            address: {
                multiple: false,
                title: 'Address',
                title_sidebar: 'Address List',
                search: true,
                apiurl: 'api/obj/address/list/',
                addNew: 'address'
            },
        };
    }
    TacDeviceFormComponent.prototype.ngOnInit = function () {
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
    TacDeviceFormComponent.prototype.setGroup = function (data) {
        //console.log(data)
        this.options.data.group = data;
    };
    TacDeviceFormComponent.prototype.setAcl = function (data) {
        console.log(data);
        this.options.data.acl = data;
    };
    TacDeviceFormComponent.prototype.setUserGroup = function (data) {
        //console.log(data)
        this.options.data.user_group = data;
    };
    TacDeviceFormComponent.prototype.setAddr = function (data) {
        //console.log(data)
        this.options.data.address = data;
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacDeviceFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacDeviceFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], TacDeviceFormComponent.prototype, "loading", void 0);
    TacDeviceFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-tac-device-form',
            template: __webpack_require__(/*! ./tac-device-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./tac-device-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/tac-device-form/tac-device-form.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService])
    ], TacDeviceFormComponent);
    return TacDeviceFormComponent;
}());
exports.TacDeviceFormComponent = TacDeviceFormComponent;


/***/ })

}]);
//# sourceMappingURL=devices-devices-module.js.map