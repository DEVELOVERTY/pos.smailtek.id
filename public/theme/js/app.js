!(function (t) {
    "use strict";
    function s() {
        for (
            var e = document
                    .getElementById("topnav-menu-content")
                    .getElementsByTagName("a"),
                t = 0,
                n = e.length;
            t < n;
            t++
        )
            "nav-item dropdown active" ===
                e[t].parentElement.getAttribute("class") &&
                (e[t].parentElement.classList.remove("active"),
                e[t].nextElementSibling.classList.remove("show"));
    }
    function n(e) {
      
    }
    function e() {
        document.webkitIsFullScreen ||
            document.mozFullScreen ||
            document.msFullscreenElement ||
            (console.log("pressed"),
            t("body").removeClass("fullscreen-enable"));
    }
    var a;
    t("#side-menu").metisMenu(),
        t("#vertical-menu-btn").on("click", function (e) {
            e.preventDefault(),
                t("body").toggleClass("sidebar-enable"),
                992 <= t(window).width()
                    ? t("body").toggleClass("vertical-collpsed")
                    : t("body").removeClass("vertical-collpsed");
        }),
        t("#sidebar-menu a").each(function () {
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e &&
                (t(this).addClass("active"),
                t(this).parent().addClass("mm-active"),
                t(this).parent().parent().addClass("mm-show"),
                t(this).parent().parent().prev().addClass("mm-active"),
                t(this).parent().parent().parent().addClass("mm-active"),
                t(this).parent().parent().parent().parent().addClass("mm-show"),
                t(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("mm-active"));
        }),
        t(".navbar-nav a").each(function () {
            var e = window.location.href.split(/[?#]/)[0];
            this.href == e &&
                (t(this).addClass("active"),
                t(this).parent().addClass("active"),
                t(this).parent().parent().addClass("active"),
                t(this).parent().parent().parent().addClass("active"),
                t(this).parent().parent().parent().parent().addClass("active"),
                t(this)
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .parent()
                    .addClass("active"));
        }),
        t(document).ready(function () {
            var e;
            0 < t("#sidebar-menu").length &&
                0 < t("#sidebar-menu .mm-active .active").length &&
                300 <
                    (e = t("#sidebar-menu .mm-active .active").offset().top) &&
                ((e -= 300),
                t(".vertical-menu .simplebar-content-wrapper").animate(
                    { scrollTop: e },
                    "slow"
                ));
        }),
       
        
        (function () {
            if (document.getElementById("topnav-menu-content")) {
                for (
                    var e = document
                            .getElementById("topnav-menu-content")
                            .getElementsByTagName("a"),
                        t = 0,
                        n = e.length;
                    t < n;
                    t++
                )
                    e[t].onclick = function (e) {
                        "#" === e.target.getAttribute("href") &&
                            (e.target.parentElement.classList.toggle("active"),
                            e.target.nextElementSibling.classList.toggle(
                                "show"
                            ));
                    };
                window.addEventListener("resize", s);
            }
        })(),
        t(function () {
            t('[data-bs-toggle="tooltip"]').tooltip();
        }),
        t(function () {
            t('[data-bs-toggle="popover"]').popover();
        }),
        window.sessionStorage &&
            ((a = sessionStorage.getItem("is_visited"))
                ? (t(".right-bar input:checkbox").prop("checked", !1),
                  t("#" + a).prop("checked", !0),
                  n(a))
                : sessionStorage.setItem("is_visited", "light-mode-switch")),
        t("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch").on(
            "change",
            function (e) {
                n(e.target.id);
            }
        ),
        t(window).on("load", function () {
            t("#status").fadeOut(), t("#preloader").delay(350).fadeOut("slow");
        }),
        Waves.init();
})(jQuery);
