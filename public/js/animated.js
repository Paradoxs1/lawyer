! function(s) {
    s.fn.animated = function(t, i) {
        s(this).css("opacity", "0").addClass("animated").waypoint(function(n) {
            "down" === n ? s(this).removeClass(i).addClass(t).css("opacity", "1") : s(this).removeClass(t).addClass(i).css("opacity", "1")
        }, {
            offset: "90%"
        }).waypoint(function(n) {
            "down" === n ? s(this).removeClass(t).addClass(i).css("opacity", "1") : s(this).removeClass(i).addClass(t).css("opacity", "1")
        }, {
            offset: -s(window).height()
        })
    }
}(jQuery),
function($) {
        $.fn.animated2 = function(inEffect, outEffect) {
            $(this).css("opacity", "0").addClass("animated").waypoint(function(dir) {
                    if (dir === "down") {
                            $(this).removeClass(outEffect).addClass(inEffect).css("opacity", "1");
                    }
            }, {
                    offset: "90%"
            })
        };
}(jQuery);