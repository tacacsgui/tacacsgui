(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app-views-pages-mavis-mavis-module"],{

/***/ "./src/app/views/pages/mavis/ldap/ldap.component.html":
/*!************************************************************!*\
  !*** ./src/app/views/pages/mavis/ldap/ldap.component.html ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<ngb-tabset (tabChange)=\"filterEvent($event)\">\n  <ngb-tab title=\"LDAP Settings\">\n    <ng-template ngbTabContent>\n\n<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loadingForm | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n    \t\t\t\t\t<label style=\"width: 100%;\">MAVIS LDAP Enabled</label>\n  \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--success\">\n  \t\t\t\t\t\t\t<label>\n  \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"params.enabled\">\n  \t\t\t\t\t\t\t\t<span></span>\n  \t\t\t\t\t\t\t</label>\n  \t\t\t\t\t\t</span>\n    \t\t\t\t</div>\n          </div>\n        </div>\n      <div class=\"block-below\">\n        <div class=\"block-partial\" *ngIf=\"!params.enabled\"></div>\n        <div class=\"block-container\" [ngClass]=\"{ 'active' : !params.enabled }\">\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label class=\"col-2 col-form-label\">LDAP Type</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n      \t\t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"params.type\">\n      \t\t\t\t\t\t\t<option value=\"microsoft\" selected=\"\">Microsoft</option>\n      \t\t\t\t\t\t\t<option value=\"openldap\">OpenLDAP</option>\n      \t\t\t\t\t\t</select>\n                  <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label class=\"col-3 col-form-label\">LDAP Server List</label>\n    \t\t\t\t\t\t<div class=\"col-9\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [(ngModel)]=\"params.hosts\">\n                  <span class=\"form-text text-muted\">comma-separated list of IP addresses or hostnames (don't try to set port here), e.g. 10.2.1.2, 10.2.3.2</span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n    \t\t\t\t\t\t<label >LDAP Base</label>\n    \t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [(ngModel)]=\"params.base\">\n                <span class=\"form-text text-muted\">base DN of your LDAP server, e.g. dc=domain,dc=name</span>\n    \t\t\t\t\t</div>\n            </div>\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n    \t\t\t\t\t\t<label >LDAP Search Attribute</label>\n    \t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [(ngModel)]=\"params.filter\">\n                <span class=\"form-text text-muted\">LDAP search attribute, e.g. sAMAccountName</span>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n    \t\t\t\t\t\t<label >Username</label>\n    \t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [(ngModel)]=\"params.user\">\n                <span class=\"form-text text-muted\">ldap user, without or with domain suffix</span>\n    \t\t\t\t\t</div>\n            </div>\n            <div class=\"col-6\">\n              <div class=\"form-group\">\n    \t\t\t\t\t\t<label >Password</label>\n    \t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"password\" [(ngModel)]=\"params.password\">\n                <span class=\"form-text text-muted\">password for LDAP User</span>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"accordion accordion-light  accordion-toggle-arrow\" >\n            <div class=\"card\">\n                <div class=\"card-header\">\n                    <div class=\"card-title collapsed\" [ngClass]=\"{ collapsed: !notCollapsedM }\" data-toggle=\"collapse\" (click)=\"notCollapsedM = !notCollapsedM\"\n                            [attr.aria-expanded]=\"!notCollapsedM\">Advanced Settings</div>\n                </div>\n                <div [ngbCollapse]=\"!notCollapsedM\">\n                  <div class=\"card-body\">\n                    <div class=\"row\">\n                      <div class=\"col-12\">\n                        <div class=\"form-group row\">\n              \t\t\t\t\t\t<label class=\"col-3 col-form-label\">LDAP Port</label>\n              \t\t\t\t\t\t<div class=\"col-6\">\n              \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"number\" [(ngModel)]=\"params.port\">\n                            <span class=\"form-text text-muted\"></span>\n              \t\t\t\t\t\t</div>\n              \t\t\t\t\t</div>\n                      </div>\n                    </div>\n                    <div class=\"row\">\n                      <div class=\"col-6\">\n                        <div class=\"form-group\">\n                          <label style=\"width: 100%;\">User can switch Tacacs Group</label>\n              \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--sm kt-switch--success\">\n              \t\t\t\t\t\t\t<label>\n              \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"params.group_selection\">\n              \t\t\t\t\t\t\t\t<span></span>\n              \t\t\t\t\t\t\t</label>\n              \t\t\t\t\t\t</span>\n              \t\t\t\t\t</div>\n                      </div>\n                      <div class=\"col-6\">\n                        <div class=\"form-group\">\n                          <label style=\"width: 100%;\">Default Message</label>\n              \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--sm kt-switch--success\">\n              \t\t\t\t\t\t\t<label>\n              \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"params.message_flag\">\n              \t\t\t\t\t\t\t\t<span></span>\n              \t\t\t\t\t\t\t</label>\n              \t\t\t\t\t\t</span>\n              \t\t\t\t\t</div>\n                      </div>\n                    </div>\n                    <div class=\"row\">\n                      <div class=\"col-6\">\n                        <div class=\"form-group\">\n                          <label style=\"width: 100%;\">Enable password as Login</label>\n              \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--sm kt-switch--success\">\n              \t\t\t\t\t\t\t<label>\n              \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"params.enable_login\">\n              \t\t\t\t\t\t\t\t<span></span>\n              \t\t\t\t\t\t\t</label>\n              \t\t\t\t\t\t</span>\n              \t\t\t\t\t</div>\n                      </div>\n                      <div class=\"col-6\">\n                        <div class=\"form-group\">\n                          <label style=\"width: 100%;\">PAP password as Login</label>\n              \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--sm kt-switch--success\">\n              \t\t\t\t\t\t\t<label>\n              \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"params.pap_login\">\n              \t\t\t\t\t\t\t\t<span></span>\n              \t\t\t\t\t\t\t</label>\n              \t\t\t\t\t\t</span>\n              \t\t\t\t\t</div>\n                      </div>\n                    </div>\n                  </div>\n                </div>\n            </div>\n          </div>\n        </div>\n      </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Save</button>&nbsp;\n    <button class=\"btn btn-warning btn-elevate btn-sm\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--v2 kt-spinner--right kt-spinner--sm kt-spinner--dark' : (test_loading | async) }\"\n      (click)=\"test()\">\n      Test\n    </button>&nbsp;&nbsp;&nbsp;\n    <span [ngClass]=\"{ 'text-success' : ( (test_result | async) == 'Success'),\n      'text-muted' : ( (test_loading | async) ),\n      'text-danger' :  !(test_loading | async) && !( (test_result | async) == 'Success') }\">{{test_result | async}}</span>\n  </div>\n</div>\n\n</ng-template>\n</ngb-tab>\n<ngb-tab title=\"LDAP Groups\">\n<ng-template ngbTabContent>\n  <div class=\"row\">\n    <div class=\"col-md-9 col-lg-8\">\n      <kt-portlet>\n        <kt-portlet-body>\n          <ngb-tabset>\n            <ngb-tab title=\"Group Search\">\n              <ng-template ngbTabContent>\n                <kt-main-table [options]=\"tableOptions_search\">\n                </kt-main-table>\n              </ng-template>\n            </ngb-tab>\n            <ngb-tab title=\"Group Bind Table\">\n              <ng-template ngbTabContent>\n                <kt-main-table [options]=\"tableOptions_bind\">\n                </kt-main-table>\n              </ng-template>\n            </ngb-tab>\n          </ngb-tabset>\n        </kt-portlet-body>\n      </kt-portlet>\n    </div>\n  </div>\n</ng-template>\n</ngb-tab>\n</ngb-tabset>\n"

/***/ }),

