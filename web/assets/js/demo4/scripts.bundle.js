"use strict";
/**
 * @class KTUtil  base utilize class that privides helper functions
 */
// Polyfill
// matches polyfill
this.Element && function(ElementPrototype) {
    ElementPrototype.matches = ElementPrototype.matches ||
        ElementPrototype.matchesSelector ||
        ElementPrototype.webkitMatchesSelector ||
        ElementPrototype.msMatchesSelector ||
        function(selector) {
            var node = this,
                nodes = (node.parentNode || node.document).querySelectorAll(selector),
                i = -1;
            while (nodes[++i] && nodes[i] != node);
            return !!nodes[i];
        }
}(Element.prototype);

// closest polyfill
this.Element && function(ElementPrototype) {
    ElementPrototype.closest = ElementPrototype.closest ||
        function(selector) {
            var el = this;
            while (el.matches && !el.matches(selector)) el = el.parentNode;
            return el.matches ? el : null;
        }
}(Element.prototype);

// remove polyfill
if (!('remove' in Element.prototype)) {
    Element.prototype.remove = function() {
        if (this.parentNode) {
            this.parentNode.removeChild(this);
        }
    };
}

// matches polyfill
this.Element && function(ElementPrototype) {
    ElementPrototype.matches = ElementPrototype.matches ||
        ElementPrototype.matchesSelector ||
        ElementPrototype.webkitMatchesSelector ||
        ElementPrototype.msMatchesSelector ||
        function(selector) {
            var node = this,
                nodes = (node.parentNode || node.document).querySelectorAll(selector),
                i = -1;
            while (nodes[++i] && nodes[i] != node);
            return !!nodes[i];
        }
}(Element.prototype);

