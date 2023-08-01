import {
    S,
    P as $
} from "./vendor.4d54a1d2.js";
const x = function () {
    const d = document.createElement("link").relList;
    if (d && d.supports && d.supports("modulepreload")) return;
    for (const i of document.querySelectorAll('link[rel="modulepreload"]')) l(i);
    new MutationObserver(i => {
        for (const t of i)
            if (t.type === "childList")
                for (const c of t.addedNodes) c.tagName === "LINK" && c.rel === "modulepreload" && l(c)
    }).observe(document, {
        childList: !0,
        subtree: !0
    });

    function o(i) {
        const t = {};
        return i.integrity && (t.integrity = i.integrity), i.referrerpolicy && (t.referrerPolicy = i.referrerpolicy), i.crossorigin === "use-credentials" ? t.credentials = "include" : i.crossorigin === "anonymous" ? t.credentials = "omit" : t.credentials = "same-origin", t
    }

    function l(i) {
        if (i.ep) return;
        i.ep = !0;
        const t = o(i);
        fetch(i.href, t)
    }
};
x();

function I(h) {
    const d = h.querySelector(".swiper");
    let o = !1,
        l = !1,
        i;
    const t = e => {
            e.addClass("fashion-slider-no-transition"), l = !0, cancelAnimationFrame(i), i = requestAnimationFrame(() => {
                e.removeClass("fashion-slider-no-transition"), l = !1, o = !1
            })
        },
        c = e => {
            e.$el.find(".fashion-slider-button-next").on("click", () => {
                o || e.slideNext()
            }), e.$el.find(".fashion-slider-button-prev").on("click", () => {
                o || e.slidePrev()
            })
        },
        b = e => {
            e.$el.find(".fashion-slider-button-next, .fashion-slider-button-prev").off("click")
        };
    return new S(d, {
        modules: [$],
        speed: 1300,
        allowTouchMove: !1,
        parallax: !0,
        on: {
            transitionStart(e) {
                const {
                    slides: r,
                    previousIndex: s,
                    activeIndex: n,
                    $el: a
                } = e;
                l || (o = !0);
                const f = r.eq(n),
                    u = r.eq(s),
                    v = u.find(".fashion-slider-scale"),
                    m = u.find("img"),
                    g = f.find("img"),
                    p = n - s,
                    y = f.attr("data-slide-bg-color");
                a.css("background-color", y), v.transform("scale(1.0)"), m.transition(1e3).transform("scale(1.2)"), u.find(".fashion-slider-title-text").transition(1e3).css("color", "rgba(255,255,255,0)"), m.transitionEnd(() => {
                    g.transition(1300).transform("translate3d(0, 0, 0) scale(1.0)"), m.transition(1300).transform(`translate3d(${60*p}%, 0, 0)  scale(1.2)`)
                })
            },
            transitionEnd(e) {
                const {
                    slides: r,
                    activeIndex: s,
                    $el: n
                } = e, a = r.eq(s), f = a.find("img");
                a.find(".fashion-slider-scale").transform("scale(1)"), f.transition(1e3).transform("scale(1)"), a.find(".fashion-slider-title-text").transition(1e3).css("color", "rgba(255,255,255,1)"), f.transitionEnd(() => {
                    o = !1
                }), s === 0 ? n.find(".fashion-slider-button-prev").addClass("fashion-slider-button-disabled") : n.find(".fashion-slider-button-prev").removeClass("fashion-slider-button-disabled"), s === r.length - 1 ? n.find(".fashion-slider-button-next").addClass("fashion-slider-button-disabled") : n.find(".fashion-slider-button-next").removeClass("fashion-slider-button-disabled")
            },
            init(e) {
                const {
                    slides: r,
                    activeIndex: s,
                    $el: n
                } = e;
                t(n);
                const a = r.eq(s).attr("data-slide-bg-color");
                n.css("background-color", a), e.emit("transitionEnd"), c(e)
            },
            resize(e) {
                t(e.$el)
            },
            destroy(e) {
                b(e)
            }
        }
    })
}
const q = document.querySelector(".fashion-slider");
I(q);