/***/ "./src/app/views/pages/mavis/ldap/ldap.component.scss":
/*!************************************************************!*\
  !*** ./src/app/views/pages/mavis/ldap/ldap.component.scss ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL21hdmlzL2xkYXAvbGRhcC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/mavis/ldap/ldap.component.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/mavis/ldap/ldap.component.ts ***!
  \**********************************************************/
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
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var ldap_service_1 = __webpack_require__(/*! ./ldap.service */ "./src/app/views/pages/mavis/ldap/ldap.service.ts");
var LdapMavis = {
    enabled: 0,
    period: 30,
    digits: 6,
    digest: "sha1"
};
var LdapComponent = /** @class */ (function () {
    function LdapComponent(toastr, mavis_ldap) {
        var _this = this;
        this.toastr = toastr;
        this.mavis_ldap = mavis_ldap;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.test_result = new rxjs_1.BehaviorSubject('');
        this.test_loading = new rxjs_1.BehaviorSubject(false);
        this.params = LdapMavis;
        this.params_old = '';
        this.tableOptions_search = {
            table: {
                delBtn: null,
                editBtn: false,
                selectable: false,
                preview: null,
                pagination: {
                    enable: true,
                    perpageItems: [10, 20, 30],
                    total: false
                },
                mainUrl: '/mavis/ldap/group/search/',
                columns: {
                    gidnumber: { title: 'gidnumber', show: false, sortable: false },
                    cn: { title: 'CN', show: false, sortable: false },
                    dn: { title: 'DN', show: true, sortable: false },
                    added: { title: 'Action', show: true, sortable: false,
                        htmlPattern: function (data, column_name, index, all_data) {
                            //console.log(data, column_name, index);
                            var buttom_icon = (data) ? 'fa-minus' : 'fa-plus';
                            var buttom_color = (data) ? 'warning' : 'success';
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data) {
                                // console.log(data[index])
                            });
                            return '<button class="btn btn-outline-hover-' + buttom_color + ' btn-sm btn-icon" (click)="alert()">' +
                                '<i class="fa ' + buttom_icon + '"></i>' +
                                '</button>';
                        },
                        onClick: function (data, column_name, index, all_data) {
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data_all) {
                                console.log(data_all[index]['dn']);
                                _this.mavis_ldap.bind(data, data_all[index]['dn']).subscribe(function (data_return) {
                                    console.log(data_return);
                                });
                            });
                            return true;
                        }
                    },
                },
            },
            buttons: {
                add: null,
                filter: {
                    enable: false,
                    filter: true
                },
                actions: null,
                moreColumns: null
            }
        };
        this.tableOptions_bind = {
            table: {
                delBtn: null,
                editBtn: false,
                selectable: false,
                preview: null,
                pagination: null,
                mainUrl: '/mavis/ldap/group/bind/table/',
                columns: {
                    cn: { title: 'CN', show: true, sortable: false },
                    dn: { title: 'DN', show: true, sortable: false },
                },
            },
            buttons: {
                add: null,
                filter: {
                    enable: false,
                    filter: true
                },
                actions: null,
                moreColumns: null
            }
        };
    }
    LdapComponent.prototype.ngOnInit = function () {
        this.init();
    };
    LdapComponent.prototype.init = function () {
        var _this = this;
        this.mavis_ldap.get().subscribe(function (data) {
            _this.params = data;
            _this.params_old = JSON.stringify(data);
            _this.loadingForm.next(false);
        });
    };
    LdapComponent.prototype.test = function () {
        var _this = this;
        this.test_result.next('Loading...');
        this.test_loading.next(true);
        var clone = JSON.parse(JSON.stringify(this.params));
        if (clone.password == JSON.parse(this.params_old).password)
            delete clone.password;
        this.mavis_ldap.testCon(this.params).subscribe(function (data) {
            _this.test_loading.next(false);
            if (data.exception)
                _this.test_result.next(data.exception);
            else
                _this.test_result.next('Success');
        });
    };
    LdapComponent.prototype.save = function () {
        var _this = this;
        this.loadingForm.next(true);
        if (this.params_old == JSON.stringify(this.params)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        var clone = JSON.parse(JSON.stringify(this.params));
        console.log(clone);
        if (clone.password == JSON.parse(this.params_old).password)
            delete clone.password;
        clone.enabled += 0;
        clone.enable_login += 0;
        clone.group_selection += 0;
        clone.message_flag += 0;
        clone.pap_login += 0;
        this.mavis_ldap.save(clone).subscribe(function (data) {
            if (data.mavis_ldap_update) {
                _this.toastr.success('Settings Saved');
                _this.init();
                return;
            }
            _this.toastr.error('Unexpcted Error');
            _this.init();
            return;
        });
    };
    LdapComponent.prototype.filterEvent = function (event) {
        console.log(event);
    };
    LdapComponent = __decorate([
        core_1.Component({
            selector: 'kt-ldap',
            template: __webpack_require__(/*! ./ldap.component.html */ "./src/app/views/pages/mavis/ldap/ldap.component.html"),
            styles: [__webpack_require__(/*! ./ldap.component.scss */ "./src/app/views/pages/mavis/ldap/ldap.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            ldap_service_1.LdapService])
    ], LdapComponent);
    return LdapComponent;
}());
exports.LdapComponent = LdapComponent;


/***/ }),

/***/ "./src/app/views/pages/mavis/ldap/ldap.service.ts":
/*!********************************************************!*\
  !*** ./src/app/views/pages/mavis/ldap/ldap.service.ts ***!
  \********************************************************/
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
var API_URL = 'api/mavis/ldap/';
var LdapService = /** @class */ (function () {
    function LdapService(http) {
        this.http = http;
    }
    LdapService.prototype.get = function () {
        return this.http.get(API_URL)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.params;
        }));
    };
    LdapService.prototype.save = function (data) {
        return this.http.post(API_URL, data)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    LdapService.prototype.testCon = function (data) {
        return this.http.post(API_URL + 'test/', data)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    LdapService.prototype.bind = function (action, dn) {
        if (Array.isArray(dn))
            dn = dn[0];
        return this.http.post(API_URL + 'group/bind/', { action: action, dn: dn })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    LdapService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], LdapService);
    return LdapService;
}());
exports.LdapService = LdapService;


