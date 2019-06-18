(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app-views-pages-dashboard-dashboard-module"],{

/***/ "./src/app/views/pages/dashboard/dashboard.component.html":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/dashboard/dashboard.component.html ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<kt-w-system-info></kt-w-system-info>\r\n<br>\r\n<kt-w-auth-linechart></kt-w-auth-linechart>\r\n<br>\r\n<kt-w-auth-piechart></kt-w-auth-piechart>\r\n"

/***/ }),

/***/ "./src/app/views/pages/dashboard/dashboard.component.scss":
/*!****************************************************************!*\
  !*** ./src/app/views/pages/dashboard/dashboard.component.scss ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ":host ::ng-deep ngb-tabset > .nav-tabs {\n  display: none; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYWdlcy9kYXNoYm9hcmQvZGFzaGJvYXJkLmNvbXBvbmVudC5zY3NzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0VBR0csYUFBYSxFQUFBIiwiZmlsZSI6InNyYy9hcHAvdmlld3MvcGFnZXMvZGFzaGJvYXJkL2Rhc2hib2FyZC5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIjpob3N0IHtcclxuXHQ6Om5nLWRlZXAge1xyXG5cdFx0bmdiLXRhYnNldCA+IC5uYXYtdGFicyB7XHJcblx0XHRcdGRpc3BsYXk6IG5vbmU7XHJcblx0XHR9XHJcblx0fVxyXG59XHJcbiJdfQ== */"

/***/ }),

/***/ "./src/app/views/pages/dashboard/dashboard.component.ts":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/dashboard/dashboard.component.ts ***!
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
// Angular
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
//Router
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
// Lodash
// import { shuffle } from 'lodash';
// RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
// import { takeUntil } from 'rxjs/operators';
// Services
var layout_1 = __webpack_require__(/*! ../../../core/_base/layout */ "./src/app/core/_base/layout/index.ts");
// import { UpgradeService } from '../upgrade/upgrade.service'
var super_data_service_1 = __webpack_require__(/*! ../../../core/tacgui/super-data.service */ "./src/app/core/tacgui/super-data.service.ts");
// Widgets model
var DashboardComponent = /** @class */ (function () {
    function DashboardComponent(layoutConfigService, router, 
    // private upg: UpgradeService,
    super_) {
        this.layoutConfigService = layoutConfigService;
        this.router = router;
        this.super_ = super_;
        this.destroy$ = new rxjs_1.Subject();
        // upg._search().subscribe(data => {
        // 	if (data.messages && data.messages.length){
        // 		router.navigateByUrl('/upgrade');
        // 	}
        // })
    }
    DashboardComponent.prototype.ngOnInit = function () {
        this.super_.cfgChange.subscribe(function (data) { console.log(data); });
    };
    DashboardComponent.prototype.ngOnDestroy = function () {
        this.destroy$.next();
        this.destroy$.complete();
    };
    DashboardComponent = __decorate([
        core_1.Component({
            selector: 'kt-dashboard',
            template: __webpack_require__(/*! ./dashboard.component.html */ "./src/app/views/pages/dashboard/dashboard.component.html"),
            styles: [__webpack_require__(/*! ./dashboard.component.scss */ "./src/app/views/pages/dashboard/dashboard.component.scss")]
        }),
        __metadata("design:paramtypes", [layout_1.LayoutConfigService,
            router_1.Router,
            super_data_service_1.SuperDataService])
    ], DashboardComponent);
    return DashboardComponent;
}());
exports.DashboardComponent = DashboardComponent;


/***/ }),

