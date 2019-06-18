(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["app-views-pages-gui-gui-module"],{

/***/ "./node_modules/ng2-file-upload/file-upload/file-drop.directive.js":
/*!*************************************************************************!*\
  !*** ./node_modules/ng2-file-upload/file-upload/file-drop.directive.js ***!
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
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var file_uploader_class_1 = __webpack_require__(/*! ./file-uploader.class */ "./node_modules/ng2-file-upload/file-upload/file-uploader.class.js");
var FileDropDirective = (function () {
    function FileDropDirective(element) {
        this.fileOver = new core_1.EventEmitter();
        this.onFileDrop = new core_1.EventEmitter();
        this.element = element;
    }
    FileDropDirective.prototype.getOptions = function () {
        return this.uploader.options;
    };
    FileDropDirective.prototype.getFilters = function () {
        return {};
    };
    FileDropDirective.prototype.onDrop = function (event) {
        var transfer = this._getTransfer(event);
        if (!transfer) {
            return;
        }
        var options = this.getOptions();
        var filters = this.getFilters();
        this._preventAndStop(event);
        this.uploader.addToQueue(transfer.files, options, filters);
        this.fileOver.emit(false);
        this.onFileDrop.emit(transfer.files);
    };
    FileDropDirective.prototype.onDragOver = function (event) {
        var transfer = this._getTransfer(event);
        if (!this._haveFiles(transfer.types)) {
            return;
        }
        transfer.dropEffect = 'copy';
        this._preventAndStop(event);
        this.fileOver.emit(true);
    };
    FileDropDirective.prototype.onDragLeave = function (event) {
        if (this.element) {
            if (event.currentTarget === this.element[0]) {
                return;
            }
        }
        this._preventAndStop(event);
        this.fileOver.emit(false);
    };
    FileDropDirective.prototype._getTransfer = function (event) {
        return event.dataTransfer ? event.dataTransfer : event.originalEvent.dataTransfer; // jQuery fix;
    };
    FileDropDirective.prototype._preventAndStop = function (event) {
        event.preventDefault();
        event.stopPropagation();
    };
    FileDropDirective.prototype._haveFiles = function (types) {
        if (!types) {
            return false;
        }
        if (types.indexOf) {
            return types.indexOf('Files') !== -1;
        }
        else if (types.contains) {
            return types.contains('Files');
        }
        else {
            return false;
        }
    };
    return FileDropDirective;
}());
__decorate([
    core_1.Input(),
    __metadata("design:type", file_uploader_class_1.FileUploader)
], FileDropDirective.prototype, "uploader", void 0);
__decorate([
    core_1.Output(),
    __metadata("design:type", core_1.EventEmitter)
], FileDropDirective.prototype, "fileOver", void 0);
__decorate([
    core_1.Output(),
    __metadata("design:type", core_1.EventEmitter)
], FileDropDirective.prototype, "onFileDrop", void 0);
__decorate([
    core_1.HostListener('drop', ['$event']),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [Object]),
    __metadata("design:returntype", void 0)
], FileDropDirective.prototype, "onDrop", null);
__decorate([
    core_1.HostListener('dragover', ['$event']),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [Object]),
    __metadata("design:returntype", void 0)
], FileDropDirective.prototype, "onDragOver", null);
__decorate([
    core_1.HostListener('dragleave', ['$event']),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [Object]),
    __metadata("design:returntype", Object)
], FileDropDirective.prototype, "onDragLeave", null);
FileDropDirective = __decorate([
    core_1.Directive({ selector: '[ng2FileDrop]' }),
    __metadata("design:paramtypes", [core_1.ElementRef])
], FileDropDirective);
exports.FileDropDirective = FileDropDirective;


/***/ }),

/***/ "./node_modules/ng2-file-upload/file-upload/file-item.class.js":
/*!*********************************************************************!*\
  !*** ./node_modules/ng2-file-upload/file-upload/file-item.class.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var file_like_object_class_1 = __webpack_require__(/*! ./file-like-object.class */ "./node_modules/ng2-file-upload/file-upload/file-like-object.class.js");
var FileItem = (function () {
    function FileItem(uploader, some, options) {
        this.url = '/';
        this.headers = [];
        this.withCredentials = true;
        this.formData = [];
        this.isReady = false;
        this.isUploading = false;
        this.isUploaded = false;
        this.isSuccess = false;
        this.isCancel = false;
        this.isError = false;
        this.progress = 0;
        this.index = void 0;
        this.uploader = uploader;
        this.some = some;
        this.options = options;
        this.file = new file_like_object_class_1.FileLikeObject(some);
        this._file = some;
        if (uploader.options) {
            this.method = uploader.options.method || 'POST';
            this.alias = uploader.options.itemAlias || 'file';
        }
        this.url = uploader.options.url;
    }
    FileItem.prototype.upload = function () {
        try {
            this.uploader.uploadItem(this);
        }
        catch (e) {
            this.uploader._onCompleteItem(this, '', 0, {});
            this.uploader._onErrorItem(this, '', 0, {});
        }
    };
    FileItem.prototype.cancel = function () {
        this.uploader.cancelItem(this);
    };
    FileItem.prototype.remove = function () {
        this.uploader.removeFromQueue(this);
    };
    FileItem.prototype.onBeforeUpload = function () {
        return void 0;
    };
    FileItem.prototype.onBuildForm = function (form) {
        return { form: form };
    };
    FileItem.prototype.onProgress = function (progress) {
        return { progress: progress };
    };
    FileItem.prototype.onSuccess = function (response, status, headers) {
        return { response: response, status: status, headers: headers };
    };
    FileItem.prototype.onError = function (response, status, headers) {
        return { response: response, status: status, headers: headers };
    };
    FileItem.prototype.onCancel = function (response, status, headers) {
        return { response: response, status: status, headers: headers };
    };
    FileItem.prototype.onComplete = function (response, status, headers) {
        return { response: response, status: status, headers: headers };
    };
    FileItem.prototype._onBeforeUpload = function () {
        this.isReady = true;
        this.isUploading = true;
        this.isUploaded = false;
        this.isSuccess = false;
        this.isCancel = false;
        this.isError = false;
        this.progress = 0;
        this.onBeforeUpload();
    };
    FileItem.prototype._onBuildForm = function (form) {
        this.onBuildForm(form);
    };
    FileItem.prototype._onProgress = function (progress) {
        this.progress = progress;
        this.onProgress(progress);
    };
    FileItem.prototype._onSuccess = function (response, status, headers) {
        this.isReady = false;
        this.isUploading = false;
        this.isUploaded = true;
        this.isSuccess = true;
        this.isCancel = false;
        this.isError = false;
        this.progress = 100;
        this.index = void 0;
        this.onSuccess(response, status, headers);
    };
    FileItem.prototype._onError = function (response, status, headers) {
        this.isReady = false;
        this.isUploading = false;
        this.isUploaded = true;
        this.isSuccess = false;
        this.isCancel = false;
        this.isError = true;
        this.progress = 0;
        this.index = void 0;
        this.onError(response, status, headers);
    };
    FileItem.prototype._onCancel = function (response, status, headers) {
        this.isReady = false;
        this.isUploading = false;
        this.isUploaded = false;
        this.isSuccess = false;
        this.isCancel = true;
        this.isError = false;
        this.progress = 0;
        this.index = void 0;
        this.onCancel(response, status, headers);
    };
    FileItem.prototype._onComplete = function (response, status, headers) {
        this.onComplete(response, status, headers);
        if (this.uploader.options.removeAfterUpload) {
            this.remove();
        }
    };
    FileItem.prototype._prepareToUploading = function () {
        this.index = this.index || ++this.uploader._nextIndex;
        this.isReady = true;
    };
    return FileItem;
}());
exports.FileItem = FileItem;


/***/ }),

/***/ "./node_modules/ng2-file-upload/file-upload/file-like-object.class.js":
/*!****************************************************************************!*\
  !*** ./node_modules/ng2-file-upload/file-upload/file-like-object.class.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

function isElement(node) {
    return !!(node && (node.nodeName || node.prop && node.attr && node.find));
}
var FileLikeObject = (function () {
    function FileLikeObject(fileOrInput) {
        this.rawFile = fileOrInput;
        var isInput = isElement(fileOrInput);
        var fakePathOrObject = isInput ? fileOrInput.value : fileOrInput;
        var postfix = typeof fakePathOrObject === 'string' ? 'FakePath' : 'Object';
        var method = '_createFrom' + postfix;
        this[method](fakePathOrObject);
    }
    FileLikeObject.prototype._createFromFakePath = function (path) {
        this.lastModifiedDate = void 0;
        this.size = void 0;
        this.type = 'like/' + path.slice(path.lastIndexOf('.') + 1).toLowerCase();
        this.name = path.slice(path.lastIndexOf('/') + path.lastIndexOf('\\') + 2);
    };
    FileLikeObject.prototype._createFromObject = function (object) {
        this.size = object.size;
        this.type = object.type;
        this.name = object.name;
    };
    return FileLikeObject;
}());
exports.FileLikeObject = FileLikeObject;


/***/ }),

