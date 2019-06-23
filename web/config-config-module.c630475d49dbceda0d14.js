(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["config-config-module"],{

/***/ "./src/app/views/pages/tacacs/config/apply/apply.component.html":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/apply/apply.component.html ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-12\">\n    <kt-portlet>\n      <kt-portlet-body>\n        <div class=\"row\">\n          <div class=\"col-3 text-center\">\n            <button class=\"btn btn-success btn-taller\n            {{(loading_ | async) ? 'kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light' : ''}}\"\n            (click)=\"test()\" style=\"min-width: 100px;\" [disabled]=\"(loading_ | async)\">\n              <i class=\"fa fa-cogs\"></i> Test\n            </button>\n            <br>\n            <br>\n            <button class=\"btn btn-warning btn-taller\n            {{(loading_ | async) ? 'kt-spinner kt-spinner--right kt-spinner--lg kt-spinner--light' : ''}}\"\n            (click)=\"apply()\" style=\"min-width: 100px;\" [disabled]=\"(loading_ | async)\">\n              <i class=\"fa fa-save\"></i> Apply\n            </button>\n            <br>\n            <br>\n            <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"backup\"> Make backup after applying\n\t\t\t\t\t\t\t<span></span>\n\t\t\t\t\t\t</label>\n          </div>\n          <div class=\"col-9\">\n            <div class=\"kt-timeline-v2\">\n      \t\t\t\t<div class=\"kt-timeline-v2__items  kt-padding-top-25 kt-padding-bottom-30\">\n      \t\t\t\t\t<div class=\"kt-timeline-v2__item\">\n      \t\t\t\t\t\t<div class=\"kt-timeline-v2__item-cricle\">\n      \t\t\t\t\t\t\t<i class=\"fa fa-genderless kt-font-success\">\n                    </i>\n      \t\t\t\t\t\t</div>\n      \t\t\t\t\t\t<div class=\"kt-timeline-v2__item-text  kt-padding-top-5\">No Changes Detected</div>\n      \t\t\t\t\t</div>\n      \t\t\t\t\t<div class=\"kt-timeline-v2__item\">\n      \t\t\t\t\t\t<div class=\"kt-timeline-v2__item-cricle\">\n      \t\t\t\t\t\t\t<i class=\"fa fa-genderless\"\n                      [ngClass]=\"{ 'kt-font-success' : (ts | async) == 's', 'kt-font-danger' : (ts | async) == 'e', 'kt-font-default' : (ts | async) == '' }\">\n                    </i>\n      \t\t\t\t\t\t</div>\n      \t\t\t\t\t\t<div class=\"kt-timeline-v2__item-text  kt-padding-top-5\">\n                    <h4>Test Configuration</h4>\n      \t\t\t\t\t\t\t{{test_result | async}}\n      \t\t\t\t\t\t</div>\n      \t\t\t\t\t</div>\n                <div class=\"kt-timeline-v2__item\">\n      \t\t\t\t\t\t<div class=\"kt-timeline-v2__item-cricle\">\n      \t\t\t\t\t\t\t<i class=\"fa fa-genderless\"\n                      [ngClass]=\"{ 'kt-font-success' : (aps | async) == 's', 'kt-font-danger' : (aps | async) == 'e', 'kt-font-default' : (aps | async) == '' }\">\n                    </i>\n      \t\t\t\t\t\t</div>\n      \t\t\t\t\t\t<div class=\"kt-timeline-v2__item-text  kt-padding-top-5\">\n                    <h4>Apply Configuration</h4>\n      \t\t\t\t\t\t\t{{apply_result | async}}\n                    <div class=\"table-responsive\" *ngIf=\"slaveList.length\">\n                      <h6>Slave List</h6>\n                      <table class=\"table\">\n                        <thead>\n                          <tr>\n                            <th>ID</th>\n                            <th>IP</th>\n                            <th>API</th>\n                            <th>DB Check</th>\n                          </tr>\n                        </thead>\n                        <tbody>\n                          <ng-container *ngFor=\"let slave of slaveList\">\n                            <tr>\n                              <td>{{ slave.slave_id }}</td>\n                              <td>{{ slave.ipaddr }}</td>\n                              <td>{{ ((slave.slave_stat | async).api_check) ? 'Ok' : 'Bad' }}</td>\n                              <td>{{ ((slave.slave_stat | async).db_check) ? 'Ok' : 'Bad' }}</td>\n                            </tr>\n                            <tr>\n                              <td colspan=\"4\">\n                                {{((slave.slave_stat | async).applyStatus) ? (slave.slave_stat | async).applyStatus.message : 'Bad'}}\n                              </td>\n                            </tr>\n                          </ng-container>\n\n                        </tbody>\n                      </table>\n                    </div>\n      \t\t\t\t\t\t</div>\n      \t\t\t\t\t</div>\n                <div class=\"kt-timeline-v2__item\">\n      \t\t\t\t\t\t<div class=\"kt-timeline-v2__item-cricle\">\n      \t\t\t\t\t\t\t<i class=\"fa fa-genderless\"></i>\n      \t\t\t\t\t\t</div>\n      \t\t\t\t\t\t<div class=\"kt-timeline-v2__item-text  kt-padding-top-5\"></div>\n      \t\t\t\t\t</div>\n      \t\t\t  </div>\n            </div>\n          </div>\n        </div>\n      </kt-portlet-body>\n    </kt-portlet>\n  </div>\n</div>\n\n<pre class=\"tac_config\"><div *ngFor=\"let line of (_fullConfig | async);\" class=\"line\" [innerHTML]=\"line | safe: 'html'\"></div></pre>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/config/apply/apply.component.scss":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/apply/apply.component.scss ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".tac_config {\n  background-color: #1e1e2d;\n  color: #fff;\n  counter-reset: line;\n  padding: 0px;\n  border: 0px;\n  border-radius: 0px; }\n\n.tac_config div.line:nth-child(odd) {\n  background-color: #1a1a27; }\n\n.tac_config > div.line {\n  counter-increment: line; }\n\n.tac_config > div.line::before {\n  content: counter(line);\n  min-width: 33px;\n  text-align: center;\n  padding-left: 5px;\n  margin-right: 7px;\n  border-right: 1px solid;\n  display: inline-table; }\n\nspan.tac-comment {\n  color: #9093ac; }\n\nspan.tac-attr {\n  color: #ffb822; }\n\nspan.tac-param {\n  color: #0abb87; }\n\nspan.tac-object {\n  color: #fd397a; }\n\nspan.tac-val {\n  color: #5d78ff; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYWdlcy90YWNhY3MvY29uZmlnL2FwcGx5L2FwcGx5LmNvbXBvbmVudC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBQ0UseUJBQXlCO0VBQ3pCLFdBQVc7RUFFWCxtQkFBbUI7RUFDbkIsWUFBWTtFQUNaLFdBQVc7RUFDWCxrQkFBa0IsRUFBQTs7QUFHcEI7RUFDRSx5QkFBeUIsRUFBQTs7QUFHM0I7RUFDRSx1QkFBdUIsRUFBQTs7QUFHekI7RUFDRSxzQkFBc0I7RUFDdEIsZUFBZTtFQUNmLGtCQUFrQjtFQUNsQixpQkFBaUI7RUFDakIsaUJBQWlCO0VBQ2pCLHVCQUF1QjtFQUN2QixxQkFBcUIsRUFBQTs7QUFHdkI7RUFDRSxjQUFjLEVBQUE7O0FBRWhCO0VBQ0UsY0FBYyxFQUFBOztBQUVoQjtFQUNFLGNBQWMsRUFBQTs7QUFFaEI7RUFDRSxjQUFjLEVBQUE7O0FBRWhCO0VBQ0UsY0FBYyxFQUFBIiwiZmlsZSI6InNyYy9hcHAvdmlld3MvcGFnZXMvdGFjYWNzL2NvbmZpZy9hcHBseS9hcHBseS5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIi50YWNfY29uZmlnIHtcclxuICBiYWNrZ3JvdW5kLWNvbG9yOiAjMWUxZTJkO1xyXG4gIGNvbG9yOiAjZmZmO1xyXG4gIC8vIHBhZGRpbmc6IDE1cHg7XHJcbiAgY291bnRlci1yZXNldDogbGluZTtcclxuICBwYWRkaW5nOiAwcHg7XHJcbiAgYm9yZGVyOiAwcHg7XHJcbiAgYm9yZGVyLXJhZGl1czogMHB4O1xyXG59XHJcblxyXG4udGFjX2NvbmZpZyBkaXYubGluZTpudGgtY2hpbGQob2RkKSB7XHJcbiAgYmFja2dyb3VuZC1jb2xvcjogIzFhMWEyNztcclxufVxyXG5cclxuLnRhY19jb25maWcgPiBkaXYubGluZSB7XHJcbiAgY291bnRlci1pbmNyZW1lbnQ6IGxpbmU7XHJcbn1cclxuXHJcbi50YWNfY29uZmlnID4gZGl2LmxpbmU6OmJlZm9yZSB7XHJcbiAgY29udGVudDogY291bnRlcihsaW5lKTtcclxuICBtaW4td2lkdGg6IDMzcHg7XHJcbiAgdGV4dC1hbGlnbjogY2VudGVyO1xyXG4gIHBhZGRpbmctbGVmdDogNXB4O1xyXG4gIG1hcmdpbi1yaWdodDogN3B4O1xyXG4gIGJvcmRlci1yaWdodDogMXB4IHNvbGlkO1xyXG4gIGRpc3BsYXk6IGlubGluZS10YWJsZTtcclxufVxyXG5cclxuc3Bhbi50YWMtY29tbWVudCB7XHJcbiAgY29sb3I6ICM5MDkzYWM7XHJcbn1cclxuc3Bhbi50YWMtYXR0ciB7XHJcbiAgY29sb3I6ICNmZmI4MjI7XHJcbn1cclxuc3Bhbi50YWMtcGFyYW0ge1xyXG4gIGNvbG9yOiAjMGFiYjg3O1xyXG59XHJcbnNwYW4udGFjLW9iamVjdCB7XHJcbiAgY29sb3I6ICNmZDM5N2E7XHJcbn1cclxuc3Bhbi50YWMtdmFsIHtcclxuICBjb2xvcjogIzVkNzhmZjtcclxufVxyXG4iXX0= */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/config/apply/apply.component.ts":
/*!********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/apply/apply.component.ts ***!
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
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
var apply_service_1 = __webpack_require__(/*! ./apply.service */ "./src/app/views/pages/tacacs/config/apply/apply.service.ts");
var ApplyComponent = /** @class */ (function () {
    function ApplyComponent(service) {
        this.service = service;
        this.ts = new rxjs_1.BehaviorSubject('');
        this.aps = new rxjs_1.BehaviorSubject('');
        this.test_result = new rxjs_1.BehaviorSubject('');
        this.apply_result = new rxjs_1.BehaviorSubject('');
        this.loading_ = new rxjs_1.BehaviorSubject(false);
        this._fullConfig = new rxjs_1.BehaviorSubject([]);
        this.backup = true;
        this.slaveList = [];
        this.slaveStats = {};
    }
    ApplyComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.service.get().subscribe(function (data) {
            console.log(data);
            _this._fullConfig.next([].concat(data.spawnd, data.tac_general, data.tac_mavis, data.tac_acl, data.tac_devGrps, data.tac_devices, data.tac_usrGrps, data.tac_users, ['}##END GLOBAL CONFIGURATION']));
        });
    };
    ApplyComponent.prototype.test = function () {
        var _this = this;
        this.loading_.next(true);
        this.clearStatus();
        this.service.test_c().subscribe(function (data) {
            _this.testReturn(data.confTest);
            _this.loading_.next(false);
        });
    };
    ApplyComponent.prototype.testReturn = function (result) {
        if (result.error) {
            this.ts.next('e');
        }
        else
            this.ts.next('s');
        this.test_result.next(result.message);
    };
    ApplyComponent.prototype.apply = function () {
        var _this = this;
        this.clearStatus();
        this.loading_.next(true);
        this.service.test_c().subscribe(function (data) {
            _this.testReturn(data.confTest);
            if (!data.confTest.error) {
                _this.service.apply_c(_this.backup).subscribe(function (data) {
                    _this.loading_.next(false);
                    console.log(data);
                    _this.applyReturn(data.applyStatus);
                    // console.log(data.server_list)
                    if (data.applyStatus.error)
                        return;
                    if (data.hasOwnProperty('server_list') && data.server_list.hasOwnProperty('slave')) {
                        var slaves = [];
                        for (var key in data.server_list.slave) {
                            data.server_list.slave[key].slave_id = key;
                            data.server_list.slave[key].slave_stat = new rxjs_1.BehaviorSubject({});
                            slaves[slaves.length] = data.server_list.slave[key];
                        }
                        _this.slaveList = slaves;
                        if (slaves.length > 0)
                            _this.applySlaves();
                        console.log(slaves);
                    }
                });
                // this.applyReturn()
            }
            else {
                _this.loading_.next(false);
            }
        });
    };
    ApplyComponent.prototype.applySlaves = function () {
        var _this = this;
        var _loop_1 = function (i) {
            this_1.service.apply_slave({ sid: this_1.slaveList[i].slave_id }).subscribe(function (data) {
                console.log(data);
                if (data.server_response && data.server_response.hasOwnProperty('sid')) {
                    //console.log(this.slaveList, i, this.slaveList[i] )
                    _this.slaveList[i].slave_stat.next(data.server_response.responce);
                }
            });
        };
        var this_1 = this;
        for (var i = 0; i < this.slaveList.length; i++) {
            _loop_1(i);
        }
        console.log(this.slaveStats);
    };
    ApplyComponent.prototype.applyReturn = function (result) {
        if (result.error) {
            this.aps.next('e');
        }
        else
            this.aps.next('s');
        this.apply_result.next(result.message);
    };
    ApplyComponent.prototype.clearStatus = function () {
        this.ts.next('');
        this.aps.next('');
        this.test_result.next('Loading...');
        this.apply_result.next('');
        this.slaveList = [];
    };
    ApplyComponent = __decorate([
        core_1.Component({
            selector: 'kt-apply',
            template: __webpack_require__(/*! ./apply.component.html */ "./src/app/views/pages/tacacs/config/apply/apply.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./apply.component.scss */ "./src/app/views/pages/tacacs/config/apply/apply.component.scss")]
        }),
        __metadata("design:paramtypes", [apply_service_1.ApplyService])
    ], ApplyComponent);
    return ApplyComponent;
}());
exports.ApplyComponent = ApplyComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/config/apply/apply.service.ts":
/*!******************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/apply/apply.service.ts ***!
  \******************************************************************/
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
var API_URL = 'api/tacacs/config/apply/';
var ApplyService = /** @class */ (function () {
    function ApplyService(http) {
        this.http = http;
    }
    ApplyService.prototype.get = function () {
        var params = new http_1.HttpParams().set('html', 'true');
        return this.http.get('api/tacacs/config/generate/', { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ApplyService.prototype.test_c = function () {
        var params = new http_1.HttpParams().set('contentType', 'json').set('confTest', 'on');
        return this.http.get(API_URL, { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ApplyService.prototype.apply_c = function (backup) {
        if (backup === void 0) { backup = false; }
        // contentType: json
        // confTest: on
        // confSave: yes
        // doBackup: false
        var params = new http_1.HttpParams().set('contentType', 'json').set('confTest', 'on')
            .set('confSave', 'yes').set('doBackup', (backup) ? '1' : '0');
        return this.http.get(API_URL, { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ApplyService.prototype.apply_slave = function (data) {
        // contentType: json
        // confTest: on
        // confSave: yes
        // doBackup: false
        return this.http.post(API_URL + 'slave/', data)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ApplyService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], ApplyService);
    return ApplyService;
}());
exports.ApplyService = ApplyService;


/***/ }),

/***/ "./src/app/views/pages/tacacs/config/config.module.ts":
/*!************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/config.module.ts ***!
  \************************************************************/
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
var forms_1 = __webpack_require__(/*! @angular/forms */ "./node_modules/@angular/forms/fesm5/forms.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
var pages_module_1 = __webpack_require__(/*! ../../pages.module */ "./src/app/views/pages/pages.module.ts");
var portlet_module_1 = __webpack_require__(/*! ../../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
var safe_pipe_1 = __webpack_require__(/*! ../../../partials/layout/tacgui/_pipes/safe.pipe */ "./src/app/views/partials/layout/tacgui/_pipes/safe.pipe.ts");
//Components
var apply_component_1 = __webpack_require__(/*! ./apply/apply.component */ "./src/app/views/pages/tacacs/config/apply/apply.component.ts");
var global_component_1 = __webpack_require__(/*! ./global/global.component */ "./src/app/views/pages/tacacs/config/global/global.component.ts");
var ConfigModule = /** @class */ (function () {
    function ConfigModule() {
    }
    ConfigModule = __decorate([
        core_1.NgModule({
            declarations: [
                apply_component_1.ApplyComponent,
                global_component_1.GlobalComponent,
                safe_pipe_1.SafePipe,
            ],
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                ng_bootstrap_1.NgbModule,
                pages_module_1.PagesModule,
                portlet_module_1.PortletModule,
                router_1.RouterModule.forChild([
                    {
                        path: 'global',
                        component: global_component_1.GlobalComponent
                    },
                    {
                        path: 'apply',
                        component: apply_component_1.ApplyComponent
                    },
                ]),
            ]
        })
    ], ConfigModule);
    return ConfigModule;
}());
exports.ConfigModule = ConfigModule;


/***/ }),

/***/ "./src/app/views/pages/tacacs/config/global/global.component.html":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/global/global.component.html ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet>\n      <kt-portlet-body>\n        <h4>Start/Stop/Reload Tacacs Daemon</h4>\n        <br>\n        <div class=\"row\">\n          <div class=\"col-8\">\n            <div class=\"btn-group btn-group-sm\" role=\"group\" aria-label=\"...\">\n                <button type=\"button\"\n                  (click)=\"start()\"\n                  class=\"btn btn-outline-info\" ngbPopover=\"Start\"\n                  triggers=\"mouseenter:mouseleave\">\n                  <i class=\"fa fa-play\"></i>\n                </button>\n                <button type=\"button\"\n                  (click)=\"stop()\"\n                  class=\"btn btn-outline-info\" ngbPopover=\"Stop\"\n                  triggers=\"mouseenter:mouseleave\">\n                  <i class=\"fa fa-stop\"></i>\n                </button>\n                <button type=\"button\"\n                  (click)=\"reload()\"\n                  class=\"btn btn-outline-info\"ngbPopover=\"Restart\"\n                  triggers=\"mouseenter:mouseleave\">\n                  <i class=\"fa fa-redo-alt\"></i>\n                </button>\n                <button type=\"button\"\n                  (click)=\"info()\"\n                  class=\"btn btn-outline-info\" ngbPopover=\"Info\"\n                  triggers=\"mouseenter:mouseleave\">\n                  <i class=\"fa fa-info\"></i>\n                </button>\n            </div>\n          </div>\n        </div>\n        <br>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <label>Current Status</label>\n            <input class=\"form-control form-control-sm\" type=\"text\" [value]=\"(tacacsStatusMessage | async )\" disabled>\n          </div>\n        </div>\n      </kt-portlet-body>\n    </kt-portlet>\n  </div>\n</div>\n<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loadingForm | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <h4>Global Settings</h4>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <div class=\"form-group row\">\n  \t\t\t\t\t\t<label class=\"col-2 col-form-label\">Listening Port</label>\n  \t\t\t\t\t\t<div class=\"col-3\">\n  \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"number\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.port }\"\n                  [(ngModel)]=\"params.port\">\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.port;\">{{message}}</p>\n                </div>\n                <span class=\"form-text text-muted\"></span>\n  \t\t\t\t\t\t</div>\n  \t\t\t\t\t</div>\n          </div>\n        </div>\n          <h4>Authentication</h4>\n          <div class=\"row\">\n\n            <div class=\"col-4\">\n              <div class=\"form-group\">\n    \t\t\t\t\t\t<label>Authentication Max Attempt</label>\n                <div class=\"input-group\">\n                  <input class=\"form-control form-control-sm\" type=\"number\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.max_attempts }\"\n                  [(ngModel)]=\"params.max_attempts\">\n                  <div class=\"input-group-append\">\n    \t\t\t\t\t\t\t\t<button class=\"btn btn-default btn-sm btn-icon\"\n                      ngbPopover=\"that parameter limits the number of Password: prompts per TACACS+ session at login, default: 1\"\n                      triggers=\"mouseenter:mouseleave\">\n                      <i class=\"fa fa-info\"></i>\n                    </button>\n    \t\t\t\t\t\t\t</div>\n                </div>\n\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.max_attempts;\">{{message}}</p>\n                </div>\n                <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t</div>\n            </div>\n            <div class=\"col-4\">\n              <div class=\"form-group\">\n    \t\t\t\t\t\t<label>Backoff Timer</label>\n                <div class=\"input-group\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"number\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.backoff }\"\n                  [(ngModel)]=\"params.backoff\">\n                  <div class=\"input-group-append\">\n                    <button class=\"btn btn-default btn-sm btn-icon\"\n                      ngbPopover=\"tacacs will wait for seconds before returning a final authentication failure (password incorrect) message, default: 1 second\"\n                      triggers=\"mouseenter:mouseleave\">\n                      <i class=\"fa fa-info\"></i>\n                    </button>\n                  </div>\n                </div>\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.backoff;\">{{message}}</p>\n                </div>\n                <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t</div>\n            </div>\n            <div class=\"col-4\">\n              <div class=\"form-group\">\n    \t\t\t\t\t\t<label>Separation Tag</label>\n                <div class=\"input-group\">\n                  <select class=\"form-control form-control-sm\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.separation_tag }\" [(ngModel)]=\"params.separation_tag\">\n      \t\t\t\t\t\t\t<option value=\"*\">*</option>\n      \t\t\t\t\t\t\t<option value=\"@\">@</option>\n      \t\t\t\t\t\t\t<option value=\"/\">/</option>\n      \t\t\t\t\t\t\t<option value=\"%\">%</option>\n      \t\t\t\t\t\t\t<option value=\"$\">$</option>\n      \t\t\t\t\t\t\t<option value=\"=\">=</option>\n      \t\t\t\t\t\t</select>\n    \t\t\t\t\t\t\t<!-- <input class=\"form-control form-control-sm\" type=\"text\"\n                  [ngClass]=\"{ 'is-invalid' : (validation | async)?.separation_tag }\"\n                  [(ngModel)]=\"params.separation_tag\"> -->\n                  <div class=\"input-group-append\">\n                    <button class=\"btn btn-default btn-sm btn-icon\"\n                      ngbPopover=\"separation tag used to separate users and groups, by default *\"\n                      triggers=\"mouseenter:mouseleave\">\n                      <i class=\"fa fa-info\"></i>\n                    </button>\n                  </div>\n                </div>\n                <div class=\"invalid-feedback\">\n                  <p *ngFor=\"let message of (validation | async)?.separation_tag;\">{{message}}</p>\n                </div>\n                <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n        <h4>Miscellaneous</h4>\n        <div class=\"row\">\n          <div class=\"col-5\">\n            <div class=\"form-group\">\n              <label style=\"width:100%\">Skip conflicting groups</label>\n              <span class=\"kt-switch kt-switch--outline kt-switch--success\">\n  \t\t\t\t\t\t\t<label>\n  \t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"params.skip_conflicting_groups\">\n  \t\t\t\t\t\t\t\t<span></span>\n  \t\t\t\t\t\t\t</label>\n  \t\t\t\t\t\t</span>\n            </div>\n          </div>\n          <div class=\"col-5\">\n            <div class=\"form-group\">\n              <label style=\"width:100%\">Skip missing groups</label>\n              <span class=\"kt-switch kt-switch--outline kt-switch--success\">\n  \t\t\t\t\t\t\t<label>\n  \t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"params.skip_missing_groups\">\n  \t\t\t\t\t\t\t\t<span></span>\n  \t\t\t\t\t\t\t</label>\n  \t\t\t\t\t\t</span>\n            </div>\n          </div>\n        </div>\n        <h4>Limits and Timeouts</h4>\n        <div class=\"row\">\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label>Connection Timeout</label>\n              <div class=\"input-group\">\n                <input class=\"form-control form-control-sm\" type=\"number\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.connection_timeout }\"\n                [(ngModel)]=\"params.connection_timeout\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-default btn-sm btn-icon\"\n                    ngbPopover=\"terminate a connection to a NAS after an idle period of at least s seconds, default: 600 seconds\"\n                    triggers=\"mouseenter:mouseleave\">\n                    <i class=\"fa fa-info\"></i>\n                  </button>\n                </div>\n              </div>\n\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.connection_timeout;\">{{message}}</p>\n              </div>\n              <span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label>Context Timeout</label>\n              <div class=\"input-group\">\n                <input class=\"form-control form-control-sm\" type=\"number\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.context_timeout }\"\n                [(ngModel)]=\"params.context_timeout\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-default btn-sm btn-icon\"\n                    ngbPopover=\"clears context cache entries after s seconds of inactivity, default: 3600 seconds\"\n                    triggers=\"mouseenter:mouseleave\">\n                    <i class=\"fa fa-info\"></i>\n                  </button>\n                </div>\n              </div>\n\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.context_timeout;\">{{message}}</p>\n              </div>\n              <span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <h4>Syslog Settings</h4>\n        <div class=\"row\">\n          <div class=\"col-5\">\n            <div class=\"form-group\">\n              <label>Syslog server</label>\n              <div class=\"input-group\">\n                <input class=\"form-control form-control-sm\" type=\"text\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.syslog_ip }\"\n                [(ngModel)]=\"params.syslog_ip\">\n\n              </div>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.syslog_ip;\">{{message}}</p>\n              </div>\n              <span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label>Port</label>\n              <div class=\"input-group\">\n                <input class=\"form-control form-control-sm\" type=\"text\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.syslog_port }\"\n                [(ngModel)]=\"params.syslog_port\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-default btn-sm btn-icon\"\n                    ngbPopover=\"udp port of syslog server, default 514\"\n                    triggers=\"mouseenter:mouseleave\">\n                    <i class=\"fa fa-info\"></i>\n                  </button>\n                </div>\n              </div>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.syslog_port;\">{{message}}</p>\n              </div>\n              <span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n        <h4>Reports Settings</h4>\n        <span class=\"text-danger\">be careful with those settings! it influences on log parser script!</span>\n        <div class=\"row\">\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label>Authentication</label>\n              <div class=\"input-group\">\n                <input class=\"form-control form-control-sm\" type=\"text\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.authentication }\"\n                [(ngModel)]=\"params.authentication\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-default btn-sm btn-icon\"\n                    ngbPopover=\"here you can set path to file on the server, command or syslog server ip and port, by default it used for Log Parser script\"\n                    triggers=\"mouseenter:mouseleave\">\n                    <i class=\"fa fa-info\"></i>\n                  </button>\n                </div>\n              </div>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.authentication;\">{{message}}</p>\n              </div>\n              <span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label>Authorization</label>\n              <div class=\"input-group\">\n                <input class=\"form-control form-control-sm\" type=\"text\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.authorization }\"\n                [(ngModel)]=\"params.authorization\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-default btn-sm btn-icon\"\n                    ngbPopover=\"here you can set path to file on the server, command or syslog server ip and port, by default it used for Log Parser script\"\n                    triggers=\"mouseenter:mouseleave\">\n                    <i class=\"fa fa-info\"></i>\n                  </button>\n                </div>\n              </div>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.authorization;\">{{message}}</p>\n              </div>\n              <span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n          <div class=\"col-4\">\n            <div class=\"form-group\">\n              <label>Accounting</label>\n              <div class=\"input-group\">\n                <input class=\"form-control form-control-sm\" type=\"text\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.accounting }\"\n                [(ngModel)]=\"params.accounting\">\n                <div class=\"input-group-append\">\n                  <button class=\"btn btn-default btn-sm btn-icon\"\n                    ngbPopover=\"here you can set path to file on the server, command or syslog server ip and port, by default it used for Log Parser script\"\n                    triggers=\"mouseenter:mouseleave\">\n                    <i class=\"fa fa-info\"></i>\n                  </button>\n                </div>\n              </div>\n              <div class=\"invalid-feedback\">\n                <p *ngFor=\"let message of (validation | async)?.accounting;\">{{message}}</p>\n              </div>\n              <span class=\"form-text text-muted\"></span>\n            </div>\n          </div>\n        </div>\n\n        <h4>Manual Configuration\n          <small>\n            <i class=\"fa fa-info\"\n            ngbPopover=\"that configuration will be added to the top of global configuration, after port listening settings\"\n            triggers=\"mouseenter:mouseleave\">\n            </i>\n          </small>\n        </h4>\n        <span class=\"text-danger\">be careful with those settings! by default it influences on log parser script!</span>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <div class=\"form-group manual\">\n\t\t\t\t\t\t<textarea rows=\"9\" class=\"form-control form-control-sm\" [(ngModel)]=\"params.manual\" placeholder=\"Manual configuration\"></textarea>\n\t\t\t\t\t</div>\n          </div>\n        </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-warning btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Save</button>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/tacacs/config/global/global.component.scss":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/global/global.component.scss ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL3RhY2Fjcy9jb25maWcvZ2xvYmFsL2dsb2JhbC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/tacacs/config/global/global.component.ts":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/global/global.component.ts ***!
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
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var global_service_1 = __webpack_require__(/*! ./global.service */ "./src/app/views/pages/tacacs/config/global/global.service.ts");
var GlobalTacacs = {
    port: 49,
    max_attempts: 1,
    backoff: 1,
    separation_tag: "*",
    skip_conflicting_groups: 1,
    skip_missing_groups: 1,
};
var GlobalComponent = /** @class */ (function () {
    function GlobalComponent(toastr, t_service) {
        this.toastr = toastr;
        this.t_service = t_service;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.tacacsStatusMessage = new rxjs_1.BehaviorSubject('');
        this.params = GlobalTacacs;
        this.params_old = '';
    }
    GlobalComponent.prototype.ngOnInit = function () {
        this.init();
    };
    GlobalComponent.prototype.init = function () {
        var _this = this;
        this.t_service.get().subscribe(function (data) {
            _this.params = data;
            _this.params_old = JSON.stringify(data);
            _this.loadingForm.next(false);
        });
        this.info();
    };
    GlobalComponent.prototype.save = function () {
        var _this = this;
        this.loadingForm.next(true);
        if (this.params_old == JSON.stringify(this.params)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        this.t_service.save(this.params).subscribe(function (data) {
            if (data.tglobal_update) {
                _this.toastr.success('Settings Saved');
                _this.init();
                return;
            }
            _this.toastr.error('Unexpcted Error');
            _this.init();
            return;
        });
    };
    //daemon
    GlobalComponent.prototype.start = function () {
        var _this = this;
        this.tacacsStatusMessage.next('Loading...');
        this.t_service.start().subscribe(function (data) {
            // this.tacacsStatusMessage.next(data.tacacsStatusMessage)
            _this.info();
        });
    };
    GlobalComponent.prototype.stop = function () {
        var _this = this;
        this.tacacsStatusMessage.next('Loading...');
        this.t_service.stop().subscribe(function (data) {
            // this.tacacsStatusMessage.next(data.tacacsStatusMessage)
            _this.info();
        });
    };
    GlobalComponent.prototype.reload = function () {
        var _this = this;
        this.tacacsStatusMessage.next('Loading...');
        this.t_service.reload().subscribe(function (data) {
            // this.tacacsStatusMessage.next(data.tacacsStatusMessage)
            _this.info();
        });
    };
    GlobalComponent.prototype.info = function () {
        var _this = this;
        this.tacacsStatusMessage.next('Loading...');
        this.t_service.info().subscribe(function (data) {
            _this.tacacsStatusMessage.next(data.tacacsStatusMessage);
        });
    };
    GlobalComponent = __decorate([
        core_1.Component({
            selector: 'kt-global',
            template: __webpack_require__(/*! ./global.component.html */ "./src/app/views/pages/tacacs/config/global/global.component.html"),
            styles: [__webpack_require__(/*! ./global.component.scss */ "./src/app/views/pages/tacacs/config/global/global.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            global_service_1.GlobalService])
    ], GlobalComponent);
    return GlobalComponent;
}());
exports.GlobalComponent = GlobalComponent;


/***/ }),

/***/ "./src/app/views/pages/tacacs/config/global/global.service.ts":
/*!********************************************************************!*\
  !*** ./src/app/views/pages/tacacs/config/global/global.service.ts ***!
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
var http_1 = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var API_URL = 'api/tacacs/config/global/edit/';
var API_URL_DAEMON = 'api/tacacs/config/daemon/';
var GlobalService = /** @class */ (function () {
    function GlobalService(http) {
        this.http = http;
    }
    GlobalService.prototype.get = function () {
        return this.http.get(API_URL)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.global_variables;
        }));
    };
    GlobalService.prototype.save = function (data) {
        return this.http.post(API_URL, data)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    GlobalService.prototype.info = function () {
        return this.http.post(API_URL_DAEMON, {})
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    GlobalService.prototype.start = function () {
        return this.http.post(API_URL_DAEMON, { action: 'start' })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    GlobalService.prototype.stop = function () {
        return this.http.post(API_URL_DAEMON, { action: 'stop' })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    GlobalService.prototype.reload = function () {
        return this.http.post(API_URL_DAEMON, { action: 'reload' })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    GlobalService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], GlobalService);
    return GlobalService;
}());
exports.GlobalService = GlobalService;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_pipes/safe.pipe.ts":
/*!******************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_pipes/safe.pipe.ts ***!
  \******************************************************************/
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
var platform_browser_1 = __webpack_require__(/*! @angular/platform-browser */ "./node_modules/@angular/platform-browser/fesm5/platform-browser.js");
var SafePipe = /** @class */ (function () {
    function SafePipe(sanitizer) {
        this.sanitizer = sanitizer;
    }
    SafePipe.prototype.transform = function (value, type) {
        switch (type) {
            case 'html':
                {
                    return this.sanitizer.bypassSecurityTrustHtml(value);
                }
                ;
            case 'style': return this.sanitizer.bypassSecurityTrustStyle(value);
            case 'script': return this.sanitizer.bypassSecurityTrustScript(value);
            case 'url': return this.sanitizer.bypassSecurityTrustUrl(value);
            case 'resourceUrl': return this.sanitizer.bypassSecurityTrustResourceUrl(value);
            default: throw new Error("Invalid safe type specified: " + type);
        }
    };
    SafePipe = __decorate([
        core_1.Pipe({
            name: 'safe'
        }),
        __metadata("design:paramtypes", [platform_browser_1.DomSanitizer])
    ], SafePipe);
    return SafePipe;
}());
exports.SafePipe = SafePipe;


/***/ })

}]);
//# sourceMappingURL=config-config-module.c630475d49dbceda0d14.js.map