//
// requestAnimationFrame polyfill by Erik Möller.
//  With fixes from Paul Irish and Tino Zijdel
//
//  http://paulirish.com/2011/requestanimationframe-for-smart-animating/
//  http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
//
//  MIT license
//
(function() {
    var lastTime = 0;
    var vendors = ['webkit', 'moz'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
        window.cancelAnimationFrame =
            window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() {
                callback(currTime + timeToCall);
            }, timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

// Source: https://github.com/jserz/js_piece/blob/master/DOM/ParentNode/prepend()/prepend().md
(function(arr) {
    arr.forEach(function(item) {
        if (item.hasOwnProperty('prepend')) {
            return;
        }
        Object.defineProperty(item, 'prepend', {
            configurable: true,
            enumerable: true,
            writable: true,
            value: function prepend() {
                var argArr = Array.prototype.slice.call(arguments),
                    docFrag = document.createDocumentFragment();

                argArr.forEach(function(argItem) {
                    var isNode = argItem instanceof Node;
                    docFrag.appendChild(isNode ? argItem : document.createTextNode(String(argItem)));
                });

                this.insertBefore(docFrag, this.firstChild);
            }
        });
    });
})([Element.prototype, Document.prototype, DocumentFragment.prototype]);

// Global variables 
window.KTUtilElementDataStore = {};
window.KTUtilElementDataStoreID = 0;
window.KTUtilDelegatedEventHandlers = {};

var KTUtil = function() {
    var resizeHandlers = [];

    /** @type {object} breakpoints The device width breakpoints **/
    var breakpoints = {
        sm: 544, // Small screen / phone           
        md: 768, // Medium screen / tablet            
        lg: 1024, // Large screen / desktop        
        xl: 1200 // Extra large screen / wide desktop
    };

    /**
     * Handle window resize event with some 
     * delay to attach event handlers upon resize complete 
     */
    var _windowResizeHandler = function() {
        var _runResizeHandlers = function() {
            // reinitialize other subscribed elements
            for (var i = 0; i < resizeHandlers.length; i++) {
                var each = resizeHandlers[i];
                each.call();
            }
        };

        var timeout = false; // holder for timeout id
        var delay = 250; // delay after event is "complete" to run callback

        window.addEventListener('resize', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                _runResizeHandlers();
            }, delay); // wait 50ms until window resize finishes.
        });
    };

    return {
        /**
         * Class main initializer.
         * @param {object} options.
         * @returns null
         */
        //main function to initiate the theme
        init: function(options) {
            if (options && options.breakpoints) {
                breakpoints = options.breakpoints;
            }

            _windowResizeHandler();
        },

        /**
         * Adds window resize event handler.
         * @param {function} callback function.
         */
        addResizeHandler: function(callback) {
            resizeHandlers.push(callback);
        },

        /**
         * Removes window resize event handler.
         * @param {function} callback function.
         */
        removeResizeHandler: function(callback) {
            for (var i = 0; i < resizeHandlers.length; i++) {
                if (callback === resizeHandlers[i]) {
                    delete resizeHandlers[i];
                }
            }
        },

        /**
         * Trigger window resize handlers.
         */
        runResizeHandlers: function() {
            _runResizeHandlers();
        },

        resize: function() {
            if (typeof(Event) === 'function') {
                // modern browsers
                window.dispatchEvent(new Event('resize'));
            } else {
                // for IE and other old browsers
                // causes deprecation warning on modern browsers
                var evt = window.document.createEvent('UIEvents'); 
                evt.initUIEvent('resize', true, false, window, 0); 
                window.dispatchEvent(evt);
            }
        },

        /**
         * Get GET parameter value from URL.
         * @param {string} paramName Parameter name.
         * @returns {string}  
         */
        getURLParam: function(paramName) {
            var searchString = window.location.search.substring(1),
                i, val, params = searchString.split("&");

            for (i = 0; i < params.length; i++) {
                val = params[i].split("=");
                if (val[0] == paramName) {
                    return unescape(val[1]);
                }
            }

            return null;
        },

        /**
         * Checks whether current device is mobile touch.
         * @returns {boolean}  
         */
        isMobileDevice: function() {
            return (this.getViewPort().width < this.getBreakpoint('lg') ? true : false);
        },

        /**
         * Checks whether current device is desktop.
         * @returns {boolean}  
         */
        isDesktopDevice: function() {
            return KTUtil.isMobileDevice() ? false : true;
        },

        /**
         * Gets browser window viewport size. Ref:
         * http://andylangton.co.uk/articles/javascript/get-viewport-size-javascript/
         * @returns {object}  
         */
        getViewPort: function() {
            var e = window,
                a = 'inner';
            if (!('innerWidth' in window)) {
                a = 'client';
                e = document.documentElement || document.body;
            }

            return {
                width: e[a + 'Width'],
                height: e[a + 'Height']
            };
        },

        /**
         * Checks whether given device mode is currently activated.
         * @param {string} mode Responsive mode name(e.g: desktop,
         *     desktop-and-tablet, tablet, tablet-and-mobile, mobile)
         * @returns {boolean}  
         */
        isInResponsiveRange: function(mode) {
            var breakpoint = this.getViewPort().width;

            if (mode == 'general') {
                return true;
            } else if (mode == 'desktop' && breakpoint >= (this.getBreakpoint('lg') + 1)) {
                return true;
            } else if (mode == 'tablet' && (breakpoint >= (this.getBreakpoint('md') + 1) && breakpoint < this.getBreakpoint('lg'))) {
                return true;
            } else if (mode == 'mobile' && breakpoint <= this.getBreakpoint('md')) {
                return true;
            } else if (mode == 'desktop-and-tablet' && breakpoint >= (this.getBreakpoint('md') + 1)) {
                return true;
            } else if (mode == 'tablet-and-mobile' && breakpoint <= this.getBreakpoint('lg')) {
                return true;
            } else if (mode == 'minimal-desktop-and-below' && breakpoint <= this.getBreakpoint('xl')) {
                return true;
            }

            return false;
        },

        /**
         * Generates unique ID for give prefix.
         * @param {string} prefix Prefix for generated ID
         * @returns {boolean}  
         */
        getUniqueID: function(prefix) {
            return prefix + Math.floor(Math.random() * (new Date()).getTime());
        },

        /**
         * Gets window width for give breakpoint mode.
         * @param {string} mode Responsive mode name(e.g: xl, lg, md, sm)
         * @returns {number}  
         */
        getBreakpoint: function(mode) {
            return breakpoints[mode];
        },

        /**
         * Checks whether object has property matchs given key path.
         * @param {object} obj Object contains values paired with given key path
         * @param {string} keys Keys path seperated with dots
         * @returns {object}  
         */
        isset: function(obj, keys) {
            var stone;

            keys = keys || '';

            if (keys.indexOf('[') !== -1) {
                throw new Error('Unsupported object path notation.');
            }

            keys = keys.split('.');

            do {
                if (obj === undefined) {
                    return false;
                }

                stone = keys.shift();

                if (!obj.hasOwnProperty(stone)) {
                    return false;
                }

                obj = obj[stone];

            } while (keys.length);

            return true;
        },

        /**
         * Gets highest z-index of the given element parents
         * @param {object} el jQuery element object
         * @returns {number}  
         */
        getHighestZindex: function(el) {
            var elem = KTUtil.get(el),
                position, value;

            while (elem && elem !== document) {
                // Ignore z-index if position is set to a value where z-index is ignored by the browser
                // This makes behavior of this function consistent across browsers
                // WebKit always returns auto if the element is positioned
                position = KTUtil.css(elem, 'position');

                if (position === "absolute" || position === "relative" || position === "fixed") {
                    // IE returns 0 when zIndex is not specified
                    // other browsers return a string
                    // we ignore the case of nested elements with an explicit value of 0
                    // <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
                    value = parseInt(KTUtil.css(elem, 'z-index'));

                    if (!isNaN(value) && value !== 0) {
                        return value;
                    }
                }

                elem = elem.parentNode;
            }

            return null;
        },

        /**
         * Checks whether the element has any parent with fixed positionfreg
         * @param {object} el jQuery element object
         * @returns {boolean}  
         */
        hasFixedPositionedParent: function(el) {
            while (el && el !== document) {
                position = KTUtil.css(el, 'position');

                if (position === "fixed") {
                    return true;
                }

                el = el.parentNode;
            }

            return false;
        },

        /**
         * Simulates delay
         */
        sleep: function(milliseconds) {
            var start = new Date().getTime();
            for (var i = 0; i < 1e7; i++) {
                if ((new Date().getTime() - start) > milliseconds) {
                    break;
                }
            }
        },

        /**
         * Gets randomly generated integer value within given min and max range
         * @param {number} min Range start value
         * @param {number} max Range end value
         * @returns {number}
         */
        getRandomInt: function(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },

        /**
         * Checks whether Angular library is included
         * @returns {boolean}  
         */
        isAngularVersion: function() {
            return window.Zone !== undefined ? true : false;
        },

        // jQuery Workarounds

        // Deep extend:  $.extend(true, {}, objA, objB);
        deepExtend: function(out) {
            out = out || {};

            for (var i = 1; i < arguments.length; i++) {
                var obj = arguments[i];

                if (!obj)
                    continue;

                for (var key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        if (typeof obj[key] === 'object')
                            out[key] = KTUtil.deepExtend(out[key], obj[key]);
                        else
                            out[key] = obj[key];
                    }
                }
            }

            return out;
        },

        // extend:  $.extend({}, objA, objB); 
        extend: function(out) {
            out = out || {};

            for (var i = 1; i < arguments.length; i++) {
                if (!arguments[i])
                    continue;

                for (var key in arguments[i]) {
                    if (arguments[i].hasOwnProperty(key))
                        out[key] = arguments[i][key];
                }
            }

            return out;
        },

        get: function(query) {
            var el;

            if (query === document) {
                return document;
            }

            if (!!(query && query.nodeType === 1)) {
                return query;
            }

            if (el = document.getElementById(query)) {
                return el;
            } else if (el = document.getElementsByTagName(query)) {
                return el[0];
            } else if (el = document.getElementsByClassName(query)) {
                return el[0];
            } else {
                return null;
            }
        },

        getByID: function(query) {
            if (!!(query && query.nodeType === 1)) {
                return query;
            }

            return document.getElementById(query);
        },

        getByTag: function(query) {
            var el;
            
            if (el = document.getElementsByTagName(query)) {
                return el[0];
            } else {
                return null;
            }
        },

        getByClass: function(query) {
            var el;
            
            if (el = document.getElementsByClassName(query)) {
                return el[0];
            } else {
                return null;
            }
        },

        /**
         * Checks whether the element has given classes
         * @param {object} el jQuery element object
         * @param {string} Classes string
         * @returns {boolean}  
         */
        hasClasses: function(el, classes) {
            if (!el) {
                return;
            }

            var classesArr = classes.split(" ");

            for (var i = 0; i < classesArr.length; i++) {
                if (KTUtil.hasClass(el, KTUtil.trim(classesArr[i])) == false) {
                    return false;
                }
            }

            return true;
        },

        hasClass: function(el, className) {
            if (!el) {
                return;
            }

            return el.classList ? el.classList.contains(className) : new RegExp('\\b' + className + '\\b').test(el.className);
        },

        addClass: function(el, className) {
            if (!el || typeof className === 'undefined') {
                return;
            }

            var classNames = className.split(' ');

            if (el.classList) {
                for (var i = 0; i < classNames.length; i++) {
                    if (classNames[i] && classNames[i].length > 0) {
                        el.classList.add(KTUtil.trim(classNames[i]));
                    }
                }
            } else if (!KTUtil.hasClass(el, className)) {
                for (var i = 0; i < classNames.length; i++) {
                    el.className += ' ' + KTUtil.trim(classNames[i]);
                }
            }
        },

        removeClass: function(el, className) {
          if (!el || typeof className === 'undefined') {
                return;
            }

            var classNames = className.split(' ');

            if (el.classList) {
                for (var i = 0; i < classNames.length; i++) {
                    el.classList.remove(KTUtil.trim(classNames[i]));
                }
            } else if (KTUtil.hasClass(el, className)) {
                for (var i = 0; i < classNames.length; i++) {
                    el.className = el.className.replace(new RegExp('\\b' + KTUtil.trim(classNames[i]) + '\\b', 'g'), '');
                }
            }
        },

        triggerCustomEvent: function(el, eventName, data) {
            if (window.CustomEvent) {
                var event = new CustomEvent(eventName, {
                    detail: data
                });
            } else {
                var event = document.createEvent('CustomEvent');
                event.initCustomEvent(eventName, true, true, data);
            }

            el.dispatchEvent(event);
        },

        triggerEvent: function(node, eventName) {
            // Make sure we use the ownerDocument from the provided node to avoid cross-window problems
            var doc;
            if (node.ownerDocument) {
                doc = node.ownerDocument;
            } else if (node.nodeType == 9) {
                // the node may be the document itself, nodeType 9 = DOCUMENT_NODE
                doc = node;
            } else {
                throw new Error("Invalid node passed to fireEvent: " + node.id);
            }

            if (node.dispatchEvent) {
                // Gecko-style approach (now the standard) takes more work
                var eventClass = "";

                // Different events have different event classes.
                // If this switch statement can't map an eventName to an eventClass,
                // the event firing is going to fail.
                switch (eventName) {
                case "click": // Dispatching of 'click' appears to not work correctly in Safari. Use 'mousedown' or 'mouseup' instead.
                case "mouseenter":
                case "mouseleave":
                case "mousedown":
                case "mouseup":
                    eventClass = "MouseEvents";
                    break;

                case "focus":
                case "change":
                case "blur":
                case "select":
                    eventClass = "HTMLEvents";
                    break;

                default:
                    throw "fireEvent: Couldn't find an event class for event '" + eventName + "'.";
                    break;
                }
                var event = doc.createEvent(eventClass);

                var bubbles = eventName == "change" ? false : true;
                event.initEvent(eventName, bubbles, true); // All events created as bubbling and cancelable.

                event.synthetic = true; // allow detection of synthetic events
                // The second parameter says go ahead with the default action
                node.dispatchEvent(event, true);
            } else if (node.fireEvent) {
                // IE-old school style
                var event = doc.createEventObject();
                event.synthetic = true; // allow detection of synthetic events
                node.fireEvent("on" + eventName, event);
            }
        },

        index: function( elm ){ 
            elm = KTUtil.get(elm);
            var c = elm.parentNode.children, i = 0;
            for(; i < c.length; i++ )
                if( c[i] == elm ) return i;
        },

        trim: function(string) {
            return string.trim();
        },

        eventTriggered: function(e) {
            if (e.currentTarget.dataset.triggered) {
                return true;
            } else {
                e.currentTarget.dataset.triggered = true;

                return false;
            }
        },

        remove: function(el) {
            if (el && el.parentNode) {
                el.parentNode.removeChild(el);
            }
        },

        find: function(parent, query) {
            parent = KTUtil.get(parent);
            if (parent) {
                return parent.querySelector(query);
            }            
        },

        findAll: function(parent, query) {
            parent = KTUtil.get(parent);
            if (parent) {
                return parent.querySelectorAll(query);
            } 
        },

        insertAfter: function(el, referenceNode) {
            return referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
        },

        parents: function(elem, selector) {
            // Element.matches() polyfill
            if (!Element.prototype.matches) {
                Element.prototype.matches =
                    Element.prototype.matchesSelector ||
                    Element.prototype.mozMatchesSelector ||
                    Element.prototype.msMatchesSelector ||
                    Element.prototype.oMatchesSelector ||
                    Element.prototype.webkitMatchesSelector ||
                    function(s) {
                        var matches = (this.document || this.ownerDocument).querySelectorAll(s),
                            i = matches.length;
                        while (--i >= 0 && matches.item(i) !== this) {}
                        return i > -1;
                    };
            }

            // Set up a parent array
            var parents = [];

            // Push each parent element to the array
            for ( ; elem && elem !== document; elem = elem.parentNode ) {
                if (selector) {
                    if (elem.matches(selector)) {
                        parents.push(elem);
                    }
                    continue;
                }
                parents.push(elem);
            }

            // Return our parent array
            return parents;
        },

        children: function(el, selector, log) {
            if (!el || !el.childNodes) {
                return;
            }

            var result = [],
                i = 0,
                l = el.childNodes.length;

            for (var i; i < l; ++i) {
                if (el.childNodes[i].nodeType == 1 && KTUtil.matches(el.childNodes[i], selector, log)) {
                    result.push(el.childNodes[i]);
                }
            }

            return result;
        },

        child: function(el, selector, log) {
            var children = KTUtil.children(el, selector, log);

            return children ? children[0] : null;
        },

        matches: function(el, selector, log) {
            var p = Element.prototype;
            var f = p.matches || p.webkitMatchesSelector || p.mozMatchesSelector || p.msMatchesSelector || function(s) {
                return [].indexOf.call(document.querySelectorAll(s), this) !== -1;
            };

            if (el && el.tagName) {
                return f.call(el, selector);
            } else {
                return false;
            }
        },

        data: function(element) {
            element = KTUtil.get(element);

            return {
                set: function(name, data) {
                    if (element === undefined) {
                        return;
                    }

                    if (element.customDataTag === undefined) {
                        KTUtilElementDataStoreID++;
                        element.customDataTag = KTUtilElementDataStoreID;
                    }

                    if (KTUtilElementDataStore[element.customDataTag] === undefined) {
                        KTUtilElementDataStore[element.customDataTag] = {};
                    }

                    KTUtilElementDataStore[element.customDataTag][name] = data;
                },

                get: function(name) {
                    if (element === undefined) {
                        return;
                    }

                    if (element.customDataTag === undefined) { 
                        return null;
                    }

                    return this.has(name) ? KTUtilElementDataStore[element.customDataTag][name] : null;
                },

                has: function(name) {
                    if (element === undefined) {
                        return false;
                    }
                    
                    if (element.customDataTag === undefined) { 
                        return false;
                    }

                    return (KTUtilElementDataStore[element.customDataTag] && KTUtilElementDataStore[element.customDataTag][name]) ? true : false;
                },

                remove: function(name) {
                    if (element && this.has(name)) {
                        delete KTUtilElementDataStore[element.customDataTag][name];
                    }
                }
            };
        },

        outerWidth: function(el, margin) {
            var width;

            if (margin === true) {
                var width = parseFloat(el.offsetWidth);
                width += parseFloat(KTUtil.css(el, 'margin-left')) + parseFloat(KTUtil.css(el, 'margin-right'));

                return parseFloat(width);
            } else {
                var width = parseFloat(el.offsetWidth);

                return width;
            }
        },

        offset: function(elem) {
            var rect, win;
            elem = KTUtil.get(elem);

            if ( !elem ) {
                return;
            }

            // Return zeros for disconnected and hidden (display: none) elements (gh-2310)
            // Support: IE <=11 only
            // Running getBoundingClientRect on a
            // disconnected node in IE throws an error

            if ( !elem.getClientRects().length ) {
                return { top: 0, left: 0 };
            }

            // Get document-relative position by adding viewport scroll to viewport-relative gBCR
            rect = elem.getBoundingClientRect();
            win = elem.ownerDocument.defaultView;

            return {
                top: rect.top + win.pageYOffset,
                left: rect.left + win.pageXOffset
            };
        },

        height: function(el) {
            return KTUtil.css(el, 'height');
        },

        visible: function(el) {
            return !(el.offsetWidth === 0 && el.offsetHeight === 0);
        },

        attr: function(el, name, value) {
            el = KTUtil.get(el);

            if (el == undefined) {
                return;
            }

            if (value !== undefined) {
                el.setAttribute(name, value);
            } else {
                return el.getAttribute(name);
            }
        },

        hasAttr: function(el, name) {
            el = KTUtil.get(el);

            if (el == undefined) {
                return;
            }

            return el.getAttribute(name) ? true : false;
        },

        removeAttr: function(el, name) {
            el = KTUtil.get(el);

            if (el == undefined) {
                return;
            }

            el.removeAttribute(name);
        },

        animate: function(from, to, duration, update, easing, done) {
            /**
             * TinyAnimate.easings
             *  Adapted from jQuery Easing
             */
            var easings = {};
            var easing;

            easings.linear = function(t, b, c, d) {
                return c * t / d + b;
            };

            easing = easings.linear;

            // Early bail out if called incorrectly
            if (typeof from !== 'number' ||
                typeof to !== 'number' ||
                typeof duration !== 'number' ||
                typeof update !== 'function') {
                return;
            }

            // Create mock done() function if necessary
            if (typeof done !== 'function') {
                done = function() {};
            }

            // Pick implementation (requestAnimationFrame | setTimeout)
            var rAF = window.requestAnimationFrame || function(callback) {
                window.setTimeout(callback, 1000 / 50);
            };

            // Animation loop
            var canceled = false;
            var change = to - from;

            function loop(timestamp) {
                var time = (timestamp || +new Date()) - start;

                if (time >= 0) {
                    update(easing(time, from, change, duration));
                }
                if (time >= 0 && time >= duration) {
                    update(to);
                    done();
                } else {
                    rAF(loop);
                }
            }

            update(from);

            // Start animation loop
            var start = window.performance && window.performance.now ? window.performance.now() : +new Date();

            rAF(loop);
        },

        actualCss: function(el, prop, cache) {
            el = KTUtil.get(el);
            var css = '';
            
            if (el instanceof HTMLElement === false) {
                return;
            }

            if (!el.getAttribute('kt-hidden-' + prop) || cache === false) {
                var value;

                // the element is hidden so:
                // making the el block so we can meassure its height but still be hidden
                css = el.style.cssText;
                el.style.cssText = 'position: absolute; visibility: hidden; display: block;';

                if (prop == 'width') {
                    value = el.offsetWidth;
                } else if (prop == 'height') {
                    value = el.offsetHeight;
                }

                el.style.cssText = css;

                // store it in cache
                el.setAttribute('kt-hidden-' + prop, value);

                return parseFloat(value);
            } else {
                // store it in cache
                return parseFloat(el.getAttribute('kt-hidden-' + prop));
            }
        },

        actualHeight: function(el, cache) {
            return KTUtil.actualCss(el, 'height', cache);
        },

        actualWidth: function(el, cache) {
            return KTUtil.actualCss(el, 'width', cache);
        },

        getScroll: function(element, method) {
            // The passed in `method` value should be 'Top' or 'Left'
            method = 'scroll' + method;
            return (element == window || element == document) ? (
                self[(method == 'scrollTop') ? 'pageYOffset' : 'pageXOffset'] ||
                (browserSupportsBoxModel && document.documentElement[method]) ||
                document.body[method]
            ) : element[method];
        },

        css: function(el, styleProp, value) {
            el = KTUtil.get(el);

            if (!el) {
                return;
            }

            if (value !== undefined) {
                el.style[styleProp] = value;
            } else {
                var value, defaultView = (el.ownerDocument || document).defaultView;
                // W3C standard way:
                if (defaultView && defaultView.getComputedStyle) {
                    // sanitize property name to css notation
                    // (hyphen separated words eg. font-Size)
                    styleProp = styleProp.replace(/([A-Z])/g, "-$1").toLowerCase();
                    return defaultView.getComputedStyle(el, null).getPropertyValue(styleProp);
                } else if (el.currentStyle) { // IE
                    // sanitize property name to camelCase
                    styleProp = styleProp.replace(/\-(\w)/g, function(str, letter) {
                        return letter.toUpperCase();
                    });
                    value = el.currentStyle[styleProp];
                    // convert other units to pixels on IE
                    if (/^\d+(em|pt|%|ex)?$/i.test(value)) {
                        return (function(value) {
                            var oldLeft = el.style.left,
                                oldRsLeft = el.runtimeStyle.left;
                            el.runtimeStyle.left = el.currentStyle.left;
                            el.style.left = value || 0;
                            value = el.style.pixelLeft + "px";
                            el.style.left = oldLeft;
                            el.runtimeStyle.left = oldRsLeft;
                            return value;
                        })(value);
                    }
                    return value;
                }
            }
        },

        slide: function(el, dir, speed, callback, recalcMaxHeight) {
            if (!el || (dir == 'up' && KTUtil.visible(el) === false) || (dir == 'down' && KTUtil.visible(el) === true)) {
                return;
            }

            speed = (speed ? speed : 600);
            var calcHeight = KTUtil.actualHeight(el);
            var calcPaddingTop = false;
            var calcPaddingBottom = false;

            if (KTUtil.css(el, 'padding-top') && KTUtil.data(el).has('slide-padding-top') !== true) {
                KTUtil.data(el).set('slide-padding-top', KTUtil.css(el, 'padding-top'));
            }

            if (KTUtil.css(el, 'padding-bottom') && KTUtil.data(el).has('slide-padding-bottom') !== true) {
                KTUtil.data(el).set('slide-padding-bottom', KTUtil.css(el, 'padding-bottom'));
            }

            if (KTUtil.data(el).has('slide-padding-top')) {
                calcPaddingTop = parseInt(KTUtil.data(el).get('slide-padding-top'));
            }

            if (KTUtil.data(el).has('slide-padding-bottom')) {
                calcPaddingBottom = parseInt(KTUtil.data(el).get('slide-padding-bottom'));
            }

            if (dir == 'up') { // up          
                el.style.cssText = 'display: block; overflow: hidden;';

                if (calcPaddingTop) {
                    KTUtil.animate(0, calcPaddingTop, speed, function(value) {
                        el.style.paddingTop = (calcPaddingTop - value) + 'px';
                    }, 'linear');
                }

                if (calcPaddingBottom) {
                    KTUtil.animate(0, calcPaddingBottom, speed, function(value) {
                        el.style.paddingBottom = (calcPaddingBottom - value) + 'px';
                    }, 'linear');
                }

                KTUtil.animate(0, calcHeight, speed, function(value) {
                    el.style.height = (calcHeight - value) + 'px';
                }, 'linear', function() {
                    callback();
                    el.style.height = '';
                    el.style.display = 'none';
                });


            } else if (dir == 'down') { // down
                el.style.cssText = 'display: block; overflow: hidden;';

                if (calcPaddingTop) {
                    KTUtil.animate(0, calcPaddingTop, speed, function(value) {
                        el.style.paddingTop = value + 'px';
                    }, 'linear', function() {
                        el.style.paddingTop = '';
                    });
                }

                if (calcPaddingBottom) {
                    KTUtil.animate(0, calcPaddingBottom, speed, function(value) {
                        el.style.paddingBottom = value + 'px';
                    }, 'linear', function() {
                        el.style.paddingBottom = '';
                    });
                }

                KTUtil.animate(0, calcHeight, speed, function(value) {
                    el.style.height = value + 'px';
                }, 'linear', function() {
                    callback();
                    el.style.height = '';
                    el.style.display = '';
                    el.style.overflow = '';
                });
            }
        },

        slideUp: function(el, speed, callback) {
            KTUtil.slide(el, 'up', speed, callback);
        },

        slideDown: function(el, speed, callback) {
            KTUtil.slide(el, 'down', speed, callback);
        },

        show: function(el, display) {
            if (typeof el !== 'undefined') {
                el.style.display = (display ? display : 'block');
            }
        },

        hide: function(el) {
            if (typeof el !== 'undefined') {
                el.style.display = 'none';
            }
        },

        addEvent: function(el, type, handler, one) {
            el = KTUtil.get(el);
            if (typeof el !== 'undefined') {
                el.addEventListener(type, handler);
            }
        },

        removeEvent: function(el, type, handler) {
            el = KTUtil.get(el);
            el.removeEventListener(type, handler);
        },

        on: function(element, selector, event, handler) {
            if (!selector) {
                return;
            }

            var eventId = KTUtil.getUniqueID('event');

            KTUtilDelegatedEventHandlers[eventId] = function(e) {
                var targets = element.querySelectorAll(selector);
                var target = e.target;

                while (target && target !== element) {
                    for (var i = 0, j = targets.length; i < j; i++) {
                        if (target === targets[i]) {
                            handler.call(target, e);
                        }
                    }

                    target = target.parentNode;
                }
            }

            KTUtil.addEvent(element, event, KTUtilDelegatedEventHandlers[eventId]);

            return eventId;
        },

        off: function(element, event, eventId) {
            if (!element || !KTUtilDelegatedEventHandlers[eventId]) {
                return;
            }

            KTUtil.removeEvent(element, event, KTUtilDelegatedEventHandlers[eventId]);

            delete KTUtilDelegatedEventHandlers[eventId];
        },

        one: function onetime(el, type, callback) {
            el = KTUtil.get(el);

            el.addEventListener(type, function callee(e) {
                // remove event
                if (e.target && e.target.removeEventListener) {
                    e.target.removeEventListener(e.type, callee);                    
                }
                
                // call handler
                return callback(e);
            });
        },

        hash: function(str) {
            var hash = 0,
                i, chr;

            if (str.length === 0) return hash;
            for (i = 0; i < str.length; i++) {
                chr = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + chr;
                hash |= 0; // Convert to 32bit integer
            }

            return hash;
        },

        animateClass: function(el, animationName, callback) {
            var animation;
            var animations = {
                animation: 'animationend',
                OAnimation: 'oAnimationEnd',
                MozAnimation: 'mozAnimationEnd',
                WebkitAnimation: 'webkitAnimationEnd',
                msAnimation: 'msAnimationEnd',
            };

            for (var t in animations) {
                if (el.style[t] !== undefined) {
                    animation = animations[t];
                }
            }

            KTUtil.addClass(el, 'animated ' + animationName);

            KTUtil.one(el, animation, function() {
                KTUtil.removeClass(el, 'animated ' + animationName);
            });

            if (callback) {
                KTUtil.one(el, animation, callback);
            }
        },

        transitionEnd: function(el, callback) {
            var transition;
            var transitions = {
                transition: 'transitionend',
                OTransition: 'oTransitionEnd',
                MozTransition: 'mozTransitionEnd',
                WebkitTransition: 'webkitTransitionEnd',
                msTransition: 'msTransitionEnd'
            };

            for (var t in transitions) {
                if (el.style[t] !== undefined) {
                    transition = transitions[t];
                }
            }

            KTUtil.one(el, transition, callback);
        },

        animationEnd: function(el, callback) {
            var animation;
            var animations = {
                animation: 'animationend',
                OAnimation: 'oAnimationEnd',
                MozAnimation: 'mozAnimationEnd',
                WebkitAnimation: 'webkitAnimationEnd',
                msAnimation: 'msAnimationEnd'
            };

            for (var t in animations) {
                if (el.style[t] !== undefined) {
                    animation = animations[t];
                }
            }

            KTUtil.one(el, animation, callback);
        },

        animateDelay: function(el, value) {
            var vendors = ['webkit-', 'moz-', 'ms-', 'o-', ''];
            for (var i = 0; i < vendors.length; i++) {
                KTUtil.css(el, vendors[i] + 'animation-delay', value);
            }
        },

        animateDuration: function(el, value) {
            var vendors = ['webkit-', 'moz-', 'ms-', 'o-', ''];
            for (var i = 0; i < vendors.length; i++) {
                KTUtil.css(el, vendors[i] + 'animation-duration', value);
            }
        },

        scrollTo: function(target, offset, duration) {
            var duration = duration ? duration : 500;
            var target = KTUtil.get(target);
            var targetPos = target ? KTUtil.offset(target).top : 0;
            var scrollPos = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0;
            var from, to;

            if (targetPos > scrollPos) {
                from = targetPos;
                to = scrollPos;
            } else {
                from = scrollPos;
                to = targetPos;
            }

            if (offset) {
                to += offset;
            }

            KTUtil.animate(from, to, duration, function(value) {
                document.documentElement.scrollTop = value;
                document.body.parentNode.scrollTop = value;
                document.body.scrollTop = value;
            }); //, easing, done
        },

        scrollTop: function(offset, duration) {
            KTUtil.scrollTo(null, offset, duration);
        },

        isArray: function(obj) {
            return obj && Array.isArray(obj);
        },

        ready: function(callback) {
            if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
                callback();
            } else {
                document.addEventListener('DOMContentLoaded', callback);
            }
        },

        isEmpty: function(obj) {
            for (var prop in obj) {
                if (obj.hasOwnProperty(prop)) {
                    return false;
                }
            }

            return true;
        },

        numberString: function(nStr) {
            nStr += '';
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        },

        detectIE: function() {
            var ua = window.navigator.userAgent;

            // Test values; Uncomment to check result …

            // IE 10
            // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';

            // IE 11
            // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';

            // Edge 12 (Spartan)
            // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

            // Edge 13
            // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';

            var msie = ua.indexOf('MSIE ');
            if (msie > 0) {
                // IE 10 or older => return version number
                return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
            }

            var trident = ua.indexOf('Trident/');
            if (trident > 0) {
                // IE 11 => return version number
                var rv = ua.indexOf('rv:');
                return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
            }

            var edge = ua.indexOf('Edge/');
            if (edge > 0) {
                // Edge (IE 12+) => return version number
                return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
            }

            // other browser
            return false;
        },

        isRTL: function() {
            return (KTUtil.attr(KTUtil.get('html'), 'direction') == 'rtl');
        },

        // 

        // Scroller
        scrollInit: function(element, options) {
            if(!element) return;
            // Define init function
            function init() {
                var ps;
                var height;

                if (options.height instanceof Function) {
                    height = parseInt(options.height.call());
                } else {
                    height = parseInt(options.height);
                }

                // Destroy scroll on table and mobile modes
                if ((options.mobileNativeScroll || options.disableForMobile) && KTUtil.isInResponsiveRange('tablet-and-mobile')) {
                    if (ps = KTUtil.data(element).get('ps')) {
                        if (options.resetHeightOnDestroy) {
                            KTUtil.css(element, 'height', 'auto');
                        } else {
                            KTUtil.css(element, 'overflow', 'auto');
                            if (height > 0) {
                                KTUtil.css(element, 'height', height + 'px');
                            }
                        }

                        ps.destroy();
                        ps = KTUtil.data(element).remove('ps');
                    } else if (height > 0){
                        KTUtil.css(element, 'overflow', 'auto');
                        KTUtil.css(element, 'height', height + 'px');
                    }

                    return;
                }

                if (height > 0) {
                    KTUtil.css(element, 'height', height + 'px');
                }

                if (options.desktopNativeScroll) {
                    KTUtil.css(element, 'overflow', 'auto');
                    return;
                }
                
                // Init scroll
                KTUtil.css(element, 'overflow', 'hidden');

                if (ps = KTUtil.data(element).get('ps')) {
                    ps.update();
                } else {
                    KTUtil.addClass(element, 'kt-scroll');
                    ps = new PerfectScrollbar(element, {
                        wheelSpeed: 0.5,
                        swipeEasing: true,
                        wheelPropagation: (options.windowScroll === false ? false : true),
                        minScrollbarLength: 40,
                        maxScrollbarLength: 300, 
                        suppressScrollX: KTUtil.attr(element, 'data-scroll-x') != 'true' ? true : false
                    });

                    KTUtil.data(element).set('ps', ps);
                }

                // Remember scroll position in cookie
                var uid = KTUtil.attr(element, 'id');

                if (options.rememberPosition === true && Cookies && uid) {
                    if (Cookies.get(uid)) {
                        var pos = parseInt(Cookies.get(uid));

                        if (pos > 0) {
                            element.scrollTop = pos;
                        }
                    } 

                    element.addEventListener('ps-scroll-y', function() {
                        Cookies.set(uid, element.scrollTop);
                    });                                      
                }
            }

            // Init
            init();

            // Handle window resize
            if (options.handleWindowResize) {
                KTUtil.addResizeHandler(function() {
                    init();
                });
            }
        },

        scrollUpdate: function(element) {
            var ps;
            if (ps = KTUtil.data(element).get('ps')) {
                ps.update();
            }
        },

        scrollUpdateAll: function(parent) {
            var scrollers = KTUtil.findAll(parent, '.ps');
            for (var i = 0, len = scrollers.length; i < len; i++) {
                KTUtil.scrollerUpdate(scrollers[i]);
            }
        },

        scrollDestroy: function(element) {
            var ps;
            if (ps = KTUtil.data(element).get('ps')) {
                ps.destroy();
                ps = KTUtil.data(element).remove('ps');
            }
        },

        setHTML: function(el, html) {
            if (KTUtil.get(el)) {
                KTUtil.get(el).innerHTML = html;
            }
        },

        getHTML: function(el) {
            if (KTUtil.get(el)) {
                return KTUtil.get(el).innerHTML;
            }
        } 
    }
}();