/***/ "./node_modules/ng2-file-upload/file-upload/file-select.directive.js":
/*!***************************************************************************!*\
  !*** ./node_modules/ng2-file-upload/file-upload/file-select.directive.js ***!
  \***************************************************************************/
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
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var file_uploader_class_1 = __webpack_require__(/*! ./file-uploader.class */ "./node_modules/ng2-file-upload/file-upload/file-uploader.class.js");
var FileSelectDirective = (function () {
    function FileSelectDirective(element) {
        this.onFileSelected = new core_1.EventEmitter();
        this.element = element;
    }
    FileSelectDirective.prototype.getOptions = function () {
        return this.uploader.options;
    };
    FileSelectDirective.prototype.getFilters = function () {
        return {};
    };
    FileSelectDirective.prototype.isEmptyAfterSelection = function () {
        return !!this.element.nativeElement.attributes.multiple;
    };
    FileSelectDirective.prototype.onChange = function () {
        var files = this.element.nativeElement.files;
        var options = this.getOptions();
        var filters = this.getFilters();
        this.uploader.addToQueue(files, options, filters);
        this.onFileSelected.emit(files);
        if (this.isEmptyAfterSelection()) {
            this.element.nativeElement.value = '';
        }
    };
    return FileSelectDirective;
}());
__decorate([
    core_1.Input(),
    __metadata("design:type", file_uploader_class_1.FileUploader)
], FileSelectDirective.prototype, "uploader", void 0);
__decorate([
    core_1.Output(),
    __metadata("design:type", core_1.EventEmitter)
], FileSelectDirective.prototype, "onFileSelected", void 0);
__decorate([
    core_1.HostListener('change'),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", []),
    __metadata("design:returntype", Object)
], FileSelectDirective.prototype, "onChange", null);
FileSelectDirective = __decorate([
    core_1.Directive({ selector: '[ng2FileSelect]' }),
    __metadata("design:paramtypes", [core_1.ElementRef])
], FileSelectDirective);
exports.FileSelectDirective = FileSelectDirective;


/***/ }),

/***/ "./node_modules/ng2-file-upload/file-upload/file-type.class.js":
/*!*********************************************************************!*\
  !*** ./node_modules/ng2-file-upload/file-upload/file-type.class.js ***!
  \*********************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var FileType = (function () {
    function FileType() {
    }
    FileType.getMimeClass = function (file) {
        var mimeClass = 'application';
        if (this.mime_psd.indexOf(file.type) !== -1) {
            mimeClass = 'image';
        }
        else if (file.type.match('image.*')) {
            mimeClass = 'image';
        }
        else if (file.type.match('video.*')) {
            mimeClass = 'video';
        }
        else if (file.type.match('audio.*')) {
            mimeClass = 'audio';
        }
        else if (file.type === 'application/pdf') {
            mimeClass = 'pdf';
        }
        else if (this.mime_compress.indexOf(file.type) !== -1) {
            mimeClass = 'compress';
        }
        else if (this.mime_doc.indexOf(file.type) !== -1) {
            mimeClass = 'doc';
        }
        else if (this.mime_xsl.indexOf(file.type) !== -1) {
            mimeClass = 'xls';
        }
        else if (this.mime_ppt.indexOf(file.type) !== -1) {
            mimeClass = 'ppt';
        }
        if (mimeClass === 'application') {
            mimeClass = this.fileTypeDetection(file.name);
        }
        return mimeClass;
    };
    FileType.fileTypeDetection = function (inputFilename) {
        var types = {
            'jpg': 'image',
            'jpeg': 'image',
            'tif': 'image',
            'psd': 'image',
            'bmp': 'image',
            'png': 'image',
            'nef': 'image',
            'tiff': 'image',
            'cr2': 'image',
            'dwg': 'image',
            'cdr': 'image',
            'ai': 'image',
            'indd': 'image',
            'pin': 'image',
            'cdp': 'image',
            'skp': 'image',
            'stp': 'image',
            '3dm': 'image',
            'mp3': 'audio',
            'wav': 'audio',
            'wma': 'audio',
            'mod': 'audio',
            'm4a': 'audio',
            'compress': 'compress',
            'zip': 'compress',
            'rar': 'compress',
            '7z': 'compress',
            'lz': 'compress',
            'z01': 'compress',
            'pdf': 'pdf',
            'xls': 'xls',
            'xlsx': 'xls',
            'ods': 'xls',
            'mp4': 'video',
            'avi': 'video',
            'wmv': 'video',
            'mpg': 'video',
            'mts': 'video',
            'flv': 'video',
            '3gp': 'video',
            'vob': 'video',
            'm4v': 'video',
            'mpeg': 'video',
            'm2ts': 'video',
            'mov': 'video',
            'doc': 'doc',
            'docx': 'doc',
            'eps': 'doc',
            'txt': 'doc',
            'odt': 'doc',
            'rtf': 'doc',
            'ppt': 'ppt',
            'pptx': 'ppt',
            'pps': 'ppt',
            'ppsx': 'ppt',
            'odp': 'ppt'
        };
        var chunks = inputFilename.split('.');
        if (chunks.length < 2) {
            return 'application';
        }
        var extension = chunks[chunks.length - 1].toLowerCase();
        if (types[extension] === undefined) {
            return 'application';
        }
        else {
            return types[extension];
        }
    };
    return FileType;
}());
/*  MS office  */
FileType.mime_doc = [
    'application/msword',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
    'application/vnd.ms-word.document.macroEnabled.12',
    'application/vnd.ms-word.template.macroEnabled.12'
];
FileType.mime_xsl = [
    'application/vnd.ms-excel',
    'application/vnd.ms-excel',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
    'application/vnd.ms-excel.sheet.macroEnabled.12',
    'application/vnd.ms-excel.template.macroEnabled.12',
    'application/vnd.ms-excel.addin.macroEnabled.12',
    'application/vnd.ms-excel.sheet.binary.macroEnabled.12'
];
FileType.mime_ppt = [
    'application/vnd.ms-powerpoint',
    'application/vnd.ms-powerpoint',
    'application/vnd.ms-powerpoint',
    'application/vnd.ms-powerpoint',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'application/vnd.openxmlformats-officedocument.presentationml.template',
    'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
    'application/vnd.ms-powerpoint.addin.macroEnabled.12',
    'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
    'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
    'application/vnd.ms-powerpoint.slideshow.macroEnabled.12'
];
/* PSD */
FileType.mime_psd = [
    'image/photoshop',
    'image/x-photoshop',
    'image/psd',
    'application/photoshop',
    'application/psd',
    'zz-application/zz-winassoc-psd'
];
/* Compressed files */
FileType.mime_compress = [
    'application/x-gtar',
    'application/x-gcompress',
    'application/compress',
    'application/x-tar',
    'application/x-rar-compressed',
    'application/octet-stream'
];
exports.FileType = FileType;


/***/ }),

/***/ "./node_modules/ng2-file-upload/file-upload/file-upload.module.js":
/*!************************************************************************!*\
  !*** ./node_modules/ng2-file-upload/file-upload/file-upload.module.js ***!
  \************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var common_1 = __webpack_require__(/*! @angular/common */ "./node_modules/@angular/common/fesm5/common.js");
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var file_drop_directive_1 = __webpack_require__(/*! ./file-drop.directive */ "./node_modules/ng2-file-upload/file-upload/file-drop.directive.js");
var file_select_directive_1 = __webpack_require__(/*! ./file-select.directive */ "./node_modules/ng2-file-upload/file-upload/file-select.directive.js");
var FileUploadModule = (function () {
    function FileUploadModule() {
    }
    return FileUploadModule;
}());
FileUploadModule = __decorate([
    core_1.NgModule({
        imports: [common_1.CommonModule],
        declarations: [file_drop_directive_1.FileDropDirective, file_select_directive_1.FileSelectDirective],
        exports: [file_drop_directive_1.FileDropDirective, file_select_directive_1.FileSelectDirective]
    })
], FileUploadModule);
exports.FileUploadModule = FileUploadModule;


/***/ }),