/***/ }),

/***/ "./src/app/views/pages/mavis/local/local.component.html":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/mavis/local/local.component.html ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loadingForm | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n    \t\t\t\t\t<label style=\"width: 100%;\">MAVIS Local Enabled</label>\n    \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--success\">\n    \t\t\t\t\t\t\t<label>\n    \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"params.enabled\">\n    \t\t\t\t\t\t\t\t<span></span>\n    \t\t\t\t\t\t\t</label>\n    \t\t\t\t\t\t</span>\n    \t\t\t\t</div>\n          </div>\n        </div>\n      <div class=\"block-below\">\n        <div class=\"block-partial\" *ngIf=\"!params.enabled\"></div>\n        <div class=\"block-container\" [ngClass]=\"{ 'active' : !params.enabled }\">\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n    \t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"params.change_passwd_cli\"> Change Password via NAS CLI\n    \t\t\t\t\t\t<span></span>\n    \t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">user will be able to change your password via device (NAS) CLI, empty password at login, the user is given the option to change his password</span>\n              </div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group\">\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n    \t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"params.change_passwd_gui\"> Change Password via GUI\n    \t\t\t\t\t\t<span></span>\n    \t\t\t\t\t</label>\n              <span class=\"form-text text-muted\">user will be able to change your password via GUI</span>\n              </div>\n            </div>\n          </div>\n        </div>\n      </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Save</button>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/mavis/local/local.component.scss":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/mavis/local/local.component.scss ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL21hdmlzL2xvY2FsL2xvY2FsLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/mavis/local/local.component.ts":
/*!************************************************************!*\
  !*** ./src/app/views/pages/mavis/local/local.component.ts ***!
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
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
var local_service_1 = __webpack_require__(/*! ./local.service */ "./src/app/views/pages/mavis/local/local.service.ts");
var LocalMavis = {
    enabled: 0,
    change_passwd_cli: 0,
    change_passwd_gui: 0
};
var LocalComponent = /** @class */ (function () {
    function LocalComponent(toastr, mavis_local) {
        this.toastr = toastr;
        this.mavis_local = mavis_local;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.params = LocalMavis;
        this.params_old = '';
    }
    LocalComponent.prototype.ngOnInit = function () {
        this.init();
    };
    LocalComponent.prototype.init = function () {
        var _this = this;
        this.mavis_local.get().subscribe(function (data) {
            _this.params = data;
            _this.params_old = JSON.stringify(data);
            _this.loadingForm.next(false);
        });
    };
    LocalComponent.prototype.save = function () {
        var _this = this;
        this.loadingForm.next(true);
        if (this.params_old == JSON.stringify(this.params)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        this.params.enabled += 0;
        this.params.change_passwd_cli += 0;
        this.params.change_passwd_gui += 0;
        this.mavis_local.save(this.params).subscribe(function (data) {
            if (data.mavis_local_update) {
                _this.toastr.success('Settings Saved');
                _this.init();
                return;
            }
            _this.toastr.error('Unexpcted Error');
            _this.init();
            return;
        });
    };
    LocalComponent = __decorate([
        core_1.Component({
            selector: 'kt-local',
            template: __webpack_require__(/*! ./local.component.html */ "./src/app/views/pages/mavis/local/local.component.html"),
            styles: [__webpack_require__(/*! ./local.component.scss */ "./src/app/views/pages/mavis/local/local.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            local_service_1.LocalService])
    ], LocalComponent);
    return LocalComponent;
}());
exports.LocalComponent = LocalComponent;


/***/ }),

/***/ "./src/app/views/pages/mavis/local/local.service.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/mavis/local/local.service.ts ***!
  \**********************************************************/
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
var API_URL = 'api/mavis/local/';
var LocalService = /** @class */ (function () {
    function LocalService(http) {
        this.http = http;
    }
    LocalService.prototype.get = function () {
        return this.http.get(API_URL)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.params;
        }));
    };
    LocalService.prototype.save = function (data) {
        return this.http.post(API_URL, data)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    LocalService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], LocalService);
    return LocalService;
}());
exports.LocalService = LocalService;


