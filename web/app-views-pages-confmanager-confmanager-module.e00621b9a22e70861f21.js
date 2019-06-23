(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app-views-pages-confmanager-confmanager-module"],{

/***/ "./src/app/views/pages/confmanager/confmanager.component.html":
/*!********************************************************************!*\
  !*** ./src/app/views/pages/confmanager/confmanager.component.html ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-12\">\n    <kt-portlet>\n      <kt-portlet-header [title]=\"'Configuration Manager'\">\n\n\t\t\t\t<ng-container ktPortletTools>\n\t\t\t\t\t<button type=\"button\" class=\"btn btn-primary\" (click)=\"renameFlag = false; newFolder(content)\">New Folder</button>\n\t\t\t\t</ng-container>\n\t\t\t</kt-portlet-header>\n      <nav aria-label=\"breadcrumb\">\n        <ol class=\"breadcrumb breadcrumb-custome\">\n          <ng-container *ngFor=\"let bpath of breadcrumb.path; let i = index; let first = first; let last = last\">\n            <li class=\"breadcrumb-item\" *ngIf=\"!last\">\n              <a href=\"javascript:void(0);\" (click)=\"navigatorTree(i)\">{{(first)? 'root' : bpath}}</a>\n            </li>\n            <li class=\"breadcrumb-item active\" *ngIf=\"last\" aria-current=\"page\">{{(first)? 'root' : bpath}}</li>\n          </ng-container>\n\n          <!-- <li class=\"breadcrumb-item\"><a href=\"#\">Library</a></li>\n          <li class=\"breadcrumb-item active\" aria-current=\"page\">Data</li> -->\n        </ol>\n      </nav>\n      <kt-portlet-body>\n        <div class=\"row\">\n          <div class=\"col-3\" style=\"border-right: 1px solid #bbb; overflow: auto; max-height: 500px;\">\n            <div class=\"super-tree\">\n              <tree-root #tree [nodes]=\"nodes\"\n              [options]=\"options\"\n              (loadNodeChildren)=\"loadChildren($event)\" (initialized)=\"treeInit()\" (activate)=\"select($event)\">\n              <ng-template #treeNodeWrapperTemplate let-node let-index=\"index\">\n                <div class=\"node-wrapper\" [style.padding-left]=\"node.getNodePadding()\" *ngIf=\"!node.data.deleted\">\n                  <tree-node-expander [node]=\"node\"></tree-node-expander>\n                  <div class=\"node-content-wrapper\"\n                    [class.node-content-wrapper-active]=\"node.isActive\"\n                    [class.node-content-wrapper-focused]=\"node.isFocused\"\n                    (click)=\"node.mouseAction('click', $event)\"\n                    (dblclick)=\"node.mouseAction('dblClick', $event)\"\n                    (contextmenu)=\"node.mouseAction('contextMenu', $event)\"\n                    (treeDrop)=\"node.onDrop($event)\"\n                    [treeAllowDrop]=\"node.allowDrop\"\n                    [treeDrag]=\"node\"\n                    [treeDragEnabled]=\"node.allowDrag()\">\n                    <i class=\"fa {{node.isExpanded && node.data.hasChildren ? 'fa-folder-open' : 'fa-folder'}} kt-font-primary\"></i>&nbsp;\n                    <span>{{ node.data.name }}</span>\n                    <!-- <tree-node-content [node]=\"node\" [index]=\"index\"></tree-node-content> -->\n                  </div>\n                </div>\n              </ng-template>\n                <!-- <ng-template #treeNodeTemplate let-node let-index=\"index\">\n                  <ng-container *ngIf=\"!node.data.deleted\">\n                    <i class=\"fa {{node.isExpanded && node.data.hasChildren ? 'fa-folder-open' : 'fa-folder'}} kt-font-primary\"></i>&nbsp;\n                    <span>{{ node.data.name }}</span>\n                  </ng-container>\n                </ng-template> -->\n              </tree-root>\n            </div>\n\n\n          </div>\n          <div class=\"col-9\">\n            <div *ngIf=\"exploer.loading | async\" class=\"kt-spinner kt-spinner--lg kt-spinner--brand\"></div>\n            <div class=\"row exploer-body\">\n              <div class=\"col-xs-6 col-sm-6 col-md-3 col-xl-2\" *ngFor=\"let el of (exploer.data | async)\">\n                <div class=\"text-center exploer-element\" (contextmenu)=\"openContext($event, el); $event.preventDefault();\" (dblclick)=\"elClick(el)\">\n                  <i class=\"{{el.icon}} kt-font-primary\"></i><br>\n                  <span class=\"element-title\">{{el.name}}</span>\n                </div>\n              </div>\n            </div>\n          </div>\n        </div>\n      </kt-portlet-body>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </kt-portlet>\n  </div>\n</div>\n\n<!-- <ng-template #fileMenu let-file>\n  <section class=\"file-menu\">\n    <div (click)=\"delete(file)\">Delete {{file.name}}</div>\n    <div>Move to</div>\n  </section>\n</ng-template> -->\n<ng-template #fileMenu let-file>\n  <section class=\"file-menu\">\n    <div (click)=\"deleteFile(file, tree)\">Delete {{file.name}}</div>\n    <!-- <div (click)=\"openMove(file, content_move)\">Move</div> -->\n    <div *ngIf=\"!file.dir\" (click)=\"preview(file.path); closeContext()\">Preview</div>\n    <!-- <div *ngIf=\"file.dir\" (click)=\"renameFlag = true; renameOpen(file, content)\">Rename</div> -->\n  </section>\n</ng-template>\n\n<ng-template #content let-c=\"close\" let-d=\"dismiss\">\n  <div class=\"modal-body\">\n    <p *ngIf=\"!renameFlag\">Add new folder {{ breadcrumb.path.join('/')+'/'+fname }}</p>\n    <p *ngIf=\"renameFlag\">Folder path {{ breadcrumb.path.join('/')+'/'+fname }}</p>\n    <div class=\"form-group\">\n      <label>Folder Name</label>\n      <input type=\"text\" class=\"form-control form-control-sm\"\n          [ngClass]=\"{ 'is-invalid' : (validation | async)?.fname || (validation | async)?.path }\"\n          [(ngModel)]=\"fname\" placeholder=\"Folder Name\">\n          <!-- is-invalid -->\n      <div class=\"invalid-feedback\">\n        <p *ngFor=\"let message of (validation | async)?.fname;\">{{message}}</p>\n        <p *ngFor=\"let message of (validation | async)?.path;\">{{message}}</p>\n      </div>\n      <span class=\"form-text text-muted\"></span>\n    </div>\n  </div>\n  <div class=\"modal-footer\">\n    <button *ngIf=\"!renameFlag\" class=\"btn btn-success btn-elevate btn-sm\" (click)=\"addFolder(tree)\">Add</button>&nbsp;\n    <button *ngIf=\"renameFlag\" class=\"btn btn-success btn-elevate btn-sm\" (click)=\"renameFolder(tree)\">Edit</button>&nbsp;\n    <button (click)=\"d('Cross click')\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</button>&nbsp;\n    <!-- <button type=\"button\" class=\"btn btn-outline-dark\" (click)=\"c('Save click')\">Save</button> -->\n  </div>\n</ng-template>\n\n<ng-template #content_move let-c=\"close\" let-d=\"dismiss\">\n  <div class=\"modal-body\">\n    <p>{{ (moveFile.file.dir) ? 'Folder' : 'File' }} name: {{moveFile.file.name}}</p>\n    <p>Move from: {{breadcrumb.path.join('/')+'/'}}</p>\n    <p>Move to: {{ moveFile.new_path }}</p>\n    <kt-confm-tree-view (path)=\"newPathSelect($event)\"></kt-confm-tree-view>\n  </div>\n  <div class=\"modal-footer\">\n    <button class=\"btn btn-success btn-elevate btn-sm\" (click)=\"moveFolder()\">Move</button>&nbsp;\n    <button (click)=\"d('Cross click')\" class=\"btn btn-default btn-elevate btn-sm\" >Cancel</button>&nbsp;\n    <!-- <button type=\"button\" class=\"btn btn-outline-dark\" (click)=\"c('Save click')\">Save</button> -->\n  </div>\n</ng-template>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/confmanager.component.scss":
/*!********************************************************************!*\
  !*** ./src/app/views/pages/confmanager/confmanager.component.scss ***!
  \********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".example-tree-invisible {\n  display: none; }\n\n.example-tree ul,\n.example-tree li {\n  margin-top: 0;\n  margin-bottom: 0;\n  list-style-type: none; }\n\n.example-tree-node {\n  display: block; }\n\n.example-tree-node .example-tree-node {\n  padding-left: 7px; }\n\n.folder-name {\n  cursor: pointer; }\n\n.folder-selected {\n  color: #1d1e2c;\n  font-weight: bold; }\n\nol.breadcrumb-custome {\n  border-radius: 0px;\n  background-color: #f7f8fa;\n  border-bottom: 1px solid #bbb; }\n\n.super-tree {\n  display: inline-block; }\n\n.exploer-element {\n  cursor: pointer; }\n\n.exploer-element:hover {\n  background-color: #5867dc1a; }\n\n.exploer-element > i {\n  font-size: 3.5rem;\n  line-height: 1.2; }\n\n.element-title {\n  white-space: nowrap;\n  overflow: hidden;\n  text-overflow: ellipsis;\n  width: 120px; }\n\n.file-menu {\n  background-color: #fafafa;\n  padding: 4pt;\n  font-size: 10pt;\n  z-index: 1000;\n  box-shadow: 0 0 12pt rgba(0, 0, 0, 0.25);\n  border-radius: 4pt;\n  padding: 0.5em 0 0.5em 0;\n  -webkit-animation: fadeIn 0.1s ease-out;\n          animation: fadeIn 0.1s ease-out;\n  opacity: 1.0;\n  display: block; }\n\n.file-menu hr {\n  border: none;\n  border-bottom: 1px solid #eee; }\n\n.file-menu div {\n  cursor: pointer;\n  display: block;\n  text-decoration: none;\n  color: #333;\n  padding: 0.5em 2em 0.5em 0.75em;\n  max-width: 18em;\n  white-space: nowrap;\n  overflow: hidden;\n  text-overflow: ellipsis; }\n\n.file-menu div:hover {\n  background-color: #333;\n  color: #fff; }\n\n.file-menu div::before {\n  content: '';\n  float: left;\n  margin-right: 0.75em;\n  width: 0.5em;\n  height: 1em;\n  display: inline-block; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYWdlcy9jb25mbWFuYWdlci9jb25mbWFuYWdlci5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLGFBQWEsRUFBQTs7QUFHZjs7RUFFRSxhQUFhO0VBQ2IsZ0JBQWdCO0VBQ2hCLHFCQUFxQixFQUFBOztBQUV2QjtFQUNFLGNBQWMsRUFBQTs7QUFHaEI7RUFDRSxpQkFBaUIsRUFBQTs7QUFHbkI7RUFDRSxlQUFlLEVBQUE7O0FBR2pCO0VBQ0UsY0FBYztFQUNkLGlCQUFpQixFQUFBOztBQUduQjtFQUNFLGtCQUFrQjtFQUNsQix5QkFBeUI7RUFDekIsNkJBQTZCLEVBQUE7O0FBRy9CO0VBQ0UscUJBQXFCLEVBQUE7O0FBTXZCO0VBQ0UsZUFBZSxFQUFBOztBQUVqQjtFQUNFLDJCQUEyQixFQUFBOztBQUU3QjtFQUNFLGlCQUFpQjtFQUNqQixnQkFBZ0IsRUFBQTs7QUFHbEI7RUFDRSxtQkFBbUI7RUFDbkIsZ0JBQWdCO0VBQ2hCLHVCQUF1QjtFQUN2QixZQUFZLEVBQUE7O0FBR2Q7RUFDRSx5QkFBeUI7RUFDekIsWUFBWTtFQUNaLGVBQWU7RUFDZixhQUFhO0VBQ2Isd0NBQXdDO0VBQ3hDLGtCQUFrQjtFQUNsQix3QkFBd0I7RUFDeEIsdUNBQStCO1VBQS9CLCtCQUErQjtFQUMvQixZQUFXO0VBQ1gsY0FBYSxFQUFBOztBQUlmO0VBQ0UsWUFBWTtFQUNaLDZCQUE2QixFQUFBOztBQUcvQjtFQUNFLGVBQWU7RUFDZixjQUFjO0VBQ2QscUJBQXFCO0VBQ3JCLFdBQVc7RUFDWCwrQkFBK0I7RUFDL0IsZUFBZTtFQUNmLG1CQUFtQjtFQUNuQixnQkFBZ0I7RUFDaEIsdUJBQXVCLEVBQUE7O0FBR3pCO0VBQ0Usc0JBQXNCO0VBQ3RCLFdBQVcsRUFBQTs7QUFJYjtFQUNFLFdBQVc7RUFDWCxXQUFXO0VBQ1gsb0JBQW9CO0VBQ3BCLFlBQVk7RUFDWixXQUFXO0VBQ1gscUJBQXFCLEVBQUEiLCJmaWxlIjoic3JjL2FwcC92aWV3cy9wYWdlcy9jb25mbWFuYWdlci9jb25mbWFuYWdlci5jb21wb25lbnQuc2NzcyIsInNvdXJjZXNDb250ZW50IjpbIi5leGFtcGxlLXRyZWUtaW52aXNpYmxlIHtcbiAgZGlzcGxheTogbm9uZTtcbn1cblxuLmV4YW1wbGUtdHJlZSB1bCxcbi5leGFtcGxlLXRyZWUgbGkge1xuICBtYXJnaW4tdG9wOiAwO1xuICBtYXJnaW4tYm90dG9tOiAwO1xuICBsaXN0LXN0eWxlLXR5cGU6IG5vbmU7XG59XG4uZXhhbXBsZS10cmVlLW5vZGUge1xuICBkaXNwbGF5OiBibG9jaztcbn1cblxuLmV4YW1wbGUtdHJlZS1ub2RlIC5leGFtcGxlLXRyZWUtbm9kZSB7XG4gIHBhZGRpbmctbGVmdDogN3B4O1xufVxuXG4uZm9sZGVyLW5hbWUge1xuICBjdXJzb3I6IHBvaW50ZXI7XG59XG5cbi5mb2xkZXItc2VsZWN0ZWQge1xuICBjb2xvcjogIzFkMWUyYztcbiAgZm9udC13ZWlnaHQ6IGJvbGQ7XG59XG5cbm9sLmJyZWFkY3J1bWItY3VzdG9tZSB7XG4gIGJvcmRlci1yYWRpdXM6IDBweDtcbiAgYmFja2dyb3VuZC1jb2xvcjogI2Y3ZjhmYTtcbiAgYm9yZGVyLWJvdHRvbTogMXB4IHNvbGlkICNiYmI7XG59XG5cbi5zdXBlci10cmVlIHtcbiAgZGlzcGxheTogaW5saW5lLWJsb2NrO1xufVxuXG4uZXhwbG9lci1ib2R5IHtcblxufVxuLmV4cGxvZXItZWxlbWVudCB7XG4gIGN1cnNvcjogcG9pbnRlcjtcbn1cbi5leHBsb2VyLWVsZW1lbnQ6aG92ZXIge1xuICBiYWNrZ3JvdW5kLWNvbG9yOiAjNTg2N2RjMWE7XG59XG4uZXhwbG9lci1lbGVtZW50ID4gaSB7XG4gIGZvbnQtc2l6ZTogMy41cmVtO1xuICBsaW5lLWhlaWdodDogMS4yO1xufVxuXG4uZWxlbWVudC10aXRsZSB7XG4gIHdoaXRlLXNwYWNlOiBub3dyYXA7XG4gIG92ZXJmbG93OiBoaWRkZW47XG4gIHRleHQtb3ZlcmZsb3c6IGVsbGlwc2lzO1xuICB3aWR0aDogMTIwcHg7XG59XG5cbi5maWxlLW1lbnUge1xuICBiYWNrZ3JvdW5kLWNvbG9yOiAjZmFmYWZhO1xuICBwYWRkaW5nOiA0cHQ7XG4gIGZvbnQtc2l6ZTogMTBwdDtcbiAgei1pbmRleDogMTAwMDtcbiAgYm94LXNoYWRvdzogMCAwIDEycHQgcmdiYSgwLCAwLCAwLCAwLjI1KTtcbiAgYm9yZGVyLXJhZGl1czogNHB0O1xuICBwYWRkaW5nOiAwLjVlbSAwIDAuNWVtIDA7XG4gIGFuaW1hdGlvbjogZmFkZUluIDAuMXMgZWFzZS1vdXQ7XG4gIG9wYWNpdHk6MS4wO1xuICBkaXNwbGF5OmJsb2NrO1xufVxuXG5cbi5maWxlLW1lbnUgaHIge1xuICBib3JkZXI6IG5vbmU7XG4gIGJvcmRlci1ib3R0b206IDFweCBzb2xpZCAjZWVlO1xufVxuXG4uZmlsZS1tZW51IGRpdiB7XG4gIGN1cnNvcjogcG9pbnRlcjtcbiAgZGlzcGxheTogYmxvY2s7XG4gIHRleHQtZGVjb3JhdGlvbjogbm9uZTtcbiAgY29sb3I6ICMzMzM7XG4gIHBhZGRpbmc6IDAuNWVtIDJlbSAwLjVlbSAwLjc1ZW07XG4gIG1heC13aWR0aDogMThlbTtcbiAgd2hpdGUtc3BhY2U6IG5vd3JhcDtcbiAgb3ZlcmZsb3c6IGhpZGRlbjtcbiAgdGV4dC1vdmVyZmxvdzogZWxsaXBzaXM7XG59XG5cbi5maWxlLW1lbnUgZGl2OmhvdmVyIHtcbiAgYmFja2dyb3VuZC1jb2xvcjogIzMzMztcbiAgY29sb3I6ICNmZmY7XG59XG5cblxuLmZpbGUtbWVudSBkaXY6OmJlZm9yZSB7XG4gIGNvbnRlbnQ6ICcnO1xuICBmbG9hdDogbGVmdDtcbiAgbWFyZ2luLXJpZ2h0OiAwLjc1ZW07XG4gIHdpZHRoOiAwLjVlbTtcbiAgaGVpZ2h0OiAxZW07XG4gIGRpc3BsYXk6IGlubGluZS1ibG9jaztcbn1cbiJdfQ== */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/confmanager.component.ts":
/*!******************************************************************!*\
  !*** ./src/app/views/pages/confmanager/confmanager.component.ts ***!
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
var overlay_1 = __webpack_require__(/*! @angular/cdk/overlay */ "./node_modules/@angular/cdk/esm5/overlay.es5.js");
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var portal_1 = __webpack_require__(/*! @angular/cdk/portal */ "./node_modules/@angular/cdk/esm5/portal.es5.js");
var ng_bootstrap_1 = __webpack_require__(/*! @ng-bootstrap/ng-bootstrap */ "./node_modules/@ng-bootstrap/ng-bootstrap/fesm5/ng-bootstrap.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Router
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
//Service
var preview_service_1 = __webpack_require__(/*! ./preview.service */ "./src/app/views/pages/confmanager/preview.service.ts");
// interface File_ {
//   name: string,
//   rights?: string
// }
//
// interface Folder_ {
//   name: string,
//   node?: any,
//   rights?: string
// }
var ConfmanagerComponent = /** @class */ (function () {
    function ConfmanagerComponent(service, config, modalService, overlay, viewContainerRef, toastr, router, route) {
        this.service = service;
        this.config = config;
        this.modalService = modalService;
        this.overlay = overlay;
        this.viewContainerRef = viewContainerRef;
        this.toastr = toastr;
        this.router = router;
        this.route = route;
        this.rootDir = '/opt/tgui_data/confManager/configs';
        this.validation = new rxjs_1.BehaviorSubject([]);
        this.fname = '';
        this.fname_old = '';
        this.moveFile = {
            file: {
                name: '',
                path: ''
            },
            new_path: '/'
        };
        this.options = {
            getChildren: this.getChildren.bind(this),
        };
        this.nodes = [];
        this.breadcrumb = {
            path: [],
            nodes: []
        };
        this.exploer = {
            data: new rxjs_1.BehaviorSubject([]),
            loading: new rxjs_1.BehaviorSubject(false)
        };
        config.backdrop = 'static';
        config.keyboard = false;
        this.nodes = [
            {
                name: 'root',
                id: '/',
                path: '/',
                partial_path: [''],
                hasChildren: true,
                deleted: false
            }
        ];
    }
    ConfmanagerComponent.prototype.getChildren = function (node) {
        return this.service.getDir(node.data.path);
    };
    ConfmanagerComponent.prototype.loadChildren = function (e) {
        // console.log(e)
        if (!e.node.children.length) {
            // console.log(e.node)
            e.node.data.hasChildren = false;
        }
    };
    ConfmanagerComponent.prototype.ngOnInit = function () {
    };
    ConfmanagerComponent.prototype.treeInit = function () {
        var someNode = this.tree.treeModel.getNodeById('/');
        someNode.expand();
        var firstRoot = this.tree.treeModel.roots[0];
        firstRoot.setActiveAndVisible();
    };
    ConfmanagerComponent.prototype.select = function (e) {
        console.log(e);
        e.node.expand();
        this.activeNode = e.node;
        this.breadcrumb.path = e.node.data.partial_path;
        this.breadcrumb.nodes = [];
        var counter = 0, parent_temp = e.node;
        while (true) {
            if (parent_temp.isRoot) {
                this.breadcrumb.nodes.unshift(parent_temp);
                break;
            }
            parent_temp = parent_temp.parent;
            this.breadcrumb.nodes.unshift(parent_temp);
            counter++;
            if (parent_temp.isRoot)
                break;
            if (counter > 1000)
                break;
        }
        this.fillExploer(e.node);
        // console.log(this.breadcrumb)
    };
    ConfmanagerComponent.prototype.fillExploer = function (node) {
        var _this = this;
        this.exploer.loading.next(true);
        this.exploer.data.next([]);
        this.service.getDirExploer(node.data.path).subscribe(function (data) {
            // console.log(data)
            var els = [];
            for (var i = 0; i < data.length; i++) {
                els.push(_this.createElement(data[i]));
            }
            if (!node.isRoot)
                els.unshift({ name: node.parent.data.name, dir: true, icon: 'fas fa-angle-up', parent: true });
            _this.exploer.data.next(els);
            _this.exploer.loading.next(false);
        });
    };
    ConfmanagerComponent.prototype.createElement = function (el) {
        var regex = RegExp('^d.*');
        var dir = regex.test(el);
        var parts = el.split(' ');
        return {
            name: parts[1],
            path: this.breadcrumb.path.join('/') + '/' + parts[1],
            dir: dir,
            icon: (dir) ? 'fa fa-folder' : 'fa fa-file-alt',
        };
    };
    ConfmanagerComponent.prototype.navigatorTree = function (index) {
        // console.log(index)
        this.breadcrumb.nodes[index].expand();
        this.breadcrumb.nodes[index].setActiveAndVisible();
    };
    ConfmanagerComponent.prototype.elClick = function (el) {
        // console.log(el)
        if (!el.dir) {
            this.preview(el.path);
            return;
        }
        if (el.parent) {
            this.activeNode.parent.expand();
            this.activeNode.parent.setActiveAndVisible();
            return;
        }
        if (el.dir) {
            var superDone = false;
            for (var i = 0; i < this.activeNode.children.length; i++) {
                // console.log(this.activeNode.children[i])
                // console.log(this.activeNode.children[i].data.name == el.name)
                if (this.activeNode.children[i].data.name == el.name) {
                    this.activeNode.children[i].expand();
                    this.activeNode.children[i].setActiveAndVisible();
                    return;
                }
            }
            // console.log(this.activeNode.children)
            return;
        }
        console.log(this.activeNode);
    };
    ConfmanagerComponent.prototype.openContext = function (e, el) {
        var _this = this;
        console.log(el);
        this.closeContext();
        var positionStrategy = this.overlay.position()
            .flexibleConnectedTo(e)
            .withPositions([
            {
                originX: 'end',
                originY: 'bottom',
                overlayX: 'end',
                overlayY: 'top',
            }
        ]);
        this.overlayRef = this.overlay.create({
            positionStrategy: positionStrategy,
            scrollStrategy: this.overlay.scrollStrategies.close()
        });
        this.overlayRef.attach(new portal_1.TemplatePortal(this.fileMenu, this.viewContainerRef, {
            $implicit: el
        }));
        this.sub = rxjs_1.fromEvent(document, 'click')
            .pipe(operators_1.filter(function (event) {
            var clickTarget = event.target;
            return !!_this.overlayRef && !_this.overlayRef.overlayElement.contains(clickTarget);
        }), operators_1.take(1)).subscribe(function () { return _this.closeContext(); });
    };
    ConfmanagerComponent.prototype.closeContext = function () {
        this.sub && this.sub.unsubscribe();
        if (this.overlayRef) {
            this.overlayRef.dispose();
            this.overlayRef = null;
        }
    };
    ConfmanagerComponent.prototype.preview = function (file) {
        console.log(file);
        this.router.navigate(['./preview', file], { relativeTo: this.route });
    };
    ConfmanagerComponent.prototype.newFolder = function (content) {
        this.fname = '';
        this.modalService.open(content);
    };
    ConfmanagerComponent.prototype.addFolder = function (tree) {
        var _this = this;
        var path = this.breadcrumb.path.join('/') + '/' + this.fname;
        this.service.addFolder({
            fname: this.fname,
            parent: this.rootDir + this.breadcrumb.path.join('/') + '/',
            path: this.rootDir + path,
        }).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                //this.loading.next(false)
                return;
            }
            _this.activeNode.data.children = _this.activeNode.data.children || [];
            _this.activeNode.data.children.unshift({
                name: _this.fname,
                path: path,
                partial_path: path.split('/')
            });
            tree.treeModel.update();
            tree.treeModel.getNodeById(_this.activeNode.data.id)
                .setActiveAndVisible();
            _this.modalService.dismissAll();
        });
    };
    ConfmanagerComponent.prototype.deleteFile = function (f, tree) {
        var _this = this;
        // console.log(f)
        if (!confirm('Are you sure? Delete ' + f.name + '?'))
            return;
        this.closeContext();
        this.service.delFolder({
            path: this.rootDir + f.path,
            file: !!f.dir,
        }).subscribe(function (data) {
            console.log(data);
            if (!data.status) {
                _this.toastr.error('Error');
                return;
            }
            var _loop_1 = function (i) {
                if (f !== _this.exploer.data.getValue()[i])
                    return "continue";
                _this.exploer.data.pipe(operators_1.take(1)).subscribe(function (data) {
                    data.splice(i, 1);
                    _this.exploer.data.next(data);
                });
                return "break";
            };
            for (var i = 0; i < _this.exploer.data.getValue().length; i++) {
                var state_1 = _loop_1(i);
                if (state_1 === "break")
                    break;
            }
            if (f.dir) {
                for (var i = 0; i < _this.activeNode.children.length; i++) {
                    console.log(f.name !== _this.activeNode.children[i].data.name);
                    if (f.name !== _this.activeNode.children[i].data.name)
                        continue;
                    _this.activeNode.children[i].parent.data.children.splice(i, 1);
                    tree.treeModel.update();
                    tree.treeModel.getNodeById(_this.activeNode.data.id)
                        .setActiveAndVisible();
                    // console.log(this.activeNode)
                    //this.activeNode = e.node;
                    break;
                }
            }
            _this.toastr.success('Deleted');
        });
    };
    ConfmanagerComponent.prototype.renameOpen = function (file, content) {
        this.fname = file.name;
        this.fname_old = file.name;
        this.modalService.open(content);
        this.closeContext();
    };
    ConfmanagerComponent.prototype.renameFolder = function () {
        var _this = this;
        console.log(this.fname, this.fname_old);
        this.service.moveFolder({
            fname: this.fname,
            path: this.rootDir + this.breadcrumb.path.join('/') + '/' + this.fname,
            path_old: this.rootDir + this.breadcrumb.path.join('/') + '/' + this.fname_old,
        }).subscribe(function (data) {
            console.log(data);
            _this.validation.next(data.error.validation);
            if (data.error.status) {
                //this.loading.next(false)
                return;
            }
            _this.tree.treeModel.update();
            var myTarget = _this.tree.treeModel.getNodeById(_this.breadcrumb.path.join('/') + '/' + _this.fname_old + '/');
            console.log(myTarget);
            myTarget.data.name = _this.fname;
            myTarget.data.path = _this.breadcrumb.path.join('/') + '/' + _this.fname + '/';
            myTarget.data.id = _this.breadcrumb.path.join('/') + '/' + _this.fname + '/';
            _this.tree.treeModel.getNodeById(_this.breadcrumb.path.join('/') + '/')
                .setActiveAndVisible();
            _this.modalService.dismissAll();
        });
    };
    ConfmanagerComponent.prototype.openMove = function (file, content) {
        console.log(file);
        this.moveFile.file = file;
        this.modalService.open(content);
        this.closeContext();
    };
    ConfmanagerComponent.prototype.newPathSelect = function (e) {
        console.log(e);
        this.moveFile.new_path = e || '/';
    };
    ConfmanagerComponent.prototype.moveFolder = function () {
        var _this = this;
        this.service.moveFolder({
            fname: this.moveFile.file.name,
            path: this.rootDir + this.moveFile.new_path + this.moveFile.file.name,
            path_old: this.rootDir + this.breadcrumb.path.join('/') + '/' + this.moveFile.file.name,
        }).subscribe(function (data) {
            console.log(data);
            console.log(_this.breadcrumb.path.join('/') + '/' + _this.moveFile.file.name + '/');
            var node_child = _this.tree.treeModel.getNodeById(_this.breadcrumb.path.join('/') + '/' + _this.moveFile.file.name + '/');
            var node_old_parent = _this.tree.treeModel.getNodeById(_this.breadcrumb.path.join('/') + '/');
            console.log(node_child);
            console.log(node_old_parent);
            node_child.data.deleted = true;
            node_child.data.id = node_child.data.id + '--deleted';
            // _.remove(node_old_parent.parent.data.children, node_child.data);
            // for (let i = 0; i < node_old_parent.data.children.length; i++) {
            //     if (node_old_parent.data.children[i].name !== node_child.data.name) continue;
            //     node_old_parent.data.children.splice(i,1)
            //     node_old_parent.children.splice(i,1)
            //     break;
            // }
            //this.tree.treeModel.update();
            // this.tree.treeModel.getNodeById(this.breadcrumb.path.join('/')+'/')
            //   .setActiveAndVisible();
            var node_new_parent = _this.tree.treeModel.getNodeById(_this.moveFile.new_path);
            console.log(node_new_parent);
            if (node_new_parent && node_new_parent.data.children) {
                var new_data = JSON.parse(JSON.stringify({
                    id: _this.moveFile.new_path + _this.moveFile.file.name + '/',
                    name: _this.moveFile.file.name,
                    path: _this.moveFile.new_path + _this.moveFile.file.name + '/',
                    partial_path: _this.moveFile.new_path.split('/'),
                    hasChildren: true
                }));
                // let new_data = { name: 'Jopa!!!' }
                console.log(new_data);
                node_new_parent.data.children.push(new_data);
            }
            // console.log(node_new_parent)
            //node_new_parent.data.children.unshift()
            _this.tree.treeModel.update();
            _this.tree.treeModel.getNodeById(_this.breadcrumb.path.join('/') + '/')
                .setActiveAndVisible();
            _this.modalService.dismissAll();
        });
    };
    __decorate([
        core_1.ViewChild('tree'),
        __metadata("design:type", Object)
    ], ConfmanagerComponent.prototype, "tree", void 0);
    __decorate([
        core_1.ViewChild('fileMenu'),
        __metadata("design:type", core_1.TemplateRef)
    ], ConfmanagerComponent.prototype, "fileMenu", void 0);
    ConfmanagerComponent = __decorate([
        core_1.Component({
            selector: 'kt-confmanager',
            template: __webpack_require__(/*! ./confmanager.component.html */ "./src/app/views/pages/confmanager/confmanager.component.html"),
            styles: [__webpack_require__(/*! ./confmanager.component.scss */ "./src/app/views/pages/confmanager/confmanager.component.scss")]
        }),
        __metadata("design:paramtypes", [preview_service_1.PreviewService,
            ng_bootstrap_1.NgbModalConfig,
            ng_bootstrap_1.NgbModal,
            overlay_1.Overlay,
            core_1.ViewContainerRef,
            ngx_toastr_1.ToastrService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], ConfmanagerComponent);
    return ConfmanagerComponent;
}());
exports.ConfmanagerComponent = ConfmanagerComponent;