/***/ "./node_modules/ng2-file-upload/file-upload/file-uploader.class.js":
/*!*************************************************************************!*\
  !*** ./node_modules/ng2-file-upload/file-upload/file-uploader.class.js ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var file_like_object_class_1 = __webpack_require__(/*! ./file-like-object.class */ "./node_modules/ng2-file-upload/file-upload/file-like-object.class.js");
var file_item_class_1 = __webpack_require__(/*! ./file-item.class */ "./node_modules/ng2-file-upload/file-upload/file-item.class.js");
var file_type_class_1 = __webpack_require__(/*! ./file-type.class */ "./node_modules/ng2-file-upload/file-upload/file-type.class.js");
function isFile(value) {
    return (File && value instanceof File);
}
var FileUploader = (function () {
    function FileUploader(options) {
        this.isUploading = false;
        this.queue = [];
        this.progress = 0;
        this._nextIndex = 0;
        this.options = {
            autoUpload: false,
            isHTML5: true,
            filters: [],
            removeAfterUpload: false,
            disableMultipart: false,
            formatDataFunction: function (item) { return item._file; },
            formatDataFunctionIsAsync: false
        };
        this.setOptions(options);
        this.response = new core_1.EventEmitter();
    }
    FileUploader.prototype.setOptions = function (options) {
        this.options = Object.assign(this.options, options);
        this.authToken = this.options.authToken;
        this.authTokenHeader = this.options.authTokenHeader || 'Authorization';
        this.autoUpload = this.options.autoUpload;
        this.options.filters.unshift({ name: 'queueLimit', fn: this._queueLimitFilter });
        if (this.options.maxFileSize) {
            this.options.filters.unshift({ name: 'fileSize', fn: this._fileSizeFilter });
        }
        if (this.options.allowedFileType) {
            this.options.filters.unshift({ name: 'fileType', fn: this._fileTypeFilter });
        }
        if (this.options.allowedMimeType) {
            this.options.filters.unshift({ name: 'mimeType', fn: this._mimeTypeFilter });
        }
        for (var i = 0; i < this.queue.length; i++) {
            this.queue[i].url = this.options.url;
        }
    };
    FileUploader.prototype.addToQueue = function (files, options, filters) {
        var _this = this;
        var list = [];
        for (var _i = 0, files_1 = files; _i < files_1.length; _i++) {
            var file = files_1[_i];
            list.push(file);
        }
        var arrayOfFilters = this._getFilters(filters);
        var count = this.queue.length;
        var addedFileItems = [];
        list.map(function (some) {
            if (!options) {
                options = _this.options;
            }
            var temp = new file_like_object_class_1.FileLikeObject(some);
            if (_this._isValidFile(temp, arrayOfFilters, options)) {
                var fileItem = new file_item_class_1.FileItem(_this, some, options);
                addedFileItems.push(fileItem);
                _this.queue.push(fileItem);
                _this._onAfterAddingFile(fileItem);
            }
            else {
                var filter = arrayOfFilters[_this._failFilterIndex];
                _this._onWhenAddingFileFailed(temp, filter, options);
            }
        });
        if (this.queue.length !== count) {
            this._onAfterAddingAll(addedFileItems);
            this.progress = this._getTotalProgress();
        }
        this._render();
        if (this.options.autoUpload) {
            this.uploadAll();
        }
    };
    FileUploader.prototype.removeFromQueue = function (value) {
        var index = this.getIndexOfItem(value);
        var item = this.queue[index];
        if (item.isUploading) {
            item.cancel();
        }
        this.queue.splice(index, 1);
        this.progress = this._getTotalProgress();
    };
    FileUploader.prototype.clearQueue = function () {
        while (this.queue.length) {
            this.queue[0].remove();
        }
        this.progress = 0;
    };
    FileUploader.prototype.uploadItem = function (value) {
        var index = this.getIndexOfItem(value);
        var item = this.queue[index];
        var transport = this.options.isHTML5 ? '_xhrTransport' : '_iframeTransport';
        item._prepareToUploading();
        if (this.isUploading) {
            return;
        }
        this.isUploading = true;
        this[transport](item);
    };
    FileUploader.prototype.cancelItem = function (value) {
        var index = this.getIndexOfItem(value);
        var item = this.queue[index];
        var prop = this.options.isHTML5 ? item._xhr : item._form;
        if (item && item.isUploading) {
            prop.abort();
        }
    };
    FileUploader.prototype.uploadAll = function () {
        var items = this.getNotUploadedItems().filter(function (item) { return !item.isUploading; });
        if (!items.length) {
            return;
        }
        items.map(function (item) { return item._prepareToUploading(); });
        items[0].upload();
    };
    FileUploader.prototype.cancelAll = function () {
        var items = this.getNotUploadedItems();
        items.map(function (item) { return item.cancel(); });
    };
    FileUploader.prototype.isFile = function (value) {
        return isFile(value);
    };
    FileUploader.prototype.isFileLikeObject = function (value) {
        return value instanceof file_like_object_class_1.FileLikeObject;
    };
    FileUploader.prototype.getIndexOfItem = function (value) {
        return typeof value === 'number' ? value : this.queue.indexOf(value);
    };
    FileUploader.prototype.getNotUploadedItems = function () {
        return this.queue.filter(function (item) { return !item.isUploaded; });
    };
    FileUploader.prototype.getReadyItems = function () {
        return this.queue
            .filter(function (item) { return (item.isReady && !item.isUploading); })
            .sort(function (item1, item2) { return item1.index - item2.index; });
    };
    FileUploader.prototype.destroy = function () {
        return void 0;
    };
    FileUploader.prototype.onAfterAddingAll = function (fileItems) {
        return { fileItems: fileItems };
    };
    FileUploader.prototype.onBuildItemForm = function (fileItem, form) {
        return { fileItem: fileItem, form: form };
    };
    FileUploader.prototype.onAfterAddingFile = function (fileItem) {
        return { fileItem: fileItem };
    };
    FileUploader.prototype.onWhenAddingFileFailed = function (item, filter, options) {
        return { item: item, filter: filter, options: options };
    };
    FileUploader.prototype.onBeforeUploadItem = function (fileItem) {
        return { fileItem: fileItem };
    };
    FileUploader.prototype.onProgressItem = function (fileItem, progress) {
        return { fileItem: fileItem, progress: progress };
    };
    FileUploader.prototype.onProgressAll = function (progress) {
        return { progress: progress };
    };
    FileUploader.prototype.onSuccessItem = function (item, response, status, headers) {
        return { item: item, response: response, status: status, headers: headers };
    };
    FileUploader.prototype.onErrorItem = function (item, response, status, headers) {
        return { item: item, response: response, status: status, headers: headers };
    };
    FileUploader.prototype.onCancelItem = function (item, response, status, headers) {
        return { item: item, response: response, status: status, headers: headers };
    };
    FileUploader.prototype.onCompleteItem = function (item, response, status, headers) {
        return { item: item, response: response, status: status, headers: headers };
    };
    FileUploader.prototype.onCompleteAll = function () {
        return void 0;
    };
    FileUploader.prototype._mimeTypeFilter = function (item) {
        return !(this.options.allowedMimeType && this.options.allowedMimeType.indexOf(item.type) === -1);
    };
    FileUploader.prototype._fileSizeFilter = function (item) {
        return !(this.options.maxFileSize && item.size > this.options.maxFileSize);
    };
    FileUploader.prototype._fileTypeFilter = function (item) {
        return !(this.options.allowedFileType &&
            this.options.allowedFileType.indexOf(file_type_class_1.FileType.getMimeClass(item)) === -1);
    };
    FileUploader.prototype._onErrorItem = function (item, response, status, headers) {
        item._onError(response, status, headers);
        this.onErrorItem(item, response, status, headers);
    };
    FileUploader.prototype._onCompleteItem = function (item, response, status, headers) {
        item._onComplete(response, status, headers);
        this.onCompleteItem(item, response, status, headers);
        var nextItem = this.getReadyItems()[0];
        this.isUploading = false;
        if (nextItem) {
            nextItem.upload();
            return;
        }
        this.onCompleteAll();
        this.progress = this._getTotalProgress();
        this._render();
    };
    FileUploader.prototype._headersGetter = function (parsedHeaders) {
        return function (name) {
            if (name) {
                return parsedHeaders[name.toLowerCase()] || void 0;
            }
            return parsedHeaders;
        };
    };
    FileUploader.prototype._xhrTransport = function (item) {
        var _this = this;
        var that = this;
        var xhr = item._xhr = new XMLHttpRequest();
        var sendable;
        this._onBeforeUploadItem(item);
        if (typeof item._file.size !== 'number') {
            throw new TypeError('The file specified is no longer valid');
        }
        if (!this.options.disableMultipart) {
            sendable = new FormData();
            this._onBuildItemForm(item, sendable);
            var appendFile = function () { return sendable.append(item.alias, item._file, item.file.name); };
            if (!this.options.parametersBeforeFiles) {
                appendFile();
            }
            // For AWS, Additional Parameters must come BEFORE Files
            if (this.options.additionalParameter !== undefined) {
                Object.keys(this.options.additionalParameter).forEach(function (key) {
                    var paramVal = _this.options.additionalParameter[key];
                    // Allow an additional parameter to include the filename
                    if (typeof paramVal === 'string' && paramVal.indexOf('{{file_name}}') >= 0) {
                        paramVal = paramVal.replace('{{file_name}}', item.file.name);
                    }
                    sendable.append(key, paramVal);
                });
            }
            if (this.options.parametersBeforeFiles) {
                appendFile();
            }
        }
        else {
            sendable = this.options.formatDataFunction(item);
        }
        xhr.upload.onprogress = function (event) {
            var progress = Math.round(event.lengthComputable ? event.loaded * 100 / event.total : 0);
            _this._onProgressItem(item, progress);
        };
        xhr.onload = function () {
            var headers = _this._parseHeaders(xhr.getAllResponseHeaders());
            var response = _this._transformResponse(xhr.response, headers);
            var gist = _this._isSuccessCode(xhr.status) ? 'Success' : 'Error';
            var method = '_on' + gist + 'Item';
            _this[method](item, response, xhr.status, headers);
            _this._onCompleteItem(item, response, xhr.status, headers);
        };
        xhr.onerror = function () {
            var headers = _this._parseHeaders(xhr.getAllResponseHeaders());
            var response = _this._transformResponse(xhr.response, headers);
            _this._onErrorItem(item, response, xhr.status, headers);
            _this._onCompleteItem(item, response, xhr.status, headers);
        };
        xhr.onabort = function () {
            var headers = _this._parseHeaders(xhr.getAllResponseHeaders());
            var response = _this._transformResponse(xhr.response, headers);
            _this._onCancelItem(item, response, xhr.status, headers);
            _this._onCompleteItem(item, response, xhr.status, headers);
        };
        xhr.open(item.method, item.url, true);
        xhr.withCredentials = item.withCredentials;
        if (this.options.headers) {
            for (var _i = 0, _a = this.options.headers; _i < _a.length; _i++) {
                var header = _a[_i];
                xhr.setRequestHeader(header.name, header.value);
            }
        }
        if (item.headers.length) {
            for (var _b = 0, _c = item.headers; _b < _c.length; _b++) {
                var header = _c[_b];
                xhr.setRequestHeader(header.name, header.value);
            }
        }
        if (this.authToken) {
            xhr.setRequestHeader(this.authTokenHeader, this.authToken);
        }
        xhr.onreadystatechange = function () {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                that.response.emit(xhr.responseText);
            }
        };
        if (this.options.formatDataFunctionIsAsync) {
            sendable.then(function (result) { return xhr.send(JSON.stringify(result)); });
        }
        else {
            xhr.send(sendable);
        }
        this._render();
    };
    FileUploader.prototype._getTotalProgress = function (value) {
        if (value === void 0) { value = 0; }
        if (this.options.removeAfterUpload) {
            return value;
        }
        var notUploaded = this.getNotUploadedItems().length;
        var uploaded = notUploaded ? this.queue.length - notUploaded : this.queue.length;
        var ratio = 100 / this.queue.length;
        var current = value * ratio / 100;
        return Math.round(uploaded * ratio + current);
    };
    FileUploader.prototype._getFilters = function (filters) {
        if (!filters) {
            return this.options.filters;
        }
        if (Array.isArray(filters)) {
            return filters;
        }
        if (typeof filters === 'string') {
            var names_1 = filters.match(/[^\s,]+/g);
            return this.options.filters
                .filter(function (filter) { return names_1.indexOf(filter.name) !== -1; });
        }
        return this.options.filters;
    };
    FileUploader.prototype._render = function () {
        return void 0;
    };
    FileUploader.prototype._queueLimitFilter = function () {
        return this.options.queueLimit === undefined || this.queue.length < this.options.queueLimit;
    };
    FileUploader.prototype._isValidFile = function (file, filters, options) {
        var _this = this;
        this._failFilterIndex = -1;
        return !filters.length ? true : filters.every(function (filter) {
            _this._failFilterIndex++;
            return filter.fn.call(_this, file, options);
        });
    };
    FileUploader.prototype._isSuccessCode = function (status) {
        return (status >= 200 && status < 300) || status === 304;
    };
    FileUploader.prototype._transformResponse = function (response, headers) {
        return response;
    };
    FileUploader.prototype._parseHeaders = function (headers) {
        var parsed = {};
        var key;
        var val;
        var i;
        if (!headers) {
            return parsed;
        }
        headers.split('\n').map(function (line) {
            i = line.indexOf(':');
            key = line.slice(0, i).trim().toLowerCase();
            val = line.slice(i + 1).trim();
            if (key) {
                parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
            }
        });
        return parsed;
    };
    FileUploader.prototype._onWhenAddingFileFailed = function (item, filter, options) {
        this.onWhenAddingFileFailed(item, filter, options);
    };
    FileUploader.prototype._onAfterAddingFile = function (item) {
        this.onAfterAddingFile(item);
    };
    FileUploader.prototype._onAfterAddingAll = function (items) {
        this.onAfterAddingAll(items);
    };
    FileUploader.prototype._onBeforeUploadItem = function (item) {
        item._onBeforeUpload();
        this.onBeforeUploadItem(item);
    };
    FileUploader.prototype._onBuildItemForm = function (item, form) {
        item._onBuildForm(form);
        this.onBuildItemForm(item, form);
    };
    FileUploader.prototype._onProgressItem = function (item, progress) {
        var total = this._getTotalProgress(progress);
        this.progress = total;
        item._onProgress(progress);
        this.onProgressItem(item, progress);
        this.onProgressAll(total);
        this._render();
    };
    FileUploader.prototype._onSuccessItem = function (item, response, status, headers) {
        item._onSuccess(response, status, headers);
        this.onSuccessItem(item, response, status, headers);
    };
    FileUploader.prototype._onCancelItem = function (item, response, status, headers) {
        item._onCancel(response, status, headers);
        this.onCancelItem(item, response, status, headers);
    };
    return FileUploader;
}());
exports.FileUploader = FileUploader;


