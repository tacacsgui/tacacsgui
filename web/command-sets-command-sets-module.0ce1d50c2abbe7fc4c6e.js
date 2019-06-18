(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["command-sets-command-sets-module"],{

/***/ "./src/app/views/pages/tacacs/objects/command-sets/add/add.component.html":
/*!********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/add/add.component.html ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-obj-commands-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-obj-commands-form>\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"add()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Add CMD Set</button>&nbsp;\n    <a routerLink=\"..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/add/add.component.scss":
/*!********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/add/add.component.scss ***!
  \********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9vYmplY3RzL2NvbW1hbmQtc2V0cy9hZGQvYWRkLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/add/add.component.ts":
/*!******************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/add/add.component.ts ***!
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
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Model CMD
var obj_commands_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/obj-commands-form/obj-commands.model */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands.model.ts");
//Service//
var cmd_service_1 = __webpack_require__(/*! ../cmd.service */ "./src/app/views/pages/tacacs/objects/command-sets/cmd.service.ts");
var AddComponent = /** @class */ (function () {
    function AddComponent(toastr, cmd_service, router, route) {
        this.toastr = toastr;
        this.cmd_service = cmd_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
        this.formParameters = {
            action: 'add',
            data: new obj_commands_model_1.CMD,
            old_data: new obj_commands_model_1.CMD
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
        data.junos = (data.junos.length) ? data.junos.join(',') : '';
        console.log(data);
        this.cmd_service.add(data).subscribe(function (data) {
            // console.log(data)
            _this.validation.next(data.error.validation);
            // console.log(this.validation.getValue())
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.cmd) {
                _this.toastr.success('Command Added!');
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
            template: __webpack_require__(/*! ./add.component.html */ "./src/app/views/pages/tacacs/objects/command-sets/add/add.component.html"),
            styles: [__webpack_require__(/*! ./add.component.scss */ "./src/app/views/pages/tacacs/objects/command-sets/add/add.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            cmd_service_1.CMDService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], AddComponent);
    return AddComponent;
}());
exports.AddComponent = AddComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.html":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.html ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-main-table [options]=\"tableOptions\">\n</kt-main-table>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.scss":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.scss ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9vYmplY3RzL2NvbW1hbmQtc2V0cy9jb21tYW5kLXNldHMuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.ts":
/*!***********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.ts ***!
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
var CommandSetsComponent = /** @class */ (function () {
    function CommandSetsComponent() {
        this.tableOptions = {
            table: {
                delBtn: '/obj/cmd/delete/',
                editBtn: true,
                selectable: true,
                preview: {
                    target: 'cmd'
                },
                pagination: false,
                mainUrl: '/obj/cmd/datatables/',
                sort: {
                    column: 'name',
                    direction: 'asc'
                },
                editable: true,
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    name: { title: 'Name', show: true, sortable: true },
                    type: { title: 'Type', show: true, sortable: true,
                        htmlPattern: function (data) {
                            //console.log(data, column_name, index);
                            var type = (data == 1) ? 'JunOS' : 'General';
                            return '<span title="' + type + '">' + type + '</span>';
                        }
                    },
                    created_at: { title: 'Created', show: false, sortable: true },
                    updated_at: { title: 'Updated', show: false, sortable: true },
                },
            },
            buttons: {
                add: {
                    enable: true,
                    name: 'Add CMD Set',
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
    CommandSetsComponent.prototype.ngOnInit = function () {
    };
    CommandSetsComponent = __decorate([
        core_1.Component({
            selector: 'kt-command-sets',
            template: __webpack_require__(/*! ./command-sets.component.html */ "./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.html"),
            styles: [__webpack_require__(/*! ./command-sets.component.scss */ "./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], CommandSetsComponent);
    return CommandSetsComponent;
}());
exports.CommandSetsComponent = CommandSetsComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/command-sets.module.ts":
/*!********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/command-sets.module.ts ***!
  \********************************************************************************/
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
//Form
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
var core_module_1 = __webpack_require__(/*! ../../../../../core/core.module */ "./src/app/core/core.module.ts");
var pages_module_1 = __webpack_require__(/*! ../../../pages.module */ "./src/app/views/pages/pages.module.ts");
var partials_module_1 = __webpack_require__(/*! ../../../../partials/partials.module */ "./src/app/views/partials/partials.module.ts");
var obj_commands_form_module_1 = __webpack_require__(/*! ../../../../partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.module */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.module.ts");
// import { DragDropModule } from '@angular/cdk/drag-drop';
var command_sets_component_1 = __webpack_require__(/*! ./command-sets.component */ "./src/app/views/pages/tacacs/objects/command-sets/command-sets.component.ts");
var add_component_1 = __webpack_require__(/*! ./add/add.component */ "./src/app/views/pages/tacacs/objects/command-sets/add/add.component.ts");
var edit_component_1 = __webpack_require__(/*! ./edit/edit.component */ "./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.ts");
var CommandSetsModule = /** @class */ (function () {
    function CommandSetsModule() {
    }
    CommandSetsModule = __decorate([
        core_1.NgModule({
            declarations: [
                add_component_1.AddComponent,
                edit_component_1.EditComponent,
                command_sets_component_1.CommandSetsComponent,
            ],
            imports: [
                common_1.CommonModule,
                pages_module_1.PagesModule,
                core_module_1.CoreModule,
                ng_bootstrap_1.NgbModule,
                partials_module_1.PartialsModule,
                forms_1.FormsModule,
                // DragDropModule,
                obj_commands_form_module_1.ObjCommandsFormModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: command_sets_component_1.CommandSetsComponent
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
    ], CommandSetsModule);
    return CommandSetsModule;
}());
exports.CommandSetsModule = CommandSetsModule;


/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.html":
/*!**********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.html ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-obj-commands-form [options]=\"formParameters\" [validation]=\"validation\" [loading]=\"loadingForm\">\n</kt-obj-commands-form>\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Save CMD Set</button>&nbsp;\n    <a routerLink=\"../..\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</a>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.scss":
/*!**********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.scss ***!
  \**********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9vYmplY3RzL2NvbW1hbmQtc2V0cy9lZGl0L2VkaXQuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.ts":
/*!********************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.ts ***!
  \********************************************************************************/
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
//Model CMD
var obj_commands_model_1 = __webpack_require__(/*! ../../../../../partials/layout/tacgui/_forms/obj-commands-form/obj-commands.model */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands.model.ts");
//Service//
var cmd_service_1 = __webpack_require__(/*! ../cmd.service */ "./src/app/views/pages/tacacs/objects/command-sets/cmd.service.ts");
var EditComponent = /** @class */ (function () {
    function EditComponent(toastr, cmd_service, router, route) {
        this.toastr = toastr;
        this.cmd_service = cmd_service;
        this.router = router;
        this.route = route;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.formParameters = {
            action: 'add',
            data: new obj_commands_model_1.CMD,
            old_data: new obj_commands_model_1.CMD
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
        this.cmd_service.get(id).subscribe(function (data) {
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
        // console.log(JSON.stringify(this.formParameters.data), JSON.stringify(this.formParameters.old_data))
        if (JSON.stringify(data) == JSON.stringify(old_data)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        data.junos = (data.junos.length) ? data.junos.join(',') : '';
        console.log(data);
        this.cmd_service.save(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loadingForm.next(false);
                return;
            }
            if (data.save) {
                _this.toastr.success('CMD Set Changed!');
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
            template: __webpack_require__(/*! ./edit.component.html */ "./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.html"),
            styles: [__webpack_require__(/*! ./edit.component.scss */ "./src/app/views/pages/tacacs/objects/command-sets/edit/edit.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            cmd_service_1.CMDService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], EditComponent);
    return EditComponent;
}());
exports.EditComponent = EditComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.html":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.html ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label>Main Command Name (First part)</label>\n      <input type=\"text\" class=\"form-control form-control-sm\"\n          [ngClass]=\"{ 'is-invalid' : (validation | async)?.cmd }\"\n          [(ngModel)]=\"options.data.cmd\" placeholder=\"Main Command\" autocomplete=\"off\">\n          <!-- is-invalid -->\n      <div class=\"invalid-feedback\">\n        <p *ngFor=\"let message of (validation | async)?.cmd;\">{{message}}</p>\n      </div>\n      <span class=\"form-text text-muted\">first part of command, e.g. <i>show,telnet,configure</i> and so on</span>\n    </div>\n  </div>\n  <div class=\"col-6\">\n    <div class=\"form-group\">\n      <label style=\"width: 100%;\">Implicit Permit</label>\n        <span class=\"kt-switch kt-switch--icon kt-switch--outline kt-switch--success\">\n          <label>\n            <input type=\"checkbox\" checked [(ngModel)]=\"options.data.cmd_permit_end\">\n            <span></span>\n          </label>\n        </span>\n    </div>\n  </div>\n</div>\n<div class=\"row\">\n  <div class=\"col-8\">\n    <div class=\"form-group\">\n      <div class=\"input-group\">\n\t\t\t\t<div class=\"input-group-prepend\">\n\t\t\t\t\t<button *ngIf=\"!!argAction\" (click)=\"argAction=+!argAction\" class=\"btn btn-outline-success\">\n            Permit\n          </button>\n\t\t\t\t\t<button *ngIf=\"!argAction\" (click)=\"argAction=+!argAction\" class=\"btn btn-outline-danger\">\n            Deny\n          </button>\n\t\t\t\t</div>\n\t\t\t\t<input type=\"text\" class=\"form-control\" [(ngModel)]=\"newArg\" placeholder=\"command argument\">\n\t\t\t\t<div class=\"input-group-append\">\n\t\t\t\t\t<button class=\"btn btn-success\" (click)=\"addArg()\">Add</button>\n\t\t\t\t</div>\n\t\t\t</div>\n    </div>\n  </div>\n  <div class=\"col-8\">\n    <table class=\"table\" cdkDropList (cdkDropListDropped)=\"drop($event)\">\n      <ng-container *ngFor=\"let arg of options.data.cmd_attr; let i = index\">\n        <tr [ngClass]=\"{'arg-line-deny' : !arg.action , 'arg-line-permit' : arg.action}\" cdkDrag>\n          <td width=\"30px\" cdkDragHandle><i class=\"fa fa-arrows-alt\"></i><input type=\"hidden\" [(ngModel)]=\"arg.order\"></td>\n          <td><b>{{ (arg.action) ? 'permit' : 'deny' }}</b></td>\n          <td>{{arg.arg}}</td>\n          <td><a class=\"del-arg\" (click)=\"delArg(i)\">x</a></td>\n        </tr>\n      </ng-container>\n      <tr class=\"arg-line-permit-implicit\" *ngIf=\"options.data.cmd_permit_end\">\n        <td></td>\n        <td>permit</td>\n        <td>/.*/</td>\n        <td></td>\n      </tr>\n    </table>\n  </div>\n</div>\n<div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n    <div class=\"card\">\n        <div class=\"card-header\">\n            <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMS = !notCollapsedMS\"\n                    [attr.aria-expanded]=\"!notCollapsedMS\">Messages</div>\n        </div>\n        <div [ngbCollapse]=\"!notCollapsedMS\">\n            <div class=\"card-body\">\n              <div class=\"form-group\">\n                <label class=\"pull-right\">Message with permitted command</label>\n                <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.message_permit\" rows=\"3\"></textarea>\n              </div>\n              <div class=\"form-group\">\n                <label class=\"pull-right\">Message with denied command</label>\n                <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.message_deny\" rows=\"3\"></textarea>\n              </div>\n            </div>\n        </div>\n    </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.scss":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.scss ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".arg-line-deny {\n  background-color: #fd397a47; }\n\n.arg-line-permit {\n  background-color: #0abb8742; }\n\n.del-arg {\n  cursor: pointer; }\n\n.arg-line-permit-implicit {\n  color: #a7abc3; }\n\n.cdk-drag-preview {\n  border: 1px solid #ebedf2;\n  padding: 7px;\n  margin: 3px;\n  box-sizing: border-box;\n  background-color: #fff; }\n\n.cdk-drag-preview a.del-arg {\n  display: none; }\n\n.cdk-drag-placeholder {\n  opacity: 0; }\n\n.cdk-drag-animating {\n  transition: -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1), -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1); }\n\n.cdk-drop-list-dragging {\n  transition: -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1);\n  transition: transform 250ms cubic-bezier(0, 0, 0.2, 1), -webkit-transform 250ms cubic-bezier(0, 0, 0.2, 1); }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYXJ0aWFscy9sYXlvdXQvdGFjZ3VpL19mb3Jtcy9vYmotY29tbWFuZHMtZm9ybS9nZW5lcmFsL2dlbmVyYWwuY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBR0E7RUFDRSwyQkFBMkIsRUFBQTs7QUFFN0I7RUFDRSwyQkFBMkIsRUFBQTs7QUFFN0I7RUFDRSxlQUFlLEVBQUE7O0FBRWpCO0VBQ0UsY0FBYyxFQUFBOztBQUdoQjtFQUNFLHlCQUF5QjtFQUN6QixZQUFZO0VBQ1osV0FBVztFQUNYLHNCQUFzQjtFQUN0QixzQkFBc0IsRUFBQTs7QUFFeEI7RUFDRSxhQUFhLEVBQUE7O0FBR2Y7RUFDRSxVQUFVLEVBQUE7O0FBR1o7RUFDRSw4REFBc0Q7RUFBdEQsc0RBQXNEO0VBQXRELDBHQUFzRCxFQUFBOztBQUd4RDtFQUNFLDhEQUFzRDtFQUF0RCxzREFBc0Q7RUFBdEQsMEdBQXNELEVBQUEiLCJmaWxlIjoic3JjL2FwcC92aWV3cy9wYXJ0aWFscy9sYXlvdXQvdGFjZ3VpL19mb3Jtcy9vYmotY29tbWFuZHMtZm9ybS9nZW5lcmFsL2dlbmVyYWwuY29tcG9uZW50LnNjc3MiLCJzb3VyY2VzQ29udGVudCI6WyIuYXJnLWxpbmUge1xyXG5cclxufVxyXG4uYXJnLWxpbmUtZGVueSB7XHJcbiAgYmFja2dyb3VuZC1jb2xvcjogI2ZkMzk3YTQ3O1xyXG59XHJcbi5hcmctbGluZS1wZXJtaXQge1xyXG4gIGJhY2tncm91bmQtY29sb3I6ICMwYWJiODc0MjtcclxufVxyXG4uZGVsLWFyZyB7XHJcbiAgY3Vyc29yOiBwb2ludGVyO1xyXG59XHJcbi5hcmctbGluZS1wZXJtaXQtaW1wbGljaXR7XHJcbiAgY29sb3I6ICNhN2FiYzM7XHJcbn1cclxuXHJcbi5jZGstZHJhZy1wcmV2aWV3IHtcclxuICBib3JkZXI6IDFweCBzb2xpZCAjZWJlZGYyO1xyXG4gIHBhZGRpbmc6IDdweDtcclxuICBtYXJnaW46IDNweDtcclxuICBib3gtc2l6aW5nOiBib3JkZXItYm94O1xyXG4gIGJhY2tncm91bmQtY29sb3I6ICNmZmY7XHJcbn1cclxuLmNkay1kcmFnLXByZXZpZXcgYS5kZWwtYXJnIHtcclxuICBkaXNwbGF5OiBub25lO1xyXG59XHJcblxyXG4uY2RrLWRyYWctcGxhY2Vob2xkZXIge1xyXG4gIG9wYWNpdHk6IDA7XHJcbn1cclxuXHJcbi5jZGstZHJhZy1hbmltYXRpbmcge1xyXG4gIHRyYW5zaXRpb246IHRyYW5zZm9ybSAyNTBtcyBjdWJpYy1iZXppZXIoMCwgMCwgMC4yLCAxKTtcclxufVxyXG5cclxuLmNkay1kcm9wLWxpc3QtZHJhZ2dpbmcge1xyXG4gIHRyYW5zaXRpb246IHRyYW5zZm9ybSAyNTBtcyBjdWJpYy1iZXppZXIoMCwgMCwgMC4yLCAxKTtcclxufVxyXG4iXX0= */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.ts":
/*!****************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.ts ***!
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
//CDK
var drag_drop_1 = __webpack_require__(/*! @angular/cdk/drag-drop */ "./node_modules/@angular/cdk/esm5/drag-drop.es5.js");
var GeneralComponent = /** @class */ (function () {
    function GeneralComponent() {
        this.argAction = 1;
        this.newArg = '';
    }
    GeneralComponent.prototype.ngOnInit = function () {
    };
    GeneralComponent.prototype.addArg = function () {
        if (this.newArg == '')
            return;
        var regex = /^\/.*\/\s{0,}$/;
        var text = this.newArg;
        text = (text && !regex.test(text)) ? '/' + text + '/' : text;
        for (var i = 0; i < this.options.data.cmd_attr.length; i++) {
            if (this.options.data.cmd_attr[i].arg == text)
                return;
        }
        this.options.data.cmd_attr.push({ action: this.argAction, arg: text });
        this.newArg = '';
    };
    GeneralComponent.prototype.delArg = function (index) {
        this.options.data.cmd_attr.splice(index, 1);
    };
    GeneralComponent.prototype.drop = function (event) {
        drag_drop_1.moveItemInArray(this.options.data.cmd_attr, event.previousIndex, event.currentIndex);
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], GeneralComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], GeneralComponent.prototype, "validation", void 0);
    GeneralComponent = __decorate([
        core_1.Component({
            selector: 'kt-general',
            template: __webpack_require__(/*! ./general.component.html */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.html"),
            styles: [__webpack_require__(/*! ./general.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], GeneralComponent);
    return GeneralComponent;
}());
exports.GeneralComponent = GeneralComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.html":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.html ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-12\">\n    <div class=\"form-group\">\n      <label>List of Commands</label>\n      <form [formGroup]=\"form\">\n          <tag-input\n              [formControlName]=\"'chips'\"\n              [modelAsStrings]=\"true\"\n              [secondaryPlaceholder]=\"'Type Command'\"\n              [placeholder]=\"'+ Command'\"\n              [separatorKeyCodes]=\"[13,188]\"\n              theme='bootstrap'>\n          </tag-input>\n      </form>\n      <span class=\"form-text text-muted\">user <kbd>Enter ↵</kbd> or comma (<kbd> , </kbd>) key to separate commands</span>\n\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.scss":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.scss ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL29iai1jb21tYW5kcy1mb3JtL2p1bmlwZXIvanVuaXBlci5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.ts":
/*!****************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.ts ***!
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
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
var JuniperComponent = /** @class */ (function () {
    function JuniperComponent(fb) {
        this.fb = fb;
    }
    JuniperComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.form = this.fb.group({
            chips: [this.options.data.junos, []],
        });
        this.form.get('chips').valueChanges.subscribe(function (val) {
            // console.log(val)
            _this.options.data.junos = val;
        });
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], JuniperComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], JuniperComponent.prototype, "validation", void 0);
    JuniperComponent = __decorate([
        core_1.Component({
            selector: 'kt-juniper',
            template: __webpack_require__(/*! ./juniper.component.html */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.html"),
            styles: [__webpack_require__(/*! ./juniper.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.scss")]
        }),
        __metadata("design:paramtypes", [forms_1.FormBuilder])
    ], JuniperComponent);
    return JuniperComponent;
}());
exports.JuniperComponent = JuniperComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.html":
/*!********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.html ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n    \t\t\t\t\t<label>Type</label>\n    \t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.type\">\n    \t\t\t\t\t\t<option value=\"0\">General (Cisco Type)</option>\n    \t\t\t\t\t\t<option value=\"1\">Juniper</option>\n    \t\t\t\t\t</select>\n    \t\t\t\t</div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <label>CMD Set Name</label>\n              <input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.name }\"\n                  [(ngModel)]=\"options.data.name\" placeholder=\"CMD Set Name\" autocomplete=\"off\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.name;\">{{message}}</p>\n              </div>\n              <span class=\"form-text text-muted\">it should be unique, but you can change it later</span>\n            </div>\n          </div>\n        </div>\n        <ng-container *ngIf=\"options.data.type == 0\">\n          <kt-general [options]=\"options\" [validation]=\"validation\">\n          </kt-general>\n        </ng-container>\n        <ng-container *ngIf=\"options.data.type == 1\">\n          <kt-juniper [options]=\"options\" [validation]=\"validation\">\n          </kt-juniper>\n        </ng-container>\n        <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMS = !notCollapsedMS\"\n                            [attr.aria-expanded]=\"!notCollapsedMS\">Manual Configuration</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedMS\">\n                    <div class=\"card-body\">\n                      <div class=\"form-group\">\n                        <label class=\"pull-right\">Manual Configuration</label>\n                        <textarea class=\"form-control form-control-sm\" [(ngModel)]=\"options.data.manual\" rows=\"5\"></textarea>\n                      </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n        <p *ngIf=\"options.data.created_at && options.data.updated_at\">\n          <span class=\"text-muted\">Created: {{options.data.created_at}}</span>\n          <span class=\"text-muted pull-right\">Last Update: {{options.data.updated_at}}</span>\n        </p>\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.scss":
/*!********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.scss ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2Zvcm1zL29iai1jb21tYW5kcy1mb3JtL29iai1jb21tYW5kcy1mb3JtLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.ts":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.ts ***!
  \******************************************************************************************************/
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
var ObjCommandsFormComponent = /** @class */ (function () {
    function ObjCommandsFormComponent(toastr) {
        this.toastr = toastr;
        this.type = 0;
    }
    ObjCommandsFormComponent.prototype.ngOnInit = function () {
        var _this = this;
        console.log(this.options);
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
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ObjCommandsFormComponent.prototype, "options", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ObjCommandsFormComponent.prototype, "validation", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Object)
    ], ObjCommandsFormComponent.prototype, "loading", void 0);
    ObjCommandsFormComponent = __decorate([
        core_1.Component({
            selector: 'kt-obj-commands-form',
            template: __webpack_require__(/*! ./obj-commands-form.component.html */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.html"),
            styles: [__webpack_require__(/*! ./obj-commands-form.component.scss */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService])
    ], ObjCommandsFormComponent);
    return ObjCommandsFormComponent;
}());
exports.ObjCommandsFormComponent = ObjCommandsFormComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.module.ts":
/*!***************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.module.ts ***!
  \***************************************************************************************************/
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
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
//PortletModule
var portlet_module_1 = __webpack_require__(/*! ../../../../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
//Form
var ngx_chips_1 = __webpack_require__(/*! ngx-chips */ "./node_modules/ngx-chips/esm5/ngx-chips.js");
// import { BrowserAnimationsModule } from '@angular/platform-browser/animations'; // this is needed!
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
var drag_drop_1 = __webpack_require__(/*! @angular/cdk/drag-drop */ "./node_modules/@angular/cdk/esm5/drag-drop.es5.js");
var pages_module_1 = __webpack_require__(/*! ../../../../../pages/pages.module */ "./src/app/views/pages/pages.module.ts");
var obj_commands_form_component_1 = __webpack_require__(/*! ./obj-commands-form.component */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/obj-commands-form.component.ts");
var general_component_1 = __webpack_require__(/*! ./general/general.component */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/general/general.component.ts");
var juniper_component_1 = __webpack_require__(/*! ./juniper/juniper.component */ "./src/app/views/partials/layout/tacgui/_forms/obj-commands-form/juniper/juniper.component.ts");
var ObjCommandsFormModule = /** @class */ (function () {
    function ObjCommandsFormModule() {
    }
    ObjCommandsFormModule = __decorate([
        core_1.NgModule({
            declarations: [
                obj_commands_form_component_1.ObjCommandsFormComponent,
                general_component_1.GeneralComponent,
                juniper_component_1.JuniperComponent
            ],
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                ngx_chips_1.TagInputModule,
                drag_drop_1.DragDropModule,
                // BrowserAnimationsModule,
                forms_1.ReactiveFormsModule,
                ng_bootstrap_1.NgbModule,
                portlet_module_1.PortletModule,
                pages_module_1.PagesModule
            ],
            exports: [
                obj_commands_form_component_1.ObjCommandsFormComponent,
                general_component_1.GeneralComponent,
                juniper_component_1.JuniperComponent
            ]
        })
    ], ObjCommandsFormModule);
    return ObjCommandsFormModule;
}());
exports.ObjCommandsFormModule = ObjCommandsFormModule;


/***/ })

}]);
//# sourceMappingURL=command-sets-command-sets-module.0ce1d50c2abbe7fc4c6e.js.map