/***/ }),

/***/ "./src/app/views/pages/mavis/mavis.module.ts":
/*!***************************************************!*\
  !*** ./src/app/views/pages/mavis/mavis.module.ts ***!
  \***************************************************/
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
var pages_module_1 = __webpack_require__(/*! ../pages.module */ "./src/app/views/pages/pages.module.ts");
var portlet_module_1 = __webpack_require__(/*! ../../partials/content/general/portlet/portlet.module */ "./src/app/views/partials/content/general/portlet/portlet.module.ts");
var clock_module_1 = __webpack_require__(/*! ../../partials/layout/tacgui/_fields/clock/clock.module */ "./src/app/views/partials/layout/tacgui/_fields/clock/clock.module.ts");
var otp_component_1 = __webpack_require__(/*! ./otp/otp.component */ "./src/app/views/pages/mavis/otp/otp.component.ts");
var local_component_1 = __webpack_require__(/*! ./local/local.component */ "./src/app/views/pages/mavis/local/local.component.ts");
var sms_component_1 = __webpack_require__(/*! ./sms/sms.component */ "./src/app/views/pages/mavis/sms/sms.component.ts");
var ldap_component_1 = __webpack_require__(/*! ./ldap/ldap.component */ "./src/app/views/pages/mavis/ldap/ldap.component.ts");
var test_component_1 = __webpack_require__(/*! ./test/test.component */ "./src/app/views/pages/mavis/test/test.component.ts");
var MavisModule = /** @class */ (function () {
    function MavisModule() {
    }
    MavisModule = __decorate([
        core_1.NgModule({
            declarations: [
                otp_component_1.OtpComponent,
                local_component_1.LocalComponent,
                sms_component_1.SmsComponent,
                ldap_component_1.LdapComponent,
                test_component_1.TestComponent
            ],
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                portlet_module_1.PortletModule,
                clock_module_1.ClockModule,
                pages_module_1.PagesModule,
                ng_bootstrap_1.NgbModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        redirectTo: '', pathMatch: 'full'
                    },
                    {
                        path: 'local',
                        component: local_component_1.LocalComponent
                    },
                    {
                        path: 'sms',
                        component: sms_component_1.SmsComponent
                    },
                    {
                        path: 'test',
                        component: test_component_1.TestComponent
                    },
                    {
                        path: 'otp',
                        component: otp_component_1.OtpComponent
                    },
                    {
                        path: 'ldap',
                        component: ldap_component_1.LdapComponent
                    },
                ]),
            ]
        })
    ], MavisModule);
    return MavisModule;
}());
exports.MavisModule = MavisModule;