/***/ }),

/***/ "./node_modules/ng2-file-upload/index.js":
/*!***********************************************!*\
  !*** ./node_modules/ng2-file-upload/index.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

function __export(m) {
    for (var p in m) if (!exports.hasOwnProperty(p)) exports[p] = m[p];
}
__export(__webpack_require__(/*! ./file-upload/file-select.directive */ "./node_modules/ng2-file-upload/file-upload/file-select.directive.js"));
__export(__webpack_require__(/*! ./file-upload/file-drop.directive */ "./node_modules/ng2-file-upload/file-upload/file-drop.directive.js"));
__export(__webpack_require__(/*! ./file-upload/file-uploader.class */ "./node_modules/ng2-file-upload/file-upload/file-uploader.class.js"));
__export(__webpack_require__(/*! ./file-upload/file-item.class */ "./node_modules/ng2-file-upload/file-upload/file-item.class.js"));
__export(__webpack_require__(/*! ./file-upload/file-like-object.class */ "./node_modules/ng2-file-upload/file-upload/file-like-object.class.js"));
var file_upload_module_1 = __webpack_require__(/*! ./file-upload/file-upload.module */ "./node_modules/ng2-file-upload/file-upload/file-upload.module.js");
exports.FileUploadModule = file_upload_module_1.FileUploadModule;


/***/ }),

/***/ "./node_modules/ng2-file-upload/ng2-file-upload.js":
/*!*********************************************************!*\
  !*** ./node_modules/ng2-file-upload/ng2-file-upload.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

function __export(m) {
    for (var p in m) if (!exports.hasOwnProperty(p)) exports[p] = m[p];
}
__export(__webpack_require__(/*! ./index */ "./node_modules/ng2-file-upload/index.js"));


/***/ }),

