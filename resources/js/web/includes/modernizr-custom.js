"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*! modernizr 3.6.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-cssgrid_cssgridlegacy-flexbox-objectfit-touchevents-webp-setclasses !*/
!function (e, n, t) {
  function r(e) {
    var n = x.className,
        t = Modernizr._config.classPrefix || "";

    if (S && (n = n.baseVal), Modernizr._config.enableJSClass) {
      var r = new RegExp("(^|\\s)" + t + "no-js(\\s|$)");
      n = n.replace(r, "$1" + t + "js$2");
    }

    Modernizr._config.enableClasses && (n += " " + t + e.join(" " + t), S ? x.className.baseVal = n : x.className = n);
  }

  function o(e, n) {
    return _typeof(e) === n;
  }

  function i() {
    var e, n, t, r, i, s, a;

    for (var l in b) {
      if (b.hasOwnProperty(l)) {
        if (e = [], n = b[l], n.name && (e.push(n.name.toLowerCase()), n.options && n.options.aliases && n.options.aliases.length)) for (t = 0; t < n.options.aliases.length; t++) {
          e.push(n.options.aliases[t].toLowerCase());
        }

        for (r = o(n.fn, "function") ? n.fn() : n.fn, i = 0; i < e.length; i++) {
          s = e[i], a = s.split("."), 1 === a.length ? Modernizr[a[0]] = r : (!Modernizr[a[0]] || Modernizr[a[0]] instanceof Boolean || (Modernizr[a[0]] = new Boolean(Modernizr[a[0]])), Modernizr[a[0]][a[1]] = r), w.push((r ? "" : "no-") + a.join("-"));
        }
      }
    }
  }

  function s(e, n) {
    if ("object" == _typeof(e)) for (var t in e) {
      C(e, t) && s(t, e[t]);
    } else {
      e = e.toLowerCase();
      var o = e.split("."),
          i = Modernizr[o[0]];
      if (2 == o.length && (i = i[o[1]]), "undefined" != typeof i) return Modernizr;
      n = "function" == typeof n ? n() : n, 1 == o.length ? Modernizr[o[0]] = n : (!Modernizr[o[0]] || Modernizr[o[0]] instanceof Boolean || (Modernizr[o[0]] = new Boolean(Modernizr[o[0]])), Modernizr[o[0]][o[1]] = n), r([(n && 0 != n ? "" : "no-") + o.join("-")]), Modernizr._trigger(e, n);
    }
    return Modernizr;
  }

  function a(e) {
    return e.replace(/([a-z])-([a-z])/g, function (e, n, t) {
      return n + t.toUpperCase();
    }).replace(/^-/, "");
  }

  function l(e, n) {
    return function () {
      return e.apply(n, arguments);
    };
  }

  function u(e, n, t) {
    var r;

    for (var i in e) {
      if (e[i] in n) return t === !1 ? e[i] : (r = n[e[i]], o(r, "function") ? l(r, t || n) : r);
    }

    return !1;
  }

  function f(e, n) {
    return !!~("" + e).indexOf(n);
  }

  function A() {
    return "function" != typeof n.createElement ? n.createElement(arguments[0]) : S ? n.createElementNS.call(n, "http://www.w3.org/2000/svg", arguments[0]) : n.createElement.apply(n, arguments);
  }

  function c(e) {
    return e.replace(/([A-Z])/g, function (e, n) {
      return "-" + n.toLowerCase();
    }).replace(/^ms-/, "-ms-");
  }

  function d(n, t, r) {
    var o;

    if ("getComputedStyle" in e) {
      o = getComputedStyle.call(e, n, t);
      var i = e.console;
      if (null !== o) r && (o = o.getPropertyValue(r));else if (i) {
        var s = i.error ? "error" : "log";
        i[s].call(i, "getComputedStyle returning null, its possible modernizr test results are inaccurate");
      }
    } else o = !t && n.currentStyle && n.currentStyle[r];

    return o;
  }

  function p() {
    var e = n.body;
    return e || (e = A(S ? "svg" : "body"), e.fake = !0), e;
  }

  function m(e, t, r, o) {
    var i,
        s,
        a,
        l,
        u = "modernizr",
        f = A("div"),
        c = p();
    if (parseInt(r, 10)) for (; r--;) {
      a = A("div"), a.id = o ? o[r] : u + (r + 1), f.appendChild(a);
    }
    return i = A("style"), i.type = "text/css", i.id = "s" + u, (c.fake ? c : f).appendChild(i), c.appendChild(f), i.styleSheet ? i.styleSheet.cssText = e : i.appendChild(n.createTextNode(e)), f.id = u, c.fake && (c.style.background = "", c.style.overflow = "hidden", l = x.style.overflow, x.style.overflow = "hidden", x.appendChild(c)), s = t(f, e), c.fake ? (c.parentNode.removeChild(c), x.style.overflow = l, x.offsetHeight) : f.parentNode.removeChild(f), !!s;
  }

  function g(n, r) {
    var o = n.length;

    if ("CSS" in e && "supports" in e.CSS) {
      for (; o--;) {
        if (e.CSS.supports(c(n[o]), r)) return !0;
      }

      return !1;
    }

    if ("CSSSupportsRule" in e) {
      for (var i = []; o--;) {
        i.push("(" + c(n[o]) + ":" + r + ")");
      }

      return i = i.join(" or "), m("@supports (" + i + ") { #modernizr { position: absolute; } }", function (e) {
        return "absolute" == d(e, null, "position");
      });
    }

    return t;
  }

  function h(e, n, r, i) {
    function s() {
      u && (delete E.style, delete E.modElem);
    }

    if (i = o(i, "undefined") ? !1 : i, !o(r, "undefined")) {
      var l = g(e, r);
      if (!o(l, "undefined")) return l;
    }

    for (var u, c, d, p, m, h = ["modernizr", "tspan", "samp"]; !E.style && h.length;) {
      u = !0, E.modElem = A(h.shift()), E.style = E.modElem.style;
    }

    for (d = e.length, c = 0; d > c; c++) {
      if (p = e[c], m = E.style[p], f(p, "-") && (p = a(p)), E.style[p] !== t) {
        if (i || o(r, "undefined")) return s(), "pfx" == n ? p : !0;

        try {
          E.style[p] = r;
        } catch (v) {}

        if (E.style[p] != m) return s(), "pfx" == n ? p : !0;
      }
    }

    return s(), !1;
  }

  function v(e, n, t, r, i) {
    var s = e.charAt(0).toUpperCase() + e.slice(1),
        a = (e + " " + T.join(s + " ") + s).split(" ");
    return o(n, "string") || o(n, "undefined") ? h(a, n, r, i) : (a = (e + " " + U.join(s + " ") + s).split(" "), u(a, n, t));
  }

  function y(e, n, r) {
    return v(e, t, t, n, r);
  }

  var w = [],
      b = [],
      _ = {
    _version: "3.6.0",
    _config: {
      classPrefix: "",
      enableClasses: !0,
      enableJSClass: !0,
      usePrefixes: !0
    },
    _q: [],
    on: function on(e, n) {
      var t = this;
      setTimeout(function () {
        n(t[e]);
      }, 0);
    },
    addTest: function addTest(e, n, t) {
      b.push({
        name: e,
        fn: n,
        options: t
      });
    },
    addAsyncTest: function addAsyncTest(e) {
      b.push({
        name: null,
        fn: e
      });
    }
  },
      Modernizr = function Modernizr() {};

  Modernizr.prototype = _, Modernizr = new Modernizr();
  var C,
      x = n.documentElement,
      S = "svg" === x.nodeName.toLowerCase();
  !function () {
    var e = {}.hasOwnProperty;
    C = o(e, "undefined") || o(e.call, "undefined") ? function (e, n) {
      return n in e && o(e.constructor.prototype[n], "undefined");
    } : function (n, t) {
      return e.call(n, t);
    };
  }(), _._l = {}, _.on = function (e, n) {
    this._l[e] || (this._l[e] = []), this._l[e].push(n), Modernizr.hasOwnProperty(e) && setTimeout(function () {
      Modernizr._trigger(e, Modernizr[e]);
    }, 0);
  }, _._trigger = function (e, n) {
    if (this._l[e]) {
      var t = this._l[e];
      setTimeout(function () {
        var e, r;

        for (e = 0; e < t.length; e++) {
          (r = t[e])(n);
        }
      }, 0), delete this._l[e];
    }
  }, Modernizr._q.push(function () {
    _.addTest = s;
  }), Modernizr.addAsyncTest(function () {
    function e(e, n, t) {
      function r(n) {
        var r = n && "load" === n.type ? 1 == o.width : !1,
            i = "webp" === e;
        s(e, i && r ? new Boolean(r) : r), t && t(n);
      }

      var o = new Image();
      o.onerror = r, o.onload = r, o.src = n;
    }

    var n = [{
      uri: "data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoBAAEAAwA0JaQAA3AA/vuUAAA=",
      name: "webp"
    }, {
      uri: "data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA==",
      name: "webp.alpha"
    }, {
      uri: "data:image/webp;base64,UklGRlIAAABXRUJQVlA4WAoAAAASAAAAAAAAAAAAQU5JTQYAAAD/////AABBTk1GJgAAAAAAAAAAAAAAAAAAAGQAAABWUDhMDQAAAC8AAAAQBxAREYiI/gcA",
      name: "webp.animation"
    }, {
      uri: "data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAAAAAAfQ//73v/+BiOh/AAA=",
      name: "webp.lossless"
    }],
        t = n.shift();
    e(t.name, t.uri, function (t) {
      if (t && "load" === t.type) for (var r = 0; r < n.length; r++) {
        e(n[r].name, n[r].uri);
      }
    });
  });
  var B = "Moz O ms Webkit",
      T = _._config.usePrefixes ? B.split(" ") : [];
  _._cssomPrefixes = T;

  var Q = function Q(n) {
    var r,
        o = k.length,
        i = e.CSSRule;
    if ("undefined" == typeof i) return t;
    if (!n) return !1;
    if (n = n.replace(/^@/, ""), r = n.replace(/-/g, "_").toUpperCase() + "_RULE", r in i) return "@" + n;

    for (var s = 0; o > s; s++) {
      var a = k[s],
          l = a.toUpperCase() + "_" + r;
      if (l in i) return "@-" + a.toLowerCase() + "-" + n;
    }

    return !1;
  };

  _.atRule = Q;
  var U = _._config.usePrefixes ? B.toLowerCase().split(" ") : [];
  _._domPrefixes = U;
  var R = {
    elem: A("modernizr")
  };

  Modernizr._q.push(function () {
    delete R.elem;
  });

  var E = {
    style: R.elem.style
  };
  Modernizr._q.unshift(function () {
    delete E.style;
  }), _.testAllProps = v, _.testAllProps = y, Modernizr.addTest("cssgridlegacy", y("grid-columns", "10px", !0)), Modernizr.addTest("cssgrid", y("grid-template-rows", "none", !0)), Modernizr.addTest("flexbox", y("flexBasis", "1px", !0));

  var P = _.prefixed = function (e, n, t) {
    return 0 === e.indexOf("@") ? Q(e) : (-1 != e.indexOf("-") && (e = a(e)), n ? v(e, n, t) : v(e, "pfx"));
  };

  Modernizr.addTest("objectfit", !!P("objectFit"), {
    aliases: ["object-fit"]
  });
  var j = _.testStyles = m,
      k = _._config.usePrefixes ? " -webkit- -moz- -o- -ms- ".split(" ") : ["", ""];
  _._prefixes = k, Modernizr.addTest("touchevents", function () {
    var t;
    if ("ontouchstart" in e || e.DocumentTouch && n instanceof DocumentTouch) t = !0;else {
      var r = ["@media (", k.join("touch-enabled),("), "heartz", ")", "{#modernizr{top:9px;position:absolute}}"].join("");
      j(r, function (e) {
        t = 9 === e.offsetTop;
      });
    }
    return t;
  }), i(), r(w), delete _.addTest, delete _.addAsyncTest;

  for (var z = 0; z < Modernizr._q.length; z++) {
    Modernizr._q[z]();
  }

  e.Modernizr = Modernizr;
}(window, document);