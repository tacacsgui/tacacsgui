(window.webpackJsonp=window.webpackJsonp||[]).push([[17],{kIFp:function(l,n,u){"use strict";u.r(n);var e=u("CcnG"),t=function(){return function(){}}(),a=u("pMnS"),s=u("9AJC"),d=u("Ip0R"),i=u("i+/5"),r=u("kl+L"),c=u("A2Ik"),o=u("ZYCi"),h=u("26FU"),p=u("P6uZ"),g=u("67Y/"),b=u("t/Na"),f=function(){function l(l){this.http=l}return l.prototype.get=function(){return this.http.get("api/tacacs/reports/general/",{}).pipe(Object(p.a)(),Object(g.a)(function(l){return l}))},l.prototype.checkUpdate=function(){return this.http.post("api/update/",{}).pipe(Object(p.a)(),Object(g.a)(function(l){return l}))},l.ngInjectableDef=e["\u0275\u0275defineInjectable"]({factory:function(){return new l(e["\u0275\u0275inject"](b.c))},token:l,providedIn:"root"}),l}(),v=u("9fK0"),m=function(){function l(l,n){this.service=l,this.service_=n,this.widgets={api:{text:new h.a("...")},tac_plus:{text:new h.a("...")},users:{text:new h.a("..."),url:"/tacacs/users"},devices:{text:new h.a("..."),url:"/tacacs/devices"},bad_authe:{text:new h.a("..."),url:"/reports/authe"},authe:{text:new h.a("..."),url:"/reports/authe"},autho:{text:new h.a("..."),url:"/reports/autho"},acc:{text:new h.a("..."),url:"/reports/acc"},ha:{text:new h.a("..."),url:"/"},tac_status:{text:new h.a("..."),url:"/tacacs/config/global"}},this.ha={config:{},slaves:[],master:[],db:"",api:""}}return l.prototype.ngOnInit=function(){var l=this;this.service.get().subscribe(function(n){n.widgets[0].update_&&l.checkUpdate(),l.widgets.users.text.next(n.widgets[0].users),l.widgets.devices.text.next(n.widgets[0].devices),l.widgets.api.text.next(n.widgets[0].APIVER),l.widgets.tac_plus.text.next(n.widgets[0].TACVER),l.widgets.bad_authe.text.next(n.widgets[0].authe_err),l.widgets.authe.text.next(n.widgets[0].authe),l.widgets.autho.text.next(n.widgets[0].autho),l.widgets.acc.text.next(n.widgets[0].acc),l.widgets.ha.text.next(n.widgets[0].ha),l.widgets.tac_status.text.next(n.widgets[0].tac_status),l.ha=n.ha})},l.prototype.checkUpdate=function(){var l=this;this.service.checkUpdate().subscribe(function(n){n.output.client_version!==n.output.last_version.version&&(l.service_.update=!0)})},l}(),C=e["\u0275crt"]({encapsulation:0,styles:[[""]],data:{}});function y(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,1,"span",[["class","kt-badge kt-badge--success kt-badge--inline"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["master"]))],null,null)}function k(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,1,"span",[["class","kt-badge kt-badge--warning kt-badge--inline"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["slave"]))],null,null)}function w(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,1,"span",[["class","kt-badge"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["none"]))],null,null)}function x(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,2,null,null,null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,1,"span",[["class","kt-badge kt-badge--danger kt-badge--inline"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["out of sync"]))],null,null)}function R(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,2,null,null,null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,1,"span",[["class","kt-badge kt-badge--success kt-badge--inline"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["synced"]))],null,null)}function _(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,2,null,null,null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,1,"span",[["class","kt-badge kt-badge--danger kt-badge--inline"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["out of sync"]))],null,null)}function D(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,2,null,null,null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,1,"span",[["class","kt-badge kt-badge--success kt-badge--inline"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["sync"]))],null,null)}function I(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,2,null,null,null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,1,"span",[["class","kt-badge kt-badge--danger kt-badge--inline"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["out of sync"]))],null,null)}function L(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,2,null,null,null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,1,"span",[["class","kt-badge kt-badge--success kt-badge--inline"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["ready"]))],null,null)}function A(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,22,null,null,null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,21,"tr",[],null,null,null,null,null)),(l()(),e["\u0275eld"](2,0,null,null,1,"td",[],null,null,null,null,null)),(l()(),e["\u0275ted"](3,null,["",""])),(l()(),e["\u0275eld"](4,0,null,null,1,"td",[],null,null,null,null,null)),(l()(),e["\u0275ted"](5,null,["",""])),(l()(),e["\u0275eld"](6,0,null,null,4,"td",[],null,null,null,null,null)),(l()(),e["\u0275and"](16777216,null,null,1,null,x)),e["\u0275did"](8,16384,null,0,d.NgIf,[e.ViewContainerRef,e.TemplateRef],{ngIf:[0,"ngIf"]},null),(l()(),e["\u0275and"](16777216,null,null,1,null,R)),e["\u0275did"](10,16384,null,0,d.NgIf,[e.ViewContainerRef,e.TemplateRef],{ngIf:[0,"ngIf"]},null),(l()(),e["\u0275eld"](11,0,null,null,4,"td",[],null,null,null,null,null)),(l()(),e["\u0275and"](16777216,null,null,1,null,_)),e["\u0275did"](13,16384,null,0,d.NgIf,[e.ViewContainerRef,e.TemplateRef],{ngIf:[0,"ngIf"]},null),(l()(),e["\u0275and"](16777216,null,null,1,null,D)),e["\u0275did"](15,16384,null,0,d.NgIf,[e.ViewContainerRef,e.TemplateRef],{ngIf:[0,"ngIf"]},null),(l()(),e["\u0275eld"](16,0,null,null,4,"td",[],null,null,null,null,null)),(l()(),e["\u0275and"](16777216,null,null,1,null,I)),e["\u0275did"](18,16384,null,0,d.NgIf,[e.ViewContainerRef,e.TemplateRef],{ngIf:[0,"ngIf"]},null),(l()(),e["\u0275and"](16777216,null,null,1,null,L)),e["\u0275did"](20,16384,null,0,d.NgIf,[e.ViewContainerRef,e.TemplateRef],{ngIf:[0,"ngIf"]},null),(l()(),e["\u0275eld"](21,0,null,null,1,"td",[],null,null,null,null,null)),(l()(),e["\u0275ted"](22,null,["",""]))],function(l,n){var u=n.component;l(n,8,0,n.context.$implicit.db!=u.ha.db),l(n,10,0,n.context.$implicit.db==u.ha.db),l(n,13,0,n.context.$implicit.cfg!=u.ha.config.cfg),l(n,15,0,n.context.$implicit.cfg==u.ha.config.cfg),l(n,18,0,99!=n.context.$implicit.status),l(n,20,0,99==n.context.$implicit.status)},function(l,n){l(n,3,0,n.context.$implicit.ip),l(n,5,0,n.context.$implicit.api),l(n,22,0,n.context.$implicit.date)})}function S(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,26,"div",[["class","row"]],null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,25,"div",[["class","col-lg-8 col-xs-12 col-md-12"]],null,null,null,null,null)),(l()(),e["\u0275eld"](2,0,null,null,24,"div",[["class","card m-2"]],null,null,null,null,null)),(l()(),e["\u0275eld"](3,0,null,null,23,"div",[["class","card-body"]],null,null,null,null,null)),(l()(),e["\u0275eld"](4,0,null,null,3,"h5",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["High Availability "])),(l()(),e["\u0275eld"](6,0,null,null,1,"small",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["slave list"])),(l()(),e["\u0275eld"](8,0,null,null,18,"div",[["class","table-responsive"]],null,null,null,null,null)),(l()(),e["\u0275eld"](9,0,null,null,17,"table",[["class","table"]],null,null,null,null,null)),(l()(),e["\u0275eld"](10,0,null,null,13,"thead",[],null,null,null,null,null)),(l()(),e["\u0275eld"](11,0,null,null,12,"tr",[],null,null,null,null,null)),(l()(),e["\u0275eld"](12,0,null,null,1,"th",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["IP Address"])),(l()(),e["\u0275eld"](14,0,null,null,1,"th",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["API"])),(l()(),e["\u0275eld"](16,0,null,null,1,"th",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["DB Check"])),(l()(),e["\u0275eld"](18,0,null,null,1,"th",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Cfg Check"])),(l()(),e["\u0275eld"](20,0,null,null,1,"th",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Status"])),(l()(),e["\u0275eld"](22,0,null,null,1,"th",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Last Check"])),(l()(),e["\u0275eld"](24,0,null,null,2,"tbody",[],null,null,null,null,null)),(l()(),e["\u0275and"](16777216,null,null,1,null,A)),e["\u0275did"](26,278528,null,0,d.NgForOf,[e.ViewContainerRef,e.TemplateRef,e.IterableDiffers],{ngForOf:[0,"ngForOf"]},null)],function(l,n){l(n,26,0,n.component.ha.slaves)},null)}function T(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,108,"div",[["class","row"]],null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,35,"div",[["class","col-lg-3 col-xs-12 col-md-6"]],null,null,null,null,null)),(l()(),e["\u0275eld"](2,0,null,null,34,"div",[["class","card m-2"],["style","min-height: 200px;"]],null,null,null,null,null)),(l()(),e["\u0275eld"](3,0,null,null,33,"div",[["class","card-body"]],null,null,null,null,null)),(l()(),e["\u0275eld"](4,0,null,null,1,"h5",[["class","card-title"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["System Info"])),(l()(),e["\u0275eld"](6,0,null,null,5,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](7,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Time: "])),(l()(),e["\u0275eld"](9,0,null,null,2,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275eld"](10,0,null,null,1,"kt-clock",[],null,null,null,i.b,i.a)),e["\u0275did"](11,245760,null,0,r.a,[c.a],null,null),(l()(),e["\u0275eld"](12,0,null,null,5,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](13,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["API: "])),(l()(),e["\u0275eld"](15,0,null,null,2,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275ted"](16,null,["",""])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](18,0,null,null,5,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](19,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["TAC: "])),(l()(),e["\u0275eld"](21,0,null,null,2,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275ted"](22,null,["",""])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](24,0,null,null,12,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](25,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["HA Role: "])),(l()(),e["\u0275eld"](27,0,null,null,9,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275eld"](28,0,null,null,8,null,null,null,null,null,null,null)),e["\u0275did"](29,16384,null,0,d.NgSwitch,[],{ngSwitch:[0,"ngSwitch"]},null),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275and"](16777216,null,null,1,null,y)),e["\u0275did"](32,278528,null,0,d.NgSwitchCase,[e.ViewContainerRef,e.TemplateRef,d.NgSwitch],{ngSwitchCase:[0,"ngSwitchCase"]},null),(l()(),e["\u0275and"](16777216,null,null,1,null,k)),e["\u0275did"](34,278528,null,0,d.NgSwitchCase,[e.ViewContainerRef,e.TemplateRef,d.NgSwitch],{ngSwitchCase:[0,"ngSwitchCase"]},null),(l()(),e["\u0275and"](16777216,null,null,1,null,w)),e["\u0275did"](36,16384,null,0,d.NgSwitchDefault,[e.ViewContainerRef,e.TemplateRef,d.NgSwitch],null,null),(l()(),e["\u0275eld"](37,0,null,null,34,"div",[["class","col-lg-2 col-xs-12 col-md-6"]],null,null,null,null,null)),(l()(),e["\u0275eld"](38,0,null,null,33,"div",[["class","card m-2"],["style","min-height: 200px;"]],null,null,null,null,null)),(l()(),e["\u0275eld"](39,0,null,null,32,"div",[["class","card-body"]],null,null,null,null,null)),(l()(),e["\u0275eld"](40,0,null,null,1,"h5",[["class","card-title"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Tac_Plus Info"])),(l()(),e["\u0275eld"](42,0,null,null,12,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](43,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Status: "])),(l()(),e["\u0275eld"](45,0,null,null,9,"a",[],[[1,"target",0],[8,"href",4]],[[null,"click"]],function(l,n,u){var t=!0;return"click"===n&&(t=!1!==e["\u0275nov"](l,46).onClick(u.button,u.ctrlKey,u.metaKey,u.shiftKey)&&t),t},null,null)),e["\u0275did"](46,671744,null,0,o.s,[o.q,o.a,d.LocationStrategy],{routerLink:[0,"routerLink"]},null),(l()(),e["\u0275eld"](47,0,null,null,7,"span",[["class","pull-right kt-badge kt-badge--inline kt-badge--pill kt-badge--wide"]],null,null,null,null,null)),e["\u0275prd"](512,null,d["\u0275NgClassImpl"],d["\u0275NgClassR2Impl"],[e.IterableDiffers,e.KeyValueDiffers,e.ElementRef,e.Renderer2]),e["\u0275did"](49,278528,null,0,d.NgClass,[d["\u0275NgClassImpl"]],{klass:[0,"klass"],ngClass:[1,"ngClass"]},null),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),e["\u0275pod"](52,{"kt-badge--success":0,"kt-badge--warning":1}),(l()(),e["\u0275ted"](53,null,[" "," "])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](55,0,null,null,7,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](56,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Users: "])),(l()(),e["\u0275eld"](58,0,null,null,4,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275eld"](59,0,null,null,3,"a",[],[[1,"target",0],[8,"href",4]],[[null,"click"]],function(l,n,u){var t=!0;return"click"===n&&(t=!1!==e["\u0275nov"](l,60).onClick(u.button,u.ctrlKey,u.metaKey,u.shiftKey)&&t),t},null,null)),e["\u0275did"](60,671744,null,0,o.s,[o.q,o.a,d.LocationStrategy],{routerLink:[0,"routerLink"]},null),(l()(),e["\u0275ted"](61,null,["",""])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](63,0,null,null,7,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](64,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Devices: "])),(l()(),e["\u0275eld"](66,0,null,null,4,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275eld"](67,0,null,null,3,"a",[],[[1,"target",0],[8,"href",4]],[[null,"click"]],function(l,n,u){var t=!0;return"click"===n&&(t=!1!==e["\u0275nov"](l,68).onClick(u.button,u.ctrlKey,u.metaKey,u.shiftKey)&&t),t},null,null)),e["\u0275did"](68,671744,null,0,o.s,[o.q,o.a,d.LocationStrategy],{routerLink:[0,"routerLink"]},null),(l()(),e["\u0275ted"](69,null,["",""])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](71,0,null,null,0,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](72,0,null,null,36,"div",[["class","col-lg-3 col-xs-12 col-md-6"]],null,null,null,null,null)),(l()(),e["\u0275eld"](73,0,null,null,35,"div",[["class","card m-2"],["style","min-height: 200px;"]],null,null,null,null,null)),(l()(),e["\u0275eld"](74,0,null,null,34,"div",[["class","card-body"]],null,null,null,null,null)),(l()(),e["\u0275eld"](75,0,null,null,1,"h5",[["class","card-title"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Reports"])),(l()(),e["\u0275eld"](77,0,null,null,7,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](78,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Authe Total: "])),(l()(),e["\u0275eld"](80,0,null,null,4,"a",[],[[1,"target",0],[8,"href",4]],[[null,"click"]],function(l,n,u){var t=!0;return"click"===n&&(t=!1!==e["\u0275nov"](l,81).onClick(u.button,u.ctrlKey,u.metaKey,u.shiftKey)&&t),t},null,null)),e["\u0275did"](81,671744,null,0,o.s,[o.q,o.a,d.LocationStrategy],{routerLink:[0,"routerLink"]},null),(l()(),e["\u0275eld"](82,0,null,null,2,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275ted"](83,null,["",""])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](85,0,null,null,7,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](86,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Autho Total: "])),(l()(),e["\u0275eld"](88,0,null,null,4,"a",[],[[1,"target",0],[8,"href",4]],[[null,"click"]],function(l,n,u){var t=!0;return"click"===n&&(t=!1!==e["\u0275nov"](l,89).onClick(u.button,u.ctrlKey,u.metaKey,u.shiftKey)&&t),t},null,null)),e["\u0275did"](89,671744,null,0,o.s,[o.q,o.a,d.LocationStrategy],{routerLink:[0,"routerLink"]},null),(l()(),e["\u0275eld"](90,0,null,null,2,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275ted"](91,null,["",""])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](93,0,null,null,7,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](94,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Acc Total: "])),(l()(),e["\u0275eld"](96,0,null,null,4,"a",[],[[1,"target",0],[8,"href",4]],[[null,"click"]],function(l,n,u){var t=!0;return"click"===n&&(t=!1!==e["\u0275nov"](l,97).onClick(u.button,u.ctrlKey,u.metaKey,u.shiftKey)&&t),t},null,null)),e["\u0275did"](97,671744,null,0,o.s,[o.q,o.a,d.LocationStrategy],{routerLink:[0,"routerLink"]},null),(l()(),e["\u0275eld"](98,0,null,null,2,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275ted"](99,null,["",""])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](101,0,null,null,7,"p",[["class","card-text"]],null,null,null,null,null)),(l()(),e["\u0275eld"](102,0,null,null,1,"b",[],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Bad Authe: "])),(l()(),e["\u0275eld"](104,0,null,null,4,"a",[],[[1,"target",0],[8,"href",4]],[[null,"click"]],function(l,n,u){var t=!0;return"click"===n&&(t=!1!==e["\u0275nov"](l,105).onClick(u.button,u.ctrlKey,u.metaKey,u.shiftKey)&&t),t},null,null)),e["\u0275did"](105,671744,null,0,o.s,[o.q,o.a,d.LocationStrategy],{routerLink:[0,"routerLink"]},null),(l()(),e["\u0275eld"](106,0,null,null,2,"span",[["class","pull-right"]],null,null,null,null,null)),(l()(),e["\u0275ted"](107,null,["",""])),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275and"](16777216,null,null,1,null,S)),e["\u0275did"](110,16384,null,0,d.NgIf,[e.ViewContainerRef,e.TemplateRef],{ngIf:[0,"ngIf"]},null)],function(l,n){var u=n.component;l(n,11,0),l(n,29,0,e["\u0275unv"](n,29,0,e["\u0275nov"](n,30).transform(u.widgets.ha.text))),l(n,32,0,1),l(n,34,0,2),l(n,46,0,u.widgets.tac_status.url);var t=l(n,52,0,"active"==e["\u0275unv"](n,49,1,e["\u0275nov"](n,50).transform(u.widgets.tac_status.text)),"active"!=e["\u0275unv"](n,49,1,e["\u0275nov"](n,51).transform(u.widgets.tac_status.text)));l(n,49,0,"pull-right kt-badge kt-badge--inline kt-badge--pill kt-badge--wide",t),l(n,60,0,u.widgets.users.url),l(n,68,0,u.widgets.devices.url),l(n,81,0,u.widgets.authe.url),l(n,89,0,u.widgets.autho.url),l(n,97,0,u.widgets.acc.url),l(n,105,0,u.widgets.bad_authe.url),l(n,110,0,u.ha.slaves.length>0)},function(l,n){var u=n.component;l(n,16,0,e["\u0275unv"](n,16,0,e["\u0275nov"](n,17).transform(u.widgets.api.text))),l(n,22,0,e["\u0275unv"](n,22,0,e["\u0275nov"](n,23).transform(u.widgets.tac_plus.text))),l(n,45,0,e["\u0275nov"](n,46).target,e["\u0275nov"](n,46).href),l(n,53,0,e["\u0275unv"](n,53,0,e["\u0275nov"](n,54).transform(u.widgets.tac_status.text))),l(n,59,0,e["\u0275nov"](n,60).target,e["\u0275nov"](n,60).href),l(n,61,0,e["\u0275unv"](n,61,0,e["\u0275nov"](n,62).transform(u.widgets.users.text))),l(n,67,0,e["\u0275nov"](n,68).target,e["\u0275nov"](n,68).href),l(n,69,0,e["\u0275unv"](n,69,0,e["\u0275nov"](n,70).transform(u.widgets.devices.text))),l(n,80,0,e["\u0275nov"](n,81).target,e["\u0275nov"](n,81).href),l(n,83,0,e["\u0275unv"](n,83,0,e["\u0275nov"](n,84).transform(u.widgets.authe.text))),l(n,88,0,e["\u0275nov"](n,89).target,e["\u0275nov"](n,89).href),l(n,91,0,e["\u0275unv"](n,91,0,e["\u0275nov"](n,92).transform(u.widgets.autho.text))),l(n,96,0,e["\u0275nov"](n,97).target,e["\u0275nov"](n,97).href),l(n,99,0,e["\u0275unv"](n,99,0,e["\u0275nov"](n,100).transform(u.widgets.acc.text))),l(n,104,0,e["\u0275nov"](n,105).target,e["\u0275nov"](n,105).href),l(n,107,0,e["\u0275unv"](n,107,0,e["\u0275nov"](n,108).transform(u.widgets.bad_authe.text)))})}var O=u("Zseb"),K=function(){function l(l){this.http=l}return l.prototype.get=function(){return this.http.get("api/tacacs/widget/chart/auth/",{}).pipe(Object(p.a)(),Object(g.a)(function(l){return l}))},l.ngInjectableDef=e["\u0275\u0275defineInjectable"]({factory:function(){return new l(e["\u0275\u0275inject"](b.c))},token:l,providedIn:"root"}),l}(),N=function(){function l(l){this.service=l,this.barChartOptions_authe={scaleShowVerticalLines:!1,responsive:!0,scales:{yAxes:[{display:!0,scaleLabel:{display:!0,labelString:"Authentication"},ticks:{beginAtZero:!0,userCallback:function(l,n,u){if(Math.floor(l)===l)return l}}}]}},this.barChartOptions_autho={scaleShowVerticalLines:!1,responsive:!0,scales:{yAxes:[{display:!0,scaleLabel:{display:!0,labelString:"Authorization"},ticks:{beginAtZero:!0,userCallback:function(l,n,u){if(Math.floor(l)===l)return l}}}]}},this.barChartLabels=[],this.labels=new h.a([]),this.barChartType="line",this.barChartLegend=!0,this.barChartData_authe=[{data:[],label:"Fail",fill:!1},{data:[],label:"Success",fill:!1}],this.barChartData_autho=[{data:[],label:"Fail",fill:!1},{data:[],label:"Success",fill:!1}]}return l.prototype.ngOnInit=function(){var l=this;this.service.get().subscribe(function(n){l.barChartData_authe[0].data=n.authe.chart.f,l.barChartData_authe[1].data=n.authe.chart.s,l.barChartData_autho[0].data=n.autho.chart.f,l.barChartData_autho[1].data=n.autho.chart.s,l.labels.next(n.time_range)})},l}(),P=e["\u0275crt"]({encapsulation:0,styles:[[""]],data:{}});function j(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,20,"div",[["class","row"]],null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,9,"div",[["class","col-lg-4 col-md-12"]],null,null,null,null,null)),(l()(),e["\u0275eld"](2,0,null,null,8,"div",[["class","card m-2"]],null,null,null,null,null)),(l()(),e["\u0275eld"](3,0,null,null,7,"div",[["class","card-body"]],null,null,null,null,null)),(l()(),e["\u0275eld"](4,0,null,null,1,"h5",[["class","card-title"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Authentication Stats"])),(l()(),e["\u0275eld"](6,0,null,null,1,"h6",[["class","card-subtitle mb-2 text-muted"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["authentication per week"])),(l()(),e["\u0275eld"](8,0,null,null,2,"canvas",[["baseChart",""]],null,null,null,null,null)),e["\u0275did"](9,999424,null,0,O.a,[e.ElementRef,O.c],{datasets:[0,"datasets"],labels:[1,"labels"],options:[2,"options"],chartType:[3,"chartType"],legend:[4,"legend"]},null),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](11,0,null,null,9,"div",[["class","col-lg-4 col-md-12"]],null,null,null,null,null)),(l()(),e["\u0275eld"](12,0,null,null,8,"div",[["class","card m-2"]],null,null,null,null,null)),(l()(),e["\u0275eld"](13,0,null,null,7,"div",[["class","card-body"]],null,null,null,null,null)),(l()(),e["\u0275eld"](14,0,null,null,1,"h5",[["class","card-title"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Authorization Stats"])),(l()(),e["\u0275eld"](16,0,null,null,1,"h6",[["class","card-subtitle mb-2 text-muted"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["authorization per week"])),(l()(),e["\u0275eld"](18,0,null,null,2,"canvas",[["baseChart",""]],null,null,null,null,null)),e["\u0275did"](19,999424,null,0,O.a,[e.ElementRef,O.c],{datasets:[0,"datasets"],labels:[1,"labels"],options:[2,"options"],chartType:[3,"chartType"],legend:[4,"legend"]},null),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef])],function(l,n){var u=n.component;l(n,9,0,u.barChartData_authe,e["\u0275unv"](n,9,1,e["\u0275nov"](n,10).transform(u.labels)),u.barChartOptions_authe,u.barChartType,u.barChartLegend),l(n,19,0,u.barChartData_autho,e["\u0275unv"](n,19,1,e["\u0275nov"](n,20).transform(u.labels)),u.barChartOptions_autho,u.barChartType,u.barChartLegend)},null)}var V=function(){function l(l){this.http=l}return l.prototype.get=function(l){var n=(new b.j).set("users",l.users.toString()).set("devices",l.devices.toString()).set("usersReload",l.usersReload.toString()).set("devicesReload",l.devicesReload.toString());return this.http.get("api/tacacs/reports/top/access/",{params:n}).pipe(Object(p.a)(),Object(g.a)(function(l){return l}))},l.ngInjectableDef=e["\u0275\u0275defineInjectable"]({factory:function(){return new l(e["\u0275\u0275inject"](b.c))},token:l,providedIn:"root"}),l}(),F=function(){function l(l){this.service=l,this.chartColors=["rgb(255, 99, 132)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(201, 203, 207)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(255, 159, 64)"],this.barChartLabels_devices=[],this.barChartLabels=[],this.device_labels=new h.a(this.barChartLabels_devices),this.user_labels=new h.a(this.barChartLabels),this.barChartOptions={scaleShowVerticalLines:!1,responsive:!0},this.barChartType="pie",this.barChartLegend=!0,this.barChartData=[{data:[],label:"Users",backgroundColor:this.chartColors}],this.barChartData_devices=[{data:[],label:"Devices",backgroundColor:this.chartColors}],this.set={users:5,devices:5,usersReload:1,devicesReload:1}}return l.prototype.ngOnInit=function(){var l=this;this.service.get(this.set).subscribe(function(n){l.barChartLabels=[],l.barChartData[0].data=[],l.barChartLabels_devices=[],l.barChartData_devices[0].data=[];for(var u=0;u<n.topUsers.length;u++)l.barChartLabels.push(n.topUsers[u].label),l.barChartData[0].data.push(n.topUsers[u].count);for(u=0;u<n.topDevices.length;u++)l.barChartLabels_devices.push(n.topDevices[u].label),l.barChartData_devices[0].data.push(n.topDevices[u].count);l.device_labels.next(l.barChartLabels_devices),l.user_labels.next(l.barChartLabels)})},l}(),U=e["\u0275crt"]({encapsulation:0,styles:[[""]],data:{}});function z(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,20,"div",[["class","row"]],null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,9,"div",[["class","col-lg-4 col-md-12"]],null,null,null,null,null)),(l()(),e["\u0275eld"](2,0,null,null,8,"div",[["class","card m-2"]],null,null,null,null,null)),(l()(),e["\u0275eld"](3,0,null,null,7,"div",[["class","card-body"]],null,null,null,null,null)),(l()(),e["\u0275eld"](4,0,null,null,1,"h5",[["class","card-title"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Top 5 Active Users"])),(l()(),e["\u0275eld"](6,0,null,null,1,"h6",[["class","card-subtitle mb-2 text-muted"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["number of authentication per week"])),(l()(),e["\u0275eld"](8,0,[["topUsers",1]],null,2,"canvas",[["baseChart",""]],null,null,null,null,null)),e["\u0275did"](9,999424,null,0,O.a,[e.ElementRef,O.c],{datasets:[0,"datasets"],labels:[1,"labels"],options:[2,"options"],chartType:[3,"chartType"],legend:[4,"legend"]},null),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef]),(l()(),e["\u0275eld"](11,0,null,null,9,"div",[["class","col-lg-4 col-md-12"]],null,null,null,null,null)),(l()(),e["\u0275eld"](12,0,null,null,8,"div",[["class","card m-2"]],null,null,null,null,null)),(l()(),e["\u0275eld"](13,0,null,null,7,"div",[["class","card-body"]],null,null,null,null,null)),(l()(),e["\u0275eld"](14,0,null,null,1,"h5",[["class","card-title"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["Top 5 Used Devices"])),(l()(),e["\u0275eld"](16,0,null,null,1,"h6",[["class","card-subtitle mb-2 text-muted"]],null,null,null,null,null)),(l()(),e["\u0275ted"](-1,null,["number of authentication per week"])),(l()(),e["\u0275eld"](18,0,[["topDevices",1]],null,2,"canvas",[["baseChart",""]],null,null,null,null,null)),e["\u0275did"](19,999424,null,0,O.a,[e.ElementRef,O.c],{datasets:[0,"datasets"],labels:[1,"labels"],options:[2,"options"],chartType:[3,"chartType"],legend:[4,"legend"]},null),e["\u0275pid"](131072,d.AsyncPipe,[e.ChangeDetectorRef])],function(l,n){var u=n.component;l(n,9,0,u.barChartData,e["\u0275unv"](n,9,1,e["\u0275nov"](n,10).transform(u.user_labels)),u.barChartOptions,u.barChartType,u.barChartLegend),l(n,19,0,u.barChartData_devices,e["\u0275unv"](n,19,1,e["\u0275nov"](n,20).transform(u.device_labels)),u.barChartOptions,u.barChartType,u.barChartLegend)},null)}var q=function(){function l(){}return l.prototype.ngOnInit=function(){},l}(),E=e["\u0275crt"]({encapsulation:0,styles:[["[_nghost-%COMP%]     ngb-tabset>.nav-tabs{display:none}"]],data:{}});function $(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,6,"div",[["class","m-3"]],null,null,null,null,null)),(l()(),e["\u0275eld"](1,0,null,null,1,"kt-w-system-info",[],null,null,null,T,C)),e["\u0275did"](2,114688,null,0,m,[f,v.a],null,null),(l()(),e["\u0275eld"](3,0,null,null,1,"kt-w-auth-linechart",[],null,null,null,j,P)),e["\u0275did"](4,114688,null,0,N,[K],null,null),(l()(),e["\u0275eld"](5,0,null,null,1,"kt-w-auth-piechart",[],null,null,null,z,U)),e["\u0275did"](6,114688,null,0,F,[V],null,null)],function(l,n){l(n,2,0),l(n,4,0),l(n,6,0)},null)}function M(l){return e["\u0275vid"](0,[(l()(),e["\u0275eld"](0,0,null,null,1,"kt-dashboard",[],null,null,null,$,E)),e["\u0275did"](1,114688,null,0,q,[],null,null)],function(l,n){l(n,1,0)},null)}var Z=e["\u0275ccf"]("kt-dashboard",q,M,{},{},[]),J=u("gIcY"),G=u("4GxJ"),Y=u("gk6K"),H=u("F+oH"),B=u("yYhs"),Q=u("2rQ4");u.d(n,"DashboardModuleNgFactory",function(){return W});var W=e["\u0275cmf"](t,[],function(l){return e["\u0275mod"]([e["\u0275mpd"](512,e.ComponentFactoryResolver,e["\u0275CodegenComponentFactoryResolver"],[[8,[a.a,s.a,s.b,s.p,s.q,s.m,s.n,s.o,Z]],[3,e.ComponentFactoryResolver],e.NgModuleRef]),e["\u0275mpd"](4608,d.NgLocalization,d.NgLocaleLocalization,[e.LOCALE_ID,[2,d["\u0275angular_packages_common_common_a"]]]),e["\u0275mpd"](4608,J.A,J.A,[]),e["\u0275mpd"](4608,G.D,G.D,[e.ComponentFactoryResolver,e.Injector,G.xb,G.E]),e["\u0275mpd"](4608,Y.a,Y.a,[]),e["\u0275mpd"](1073742336,d.CommonModule,d.CommonModule,[]),e["\u0275mpd"](1073742336,o.t,o.t,[[2,o.z],[2,o.q]]),e["\u0275mpd"](1073742336,O.b,O.b,[]),e["\u0275mpd"](1073742336,H.a,H.a,[]),e["\u0275mpd"](1073742336,B.a,B.a,[]),e["\u0275mpd"](1073742336,G.c,G.c,[]),e["\u0275mpd"](1073742336,G.g,G.g,[]),e["\u0275mpd"](1073742336,G.h,G.h,[]),e["\u0275mpd"](1073742336,G.l,G.l,[]),e["\u0275mpd"](1073742336,G.n,G.n,[]),e["\u0275mpd"](1073742336,J.z,J.z,[]),e["\u0275mpd"](1073742336,J.k,J.k,[]),e["\u0275mpd"](1073742336,G.t,G.t,[]),e["\u0275mpd"](1073742336,G.z,G.z,[]),e["\u0275mpd"](1073742336,G.F,G.F,[]),e["\u0275mpd"](1073742336,G.J,G.J,[]),e["\u0275mpd"](1073742336,G.O,G.O,[]),e["\u0275mpd"](1073742336,G.R,G.R,[]),e["\u0275mpd"](1073742336,G.U,G.U,[]),e["\u0275mpd"](1073742336,G.Z,G.Z,[]),e["\u0275mpd"](1073742336,G.db,G.db,[]),e["\u0275mpd"](1073742336,G.gb,G.gb,[]),e["\u0275mpd"](1073742336,G.jb,G.jb,[]),e["\u0275mpd"](1073742336,G.G,G.G,[]),e["\u0275mpd"](1073742336,Q.a,Q.a,[]),e["\u0275mpd"](1073742336,t,t,[]),e["\u0275mpd"](1024,o.m,function(){return[[{path:"",component:q}]]},[])])})}}]);