/***/ "./src/app/views/pages/gui/backup/backup.component.html":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/gui/backup/backup.component.html ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-9\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">Backup Tables</h5>\n        <ngb-tabset>\n          <ngb-tab title=\"Tacacs\">\n            <ng-template ngbTabContent>\n              <div class=\"card\">\n                <div class=\"card-body\">\n                  <h5 class=\"card-title\">Tacacs Configuration Backup</h5>\n                  <h6 class=\"card-subtitle mb-2 text-muted\">here is stored information about devices, users, acls, services and mavis modules</h6>\n                  <br>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n                        <label style=\"width: 100%\">Make backup every time when configuration is applied</label>\n                        <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n          \t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"settings.tcfgSet\" (change)=\"change('tcfgSet')\"> Enable\n          \t\t\t\t\t\t\t\t<span></span>\n          \t\t\t\t\t\t\t</label>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n            \t\t\t\t\t\t<label>Upload File</label>\n            \t\t\t\t\t\t<div class=\"form-group\">\n                          <input type=\"file\" ng2FileSelect [uploader]=\"uploader\" />\n                        </div>\n\n                        <ng-container *ngFor=\"let item of uploader.queue\">\n                          <button type=\"button\" class=\"btn btn-primary btn-sm\"\n                              (click)=\"item.upload()\" [disabled]=\"item.isReady || item.isUploading || item.isSuccess\">\n                            Upload\n                          </button>\n                        </ng-container>\n                        <!-- <div class=\"custom-file\">\n            \t\t\t\t\t\t  \t<input type=\"file\" class=\"custom-file-input\" (change)=\"handleFileInput($event.target.files, 'tcfg')\">\n            \t\t\t\t\t\t  \t<label class=\"custom-file-label\">{{(file_tcfg)? file_tcfg.name : 'Choose file'}}</label>\n            \t\t\t\t\t\t</div>\n                        <p></p> -->\n            \t\t\t\t\t</div>\n\n                    </div>\n                  </div>\n                  <kt-main-table [options]=\"tableOptions_tgui\" [reload]=\"table_reload\">\n                  </kt-main-table>\n                </div>\n              </div>\n            </ng-template>\n          </ngb-tab>\n\n\n          <ngb-tab title=\"API\">\n            <ng-template ngbTabContent>\n              <div class=\"card\">\n                <div class=\"card-body\">\n                  <h5 class=\"card-title\">API Configuration Backup</h5>\n                  <h6 class=\"card-subtitle mb-2 text-muted\">here is stored information of api users, groups and settings</h6>\n                  <br>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"row\">\n                        <div class=\"col-12\">\n                          <div class=\"form-group\">\n                            <label style=\"width: 100%\">Make backup every time when api user or group is added</label>\n                            <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n              \t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"settings.apicfgSet\" (change)=\"change('apicfgSet')\"> Enable\n              \t\t\t\t\t\t\t\t<span></span>\n              \t\t\t\t\t\t\t</label>\n                          </div>\n                          <div class=\"form-group\">\n                            <button type=\"button\" class=\"btn btn-sm btn-primary\" (click)=\"makeBackup('apicfg')\">Make Backup</button>\n                          </div>\n                          <div class=\"form-group\">\n                            <label style=\"width: 100%\">Check difference with the last backup</label>\n                            <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n              \t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"diffs.apicfg\"> Enable\n              \t\t\t\t\t\t\t\t<span></span>\n              \t\t\t\t\t\t\t</label>\n                          </div>\n                        </div>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n            \t\t\t\t\t\t<label>Upload File</label>\n                        <div class=\"form-group\">\n                          <input type=\"file\" ng2FileSelect [uploader]=\"uploader\" />\n                        </div>\n\n                        <ng-container *ngFor=\"let item of uploader.queue\">\n                          <button type=\"button\" class=\"btn btn-primary btn-sm\"\n                              (click)=\"item.upload()\" [disabled]=\"item.isReady || item.isUploading || item.isSuccess\">\n                            Upload\n                          </button>\n                        </ng-container>\n            \t\t\t\t\t</div>\n\n                    </div>\n                  </div>\n                  <kt-main-table [options]=\"tableOptions_api\" [reload]=\"table_reload\">\n                  </kt-main-table>\n                </div>\n              </div>\n            </ng-template>\n          </ngb-tab>\n\n\n          <ngb-tab title=\"Full Backup\">\n            <ng-template ngbTabContent>\n              <div class=\"card\">\n                <div class=\"card-body\">\n                  <h5 class=\"card-title\">Full Configuration Backup</h5>\n                  <h6 class=\"card-subtitle mb-2 text-muted\">here is stored full data api and tacacs configuration (without log)</h6>\n                  <br>\n                  <div class=\"row\">\n                    <div class=\"col-6\">\n                      <div class=\"row\">\n                        <div class=\"col-12\">\n                          <div class=\"form-group\">\n                            <button type=\"button\" class=\"btn btn-sm btn-primary\" (click)=\"makeBackup('full')\">Make Backup</button>\n                          </div>\n                          <div class=\"form-group\">\n                            <label style=\"width: 100%\">Check difference with the last backup</label>\n                            <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n              \t\t\t\t\t\t\t\t<input type=\"checkbox\" [(ngModel)]=\"diffs.full\"> Enable\n              \t\t\t\t\t\t\t\t<span></span>\n              \t\t\t\t\t\t\t</label>\n                          </div>\n                        </div>\n                      </div>\n                    </div>\n                    <div class=\"col-6\">\n                      <div class=\"form-group\">\n            \t\t\t\t\t\t<label>Upload File</label>\n                        <div class=\"form-group\">\n                          <input type=\"file\" ng2FileSelect [uploader]=\"uploader\" />\n                        </div>\n\n                        <ng-container *ngFor=\"let item of uploader.queue\">\n                          <button type=\"button\" class=\"btn btn-primary btn-sm\"\n                              (click)=\"item.upload()\" [disabled]=\"item.isReady || item.isUploading || item.isSuccess\">\n                            Upload\n                          </button>\n                        </ng-container>\n            \t\t\t\t\t</div>\n\n                    </div>\n                  </div>\n                  <kt-main-table [options]=\"tableOptions_full\" [reload]=\"table_reload\">\n                  </kt-main-table>\n                </div>\n              </div>\n            </ng-template>\n          </ngb-tab>\n        </ngb-tabset>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/backup/backup.component.scss":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/gui/backup/backup.component.scss ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9iYWNrdXAvYmFja3VwLmNvbXBvbmVudC5zY3NzIn0= */"

/***/ }),