/***/ }),

/***/ "./src/app/views/pages/confmanager/confmanager.module.ts":
/*!***************************************************************!*\
  !*** ./src/app/views/pages/confmanager/confmanager.module.ts ***!
  \***************************************************************/
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
var pages_module_1 = __webpack_require__(/*! ../../pages/pages.module */ "./src/app/views/pages/pages.module.ts");
// Partials
var partials_module_1 = __webpack_require__(/*! ../../partials/partials.module */ "./src/app/views/partials/partials.module.ts");
var angular_tree_component_1 = __webpack_require__(/*! angular-tree-component */ "./node_modules/angular-tree-component/dist/angular-tree-component.js");
// import { LoggingComponent } from './logging/logging.component';
var confmanager_component_1 = __webpack_require__(/*! ./confmanager.component */ "./src/app/views/pages/confmanager/confmanager.component.ts");
var confmanager_module_1 = __webpack_require__(/*! ../../partials/layout/tacgui/_forms/confmanager/confmanager.module */ "./src/app/views/partials/layout/tacgui/_forms/confmanager/confmanager.module.ts");
var preview_component_1 = __webpack_require__(/*! ./preview/preview.component */ "./src/app/views/pages/confmanager/preview/preview.component.ts");
var ConfmanagerModule = /** @class */ (function () {
    function ConfmanagerModule() {
    }
    ConfmanagerModule = __decorate([
        core_1.NgModule({
            declarations: [
                // LoggingComponent,
                confmanager_component_1.ConfmanagerComponent,
                preview_component_1.PreviewComponent
            ],
            imports: [
                common_1.CommonModule,
                forms_1.FormsModule,
                ng_bootstrap_1.NgbModule,
                pages_module_1.PagesModule,
                partials_module_1.PartialsModule,
                confmanager_module_1.ConfmanagerModule,
                angular_tree_component_1.TreeModule.forRoot(),
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: confmanager_component_1.ConfmanagerComponent
                    },
                    {
                        path: 'preview/:file',
                        component: preview_component_1.PreviewComponent
                    },
                    {
                        path: 'settings',
                        loadChildren: './settings/confmanager-settings.module#ConfmanagerSettingsModule'
                    },
                ]),
            ]
        })
    ], ConfmanagerModule);
    return ConfmanagerModule;
}());
exports.ConfmanagerModule = ConfmanagerModule;


