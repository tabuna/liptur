!function (t) {
    "use strict";
    t.fn.counterUp = function (a) {
        var e, n = t.extend({
            time: 400, delay: 10, formatter: !1, callback: function () {
            }
        }, a);
        return this.each(function () {
            var a = t(this), u = {
                time: t(this).data("counterup-time") || n.time,
                delay: t(this).data("counterup-delay") || n.delay
            }, r = function () {
                var t = [], r = u.time / u.delay, o = a.text(), c = /[0-9]+,[0-9]+/.test(o);
                o = o.replace(/,/g, "");
                var i = (o.split(".")[1] || []).length, l = /[0-9]+:[0-9]+:[0-9]+/.test(o);
                if (l) {
                    var s = o.split(":"), d = 1;
                    for (e = 0; s.length > 0;)e += d * parseInt(s.pop(), 10), d *= 60
                }
                for (var f = r; f >= 1; f--) {
                    var p = parseFloat(o / r * f).toFixed(i);
                    if (l) {
                        p = parseInt(e / r * f);
                        var m = parseInt(p / 3600) % 24, h = parseInt(p / 60) % 60, v = parseInt(p % 60, 10);
                        p = (10 > m ? "0" + m : m) + ":" + (10 > h ? "0" + h : h) + ":" + (10 > v ? "0" + v : v)
                    }
                    if (c)for (; /(\d+)(\d{3})/.test(p.toString());)p = p.toString().replace(/(\d+)(\d{3})/, "$1,$2");
                    n.formatter && (p = n.formatter.call(this, p)), t.unshift(p)
                }
                a.data("counterup-nums", t), a.text("0");
                var y = function () {
                    return a.data("counterup-nums") ? (a.html(a.data("counterup-nums").shift()), void(a.data("counterup-nums").length ? setTimeout(a.data("counterup-func"), u.delay) : (a.data("counterup-nums", null), a.data("counterup-func", null), n.callback.call(this)))) : void n.callback.call(this)
                };
                a.data("counterup-func", y), setTimeout(a.data("counterup-func"), u.delay)
            };
            a.waypoint(function (t) {
                r(), this.destroy()
            }, {offset: "100%"})
        })
    }
}(jQuery);

jQuery(document).ready(function ($) {
    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });
});