/***/ "./src/app/views/pages/gui/backup/backup.component.ts":
/*!************************************************************!*\
  !*** ./src/app/views/pages/gui/backup/backup.component.ts ***!
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
var ng2_file_upload_1 = __webpack_require__(/*! ng2-file-upload/ng2-file-upload */ "./node_modules/ng2-file-upload/ng2-file-upload.js");
//RXJS
var rxjs_1 = __webpack_require__(/*! rxjs */ "./node_modules/rxjs/_esm5/index.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
//Service
var backup_service_1 = __webpack_require__(/*! ./backup.service */ "./src/app/views/pages/gui/backup/backup.service.ts");
var BackupComponent = /** @class */ (function () {
    function BackupComponent(service, toastr) {
        var _this = this;
        this.service = service;
        this.toastr = toastr;
        this.diffs = {
            apicfg: true,
            full: true,
        };
        this.file_tcfg = null;
        this.file_api = null;
        this.file_full = null;
        this.settings = {
            apicfgSet: false,
            tcfgSet: false
        };
        this.table_reload = new rxjs_1.BehaviorSubject(false);
        this.tableOptions_api = {
            table: {
                mainUrl: '/backup/datatables/',
                extra: {
                    type: 'apicfg'
                },
                sort: {
                    column: 'filename',
                    direction: 'asc'
                },
                // editable: true,
                columns: {
                    filename: { title: 'Filename', show: true, sortable: true },
                    size: { title: 'Size', show: true, sortable: false },
                    action: { title: 'Action', show: true, sortable: false,
                        htmlPattern: function (data, column_name, index, all_data) {
                            // console.log(data, column_name, index);
                            var href = '';
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data) {
                                // console.log(data[index])
                                href = data[index].href;
                            });
                            return '<a href="' + href + '" target="_blank" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-download"></i></a> ' +
                                '<a title="Restore" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" name="restore"><i class="la la-refresh"></i></a> ' +
                                '<a title="Delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" name="delete"><i class="la la-trash"></i></a>';
                        },
                        onClick: function (data, column_name, index, all_data, e) {
                            // console.log(e)
                            // console.log(e.target.parentElement.name)
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data_all) {
                                // console.log(data_all[index])
                                if ([e.target.parentElement.name, e.target.name].includes('delete')) {
                                    // let result = this.del(data_all[index].filename, data_all[index].type)
                                    if (_this.del(data_all[index].filename, data_all[index].type))
                                        if ([e.target.parentElement.name, e.target.name].includes('delete', 1)) {
                                            console.log(e.target.parentElement);
                                            e.target.parentElement.parentElement.style.display = 'none';
                                        }
                                        else {
                                            console.log(e);
                                            e.target.parentElement.parentElement.parentElement.style.display = 'none';
                                        }
                                }
                                if ([e.target.parentElement.name, e.target.name].includes('restore')) {
                                    _this.restore(data_all[index].filename, data_all[index].type);
                                }
                            });
                            return false;
                        }
                    },
                },
            },
            buttons: {
                disabled: true,
                filter: {}
            }
        };
        this.tableOptions_tgui = {
            table: {
                mainUrl: '/backup/datatables/',
                extra: {
                    type: 'tcfg'
                },
                sort: {
                    column: 'filename',
                    direction: 'asc'
                },
                // editable: true,
                columns: {
                    filename: { title: 'Filename', show: true, sortable: true },
                    size: { title: 'Size', show: true, sortable: false },
                    action: { title: 'Action', show: true, sortable: false,
                        htmlPattern: function (data, column_name, index, all_data) {
                            // console.log(data, column_name, index);
                            var href = '';
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data) {
                                // console.log(data[index])
                                href = data[index].href;
                            });
                            return '<a href="' + href + '" target="_blank" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-download"></i></a> ' +
                                '<a title="Restore" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" name="restore"><i class="la la-refresh"></i></a> ' +
                                '<a title="Delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" name="delete"><i class="la la-trash"></i></a>';
                        },
                        onClick: function (data, column_name, index, all_data, e) {
                            // console.log(e)
                            // console.log(e.target.parentElement.name)
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data_all) {
                                // console.log([e.target.parentElement.name, e.target.name].includes('delete', 1) )
                                if ([e.target.parentElement.name, e.target.name].includes('delete')) {
                                    // let result = this.del(data_all[index].filename, data_all[index].type)
                                    if (_this.del(data_all[index].filename, data_all[index].type))
                                        if ([e.target.parentElement.name, e.target.name].includes('delete', 1)) {
                                            console.log(e.target.parentElement);
                                            e.target.parentElement.parentElement.style.display = 'none';
                                        }
                                        else {
                                            console.log(e);
                                            e.target.parentElement.parentElement.parentElement.style.display = 'none';
                                        }
                                }
                                if ([e.target.parentElement.name, e.target.name].includes('restore')) {
                                    _this.restore(data_all[index].filename, data_all[index].type);
                                }
                            });
                            return false;
                        }
                    },
                },
            },
            buttons: {
                disabled: true,
                filter: {}
            }
        };
        this.tableOptions_full = {
            table: {
                mainUrl: '/backup/datatables/',
                extra: {
                    type: 'full'
                },
                sort: {
                    column: 'filename',
                    direction: 'asc'
                },
                // editable: true,
                columns: {
                    filename: { title: 'Filename', show: true, sortable: true },
                    size: { title: 'Size', show: true, sortable: false },
                    action: { title: 'Action', show: true, sortable: false,
                        htmlPattern: function (data, column_name, index, all_data) {
                            // console.log(data, column_name, index);
                            var href = '';
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data) {
                                // console.log(data[index])
                                href = data[index].href;
                            });
                            return '<a href="' + href + '" target="_blank" class="btn btn-sm btn-clean btn-icon btn-icon-md"><i class="la la-download"></i></a> ' +
                                '<a title="Restore" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" name="restore"><i class="la la-refresh"></i></a> ' +
                                '<a title="Delete" href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" name="delete"><i class="la la-trash"></i></a>';
                        },
                        onClick: function (data, column_name, index, all_data, e) {
                            // console.log(e)
                            // console.log(e.target.parentElement.name)
                            all_data.pipe(operators_1.first())
                                .subscribe(function (data_all) {
                                // console.log(data_all[index])
                                if ([e.target.parentElement.name, e.target.name].includes('delete')) {
                                    // let result = this.del(data_all[index].filename, data_all[index].type)
                                    if (_this.del(data_all[index].filename, data_all[index].type))
                                        if ([e.target.parentElement.name, e.target.name].includes('delete', 1)) {
                                            console.log(e.target.parentElement);
                                            e.target.parentElement.parentElement.style.display = 'none';
                                        }
                                        else {
                                            console.log(e);
                                            e.target.parentElement.parentElement.parentElement.style.display = 'none';
                                        }
                                }
                                if ([e.target.parentElement.name, e.target.name].includes('restore')) {
                                    _this.restore(data_all[index].filename, data_all[index].type);
                                }
                            });
                            return false;
                        }
                    },
                },
            },
            buttons: {
                disabled: true,
                filter: {}
            }
        };
        this.uploader = new ng2_file_upload_1.FileUploader({ url: 'api/backup/upload/' });
        this.hasBaseDropZoneOver = false;
        this.hasAnotherDropZoneOver = false;
    }
    BackupComponent.prototype.handleFileInput = function (files, type) {
        if (type === void 0) { type = 'tcfg'; }
        this.file_tcfg = files.item(0);
    };
    BackupComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.service.settings().subscribe(function (data) {
            console.log(data.settings);
            _this.settings = data.settings;
        });
        this.uploader.onErrorItem = function (item, response, status, headers) { return _this.onErrorItem(item, response, status, headers); };
        this.uploader.onSuccessItem = function (item, response, status, headers) { return _this.onSuccessItem(item, response, status, headers); };
        this.uploader.onAfterAddingFile = function (f) { if (_this.uploader.queue.length > 1) {
            _this.uploader.queue.splice(0, 1);
        } };
    };
    BackupComponent.prototype.makeBackup = function (type) {
        var _this = this;
        // console.log(type)
        var data = {
            type: type,
            diff: this.diffs[type]
        };
        this.service.make(data).subscribe(function (data) {
            // console.log(data)
            if (data.result && data.result.status) {
                _this.toastr.success('Backup Created');
                _this.table_reload.next(true);
            }
            else {
                _this.toastr.error((data.result.message) ? data.result.message : 'Unknown status');
            }
        });
    };
    BackupComponent.prototype.del = function (filename, type) {
        var _this = this;
        if (!confirm('Are you sure? Delete ' + filename))
            return false;
        // console.log(filename, type)
        this.service.del({ name: filename }).subscribe(function (data) {
            // console.log(data)
            if (data.result)
                _this.toastr.success('Deleted');
            else
                _this.toastr.error('Error. Not Deleted');
            _this.table_reload.next(true);
        });
        return true;
    };
    BackupComponent.prototype.restore = function (filename, type) {
        var _this = this;
        if (!confirm('Are you sure? Restore ' + filename))
            return false;
        console.log(filename, type);
        this.service.restore({
            name: filename,
            type: type
        }).subscribe(function (data) {
            console.log(data);
            if (data.result) {
                _this.toastr.success('Restored');
                return;
            }
            _this.toastr.error('Error');
            return;
        });
        return true;
    };
    BackupComponent.prototype.change = function (type) {
        var _this = this;
        console.log(type);
        this.service.settings_({ set: this.settings[type] + 0, target: type }).subscribe(function (data) {
            // console.log(data)
            if (data.result)
                _this.toastr.success('Change Saved');
        });
    };
    BackupComponent.prototype.fileOverBase = function (e) {
        this.hasBaseDropZoneOver = e;
    };
    BackupComponent.prototype.fileOverAnother = function (e) {
        this.hasAnotherDropZoneOver = e;
    };
    BackupComponent.prototype.upload = function (item) {
        console.log(item);
    };
    BackupComponent.prototype.onSuccessItem = function (item, response, status, headers) {
        var data = JSON.parse(response); //success server response
        this.uploader.clearQueue();
        if (data.error && data.error.status) {
            this.toastr.error(data.error.message);
            return;
        }
        this.table_reload.next(true);
        this.toastr.success('Uploaded');
        // console.log(data)
        // console.log(this.uploader)
    };
    BackupComponent.prototype.onErrorItem = function (item, response, status, headers) {
        var error = JSON.parse(response); //error server response
        console.log(error);
    };
    BackupComponent = __decorate([
        core_1.Component({
            selector: 'kt-backup',
            template: __webpack_require__(/*! ./backup.component.html */ "./src/app/views/pages/gui/backup/backup.component.html"),
            styles: [__webpack_require__(/*! ./backup.component.scss */ "./src/app/views/pages/gui/backup/backup.component.scss")]
        }),
        __metadata("design:paramtypes", [backup_service_1.BackupService,
            ngx_toastr_1.ToastrService])
    ], BackupComponent);
    return BackupComponent;
}());
exports.BackupComponent = BackupComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/backup/backup.service.ts":
/*!**********************************************************!*\
  !*** ./src/app/views/pages/gui/backup/backup.service.ts ***!
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
var API_URL = 'api/backup/';
var BackupService = /** @class */ (function () {
    function BackupService(http) {
        this.http = http;
    }
    BackupService.prototype.settings = function () {
        return this.http.get(API_URL + 'settings/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    BackupService.prototype.settings_ = function (params) {
        return this.http.post(API_URL + 'settings/', params)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    BackupService.prototype.postFile = function (fileToUpload, settings) {
        var formData = new FormData();
        formData.append('tcfg', fileToUpload, fileToUpload.name);
        // formData.append('action', settings.action);
        // formData.append('name', settings.name);
        return this.http
            .post(API_URL + 'upload/', formData).pipe(operators_1.map(function () { return true; }));
    };
    BackupService.prototype.upload = function (file) {
        var formData = new FormData();
        formData.append('file', file);
        var config = {
            headers: { 'Content-Type': undefined },
            transformRequest: []
        };
        return this.http.post(API_URL + 'upload/', formData, config).pipe(operators_1.map(function (event) {
            switch (event.type) {
                case http_1.HttpEventType.UploadProgress:
                    var progress = Math.round(100 * event.loaded / event.total);
                    return { status: 'progress', message: progress };
                case http_1.HttpEventType.Response:
                    return event.body;
                default:
                    return "Unhandled event: " + event.type;
            }
        }));
    };
    BackupService.prototype.make = function (settings) {
        return this.http.post(API_URL + 'make/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    BackupService.prototype.del = function (settings) {
        return this.http.post(API_URL + 'delete/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    BackupService.prototype.restore = function (settings) {
        // name: 2019-05-23_tcfg_393.sql
        // type: tcfg
        return this.http.post(API_URL + 'restore/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    BackupService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], BackupService);
    return BackupService;
}());
exports.BackupService = BackupService;


/***/ }),

/***/ "./src/app/views/pages/gui/gui.component.html":
/*!****************************************************!*\
  !*** ./src/app/views/pages/gui/gui.component.html ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n\t<div class=\"col-md-3 col-sm-6\" *ngFor=\"let card of cards\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">{{card.title}}</h5>\n        <!-- <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6> -->\n        <div class=\"text-center\">\n          <p class=\"card-text\">\n            <a [routerLink]=\"card.list\">\n              <span style=\"font-size: 5em;\" [ngStyle]=\"{'color': card.icon_color}\">\n                <i class=\"{{card.icon}}\"></i>\n              </span>\n            </a>\n          </p>\n        </div>\n        <hr>\n        <div class=\"text-center\">\n          <a [routerLink]=\"card.list\" class=\"btn btn-warning btn-elevate btn-elevate-air\" *ngIf=\"card.list\">View</a>&nbsp;\n        </div>\n      </div>\n    </div>\n    <br>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/gui.component.scss":
/*!****************************************************!*\
  !*** ./src/app/views/pages/gui/gui.component.scss ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiJzcmMvYXBwL3ZpZXdzL3BhZ2VzL2d1aS9ndWkuY29tcG9uZW50LnNjc3MifQ== */"

/***/ }),

/***/ "./src/app/views/pages/gui/gui.component.ts":
/*!**************************************************!*\
  !*** ./src/app/views/pages/gui/gui.component.ts ***!
  \**************************************************/
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
var GuiComponent = /** @class */ (function () {
    function GuiComponent() {
        this.cards = [
            {
                title: 'Users',
                icon: 'fa fa-user',
                // icon_color:'#5867dd',
                svg: 'fa-key',
                list: '/gui/users',
            },
            {
                title: 'User Groups',
                icon: 'fa fa-users',
                // icon_color:'#5867dd',
                list: '/gui/user-groups',
            },
            {
                title: 'Upgrade',
                icon: 'fa fa-oil-can',
                // icon_color:'#5867dd',
                list: '/gui/upgrade',
            },
            {
                title: 'Backup',
                icon: 'fa fa-cloud-upload-alt',
                // icon_color:'#5867dd',
                list: '/gui/backup',
            },
        ];
    }
    GuiComponent.prototype.ngOnInit = function () {
    };
    GuiComponent = __decorate([
        core_1.Component({
            selector: 'kt-gui',
            template: __webpack_require__(/*! ./gui.component.html */ "./src/app/views/pages/gui/gui.component.html"),
            styles: [__webpack_require__(/*! ./gui.component.scss */ "./src/app/views/pages/gui/gui.component.scss")]
        }),
        __metadata("design:paramtypes", [])
    ], GuiComponent);
    return GuiComponent;
}());
exports.GuiComponent = GuiComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/gui.module.ts":
/*!***********************************************!*\
  !*** ./src/app/views/pages/gui/gui.module.ts ***!
  \***********************************************/
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
//Page Module
var pages_module_1 = __webpack_require__(/*! ../../pages/pages.module */ "./src/app/views/pages/pages.module.ts");
var ngx_clipboard_1 = __webpack_require__(/*! ngx-clipboard */ "./node_modules/ngx-clipboard/fesm5/ngx-clipboard.js");
var ng2_file_upload_1 = __webpack_require__(/*! ng2-file-upload */ "./node_modules/ng2-file-upload/index.js");
var update_component_1 = __webpack_require__(/*! ./update/update.component */ "./src/app/views/pages/gui/update/update.component.ts");
var gui_component_1 = __webpack_require__(/*! ./gui.component */ "./src/app/views/pages/gui/gui.component.ts");
var backup_component_1 = __webpack_require__(/*! ./backup/backup.component */ "./src/app/views/pages/gui/backup/backup.component.ts");
var GuiModule = /** @class */ (function () {
    function GuiModule() {
    }
    GuiModule = __decorate([
        core_1.NgModule({
            declarations: [
                gui_component_1.GuiComponent,
                update_component_1.UpdateComponent,
                backup_component_1.BackupComponent,
                ng2_file_upload_1.FileSelectDirective
            ],
            imports: [
                common_1.CommonModule,
                ng_bootstrap_1.NgbModule,
                pages_module_1.PagesModule,
                forms_1.FormsModule,
                ngx_clipboard_1.ClipboardModule,
                router_1.RouterModule.forChild([
                    {
                        path: '',
                        component: gui_component_1.GuiComponent
                    },
                    {
                        path: 'users',
                        loadChildren: './api-users/users.module#UsersModule'
                    },
                    {
                        path: 'user-groups',
                        loadChildren: './api-user-groups/user-groups.module#UserGroupsModule'
                    },
                    {
                        path: 'upgrade',
                        component: update_component_1.UpdateComponent
                    },
                    {
                        path: 'backup',
                        component: backup_component_1.BackupComponent
                    },
                    {
                        path: 'settings',
                        loadChildren: './settings/settings.module#SettingsModule'
                    },
                ]),
            ],
            exports: [
                router_1.RouterModule
            ]
        })
    ], GuiModule);
    return GuiModule;
}());
exports.GuiModule = GuiModule;


/***/ }),

