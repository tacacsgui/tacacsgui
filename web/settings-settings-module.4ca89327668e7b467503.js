(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["settings-settings-module"],{

/***/ "./src/app/views/pages/gui/settings/ha/ha.component.html":
/*!***************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/ha/ha.component.html ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Select Role</label>\n  \t\t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"server.role\"\n              [ngClass]=\"{ 'is-invalid' : (validation | async)?.role }\">\n                <option value=\"disabled\">disabled</option>\n                <option value=\"master\">master</option>\n                <option value=\"slave\">slave</option>\n  \t\t\t\t\t\t</select>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.role;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t</div>\n          </div>\n        </div>\n\n        <div class=\"row\" *ngIf=\"server.role=='master'\">\n          <div class=\"col-12\">\n            <div class=\"form-group \">\n  \t\t\t\t\t\t<label>Pre-Shared Key</label>\n  \t\t\t\t\t\t<div class=\"input-group\">\n  \t\t\t\t\t\t\t<div class=\"input-group-prepend\">\n  \t\t\t\t\t\t\t\t<button class=\"btn btn-sm btn-primary\" ngxClipboard\n                  [cbContent]=\"server.psk_master\" (cbOnSuccess)=\"copyKey($event)\" type=\"button\">Copy</button>\n  \t\t\t\t\t\t\t</div>\n  \t\t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"server.psk_master\" disabled>\n  \t\t\t\t\t\t\t<div class=\"input-group-append\">\n  \t\t\t\t\t\t\t\t<button class=\"btn btn-sm btn-warning\" type=\"button\" (click)=\"newKey()\">Generate</button>\n  \t\t\t\t\t\t\t</div>\n  \t\t\t\t\t\t</div>\n  \t\t\t\t\t</div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Listen Interface</label>\n  \t\t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"inter\" >\n                <ng-container *ngFor=\"let interf of inter_list;\">\n                  <option value=\"{{interf}}\">{{interf}}</option>\n                </ng-container>\n  \t\t\t\t\t\t</select>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.role;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t</div>\n          </div>\n          <div class=\"col-12\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>List of Slave's ip addresses</label>\n              <button type=\"button\" class=\"btn btn-outline-info btn-elevate btn-circle btn-icon pull-right btn-sm\"\n              ngbTooltip=\"Save slave list\"\n              (click)=\"slaveRefresh()\">\n                <i class=\"la la-refresh\"></i>\n              </button>\n  \t\t\t\t\t\t<textarea rows=\"6\" class=\"form-control\"  [(ngModel)]=\"server.slaves_ip\"\n              [ngClass]=\"{ 'is-invalid' : (validation | async)?.slaves_ip }\"></textarea>\n              <span class=\"form-text text-muted\">e.g. 10.1.1.2,10.1.1.4</span>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.slaves_ip;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t</div>\n          </div>\n        </div>\n\n        <div class=\"row\" *ngIf=\"server.role=='slave'\">\n          <div class=\"col-12\">\n            <div class=\"form-group \">\n  \t\t\t\t\t\t<label>Pre-Shared Key</label>\n\t\t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"server.psk_slave\"\n              [ngClass]=\"{ 'is-invalid' : (validation | async)?.psk_slave }\">\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.psk_slave;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t</div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Master IP</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"server.ipaddr_master\"\n              [ngClass]=\"{ 'is-invalid' : (validation | async)?.ipaddr_master }\"/>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.ipaddr_master;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t</div>\n          </div>\n        </div>\n\n        <div class=\"row\" *ngIf=\"(rootpw | async)\">\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>MySQL Root Password</label>\n  \t\t\t\t\t\t<input type=\"password\" class=\"form-control form-control-sm\" [(ngModel)]=\"server.rootpw\"/>\n  \t\t\t\t\t</div>\n          </div>\n        </div>\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loading | async) }\"\n      [disabled]=\"(loading | async)\">Save</button>&nbsp;\n    <button class=\"btn btn-warning btn-elevate btn-sm\"\n      (click)=\"status()\">Status</button>\n  </div>\n</div>\n<br>\n<div class=\"row\">\n\t<div class=\"col-9\" *ngIf=\"output | async\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n<pre>{{output | async}}</pre>\n      </div>\n    </div>\n    <br>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-9\">\n    <div class=\"card\" *ngIf=\"(masterInfo | async)?.ipaddr\">\n      <div class=\"card-body\">\n        <h6 class=\"card-subtitle mb-2 text-muted\">Master Info</h6>\n        <div class=\"table-responsive\">\n          <table class=\"table\">\n            <thead>\n              <tr>\n                <th>IP Address</th>\n                <th>API</th>\n                <th>DB Check</th>\n                <th>Last Check</th>\n              </tr>\n            </thead>\n            <tbody>\n              <tr>\n                <td>{{(masterInfo | async).ipaddr}}</td>\n                <td>{{(masterInfo | async).apiver}}</td>\n                <td>{{(masterInfo | async).dbcheck}}</td>\n                <td>{{(masterInfo | async).lastchk}}</td>\n              </tr>\n            </tbody>\n          </table>\n        </div>\n      </div>\n    </div>\n    <div class=\"card\" *ngIf=\"(slaveInfo | async).length > 0\">\n      <div class=\"card-body\">\n        <h6 class=\"card-subtitle mb-2 text-muted\">Slave Info</h6>\n        <div class=\"table-responsive\">\n          <table class=\"table\">\n            <thead>\n              <tr>\n                <th>IP Address</th>\n                <th>ID</th>\n                <th>Location</th>\n                <th>Last Check</th>\n              </tr>\n            </thead>\n            <tbody>\n              <tr *ngFor=\"let slave of (slaveInfo | async)\">\n                <td>{{slave.ipaddr}}</td>\n                <td>{{slave.slave_id}}</td>\n                <td>{{slave.location}}</td>\n                <td>{{slave.lastchk}}</td>\n              </tr>\n            </tbody>\n          </table>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/ha/ha.component.scss":
/*!***************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/ha/ha.component.scss ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9zZXR0aW5ncy9oYS9oYS5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/ha/ha.component.ts":
/*!*************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/ha/ha.component.ts ***!
  \*************************************************************/
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
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
//Service
var settings_service_1 = __webpack_require__(/*! ../settings.service */ "./src/app/views/pages/gui/settings/settings.service.ts");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var HaComponent = /** @class */ (function () {
    function HaComponent(service, toastr) {
        this.service = service;
        this.toastr = toastr;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loading = new rxjs_1.BehaviorSubject(true);
        this.server = {
            config_uid: "",
            interface: "",
            ipaddr: "",
            ipaddr_master: "",
            ipaddr_slave: "",
            psk_master: this.keyGen(),
            psk_slave: "",
            role: "disabled",
            slave_id_list: "",
            slaves_ip: ""
        };
        this.masterInfo = new rxjs_1.BehaviorSubject({});
        this.slaveInfo = new rxjs_1.BehaviorSubject([]);
        this.inter = '';
        this.inter_list = [];
        this.output = new rxjs_1.BehaviorSubject('');
        this.rootpw = new rxjs_1.BehaviorSubject(false);
    }
    HaComponent.prototype.ngOnInit = function () {
        this.initInfo();
    };
    HaComponent.prototype.initInfo = function () {
        var _this = this;
        this.slaveInfo.next([]);
        this.masterInfo.next({});
        rxjs_1.forkJoin(this.service.network_list(), this.service.ha_get())
            .pipe(operators_1.map(function (_a) {
            var inter = _a[0], data = _a[1];
            return [inter, data];
        }))
            .subscribe(function (data) {
            console.log(data);
            _this.inter_list = data[0].list;
            _this.inter = _this.inter_list[0];
            if (data[1].result && data[1].result.server)
                _this.server = data[1].result.server;
            if (data[1].result && data[1].result.server_list) {
                if (data[1].result.server_list.master && data[1].result.server_list.master.ipaddr)
                    _this.masterInfo.next(data[1].result.server_list.master);
                if (data[1].result.server_list.slave) {
                    var slaves = [];
                    for (var key in data[1].result.server_list.slave) {
                        data[1].result.server_list.slave[key].slave_id = key;
                        slaves[length] = data[1].result.server_list.slave[key];
                    }
                    //console.log(slaves)
                    _this.slaveInfo.next(slaves);
                }
                //console.log(this.masterInfo.getValue())
            }
            _this.loading.next(false);
        });
    };
    HaComponent.prototype.keyGen = function () {
        var length = 32; //Math.floor(Math.random() * (+16 - +16)) + +16; //224
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        return text;
    };
    HaComponent.prototype.newKey = function () {
        if (!confirm('Are you sure?'))
            return false;
        this.server.psk_master = this.keyGen();
        return true;
    };
    HaComponent.prototype.copyKey = function (e) {
        // console.log(e)
        if (e.isSuccess)
            this.toastr.success('You have copied the key');
    };
    HaComponent.prototype.putKey = function (e) {
        console.log(e.clipboardData);
    };
    HaComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    HaComponent.prototype.save = function () {
        var _this = this;
        if (!confirm('Are you sure? It will refresh all settings and create new instance of HA.'))
            return;
        this.loading.next(true);
        this.rootpw.next(false);
        this.output.next('');
        var data = this.makeClone(this.server);
        var inter = this.inter.split('-').map(Function.prototype.call, String.prototype.trim);
        data.slaves_ip = data.slaves_ip.split(',').map(Function.prototype.call, String.prototype.trim);
        data.interface = inter[0];
        data.ipaddr = inter[1];
        this.service.ha_post(data).subscribe(function (data) {
            _this.initInfo();
            _this.loading.next(false);
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loading.next(false);
                return;
            }
            if (data.response_e != '') {
                _this.rootpw.next(!!data.rootpw);
                _this.output.next(data.response_e);
                return;
            }
            var message = '';
            if (data.response && data.response.log) {
                message = data.response.log.messages.join("\n");
                // for (let i = 0; i < data.response.log.messages.length; i++) {
                //     message += data.response.log.messages[i];
                // }
            }
            _this.output.next(message);
            _this.rootpw.next(data.rootpw);
        });
    };
    HaComponent.prototype.status = function () {
        var _this = this;
        this.output.next('');
        this.service.ha_status().subscribe(function (data) {
            console.log(data);
            _this.output.next(data.status.log.messages.join("\n"));
        });
    };
    HaComponent.prototype.slaveRefresh = function () {
        var _this = this;
        if (this.server.slaves_ip == '') {
            this.toastr.error('List can not be empty!');
            return;
        }
        var list = this.makeClone(this.server.slaves_ip).split(',').map(Function.prototype.call, String.prototype.trim);
        this.service.ha_slave_list(list).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loading.next(false);
                return;
            }
            if (data.status) {
                _this.toastr.success('List saved');
            }
        });
    };
    HaComponent = __decorate([
        core_1.Component({
            selector: 'kt-ha',
            template: __webpack_require__(/*! ./ha.component.html */ "./src/app/views/pages/gui/settings/ha/ha.component.html"),
            styles: [__webpack_require__(/*! ./ha.component.scss */ "./src/app/views/pages/gui/settings/ha/ha.component.scss")]
        }),
        __metadata("design:paramtypes", [settings_service_1.SettingsService,
            ngx_toastr_1.ToastrService])
    ], HaComponent);
    return HaComponent;
}());
exports.HaComponent = HaComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/settings/logging/logging.component.html":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/logging/logging.component.html ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>API Logging</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group \">\n\t\t\t\t\t\t<div class=\"input-group\">\n              <select class=\"form-control form-control-sm\" [(ngModel)]=\"periods.api\">\n                <option value=\"3 years\">older then 3 years</option>\n                <option value=\"1 year\">older then 1 years</option>\n                <option value=\"6 months\">older then 6 months</option>\n                <option value=\"3 months\">older then 3 months</option>\n                <option value=\"1 month\">older then 1 month</option>\n                <option value=\"all\">ALL LOGS</option>\n  \t\t\t\t\t\t</select>\n\t\t\t\t\t\t\t<div class=\"input-group-append\">\n\t\t\t\t\t\t\t\t<button class=\"btn btn-sm btn-danger\" type=\"button\" (click)=\"del('api')\">Delete</button>\n\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t</div>\n\t\t\t\t\t</div>\n          </div>\n        </div>\n        <hr>\n        <h5>Tacacs Authentication Logging</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group \">\n            <div class=\"input-group\">\n              <select class=\"form-control form-control-sm\" [(ngModel)]=\"periods.authentication\">\n                <option value=\"3 years\">older then 3 years</option>\n                <option value=\"1 year\">older then 1 years</option>\n                <option value=\"6 months\">older then 6 months</option>\n                <option value=\"3 months\">older then 3 months</option>\n                <option value=\"1 month\">older then 1 month</option>\n                <option value=\"all\">ALL LOGS</option>\n              </select>\n              <div class=\"input-group-append\">\n                <button class=\"btn btn-sm btn-danger\" type=\"button\" (click)=\"del('authentication')\">Delete</button>\n              </div>\n            </div>\n          </div>\n          </div>\n        </div>\n        <h5>Tacacs Authorization Logging</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group \">\n            <div class=\"input-group\">\n              <select class=\"form-control form-control-sm\" [(ngModel)]=\"periods.authorization\">\n                <option value=\"3 years\">older then 3 years</option>\n                <option value=\"1 year\">older then 1 years</option>\n                <option value=\"6 months\">older then 6 months</option>\n                <option value=\"3 months\">older then 3 months</option>\n                <option value=\"1 month\">older then 1 month</option>\n                <option value=\"all\">ALL LOGS</option>\n              </select>\n              <div class=\"input-group-append\">\n                <button class=\"btn btn-sm btn-danger\" type=\"button\" (click)=\"del('authorization')\">Delete</button>\n              </div>\n            </div>\n          </div>\n          </div>\n        </div>\n        <h5>Tacacs Accounting Logging</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group \">\n            <div class=\"input-group\">\n              <select class=\"form-control form-control-sm\" [(ngModel)]=\"periods.accounting\">\n                <option value=\"3 years\">older then 3 years</option>\n                <option value=\"1 year\">older then 1 years</option>\n                <option value=\"6 months\">older then 6 months</option>\n                <option value=\"3 months\">older then 3 months</option>\n                <option value=\"1 month\">older then 1 month</option>\n                <option value=\"all\">ALL LOGS</option>\n              </select>\n              <div class=\"input-group-append\">\n                <button class=\"btn btn-sm btn-danger\" type=\"button\" (click)=\"del('accounting')\">Delete</button>\n              </div>\n            </div>\n          </div>\n          </div>\n        </div>\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/logging/logging.component.scss":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/logging/logging.component.scss ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9zZXR0aW5ncy9sb2dnaW5nL2xvZ2dpbmcuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/logging/logging.component.ts":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/logging/logging.component.ts ***!
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Service
var settings_service_1 = __webpack_require__(/*! ../settings.service */ "./src/app/views/pages/gui/settings/settings.service.ts");
var LoggingComponent = /** @class */ (function () {
    function LoggingComponent(service, toastr) {
        this.service = service;
        this.toastr = toastr;
        this.periods = {
            api: "3 years",
            authentication: "3 years",
            authorization: "3 years",
            accounting: "3 years"
        };
        this.api_log_period = "3 years";
        this.authe_log_period = "3 years";
        this.autho_log_period = "3 years";
        this.acc_log_period = "3 years";
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loading = new rxjs_1.BehaviorSubject(false);
    }
    LoggingComponent.prototype.ngOnInit = function () {
        this.init();
    };
    LoggingComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    LoggingComponent.prototype.init = function () {
        // this.service.smtp_get().subscribe( data => {
        //   console.log(data)
        //   this.data = data.smtp
        //   this.data_old = this.makeClone(data.smtp)
        //   this.loading.next(false)
        // })
    };
    LoggingComponent.prototype.del = function (type) {
        var _this = this;
        this.loading.next(true);
        var data = {
            period: this.periods[type],
            target: type
        };
        if (type == 'api')
            delete data.target;
        this.service.del_reports(data, type).subscribe(function (data) {
            console.log(data);
            _this.loading.next(false);
            if (data.error && data.error.status) {
                _this.toastr.error('Unexpected Error!');
                return;
            }
            if (data.result == 0) {
                _this.toastr.warning('Nothing Deleted!');
                return;
            }
            else {
                _this.toastr.warning('Deleted ' + data.result + 'entries');
            }
        });
    };
    LoggingComponent = __decorate([
        core_1.Component({
            selector: 'kt-logging',
            template: __webpack_require__(/*! ./logging.component.html */ "./src/app/views/pages/gui/settings/logging/logging.component.html"),
            styles: [__webpack_require__(/*! ./logging.component.scss */ "./src/app/views/pages/gui/settings/logging/logging.component.scss")]
        }),
        __metadata("design:paramtypes", [settings_service_1.SettingsService,
            ngx_toastr_1.ToastrService])
    ], LoggingComponent);
    return LoggingComponent;
}());
exports.LoggingComponent = LoggingComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/settings/network/network.component.html":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/network/network.component.html ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-3\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Select Interface</label>\n  \t\t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"inter\">\n                <ng-container *ngFor=\"let interf of inter_list;\">\n                  <option value=\"{{interf}}\">{{interf}}</option>\n                </ng-container>\n  \t\t\t\t\t\t</select>\n  \t\t\t\t\t</div>\n          </div>\n\n          <div class=\"col-9\">\n            <div class=\"row\">\n              <div class=\"col-6\">\n                <div class=\"form-group\">\n      \t\t\t\t\t\t<label>IP Address</label>\n      \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                      [ngClass]=\"{ 'is-invalid' : (validation | async)?.network_address }\"\n                      [(ngModel)]=\"data.network_address\" placeholder=\"IP Address\">\n                      <!-- is-invalid -->\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.network_address;\">{{message}}</p>\n                  </div>\n      \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                </div>\n              </div>\n              <div class=\"col-6\">\n                <div class=\"form-group\">\n      \t\t\t\t\t\t<label>Network Mask</label>\n      \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                      [ngClass]=\"{ 'is-invalid' : (validation | async)?.network_mask }\"\n                      [(ngModel)]=\"data.network_mask\" placeholder=\"Network Mask\">\n                      <!-- is-invalid -->\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.network_mask;\">{{message}}</p>\n                  </div>\n      \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                </div>\n              </div>\n              <div class=\"col-6\">\n                <div class=\"form-group\">\n      \t\t\t\t\t\t<label>Gateway</label>\n      \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                      [ngClass]=\"{ 'is-invalid' : (validation | async)?.network_gateway }\"\n                      [(ngModel)]=\"data.network_gateway\" placeholder=\"Gateway\">\n                      <!-- is-invalid -->\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.network_gateway;\">{{message}}</p>\n                  </div>\n      \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                </div>\n              </div>\n            </div>\n            <div class=\"row\">\n              <div class=\"col-6\">\n                <div class=\"form-group\">\n      \t\t\t\t\t\t<label>DNS Server Primary</label>\n      \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                      [ngClass]=\"{ 'is-invalid' : (validation | async)?.network_dns1 }\"\n                      [(ngModel)]=\"data.network_dns1\" placeholder=\"DNS Server Primary\">\n                      <!-- is-invalid -->\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.network_dns1;\">{{message}}</p>\n                  </div>\n      \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                </div>\n              </div>\n              <div class=\"col-6\">\n                <div class=\"form-group\">\n      \t\t\t\t\t\t<label>DNS Server Secondary</label>\n      \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                      [ngClass]=\"{ 'is-invalid' : (validation | async)?.network_dns2 }\"\n                      [(ngModel)]=\"data.network_dns2\" placeholder=\"DNS Server Secondary\">\n                      <!-- is-invalid -->\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.network_dns2;\">{{message}}</p>\n                  </div>\n      \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n                </div>\n              </div>\n            </div>\n  \n            <div class=\"row\">\n              <div class=\"col-6\">\n                <div class=\"form-group\">\n                  <label>IPv6 Address</label>\n                  <input type=\"text\" class=\"form-control form-control-sm\"\n                      [ngClass]=\"{ 'is-invalid' : (validation | async)?.network_address6 }\"\n                      [(ngModel)]=\"data.network_address6\" placeholder=\"IP Address\">\n                      <!-- is-invalid -->\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.network_address6;\">{{message}}</p>\n                  </div>\n                  <span class=\"form-text text-muted\"></span>\n                </div>\n              </div>\n              <div class=\"col-6\">\n                <div class=\"form-group\">\n                  <label>Gateway6</label>\n                  <input type=\"text\" class=\"form-control form-control-sm\"\n                      [ngClass]=\"{ 'is-invalid' : (validation | async)?.network_gateway6 }\"\n                      [(ngModel)]=\"data.network_gateway6\" placeholder=\"Gateway\">\n                      <!-- is-invalid -->\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.network_gateway6;\">{{message}}</p>\n                  </div>\n                  <span class=\"form-text text-muted\"></span>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loading | async) }\"\n      [disabled]=\"(loading | async)\">Save</button>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/network/network.component.scss":
/*!*************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/network/network.component.scss ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9zZXR0aW5ncy9uZXR3b3JrL25ldHdvcmsuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/network/network.component.ts":
/*!***********************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/network/network.component.ts ***!
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Service
var settings_service_1 = __webpack_require__(/*! ../settings.service */ "./src/app/views/pages/gui/settings/settings.service.ts");
var NetworkComponent = /** @class */ (function () {
    function NetworkComponent(service, toastr) {
        this.service = service;
        this.toastr = toastr;
        this.inter_list = [];
        this.inter = '';
        this.data = {
            network_address: "",
            network_dns1: "",
            network_dns2: "",
            network_gateway: "",
            network_mask: "",
        };
        this.data_old = {};
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loading = new rxjs_1.BehaviorSubject(true);
    }
    NetworkComponent.prototype.ngOnInit = function () {
        this.init();
    };
    NetworkComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    NetworkComponent.prototype.init = function () {
        var _this = this;
        this.service.network_get(this.inter).subscribe(function (data) {
            console.log(data);
            _this.inter = data.list[0];
            _this.inter_list = data.list;
            _this.data = data.interface;
            _this.data_old = _this.makeClone(data.interface);
            _this.loading.next(false);
        });
    };
    NetworkComponent.prototype.save = function () {
        var _this = this;
        console.log(this.data);
        this.loading.next(true);
        if (JSON.stringify(this.data) == JSON.stringify(this.data_old)) {
            this.toastr.warning('No Changes Detected!');
            this.loading.next(false);
            return;
        }
        var data = this.makeClone(this.data);
        data.network_interface = this.inter;
        var ipv6 = data.network_address6.split('/');
        data.network_address6 = ipv6[0] || '';
        data.network_prefix6 = ipv6[1] || 64;
        console.log(data);
        this.service.network_post(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loading.next(false);
                return;
            }
            _this.toastr.success('Changes Saved!');
            _this.init();
            _this.loading.next(false);
        });
    };
    NetworkComponent = __decorate([
        core_1.Component({
            selector: 'kt-network',
            template: __webpack_require__(/*! ./network.component.html */ "./src/app/views/pages/gui/settings/network/network.component.html"),
            styles: [__webpack_require__(/*! ./network.component.scss */ "./src/app/views/pages/gui/settings/network/network.component.scss")]
        }),
        __metadata("design:paramtypes", [settings_service_1.SettingsService,
            ngx_toastr_1.ToastrService])
    ], NetworkComponent);
    return NetworkComponent;
}());
exports.NetworkComponent = NetworkComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/settings/notifications/notifications.component.html":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/notifications/notifications.component.html ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <ngb-tabset>\n          <ngb-tab title=\"Settings\">\n            <ng-template ngbTabContent>\n              <h4>Bad Authentication Settings</h4>\n              <div class=\"row\">\n                <div class=\"col-6\">\n                  <div class=\"form-group\">\n                    <label style=\"width: 100%\">Bad Authentication</label>\n                    <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n                      <input type=\"checkbox\" [(ngModel)]=\"data.bad_authentication_enable\"> Enable\n                      <span></span>\n                    </label>\n                    <span class=\"form-text text-muted\"></span>\n                  </div>\n                </div>\n              </div>\n              <div class=\"row\">\n                <div class=\"col-6\">\n                  <div class=\"form-group\">\n                    <label>Bad Authentication count</label>\n                    <div class=\"input-group\">\n                      <input type=\"number\" class=\"form-control form-control-sm\"\n                          [ngClass]=\"{ 'is-invalid' : (validation | async)?.bad_authentication_count }\"\n                          [(ngModel)]=\"data.bad_authentication_count\" placeholder=\"Servers list\">\n                          <!-- is-invalid -->\n                      <div class=\"input-group-append\"\n                      ngbTooltip=\"bad authentications in a minute\">\n                        <span class=\"input-group-text\" id=\"basic-addon1\"><i class=\"fa fa-info\"></i></span>\n                      </div>\n        \t\t\t\t\t\t</div>\n                    <div class=\"invalid-feedback\">\n                      <p *ngFor=\"let message of (validation | async)?.bad_authentication_count;\">{{message}}</p>\n                    </div>\n                    <span class=\"form-text text-muted\"></span>\n                  </div>\n                </div>\n                <div class=\"col-6\">\n                  <div class=\"form-group\">\n                    <label>Interval</label>\n                    <div class=\"input-group\">\n                      <input type=\"number\" class=\"form-control form-control-sm\"\n                          [ngClass]=\"{ 'is-invalid' : (validation | async)?.bad_authentication_interval }\"\n                          [(ngModel)]=\"data.bad_authentication_interval\" placeholder=\"Servers list\">\n                          <!-- is-invalid -->\n                      <div class=\"input-group-append\"\n                      ngbTooltip=\"if a notification is corresponding\n                        to the same ip address, it will be suspended for the time interval (minutes)\">\n                        <span class=\"input-group-text\" id=\"basic-addon1\"><i class=\"fa fa-info\"></i></span>\n                      </div>\n                    </div>\n                    <div class=\"invalid-feedback\">\n                      <p *ngFor=\"let message of (validation | async)?.bad_authentication_interval;\">{{message}}</p>\n                    </div>\n                    <span class=\"form-text text-muted\"></span>\n                  </div>\n                </div>\n              </div>\n\n              <div class=\"row\">\n                <div class=\"col-12\">\n                  <div class=\"form-group\">\n        \t\t\t\t\t\t<label>Additional Email List</label>\n        \t\t\t\t\t\t<textarea rows=\"3\" class=\"form-control\"  [(ngModel)]=\"data.bad_authentication_email_list\"\n                    [ngClass]=\"{ 'is-invalid' : (validation | async)?.bad_authentication_email_list }\"></textarea>\n                    <span class=\"form-text text-muted\">list of email user1@example.com;user2@example.com</span>\n                    <div class=\"invalid-feedback\">\n                      <p *ngFor=\"let message of (validation | async)?.bad_authentication_email_list;\">{{message}}</p>\n                    </div>\n        \t\t\t\t\t</div>\n                </div>\n              </div>\n\n              <hr>\n\n              <h4>Bad Authorization Settings</h4>\n              <div class=\"row\">\n                <div class=\"col-6\">\n                  <div class=\"form-group\">\n                    <label style=\"width: 100%\">Bad Authorization</label>\n                    <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n                      <input type=\"checkbox\" [(ngModel)]=\"data.bad_authorization_enable\"> Enable\n                      <span></span>\n                    </label>\n                    <span class=\"form-text text-muted\"></span>\n                  </div>\n                </div>\n              </div>\n              <div class=\"row\">\n                <div class=\"col-6\">\n                  <div class=\"form-group\">\n                    <label>Bad Authorization count</label>\n                    <div class=\"input-group\">\n                      <input type=\"number\" class=\"form-control form-control-sm\"\n                          [ngClass]=\"{ 'is-invalid' : (validation | async)?.bad_authorization_count }\"\n                          [(ngModel)]=\"data.bad_authorization_count\" placeholder=\"Servers list\">\n                          <!-- is-invalid -->\n                      <div class=\"input-group-append\"\n                      ngbTooltip=\"bad authorization in a minute\">\n                        <span class=\"input-group-text\" id=\"basic-addon1\"><i class=\"fa fa-info\"></i></span>\n                      </div>\n        \t\t\t\t\t\t</div>\n                    <div class=\"invalid-feedback\">\n                      <p *ngFor=\"let message of (validation | async)?.bad_authorization_count;\">{{message}}</p>\n                    </div>\n                    <span class=\"form-text text-muted\"></span>\n                  </div>\n                </div>\n                <div class=\"col-6\">\n                  <div class=\"form-group\">\n                    <label>Interval</label>\n                    <div class=\"input-group\">\n                      <input type=\"number\" class=\"form-control form-control-sm\"\n                          [ngClass]=\"{ 'is-invalid' : (validation | async)?.bad_authorization_interval }\"\n                          [(ngModel)]=\"data.bad_authorization_interval\" placeholder=\"Servers list\">\n                          <!-- is-invalid -->\n                      <div class=\"input-group-append\"\n                      ngbTooltip=\"if a notification is corresponding\n                        to the same ip address, it will be suspended for the time interval (minutes)\">\n                        <span class=\"input-group-text\" id=\"basic-addon1\"><i class=\"fa fa-info\"></i></span>\n                      </div>\n                    </div>\n                    <div class=\"invalid-feedback\">\n                      <p *ngFor=\"let message of (validation | async)?.bad_authorization_interval;\">{{message}}</p>\n                    </div>\n                    <span class=\"form-text text-muted\"></span>\n                  </div>\n                </div>\n              </div>\n\n              <div class=\"row\">\n                <div class=\"col-12\">\n                  <div class=\"form-group\">\n        \t\t\t\t\t\t<label>Additional Email List</label>\n        \t\t\t\t\t\t<textarea rows=\"3\" class=\"form-control\"  [(ngModel)]=\"data.bad_authorization_email_list\"\n                    [ngClass]=\"{ 'is-invalid' : (validation | async)?.bad_authorization_email_list }\"></textarea>\n                    <span class=\"form-text text-muted\">list of email user1@example.com;user2@example.com</span>\n                    <div class=\"invalid-feedback\">\n                      <p *ngFor=\"let message of (validation | async)?.bad_authorization_email_list;\">{{message}}</p>\n                    </div>\n        \t\t\t\t\t</div>\n                </div>\n              </div>\n\n\n            </ng-template>\n          </ngb-tab>\n          <ngb-tab title=\"Log\">\n            <ng-template ngbTabContent>\n              <kt-main-table [options]=\"tableOptions_log\">\n              </kt-main-table>\n            </ng-template>\n          </ngb-tab>\n          <ngb-tab title=\"Buffer\">\n            <ng-template ngbTabContent>\n              <kt-main-table [options]=\"tableOptions_buffer\">\n              </kt-main-table>\n            </ng-template>\n          </ngb-tab>\n        </ngb-tabset>\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loading | async) }\"\n      [disabled]=\"(loading | async)\">Save</button>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/notifications/notifications.component.scss":
/*!*************************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/notifications/notifications.component.scss ***!
  \*************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9zZXR0aW5ncy9ub3RpZmljYXRpb25zL25vdGlmaWNhdGlvbnMuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/notifications/notifications.component.ts":
/*!***********************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/notifications/notifications.component.ts ***!
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
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Service
var settings_service_1 = __webpack_require__(/*! ../settings.service */ "./src/app/views/pages/gui/settings/settings.service.ts");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var NotificationsComponent = /** @class */ (function () {
    function NotificationsComponent(service, toastr) {
        this.service = service;
        this.toastr = toastr;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loading = new rxjs_1.BehaviorSubject(true);
        this.data = {
            bad_authentication_count: 0,
            bad_authentication_email_list: '',
            bad_authentication_enable: 0,
            bad_authentication_interval: 0,
            bad_authorization_count: 0,
            bad_authorization_email_list: '',
            bad_authorization_enable: 0,
            bad_authorization_interval: 0,
        };
        this.data_old = {};
        this.tableOptions_log = {
            table: {
                delBtn: false,
                editBtn: false,
                selectable: false,
                preview: false,
                pagination: {
                    enable: true,
                    perpageItems: [30, 50, 100],
                    total: false
                },
                mainUrl: '/notification/post/logging/',
                sort: {
                    column: 'date',
                    direction: 'desc'
                },
                editable: false,
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    date: { title: 'Date', show: true, sortable: true },
                    device_ipaddr: { title: 'NAS', show: true, sortable: true },
                    user_ipaddr: { title: 'NAC', show: true, sortable: true },
                    username: { title: 'Username', show: true, sortable: true },
                    type: { title: 'Type', show: true, sortable: true },
                    status: { title: 'Status', show: true, sortable: true },
                    server: { title: 'Server', show: false, sortable: false },
                    receivers: { title: 'Emails', show: true, sortable: false },
                },
            },
            buttons: {
                moreColumns: {
                    enable: true
                },
                filter: false
            }
        };
        this.tableOptions_buffer = {
            table: {
                delBtn: false,
                editBtn: false,
                selectable: false,
                preview: false,
                pagination: false,
                mainUrl: '/notification/post/buffer/',
                sort: {
                    column: 'date',
                    direction: 'desc'
                },
                editable: false,
                columns: {
                    id: { title: 'ID', show: false, sortable: true },
                    date: { title: 'Date', show: true, sortable: true },
                    device_ipaddr: { title: 'NAS', show: true, sortable: true },
                    user_ipaddr: { title: 'NAC', show: true, sortable: true },
                    username: { title: 'Username', show: true, sortable: true },
                    type: { title: 'Type', show: true, sortable: true },
                    count: { title: 'Count', show: true, sortable: true },
                    server: { title: 'Server', show: false, sortable: false },
                },
            },
            buttons: {
                moreColumns: {
                    enable: true
                },
                filter: false
            }
        };
    }
    NotificationsComponent.prototype.ngOnInit = function () {
        this.init();
    };
    NotificationsComponent.prototype.init = function () {
        var _this = this;
        this.service.notification_get().subscribe(function (data) {
            console.log(data);
            _this.data = data.settings;
            _this.data_old = _this.makeClone(data.settings);
            _this.loading.next(false);
        });
    };
    NotificationsComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    NotificationsComponent.prototype.save = function () {
        var _this = this;
        if (JSON.stringify(this.data) == JSON.stringify(this.data_old)) {
            this.toastr.warning('No Changes Detected!');
            return;
        }
        this.loading.next(true);
        var data = this.makeClone(this.data);
        data.bad_authentication_email_list = data.bad_authentication_email_list.split(';').map(Function.prototype.call, String.prototype.trim);
        data.bad_authorization_email_list = data.bad_authorization_email_list.split(';').map(Function.prototype.call, String.prototype.trim);
        data.bad_authentication_enable += 0;
        data.bad_authorization_enable += 0;
        this.service.notification_post(data).subscribe(function (data) {
            _this.loading.next(false);
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loading.next(false);
                return;
            }
            _this.init();
            _this.toastr.success('Settings Saved');
        });
    };
    NotificationsComponent = __decorate([
        core_1.Component({
            selector: 'kt-notifications',
            template: __webpack_require__(/*! ./notifications.component.html */ "./src/app/views/pages/gui/settings/notifications/notifications.component.html"),
            styles: [__webpack_require__(/*! ./notifications.component.scss */ "./src/app/views/pages/gui/settings/notifications/notifications.component.scss")]
        }),
        __metadata("design:paramtypes", [settings_service_1.SettingsService,
            ngx_toastr_1.ToastrService])
    ], NotificationsComponent);
    return NotificationsComponent;
}());
exports.NotificationsComponent = NotificationsComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.html":
/*!*******************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.html ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>Password Policy For API Users</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Minimal Password Length</label>\n  \t\t\t\t\t\t<input type=\"number\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.api_pw_length }\"\n                  [(ngModel)]=\"data.api_pw_length\" placeholder=\"Minimal Password Length\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.api_pw_length;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"data.api_pw_uppercase\"> Upper-case letters\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">must contain [A-Z]</span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"data.api_pw_lowercase\"> Lower-case letters\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">must contain [a-z]</span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"data.api_pw_numbers\"> Numbers\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">must contain [0-9]</span>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"data.api_pw_special\"> Special Characters\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">{{'must contain (~!@#$%^&*_-+=`|(){}[]:;><,.?/)'}}</span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"data.api_pw_same\"> The same password check\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">can't set the same password</span>\n            </div>\n          </div>\n        </div>\n\n        <h5>Password Policy For Tacacs Users and Devices</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Minimal Password Length</label>\n  \t\t\t\t\t\t<input type=\"number\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.tac_pw_length }\"\n                  [(ngModel)]=\"data.tac_pw_length\" placeholder=\"Minimal Password Length\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.tac_pw_length;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"+data.tac_pw_uppercase\"> Upper-case letters\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">must contain [A-Z]</span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"+data.tac_pw_lowercase\"> Lower-case letters\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">must contain [a-z]</span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"+data.tac_pw_numbers\"> Numbers\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">must contain [0-9]</span>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"+data.tac_pw_special\"> Special Characters\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">{{'must contain (~!@#$%^&*_-+=`|(){}[]:;><,.?/)'}}</span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"+data.tac_pw_same\"> The same password check\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">can't set the same password</span>\n            </div>\n          </div>\n        </div>\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loading | async) }\"\n      [disabled]=\"(loading | async)\">Save</button>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.scss":
/*!*******************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.scss ***!
  \*******************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9zZXR0aW5ncy9wYXNzcG9saWN5L3Bhc3Nwb2xpY3kuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.ts":
/*!*****************************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.ts ***!
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Service
var settings_service_1 = __webpack_require__(/*! ../settings.service */ "./src/app/views/pages/gui/settings/settings.service.ts");
var PasspolicyComponent = /** @class */ (function () {
    function PasspolicyComponent(service, toastr) {
        this.service = service;
        this.toastr = toastr;
        this.data = {
            api_pw_length: 6,
            api_pw_lowercase: 0,
            api_pw_numbers: 0,
            api_pw_same: 0,
            api_pw_special: 0,
            api_pw_uppercase: 0,
            tac_pw_length: 6,
            tac_pw_lowercase: 0,
            tac_pw_numbers: 0,
            tac_pw_same: 0,
            tac_pw_special: 0,
            tac_pw_uppercase: 0
        };
        this.data_old = {};
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loading = new rxjs_1.BehaviorSubject(true);
    }
    PasspolicyComponent.prototype.ngOnInit = function () {
        this.init();
    };
    PasspolicyComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    PasspolicyComponent.prototype.init = function () {
        var _this = this;
        this.service.passpolicy_get().subscribe(function (data) {
            console.log(data);
            _this.data = data.policy;
            _this.data_old = _this.makeClone(data.policy);
            _this.loading.next(false);
        });
    };
    PasspolicyComponent.prototype.save = function () {
        var _this = this;
        console.log(this.data);
        this.loading.next(false);
        if (JSON.stringify(this.data) == JSON.stringify(this.data_old)) {
            this.toastr.warning('No Changes Detected!');
            this.loading.next(false);
            return;
        }
        var data = this.makeClone(this.data);
        console.log(data);
        data.api_pw_lowercase += 0;
        data.api_pw_numbers += 0;
        data.api_pw_same += 0;
        data.api_pw_special += 0;
        data.api_pw_uppercase += 0;
        data.tac_pw_lowercase += 0;
        data.tac_pw_numbers += 0;
        data.tac_pw_same += 0;
        data.tac_pw_special += 0;
        data.tac_pw_uppercase += 0;
        this.service.passpolicy_post(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loading.next(false);
                return;
            }
            _this.toastr.success('Changes Saved!');
            _this.init();
            _this.loading.next(false);
        });
    };
    PasspolicyComponent = __decorate([
        core_1.Component({
            selector: 'kt-passpolicy',
            template: __webpack_require__(/*! ./passpolicy.component.html */ "./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.html"),
            styles: [__webpack_require__(/*! ./passpolicy.component.scss */ "./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.scss")]
        }),
        __metadata("design:paramtypes", [settings_service_1.SettingsService,
            ngx_toastr_1.ToastrService])
    ], PasspolicyComponent);
    return PasspolicyComponent;
}());
exports.PasspolicyComponent = PasspolicyComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/settings/settings.module.ts":
/*!*************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/settings.module.ts ***!
  \*************************************************************/
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
var ngx_clipboard_1 = __webpack_require__(/*! ngx-clipboard */ "./node_modules/ngx-clipboard/fesm5/ngx-clipboard.js");
var portlet_module_1 = __webpack_require__(/*! ../../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
var clock_module_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_fields/clock/clock.module */ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.module.ts");
var pages_module_1 = __webpack_require__(/*! ../../pages.module */ "./src/app/views/pages/pages.module.ts");
var time_component_1 = __webpack_require__(/*! ./time/time.component */ "./src/app/views/pages/gui/settings/time/time.component.ts");
var ha_component_1 = __webpack_require__(/*! ./ha/ha.component */ "./src/app/views/pages/gui/settings/ha/ha.component.ts");
var network_component_1 = __webpack_require__(/*! ./network/network.component */ "./src/app/views/pages/gui/settings/network/network.component.ts");
var logging_component_1 = __webpack_require__(/*! ./logging/logging.component */ "./src/app/views/pages/gui/settings/logging/logging.component.ts");
var smtp_component_1 = __webpack_require__(/*! ./smtp/smtp.component */ "./src/app/views/pages/gui/settings/smtp/smtp.component.ts");
var passpolicy_component_1 = __webpack_require__(/*! ./passpolicy/passpolicy.component */ "./src/app/views/pages/gui/settings/passpolicy/passpolicy.component.ts");
var notifications_component_1 = __webpack_require__(/*! ./notifications/notifications.component */ "./src/app/views/pages/gui/settings/notifications/notifications.component.ts");
var SettingsModule = /** @class */ (function () {
    function SettingsModule() {
    }
    SettingsModule = __decorate([
        core_1.NgModule({
            declarations: [
                time_component_1.TimeComponent,
                ha_component_1.HaComponent,
                network_component_1.NetworkComponent,
                logging_component_1.LoggingComponent,
                smtp_component_1.SmtpComponent,
                passpolicy_component_1.PasspolicyComponent,
                notifications_component_1.NotificationsComponent
            ],
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                ng_bootstrap_1.NgbModule,
                clock_module_1.ClockModule,
                portlet_module_1.PortletModule,
                ngx_clipboard_1.ClipboardModule,
                pages_module_1.PagesModule,
                router_1.RouterModule.forChild([
                    {
                        path: 'time',
                        component: time_component_1.TimeComponent
                    },
                    {
                        path: 'ha',
                        component: ha_component_1.HaComponent
                    },
                    {
                        path: 'network',
                        component: network_component_1.NetworkComponent
                    },
                    {
                        path: 'logging',
                        component: logging_component_1.LoggingComponent
                    },
                    {
                        path: 'smtp',
                        component: smtp_component_1.SmtpComponent
                    },
                    {
                        path: 'passpolicy',
                        component: passpolicy_component_1.PasspolicyComponent
                    },
                    {
                        path: 'notifications',
                        component: notifications_component_1.NotificationsComponent
                    },
                ]),
            ],
        })
    ], SettingsModule);
    return SettingsModule;
}());
exports.SettingsModule = SettingsModule;


