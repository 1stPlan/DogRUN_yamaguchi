$(function() {
    // スクロール
    var startPos = 0,
        winScrollTop = 0;

    $(window).on("scroll", function() {
        winScrollTop = $(this).scrollTop();
        if (winScrollTop >= startPos) {
            if (winScrollTop >= 200) {
                if ($("#cross_menu").prop("checked") == false) {
                    $(".header__list").addClass("hide");
                }
            }
        } else {
            $(".header__list").removeClass("hide");
        }
        startPos = winScrollTop;
    });

    // メニュー
    $("#cross_menu").on("click", function() {
        $("#header-nav").slideToggle();
    });

    $("#cross_menu").on("click", function() {
        $(".header_list").toggleClass("open");
    });

    $("#header-nav li a").on("click", function() {
        $("#header-nav").css("display", "none");
        $('input[name="check"]').prop("checked", false);
        $(".header_list").toggleClass("open");
    });

    // スライダー
    $("#event_mv").slick({
        draggable: false, //追加（ドラッグでのスライド禁止
        arrows: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 530,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    $(".event__list").slick({
        asNavFor: "#event_mv", //追加（テキストスライダーを追従させる
        autoplay: true,
        infinite: true,
        autoplaySpeed: 4000,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<span class="slide-arrow prev-arrow"></span>',
        nextArrow: '<span class="slide-arrow next-arrow"></span>',
        responsive: [
            {
                breakpoint: 960,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 530,
                settings: {
                    arrows: false,
                    centerPadding: "5%",
                    focusOnSelect: true,
                    touchMove: true,
                    centerMode: true,
                    speed: 500, //スライドのスピード。初期値は300。
                    slidesToShow: 1, //スライドを画面に3枚見せる
                    slidesToScroll: 1, //1回のスクロールで1枚の写真を移動して見せる
                    variableWidth: true //幅の違う画像の高さを揃えて表示
                }
            }
        ]
    });

    // ページトップ
    $("#upArrow").on("click", function() {
        $("body,html").animate(
            {
                scrollTop: 0
            },
            500
        );
        return false;
    });

    $(".floating__banner-close").on("click", function() {
        $(this)
            .parent()
            .hide();
    });

    $("#form_circle").on("click", function() {
        $(".comment_form").toggleClass("active");
    });


    /*Dropdown Menu*/
    $(".dropdown").on("click", function() {
        $(this).attr("tabindex", 1).focus();
        $(this).toggleClass("active");
        $(this).find(".dropdown-menu").slideToggle(300);
    });
    $(".dropdown .dropdown-menu li").on("click", function() {
        $(this).parents(".dropdown").find("span").text($(this).text());
        $(this).parents(".dropdown").find("input").attr("value", $(this).attr("id"));
    });

});

//post削除
function deletePost(e) {
    "use strict";

    if (confirm("本当に削除していいですか?")) {
        document.getElementById("form_" + e.dataset.id).submit();
    }
}

// showProfile
function showProfile(e) {
    var id = e.dataset.id;
    var img = e.dataset.img;
    var name = e.dataset.name;
    // var type = e.dataset.type;
    var count = e.dataset.login_count;
    var target = e.dataset.target;
    

    console.log(target);

    Swal.fire({
        html:
            '<ul class="mypage__status-list"><li class="mypage__status-item"><p class="mypage__status-item-tit">NAME</p><h4 class="mypage__status-item-body">' +
            name +
            '</h4><li class="mypage__status-item"><p class="mypage__status-item-tit">自己紹介</p><h3 class="mypage__status-item-body">' +
            target +
            '</h3></div></li></ul></div>',

        iconHtml: img
            ? '<img src=/images/dogs/' + img + '.jpg' + ' width="100%">'
            : '<img src="/images/sample.png" width="100%">',
        customClass: {
            icon: "mypage__icon"
        },


        showConfirmButton: false
    });
}

function deleteEvent(e) {
    Swal.fire({
        title: "本当に削除しますか?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "削除します!",
        position: "center",
        closeOnConfirm: false,
        allowEscapeKey: true, //Escボタン
        allowOutsideClick: true, //枠外クリック
        showCloseButton: true //閉じるボタン
    }).then(function(result) {
        //←この行の記述を修正した結果改善された

        if (result.value) {
            document.getElementById("form_" + e.dataset.id).submit();

            Swal.fire({
                position: "center",
                icon: "success",
                title: "Successfully Deleted!",
                showConfirmButton: false,
                timer: 2500
            });
        }
    });
}

// datetimepicker
$(function() {
    $.datetimepicker.setLocale("ja");
    $(".date_picker").datetimepicker({
        lang: "ja"
    });
});