/***/ "./src/app/views/pages/gui/update/update.component.html":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/gui/update/update.component.html ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = "<div class=\"row\">\n  <div class=\"col-9\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <h5 class=\"card-title\">General Update Settings</h5>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <div class=\"form-group\">\n              <label>Update URL</label>\n              <input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"data.update_url\" disabled>\n            </div>\n          </div>\n        </div>\n        <div class=\"row\">\n          <div class=\"col-12\">\n            <div class=\"form-group\">\n              <label style=\"width: 100%\">Check after sign in</label>\n              <label class=\"kt-checkbox kt-checkbox--bold kt-checkbox--brand\">\n                <input type=\"checkbox\" [(ngModel)]=\"data.update_signin\" (change)=\"change()\"> Enable\n                <span></span>\n              </label>\n            </div>\n          </div>\n          <div class=\"col-12\">\n            <div class=\"form-group\">\n        \t\t\t<p><label>System Activation Status:</label> <span class=\"activated\">Activated</span></p>\n        \t\t\t<label>Update Key</label>\n        \t\t\t<div class=\"input-group margin\">\n        \t\t\t\t<span class=\"input-group-btn\">\n        \t\t\t\t\t<button type=\"button\" class=\"btn btn-sm btn-primary\"\n                  ngxClipboard [cbContent]=\"data.update_key\" (cbOnSuccess)=\"copyKey($event)\">Copy Key</button>\n        \t\t\t\t</span>\n                <input type=\"text\" class=\"form-control form-control-sm\" [(ngModel)]=\"data.update_key\" disabled>\n              </div>\n\n        \t\t\t<span class=\"form-text text-muted\">\n                add that key to your\n                <a href=\"https://tacacsgui.com/profile/\" target=\"_blank\">tacacsgui.com</a> profile\n              </span>\n        \t\t</div>\n          </div>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n<div class=\"row\">\n  <div class=\"col-9\">\n    <div class=\"card\">\n      <div class=\"card-body\">\n        <div class=\"form-group\">\n          <p class=\"text-muted\">Current version: {{data.version}}</p>\n          <button type=\"button\" class=\"btn btn-sm btn-success\" (click)=\"checkUpdates()\">Check Updates</button>\n\n        </div>\n        <pre *ngIf=\"outputMessage_ | async\" class=\"update-output\">{{ outputMessage_ | async }}\n          <div *ngIf=\"briefDescr_ | async\" [innerHtml]=\"briefDescr_ | async\"></div>\n          <div *ngIf=\"moreDescr_ | async\" [innerHtml]=\"moreDescr_ | async\"></div>\n        </pre>\n        <div class=\"form-group text-center\" *ngIf=\"(updateTrigger | async)\">\n          <h4 *ngIf=\"(manualTrigger | async)\">Manual Upgrade Required</h4>\n          <button *ngIf=\"!(manualTrigger | async)\" (click)=\"upgrade()\" type=\"button\" class=\"btn btn-sm btn-success\">Upgrade</button>\n        </div>\n      </div>\n    </div>\n  </div>\n</div>\n"