/***/ }),

/***/ "./src/app/views/pages/mavis/otp/otp.component.html":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/mavis/otp/otp.component.html ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loadingForm | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n    \t\t\t\t\t<label style=\"width: 100%;\">MAVIS OTP Enabled</label>\n    \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--success\">\n    \t\t\t\t\t\t\t<label>\n    \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"params.enabled\">\n    \t\t\t\t\t\t\t\t<span></span>\n    \t\t\t\t\t\t\t</label>\n    \t\t\t\t\t\t</span>\n    \t\t\t\t</div>\n          </div>\n        </div>\n      <div class=\"block-below\">\n        <div class=\"block-partial\" *ngIf=\"!params.enabled\"></div>\n        <div class=\"block-container\" [ngClass]=\"{ 'active' : !params.enabled }\">\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Period</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"number\" [(ngModel)]=\"params.period\">\n                  <span class=\"form-text text-muted\">period of generating OTP. By default, the period for a TOTP is 30 seconds</span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Digits</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"number\" [(ngModel)]=\"params.digits\">\n                  <span class=\"form-text text-muted\">by default the number of digits is 6, more than 10 may be difficult to use by the owner</span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Digest</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n      \t\t\t\t\t\t<select class=\"form-control form-control-sm\" [(ngModel)]=\"params.digest\">\n      \t\t\t\t\t\t\t<option value=\"sha1\">sha1</option>\n      \t\t\t\t\t\t\t<option value=\"sha256\">sha256</option>\n      \t\t\t\t\t\t\t<option value=\"md5\">md5</option>\n      \t\t\t\t\t\t</select>\n                  <span class=\"form-text text-muted\">if you don't know what to choose leave it as default (first value)</span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n        </div>\n      </div>\n      <kt-clock [title]=\"'Current Server Time:'\" [time_init]=\"1\" [timezone]=\"false\"></kt-clock>\n      </kt-portlet-body>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Save</button>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/mavis/otp/otp.component.scss":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/mavis/otp/otp.component.scss ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL21hdmlzL290cC9vdHAuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/mavis/otp/otp.component.ts":
/*!********************************************************!*\
  !*** ./src/app/views/pages/mavis/otp/otp.component.ts ***!
  \********************************************************/
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
var otp_service_1 = __webpack_require__(/*! ./otp.service */ "./src/app/views/pages/mavis/otp/otp.service.ts");
var OtpMavis = {
    enabled: 0,
    period: 30,
    digits: 6,
    digest: "sha1"
};
var OtpComponent = /** @class */ (function () {
    function OtpComponent(toastr, mavis_otp) {
        this.toastr = toastr;
        this.mavis_otp = mavis_otp;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.params = OtpMavis;
        this.params_old = '';
    }
    OtpComponent.prototype.ngOnInit = function () {
        this.init();
    };
    OtpComponent.prototype.init = function () {
        var _this = this;
        this.mavis_otp.get().subscribe(function (data) {
            _this.params = data;
            _this.params_old = JSON.stringify(data);
            _this.loadingForm.next(false);
        });
    };
    OtpComponent.prototype.save = function () {
        var _this = this;
        if (!confirm('Any changes will make old passwords incorrect! Continue?'))
            return;
        this.loadingForm.next(true);
        if (this.params_old == JSON.stringify(this.params)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        this.params.enabled += 0;
        this.mavis_otp.save(this.params).subscribe(function (data) {
            if (data.mavis_otp_update) {
                _this.toastr.success('Settings Saved');
                _this.init();
                return;
            }
            _this.toastr.error('Unexpcted Error');
            _this.init();
            return;
        });
    };
    OtpComponent = __decorate([
        core_1.Component({
            selector: 'kt-otp',
            template: __webpack_require__(/*! ./otp.component.html */ "./src/app/views/pages/mavis/otp/otp.component.html"),
            styles: [__webpack_require__(/*! ./otp.component.scss */ "./src/app/views/pages/mavis/otp/otp.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            otp_service_1.OtpService])
    ], OtpComponent);
    return OtpComponent;
}());
exports.OtpComponent = OtpComponent;


/***/ }),

/***/ "./src/app/views/pages/mavis/otp/otp.service.ts":
/*!******************************************************!*\
  !*** ./src/app/views/pages/mavis/otp/otp.service.ts ***!
  \******************************************************/
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
var API_URL = 'api/mavis/otp/';
var OtpService = /** @class */ (function () {
    function OtpService(http) {
        this.http = http;
    }
    OtpService.prototype.get = function () {
        return this.http.get(API_URL)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.params;
        }));
    };
    OtpService.prototype.save = function (data) {
        return this.http.post(API_URL, data)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    OtpService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], OtpService);
    return OtpService;
}());
exports.OtpService = OtpService;