/***/ }),

/***/ "./src/app/views/pages/confmanager/preview/preview.component.html":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/preview/preview.component.html ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"form-group\">\n  <a routerLink=\"../..\" class=\"btn btn-primary btn-sm\" >Back to Exploer</a>&nbsp;\n</div>\n\n<div class=\"row\">\n  <div class=\"col-xl-9\">\n    <div class=\"card {{(loading | async) ? 'tacgui-blockui-portlet' : ''}}\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Preview Mode</h5>\n        <!-- <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6> -->\n        <div class=\"row\">\n          <div class=\"col-sm-3\">\n            <div class=\"form-group\">\n              <label>Brief</label>\n              <div class=\"input-group input-group-sm\">\n                <div class=\"input-group-prepend\">\n                  <span class=\"input-group-text\">\n                    <label class=\"kt-radio kt-radio--single kt-radio--primary\">\n                      <input type=\"radio\" name=\"diffType\" value=\"brief\" [(ngModel)]=\"previewType\" (change)=\"preview()\">\n                      <span></span>\n                    </label>\n                  </span>\n                </div>\n                <input type=\"number\" class=\"form-control\" [(ngModel)]=\"context.brief\" placeholder=\"Number of context\" min=\"3\" (change)=\"preview()\">\n              </div>\n            </div>\n          </div>\n          <div class=\"col-sm-3\">\n            <div class=\"form-group\">\n              <label>Full View</label>\n              <div class=\"input-group input-group-sm\">\n                <div class=\"input-group-prepend\">\n                  <span class=\"input-group-text\">\n                    <label class=\"kt-radio kt-radio--single kt-radio--primary\">\n                      <input type=\"radio\" name=\"diffType\" value=\"full\" [(ngModel)]=\"previewType\" (change)=\"preview()\">\n                      <span></span>\n                    </label>\n                  </span>\n                </div>\n                <input type=\"text\" class=\"form-control\" placeholder=\"Full\" disabled>\n              </div>\n            </div>\n          </div>\n          <div class=\"col-sm-3\">\n            <div class=\"form-group\">\n              <label>Preview</label>\n              <div class=\"input-group input-group-sm\">\n                <div class=\"input-group-prepend\">\n                  <span class=\"input-group-text\">\n                    <label class=\"kt-radio kt-radio--single kt-radio--primary\">\n                      <input type=\"radio\" name=\"diffType\" value=\"preview\" [(ngModel)]=\"previewType\" (change)=\"preview()\">\n                      <span></span>\n                    </label>\n                  </span>\n                </div>\n                <input type=\"text\" class=\"form-control\" placeholder=\"Preview\" disabled>\n              </div>\n            </div>\n          </div>\n          <div class=\"col-sm-3\">\n            <div class=\"form-group\">\n              <label>Clear Diff</label>\n              <div class=\"input-group input-group-sm\">\n                <div class=\"input-group-prepend\">\n                  <span class=\"input-group-text\">\n                    <label class=\"kt-radio kt-radio--single kt-radio--primary\">\n                      <input type=\"radio\" name=\"diffType\" value=\"native\" [(ngModel)]=\"previewType\" (change)=\"preview()\">\n                      <span></span>\n                    </label>\n                  </span>\n                </div>\n                <input type=\"number\" class=\"form-control\" placeholder=\"Number of context\" [(ngModel)]=\"context.native\" min=\"3\" (change)=\"preview()\">\n              </div>\n            </div>\n          </div>\n        </div>\n        <hr>\n        <!-- select file version -->\n        <div class=\"row\">\n          <div class=\"col-6\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"files.a.version | async\"\n                [params]=\"list.file_a\"\n                [errors]=\"(validation | async)?.group\"\n                (returnData)=\"setFile($event)\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.group }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n          <div class=\"col-6\" *ngIf=\"(previewType == 'brief' || previewType == 'full' || previewType == 'native')\">\n            <div class=\"form-group\">\n              <kt-field-general-list [data]=\"files.b.version | async\"\n                [params]=\"list.file_b\"\n                [errors]=\"(validation | async)?.group\"\n                (returnData)=\"setFile($event,'B')\"\n                [ngClass]=\"{ 'is-invalid' : (validation | async)?.group }\" >\n              </kt-field-general-list>\n            </div>\n          </div>\n        </div>\n        <!-- preview section -->\n        <div class=\"row\" *ngIf=\"(previewType == 'brief' || previewType == 'full')\">\n          <div class=\"col-6\">\n            <div class=\"preview_diff file_a\" [ngStyle]=\"{'counter-reset': chunk_list.a | async}\">\n              <!-- <div class=\"line addition ng-star-inserted\">aaa authorization commands 10 default group tacacs+ local</div> -->\n              <ng-container *ngFor=\"let line of (files.a.diff | async);\">\n                <div class=\"line {{line.class}} {{ (line.chunk) ? 'chunk '+line.chunk  : '' }}\">{{line.text}}</div>\n              </ng-container>\n            </div>\n          </div>\n          <div class=\"col-6\">\n            <div class=\"preview_diff file_b\" [ngStyle]=\"{'counter-reset': chunk_list.b | async}\">\n              <ng-container *ngFor=\"let line of (files.b.diff | async);\">\n                <div class=\"line {{line.class}} {{ (line.chunk) ? 'chunk '+line.chunk  : '' }}\">{{line.text}}</div>\n                <!-- line.chunk.split(' ').[0] -->\n              </ng-container>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\" *ngIf=\"!(previewType == 'brief' || previewType == 'full')\">\n          <div class=\"col-12\">\n            <pre>{{native_preview | async}}</pre>\n          </div>\n        </div>\n      </div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main\"></div>\n      <div *ngIf=\"(loading | async)\" class=\"tacgui-blockui-main-message kt-spinner kt-spinner--sm kt-spinner--success\"><span>Please wait...</span></div>\n    </div>\n\n    <div class=\"card\" *ngIf=\"previewType == 'brief' || previewType == 'native'\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Tacacs Log</h5>\n        <h6 class=\"card-subtitle mb-2 text-muted\">\n          time range: {{ (files.a.version | async)[0]?.id }} - {{ (files.b.version | async)[0]?.id }}\n        </h6>\n        <h6 class=\"card-subtitle mb-2 text-muted\" *ngIf=\"(deviceInfo | async)?.id \">\n          ip address - {{ (deviceInfo | async).ipaddress }}, name - {{ (deviceInfo | async).tacdevice }}\n        </h6>\n        <h6 class=\"card-subtitle mb-2 text-muted\" *ngIf=\"!(deviceInfo | async)?.id \">\n          matches not found\n        </h6>\n        <div class=\"row\">\n          <div class=\"col-3\">\n            <div class=\"table-responsive\">\n              <table class=\"table table-striped table-hover\">\n                <thead>\n                  <tr>\n                    <th>User List</th>\n                  </tr>\n                </thead>\n                <tbody>\n                  <tr *ngFor=\"let user of tacacsUsers | async\" style=\"cursor: pointer;\" (click)=\"loadUser(user.username)\">\n                    <td class=\"user-line {{ (tacUsername == user.username) ? 'selected' : ''}}\">\n                      {{user.username}}\n                      <span class=\"kt-badge kt-badge--brand\" ngbTooltip=\"Authentications\">{{user.authe}}</span>\n                      <span class=\"kt-badge kt-badge--brand\" ngbTooltip=\"Authorizations\">{{user.autho}}</span>\n                      <span class=\"kt-badge kt-badge--brand\" ngbTooltip=\"Accounting Log\">{{user.acc}}</span>\n                    </td>\n                  </tr>\n                </tbody>\n              </table>\n            </div>\n          </div>\n          <div class=\"col-9\">\n            <ngb-tabset (tabChange)=\"changeTacLog($event)\">\n              <ngb-tab id=\"authe\" title=\"Authentications\">\n                <ng-template ngbTabContent>\n                  <div class=\"table-responsive\" style=\"max-height: 400px;\">\n                    <table class=\"table table-striped\">\n                      <thead>\n                        <tr>\n                          <th>Date</th>\n                          <th>NAC</th>\n                          <th>Action</th>\n                        </tr>\n                      </thead>\n                      <tbody>\n                        <tr *ngFor=\"let log of tacacsLog | async\">\n                          <td>\n                            {{log.date}}\n                          </td>\n                          <td>\n                            {{log.nac}}\n                          </td>\n                          <td>\n                            {{log.action}}\n                          </td>\n                        </tr>\n                      </tbody>\n                    </table>\n                  </div>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab id=\"autho\" title=\"Authorizations\">\n                <ng-template ngbTabContent>\n                  <div class=\"table-responsive\" style=\"max-height: 400px;\">\n                    <table class=\"table table-striped\">\n                      <thead>\n                        <tr>\n                          <th>Date</th>\n                          <th>NAC</th>\n                          <th>Command</th>\n                        </tr>\n                      </thead>\n                      <tbody>\n                        <tr *ngFor=\"let log of tacacsLog | async\">\n                          <td>\n                            {{log.date}}\n                          </td>\n                          <td>\n                            {{log.nac}}\n                          </td>\n                          <td>\n                            {{log.cmd}}\n                          </td>\n                        </tr>\n                      </tbody>\n                    </table>\n                  </div>\n                </ng-template>\n              </ngb-tab>\n              <ngb-tab id=\"acc\" title=\"Accounting Log\">\n                <ng-template ngbTabContent>\n                  <div class=\"table-responsive\" style=\"max-height: 400px;\">\n                    <table class=\"table table-striped\">\n                      <thead>\n                        <tr>\n                          <th>Date</th>\n                          <th>NAC</th>\n                          <th>Command</th>\n                        </tr>\n                      </thead>\n                      <tbody>\n                        <tr *ngFor=\"let log of tacacsLog | async\">\n                          <td>\n                            {{log.date}}\n                          </td>\n                          <td>\n                            {{log.nac}}\n                          </td>\n                          <td>\n                            {{log.cmd}}\n                          </td>\n                        </tr>\n                      </tbody>\n                    </table>\n                  </div>\n                </ng-template>\n              </ngb-tab>\n            </ngb-tabset>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/confmanager/preview/preview.component.scss":
/*!************************************************************************!*\
  !*** ./src/app/views/pages/confmanager/preview/preview.component.scss ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "div.preview_diff {\n  display: grid;\n  /* overflow: auto; */\n  width: 100%;\n  overflow: auto; }\n\ndiv.preview_diff > div.line {\n  background-color: #fff;\n  color: #000;\n  min-height: 19px;\n  display: inline-block;\n  padding: 0px 15px;\n  white-space: nowrap; }\n\n.chunk::before {\n  display: inline-block;\n  border-right: 1px solid #333;\n  padding: 0 .5em;\n  margin-right: .5em;\n  color: #888;\n  min-width: 40px; }\n\ndiv.preview_diff > .line.chunk_trigger {\n  background-color: #999;\n  color: #eee;\n  font-weight: bold; }\n\ndiv.preview_diff > .line.addition {\n  background-color: #00a65a42; }\n\ndiv.preview_diff > .line.subtract {\n  background-color: #dd4b3970; }\n\ndiv.preview_diff > .line.empty {\n  height: 19px;\n  content: '';\n  background-color: #eee; }\n\n.user-line.selected {\n  background-color: #ffb822b0; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYWdlcy9jb25mbWFuYWdlci9wcmV2aWV3L3ByZXZpZXcuY29tcG9uZW50LnNjc3MiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IkFBQUE7RUFDRSxhQUFhO0VBQ2Isb0JBQUE7RUFDQSxXQUFXO0VBQ1gsY0FBYyxFQUFBOztBQUdoQjtFQUNFLHNCQUFzQjtFQUN0QixXQUFXO0VBQ1gsZ0JBQWdCO0VBQ2hCLHFCQUFxQjtFQUNyQixpQkFBaUI7RUFDakIsbUJBQW1CLEVBQUE7O0FBRXJCO0VBR0UscUJBQXFCO0VBQ3JCLDRCQUE0QjtFQUM1QixlQUFlO0VBQ2Ysa0JBQWtCO0VBQ2xCLFdBQVc7RUFDWCxlQUFlLEVBQUE7O0FBU2pCO0VBQ0Usc0JBQXNCO0VBQ3RCLFdBQVc7RUFDWCxpQkFBaUIsRUFBQTs7QUFHbkI7RUFDRSwyQkFBMkIsRUFBQTs7QUFHN0I7RUFDRSwyQkFBMkIsRUFBQTs7QUFHN0I7RUFDRSxZQUFZO0VBQ1osV0FBVztFQUNYLHNCQUFzQixFQUFBOztBQUd4QjtFQUNFLDJCQUEyQixFQUFBIiwiZmlsZSI6InNyYy9hcHAvdmlld3MvcGFnZXMvY29uZm1hbmFnZXIvcHJldmlldy9wcmV2aWV3LmNvbXBvbmVudC5zY3NzIiwic291cmNlc0NvbnRlbnQiOlsiZGl2LnByZXZpZXdfZGlmZiB7XG4gIGRpc3BsYXk6IGdyaWQ7XG4gIC8qIG92ZXJmbG93OiBhdXRvOyAqL1xuICB3aWR0aDogMTAwJTtcbiAgb3ZlcmZsb3c6IGF1dG87XG59XG5cbmRpdi5wcmV2aWV3X2RpZmYgPiBkaXYubGluZSB7XG4gIGJhY2tncm91bmQtY29sb3I6ICNmZmY7XG4gIGNvbG9yOiAjMDAwO1xuICBtaW4taGVpZ2h0OiAxOXB4O1xuICBkaXNwbGF5OiBpbmxpbmUtYmxvY2s7XG4gIHBhZGRpbmc6IDBweCAxNXB4O1xuICB3aGl0ZS1zcGFjZTogbm93cmFwO1xufVxuLmNodW5rOjpiZWZvcmUge1xuICAvLyBjb3VudGVyLWluY3JlbWVudDogY2h1bmtfMjtcbiAgLy8gY29udGVudDogY291bnRlcihjaHVua18yKTtcbiAgZGlzcGxheTogaW5saW5lLWJsb2NrO1xuICBib3JkZXItcmlnaHQ6IDFweCBzb2xpZCAjMzMzO1xuICBwYWRkaW5nOiAwIC41ZW07XG4gIG1hcmdpbi1yaWdodDogLjVlbTtcbiAgY29sb3I6ICM4ODg7XG4gIG1pbi13aWR0aDogNDBweDtcbn1cblxuLy8gZGl2LnByZXZpZXdfZGlmZiA+IGRpdi5saW5lID4gZGl2IHtcbi8vICAgICBsaW5lLWhlaWdodDogMS41cmVtO1xuLy8gICAgIHBhZGRpbmc6IDBweCA1cHggMHB4IDVweDtcbi8vICAgICBtYXJnaW46IDBweCA3cHggMHB4IDBweDtcbi8vIH1cbi8vXG5kaXYucHJldmlld19kaWZmID4gLmxpbmUuY2h1bmtfdHJpZ2dlciB7XG4gIGJhY2tncm91bmQtY29sb3I6ICM5OTk7XG4gIGNvbG9yOiAjZWVlO1xuICBmb250LXdlaWdodDogYm9sZDtcbn1cbi8vXG5kaXYucHJldmlld19kaWZmID4gLmxpbmUuYWRkaXRpb24ge1xuICBiYWNrZ3JvdW5kLWNvbG9yOiAjMDBhNjVhNDI7XG59XG4vL1xuZGl2LnByZXZpZXdfZGlmZiA+IC5saW5lLnN1YnRyYWN0IHtcbiAgYmFja2dyb3VuZC1jb2xvcjogI2RkNGIzOTcwO1xufVxuLy9cbmRpdi5wcmV2aWV3X2RpZmYgPiAubGluZS5lbXB0eSB7XG4gIGhlaWdodDogMTlweDtcbiAgY29udGVudDogJyc7XG4gIGJhY2tncm91bmQtY29sb3I6ICNlZWU7XG59XG5cbi51c2VyLWxpbmUuc2VsZWN0ZWQge1xuICBiYWNrZ3JvdW5kLWNvbG9yOiAjZmZiODIyYjA7XG59XG4iXX0= */"

/***/ }),