/***/ }),

/***/ "./src/app/views/pages/gui/update/update.component.scss":
/*!**************************************************************!*\
  !*** ./src/app/views/pages/gui/update/update.component.scss ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = ".update-output {\n  background-color: #444;\n  color: #fff;\n  padding: 15px; }\n\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi92YXIvd3d3L2h0bWwvc2tlbGV0b24vc3JjL2FwcC92aWV3cy9wYWdlcy9ndWkvdXBkYXRlL3VwZGF0ZS5jb21wb25lbnQuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFBQTtFQUNFLHNCQUFzQjtFQUN0QixXQUFXO0VBQ1gsYUFBYSxFQUFBIiwiZmlsZSI6InNyYy9hcHAvdmlld3MvcGFnZXMvZ3VpL3VwZGF0ZS91cGRhdGUuY29tcG9uZW50LnNjc3MiLCJzb3VyY2VzQ29udGVudCI6WyIudXBkYXRlLW91dHB1dCB7XG4gIGJhY2tncm91bmQtY29sb3I6ICM0NDQ7XG4gIGNvbG9yOiAjZmZmO1xuICBwYWRkaW5nOiAxNXB4O1xufVxuIl19 */"

/***/ }),

/***/ "./src/app/views/pages/gui/update/update.component.ts":
/*!************************************************************!*\
  !*** ./src/app/views/pages/gui/update/update.component.ts ***!
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
//Service
var upgrade_service_1 = __webpack_require__(/*! ./upgrade.service */ "./src/app/views/pages/gui/update/upgrade.service.ts");
//Toastr
var ngx_toastr_1 = __webpack_require__(/*! ngx-toastr */ "./node_modules/ngx-toastr/fesm5/ngx-toastr.js");
// NGRX
var store_1 = __webpack_require__(/*! @ngrx/store */ "./node_modules/@ngrx/store/fesm5/store.js");
var auth_1 = __webpack_require__(/*! ../../../../core/auth */ "./src/app/core/auth/index.ts");
var UpdateComponent = /** @class */ (function () {
    function UpdateComponent(service, toastr, store, auth) {
        this.service = service;
        this.toastr = toastr;
        this.store = store;
        this.auth = auth;
        this.data = {
            update_activated: 0,
            update_key: "",
            update_signin: 0,
            update_url: "https://tacacsgui.com/api/tacacsgui/update/",
            version: ''
        };
        this.username = '';
        this.last_version = {
            description_brief: "",
            description_more: "",
            reinstall: 0,
            version: ""
        };
        this.outputMessage = '';
        this.outputMessage_ = new rxjs_1.BehaviorSubject('');
        this.briefDescr_ = new rxjs_1.BehaviorSubject('');
        this.moreDescr_ = new rxjs_1.BehaviorSubject('');
        this.updateTrigger = new rxjs_1.BehaviorSubject(false);
        this.manualTrigger = new rxjs_1.BehaviorSubject(false);
    }
    UpdateComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.service.info().subscribe(function (data) {
            console.log(data);
            _this.data = data.info;
        });
    };
    UpdateComponent.prototype.change = function () {
        var _this = this;
        this.service.change({
            settings: 1,
            update_signin: +this.data.update_signin
        }).subscribe(function (data) {
            console.log(data);
            if (data.change_status)
                _this.toastr.success('Changes Saved');
        });
    };
    UpdateComponent.prototype.copyKey = function (e) {
        // console.log(e)
        if (e.isSuccess)
            this.toastr.success('You have copied update key');
    };
    UpdateComponent.prototype.checkUpdates = function () {
        var _this = this;
        this.outputMessage_.next('Loading...');
        this.briefDescr_.next('');
        this.moreDescr_.next('');
        this.service.update({ version: this.data.version }).subscribe(function (data) {
            console.log(data);
            _this.outputMessage = '';
            if (data.output) {
                data.output.last_version.version = '0000';
                // data.output.last_version.reinstall = '1'
                if (data.output.error && data.output.error.message) {
                    _this.outputMessage_.next('Error: ' + data.output.error.message);
                    return;
                }
                if (data.output.user)
                    _this.outputMessage += "Hello " + data.output.user.username + ",\n";
                // this.username = data.output.user.username;
                _this.outputMessage += "Your api version: " + _this.data.version + "\n";
                if (data.output.last_version) {
                    _this.outputMessage += "Last available version: " + data.output.last_version.version;
                    _this.briefDescr_.next('Brief Description: ' + data.output.last_version.description_brief);
                    _this.moreDescr_.next('More Description: ' + data.output.last_version.description_more);
                    _this.manualTrigger.next(!!+data.output.last_version.reinstall);
                }
                _this.outputMessage_.next(_this.outputMessage);
                if (_this.data.version != data.output.last_version.version) {
                    _this.updateTrigger.next(true);
                }
            }
        });
    };
    UpdateComponent.prototype.upgrade = function () {
        var _this = this;
        this.service.upgrade().subscribe(function (data) {
            console.log(data);
            _this.auth.logout().subscribe(function (data) {
                console.log(data);
            });
            _this.store.dispatch(new auth_1.Logout());
        });
    };
    UpdateComponent = __decorate([
        core_1.Component({
            selector: 'kt-update',
            template: __webpack_require__(/*! ./update.component.html */ "./src/app/views/pages/gui/update/update.component.html"),
            styles: [__webpack_require__(/*! ./update.component.scss */ "./src/app/views/pages/gui/update/update.component.scss")]
        }),
        __metadata("design:paramtypes", [upgrade_service_1.UpgradeService,
            ngx_toastr_1.ToastrService,
            store_1.Store,
            auth_1.AuthService])
    ], UpdateComponent);
    return UpdateComponent;
}());
exports.UpdateComponent = UpdateComponent;


/***/ }),

/***/ "./src/app/views/pages/gui/update/upgrade.service.ts":
/*!***********************************************************!*\
  !*** ./src/app/views/pages/gui/update/upgrade.service.ts ***!
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
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
Object.defineProperty(exports, "__esModule", { value: true });
var core_1 = __webpack_require__(/*! @angular/core */ "./node_modules/@angular/core/fesm5/core.js");
var http_1 = __webpack_require__(/*! @angular/common/http */ "./node_modules/@angular/common/fesm5/http.js");
var operators_1 = __webpack_require__(/*! rxjs/operators */ "./node_modules/rxjs/_esm5/operators/index.js");
var API_URL = 'api/update/';
var UpgradeService = /** @class */ (function () {
    function UpgradeService(http) {
        this.http = http;
    }
    UpgradeService.prototype.info = function () {
        return this.http.get(API_URL + 'info/')
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UpgradeService.prototype.change = function (settings) {
        // settings: 1
        // update_signin: 0
        return this.http.post(API_URL + 'change/', settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UpgradeService.prototype.update = function (settings) {
        // version: 1
        return this.http.post(API_URL, settings)
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UpgradeService.prototype.upgrade = function () {
        return this.http.post(API_URL + 'upgrade/', {})
            .pipe(operators_1.first(), operators_1.map(function (data) {
            return data;
        }));
    };
    UpgradeService = __decorate([
        core_1.Injectable({
            providedIn: 'root'
        }),
        __metadata("design:paramtypes", [http_1.HttpClient])
    ], UpgradeService);
    return UpgradeService;
}());
exports.UpgradeService = UpgradeService;


/***/ })

}]);
//# sourceMappingURL=app-views-pages-gui-gui-module.5358abf0f41028977669.js.map