/***/ }),

/***/ "./src/app/views/pages/mavis/sms/sms.component.html":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/mavis/sms/sms.component.html ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loadingForm | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n    \t\t\t\t\t<label style=\"width: 100%;\">MAVIS SMS Enabled</label>\n    \t\t\t\t\t\t<span class=\"kt-switch kt-switch--outline kt-switch--success\">\n    \t\t\t\t\t\t\t<label>\n    \t\t\t\t\t\t\t\t<input type=\"checkbox\" checked [(ngModel)]=\"params.enabled\">\n    \t\t\t\t\t\t\t\t<span></span>\n    \t\t\t\t\t\t\t</label>\n    \t\t\t\t\t\t</span>\n    \t\t\t\t</div>\n          </div>\n        </div>\n      <div class=\"block-below\">\n        <div class=\"block-partial\" *ngIf=\"!params.enabled\"></div>\n        <div class=\"block-container\" [ngClass]=\"{ 'active' : !params.enabled }\">\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">SMPP Server</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [(ngModel)]=\"params.ipaddr\">\n                  <span class=\"form-text text-muted\">address of SMPP server</span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Port</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"number\" [(ngModel)]=\"params.port\">\n                  <span class=\"form-text text-muted\">port of SMPP server</span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Source Name</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [(ngModel)]=\"params.srcname\">\n                  <span class=\"form-text text-muted\">you can get that information from your provider</span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Username</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [(ngModel)]=\"params.login\">\n                  <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Password</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"password\" [(ngModel)]=\"params.pass\">\n                  <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <hr>\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Test Phone Number</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [ngClass]=\"{ 'is-invalid' : (phone_error | async)?.length }\" [(ngModel)]=\"phone\">\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (phone_error | async);\">{{message}}</p>\n                  </div>\n                  <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n          <ng-container *ngIf=\"( check_result | async )\">\n            <pre>{{ ( check_result | async ) }}</pre>\n          </ng-container>\n        </div>\n      </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-success btn-elevate btn-sm\"\n      (click)=\"save()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Save</button>&nbsp;\n    <button (click)=\"test()\" class=\"btn btn-warning btn-elevate btn-sm\" >Test</button>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/mavis/sms/sms.component.scss":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/mavis/sms/sms.component.scss ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL21hdmlzL3Ntcy9zbXMuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/mavis/sms/sms.component.ts":
/*!********************************************************!*\
  !*** ./src/app/views/pages/mavis/sms/sms.component.ts ***!
  \********************************************************/
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
var sms_service_1 = __webpack_require__(/*! ./sms.service */ "./src/app/views/pages/mavis/sms/sms.service.ts");
var SMSMavis = {
    enabled: 0,
    login: '',
    pass: '',
    digest: "sha1"
};
var SmsComponent = /** @class */ (function () {
    function SmsComponent(toastr, mavis_sms) {
        this.toastr = toastr;
        this.mavis_sms = mavis_sms;
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(true);
        this.params = SMSMavis;
        this.params_old = '';
        this.phone = '';
        this.phone_error = new rxjs_1.BehaviorSubject([]);
        this.check_result = new rxjs_1.BehaviorSubject('');
    }
    SmsComponent.prototype.ngOnInit = function () {
        this.init();
    };
    SmsComponent.prototype.init = function () {
        var _this = this;
        this.mavis_sms.get().subscribe(function (data) {
            _this.params = data;
            _this.params_old = JSON.stringify(data);
            _this.loadingForm.next(false);
        });
    };
    SmsComponent.prototype.test = function () {
        var _this = this;
        this.phone_error.next([]);
        if (!this.phone) {
            this.phone_error.next(['Phone number can not be empty']);
            return;
        }
        var clone = JSON.parse(JSON.stringify(this.params));
        if (clone.pass == JSON.parse(this.params_old).pass)
            delete clone.pass;
        this.mavis_sms.send(clone, this.phone).subscribe(function (data) {
            _this.check_result.next(data.check_result);
        });
    };
    SmsComponent.prototype.save = function () {
        var _this = this;
        this.loadingForm.next(true);
        if (this.params_old == JSON.stringify(this.params)) {
            this.toastr.warning('No Changes Detected!');
            this.loadingForm.next(false);
            return;
        }
        var clone = JSON.parse(JSON.stringify(this.params));
        if (clone.pass == JSON.parse(this.params_old).pass)
            delete clone.pass;
        clone.enabled += 0;
        // console.log(clone)
        this.mavis_sms.save(clone).subscribe(function (data) {
            if (data.mavis_sms_update) {
                _this.toastr.success('Settings Saved');
                _this.init();
                return;
            }
            _this.toastr.error('Unexpcted Error');
            _this.init();
            return;
        });
    };
    SmsComponent = __decorate([
        core_1.Component({
            selector: 'kt-sms',
            template: __webpack_require__(/*! ./sms.component.html */ "./src/app/views/pages/mavis/sms/sms.component.html"),
            styles: [__webpack_require__(/*! ./sms.component.scss */ "./src/app/views/pages/mavis/sms/sms.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            sms_service_1.SmsService])
    ], SmsComponent);
    return SmsComponent;
}());
exports.SmsComponent = SmsComponent;


/***/ }),

/***/ "./src/app/views/pages/mavis/sms/sms.service.ts":
/*!******************************************************!*\
  !*** ./src/app/views/pages/mavis/sms/sms.service.ts ***!
  \******************************************************/
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
var API_URL = 'api/mavis/sms/';
var SmsService = /** @class */ (function () {
    function SmsService(http) {
        this.http = http;
    }
    SmsService.prototype.get = function () {
        return this.http.get(API_URL)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data.params;
        }));
    };
    SmsService.prototype.save = function (data) {
        return this.http.post(API_URL, data)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SmsService.prototype.send = function (data, number) {
        data['number'] = number;
        return this.http.post(API_URL + 'send/', data)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    SmsService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], SmsService);
    return SmsService;
}());
exports.SmsService = SmsService;


