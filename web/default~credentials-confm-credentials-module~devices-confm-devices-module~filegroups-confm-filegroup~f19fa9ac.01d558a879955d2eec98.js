(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["default~credentials-confm-credentials-module~devices-confm-devices-module~filegroups-confm-filegroup~f19fa9ac"],{

/***/ "./src/app/views/pages/confmanager/settings/confmanager-settings.module.ts":
/*!*********************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/confmanager-settings.module.ts ***!
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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
//Page Module
var pages_module_1 = __webpack_require__(/*! ../../../pages/pages.module */ "./src/app/views/pages/pages.module.ts");
var confmanager_module_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_forms/confmanager/confmanager.module */ "./src/app/views/partials/layout/tacgui/_forms/confmanager/confmanager.module.ts");
// import { QueriesComponent } from './queries/queries.component';
// import { DevicesComponent } from './devices/devices.component';
// import { ModelsComponent } from './models/models.component';
// import { CredentialsComponent } from './credentials/credentials.component';
// import { FilegroupsComponent } from './filegroups/filegroups.component';
var main_component_1 = __webpack_require__(/*! ./main/main.component */ "./src/app/views/pages/confmanager/settings/main/main.component.ts");
var ConfmanagerSettingsModule = /** @class */ (function () {
    function ConfmanagerSettingsModule() {
    }
    ConfmanagerSettingsModule = __decorate([
        core_1.NgModule({
            declarations: [
                // QueriesComponent,
                // DevicesComponent,
                // ModelsComponent,
                // CredentialsComponent,
                // FilegroupsComponent,
                main_component_1.MainComponent
            ],
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                pages_module_1.PagesModule,
                confmanager_module_1.ConfmanagerModule,
                ng_bootstrap_1.NgbModule,
                router_1.RouterModule.forChild([
                    {
                        path: 'queries',
                        loadChildren: './queries/confm-queries.module#ConfmQueriesModule'
                    },
                    {
                        path: 'devices',
                        loadChildren: './devices/confm-devices.module#ConfmDevicesModule'
                    },
                    {
                        path: 'models',
                        loadChildren: './models/confm-models.module#ConfmModelsModule'
                    },
                    {
                        path: 'credentials',
                        loadChildren: './credentials/confm-credentials.module#ConfmCredentialsModule'
                    },
                    {
                        path: 'filegroups',
                        loadChildren: './filegroups/confm-filegroups.module#ConfmFilegroupsModule'
                    },
                    {
                        path: 'main',
                        component: main_component_1.MainComponent
                    },
                ]),
            ],
            exports: [
                confmanager_module_1.ConfmanagerModule
            ]
        })
    ], ConfmanagerSettingsModule);
    return ConfmanagerSettingsModule;
}());
exports.ConfmanagerSettingsModule = ConfmanagerSettingsModule;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/main/main.component.html":
/*!***************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/main/main.component.html ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h4>Start/Stop/Reload Configuration Manager</h4>\n        <br>\n        <div class=\"row\">\n          <div class=\"col-8\">\n            <div class=\"btn-group btn-group-sm\" role=\"group\" aria-label=\"...\">\n                <button type=\"button\"\n                  (click)=\"toogle('start')\"\n                  class=\"btn btn-outline-info\" ngbPopover=\"Start\"\n                  triggers=\"mouseenter:mouseleave\">\n                  <i class=\"fa fa-play\"></i>\n                </button>\n                <button type=\"button\"\n                  (click)=\"toogle('stop')\"\n                  class=\"btn btn-outline-info\" ngbPopover=\"Stop\"\n                  triggers=\"mouseenter:mouseleave\">\n                  <i class=\"fa fa-stop\"></i>\n                </button>\n                <button type=\"button\"\n                  (click)=\"getInfo()\"\n                  class=\"btn btn-outline-info\" ngbPopover=\"Info\"\n                  triggers=\"mouseenter:mouseleave\">\n                  <i class=\"fa fa-info\"></i>\n                </button>\n                <button type=\"button\"\n                  (click)=\"toogle('force')\"\n                  class=\"btn btn-outline-info\" ngbPopover=\"Force Start\"\n                  triggers=\"mouseenter:mouseleave\">\n                  <i class=\"fa fa-rocket\"></i>\n                </button>\n            </div>\n          </div>\n        </div>\n        <br>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <label>Current Status</label>\n            <input class=\"form-control form-control-sm\" type=\"text\" [value]=\"( currentStatus | async )\" disabled>\n          </div>\n        </div>\n      </div>\n    </div>\n\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h4>Cron Settings</h4>\n        <div class=\"row\">\n\t\t\t\t<div class=\"col-6\">\n\t\t\t\t\t<label>Configuration Manager Start</label>\n\t\t\t\t\t<div class=\"form-group\">\n            <div class=\"kt-radio-list\">\n\t\t\t\t\t\t\t<label class=\"kt-radio kt-radio--brand\">\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"radio1\" value=\"day\" [(ngModel)]=\"cm.period\"> Every day\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n\t\t\t\t\t\t\t<label class=\"kt-radio kt-radio--brand\">\n\t\t\t\t\t\t\t\t<input type=\"radio\" name=\"radio1\"  value=\"week\" [(ngModel)]=\"cm.period\"> Every Week\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<!-- <div class=\"radio\">\n\t\t\t\t\t\t  <label><input type=\"radio\" name=\"cm_period\" value=\"day\">every day</label>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"radio\">\n\t\t\t\t\t\t  <label><input type=\"radio\" name=\"cm_period\" value=\"week\">every week</label>\n\t\t\t\t\t\t</div> -->\n\t\t\t\t\t\t<input type=\"hidden\" name=\"cm_period_native\">\n\t\t\t\t\t</div>\n\t\t\t\t\t<div class=\"row\">\n\t\t\t\t\t\t<div class=\"col-12\">\n\t\t\t\t\t\t\t<div class=\"form-group\" *ngIf=\"timeReady | async\">\n\t\t\t\t        <ngb-timepicker [size]=\"small\" [minuteStep]=\"10\" [(ngModel)]=\"cm.time\"></ngb-timepicker>\n\t\t\t\t      </div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t\t<div class=\"col-12\">\n\t\t\t\t\t\t\t<div class=\"form-group\">\n\t\t\t\t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"cm.week\" [disabled]=\"cm.period == 'day'\">\n\t\t\t\t\t\t\t\t\t<option value=\"1\">Monday</option>\n\t\t\t\t\t\t\t\t\t<option value=\"2\">Tuesday</option>\n\t\t\t\t\t\t\t\t\t<option value=\"3\">Wednesday</option>\n\t\t\t\t\t\t\t\t\t<option value=\"4\">Thursday</option>\n\t\t\t\t\t\t\t\t\t<option value=\"5\">Friday</option>\n\t\t\t\t\t\t\t\t\t<option value=\"6\">Saturday</option>\n\t\t\t\t\t\t\t\t\t<option value=\"0\">Sunday</option>\n\t\t\t\t\t\t\t\t</select>\n\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"week_native\">\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n\t\t\t\t\t<p class=\"help-block\">select time when to run configuration manager, time to start collecting data</p>\n\t\t\t\t</div>\n\t\t\t\t<div class=\"col-6\">\n\t\t\t\t\t<label>Git Commit Start Every</label>\n\t\t\t\t\t<div class=\"form-group\">\n\t\t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"git.period\">\n\t\t\t\t\t\t\t<option value=\"10\">10 minutes</option>\n\t\t\t\t\t\t\t<option value=\"20\">20 minutes</option>\n\t\t\t\t\t\t\t<option value=\"30\">30 minutes</option>\n\t\t\t\t\t\t\t<option value=\"40\">40 minutes</option>\n\t\t\t\t\t\t\t<option value=\"50\">50 minutes</option>\n\t\t\t\t\t\t\t<option value=\"60\">60 minutes</option>\n\t\t\t\t\t\t</select>\n\t\t\t\t\t</div>\n\t\t\t\t\t<p class=\"help-block\">select time when configuration manager will check any changes inside of local files (configurations)</p>\n\t\t\t\t</div>\n\t\t\t</div>\n\n      </div>\n    </div>\n\n  </div>\n</div>\n<br>\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-warning btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Save</button>&nbsp;\n  </div>\n</div>\n\n<br>\n\n<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Full Configuration Preview</h5>\n        <button type=\"button\" class=\"btn btn-sm btn-warning\" (click)=\"showConfig()\">Show</button>&nbsp;\n        <button type=\"button\" class=\"btn btn-default btn-elevate btn-sm\"\n        *ngIf=\"(configPreview | async)\"\n        (click)=\"configPreview.next('')\">Hide</button>\n        <ng-container *ngIf=\"(configPreview | async)\">\n          <hr>\n          <pre>{{ configPreview | async }}</pre>\n        </ng-container>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/main/main.component.scss":
/*!***************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/main/main.component.scss ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2NvbmZtYW5hZ2VyL3NldHRpbmdzL21haW4vbWFpbi5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/main/main.component.ts":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/main/main.component.ts ***!
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Service
var main_service_1 = __webpack_require__(/*! ./main.service */ "./src/app/views/pages/confmanager/settings/main/main.service.ts");
var MainComponent = /** @class */ (function () {
    function MainComponent(service, toastr) {
        this.service = service;
        this.toastr = toastr;
        this.statusMessage = new rxjs_1.BehaviorSubject('');
        this.validation = new rxjs_1.BehaviorSubject({});
        this.cm = {
            period: "day",
            time: {
                "hour": 1,
                "minute": 0
            },
            week: 1
        };
        this.git = {
            period: 60
        };
        this.timeReady = new rxjs_1.BehaviorSubject(false);
        this.currentStatus = new rxjs_1.BehaviorSubject('Loading...');
        this.configPreview = new rxjs_1.BehaviorSubject('');
    }
    MainComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.service.cron_get().subscribe(function (data) {
            console.log(data);
            if (data.cm) {
                _this.cm.period = (data.cm.period) ? data.cm.period : _this.cm.period;
                _this.cm.week = (data.cm.week) ? data.cm.week : _this.cm.week;
                data.cm.time = data.cm.time.split(':');
                _this.cm.time.hour = (data.cm.time[0]) ? parseInt(data.cm.time[0]) : _this.cm.time.hour;
                _this.cm.time.minute = (data.cm.time[1]) ? parseInt(data.cm.time[1]) : _this.cm.time.minute;
            }
            if (data.git)
                _this.git.period = (data.git.period) ? data.git.period : _this.git.period;
            console.log(_this.cm, _this.git);
            _this.timeReady.next(true);
        });
        this.getInfo();
    };
    MainComponent.prototype.toogle = function (action) {
        var _this = this;
        this.currentStatus.next('Loading...');
        this.service.toggle({ action: action }).subscribe(function (data) {
            console.log(data);
            _this.getInfo();
        });
    };
    MainComponent.prototype.getInfo = function () {
        var _this = this;
        this.currentStatus.next('Loading...');
        this.service.info().subscribe(function (data) {
            console.log(data);
            _this.currentStatus.next(data.info);
        });
    };
    MainComponent.prototype.showConfig = function () {
        var _this = this;
        this.configPreview.next('Loading...');
        this.service.preview().subscribe(function (data) {
            console.log(data);
            _this.configPreview.next(data.preview);
        });
    };
    MainComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    MainComponent.prototype.save = function () {
        var _this = this;
        var cm = this.makeClone(this.cm);
        cm.time = cm.time.hour + ':' + cm.time.minute;
        this.service.cron_post({ cm: cm, git: this.git }).subscribe(function (data) {
            console.log(data);
            if (data.crontab == 'done')
                _this.toastr.success('Settings Saved');
            else
                _this.toastr.error('Unexpected Error');
            _this.getInfo();
        });
    };
    MainComponent = __decorate([
        core_1.Component({
            selector: 'kt-main',
            template: __webpack_require__(/*! ./main.component.html */ "./src/app/views/pages/confmanager/settings/main/main.component.html"),
            styles: [__webpack_require__(/*! ./main.component.scss */ "./src/app/views/pages/confmanager/settings/main/main.component.scss")]
        }),
        __metadata("design:paramtypes", [main_service_1.MainService,
            ngx_toastr_1.ToastrService])
    ], MainComponent);
    return MainComponent;
}());
exports.MainComponent = MainComponent;


/***/ }),

/***/ "./src/app/views/pages/confmanager/settings/main/main.service.ts":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/confmanager/settings/main/main.service.ts ***!
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
var API_URL = 'api/confmanager/';
var MainService = /** @class */ (function () {
    function MainService(http) {
        this.http = http;
    }
    MainService.prototype.toggle = function (params) {
        return this.http.post(API_URL + 'toggle/', params)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    MainService.prototype.cron_get = function () {
        return this.http.get(API_URL + 'settings/cron/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.cron;
        }));
    };
    MainService.prototype.cron_post = function (params) {
        return this.http.post(API_URL + 'settings/cron/', params)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    MainService.prototype.info = function () {
        return this.http.get(API_URL + 'info/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    MainService.prototype.preview = function () {
        return this.http.get(API_URL + 'settings/preview/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    MainService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], MainService);
    return MainService;
}());
exports.MainService = MainService;


/***/ })

}]);
//# sourceMappingURL=default~credentials-confm-credentials-module~devices-confm-devices-module~filegroups-confm-filegroup~f19fa9ac.01d558a879955d2eec98.js.map