/***/ }),

/***/ "./src/app/views/pages/gui/settings/settings.service.ts":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/settings.service.ts ***!
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
var API_URL = 'api/settings/';
var SettingsService = /** @class */ (function () {
    function SettingsService(http) {
        this.http = http;
    }
    SettingsService.prototype.time_get = function () {
        return this.http.get(API_URL + 'time/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.time_status = function () {
        return this.http.get(API_URL + 'time/status/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.time_post = function (settings) {
        return this.http.post(API_URL + 'time/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.passpolicy_get = function () {
        return this.http.get(API_URL + 'pwpolicy/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.passpolicy_post = function (settings) {
        return this.http.post(API_URL + 'pwpolicy/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.network_get = function (inter) {
        var params = new http_1.HttpParams()
            .set('interface', inter);
        return this.http.get(API_URL + 'network/interface/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.network_list = function (ip) {
        if (ip === void 0) { ip = 1; }
        var params = new http_1.HttpParams()
            .set('ip', ip.toString());
        return this.http.get(API_URL + 'network/interface/list/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.network_post = function (settings) {
        return this.http.post(API_URL + 'network/interface/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.smtp_get = function () {
        return this.http.get(API_URL + 'smtp/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.smtp_test = function (smtp_test_email) {
        return this.http.post(API_URL + 'smtp/test/', { smtp_test_email: smtp_test_email })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.smtp_post = function (settings) {
        return this.http.post(API_URL + 'smtp/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.del_reports = function (settings, urlType) {
        if (urlType === void 0) { urlType = 'api'; }
        var url = (urlType == 'api') ? 'api/logging/delete/' : 'api/tacacs/reports/delete/';
        return this.http.post(url, settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.ha_get = function () {
        return this.http.get(API_URL + 'ha/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.ha_post = function (settings) {
        return this.http.post(API_URL + 'ha/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.ha_status = function () {
        return this.http.post(API_URL + 'ha/status/', {})
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.ha_slave_list = function (slaves_ip) {
        return this.http.post(API_URL + 'ha/slave/list/', { slaves_ip: slaves_ip })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.notification_get = function () {
        return this.http.get('api/notification/settings/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService.prototype.notification_post = function (settings) {
        return this.http.post('api/notification/settings/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SettingsService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], SettingsService);
    return SettingsService;
}());
exports.SettingsService = SettingsService;


/***/ }),

/***/ "./src/app/views/pages/gui/settings/smtp/smtp.component.html":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/smtp/smtp.component.html ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>SMTP Servers list</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.smtp_servers }\"\n                  [(ngModel)]=\"data.smtp_servers\" placeholder=\"Servers list\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.smtp_servers;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\">specify main and backup SMTP servers, e.g. <i>smtp1.example.com;smtp2.example.com</i></span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label style=\"width: 100%\">SMTP authentication</label>\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"data.smtp_auth\"> Enable\n\t\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t\t</label>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>SMTP Server Port</label>\n  \t\t\t\t\t\t<input type=\"number\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.smtp_port }\"\n                  [(ngModel)]=\"data.smtp_port\" placeholder=\"Port\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.smtp_port;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n    \t\t\t\t\t\t<label style=\"width: 100%\">SMTP Secure</label>\n    \t\t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"data.smtp_secure\">\n                  <option value=\"\">None</option>\n                  <option value=\"ssl\">SSL</option>\n                  <option value=\"tls\">TLS</option>\n    \t\t\t\t\t\t</select>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n\n        <div class=\"row\" *ngIf=\"data.smtp_auth\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>SMTP Username</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.smtp_username }\"\n                  [(ngModel)]=\"data.smtp_username\" placeholder=\"SMTP Username\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.smtp_username;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label style=\"width: 100%\">SMTP Password</label>\n              <input type=\"password\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.smtp_password }\"\n                  [(ngModel)]=\"data.smtp_password\" placeholder=\"SMTP Password\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.smtp_password;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>From (Sender Address)</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.smtp_from }\"\n                  [(ngModel)]=\"data.smtp_from\" placeholder=\"From (Sender Address)\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.smtp_from;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n          <div class=\"card\">\n              <div class=\"card-header\">\n                  <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedMS }\" data-toggle=\"collapse\" (click)=\"notCollapsedMS = !notCollapsedMS\"\n                          [attr.aria-expanded]=\"!notCollapsedMS\">Advanced Settings</div>\n              </div>\n              <div [ngbCollapse]=\"!notCollapsedMS\">\n                  <div class=\"card-body\">\n                    <div class=\"row\">\n                      <div class=\"col-6\">\n                        <div class=\"form-group\">\n              \t\t\t\t\t\t<label style=\"width: 100%\">TLS Auto</label>\n                          <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n            \t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"data.smtp_autotls\"> Enable\n            \t\t\t\t\t\t\t\t<span></span>\n            \t\t\t\t\t\t\t</label>\n              \t\t\t\t\t\t<span class=\"form-text text-muted\">by default disabled</span>\n                        </div>\n                      </div>\n                    </div>\n                  </div>\n              </div>\n          </div>\n        </div>\n\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loading | async) }\"\n      [disabled]=\"(loading | async)\">Save</button>&nbsp;\n  </div>\n</div>\n\n<br>\n<br>\n<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Send test message</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>Test Email</label>\n  \t\t\t\t\t\t<input type=\"text\" class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.smtp_test_email }\"\n                  [(ngModel)]=\"smtp_test_email\" placeholder=\"Email Address\">\n                  <!-- is-invalid -->\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.smtp_test_email;\">{{message}}</p>\n              </div>\n  \t\t\t\t\t\t<span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <button class=\"btn btn-warning btn-elevate btn-sm\"\n          (click)=\"send()\"\n          [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loading_check | async) }\"\n          [disabled]=\"(loading_check | async)\">Send</button>&nbsp;\n          <hr>\n          <pre>{{send_status}}</pre>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/smtp/smtp.component.scss":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/smtp/smtp.component.scss ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9zZXR0aW5ncy9zbXRwL3NtdHAuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/smtp/smtp.component.ts":
/*!*****************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/smtp/smtp.component.ts ***!
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Service
var settings_service_1 = __webpack_require__(/*! ../settings.service */ "./src/app/views/pages/gui/settings/settings.service.ts");
var SmtpComponent = /** @class */ (function () {
    function SmtpComponent(service, toastr) {
        this.service = service;
        this.toastr = toastr;
        this.data = {
            smtp_auth: 1,
            smtp_autotls: 0,
            smtp_from: "",
            smtp_password: "",
            smtp_port: 25,
            smtp_secure: "",
            smtp_servers: "",
            smtp_username: "",
        };
        this.data_old = {
            smtp_password: ''
        };
        this.smtp_test_email = '';
        this.send_status = '';
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loading = new rxjs_1.BehaviorSubject(true);
    }
    SmtpComponent.prototype.ngOnInit = function () {
        this.init();
    };
    SmtpComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    SmtpComponent.prototype.init = function () {
        var _this = this;
        this.service.smtp_get().subscribe(function (data) {
            console.log(data);
            _this.data = data.smtp;
            _this.data_old = _this.makeClone(data.smtp);
            _this.loading.next(false);
        });
    };
    SmtpComponent.prototype.save = function () {
        var _this = this;
        console.log(this.data);
        this.loading.next(true);
        if (JSON.stringify(this.data) == JSON.stringify(this.data_old)) {
            this.toastr.warning('No Changes Detected!');
            this.loading.next(false);
            return;
        }
        var data = this.makeClone(this.data);
        data.smtp_auth += 0;
        data.smtp_autotls += 0;
        if (data.smtp_password == this.data_old.smtp_password)
            delete data.smtp_password;
        console.log(data);
        this.service.smtp_post(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loading.next(false);
                return;
            }
            _this.toastr.success('Changes Saved!');
            _this.init();
            _this.loading.next(false);
        });
    };
    SmtpComponent.prototype.send = function () {
        var _this = this;
        this.service.smtp_test(this.smtp_test_email).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loading.next(false);
                return;
            }
            _this.send_status = data.result;
        });
    };
    SmtpComponent = __decorate([
        core_1.Component({
            selector: 'kt-smtp',
            template: __webpack_require__(/*! ./smtp.component.html */ "./src/app/views/pages/gui/settings/smtp/smtp.component.html"),
            styles: [__webpack_require__(/*! ./smtp.component.scss */ "./src/app/views/pages/gui/settings/smtp/smtp.component.scss")]
        }),
        __metadata("design:paramtypes", [settings_service_1.SettingsService,
            ngx_toastr_1.ToastrService])
    ], SmtpComponent);
    return SmtpComponent;
}());
exports.SmtpComponent = SmtpComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/settings/time/time.component.html":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/time/time.component.html ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <kt-portlet [class]=\"(loading | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h5>General Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"data.timezone\"\n                [params]=\"list.timezones\"\n                [errors]=\"(validation | async)?.timezone\"\n                (returnData)=\"setTimezone($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.timezone }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <label style=\"width: 100%\">Current Time</label>\n              <kt-clock></kt-clock>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <div class=\"form-group\">\n  \t\t\t\t\t\t<label>NTP Server list</label>\n  \t\t\t\t\t\t<textarea class=\"form-control\" [(ngModel)]=\"data.ntp_list\" rows=\"3\"></textarea>\n              <span class=\"form-text text-muted\">semicolon (;) separated list</span>\n  \t\t\t\t\t</div>\n          </div>\n        </div>\n\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loading | async) }\"\n      [disabled]=\"(loading | async)\">Save</button>&nbsp;\n  </div>\n</div>\n<br>\n<br>\n<div class=\"row\">\n  <div class=\"col-md-9 col-lg-9\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">NTP Status check</h5>\n        <pre>{{check_status}}</pre>\n        <button class=\"btn btn-warning btn-elevate btn-sm\"\n          (click)=\"check()\"\n          [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loading_check | async) }\"\n          [disabled]=\"(loading_check | async)\">Check</button>&nbsp;\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/time/time.component.scss":
/*!*******************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/time/time.component.scss ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9zZXR0aW5ncy90aW1lL3RpbWUuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/settings/time/time.component.ts":
/*!*****************************************************************!*\
  !*** ./src/app/views/pages/gui/settings/time/time.component.ts ***!
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Service
var settings_service_1 = __webpack_require__(/*! ../settings.service */ "./src/app/views/pages/gui/settings/settings.service.ts");
var TimeComponent = /** @class */ (function () {
    function TimeComponent(service, toastr) {
        this.service = service;
        this.toastr = toastr;
        this.list = {
            timezones: {
                multiple: false,
                title: 'Timezone',
                title_sidebar: 'Timezones List',
                search: true,
                apiurl: 'api/settings/time/timezones/',
            }
        };
        this.data = {
            timezone: [],
            ntp_list: ''
        };
        this.data_old = {
            timezone: [],
            ntp_list: ''
        };
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loading = new rxjs_1.BehaviorSubject(true);
        this.loading_check = new rxjs_1.BehaviorSubject(false);
        this.check_status = '';
    }
    TimeComponent.prototype.ngOnInit = function () {
        this.init();
    };
    TimeComponent.prototype.init = function () {
        var _this = this;
        this.service.time_get().subscribe(function (data) {
            // console.log(data)
            _this.data = data.time;
            _this.data_old = _this.makeClone(data.time);
            _this.loading.next(false);
        });
    };
    TimeComponent.prototype.setTimezone = function (data) {
        this.data.timezone = data;
    };
    TimeComponent.prototype.makeClone = function (src) {
        return JSON.parse(JSON.stringify(src));
    };
    TimeComponent.prototype.save = function () {
        var _this = this;
        console.log(this.data);
        this.loading.next(false);
        if (JSON.stringify(this.data) == JSON.stringify(this.data_old)) {
            this.toastr.warning('No Changes Detected!');
            this.loading.next(false);
            return;
        }
        var data = this.makeClone(this.data);
        data.timezone = (data.timezone[0]) ? data.timezone[0].id : 0;
        console.log(data);
        this.service.time_post(data).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                _this.loading.next(false);
                return;
            }
            _this.toastr.success('Changes Saved!');
            _this.init();
            _this.loading.next(false);
        });
    };
    TimeComponent.prototype.check = function () {
        var _this = this;
        this.loading_check.next(true);
        this.service.time_status().subscribe(function (data) {
            _this.check_status = data.output;
            _this.loading_check.next(false);
        });
    };
    TimeComponent = __decorate([
        core_1.Component({
            selector: 'kt-time',
            template: __webpack_require__(/*! ./time.component.html */ "./src/app/views/pages/gui/settings/time/time.component.html"),
            styles: [__webpack_require__(/*! ./time.component.scss */ "./src/app/views/pages/gui/settings/time/time.component.scss")]
        }),
        __metadata("design:paramtypes", [settings_service_1.SettingsService,
            ngx_toastr_1.ToastrService])
    ], TimeComponent);
    return TimeComponent;
}());
exports.TimeComponent = TimeComponent;


/***/ })

}]);
//# sourceMappingURL=settings-settings-module.4ca89327668e7b467503.js.map