/***/ "./src/app/views/pages/dashboard/dashboard.module.ts":
/*!***********************************************************!*\
  !*** ./src/app/views/pages/dashboard/dashboard.module.ts ***!
  \***********************************************************/
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
// Angular
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
// NgBootstrap
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
// Core Module
var core_module_1 = __webpack_require__(/*! ../../../core/core.module */ "./src/app/core/core.module.ts");
var partials_module_1 = __webpack_require__(/*! ../../partials/partials.module */ "./src/app/views/partials/partials.module.ts");
var widgets_module_1 = __webpack_require__(/*! ../../partials/layout/tacgui/_widgets/widgets.module */ "./src/app/views/partials/layout/tacgui/_widgets/widgets.module.ts");
var dashboard_component_1 = __webpack_require__(/*! ./dashboard.component */ "./src/app/views/pages/dashboard/dashboard.component.ts");
var DashboardModule = /** @class */ (function () {
    function DashboardModule() {
    }
    DashboardModule = __decorate([
        core_1.NgModule({
            imports: [
                common_1.CommonModule,
                partials_module_1.PartialsModule,
                core_module_1.CoreModule,
                ng_bootstrap_1.NgbModule,
                widgets_module_1.WidgetsModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: dashboard_component_1.DashboardComponent
                    },
                ]),
            ],
            providers: [],
            declarations: [
                dashboard_component_1.DashboardComponent,
            ]
        })
    ], DashboardModule);
    return DashboardModule;
}());
exports.DashboardModule = DashboardModule;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/line-chart-widget.service.ts":
/*!*****************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/line-chart-widget.service.ts ***!
  \*****************************************************************************************************/
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
var API_URL = 'api/tacacs/widget/chart/auth/';
var LineChartWidget = /** @class */ (function () {
    function LineChartWidget(http) {
        this.http = http;
    }
    LineChartWidget.prototype.get = function () {
        return this.http.get(API_URL, {})
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    LineChartWidget = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], LineChartWidget);
    return LineChartWidget;
}());
exports.LineChartWidget = LineChartWidget;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.html":
/*!********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.html ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-lg-4 col-md-12\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Authentication Stats</h5>\n        <h6 class=\"card-subtitle mb-2 text-muted\">authentication per week</h6>\n        <canvas baseChart\n                [datasets]=\"barChartData_authe\"\n                [labels]=\"labels | async\"\n                [options]=\"barChartOptions_authe\"\n                [legend]=\"barChartLegend\"\n                [chartType]=\"barChartType\">\n        </canvas>\n      </div>\n    </div>\n  </div>\n  <div class=\"col-lg-4 col-md-12\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Authorization Stats</h5>\n        <h6 class=\"card-subtitle mb-2 text-muted\">authorization per week</h6>\n        <canvas baseChart\n                [datasets]=\"barChartData_autho\"\n                [labels]=\"labels | async\"\n                [options]=\"barChartOptions_autho\"\n                [legend]=\"barChartLegend\"\n                [chartType]=\"barChartType\">\n        </canvas>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.scss":
/*!********************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.scss ***!
  \********************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX3dpZGdldHMvdy1hdXRoLWxpbmVjaGFydC93LWF1dGgtbGluZWNoYXJ0LmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.ts":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.ts ***!
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Service
var line_chart_widget_service_1 = __webpack_require__(/*! ./line-chart-widget.service */ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/line-chart-widget.service.ts");
var WAuthLinechartComponent = /** @class */ (function () {
    function WAuthLinechartComponent(service) {
        this.service = service;
        this.barChartOptions_authe = {
            scaleShowVerticalLines: false,
            responsive: true,
            scales: {
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Authentication'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            },
                        }
                    }]
            } //scales
        };
        this.barChartOptions_autho = {
            scaleShowVerticalLines: false,
            responsive: true,
            scales: {
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Authorization'
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function (label, index, labels) {
                                if (Math.floor(label) === label) {
                                    return label;
                                }
                            },
                        }
                    }]
            } //scales
        };
        this.barChartLabels = [];
        this.labels = new rxjs_1.BehaviorSubject([]);
        this.barChartType = 'line';
        this.barChartLegend = true;
        this.barChartData_authe = [
            { data: [], label: 'Fail', fill: false },
            { data: [], label: 'Success', fill: false }
        ];
        this.barChartData_autho = [
            { data: [], label: 'Fail', fill: false },
            { data: [], label: 'Success', fill: false }
        ];
    }
    WAuthLinechartComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.service.get().subscribe(function (data) {
            // console.log(data)
            _this.barChartData_authe[0].data = data.authe.chart.f;
            _this.barChartData_authe[1].data = data.authe.chart.s;
            _this.barChartData_autho[0].data = data.autho.chart.f;
            _this.barChartData_autho[1].data = data.autho.chart.s;
            // console.log(data.authe.chart.f)
            _this.labels.next(data.time_range);
        });
    };
    WAuthLinechartComponent = __decorate([
        core_1.Component({
            selector: 'kt-w-auth-linechart',
            template: __webpack_require__(/*! ./w-auth-linechart.component.html */ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.html"),
            styles: [__webpack_require__(/*! ./w-auth-linechart.component.scss */ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.scss")]
        }),
        __metadata("design:paramtypes", [line_chart_widget_service_1.LineChartWidget])
    ], WAuthLinechartComponent);
    return WAuthLinechartComponent;
}());
exports.WAuthLinechartComponent = WAuthLinechartComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/pie-widget.service.ts":
/*!*********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/pie-widget.service.ts ***!
  \*********************************************************************************************/
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
var API_URL = 'api/tacacs/reports/top/access/';
var PieWidget = /** @class */ (function () {
    function PieWidget(http) {
        this.http = http;
    }
    PieWidget.prototype.get = function (data) {
        var params = new http_1.HttpParams()
            .set('users', data.users.toString())
            .set('devices', data.devices.toString())
            .set('usersReload', data.usersReload.toString())
            .set('devicesReload', data.devicesReload.toString());
        return this.http.get(API_URL, { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    PieWidget = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], PieWidget);
    return PieWidget;
}());
exports.PieWidget = PieWidget;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.html":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.html ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-lg-4 col-md-12\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Top 5 Active Users</h5>\n        <h6 class=\"card-subtitle mb-2 text-muted\">number of authentication per week</h6>\n        <canvas baseChart #topUsers\n                [datasets]=\"barChartData\"\n                [labels]=\"user_labels | async\"\n                [options]=\"barChartOptions\"\n                [legend]=\"barChartLegend\"\n                [chartType]=\"barChartType\">\n        </canvas>\n      </div>\n    </div>\n  </div>\n  <div class=\"col-lg-4 col-md-12\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Top 5 Used Devices</h5>\n        <h6 class=\"card-subtitle mb-2 text-muted\">number of authentication per week</h6>\n        <canvas baseChart #topDevices\n                [datasets]=\"barChartData_devices\"\n                [labels]=\"device_labels | async\"\n                [options]=\"barChartOptions\"\n                [legend]=\"barChartLegend\"\n                [chartType]=\"barChartType\">\n        </canvas>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.scss":
/*!******************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.scss ***!
  \******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX3dpZGdldHMvdy1hdXRoLXBpZWNoYXJ0L3ctYXV0aC1waWVjaGFydC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.ts":
/*!****************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.ts ***!
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
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Service
var pie_widget_service_1 = __webpack_require__(/*! ./pie-widget.service */ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/pie-widget.service.ts");
var WAuthPiechartComponent = /** @class */ (function () {
    function WAuthPiechartComponent(service) {
        this.service = service;
        this.chartColors = [
            'rgb(255, 99, 132)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(201, 203, 207)',
            'rgb(54, 162, 235)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
        ];
        this.barChartLabels_devices = [];
        this.barChartLabels = [];
        this.device_labels = new rxjs_1.BehaviorSubject(this.barChartLabels_devices);
        this.user_labels = new rxjs_1.BehaviorSubject(this.barChartLabels);
        this.barChartOptions = {
            scaleShowVerticalLines: false,
            responsive: true
        };
        this.barChartType = 'pie';
        this.barChartLegend = true;
        this.barChartData = [
            { data: [], label: 'Users', backgroundColor: this.chartColors }
        ];
        this.barChartData_devices = [
            { data: [], label: 'Devices', backgroundColor: this.chartColors }
        ];
        this.set = {
            users: 5,
            devices: 5,
            usersReload: 1,
            devicesReload: 1
        };
    }
    WAuthPiechartComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.service.get(this.set).subscribe(function (data) {
            _this.barChartLabels = [];
            _this.barChartData[0].data = [];
            _this.barChartLabels_devices = [];
            _this.barChartData_devices[0].data = [];
            for (var i = 0; i < data.topUsers.length; i++) {
                _this.barChartLabels.push(data.topUsers[i].label);
                _this.barChartData[0].data.push(data.topUsers[i].count);
            }
            for (var i = 0; i < data.topDevices.length; i++) {
                _this.barChartLabels_devices.push(data.topDevices[i].label);
                _this.barChartData_devices[0].data.push(data.topDevices[i].count);
            }
            _this.device_labels.next(_this.barChartLabels_devices);
            _this.user_labels.next(_this.barChartLabels);
            // console.log(Color)
            // this.chart_devices.update();
            // console.log(this.barChartLabels_devices)
            // console.log(this.barChartData_devices)
        });
    };
    WAuthPiechartComponent = __decorate([
        core_1.Component({
            selector: 'kt-w-auth-piechart',
            template: __webpack_require__(/*! ./w-auth-piechart.component.html */ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.html"),
            styles: [__webpack_require__(/*! ./w-auth-piechart.component.scss */ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.scss")]
        }),
        __metadata("design:paramtypes", [pie_widget_service_1.PieWidget])
    ], WAuthPiechartComponent);
    return WAuthPiechartComponent;
}());
exports.WAuthPiechartComponent = WAuthPiechartComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-system-info/system-info.service.ts":
/*!********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-system-info/system-info.service.ts ***!
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
var http_1 = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var API_URL = 'api/tacacs/reports/general/';
var SystemInfoService = /** @class */ (function () {
    function SystemInfoService(http) {
        this.http = http;
    }
    SystemInfoService.prototype.get = function () {
        return this.http.get(API_URL, {})
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SystemInfoService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], SystemInfoService);
    return SystemInfoService;
}());
exports.SystemInfoService = SystemInfoService;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.html":
/*!**************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.html ***!
  \**************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-lg-3 col-xs-12 col-md-6\">\n    <div class=\"card\" style=\"min-height: 200px;\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">System Info</h5>\n        <!-- <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6> -->\n        <p class=\"card-text\"><b>Time: </b> <span class=\"pull-right\"><kt-clock></kt-clock></span></p>\n        <p class=\"card-text\"><b>API: </b> <span class=\"pull-right\">{{ widgets.api.text | async }}</span></p>\n        <p class=\"card-text\"><b>TAC: </b> <span class=\"pull-right\">{{ widgets.tac_plus.text | async }}</span></p>\n        <p class=\"card-text\"><b>HA Role: </b> <span class=\"pull-right\">{{ widgets.ha.text | async }}</span></p>\n      </div>\n    </div>\n  </div>\n  <div class=\"col-lg-2 col-xs-12 col-md-6\">\n    <div class=\"card\" style=\"min-height: 200px;\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Tac_Plus Info</h5>\n        <!-- <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6> -->\n        <p class=\"card-text\"><b>Status: </b>\n          <a [routerLink]=\"widgets.tac_status.url\">\n            <span class=\"pull-right kt-badge kt-badge--inline kt-badge--pill kt-badge--wide\"\n              [ngClass]=\"{ 'kt-badge--success' : (widgets.tac_status.text | async) == 'active', 'kt-badge--warning' : (widgets.tac_status.text | async) != 'active' }\">\n              {{ widgets.tac_status.text | async }}\n            </span>\n          </a>\n        </p>\n        <p class=\"card-text\"><b>Users: </b>\n          <span class=\"pull-right\">\n            <a [routerLink]=\"widgets.users.url\">{{ widgets.users.text | async }}</a>\n          </span>\n        </p>\n        <p class=\"card-text\"><b>Devices: </b>\n          <span class=\"pull-right\">\n            <a [routerLink]=\"widgets.users.url\">{{ widgets.devices.text | async }}</a>\n          </span>\n        </p>\n        <p class=\"card-text\"></p>\n      </div>\n    </div>\n  </div>\n  <div class=\"col-lg-3 col-xs-12 col-md-6\">\n    <div class=\"card\" style=\"min-height: 200px;\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Reports</h5>\n        <!-- <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6> -->\n        <p class=\"card-text\"><b>Authe Total: </b> <span class=\"pull-right\">{{ widgets.authe.text | async }}</span></p>\n        <p class=\"card-text\"><b>Autho Total: </b> <span class=\"pull-right\">{{ widgets.autho.text | async }}</span></p>\n        <p class=\"card-text\"><b>Acc Total: </b> <span class=\"pull-right\">{{ widgets.acc.text | async }}</span></p>\n        <p class=\"card-text\"><b>Bad Authe: </b> <span class=\"pull-right\">{{ widgets.bad_authe.text | async }}</span></p>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.scss":
/*!**************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.scss ***!
  \**************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX3dpZGdldHMvdy1zeXN0ZW0taW5mby93LXN5c3RlbS1pbmZvLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.ts":
/*!************************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.ts ***!
  \************************************************************************************************/
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
var system_info_service_1 = __webpack_require__(/*! ./system-info.service */ "./src/app/views/partials/layout/tacgui/_widgets/w-system-info/system-info.service.ts");
var WSystemInfoComponent = /** @class */ (function () {
    function WSystemInfoComponent(service) {
        this.service = service;
        this.widgets = {
            api: {
                text: new rxjs_1.BehaviorSubject('...')
            },
            tac_plus: {
                text: new rxjs_1.BehaviorSubject('...')
            },
            users: {
                text: new rxjs_1.BehaviorSubject('...'),
                url: '/tacacs/users'
            },
            devices: {
                text: new rxjs_1.BehaviorSubject('...'),
                url: '/tacacs/devices'
            },
            bad_authe: {
                text: new rxjs_1.BehaviorSubject('...'),
            },
            authe: {
                text: new rxjs_1.BehaviorSubject('...'),
                url: '/'
            },
            autho: {
                text: new rxjs_1.BehaviorSubject('...'),
                url: '/'
            },
            acc: {
                text: new rxjs_1.BehaviorSubject('...'),
                url: '/'
            },
            ha: {
                text: new rxjs_1.BehaviorSubject('...'),
                url: '/'
            },
            tac_status: {
                text: new rxjs_1.BehaviorSubject('...'),
                url: '/tacacs/config/global'
            },
        };
    }
    WSystemInfoComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.service.get().subscribe(function (data) {
            console.log(data.widgets[0]);
            _this.widgets.users.text.next(data.widgets[0].users);
            _this.widgets.devices.text.next(data.widgets[0].devices);
            _this.widgets.api.text.next(data.widgets[0].APIVER);
            _this.widgets.tac_plus.text.next(data.widgets[0].TACVER);
            _this.widgets.bad_authe.text.next(data.widgets[0].authe_err);
            _this.widgets.authe.text.next(data.widgets[0].authe);
            _this.widgets.autho.text.next(data.widgets[0].autho);
            _this.widgets.acc.text.next(data.widgets[0].acc);
            _this.widgets.ha.text.next(data.widgets[0].ha);
            _this.widgets.tac_status.text.next(data.widgets[0].tac_status);
        });
    };
    WSystemInfoComponent = __decorate([
        core_1.Component({
            selector: 'kt-w-system-info',
            template: __webpack_require__(/*! ./w-system-info.component.html */ "./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.html"),
            styles: [__webpack_require__(/*! ./w-system-info.component.scss */ "./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.scss")]
        }),
        __metadata("design:paramtypes", [system_info_service_1.SystemInfoService])
    ], WSystemInfoComponent);
    return WSystemInfoComponent;
}());
exports.WSystemInfoComponent = WSystemInfoComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_widgets/widgets.module.ts":
/*!*************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_widgets/widgets.module.ts ***!
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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
var ng2_charts_1 = __webpack_require__(/*! ng2-charts */ "./node_modules/ng2-charts/fesm5/ng2-charts.js");
var w_auth_linechart_component_1 = __webpack_require__(/*! ./w-auth-linechart/w-auth-linechart.component */ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-linechart/w-auth-linechart.component.ts");
var w_auth_piechart_component_1 = __webpack_require__(/*! ./w-auth-piechart/w-auth-piechart.component */ "./src/app/views/partials/layout/tacgui/_widgets/w-auth-piechart/w-auth-piechart.component.ts");
var w_system_info_component_1 = __webpack_require__(/*! ./w-system-info/w-system-info.component */ "./src/app/views/partials/layout/tacgui/_widgets/w-system-info/w-system-info.component.ts");
var clock_module_1 = __webpack_require__(/*! ../_fields/clock/clock.module */ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.module.ts");
var WidgetsModule = /** @class */ (function () {
    function WidgetsModule() {
    }
    WidgetsModule = __decorate([
        core_1.NgModule({
            declarations: [
                w_auth_linechart_component_1.WAuthLinechartComponent,
                w_auth_piechart_component_1.WAuthPiechartComponent,
                w_system_info_component_1.WSystemInfoComponent,
            ],
            imports: [
                common_1.CommonModule,
                router_1.RouterModule,
                ng2_charts_1.ChartsModule,
                clock_module_1.ClockModule
            ],
            exports: [
                w_auth_linechart_component_1.WAuthLinechartComponent,
                w_auth_piechart_component_1.WAuthPiechartComponent,
                w_system_info_component_1.WSystemInfoComponent
            ]
        })
    ], WidgetsModule);
    return WidgetsModule;
}());
exports.WidgetsModule = WidgetsModule;


/***/ })

}]);
//# sourceMappingURL=app-views-pages-dashboard-dashboard-module.a6681788413dea5b84aa.js.map