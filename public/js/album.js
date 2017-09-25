$defaultViewMode = "fit";
$bg = $("#bg");
$bgimg = $("#bg #bgimg");
$preloader = $("#preloader");
$outer_container = $("#outer_container");
$outer_container_a = $("#outer_container .content>a");
$toolbar = $("#toolbar");
$nextimage_tip = $("#nextimage_tip");
$(window).load(function() {
    $toolbar.data("imageViewMode", $defaultViewMode);
    ImageViewMode($toolbar.data("imageViewMode"));
    $customScrollBox = $("#customScrollBox");
    $customScrollBox_container = $("#customScrollBox .container");
    $customScrollBox_content = $("#customScrollBox .content");
    $dragger_container = $("#dragger_container");
    $dragger = $("#dragger");
    CustomScroller();
    function CustomScroller() {
        outerMargin = 0;
        innerMargin = 20;
        $customScrollBox.height(600 - outerMargin);
        $dragger_container.height($(window).height() - innerMargin);
        visibleHeight = $(window).height() - outerMargin;
        if ($customScrollBox_container.height() > visibleHeight) {
            $dragger_container,
            $dragger.css("display", "block");
            totalContent = $customScrollBox_content.height();
            draggerContainerHeight = $(window).height() - innerMargin;
            animSpeed = 400;
            easeType = "easeOutCirc";
            bottomSpace = 1.05;
            targY = 0;
            draggerHeight = $dragger.height();
            $dragger.draggable({
                axis: "y",
                containment: "parent",
                drag: function(event, ui) {
                    Scroll()
                },
                stop: function(event, ui) {
                    DraggerOut()
                }
            });
            $dragger_container.click(function(e) {
                var mouseCoord = (e.pageY - $(this).offset().top);
                var targetPos = mouseCoord + $dragger.height();
                if (targetPos < draggerContainerHeight) {
                    $dragger.css("top", mouseCoord);
                    Scroll()
                } else {
                    $dragger.css("top", draggerContainerHeight - $dragger.height());
                    Scroll()
                }
            });
            $(function($) {
                $customScrollBox.bind("mousewheel",
                function(event, delta) {
                    vel = Math.abs(delta * 10);
                    $dragger.css("top", $dragger.position().top - (delta * vel));
                    Scroll();
                    if ($dragger.position().top < 0) {
                        $dragger.css("top", 0);
                        $customScrollBox_container.stop();
                        Scroll()
                    }
                    if ($dragger.position().top > draggerContainerHeight - $dragger.height()) {
                        $dragger.css("top", draggerContainerHeight - $dragger.height());
                        $customScrollBox_container.stop();
                        Scroll()
                    }
                    return false
                })
            });
            function Scroll() {
                var scrollAmount = (totalContent - (visibleHeight / bottomSpace)) / (draggerContainerHeight - draggerHeight);
                var draggerY = $dragger.position().top;
                targY = -draggerY * scrollAmount;
                var thePos = $customScrollBox_container.position().top - targY;
                $customScrollBox_container.stop().animate({
                    top: "-=" + thePos
                },
                animSpeed, easeType)
            }
            $dragger.mouseup(function() {
                DraggerOut()
            }).mousedown(function() {
                DraggerOver()
            });
            function DraggerOver() {
                $dragger.css("background", "url(imgs/round_custom_scrollbar_bg_over.png)")
            }
            function DraggerOut() {
                $dragger.css("background", "url(imgs/round_custom_scrollbar_bg.png)")
            }
        } else {
            $dragger,
            $dragger_container.css("display", "none")
        }
    }
    $(window).resize(function() {
        FullScreenBackground("#bgimg");
        $dragger.css("top", 0);
        $customScrollBox_container.css("top", 0);
        $customScrollBox.unbind("mousewheel");
        CustomScroller()
    });
    LargeImageLoad($bgimg)
});
$bgimg.load(function() {
    LargeImageLoad($(this))
});
function LargeImageLoad($this) {
    $preloader.fadeOut("fast");
    $this.removeAttr("width").removeAttr("height").css({
        width: "",
        height: ""
    });
    $bg.data("originalImageWidth", $this.width()).data("originalImageHeight", $this.height());
    if ($bg.data("newTitle")) {
        $this.attr("title", $bg.data("newTitle"))
    }
    FullScreenBackground($this);
    $bg.data("nextImage", $($outer_container.data("selectedThumb")).next().attr("href"));
    if (typeof itemIndex != "undefined") {
        if (itemIndex == lastItemIndex) {
            $bg.data("lastImageReached", "Y");
            $bg.data("nextImage", $outer_container_a.first().attr("href"))
        } else {
            $bg.data("lastImageReached", "N")
        }
    } else {
        $bg.data("lastImageReached", "N")
    }
    $this.fadeIn("slow");
    if ($bg.data("nextImage") || $bg.data("lastImageReached") == "Y") {
        SlidePanels("close")
    }
    NextImageTip()
}
$outer_container.hover(function() {
    SlidePanels("open")
},
function() {
    SlidePanels("close")
});
$outer_container_a.click(function(event) {
    event.preventDefault();
    var $this = this;
    $bgimg.css("display", "none");
    $preloader.fadeIn("fast");
    $outer_container_a.each(function() {
        $(this).children(".selected").css("display", "none")
    });
    $(this).children(".selected").css("display", "block");
    $outer_container.data("selectedThumb", $this);
    $bg.data("nextImage", $(this).next().attr("href"));
    $bg.data("newTitle", $(this).children("img").attr("title"));
    itemIndex = getIndex($this);
    lastItemIndex = ($outer_container_a.length) - 1;
    $bgimg.attr("src", "").attr("src", $this)
});
$bgimg.click(function(event) {
    var $this = $(this);
    if ($bg.data("nextImage")) {
        $this.css("display", "none");
        $preloader.fadeIn("fast");
        $($outer_container.data("selectedThumb")).children(".selected").css("display", "none");
        if ($bg.data("lastImageReached") != "Y") {
            $($outer_container.data("selectedThumb")).next().children(".selected").css("display", "block")
        } else {
            $outer_container_a.first().children(".selected").css("display", "block")
        }
        var selThumb = $outer_container.data("selectedThumb");
        if ($bg.data("lastImageReached") != "Y") {
            $outer_container.data("selectedThumb", $(selThumb).next())
        } else {
            $outer_container.data("selectedThumb", $outer_container_a.first())
        }
        $bg.data("newTitle", $($outer_container.data("selectedThumb")).children("img").attr("title"));
        if ($bg.data("lastImageReached") != "Y") {
            itemIndex++
        } else {
            itemIndex = 0
        }
        $this.attr("src", "").attr("src", $bg.data("nextImage"))
    }
});
function getIndex(theItem) {
    for (var i = 0,
    length = $outer_container_a.length; i < length; i++) {
        if ($outer_container_a[i] === theItem) {
            return i
        }
    }
}
$toolbar.hover(function() {
    $(this).stop().fadeTo("fast", 1)
},
function() {
    $(this).stop().fadeTo("fast", 0.8)
});
$toolbar.stop().fadeTo("fast", 0.8);
$toolbar.click(function(event) {
    ImageViewMode("fit");
    // if ($toolbar.data("imageViewMode") == "full") {
    //     ImageViewMode("fit")
    // } else if ($toolbar.data("imageViewMode") == "fit") {
    //     ImageViewMode("original")
    // } else if ($toolbar.data("imageViewMode") == "original") {
    //     ImageViewMode("full")
    // }
});
function NextImageTip() {
    if ($bg.data("nextImage")) {
        $nextimage_tip.stop().css("right", 20).fadeIn("fast").fadeOut(2000, "easeInExpo",
        function() {
            $nextimage_tip.css("right", $(window).width())
        })
    }
}
function SlidePanels(action) {
    var speed = 900;
    var easing = "easeInOutExpo";
    if (action == "open") {
        $("#arrow_indicator").fadeTo("fast", 0);
        $outer_container.stop().animate({
            left: 0
        },
        speed, easing);
        $bg.stop().animate({
            left: 0
        },
        speed, easing)
    } else {
        $outer_container.stop().animate({
            left: -340
        },
        speed, easing);
        $bg.stop().animate({
            left: -200
        },
        speed, easing,
        function() {
            $("#arrow_indicator").fadeTo("fast", 1)
        })
    }
}
function FullScreenBackground(theItem) {
    var winWidth = $(window).width();
    var winHeight = $(window).height();
    var imageWidth = $(theItem).width();
    var imageHeight = $(theItem).height();
    if ($toolbar.data("imageViewMode") != "original") {
        $(theItem).removeClass("with_border").removeClass("with_shadow");
        var picHeight = imageHeight / imageWidth;
        var picWidth = imageWidth / imageHeight;
        if ($toolbar.data("imageViewMode") != "fit") {
            if ((winHeight / winWidth) < picHeight) {
                $(theItem).css("width", winWidth).css("height", picHeight * winWidth)
            } else {
                $(theItem).css("height", winHeight).css("width", picWidth * winHeight)
            }
        } else {
            if ((winHeight / winWidth) > picHeight) {
                $(theItem).css("width", winWidth).css("height", picHeight * winWidth)
            } else {
                $(theItem).css("height", winHeight).css("width", picWidth * winHeight)
            }
        }
        $(theItem).css("margin-left", ((winWidth - $(theItem).width()) / 2)).css("margin-top", ((winHeight - $(theItem).height()) / 2))
    } else {
        $(theItem).addClass("with_border").addClass("with_shadow");
        $(theItem).css("width", $bg.data("originalImageWidth")).css("height", $bg.data("originalImageHeight"));
        $(theItem).css("margin-left", ((winWidth - $(theItem).outerWidth()) / 2)).css("margin-top", ((winHeight - $(theItem).outerHeight()) / 2))
    }
}
function ImageViewMode(theMode) {
    $toolbar.data("imageViewMode", theMode);
    FullScreenBackground($bgimg);
    if (theMode == "full") {
        $toolbar.html("<span class='lightgrey'>图像查看模式 &rsaquo;</span> 满屏")
    } else if (theMode == "fit") {
        $toolbar.html("<span class='lightgrey'>图像查看模式 &rsaquo;</span> 自适应")
    } else {
        $toolbar.html("<span class='lightgrey'>图像查看模式 &rsaquo;</span> 原图大小")
    }
}
var images = ["imgs/ajax-loader_dark.gif", "imgs/round_custom_scrollbar_bg_over.png"];
$.each(images,
function(i) {
    images[i] = new Image();
    images[i].src = this
});