// Initialize KTUtil class on document ready
KTUtil.ready(function() {
    KTUtil.init();
});

// CSS3 Transitions only after page load(.kt-page-loading class added to body tag and remove with JS on page load)
window.onload = function() {    
    KTUtil.removeClass(KTUtil.get('body'), 'kt-page--loading');
}
"use strict";
var KTHeader = function(elementId, options) {
    // Main object
    var the = this;
    var init = false;

    // Get element object
    var element = KTUtil.get(elementId);
    var body = KTUtil.get('body');

    if (element === undefined) {
        return;
    }

    // Default options
    var defaultOptions = {
        classic: false,
        offset: {
            mobile: 150,
            desktop: 200
        },
        minimize: {
            mobile: false,
            desktop: false
        }
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Run plugin
         * @returns {KTHeader}
         */
        construct: function(options) {
            if (KTUtil.data(element).has('header')) {
                the = KTUtil.data(element).get('header');
            } else {
                // reset header
                Plugin.init(options);

                // build header
                Plugin.build();

                KTUtil.data(element).set('header', the);
            }

            return the;
        },

        /**
         * Handles subheader click toggle
         * @returns {KTHeader}
         */
        init: function(options) {
            the.events = [];

            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);
        },

        /**
         * Reset header
         * @returns {KTHeader}
         */
        build: function() {
            var lastScrollTop = 0;
            var eventTriggerState = true;
            var viewportHeight = KTUtil.getViewPort().height;

            if (the.options.minimize.mobile === false && the.options.minimize.desktop === false) {
                return;
            }

            window.addEventListener('scroll', function() {
                var offset = 0, on, off, st;

                if (KTUtil.isInResponsiveRange('desktop')) {
                    offset = the.options.offset.desktop;
                    on = the.options.minimize.desktop.on;
                    off = the.options.minimize.desktop.off;
                } else if (KTUtil.isInResponsiveRange('tablet-and-mobile')) {
                    offset = the.options.offset.mobile;
                    on = the.options.minimize.mobile.on;
                    off = the.options.minimize.mobile.off;
                }

                st = window.pageYOffset;

                if (
                    (KTUtil.isInResponsiveRange('tablet-and-mobile') && the.options.classic && the.options.classic.mobile) ||
                    (KTUtil.isInResponsiveRange('desktop') && the.options.classic && the.options.classic.desktop)

                ) {
                    if (st > offset) { // down scroll mode
                        KTUtil.addClass(body, on);
                        KTUtil.removeClass(body, off);
                        
                        if (eventTriggerState) {
                            Plugin.eventTrigger('minimizeOn', the);
                            eventTriggerState = false;
                        }
                    } else { // back scroll mode
                        KTUtil.addClass(body, off);
                        KTUtil.removeClass(body, on);

                        if (eventTriggerState == false) {
                            Plugin.eventTrigger('minimizeOff', the);
                            eventTriggerState = true; 
                        }
                    }
                } else {
                    if (st > offset && lastScrollTop < st) { // down scroll mode
                        KTUtil.addClass(body, on);
                        KTUtil.removeClass(body, off);

                        if (eventTriggerState) {
                            Plugin.eventTrigger('minimizeOn', the);
                            eventTriggerState = false;
                        }
                    } else { // back scroll mode
                        KTUtil.addClass(body, off);
                        KTUtil.removeClass(body, on);

                        if (eventTriggerState == false) {
                            Plugin.eventTrigger('minimizeOff', the);
                            eventTriggerState = true;
                        }
                    }

                    lastScrollTop = st;
                }
            });
        },

        /**
         * Trigger events
         */
        eventTrigger: function(name, args) {
            for (var i = 0; i < the.events.length; i++) {
                var event = the.events[i];
                if (event.name == name) {
                    if (event.one == true) {
                        if (event.fired == false) {
                            the.events[i].fired = true;
                            event.handler.call(this, the, args);
                        }
                    } else {
                        event.handler.call(this, the, args);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * Register event
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    ///////////////////////////////
    // ** Plugin Construction ** //
    ///////////////////////////////

    // Run plugin
    Plugin.construct.apply(the, [options]);

    // Init done
    init = true;

    // Return plugin instance
    return the;
};
"use strict";
var KTMenu = function(elementId, options) {
    // Main object
    var the = this;
    var init = false;

    // Get element object
    var element = KTUtil.get(elementId);
    var body = KTUtil.get('body');  

    if (!element) {
        return;
    }

    // Default options
    var defaultOptions = {       
        // scrollable area with Perfect Scroll
        scroll: {
            rememberPosition: false
        },
        
        // accordion submenu mode
        accordion: {
            slideSpeed: 200, // accordion toggle slide speed in milliseconds
            autoScroll: false, // enable auto scrolling(focus) to the clicked menu item
            autoScrollSpeed: 1200,
            expandAll: true // allow having multiple expanded accordions in the menu
        },

        // dropdown submenu mode
        dropdown: {
            timeout: 500 // timeout in milliseconds to show and hide the hoverable submenu dropdown
        }
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Run plugin
         * @returns {KTMenu}
         */
        construct: function(options) {
            if (KTUtil.data(element).has('menu')) {
                the = KTUtil.data(element).get('menu');
            } else {
                // reset menu
                Plugin.init(options);

                // reset menu
                Plugin.reset();

                // build menu
                Plugin.build();

                KTUtil.data(element).set('menu', the);
            }

            return the;
        },

        /**
         * Handles submenu click toggle
         * @returns {KTMenu}
         */
        init: function(options) {
            the.events = [];

            the.eventHandlers = {};

            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);

            // pause menu
            the.pauseDropdownHoverTime = 0;

            the.uid = KTUtil.getUniqueID();
        },

        update: function(options) {
            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);

            // pause menu
            the.pauseDropdownHoverTime = 0;

             // reset menu
            Plugin.reset();

            the.eventHandlers = {};

            // build menu
            Plugin.build();

            KTUtil.data(element).set('menu', the);
        },

        reload: function() {
             // reset menu
            Plugin.reset();

            // build menu
            Plugin.build();

            // reset submenu props
            Plugin.resetSubmenuProps();
        },

        /**
         * Reset menu
         * @returns {KTMenu}
         */
        build: function() {
            // General accordion submenu toggle
            the.eventHandlers['event_1'] = KTUtil.on( element, '.kt-menu__toggle', 'click', Plugin.handleSubmenuAccordion);

            // Dropdown mode(hoverable)
            if (Plugin.getSubmenuMode() === 'dropdown' || Plugin.isConditionalSubmenuDropdown()) {
                // dropdown submenu - hover toggle
                the.eventHandlers['event_2'] = KTUtil.on( element, '[data-ktmenu-submenu-toggle="hover"]', 'mouseover', Plugin.handleSubmenuDrodownHoverEnter);
                the.eventHandlers['event_3'] = KTUtil.on( element, '[data-ktmenu-submenu-toggle="hover"]', 'mouseout', Plugin.handleSubmenuDrodownHoverExit);

                // dropdown submenu - click toggle
                the.eventHandlers['event_4'] = KTUtil.on( element, '[data-ktmenu-submenu-toggle="click"] > .kt-menu__toggle, [data-ktmenu-submenu-toggle="click"] > .kt-menu__link .kt-menu__toggle', 'click', Plugin.handleSubmenuDropdownClick);
                the.eventHandlers['event_5'] = KTUtil.on( element, '[data-ktmenu-submenu-toggle="tab"] > .kt-menu__toggle, [data-ktmenu-submenu-toggle="tab"] > .kt-menu__link .kt-menu__toggle', 'click', Plugin.handleSubmenuDropdownTabClick);
            }

            // handle link click
            the.eventHandlers['event_6'] = KTUtil.on(element, '.kt-menu__item > .kt-menu__link:not(.kt-menu__toggle):not(.kt-menu__link--toggle-skip)', 'click', Plugin.handleLinkClick);

            // Init scrollable menu
            if (the.options.scroll && the.options.scroll.height) {
                Plugin.scrollInit();
            }
        },

        /**
         * Reset menu
         * @returns {KTMenu}
         */
        reset: function() { 
            KTUtil.off( element, 'click', the.eventHandlers['event_1']);

            // dropdown submenu - hover toggle
            KTUtil.off( element, 'mouseover', the.eventHandlers['event_2']);
            KTUtil.off( element, 'mouseout', the.eventHandlers['event_3']);

            // dropdown submenu - click toggle
            KTUtil.off( element, 'click', the.eventHandlers['event_4']);
            KTUtil.off( element, 'click', the.eventHandlers['event_5']);
            
            // handle link click
            KTUtil.off(element, 'click', the.eventHandlers['event_6']);
        },

        /**
         * Init scroll menu
         *
        */
        scrollInit: function() {
            if ( the.options.scroll && the.options.scroll.height ) {
                KTUtil.scrollDestroy(element);
                KTUtil.scrollInit(element, {mobileNativeScroll: true, windowScroll: false, resetHeightOnDestroy: true, handleWindowResize: true, height: the.options.scroll.height, rememberPosition: the.options.scroll.rememberPosition});
            } else {
                KTUtil.scrollDestroy(element);
            }           
        },

        /**
         * Update scroll menu
        */
        scrollUpdate: function() {
            if ( the.options.scroll && the.options.scroll.height ) {
                KTUtil.scrollUpdate(element);
            }
        },

        /**
         * Scroll top
        */
        scrollTop: function() {
            if ( the.options.scroll && the.options.scroll.height ) {
                KTUtil.scrollTop(element);
            }
        },

        /**
         * Get submenu mode for current breakpoint and menu state
         * @returns {KTMenu}
         */
        getSubmenuMode: function(el) {
            if ( KTUtil.isInResponsiveRange('desktop') ) {
                if (el && KTUtil.hasAttr(el, 'data-ktmenu-submenu-toggle') && KTUtil.attr(el, 'data-ktmenu-submenu-toggle') == 'hover') {
                    return 'dropdown';
                }

                if ( KTUtil.isset(the.options.submenu, 'desktop.state.body') ) {
                    if ( KTUtil.hasClasses(body, the.options.submenu.desktop.state.body) ) {
                        return the.options.submenu.desktop.state.mode;
                    } else {
                        return the.options.submenu.desktop.default;
                    }
                } else if ( KTUtil.isset(the.options.submenu, 'desktop') ) {
                    return the.options.submenu.desktop;
                }
            } else if ( KTUtil.isInResponsiveRange('tablet') && KTUtil.isset(the.options.submenu, 'tablet') ) {
                return the.options.submenu.tablet;
            } else if ( KTUtil.isInResponsiveRange('mobile') && KTUtil.isset(the.options.submenu, 'mobile') ) {
                return the.options.submenu.mobile;
            } else {
                return false;
            }
        },

        /**
         * Get submenu mode for current breakpoint and menu state
         * @returns {KTMenu}
         */
        isConditionalSubmenuDropdown: function() {
            if ( KTUtil.isInResponsiveRange('desktop') && KTUtil.isset(the.options.submenu, 'desktop.state.body') ) {
                return true;
            } else {
                return false;
            }
        },


        /**
         * Reset submenu attributes
         * @returns {KTMenu}
         */
        resetSubmenuProps: function(e) {
            var submenus = KTUtil.findAll(element, '.kt-menu__submenu');
            if ( submenus ) {
                for (var i = 0, len = submenus.length; i < len; i++) {
                    KTUtil.css(submenus[0], 'display', '');
                    KTUtil.css(submenus[0], 'overflow', '');                                        
                }
            }
        },

        /**
         * Handles submenu hover toggle
         * @returns {KTMenu}
         */
        handleSubmenuDrodownHoverEnter: function(e) {
            if ( Plugin.getSubmenuMode(this) === 'accordion' ) {
                return;
            }

            if ( the.resumeDropdownHover() === false ) {
                return;
            }

            var item = this;

            if ( item.getAttribute('data-hover') == '1' ) {
                item.removeAttribute('data-hover');
                clearTimeout( item.getAttribute('data-timeout') );
                item.removeAttribute('data-timeout');
                //Plugin.hideSubmenuDropdown(item, false);
            }

            // console.log('test!');

            Plugin.showSubmenuDropdown(item);
        },

        /**
         * Handles submenu hover toggle
         * @returns {KTMenu}
         */
        handleSubmenuDrodownHoverExit: function(e) {
            if ( the.resumeDropdownHover() === false ) {
                return;
            }

            if ( Plugin.getSubmenuMode(this) === 'accordion' ) {
                return;
            }

            var item = this;
            var time = the.options.dropdown.timeout;

            var timeout = setTimeout(function() {
                if ( item.getAttribute('data-hover') == '1' ) {
                    Plugin.hideSubmenuDropdown(item, true);
                } 
            }, time);

            item.setAttribute('data-hover', '1');
            item.setAttribute('data-timeout', timeout);  
        },

        /**
         * Handles submenu click toggle
         * @returns {KTMenu}
         */
        handleSubmenuDropdownClick: function(e) {
            if ( Plugin.getSubmenuMode(this) === 'accordion' ) {
                return;
            }
 
            var item = this.closest('.kt-menu__item');

            if ( item.getAttribute('data-ktmenu-submenu-mode') == 'accordion' ) {
                return;
            }

            if ( KTUtil.hasClass(item, 'kt-menu__item--hover') === false ) {
                KTUtil.addClass(item, 'kt-menu__item--open-dropdown');
                Plugin.showSubmenuDropdown(item);
            } else {
                KTUtil.removeClass(item, 'kt-menu__item--open-dropdown' );
                Plugin.hideSubmenuDropdown(item, true);
            }

            e.preventDefault();
        },

        /**
         * Handles tab click toggle
         * @returns {KTMenu}
         */
        handleSubmenuDropdownTabClick: function(e) {
            if (Plugin.getSubmenuMode(this) === 'accordion') {
                return;
            }

            var item = this.closest('.kt-menu__item');

            if (item.getAttribute('data-ktmenu-submenu-mode') == 'accordion') {
                return;
            }

            if (KTUtil.hasClass(item, 'kt-menu__item--hover') == false) {
                KTUtil.addClass(item, 'kt-menu__item--open-dropdown');
                Plugin.showSubmenuDropdown(item);
            }

            e.preventDefault();
        },

        /**
         * Handles link click
         * @returns {KTMenu}
         */
        handleLinkClick: function(e) {
            var submenu = this.closest('.kt-menu__item.kt-menu__item--submenu'); //

            var result = Plugin.eventTrigger('linkClick', this, e);
            if (result === false) {
                return;
            } 

            if ( submenu && Plugin.getSubmenuMode(submenu) === 'dropdown' ) {
                Plugin.hideSubmenuDropdowns();
            }
        },

        /**
         * Handles submenu dropdown close on link click
         * @returns {KTMenu}
         */
        handleSubmenuDropdownClose: function(e, el) {
            // exit if its not submenu dropdown mode
            if (Plugin.getSubmenuMode(el) === 'accordion') {
                return;
            }

            var shown = element.querySelectorAll('.kt-menu__item.kt-menu__item--submenu.kt-menu__item--hover:not(.kt-menu__item--tabs)');

            // check if currently clicked link's parent item ha
            if (shown.length > 0 && KTUtil.hasClass(el, 'kt-menu__toggle') === false && el.querySelectorAll('.kt-menu__toggle').length === 0) {
                // close opened dropdown menus
                for (var i = 0, len = shown.length; i < len; i++) {
                    Plugin.hideSubmenuDropdown(shown[0], true);
                }
            }
        },

        /**
         * helper functions
         * @returns {KTMenu}
         */
        handleSubmenuAccordion: function(e, el) {
            var query;
            var item = el ? el : this;

            if ( Plugin.getSubmenuMode(el) === 'dropdown' && (query = item.closest('.kt-menu__item') ) ) {
                if (query.getAttribute('data-ktmenu-submenu-mode') != 'accordion' ) {
                    e.preventDefault();
                    return;
                }
            }

            var li = item.closest('.kt-menu__item');
            var submenu = KTUtil.child(li, '.kt-menu__submenu, .kt-menu__inner');

            if (KTUtil.hasClass(item.closest('.kt-menu__item'), 'kt-menu__item--open-always')) {
                return;
            }

            if ( li && submenu ) {
                e.preventDefault();
                var speed = the.options.accordion.slideSpeed;
                var hasClosables = false;

                if ( KTUtil.hasClass(li, 'kt-menu__item--open') === false ) {
                    // hide other accordions                    
                    if ( the.options.accordion.expandAll === false ) {
                        var subnav = item.closest('.kt-menu__nav, .kt-menu__subnav');
                        var closables = KTUtil.children(subnav, '.kt-menu__item.kt-menu__item--open.kt-menu__item--submenu:not(.kt-menu__item--here):not(.kt-menu__item--open-always)');

                        if ( subnav && closables ) {
                            for (var i = 0, len = closables.length; i < len; i++) {
                                var el_ = closables[0];
                                var submenu_ = KTUtil.child(el_, '.kt-menu__submenu');
                                if ( submenu_ ) {
                                    KTUtil.slideUp(submenu_, speed, function() {
                                        Plugin.scrollUpdate();
                                        KTUtil.removeClass(el_, 'kt-menu__item--open');
                                    });                    
                                }
                            }
                        }
                    }

                    KTUtil.slideDown(submenu, speed, function() {
                        Plugin.scrollToItem(item);
                        Plugin.scrollUpdate();
                        
                        Plugin.eventTrigger('submenuToggle', submenu, e);
                    });
                
                    KTUtil.addClass(li, 'kt-menu__item--open');

                } else {
                    KTUtil.slideUp(submenu, speed, function() {
                        Plugin.scrollToItem(item);
                        Plugin.eventTrigger('submenuToggle', submenu, e);
                    });

                    KTUtil.removeClass(li, 'kt-menu__item--open');
                }
            }
        },

        /**
         * scroll to item function
         * @returns {KTMenu}
         */
        scrollToItem: function(item) {
            // handle auto scroll for accordion submenus
            if ( KTUtil.isInResponsiveRange('desktop') && the.options.accordion.autoScroll && element.getAttribute('data-ktmenu-scroll') !== '1' ) {
                KTUtil.scrollTo(item, the.options.accordion.autoScrollSpeed);
            }
        },

        /**
         * Hide submenu dropdown
         * @returns {KTMenu}
         */
        hideSubmenuDropdown: function(item, classAlso) {
            // remove submenu activation class
            if ( classAlso ) {
                KTUtil.removeClass(item, 'kt-menu__item--hover');
                KTUtil.removeClass(item, 'kt-menu__item--active-tab');
            }

            // clear timeout
            item.removeAttribute('data-hover');

            if ( item.getAttribute('data-ktmenu-dropdown-toggle-class') ) {
                KTUtil.removeClass(body, item.getAttribute('data-ktmenu-dropdown-toggle-class'));
            }

            var timeout = item.getAttribute('data-timeout');
            item.removeAttribute('data-timeout');
            clearTimeout(timeout);
        },

        /**
         * Hide submenu dropdowns
         * @returns {KTMenu}
         */
        hideSubmenuDropdowns: function() {
            var items;
            if ( items = element.querySelectorAll('.kt-menu__item--submenu.kt-menu__item--hover:not(.kt-menu__item--tabs):not([data-ktmenu-submenu-toggle="tab"])') ) {
                for (var j = 0, cnt = items.length; j < cnt; j++) {
                    Plugin.hideSubmenuDropdown(items[j], true);
                }
            }
        },

        /**
         * helper functions
         * @returns {KTMenu}
         */
        showSubmenuDropdown: function(item) {
            // close active submenus
            var list = element.querySelectorAll('.kt-menu__item--submenu.kt-menu__item--hover, .kt-menu__item--submenu.kt-menu__item--active-tab');

            if ( list ) {
                for (var i = 0, len = list.length; i < len; i++) {
                    var el = list[i];
                    if ( item !== el && el.contains(item) === false && item.contains(el) === false ) {
                        Plugin.hideSubmenuDropdown(el, true);
                    }
                }
            } 

            // add submenu activation class
            KTUtil.addClass(item, 'kt-menu__item--hover');
            
            if ( item.getAttribute('data-ktmenu-dropdown-toggle-class') ) {
                KTUtil.addClass(body, item.getAttribute('data-ktmenu-dropdown-toggle-class'));
            }
        },

        /**
         * Handles submenu slide toggle
         * @returns {KTMenu}
         */
        createSubmenuDropdownClickDropoff: function(el) {
            var query;
            var zIndex = (query = KTUtil.child(el, '.kt-menu__submenu') ? KTUtil.css(query, 'z-index') : 0) - 1;

            var dropoff = document.createElement('<div class="kt-menu__dropoff" style="background: transparent; position: fixed; top: 0; bottom: 0; left: 0; right: 0; z-index: ' + zIndex + '"></div>');

            body.appendChild(dropoff);

            KTUtil.addEvent(dropoff, 'click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                KTUtil.remove(this);
                Plugin.hideSubmenuDropdown(el, true);
            });
        },

        /**
         * Handles submenu hover toggle
         * @returns {KTMenu}
         */
        pauseDropdownHover: function(time) {
            var date = new Date();

            the.pauseDropdownHoverTime = date.getTime() + time;
        },

        /**
         * Handles submenu hover toggle
         * @returns {KTMenu}
         */
        resumeDropdownHover: function() {
            var date = new Date();

            return (date.getTime() > the.pauseDropdownHoverTime ? true : false);
        },

        /**
         * Reset menu's current active item
         * @returns {KTMenu}
         */
        resetActiveItem: function(item) {
            var list;
            var parents;

            list = element.querySelectorAll('.kt-menu__item--active');
            
            for (var i = 0, len = list.length; i < len; i++) {
                var el = list[0];
                KTUtil.removeClass(el, 'kt-menu__item--active');
                KTUtil.hide( KTUtil.child(el, '.kt-menu__submenu') );
                parents = KTUtil.parents(el, '.kt-menu__item--submenu') || [];

                for (var i_ = 0, len_ = parents.length; i_ < len_; i_++) {
                    var el_ = parents[i];
                    KTUtil.removeClass(el_, 'kt-menu__item--open');
                    KTUtil.hide( KTUtil.child(el_, '.kt-menu__submenu') );
                }
            }

            // close open submenus
            if ( the.options.accordion.expandAll === false ) {
                if ( list = element.querySelectorAll('.kt-menu__item--open') ) {
                    for (var i = 0, len = list.length; i < len; i++) {
                        KTUtil.removeClass(parents[0], 'kt-menu__item--open');
                    }
                }
            }
        },

        /**
         * Sets menu's active item
         * @returns {KTMenu}
         */
        setActiveItem: function(item) {
            // reset current active item
            Plugin.resetActiveItem();

            var parents = KTUtil.parents(item, '.kt-menu__item--submenu') || [];
            for (var i = 0, len = parents.length; i < len; i++) {
                KTUtil.addClass(KTUtil.get(parents[i]), 'kt-menu__item--open');
            }

            KTUtil.addClass(KTUtil.get(item), 'kt-menu__item--active');
        },

        /**
         * Returns page breadcrumbs for the menu's active item
         * @returns {KTMenu}
         */
        getBreadcrumbs: function(item) {
            var query;
            var breadcrumbs = [];
            var link = KTUtil.child(item, '.kt-menu__link');

            breadcrumbs.push({
                text: (query = KTUtil.child(link, '.kt-menu__link-text') ? query.innerHTML : ''),
                title: link.getAttribute('title'),
                href: link.getAttribute('href')
            });

            var parents = KTUtil.parents(item, '.kt-menu__item--submenu');
            for (var i = 0, len = parents.length; i < len; i++) {
                var submenuLink = KTUtil.child(parents[i], '.kt-menu__link');

                breadcrumbs.push({
                    text: (query = KTUtil.child(submenuLink, '.kt-menu__link-text') ? query.innerHTML : ''),
                    title: submenuLink.getAttribute('title'),
                    href: submenuLink.getAttribute('href')
                });
            }

            return  breadcrumbs.reverse();
        },

        /**
         * Returns page title for the menu's active item
         * @returns {KTMenu}
         */
        getPageTitle: function(item) {
            var query;

            return (query = KTUtil.child(item, '.kt-menu__link-text') ? query.innerHTML : '');
        },

        /**
         * Trigger events
         */
        eventTrigger: function(name, target, e) {
            for (var i = 0; i < the.events.length; i++ ) {
                var event = the.events[i];
                if ( event.name == name ) {
                    if ( event.one == true ) {
                        if ( event.fired == false ) {
                            the.events[i].fired = true;
                            return event.handler.call(this, target, e);
                        }
                    } else {
                        return event.handler.call(this, target, e);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });
        },

        removeEvent: function(name) {
            if (the.events[name]) {
                delete the.events[name];
            }
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * Update scroll
     */
    the.scrollUpdate = function() {
        return Plugin.scrollUpdate();
    };

    /**
     * Re-init scroll
     */
    the.scrollReInit = function() {
        return Plugin.scrollInit();
    };

    /**
     * Scroll top
     */
    the.scrollTop = function() {
        return Plugin.scrollTop();
    };

    /**
     * Set active menu item
     */
    the.setActiveItem = function(item) {
        return Plugin.setActiveItem(item);
    };

    the.reload = function() {
        return Plugin.reload();
    };

    the.update = function(options) {
        return Plugin.update(options);
    };

    /**
     * Set breadcrumb for menu item
     */
    the.getBreadcrumbs = function(item) {
        return Plugin.getBreadcrumbs(item);
    };

    /**
     * Set page title for menu item
     */
    the.getPageTitle = function(item) {
        return Plugin.getPageTitle(item);
    };

    /**
     * Get submenu mode
     */
    the.getSubmenuMode = function(el) {
        return Plugin.getSubmenuMode(el);
    };

    /**
     * Hide dropdown
     * @returns {Object}
     */
    the.hideDropdown = function(item) {
        Plugin.hideSubmenuDropdown(item, true);
    };

    /**
     * Hide dropdowns
     * @returns {Object}
     */
    the.hideDropdowns = function() {
        Plugin.hideSubmenuDropdowns();
    };

    /**
     * Disable menu for given time
     * @returns {Object}
     */
    the.pauseDropdownHover = function(time) {
        Plugin.pauseDropdownHover(time);
    };

    /**
     * Disable menu for given time
     * @returns {Object}
     */
    the.resumeDropdownHover = function() {
        return Plugin.resumeDropdownHover();
    };

    /**
     * Register event
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    the.off = function(name) {
        return Plugin.removeEvent(name);
    };

    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    ///////////////////////////////
    // ** Plugin Construction ** //
    ///////////////////////////////

    // Run plugin
    Plugin.construct.apply(the, [options]);

    // Handle plugin on window resize
    KTUtil.addResizeHandler(function() {
        if (init) {
            the.reload();
        }  
    });

    // Init done
    init = true;

    // Return plugin instance
    return the;
};

// Plugin global lazy initialization
document.addEventListener("click", function (e) {
    var body = KTUtil.get('body');
    var query;
    if ( query = body.querySelectorAll('.kt-menu__nav .kt-menu__item.kt-menu__item--submenu.kt-menu__item--hover:not(.kt-menu__item--tabs)[data-ktmenu-submenu-toggle="click"]') ) {
        for (var i = 0, len = query.length; i < len; i++) {
            var element = query[i].closest('.kt-menu__nav').parentNode;

            if ( element ) {
                var the = KTUtil.data(element).get('menu');

                if ( !the ) {
                    break;
                }

                if ( !the || the.getSubmenuMode() !== 'dropdown' ) {
                    break;
                }

                if ( e.target !== element && element.contains(e.target) === false ) {
                    the.hideDropdowns();
                }
            }            
        }
    } 
});
"use strict";
var KTOffcanvas = function(elementId, options) {
    // Main object
    var the = this;
    var init = false;

    // Get element object
    var element = KTUtil.get(elementId);
    var body = KTUtil.get('body');

    if (!element) {
        return;
    }

    // Default options
    var defaultOptions = {};

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        construct: function(options) {
            if (KTUtil.data(element).has('offcanvas')) {
                the = KTUtil.data(element).get('offcanvas');
            } else {
                // reset offcanvas
                Plugin.init(options);
                
                // build offcanvas
                Plugin.build();

                KTUtil.data(element).set('offcanvas', the);
            }

            return the;
        },

        init: function(options) {
            the.events = [];

            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);
            the.overlay;

            the.classBase = the.options.baseClass;
            the.classShown = the.classBase + '--on';
            the.classOverlay = the.classBase + '-overlay';

            the.state = KTUtil.hasClass(element, the.classShown) ? 'shown' : 'hidden';
        },

        build: function() {
            // offcanvas toggle
            if (the.options.toggleBy) {
                if (typeof the.options.toggleBy === 'string') { 
                    KTUtil.addEvent( the.options.toggleBy, 'click', function(e) {
                        e.preventDefault();
                        Plugin.toggle();
                    }); 
                } else if (the.options.toggleBy && the.options.toggleBy[0]) {
                    if (the.options.toggleBy[0].target) {
                        for (var i in the.options.toggleBy) { 
                            KTUtil.addEvent( the.options.toggleBy[i].target, 'click', function(e) {
                                e.preventDefault();
                                Plugin.toggle();
                            }); 
                        }
                    } else {
                        for (var i in the.options.toggleBy) { 
                            KTUtil.addEvent( the.options.toggleBy[i], 'click', function(e) {
                                e.preventDefault();
                                Plugin.toggle();
                            }); 
                        }
                    }
                    
                } else if (the.options.toggleBy && the.options.toggleBy.target) {
                    KTUtil.addEvent( the.options.toggleBy.target, 'click', function(e) {
                        e.preventDefault();
                        Plugin.toggle();
                    }); 
                } 
            }

            // offcanvas close
            var closeBy = KTUtil.get(the.options.closeBy);
            if (closeBy) {
                KTUtil.addEvent(closeBy, 'click', function(e) {
                    e.preventDefault();
                    Plugin.hide();
                });
            }

            // Window resize
            KTUtil.addResizeHandler(function() {
                if (parseInt(KTUtil.css(element, 'left')) >= 0 || parseInt(KTUtil.css(element, 'right') >= 0) || KTUtil.css(element, 'position') != 'fixed') {
                    KTUtil.css(element, 'opacity', '1');
                }
            });
        },

        isShown: function(target) {
            return (the.state == 'shown' ? true : false);
        },

        toggle: function() {;
            Plugin.eventTrigger('toggle'); 

            if (the.state == 'shown') {
                Plugin.hide(this);
            } else {
                Plugin.show(this);
            }
        },

        show: function(target) {
            if (the.state == 'shown') {
                return;
            }

            Plugin.eventTrigger('beforeShow');

            Plugin.togglerClass(target, 'show');

            // Offcanvas panel
            KTUtil.addClass(body, the.classShown);
            KTUtil.addClass(element, the.classShown);
            KTUtil.css(element, 'opacity', '1');

            the.state = 'shown';

            if (the.options.overlay) {
                the.overlay = KTUtil.insertAfter(document.createElement('DIV') , element );
                KTUtil.addClass(the.overlay, the.classOverlay);
                KTUtil.addEvent(the.overlay, 'click', function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                    Plugin.hide(target);       
                });
            }

            Plugin.eventTrigger('afterShow');
        },

        hide: function(target) {
            if (the.state == 'hidden') {
                return;
            }

            Plugin.eventTrigger('beforeHide');

            Plugin.togglerClass(target, 'hide');

            KTUtil.removeClass(body, the.classShown);
            KTUtil.removeClass(element, the.classShown);

            the.state = 'hidden';

            if (the.options.overlay && the.overlay) {
                KTUtil.remove(the.overlay);
            }

            KTUtil.transitionEnd(element, function() {
                KTUtil.css(element, 'opacity', '0');
            });

            Plugin.eventTrigger('afterHide');
        },

        togglerClass: function(target, mode) {
            // Toggler
            var id = KTUtil.attr(target, 'id');
            var toggleBy;

            if (the.options.toggleBy && the.options.toggleBy[0] && the.options.toggleBy[0].target) {
                for (var i in the.options.toggleBy) {
                    if (the.options.toggleBy[i].target === id) {
                        toggleBy = the.options.toggleBy[i];
                    }        
                }
            } else if (the.options.toggleBy && the.options.toggleBy.target) {
                toggleBy = the.options.toggleBy;
            }

            if (toggleBy) {                
                var el = KTUtil.get(toggleBy.target);
                
                if (mode === 'show') {
                    KTUtil.addClass(el, toggleBy.state);
                }

                if (mode === 'hide') {
                    KTUtil.removeClass(el, toggleBy.state);
                }
            }
        },

        eventTrigger: function(name, args) {
            for (var i = 0; i < the.events.length; i++) {
                var event = the.events[i];
                if (event.name == name) {
                    if (event.one == true) {
                        if (event.fired == false) {
                            the.events[i].fired = true;
                            event.handler.call(this, the, args);
                        }
                    } else {
                        event.handler.call(this, the, args);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////
    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    the.isShown = function() {
        return Plugin.isShown();
    };

    the.hide = function() {
        return Plugin.hide();
    };

    the.show = function() {
        return Plugin.show();
    };

    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    ///////////////////////////////
    // ** Plugin Construction ** //
    ///////////////////////////////

    // Run plugin
    Plugin.construct.apply(the, [options]);

    // Init done
    init = true;

    // Return plugin instance
    return the;
};
"use strict";
var KTScrolltop = function(elementId, options) {
    // Main object
    var the = this;
    var init = false;

    // Get element object
    var element = KTUtil.get(elementId);
    var body = KTUtil.get('body');

    if (!element) {
        return;
    }

    // Default options
    var defaultOptions = {
        offset: 300,
        speed: 600,
        toggleClass: 'kt-scrolltop--on'
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Run plugin
         * @returns {mscrolltop}
         */
        construct: function(options) {
            if (KTUtil.data(element).has('scrolltop')) {
                the = KTUtil.data(element).get('scrolltop');
            } else {
                // reset scrolltop
                Plugin.init(options);

                // build scrolltop
                Plugin.build();

                KTUtil.data(element).set('scrolltop', the);
            }

            return the;
        },

        /**
         * Handles subscrolltop click toggle
         * @returns {mscrolltop}
         */
        init: function(options) {
            the.events = [];

            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);
        },

        build: function() {
            // handle window scroll
            if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
                window.addEventListener('touchend', function() {
                    Plugin.handle();
                });

                window.addEventListener('touchcancel', function() {
                    Plugin.handle();
                });

                window.addEventListener('touchleave', function() {
                    Plugin.handle();
                });
            } else {
                window.addEventListener('scroll', function() { 
                    Plugin.handle();
                });
            }

            // handle button click 
            KTUtil.addEvent(element, 'click', Plugin.scroll);
        },

        /**
         * Handles scrolltop click scrollTop
         */
        handle: function() {
            var pos = window.pageYOffset; // current vertical position
            if (pos > the.options.offset) {
                KTUtil.addClass(body, the.options.toggleClass);
            } else {
                KTUtil.removeClass(body, the.options.toggleClass);
            }
        },

        /**
         * Handles scrolltop click scrollTop
         */
        scroll: function(e) {
            e.preventDefault();

            KTUtil.scrollTop(0, the.options.speed);
        },


        /**
         * Trigger events
         */
        eventTrigger: function(name, args) {
            for (var i = 0; i < the.events.length; i++) {
                var event = the.events[i];
                if (event.name == name) {
                    if (event.one == true) {
                        if (event.fired == false) {
                            the.events[i].fired = true;
                            event.handler.call(this, the, args);
                        }
                    } else {
                        event.handler.call(this, the, args);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * Get subscrolltop mode
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    /**
     * Set scrolltop content
     * @returns {mscrolltop}
     */
    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    ///////////////////////////////
    // ** Plugin Construction ** //
    ///////////////////////////////

    // Run plugin
    Plugin.construct.apply(the, [options]);

    // Init done
    init = true;

    // Return plugin instance
    return the;
};
"use strict";

// plugin setup
var KTToggle = function(elementId, options) {
    // Main object
    var the = this;
    var init = false;

    // Get element object
    var element = KTUtil.get(elementId);
    var body = KTUtil.get('body');  

    if (!element) {
        return;
    }

    // Default options
    var defaultOptions = {
        togglerState: '',
        targetState: ''
    };    

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Construct
         */

        construct: function(options) {
            if (KTUtil.data(element).has('toggle')) {
                the = KTUtil.data(element).get('toggle');
            } else {
                // reset menu
                Plugin.init(options);

                // build menu
                Plugin.build();

                KTUtil.data(element).set('toggle', the);
            }

            return the;
        },

        /**
         * Handles subtoggle click toggle
         */
        init: function(options) {
            the.element = element;
            the.events = [];

            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);

            the.target = KTUtil.get(the.options.target);
            the.targetState = the.options.targetState;
            the.togglerState = the.options.togglerState;

            the.state = KTUtil.hasClasses(the.target, the.targetState) ? 'on' : 'off';
        },

        /**
         * Setup toggle
         */
        build: function() {
            KTUtil.addEvent(element, 'mouseup', Plugin.toggle);
        },
        
        /**
         * Handles offcanvas click toggle
         */
        toggle: function(e) {
            Plugin.eventTrigger('beforeToggle');

            if (the.state == 'off') {
                Plugin.toggleOn();
            } else {
                Plugin.toggleOff();
            }

            Plugin.eventTrigger('afterToggle');

            e.preventDefault();

            return the;
        },

        /**
         * Handles toggle click toggle
         */
        toggleOn: function() {
            Plugin.eventTrigger('beforeOn');

            KTUtil.addClass(the.target, the.targetState);

            if (the.togglerState) {
                KTUtil.addClass(element, the.togglerState);
            }

            the.state = 'on';

            Plugin.eventTrigger('afterOn');

            Plugin.eventTrigger('toggle');

            return the;
        },

        /**
         * Handles toggle click toggle
         */
        toggleOff: function() {
            Plugin.eventTrigger('beforeOff');

            KTUtil.removeClass(the.target, the.targetState);

            if (the.togglerState) {
                KTUtil.removeClass(element, the.togglerState);
            }

            the.state = 'off';

            Plugin.eventTrigger('afterOff');

            Plugin.eventTrigger('toggle');

            return the;
        },

        /**
         * Trigger events
         */
        eventTrigger: function(name) {
            for (var i = 0; i < the.events.length; i++) {
                var event = the.events[i];

                if (event.name == name) {
                    if (event.one == true) {
                        if (event.fired == false) {
                            the.events[i].fired = true;                            
                            event.handler.call(this, the);
                        }
                    } else {
                        event.handler.call(this, the);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });

            return the;
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * Get toggle state 
     */
    the.getState = function() {
        return the.state;
    };

    /**
     * Toggle 
     */
    the.toggle = function() {
        return Plugin.toggle();
    };

    /**
     * Toggle on 
     */
    the.toggleOn = function() {
        return Plugin.toggleOn();
    };

    /**
     * Toggle off 
     */
    the.toggleOff = function() {
        return Plugin.toggleOff();
    };

    /**
     * Attach event
     * @returns {KTToggle}
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    /**
     * Attach event that will be fired once
     * @returns {KTToggle}
     */
    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    // Construct plugin
    Plugin.construct.apply(the, [options]);

    return the;
};
"use strict";

// plugin setup
var KTDialog = function(options) {
    // Main object
    var the = this;

    // Get element object
    var element;
    var body = KTUtil.get('body');  

    // Default options
    var defaultOptions = {
        'placement' : 'top center',
        'type'  : 'loader',
        'width' : 100,
        'state' : 'default',
        'message' : 'Loading...' 
    };    

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Construct
         */

        construct: function(options) {
            Plugin.init(options);

            return the;
        },

        /**
         * Handles subtoggle click toggle
         */
        init: function(options) {
            the.events = [];

            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);

            the.state = false;
        },

        /**
         * Show dialog
         */
        show: function() {
            Plugin.eventTrigger('show');

            element = document.createElement("DIV");
            KTUtil.setHTML(element, the.options.message);
            
            KTUtil.addClass(element, 'kt-dialog kt-dialog--shown');
            KTUtil.addClass(element, 'kt-dialog--' + the.options.state);
            KTUtil.addClass(element, 'kt-dialog--' + the.options.type); 

            if (the.options.placement == 'top center') {
                KTUtil.addClass(element, 'kt-dialog--top-center');
            }

            body.appendChild(element);

            the.state = 'shown';

            Plugin.eventTrigger('shown');

            return the;
        },

        /**
         * Hide dialog
         */
        hide: function() {
            if (element) {
                Plugin.eventTrigger('hide');

                element.remove();
                the.state = 'hidden';

                Plugin.eventTrigger('hidden');
            }

            return the;
        },

        /**
         * Trigger events
         */
        eventTrigger: function(name) {
            for (var i = 0; i < the.events.length; i++) {
                var event = the.events[i];

                if (event.name == name) {
                    if (event.one == true) {
                        if (event.fired == false) {
                            the.events[i].fired = true;                            
                            event.handler.call(this, the);
                        }
                    } else {
                        event.handler.call(this, the);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });

            return the;
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * Check shown state 
     */
    the.shown = function() {
        return the.state == 'shown';
    };

    /**
     * Check hidden state 
     */
    the.hidden = function() {
        return the.state == 'hidden';
    };

    /**
     * Show dialog 
     */
    the.show = function() {
        return Plugin.show();
    };

    /**
     * Hide dialog
     */
    the.hide = function() {
        return Plugin.hide();
    };

    /**
     * Attach event
     * @returns {KTToggle}
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    /**
     * Attach event that will be fired once
     * @returns {KTToggle}
     */
    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    // Construct plugin
    Plugin.construct.apply(the, [options]);

    return the;
};
// plugin setup
var KTWizard = function(elementId, options) {
    // Main object
    var the = this;
    var init = false;

    // Get element object
    var element = KTUtil.get(elementId);
    var body = KTUtil.get('body');

    if (!element) {
        return; 
    }

    // Default options
    var defaultOptions = {
        startStep: 1,
        manualStepForward: false
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Construct
         */

        construct: function(options) {
            if (KTUtil.data(element).has('wizard')) {
                the = KTUtil.data(element).get('wizard');
            } else {
                // reset menu
                Plugin.init(options);

                // build menu
                Plugin.build();

                KTUtil.data(element).set('wizard', the);
            }

            return the;
        },

        /**
         * Init wizard
         */
        init: function(options) {
            the.element = element;
            the.events = [];

            // merge default and user defined options
            the.options = KTUtil.deepExtend({}, defaultOptions, options);

            // Elements
            the.steps = KTUtil.findAll(element, '[data-ktwizard-type="step"]');

            the.btnSubmit = KTUtil.find(element, '[data-ktwizard-type="action-submit"]');
            the.btnNext = KTUtil.find(element, '[data-ktwizard-type="action-next"]');
            the.btnPrev = KTUtil.find(element, '[data-ktwizard-type="action-prev"]');
            the.btnLast = KTUtil.find(element, '[data-ktwizard-type="action-last"]');
            the.btnFirst = KTUtil.find(element, '[data-ktwizard-type="action-first"]');

            // Variables
            the.events = [];
            the.currentStep = 1;
            the.stopped = false;
            the.totalSteps = the.steps.length;

            // Init current step
            if (the.options.startStep > 1) {
                Plugin.goTo(the.options.startStep);
            }

            // Init UI
            Plugin.updateUI();
        },

        /**
         * Build Form Wizard
         */
        build: function() {
            // Next button event handler
            KTUtil.addEvent(the.btnNext, 'click', function(e) {
                e.preventDefault();
                Plugin.goNext();
            });

            // Prev button event handler
            KTUtil.addEvent(the.btnPrev, 'click', function(e) {
                e.preventDefault();
                Plugin.goPrev();
            });

            // First button event handler
            KTUtil.addEvent(the.btnFirst, 'click', function(e) {
                e.preventDefault();
                Plugin.goFirst();
            });

            // Last button event handler
            KTUtil.addEvent(the.btnLast, 'click', function(e) {
                e.preventDefault();
                Plugin.goLast();
            });

            KTUtil.on(element, 'a[data-ktwizard-type="step"]', 'click', function() {
                var index = KTUtil.index(this) + 1;
                if (index !== the.currentStep) {
                    Plugin.goTo(index);
                }                
            });
        },

        /**
         * Handles wizard click wizard
         */
        goTo: function(number) {
            // Skip if this step is already shown
            if (number === the.currentStep || number > the.totalSteps || number < 0) {
                return;
            }

            // Validate step number
            if (number) {
                number = parseInt(number);
            } else {
                number = Plugin.getNextStep();
            }

            // Before next and prev events
            var callback;

            if (number > the.currentStep) {
                callback = Plugin.eventTrigger('beforeNext');
            } else {
                callback = Plugin.eventTrigger('beforePrev');
            }
            
            // Skip if stopped
            if (the.stopped === true) {
                the.stopped = false;
                return;
            }

            // Continue if no exit
            if (callback !== false) {
                // Before change
                Plugin.eventTrigger('beforeChange');

                // Set current step 
                the.currentStep = number;

                Plugin.updateUI();

                // Trigger change event
                Plugin.eventTrigger('change');
            }

            // After next and prev events
            if (number > the.startStep) {
                Plugin.eventTrigger('afterNext');
            } else {
                Plugin.eventTrigger('afterPrev');
            }

            return the;
        },

        /**
         * Cancel
         */
        stop: function() {
            the.stopped = true;
        },

        /**
         * Resume
         */
        start: function() {
            the.stopped = false;
        },

        /**
         * Check last step
         */
        isLastStep: function() {
            return the.currentStep === the.totalSteps;
        },

        /**
         * Check first step
         */
        isFirstStep: function() {
            return the.currentStep === 1;
        },

        /**
         * Check between step
         */
        isBetweenStep: function() {
            return Plugin.isLastStep() === false && Plugin.isFirstStep() === false;
        },

        /**
         * Go to the next step
         */
        goNext: function() {
            return Plugin.goTo(Plugin.getNextStep());
        },

        /**
         * Go to the prev step
         */
        goPrev: function() {
            return Plugin.goTo(Plugin.getPrevStep());
        },

        /**
         * Go to the last step
         */
        goLast: function() {
            return Plugin.goTo(the.totalSteps);
        },

        /**
         * Go to the first step
         */
        goFirst: function() {
            return Plugin.goTo(1);
        },

        /**
         * Go to the first step
         */
        updateUI: function() {
            var stepType = '';
            var index = the.currentStep - 1;

            if (Plugin.isLastStep()) {
                stepType = 'last';
            } else if (Plugin.isFirstStep()) {
                stepType = 'first';
            } else {
                stepType = 'between';
            }

            KTUtil.attr(the.element, 'data-ktwizard-state', stepType);

            // Steps
            var steps = KTUtil.findAll(the.element, '[data-ktwizard-type="step"]');

            if (steps && steps.length > 0) {
                for (var i = 0, len = steps.length; i < len; i++) {
                    if (i == index) {
                        KTUtil.attr(steps[i], 'data-ktwizard-state', 'current');
                    } else {
                        if (i < index) {
                            KTUtil.attr(steps[i], 'data-ktwizard-state', 'done');
                        } else {
                            KTUtil.attr(steps[i], 'data-ktwizard-state', 'pending');
                        }
                    }
                }
            }

            // Steps Info
            var stepsInfo = KTUtil.findAll(the.element, '[data-ktwizard-type="step-info"]');
            if (stepsInfo &&stepsInfo.length > 0) {
                for (var i = 0, len = stepsInfo.length; i < len; i++) {
                    if (i == index) {
                        KTUtil.attr(stepsInfo[i], 'data-ktwizard-state', 'current');
                    } else {
                        KTUtil.removeAttr(stepsInfo[i], 'data-ktwizard-state');
                    }
                }
            }  

            // Steps Content
            var stepsContent = KTUtil.findAll(the.element, '[data-ktwizard-type="step-content"]');
            if (stepsContent&& stepsContent.length > 0) {
                for (var i = 0, len = stepsContent.length; i < len; i++) {
                    if (i == index) {
                        KTUtil.attr(stepsContent[i], 'data-ktwizard-state', 'current');
                    } else {
                        KTUtil.removeAttr(stepsContent[i], 'data-ktwizard-state');
                    }
                }
            }            
        },

        /**
         * Get next step
         */
        getNextStep: function() {
            if (the.totalSteps >= (the.currentStep + 1)) {
                return the.currentStep + 1;
            } else {
                return the.totalSteps;
            }
        },

        /**
         * Get prev step
         */
        getPrevStep: function() {
            if ((the.currentStep - 1) >= 1) {
                return the.currentStep - 1;
            } else {
                return 1;
            }
        },

        /**
         * Trigger events
         */
        eventTrigger: function(name) {
            //KTUtil.triggerCustomEvent(name);
            for (var i = 0; i < the.events.length; i++) {
                var event = the.events[i];
                if (event.name == name) {
                    if (event.one == true) {
                        if (event.fired == false) {
                            the.events[i].fired = true;
                            event.handler.call(this, the);
                        }
                    } else {
                        event.handler.call(this, the);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });

            return the;
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * Go to the next step 
     */
    the.goNext = function() {
        return Plugin.goNext();
    };

    /**
     * Go to the prev step 
     */
    the.goPrev = function() {
        return Plugin.goPrev();
    };

    /**
     * Go to the last step 
     */
    the.goLast = function() {
        return Plugin.goLast();
    };

    /**
     * Cancel step 
     */
    the.stop = function() {
        return Plugin.stop();
    };

    /**
     * Resume step 
     */
    the.start = function() {
        return Plugin.start();
    };

    /**
     * Go to the first step 
     */
    the.goFirst = function() {
        return Plugin.goFirst();
    };

    /**
     * Go to a step
     */
    the.goTo = function(number) {
        return Plugin.goTo(number);
    };

    /**
     * Get current step number 
     */
    the.getStep = function() {
        return the.currentStep;
    };

    /**
     * Check last step 
     */
    the.isLastStep = function() {
        return Plugin.isLastStep();
    };

    /**
     * Check first step 
     */
    the.isFirstStep = function() {
        return Plugin.isFirstStep();
    };
    
    /**
     * Attach event
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    /**
     * Attach event that will be fired once
     */
    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    // Construct plugin
    Plugin.construct.apply(the, [options]);

    return the;
};