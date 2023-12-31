(() => {
    var e = {
        496: e => {
            !function () {
                var t = ["direction", "boxSizing", "width", "height", "overflowX", "overflowY", "borderTopWidth", "borderRightWidth", "borderBottomWidth", "borderLeftWidth", "borderStyle", "paddingTop", "paddingRight", "paddingBottom", "paddingLeft", "fontStyle", "fontVariant", "fontWeight", "fontStretch", "fontSize", "fontSizeAdjust", "lineHeight", "fontFamily", "textAlign", "textTransform", "textIndent", "textDecoration", "letterSpacing", "wordSpacing", "tabSize", "MozTabSize"],
                    n = "undefined" != typeof window, i = n && null != window.mozInnerScreenX;

                function o(e, o, r) {
                    if (!n) throw new Error("textarea-caret-position#getCaretCoordinates should only be called in a browser");
                    var s = r && r.debug || !1;
                    if (s) {
                        var c = document.querySelector("#input-textarea-caret-position-mirror-div");
                        c && c.parentNode.removeChild(c)
                    }
                    var l = document.createElement("div");
                    l.id = "input-textarea-caret-position-mirror-div", document.body.appendChild(l);
                    var a = l.style, u = window.getComputedStyle ? window.getComputedStyle(e) : e.currentStyle,
                        d = "INPUT" === e.nodeName;
                    a.whiteSpace = "pre-wrap", d || (a.wordWrap = "break-word"), a.position = "absolute", s || (a.visibility = "hidden"), t.forEach((function (e) {
                        d && "lineHeight" === e ? a.lineHeight = u.height : a[e] = u[e]
                    })), i ? e.scrollHeight > parseInt(u.height) && (a.overflowY = "scroll") : a.overflow = "hidden", l.textContent = e.value.substring(0, o), d && (l.textContent = l.textContent.replace(/\s/g, " "));
                    var f = document.createElement("span");
                    f.textContent = e.value.substring(o) || ".", l.appendChild(f);
                    var h = {
                        top: f.offsetTop + parseInt(u.borderTopWidth),
                        left: f.offsetLeft + parseInt(u.borderLeftWidth),
                        height: parseInt(u.lineHeight)
                    };
                    return s ? f.style.backgroundColor = "#aaa" : document.body.removeChild(l), h
                }

                void 0 !== e.exports ? e.exports = o : n && (window.getCaretCoordinates = o)
            }()
        }
    }, t = {};

    function n(i) {
        var o = t[i];
        if (void 0 !== o) return o.exports;
        var r = t[i] = {exports: {}};
        return e[i](r, r.exports, n), r.exports
    }

    (() => {
        function e(e, n) {
            return function (e) {
                if (Array.isArray(e)) return e
            }(e) || function (e, t) {
                var n = null == e ? null : "undefined" != typeof Symbol && e[Symbol.iterator] || e["@@iterator"];
                if (null == n) return;
                var i, o, r = [], s = !0, c = !1;
                try {
                    for (n = n.call(e); !(s = (i = n.next()).done) && (r.push(i.value), !t || r.length !== t); s = !0) ;
                } catch (e) {
                    c = !0, o = e
                } finally {
                    try {
                        s || null == n.return || n.return()
                    } finally {
                        if (c) throw o
                    }
                }
                return r
            }(e, n) || function (e, n) {
                if (!e) return;
                if ("string" == typeof e) return t(e, n);
                var i = Object.prototype.toString.call(e).slice(8, -1);
                "Object" === i && e.constructor && (i = e.constructor.name);
                if ("Map" === i || "Set" === i) return Array.from(e);
                if ("Arguments" === i || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(i)) return t(e, n)
            }(e, n) || function () {
                throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
            }()
        }

        function t(e, t) {
            (null == t || t > e.length) && (t = e.length);
            for (var n = 0, i = new Array(t); n < t; n++) i[n] = e[n];
            return i
        }

        function i(e, t, n) {
            return t in e ? Object.defineProperty(e, t, {
                value: n,
                enumerable: !0,
                configurable: !0,
                writable: !0
            }) : e[t] = n, e
        }

        document.addEventListener("alpine:init", (function () {
            Alpine.data("SupportsWepInsert", (function (e) {
                var t, o;
                return {
                    id: null,
                    types: e.types,
                    scope: null !== (t = e.scope) && void 0 !== t ? t : [],
                    active: !1,
                    getCaretCoordinates: n(496),
                    insertInput: (o = {}, i(o, "x-ref", "insertInput"), i(o, "@keyup", (function (e) {
                        Livewire.emit("handleInsertInput", {
                            id: this.id,
                            text: this.$el.value,
                            types: this.types,
                            scope: this.scope,
                            originCoordinates: this.$refs.insertInput.getBoundingClientRect(),
                            caretCoordinates: this.getCaretCoordinates(e.target, e.target.selectionEnd),
                            event: e
                        })
                    })), i(o, "@keydown.arrow-up", (function (e) {
                        !0 === this.active && (e.preventDefault(), Livewire.emit("insertSelectUp"))
                    })), i(o, "@keydown.arrow-down", (function (e) {
                        !0 === this.active && (e.preventDefault(), Livewire.emit("insertSelectDown"))
                    })), i(o, "@keydown.enter", (function (e) {
                        !0 === this.active && (e.preventDefault(), Livewire.emit("insertSelectCurrent"))
                    })), i(o, "@keydown.escape", (function (e) {
                        !0 === this.active && (e.preventDefault(), Livewire.emit("closeInsert"))
                    })), i(o, "@click.away", (function (e) {
                        !0 === this.active && (e.preventDefault(), Livewire.emit("closeInsert"))
                    })), o),
                    init: function () {
                        var e = this;
                        this.id = Math.floor(Math.random() * Math.floor(Math.random() * Date.now())), Livewire.on("insertComponentActive.".concat(this.id), (function () {
                            e.active = !0
                        })), Livewire.on("insertComponentSelected.".concat(this.id), (function (t) {
                            e.$el.value = t, e.$dispatch("input", t), e.$focus.focusable(e.$el) ? e.$focus.focus(e.$el) : setTimeout((function () {
                                e.$focus.focus(e.$el)
                            }), 350)
                        })), Livewire.on("insertComponentClosed.".concat(this.id), (function () {
                            e.active = !1, e.results = []
                        })), Livewire.on("overlayComponentActivated", (function () {
                            var t;
                            null === (t = e.$el) || void 0 === t || t.blur()
                        }))
                    }
                }
            })), Alpine.data("WepInsertComponent", (function (t, n) {
                var o, r;
                return {
                    show: !1,
                    types: [],
                    container: (o = {}, i(o, "x-show", "show"), i(o, ":style", "`top: ${coordinates.top}px; left: ${coordinates.left}px;`"), o),
                    results: (r = {}, i(r, "x-ref", "results"), i(r, "@keydown.arrow-up", (function () {
                        this.selectUp()
                    })), i(r, "@keydown.arrow-down", (function () {
                        this.selectDown()
                    })), i(r, "@keydown.enter", (function () {
                        this.select()
                    })), i(r, "@keydown.escape", (function () {
                        this.close()
                    })), r),
                    text: "",
                    scope: [],
                    config: n,
                    instance: null,
                    selected: 0,
                    coordinates: {top: 0, left: 0},
                    activeToken: !1,
                    recentlyClosed: !1,
                    debounceTimeout: null,
                    debounceTimeoutCallback: null,
                    init: function () {
                        var e = this;
                        Livewire.on("handleInsertInput", (function (t) {
                            e.handleInsertInput(t)
                        })), Livewire.on("showInsert", (function (t) {
                            e.scope = t.scope, e.coordinates = t.coordinates, !1 === e.show && (e.show = !0, e.recentlyOpened = !0, setTimeout((function () {
                                e.recentlyOpened = !1
                            }), 400)), e.debounce((function () {
                                e.$wire.call("query", e.types, t.query, t.scope), Livewire.emit("insertComponentActive.".concat(e.instance))
                            }), e.recentlyOpened ? 0 : n.behavior.debounce_milliseconds)
                        })), Livewire.on("insertSelectUp", (function () {
                            e.selectUp()
                        })), Livewire.on("insertSelectDown", (function () {
                            e.selectDown()
                        })), Livewire.on("closeInsert", (function () {
                            e.close()
                        })), Livewire.on("insertSelectCurrent", (function () {
                            e.select()
                        })), Livewire.on("remoteInsert", (function (t) {
                            t.instance === e.instance && e.insert(t.value)
                        })), Livewire.on("overlayComponentActivated", (function () {
                            e.close()
                        })), Livewire.on("overlayComponentClosed", (function () {
                            setTimeout((function () {
                                e.close()
                            }), 200)
                        }))
                    },
                    debounce: function (e, t) {
                        var n = this;
                        clearTimeout(this.debounceTimeout), this.debounceTimeoutCallback = function () {
                            e()
                        }, this.debounceTimeout = setTimeout((function () {
                            e(), n.debounceTimeout = null, n.debounceTimeoutCallback = null
                        }), t)
                    },
                    handleInsertInput: function (e) {
                        var t;
                        this.instance = e.id;
                        var n = e.event.target.selectionEnd || 0, i = this.getActiveToken(e.text, n);
                        this.recentlyClosed || (void 0 !== i || !0 !== this.show ? (null == i ? void 0 : i.word) !== (null === (t = this.activeToken) || void 0 === t ? void 0 : t.word) && (this.types = this.determineTypesByExpression(e.types, null == i ? void 0 : i.word), this.types.length > 0 ? (this.activeToken = i, this.text = e.text, Livewire.emit("showInsert", {
                            query: i.word,
                            scope: e.scope,
                            coordinates: {
                                top: e.originCoordinates.y + window.scrollY + e.caretCoordinates.top,
                                left: e.originCoordinates.x + e.caretCoordinates.left
                            }
                        })) : Livewire.emit("closeInsert")) : Livewire.emit("closeInsert"))
                    },
                    getActiveToken: function (e, t) {
                        var n = e.split(/[\s\n]/).reduce((function (e, t, n) {
                            var i = e[n - 1], o = 0 === n ? n : i.range[1] + 1, r = o + t.length;
                            return e.concat([{word: t, range: [o, r]}])
                        }), []);
                        if (void 0 !== t) return n.find((function (e) {
                            var n = e.range;
                            return n[0] < t && n[1] >= t
                        }))
                    },
                    determineTypesByExpression: function (e, t) {
                        var n = this;
                        return e.filter((function (e) {
                            return new RegExp(n.getConfig(e, "expression")).test(t)
                        }))
                    },
                    matchesExpression: function (e) {
                        return new RegExp(this.getConfig("expression")).test(e)
                    },
                    getConfig: function (e, t) {
                        var n;
                        return null !== (n = this.config.types[e][t]) && void 0 !== n ? n : null
                    },
                    close: function () {
                        var e = this;
                        this.show = !1, this.recentlyClosed = !0, setTimeout((function () {
                            e.selected = 0, e.recentlyClosed = !1
                        }), 400), Livewire.emit("insertComponentClosed.".concat(this.instance))
                    },
                    replaceAt: function (e, t, n) {
                        var i = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : 0, o = e.substr(0, n),
                            r = e.substr(n + i);
                        return o + t + r
                    },
                    formatInsert: function (t) {
                        var n = e(this.activeToken.range, 1)[0];
                        return this.replaceAt(this.text, t + " ", n, this.activeToken.word.length)
                    },
                    insert: function (e) {
                        Livewire.emit("insertComponentSelected.".concat(this.instance), this.formatInsert(e))
                    },
                    select: function (e) {
                        this.$wire.select(this.instance, null != e ? e : this.$refs.results.children[this.selected].dataset.id), this.close()
                    },
                    selectUp: function () {
                        var e = this;
                        this.selected = Math.max(0, this.selected - 1), this.$nextTick((function () {
                            var t;
                            null === (t = e.$refs.results.children[e.selected - 1]) || void 0 === t || t.scrollIntoView({block: "nearest"})
                        }))
                    },
                    selectDown: function () {
                        var e = this;
                        this.selected = Math.min(this.$refs.results.children.length - 1, this.selected + 1), this.$nextTick((function () {
                            var t;
                            null === (t = e.$refs.results.children[e.selected + 1]) || void 0 === t || t.scrollIntoView({block: "nearest"})
                        }))
                    }
                }
            }))
        }))
    })()
})();