/***/ "./src/app/views/pages/confmanager/preview/preview.component.ts":
/*!**********************************************************************!*\
  !*** ./src/app/views/pages/confmanager/preview/preview.component.ts ***!
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
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
//Router
var router_1 = __webpack_require__(/*! @angular/router */ "./node_modules/@angular/router/fesm5/router.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Service
var preview_service_1 = __webpack_require__(/*! ../preview.service */ "./src/app/views/pages/confmanager/preview.service.ts");
var PreviewComponent = /** @class */ (function () {
    function PreviewComponent(toastr, service, router, route) {
        this.toastr = toastr;
        this.service = service;
        this.router = router;
        this.route = route;
        this.context = {
            brief: 3,
            native: 3
        };
        this.chunk_list = {
            a: new rxjs_1.BehaviorSubject(''),
            b: new rxjs_1.BehaviorSubject(''),
        };
        this.deviceInfo = new rxjs_1.BehaviorSubject({ id: 0, ipaddress: '' });
        this.tacacsUsers = new rxjs_1.BehaviorSubject([]);
        this.tacacsLog = new rxjs_1.BehaviorSubject([]);
        this.tacLogType = 'authe';
        this.tacUsername = '';
        this.filePath = '';
        this.previewType = 'brief';
        this.loading = new rxjs_1.BehaviorSubject(true);
        this.list = {
            file_a: {
                multiple: false,
                protectDel: true,
                title: 'Version of File A',
                title_sidebar: 'File Versions',
                search: false,
                apiurl: 'api/confmanager/diff/list/',
                extra: {
                    file: ''
                }
            },
            file_b: {
                multiple: false,
                protectDel: true,
                title: 'Version of File B',
                title_sidebar: 'File Versions',
                search: false,
                apiurl: 'api/confmanager/diff/list/',
                extra: {
                    file: ''
                }
            }
        };
        this.native_preview = new rxjs_1.BehaviorSubject('');
        this.files = {
            a: {
                version: new rxjs_1.BehaviorSubject([]),
                diff: new rxjs_1.BehaviorSubject([])
            },
            b: {
                version: new rxjs_1.BehaviorSubject([]),
                diff: new rxjs_1.BehaviorSubject([])
            }
        };
    }
    PreviewComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.route.paramMap.pipe(operators_1.first()).subscribe(function (params) {
            _this.filePath = params.get('file');
            _this.list.file_a.extra.file = params.get('file');
            _this.list.file_b.extra.file = params.get('file');
            _this.formInit(params.get('file'));
        });
    };
    PreviewComponent.prototype.formInit = function (file) {
        var _this = this;
        this.service.commitList({ file: file }).subscribe(function (data) {
            console.log(data);
            if (!data.results || data.results.length == 0) {
                _this.toastr.error('No commits found');
                return;
            }
            _this.files.a.version.next([data.results[0]]);
            _this.files.b.version.next((data.results[1]) ? [data.results[1]] : [data.results[0]]);
            _this.preview();
            //console.log(this.files)
        });
    };
    PreviewComponent.prototype.preview = function () {
        var _this = this;
        this.loading = new rxjs_1.BehaviorSubject(true);
        this.tacacsLogRun();
        this.files.a.diff.next([]);
        this.files.b.diff.next([]);
        this.native_preview.next('');
        var styleSheet = document.styleSheets[0];
        var data = {
            hash_a: this.files.a.version.getValue()[0].hash,
            hash_b: this.files.b.version.getValue()[0].hash,
            filename: this.filePath,
            // filename_b: 'router_12__1_1',
            type: this.previewType,
            context: this.context[this.previewType] || 3
        };
        this.service.previewInit(data).subscribe(function (data) {
            _this.loading = new rxjs_1.BehaviorSubject(false);
            console.log(data);
            if (_this.previewType == 'native') {
                _this.native_preview.next(data.native);
                return;
            }
            if (_this.previewType == 'preview') {
                _this.native_preview.next(data.show);
                return;
            }
            if (!data.diff) {
                _this.files.a.diff.next(['No difference']);
                return;
            }
            if (data.diff.chunk_list) {
                for (var i = 0; i < data.diff.chunk_list.counters.length; i++) {
                    console.log(data.diff.chunk_list.counters[i]);
                    styleSheet.insertRule('.chunk.' + data.diff.chunk_list.counters[i] + ':before ' +
                        '{ counter-increment: ' + data.diff.chunk_list.counters[i] + '; content: counter(' + data.diff.chunk_list.counters[i] + '); }', styleSheet.cssRules.length);
                }
                _this.chunk_list.a.next(data.diff.chunk_list.file_a.join(' '));
                _this.chunk_list.b.next(data.diff.chunk_list.file_b.join(' '));
            }
            _this.files.a.diff.next(data.diff.file_a);
            _this.files.b.diff.next(data.diff.file_b);
            _this.loading = new rxjs_1.BehaviorSubject(false);
        });
    };
    PreviewComponent.prototype.tacacsLogRun = function () {
        var _this = this;
        this.deviceInfo.next({ id: 0, ipaddress: '' });
        this.tacacsUsers.next([]);
        if (this.previewType != 'brief' && this.previewType != 'native')
            return;
        this.service.pleaseGiveMeTacacs({
            filename: this.filePath,
            date_a: this.files.a.version.getValue()[0].id,
            date_b: this.files.b.version.getValue()[0].id
        }).subscribe(function (data) {
            console.log(data);
            if (data.info)
                _this.deviceInfo.next(data.info);
            if (data.users && data.users.length) {
                _this.tacacsUsers.next(data.users);
                _this.loadUser(data.users[0].username);
            }
            //console.log(this.deviceInfo.getValue())
        });
    };
    PreviewComponent.prototype.changeTacLog = function (e) {
        this.tacLogType = e.nextId;
        this.loadUser(this.tacUsername);
    };
    PreviewComponent.prototype.loadUser = function (username) {
        var _this = this;
        this.tacUsername = username;
        var data = {
            username: username,
            ip: this.deviceInfo.getValue().ipaddress,
            date_a: this.files.a.version.getValue()[0].id,
            date_b: this.files.b.version.getValue()[0].id,
            section: this.tacLogType
        };
        console.log(data);
        this.service.pleaseGiveMeTacacsLog(data).subscribe(function (data) {
            console.log(data);
            _this.tacacsLog.next(data.log);
        });
    };
    PreviewComponent.prototype.setFile = function (data, type) {
        if (type === void 0) { type = 'A'; }
        if (type == 'A')
            this.files.a.version.next(data);
        else
            this.files.b.version.next(data);
        console.log(data);
        this.preview();
    };
    PreviewComponent = __decorate([
        core_1.Component({
            selector: 'kt-preview',
            template: __webpack_require__(/*! ./preview.component.html */ "./src/app/views/pages/confmanager/preview/preview.component.html"),
            encapsulation: core_1.ViewEncapsulation.None,
            styles: [__webpack_require__(/*! ./preview.component.scss */ "./src/app/views/pages/confmanager/preview/preview.component.scss")]
        }),
        __metadata("design:paramtypes", [ngx_toastr_1.ToastrService,
            preview_service_1.PreviewService,
            router_1.Router,
            router_1.ActivatedRoute])
    ], PreviewComponent);
    return PreviewComponent;
}());
exports.PreviewComponent = PreviewComponent;


/***/ })

}]);
//# sourceMappingURL=app-views-pages-confmanager-confmanager-module.e00621b9a22e70861f21.js.map