/***/ }),

/***/ "./src/app/views/pages/mavis/test/test.component.html":
/*!************************************************************!*\
  !*** ./src/app/views/pages/mavis/test/test.component.html ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-md-9 col-lg-7\">\n    <kt-portlet [class]=\"(loadingForm | async) ? 'tacgui-blockui-portlet' : ''\">\n      <kt-portlet-body>\n\n          <div class=\"row\">\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Username</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"text\" [ngClass]=\"{ 'is-invalid' : (validation | async)?.username }\" [(ngModel)]=\"username\">\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.username;\">{{message}}</p>\n                  </div>\n                  <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          <div class=\"row\">\n          </div>\n            <div class=\"col-12\">\n              <div class=\"form-group row\">\n    \t\t\t\t\t\t<label for=\"example-text-input\" class=\"col-2 col-form-label\">Password</label>\n    \t\t\t\t\t\t<div class=\"col-6\">\n    \t\t\t\t\t\t\t<input class=\"form-control form-control-sm\" type=\"password\" [ngClass]=\"{ 'is-invalid' : (validation | async)?.password }\" [(ngModel)]=\"password\">\n                  <div class=\"invalid-feedback\">\n                    <p *ngFor=\"let message of (validation | async)?.password;\">{{message}}</p>\n                  </div>\n                  <span class=\"form-text text-muted\"></span>\n    \t\t\t\t\t\t</div>\n    \t\t\t\t\t</div>\n            </div>\n          </div>\n\n      <kt-clock [title]=\"'Current Server Time:'\" [time_init]=\"1\" [timezone]=\"false\"></kt-clock>\n      <div class=\"row\">\n        <div class=\"col-12\">\n          <pre>{{result | async}}</pre>\n        </div>\n      </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loadingForm | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xs-11 offset-sm-1 offset-md-1 offset-lg-1\">\n    <button class=\"btn btn-warning btn-elevate btn-sm\"\n      (click)=\"test()\"\n      [ngClass]=\"{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light' : (loadingForm | async) }\"\n      [disabled]=\"(loadingForm | async)\">Test</button>&nbsp;\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/mavis/test/test.component.scss":
/*!************************************************************!*\
  !*** ./src/app/views/pages/mavis/test/test.component.scss ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL21hdmlzL3Rlc3QvdGVzdC5jb21wb25lbnQuc2NzcyJ9 */"

