(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["common"],{

/***/ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.html":
/*!*********************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.html ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"\">\n  <p>{{_title}} {{ (time | async) }} {{ (timezone) ? _timezone : '' }}</p>\n</div>\n"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.scss":
/*!*********************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.scss ***!
  \*********************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhcnRpYWxzL2xheW91dC90YWNndWkvX2ZpZWxkcy9jbG9jay9jbG9jay5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.ts":
/*!*******************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.ts ***!
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
// RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var clock_service_1 = __webpack_require__(/*! ./clock.service */ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.service.ts");
var ClockComponent = /** @class */ (function () {
    function ClockComponent(cs) {
        this.cs = cs;
        this.text = 'Server Time';
        this._title = '';
        this._time_init = 1556288780;
        this._timezone = 'Etc/UTC';
        this.time = new rxjs_1.BehaviorSubject('');
        // date = new Date()
        this.destroy$ = new rxjs_1.Subject();
    }
    Object.defineProperty(ClockComponent.prototype, "title", {
        set: function (title) {
            this._title = title || '';
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ClockComponent.prototype, "time_init", {
        set: function (time_init) {
            this._time_init = time_init || 1556288780;
        },
        enumerable: true,
        configurable: true
    });
    ClockComponent.prototype.ngOnInit = function () {
        var _this = this;
        var source = rxjs_1.timer(1000, 1000);
        this.cs.get().subscribe(function (data) {
            // console.log(data)
            _this._time_init = parseInt(data.epoch);
            _this._timezone = data.timezone;
        });
        source.pipe(operators_1.takeUntil(this.destroy$)).subscribe(function (val) {
            //console.log(val);
            _this._time_init++;
            _this.time.next(_this.dateString());
        });
    };
    ClockComponent.prototype.dateString = function () {
        var utc = new Date(new Date(this._time_init * 1000).toLocaleString("en-US", { timeZone: this._timezone }));
        var month = '' + ('0' + utc.getMonth() + 1).substr(-2);
        var day = '' + ('0' + utc.getDate()).substr(-2);
        var year = utc.getFullYear();
        var hours = '' + ('0' + utc.getHours()).substr(-2);
        var minutes = '' + ('0' + utc.getMinutes()).substr(-2);
        var seconds = '' + ('0' + utc.getSeconds()).substr(-2);
        return [year, month, day].join('-') + ' ' + [hours, minutes, seconds].join(':');
    };
    ClockComponent.prototype.ngOnDestroy = function () {
        this.destroy$.next();
        this.destroy$.complete();
    };
    __decorate([
        core_1.Input(),
        __metadata("design:type", Boolean)
    ], ClockComponent.prototype, "timezone", void 0);
    __decorate([
        core_1.Input(),
        __metadata("design:type", String),
        __metadata("design:paramtypes", [String])
    ], ClockComponent.prototype, "title", null);
    __decorate([
        core_1.Input(),
        __metadata("design:type", Number),
        __metadata("design:paramtypes", [Number])
    ], ClockComponent.prototype, "time_init", null);
    ClockComponent = __decorate([
        core_1.Component({
            selector: 'kt-clock',
            template: __webpack_require__(/*! ./clock.component.html */ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.html"),
            styles: [__webpack_require__(/*! ./clock.component.scss */ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.scss")]
        }),
        __metadata("design:paramtypes", [clock_service_1.ClockService])
    ], ClockComponent);
    return ClockComponent;
}());
exports.ClockComponent = ClockComponent;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.module.ts":
/*!****************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_fields/clock/clock.module.ts ***!
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
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
var clock_component_1 = __webpack_require__(/*! ./clock.component */ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.component.ts");
var ClockModule = /** @class */ (function () {
    function ClockModule() {
    }
    ClockModule = __decorate([
        core_1.NgModule({
            declarations: [
                clock_component_1.ClockComponent
            ],
            imports: [
                common_1.CommonModule
            ],
            exports: [
                clock_component_1.ClockComponent
            ]
        })
    ], ClockModule);
    return ClockModule;
}());
exports.ClockModule = ClockModule;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.service.ts":
/*!*****************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_fields/clock/clock.service.ts ***!
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
var API_URL = 'api/apicheck/time/';
var ClockService = /** @class */ (function () {
    function ClockService(http) {
        this.http = http;
    }
    ClockService.prototype.get = function () {
        return this.http.get(API_URL)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    ClockService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], ClockService);
    return ClockService;
}());
exports.ClockService = ClockService;


/***/ }),

/***/ "./src/app/views/partials/layout/tacgui/_fields/field-general-list/preload.service.ts":
/*!********************************************************************************************!*\
  !*** ./src/app/views/partials/layout/tacgui/_fields/field-general-list/preload.service.ts ***!
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
var PreloadService = /** @class */ (function () {
    function PreloadService(http) {
        this.http = http;
    }
    PreloadService.prototype.get = function (url, id, extra) {
        if (extra === void 0) { extra = ''; }
        var params = new http_1.HttpParams()
            .set('id', id.toString()).set("extra", JSON.stringify(extra));
        //let message = ''
        return this.http.get('api' + url, { params: params })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.results;
        }));
    };
    PreloadService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], PreloadService);
    return PreloadService;
}());
exports.PreloadService = PreloadService;


/***/ })

}]);
//# sourceMappingURL=common.js.map