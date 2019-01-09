!function() {
    var e = "https://webv2.checkout.magpie.im";
    Magpie.config = {
        host: e,
        url: e + "/checkout?distinct_id="
    }
}(window.Magpie = window.Magpie || {}),
    function(e) {
        window.MagpieCheckout = window.MagpieCheckout || function(n, i) {
            function t(e) {
                e = e || {};
                var i = n.allowRememberMe || e.allowRememberMe;
                i = void 0 === i || "true" === i || i;
                var t = n.forceCvvInput || e.forceCvvInput;
                return t = void 0 !== t && ("true" === t || t),
                    {
                        key: n.key,
                        amount: n.amount || e.amount,
                        name: n.name || e.name,
                        description: n.description || e.description,
                        billing: n.billing || e.billing || !1,
                        shipping: n.shipping || e.shipping || !1,
                        currency: n.currency || e.currency,
                        payLabel: n.payLabel || e.payLabel || "PAY",
                        buttonLabel: n.buttonLabel || e.buttonLabel || "Pay with Card",
                        allowRememberMe: i,
                        email: n.email || e.email || "",
                        icon: n.icon,
                        forceCvvInput: n.forceCvvInput,
                        distinctId: o
                    }
            }
            var r = !1
                , o = e.helpers.generateID();
            if (void 0 === n)
                throw new Error("Magpie Error: no parameters given.");
            if (void 0 === n.key)
                throw new Error("Magpie Error: `key` param is required.");
            if (void 0 === n.token)
                throw new Error("Magpie Error: `token` callback param is required.");
            var a = null;
            a = e.helpers.isMobile() && !e.helpers.isFacebookBrowser() ? function() {
                var n = null;
                return {
                    open: function(i) {
                        var a = t(i);
                        n = window.open(e.config.url + o, "_magpie");
                        var s = new XMLHttpRequest;
                        s.open("POST", e.config.host + "/v1/sessions"),
                            s.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"),
                            s.onload = function() {}
                            ,
                            s.send(e.helpers.serialize({
                                details: a,
                                distinct_id: o
                            }));
                        var p = setInterval(function() {
                            r ? (r = !1,
                                n.postMessage(JSON.stringify(a), e.config.host),
                                clearInterval(p)) : n.postMessage("ping", e.config.host)
                        }, 1500)
                    },
                    close: function() {
                        n.postMessage("token_received", e.config.host)
                    }
                }
            }() : function() {
                var n = document.createElement("iframe")
                    , i = !1;
                return n.seamless = !0,
                    n.width = "100%",
                    n.height = "100%",
                    n.frameBorder = 0,
                    n.onload = function() {
                        i = !0
                    }
                    ,
                    n.setAttribute("id", "magpie-checkout-app"),
                    n.setAttribute("allowtransparency", "true"),
                    n.setAttribute("src", e.config.url + o),
                    n.setAttribute("name", Date.now()),
                    n.setAttribute("style", "position:fixed;top:0;right:0;bottom:0;left:0;z-index:2147483647;overflow-x:hidden;overflow-y:auto;margin:auto;display:none"),
                    document.body.appendChild(n),
                    {
                        open: function(r) {
                            var o = t(r);
                            i && (n.style.display = "block",
                                n.contentWindow.postMessage(JSON.stringify(o), e.config.host))
                        },
                        close: function() {
                            n.style.display = "none"
                        }
                    }
            }();
            var s = window.addEventListener ? "addEventListener" : "attachEvent"
                , p = "attachEvent" == s ? "onmessage" : "message";
            return window[s](p, function(e) {
                var i = e[e.message ? "message" : "data"];
                if ("close_app" == i)
                    a.close();
                else if ("open_app" == i)
                    a.open();
                else if ("ack" == i)
                    r = !0;
                else if (i) {
                    if ("object" == typeof i)
                        return;
                    try {
                        var t = JSON.parse(i)
                    } catch (e) {
                        t = {}
                    }
                    t.token && t.args.distinctId === o && (a.close(),
                    n.token && n.token(t.token, t.args))
                }
            }, !1),
                a
        }
    }(window.Magpie),
    function(e) {
        e.helpers = function() {
            var n = function(e) {
                return function() {
                    var n;
                    return (n = this.userAgent.match(e)) && parseInt(n[1])
                }
            }
                , i = function(e) {
                return function() {
                    return e() && !this.isWindowsPhone()
                }
            }
                , t = function(e, n) {
                var i, r = [];
                for (i in e)
                    if (e.hasOwnProperty(i)) {
                        var o = n ? n + "[" + i + "]" : i
                            , a = e[i];
                        r.push(null !== a && "object" == typeof a ? t(a, o) : encodeURIComponent(o) + "=" + encodeURIComponent(a))
                    }
                return r.join("&")
            };
            return {
                userAgent: window.navigator.userAgent,
                iOSVersion: n(/(?:iPhone OS |iPad; CPU OS )(\d+)_\d+/),
                iOSMinorVersion: n(/(?:iPhone OS |iPad; CPU OS )\d+_(\d+)/),
                iOSBuildVersion: n(/(?:iPhone OS |iPad; CPU OS )\d+_\d+_(\d+)/),
                androidWebkitVersion: n(/Mozilla\/5\.0.*Android.*AppleWebKit\/([\d]+)/),
                androidVersion: n(/Android (\d+)\.\d+/),
                firefoxVersion: n(/Firefox\/(\d+)\.\d+/),
                chromeVersion: n(/Chrome\/(\d+)\.\d+/),
                safariVersion: n(/Version\/(\d+)\.\d+ Safari/),
                iOSChromeVersion: n(/CriOS\/(\d+)\.\d+/),
                iOSNativeVersion: n(/Stripe\/(\d+)\.\d+/),
                ieVersion: n(/(?:MSIE |Trident\/.*rv:)(\d{1,2})\./),
                isiOSChrome: function() {
                    return /CriOS/.test(e.helpers.userAgent)
                },
                isiOSWebView: function() {
                    return /(iPhone|iPod|iPad).*AppleWebKit((?!.*Safari)|(.*\([^)]*like[^)]*Safari[^)]*\)))/i.test(e.helpers.userAgent)
                },
                getiOSWebViewType: function() {
                    return e.helpers.isiOSWebView() ? window.indexedDB ? "WKWebView" : "UIWebView" : void 0
                },
                isiOS: i(function() {
                    return /(iPhone|iPad|iPod)/i.test(e.helpers.userAgent)
                }),
                isFacebookBrowser: function() {
                    var n = e.helpers.userAgent;
                    return n.indexOf("FBAN") > -1 || n.indexOf("FBAV") > -1
                },
                isiOSNative: function() {
                    return e.helpers.isiOS() && e.helpers.iOSNativeVersion() >= 3
                },
                isiPad: function() {
                    return /(iPad)/i.test(e.helpers.userAgent)
                },
                isMac: i(function() {
                    return /mac/i.test(e.helpers.userAgent)
                }),
                isWindowsPhone: function() {
                    return /(Windows\sPhone|IEMobile)/i.test(e.helpers.userAgent)
                },
                isWindowsOS: function() {
                    return /(Windows NT \d\.\d)/i.test(e.helpers.userAgent)
                },
                isIE: function() {
                    return /(MSIE ([0-9]{1,}[\.0-9]{0,})|Trident\/)/i.test(e.helpers.userAgent)
                },
                isChrome: function() {
                    return "chrome"in window
                },
                isSafari: i(function() {
                    var n;
                    return n = e.helpers.userAgent,
                    /Safari/i.test(n) && !/Chrome/i.test(n)
                }),
                isFirefox: i(function() {
                    return null != e.helpers.firefoxVersion()
                }),
                isAndroidBrowser: function() {
                    var n;
                    return (n = e.helpers.androidWebkitVersion()) && 537 > n
                },
                isAndroidChrome: function() {
                    var n;
                    return (n = e.helpers.androidWebkitVersion()) && n >= 537
                },
                isAndroidDevice: i(function() {
                    return /Android/.test(e.helpers.userAgent)
                }),
                isAndroidWebView: function() {
                    return e.helpers.isAndroidChrome() && /Version\/\d+\.\d+/.test(e.helpers.userAgent)
                },
                isNativeWebContainer: function() {
                    return null != window.cordova || /GSA\/\d+\.\d+/.test(e.helpers.userAgent)
                },
                isSupportedMobileOS: function() {
                    return e.helpers.isiOS() || e.helpers.isAndroidDevice()
                },
                isAndroidWebapp: function() {
                    var n;
                    return !!e.helpers.isAndroidChrome() && ((n = document.getElementsByName("apple-mobile-web-app-capable")[0] || document.getElementsByName("mobile-web-app-capable")[0]) && "yes" === n.content)
                },
                isiOSBroken: function() {
                    var n;
                    if (n = e.helpers.iOSChromeVersion(),
                    9 === e.helpers.iOSVersion() && 2 === e.helpers.iOSMinorVersion() && n && 47 >= n)
                        return !0;
                    if (e.helpers.isiPad() && 8 === e.helpers.iOSVersion())
                        switch (e.helpers.iOSMinorVersion()) {
                            case 0:
                                return !0;
                            case 1:
                                return e.helpers.iOSBuildVersion() < 1
                        }
                    return !1
                },
                isUserGesture: function() {
                    var e, n;
                    return "click" === (e = null != (n = window.event) ? n.type : void 0) || "touchstart" === e || "touchend" === e
                },
                isInsideFrame: function() {
                    return window.top !== window.self
                },
                isFallback: function() {
                    var n, i, t, r;
                    return !("postMessage"in window && !window.postMessageDisabled && !(document.documentMode && document.documentMode < 8)) || !!((n = e.helpers.androidVersion()) && 4 > n || (r = e.helpers.iOSVersion()) && 6 > r || (t = e.helpers.firefoxVersion()) && 11 > t || (i = e.helpers.iOSChromeVersion()) && 36 > i)
                },
                isSmallScreen: function() {
                    return Math.min(window.screen.availHeight, window.screen.availWidth) <= 640 || /FakeCheckoutMobile/.test(e.helpers.userAgent)
                },
                pad: function(e, n, i) {
                    return null == n && (n = 2),
                    null == i && (i = "0"),
                        (e += "").length > n ? e : new Array(n - e.length + 1).join(i) + e
                },
                concat: function(e, n) {
                    for (var i in n)
                        e[i] = n[i];
                    return e
                },
                generateID: function() {
                    function e() {
                        return Math.floor(65536 * (1 + Math.random())).toString(16).substring(1)
                    }
                    return e() + e() + "-" + e() + "-" + e() + "-" + e() + "-" + e() + e() + e()
                },
                initializeAppType: function() {
                    var n = [];
                    e.helpers.isSupportedMobileOS() ? (e.helpers.isiOSNative() && n.push("iOSNative"),
                        e.helpers.isiPad() || e.helpers.isInsideFrame() ? (n.push("tablet"),
                        e.helpers.isSmallScreen() && n.push("smallScreen")) : n.push("mobile")) : n.push("desktop"),
                        e.app_types = n
                },
                isMobile: function() {
                    return -1 !== e.app_types.indexOf("mobile")
                },
                serialize: t,
                encodeObject: function(e) {
                    if ("object" != typeof e)
                        return "";
                    for (var n = Object.keys(e), i = "", t = 0; t < n.length; t++)
                        i += n[t] + "=" + e[n[t]],
                        t !== n.length - 1 && (i += "&");
                    return i
                },
                parseOptions: function(e) {
                    var n = {};
                    return [].forEach.call(e.attributes, function(e) {
                        if (/^data-/.test(e.name)) {
                            var i = e.name.substr(5).replace(/-(.)/g, function(e, n) {
                                return n.toUpperCase()
                            });
                            n[i] = e.value
                        }
                    }),
                        n
                }
            }
        }()
    }(window.Magpie = window.Magpie || {}),
    function(e, n) {
        window.Magpie.helpers.initializeAppType();
        var i = document.querySelectorAll(".magpie-button");
        if (i.length) {
            window.document.onload = function() {
                window.document.stylesheets[0]
            }
            ;
            var t = i[i.length - 1]
                , r = t.parentNode
                , o = n.helpers.parseOptions(t)
                , a = document.createElement("button");
            o.token = function(e, n) {
                var i = document.createElement("input");
                i.type = "hidden",
                    i.value = e.id,
                    i.name = "magpie_token",
                    r.appendChild(i);
                var t = document.createElement("input");
                if (t.type = "hidden",
                    t.value = e.email,
                    t.name = "magpie_email",
                    r.appendChild(t),
                    n.billing) {
                    var o = document.createElement("input");
                    o.type = "hidden",
                        o.value = n.billing.name,
                        o.name = "magpie_billing_name",
                        r.appendChild(o);
                    var a = document.createElement("input");
                    a.type = "hidden",
                        a.value = n.billing.address,
                        a.name = "magpie_billing_address",
                        r.appendChild(a);
                    var s = document.createElement("input");
                    s.type = "hidden",
                        s.value = n.billing.postcode,
                        s.name = "magpie_billing_postcode",
                        r.appendChild(s);
                    var p = document.createElement("input");
                    p.type = "hidden",
                        p.value = n.billing.city,
                        p.name = "magpie_billing_city",
                        r.appendChild(p);
                    var d = document.createElement("input");
                    d.type = "hidden",
                        d.value = n.billing.country,
                        d.name = "magpie_billing_country",
                        r.appendChild(d)
                }
                if (n.shipping) {
                    var u = document.createElement("input");
                    u.type = "hidden",
                        u.value = n.shipping.name,
                        u.name = "magpie_shipping_name",
                        r.appendChild(u);
                    var l = document.createElement("input");
                    l.type = "hidden",
                        l.value = n.shipping.address,
                        l.name = "magpie_shipping_address",
                        r.appendChild(l);
                    var c = document.createElement("input");
                    c.type = "hidden",
                        c.value = n.shipping.postcode,
                        c.name = "magpie_shipping_postcode",
                        r.appendChild(c);
                    var h = document.createElement("input");
                    h.type = "hidden",
                        h.value = n.shipping.city,
                        h.name = "magpie_shipping_city",
                        r.appendChild(h);
                    var m = document.createElement("input");
                    m.type = "hidden",
                        m.value = n.shipping.country,
                        m.name = "magpie_shipping_country",
                        r.appendChild(m)
                }
                r.submit()
            }
            ;
            var s = new e(o);
            a.innerHTML = o.buttonLabel || "Pay with card",
                a.setAttribute("style", "color: #fff;background: #539BEB;padding: 10px 15px;font-size: 14px;outline: 0;font-weight: bold;border: none;border-radius: 5px;text-shadow: 0 0 0.5px rgba(50,50,93,.17);box-shadow: 0 0 0 0.5px rgba(50,50,93,.17), 0 2px 5px 0 rgba(50,50,93,.1), 0 1px 1.5px 0 rgba(0,0,0,.07), 0 1px 2px 0 rgba(0,0,0,.08), 0 0 0 0 transparent"),
                a.addEventListener("click", function(e) {
                    e.preventDefault(),
                        s.open()
                }),
                r.insertBefore(a, t)
        }
    }(window.MagpieCheckout, window.Magpie);