/***/ }),

/***/ "./src/app/views/pages/mavis/test/test.component.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/mavis/test/test.component.ts ***!
  \**********************************************************/
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
var test_service_1 = __webpack_require__(/*! ./test.service */ "./src/app/views/pages/mavis/test/test.service.ts");
var TestComponent = /** @class */ (function () {
    function TestComponent(toastr, mavis_test) {
        this.toastr = toastr;
        this.mavis_test = mavis_test;
        this.username = '';
        this.password = '';
        this.result = new rxjs_1.BehaviorSubject('Result will appeared here');
        this.validation = new rxjs_1.BehaviorSubject({});
        this.loadingForm = new rxjs_1.BehaviorSubject(false);
    }
    TestComponent.prototype.ngOnInit = function () {
    };
    TestComponent.prototype.validationFill = function () {
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
    TestComponent.prototype.test = function () {
        var _this = this;
        this.validation.next({});
        this.result.next('Loading...');
        this.mavis_test.test(this.username, this.password).subscribe(function (data) {
            // console.log(data)
            if (data.error.status) {
                _this.validation.next(data.error.validation);
                for (var key in data.error.validation) {
                    if (data.error.validation[key]) {
                        //console.log(data.error.validation[key])
                        for (var i = 0; i < data.error.validation[key].length; i++) {
                            _this.toastr.error(data.error.validation[key][i]);
                        }
                    }
                }
                _this.result.next('Error.');
                return;
            }
            _this.result.next(data.check_result);
        });
    };
    TestComponent = __decorate([
        core_1.Component({
            selector: 'kt-test',
            template: __webpack_require__(/*! ./test.component.html */ "./src/app/views/pages/mavis/test/test.component.html"),
            styles: [__webpack_require__(/*! ./test.component.scss */ "./src/app/views/pages/mavis/test/test.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            test_service_1.TestService])
    ], TestComponent);
    return TestComponent;
}());
exports.TestComponent = TestComponent;


/***/ }),

/***/ "./src/app/views/pages/mavis/test/test.service.ts":
/*!********************************************************!*\
  !*** ./src/app/views/pages/mavis/test/test.service.ts ***!
  \********************************************************/
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
var API_URL = 'api/mavis/otp/check/';
var TestService = /** @class */ (function () {
    function TestService(http) {
        this.http = http;
    }
    TestService.prototype.test = function (username, password) {
        return this.http.post(API_URL, { username: username, password: password })
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    TestService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], TestService);
    return TestService;
}());
exports.TestService = TestService;


/***/ })

}]);
//# sourceMappingURL=app-views-pages-mavis-mavis-module.c7baf69671b5add666ab.js.map