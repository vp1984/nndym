! function(a) {
    function d(a) {
        return c === !1 ? !1 : "" === c ? a : c + a.charAt(0).toUpperCase() + a.substr(1)
    }
    var b = document.createElement("div").style,
        c = function() {
            for (var c, a = ["t", "webkitT", "MozT", "msT", "OT"], d = 0, e = a.length; e > d; d++)
                if (c = a[d] + "ransform", c in b) return a[d].substr(0, a[d].length - 1);
            return !1
        }(),
        e = {
            pageContainer: ".page",
            easing: "ease",
            animationTime: 1e3,
            pagination: !0,
            keyboard: !0,
            beforeMove: function() {},
            afterMove: function() {},
            loop: !1
        },
        f = a(document),
        g = d("transform"),
        h = g in b,
        i = d("transition");
    a.fn.pageScroll = function(b) {
        function q(a, b) {
            var e = null;
            h ? (e = {}, e[g] = "translate3d(0, " + a + "%, 0)", e[i] = "all " + c.animationTime + "ms " + c.easing, d.css(e), d.one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function() {
                c.afterMove(b, j.eq(b))
            })) : (e = {
                top: d.height() / 100 * a + "px"
            }, d.animate(e, c.animationTime, function() {
                c.afterMove(b, j.eq(b))
            }))
        }

        function r(a, b) {
            c.beforeMove(a, j.eq(a)), j.eq(a).removeClass("active"), c.pagination && (x.eq(a).removeClass("active"), x.eq(b).addClass("active")), j.eq(b).addClass("active"), q(-100 * b, b), m = b
        }

        function s() {
            var a = m + 1;
            if (a > k) {
                if (!c.loop) return;
                a = 0
            }
            r(m, a)
        }

        function t() {
            var a = m - 1;
            if (0 > a) {
                if (!c.loop) return;
                a = k
            }
            r(m, a)
        }

        function u(a) {
            0 > a || a > k || r(m, a)
        }

        function v(a, b) {
            if (!(Math.abs(b) < 10)) {
                var d = (new Date).getTime();
                if (d - n < o + c.animationTime) return a.preventDefault(), void 0;
                0 > b ? s() : t(), n = d
            }
        }
        var w, x, c = a.extend({}, e, b),
            d = a(this),
            j = d.find(c.pageContainer),
            k = j.length - 1,
            l = 0,
            m = 0,
            n = 0,
            o = 500,
            p = "";
        return a.fn.moveToPage = u, j.each(function(b) {
            var d = a(this);
            d.css({
                position: "absolute",
                top: l + "%"
            }), l += 100, c.pagination && (p += '<a data-index="' + b + '" href="javascript:;"></a>')
        }), j.show().eq(m).addClass("active"), c.afterMove(m, j.eq(m)), c.pagination && (w = d.find(".page-pagination"), w.length || (w = a('<div class="page-pagination"></div>').html(p), a("body").prepend(w)), x = w.find("a"), x.eq(m).addClass("active"), x.on("click", function() {
            var b = a(this);
            b.hasClass("active") || u(b.data("index"))
        })), f.on("mousewheel DOMMouseScroll MozMousePixelScroll", function(b) {
            b.preventDefault();
            var c = b.originalEvent.wheelDelta || -b.originalEvent.detail;
            a("body").hasClass("disable-page-scroll") || v(b, c)
        }), d.on("touchstart", function(b) {
            var c, d;
            return a("body").hasClass("disable-page-scroll") ? !1 : (c = b.originalEvent.touches, c && c.length && (d = c[0].pageY, f.on("touchmove.page-scroll", function(a) {
                var c, b = a.originalEvent.touches;
                a.preventDefault(), b && b.length && (c = b[0].pageY - d, Math.abs(c) >= 50 && (v(a, c), f.off(".page-scroll .page-scroll-end")))
            }), f.on("touchend.page-scroll-end", function() {
                f.off(".page-scroll .page-scroll-end")
            })), void 0)
        }), c.keyboard && f.on("keydown", function(b) {
            var c = b.target.tagName.toLowerCase();
            if ("input" !== c && "textarea" !== c && !a("body").hasClass("disable-page-scroll")) switch (b.which) {
                case 38:
                    t();
                    break;
                case 40:
                    s();
                    break;
                case 32:
                    s();
                    break;
                case 33:
                    t();
                    break;
                case 34:
                    s();
                    break;
                case 36:
                    u(0);
                    break;
                case 35:
                    u(k);
                    break;
                default:
                    return
            }
        }), !1
    }
}(window.jQuery);