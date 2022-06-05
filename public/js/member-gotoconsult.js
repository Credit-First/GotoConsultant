var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

var selectedConsultantId = 0;
var selectedPlanId = 0;
var selectedSessionPrice = null;
var selectedSessionCurrency = null;
var selectedSesionTitle = null;
var selectedSessionId = 0;
var selectedBookingDate = null;
var selectedCommunicationWay = null;

const public = function() {
    $(".member-btn-country").on("click", function(e) {
        e.preventDefault();
        const href = window.location.href;
        const origin = window.location.origin;
        var url = href.replace(origin, "");
        if (lang == "no") {
            if (url.includes("/no/finn-konsulent-sok")) {
                url = url.replace(
                    "/no/finn-konsulent-sok",
                    "find-consultant-search"
                );
            } else if (url.includes("/no/transaksjoner-sok")) {
                url = url.replace(
                    "/no/transaksjoner-sok",
                    "transaction-search"
                );
            } else if (url.includes("/no/moter")) {
                url = url.replace("/no/moter", "sessions");
            } else if (url.includes("/no/profil")) {
                url = url.replace("/no/profil", "profile");
            }
            switch (url) {
                case "/no/oversikt":
                    url = "dashboard";
                    break;
                case "/no/planer":
                    url = "plan";
                    break;
                case "/no/finn-konsulent":
                    url = "find-consultant";
                    break;
                case "/no/lommebok":
                    url = "wallet";
                    break;
                case "/no/transaksjoner":
                    url = "transactions";
                    break;
                case "/no/kontoinnstillinger":
                    url = "member-settings";
                    break;
                case "/no/kalender":
                    url = "calendar";
                    break;
                case "/medlem/personvern":
                    url = "member/privacy";
                    break;
                case "/medlem/vilkar-kunde":
                    url = "member/terms-customer";
                    break;
                case "/medlem/vilkar-konsulent":
                    url = "member/terms-consultant";
                    break;
            }
        } else {
            if (url.includes("/find-consultant-search")) {
                url = url.replace(
                    "/find-consultant-search",
                    "finn-konsulent-sok"
                );
            } else if (url.includes("/transaction-search")) {
                url = url.replace("/transaction-search", "transaksjoner-sok");
            } else if (url.includes("/sessions")) {
                url = url.replace("/sessions", "moter");
            } else if (url.includes("/profile")) {
                url = url.replace("/profile", "profil");
            }
            switch (url) {
                case "/dashboard":
                    url = "oversikt";
                    break;
                case "/plan":
                    url = "planer";
                    break;
                case "/find-consultant":
                    url = "finn-konsulent";
                    break;
                case "/wallet":
                    url = "lommebok";
                    break;
                case "/transactions":
                    url = "transaksjoner";
                    break;
                case "/calendar":
                    url = "kalender";
                    break;
                case "/member-settings":
                    url = "kontoinnstillinger";
                    break;
                case "/member/privacy":
                    url = "medlem/personvern";
                    break;
                case "/member/terms-customer":
                    url = "medlem/vilkar-kunde";
                    break;
                case "/member/terms-consultant":
                    url = "medlem/vilkar-konsulent";
                    break;
            }
        }
        var new_lang = lang == "en" ? "no" : "en";
        $(".member_selected_lang").val(new_lang);
        $(".member_current_address").val(url);
        $(".member-lang-form").trigger("submit");
    });
    $(".navbar-toggler").on("click", function() {
        $(".navbar-sidebar").addClass("collapsed");
        $(".navigation__nav").addClass("collapsed");
    });
    $(".navigation-toggler").on("click", function() {
        $(".navbar-sidebar").removeClass("collapsed");
        $(".navigation__nav").removeClass("collapsed");
    });
};
const dashboard = function(rate_imgs, btn_imgs, educatedIcon, recommended_consultants, recent_sessions, categories) {
    const Uri = function(url) {
        return window.location.origin + url;
    };
    const sessionViewInit = function(sessions) {
        let append_html = "";
        const percentage =
            $(window).width() < 768
                ? 1
                : $(window).width() < 1024
                ? 2
                : $(window).width() < 1440
                ? 3
                : $(window).width() < 1920
                ? 4
                : 5;
        sessions.forEach((item, key) => {
            let star_images = "<ul class='d-flex'>";
            for (let i = 0; i < 5; i++) {
                if (item.rate == 5) {
                    star_images +=
                        "<li><img src='" +
                        rate_imgs[0] +
                        "' alt-img='no-img'/></li>";
                } else if (item.rate == 4) {
                    star_images +=
                        i < 4
                            ? "<li><img src='" +
                              rate_imgs[1] +
                              "' alt-img='no-img'/></li>"
                            : "<li><img src='" +
                              rate_imgs[5] +
                              "' alt-img='no-img'/></li>";
                } else if (item.rate == 3) {
                    star_images +=
                        i < 3
                            ? "<li><img src='" +
                              rate_imgs[2] +
                              "' alt-img='no-img'/></li>"
                            : "<li><img src='" +
                              rate_imgs[5] +
                              "' alt-img='no-img'/></li>";
                } else if (item.rate == 2) {
                    star_images +=
                        i < 2
                            ? "<li><img src='" +
                              rate_imgs[3] +
                              "' alt-img='no-img'/></li>"
                            : "<li><img src='" +
                              rate_imgs[5] +
                              "' alt-img='no-img'/></li>";
                } else if (item.rate == 1) {
                    star_images +=
                        i < 1
                            ? "<li><img src='" +
                              rate_imgs[4] +
                              "' alt-img='no-img'/></li>"
                            : "<li><img src='" +
                              rate_imgs[5] +
                              "' alt-img='no-img'/></li>";
                } else {
                    star_images +=
                        "<li><img src='" +
                        rate_imgs[5] +
                        "' alt-img='no-img'/></li>";
                }
            }
            star_images += "</ul>";
            const floatRate = item.rate ? item.rate : 0;
            star_images += `<p>${floatRate.toFixed(1)}</p>`;
            const btn_name = lang == "en" ? "View Session" : "Vis økt";
            const session_url =
                lang == "en"
                    ? Uri("/sessions/" + item.user_id)
                    : Uri("/no/moter/" + item.user_id);
            const educatedHtml = `<span><img src="${educatedIcon}" alt="no-img" /></span>`;
            let html_item = item.company
                ? `<div class='cart-section' id='session_${item.user_id}'><div class='avatar-pic'>${educatedHtml}</div>`
                : `<div class='cart-section' id='session_${item.user_id}'><div class='avatar-pic'></div>`;

            if (item.profile.profession) {
                html_item +=
                    "<label class='mt-3 mb-0'>" +
                    item.profile.profession +
                    "</label>";
                html_item +=
                    "<h3>" +
                    item.user.first_name +
                    " " +
                    item.user.last_name +
                    "</h3><small></small><div class='star-images'>" +
                    star_images +
                    "</div><small></small>";
            } else {
                html_item +=
                    "<h3 class='mt-3 mb-0'>" +
                    item.user.first_name +
                    " " +
                    item.user.last_name +
                    "</h3><small></small><div class='star-images'>" +
                    star_images +
                    "</div><small></small>";
            }
            html_item += "<div class='end-button d-flex'>";
            html_item +=
                "<a href='" +
                session_url +
                "' style='width: 140px;'>" +
                btn_name +
                "</a></div></div>";

            if (key == 0) {
                append_html += "<div class='cart-full'>";
                append_html += html_item;
            } else if (key % percentage == 0) {
                append_html += "</div><div class='cart-full'>";
                append_html += html_item;
            } else {
                append_html += html_item;
            }
            if (key == sessions.length - 1) {
                append_html += "</div>";
            }
        });
        $(".sessions-view").append(append_html);
        sessions.forEach(item => {
            const url =
                item.profile && item.profile.avatar != null
                    ? item.profile.avatar
                    : "images/white-logo.svg";
            const sizeCss =
                item.profile && item.profile.avatar != null
                    ? "cover"
                    : "20px 20px";
            $("#session_" + item.user_id)
                .children()
                .eq(0)
                .css("background-image", "url(" + url + ")");
            $("#session_" + item.user_id)
                .children()
                .eq(0)
                .css("background-size", sizeCss);
        });
        if (sessions.length > percentage) {
            // $('.sessions-view').slick({
            //   dots: true,
            //   infinite: false,
            //   mobileFirst: true,
            //   arrows: false,
            //   fade: false,
            //   speed: 300,
            //   slidesToShow: 1,
            //   cssEase: 'linear'
            // });
        }
    };
    const consultantViewInit = function(consultants, categories) {
        $(document).ready(function(){
            $(".btn-book").on("click", function(){
                selectedConsultantId = $(this).attr("data-id");
                $(`#modal-booking-${selectedConsultantId}`).modal('show');
            });
        });
        let append_html = "";
        const percentage =
            $(window).width() < 768
                ? 1
                : $(window).width() < 1024
                ? 2
                : $(window).width() < 1440
                ? 3
                : $(window).width() < 1920
                ? 4
                : 5;
        consultants.forEach((item, key) => {
            let star_images = "<ul class='d-flex'>";
            for (let i = 0; i < 5; i++) {
                if (item.rate == 5) {
                    star_images += `<li><img src='${rate_imgs[0]}' alt-img='no-img'/></li>`;
                } else if (item.rate == 4) {
                    star_images +=
                        i < 4
                            ? `<li><img src='${rate_imgs[1]}' alt-img='no-img'/></li>`
                            : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                } else if (item.rate == 3) {
                    star_images +=
                        i < 3
                            ? `<li><img src='${rate_imgs[2]}' alt-img='no-img'/></li>`
                            : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                } else if (item.rate == 2) {
                    star_images +=
                        i < 2
                            ? `<li><img src='${rate_imgs[3]}' alt-img='no-img'/></li>`
                            : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                } else if (item.rate == 1) {
                    star_images +=
                        i < 1
                            ? `<li><img src='${rate_imgs[4]}' alt-img='no-img'/></li>`
                            : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                } else {
                    star_images += `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                }
            }
            star_images += "</ul>";
            const floatRate = item.rate ? item.rate : 0;
            star_images += `<p>${floatRate.toFixed(1)}</p>`;
            const profile_url =
                lang == "en"
                    ? item.user.account_id
                        ? Uri("/profile/" + item.user.account_id)
                        : Uri("/profile/" + item.user.id)
                    : item.user.account_id
                    ? Uri("/no/profil/" + item.user.account_id)
                    : Uri("/no/profil/" + item.user.id);
            const btn_name = lang == "en" ? "Profile" : "Profil";
            const btn_book_name = lang == "en" ? "Book Now" : "Bestill nå";
            const session_url =
                lang == "en"
                    ? Uri(`/sessions/${item.user_id}`)
                    : Uri(`/no/moter/${item.user_id}`);
            const btn_phone_img =
                item.user.status == "available"
                    ? item.phone_contact != 0
                        ? btn_imgs[0]
                        : btn_imgs[2]
                    : item.user.status == "offline"
                    ? btn_imgs[2]
                    : item.phone_contact != 0
                    ? btn_imgs[1]
                    : btn_imgs[2];
            const btn_video_img =
                item.user.status == "available"
                    ? item.video_contact != 0
                        ? btn_imgs[3]
                        : btn_imgs[5]
                    : item.user.status == "offline"
                    ? btn_imgs[5]
                    : item.video_contact != 0
                    ? btn_imgs[4]
                    : btn_imgs[5];
            const btn_chat_img =
                item.user.status == "available"
                    ? item.chat_contact != 0
                        ? btn_imgs[6]
                        : btn_imgs[8]
                    : item.user.status == "offline"
                    ? btn_imgs[8]
                    : item.chat_contact != 0
                    ? btn_imgs[7]
                    : btn_imgs[8];
            const is_offline = item.user.status == "offline" ? true : false;
            const educatedHtml = `<span><img src="${educatedIcon}" alt="no-img" /></span>`;
            let html_item = item.company
                ? `<div class='cart-section' id='con_${item.user_id}'><div class='avatar-pic'>${educatedHtml}</div>`
                : `<div class='cart-section' id='con_${item.user_id}'><div class='avatar-pic'></div>`;

            if (item.hasOwnProperty("profile") && item.profile.profession) {
                const category = categories.find(
                    sel => sel.category_name === item.profile.profession
                );

                if (typeof category !== "undefined") {
                    const profession =
                        lang === "en"
                            ? category.category_name
                            : category.category_name_no;
                    html_item += `<label class='mt-3 mb-0'>${profession}</label>`;
                    html_item += `<h3>${item.user.first_name} ${item.user.last_name}</h3><small></small><div class='star-images'>${star_images}</div><small></small>`;
                }
            } else {
                html_item += `<h3 class='mt-3 mb-0'>${item.user.first_name} ${item.user.last_name}</h3><small></small><div class='star-images'>${star_images}</div><small></small>`;
            }
            html_item += `<div class='rm d-flex justify-content-between'><a href='${profile_url}'>${btn_name}</a><p>${item.currency} ${item.hourly_rate} p/m</p></div>`;
            html_item += renderBookingModal(item);
            html_item += "<div class='end-button d-flex'>";
            html_item += `<a class="btn-book" data-id="${item.user_id}">${btn_book_name}</a>`;
            // html_item += `<a class='btn-session' href='${
            //     is_offline ? "javascript:void(0)" : session_url
            // }'><img src='${btn_phone_img}' alt='no-img'/></a>`;
            // html_item += `<a class='btn-session' href='${
            //     is_offline ? "javascript:void(0)" : session_url
            // }'><img src='${btn_video_img}' alt='no-img'/></a>`;
            // html_item += `<a class='btn-session' href='${
            //     is_offline ? "javascript:void(0)" : session_url
            // }'><img src='${btn_chat_img}' alt='no-img'/></a>`;
            html_item += "</div></div>";

            if (key == 0) {
                append_html += "<div class='cart-full'>";
                append_html += html_item;
            } else if (key % percentage == 0) {
                append_html += "</div><div class='cart-full'>";
                append_html += html_item;
            } else {
                append_html += html_item;
            }
            if (key == consultants.length - 1) {
                append_html += "</div>";
            }
        });
        $(".consultants-view").append(append_html);
        consultants.forEach(item => {
            const url =
                item.profile && item.profile.avatar != null
                    ? item.profile.avatar
                    : "images/white-logo.svg";
            const sizeCss =
                item.profile && item.profile.avatar != null
                    ? "cover"
                    : "20px 20px";
            $("#con_" + item.user_id)
                .children()
                .eq(0)
                .css("background-image", "url(" + url + ")");
            $("#con_" + item.user_id)
                .children()
                .eq(0)
                .css("background-size", sizeCss);
        });
        if (consultants.length > percentage) {
            // $('.consultants-view').slick({
            //   dots: true,
            //   infinite: false,
            //   mobileFirst: true,
            //   arrows: false,
            //   fade: false,
            //   speed: 300,
            //   slidesToShow: 1,
            //   cssEase: 'linear'
            // });
        }
    };
    const init = function() { 
        if (recent_sessions.length > 0) {
            sessionViewInit(recent_sessions);
        }
        if (recommended_consultants.length > 0) {
            consultantViewInit(
                recommended_consultants,
                categories
            );
        }
    };

    init();
};
const findConsult = function(
    search,
    countries,
    consultants,
    categories,
    rate_imgs,
    btn_imgs,
    educatedIcon
) {
    var query = {};
    $("#show_filter").on("click", function() {
        if ($(".filter-body").hasClass("active")) {
            $(this).addClass("reversed");
            $(".filter-body").removeClass("active");
        } else {
            $(this).removeClass("reversed");
            $(".filter-body").addClass("active");
        }
    });
    $("#mobile_filter").on("click", function() {
        const name = query.name ? query.name : "null";
        const category = query.category ? query.category : "All";
        const status = query.status ? query.status : "All";
        const price = query.price ? query.price : "Default";
        const country = query.country ? query.country : "All";
        const url =
            lang == "en"
                ? "/find-consultant-search?name="
                : "/no/finn-konsulent-sok?name=";

        setTimeout(function() {
            window.location =
                url +
                name +
                "&category=" +
                category +
                "&price=" +
                price +
                "&status=" +
                status +
                "&country=" +
                country;
        }, 50);
    });
    $("#desktop_filter").on("click", function() {
        const name = query.name ? query.name : "null";
        const category = query.category ? query.category : "All";
        const status = query.status ? query.status : "All";
        const price = query.price ? query.price : "Default";
        const country = query.country ? query.country : "All";
        const education = query.country ? query.country : "All";
        const url =
            lang == "en"
                ? "/find-consultant-search?name="
                : "/no/finn-konsulent-sok?name=";
        setTimeout(function() {
            window.location =
                url +
                name +
                "&category=" +
                category +
                "&price=" +
                price +
                "&status=" +
                status +
                "&country=" +
                country +
                "&education=" +
                education;
        }, 50);
    });
    $(".search").on("change", function(e) {
        query.name = e.target.value != "null" ? e.target.value : "null";
    });
    $(".category-sel").on("change", function(e) {
        query.category = e.target.value != "null" ? e.target.value : "null";
    });
    $(".price-sel").on("change", function(e) {
        query.price = e.target.value != "null" ? e.target.value : "null";
    });
    $(".status-sel").on("change", function(e) {
        query.status = e.target.value != "null" ? e.target.value : "null";
    });
    $(".country-sel").on("change", function(e) {
        query.country = e.target.value != "null" ? e.target.value : "null";
    });
    
    const Uri = function(url) {
        return window.location.origin + url;
    };

    const slick = function(consultants) {
        $(document).ready(function(){
            $(".btn-book").on("click", function(){
                selectedConsultantId = $(this).attr("data-id");
                $(`#modal-booking-${selectedConsultantId}`).modal('show');
            });
        });
        let append_html = "";
        const percentage =
            $(window).width() < 768
                ? 2
                : $(window).width() == 768
                ? 4
                : ($(window).width() >= 1024) & ($(window).width() < 1440)
                ? 6
                : 10;
        consultants.forEach((item, key) => {
            let star_images = "<ul class='d-flex'>";
            for (let i = 0; i < 5; i++) {
                if (item.rate == 5) {
                    star_images += `<li><img src='${rate_imgs[0]}' alt-img='no-img'/></li>`;
                } else if (item.rate == 4) {
                    star_images +=
                        i < 4
                            ? `<li><img src='${rate_imgs[1]}' alt-img='no-img'/></li>`
                            : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                } else if (item.rate == 3) {
                    star_images +=
                        i < 3
                            ? `<li><img src='${rate_imgs[2]}' alt-img='no-img'/></li>`
                            : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                } else if (item.rate == 2) {
                    star_images +=
                        i < 2
                            ? `<li><img src='${rate_imgs[3]}' alt-img='no-img'/></li>`
                            : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                } else if (item.rate == 1) {
                    star_images +=
                        i < 1
                            ? `<li><img src='${rate_imgs[4]}' alt-img='no-img'/></li>`
                            : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                } else {
                    star_images += `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
                }
            }
            star_images += "</ul>";
            const floatRate = item.rate ? item.rate : 0;
            star_images += `<p>${floatRate.toFixed(1)}</p>`;
            const profile_url =
                lang == "en"
                    ? item.user.account_id
                        ? Uri("/profile/" + item.user.account_id)
                        : Uri("/profile/" + item.user.id)
                    : item.user.account_id
                    ? Uri("/no/profil/" + item.user.account_id)
                    : Uri("/no/profil/" + item.user.id);
            const btn_profile_name = lang == 'en' ? 'Profile' : 'Profil';
            const btn_name = lang == "en" ? "Book Now" : "Bestill nå";
            const session_url =
                lang == "en"
                    ? Uri(`/sessions/${item.user_id}`)
                    : Uri(`/no/moter/${item.user_id}`);
            const btn_phone_img =
                item.user.status == "available"
                    ? item.phone_contact != 0
                        ? btn_imgs[0]
                        : btn_imgs[2]
                    : item.user.status == "offline"
                    ? btn_imgs[2]
                    : item.phone_contact != 0
                    ? btn_imgs[1]
                    : btn_imgs[2];
            const btn_video_img =
                item.user.status == "available"
                    ? item.video_contact != 0
                        ? btn_imgs[3]
                        : btn_imgs[5]
                    : item.user.status == "offline"
                    ? btn_imgs[5]
                    : item.video_contact != 0
                    ? btn_imgs[4]
                    : btn_imgs[5];
            const btn_chat_img =
                item.user.status == "available"
                    ? item.chat_contact != 0
                        ? btn_imgs[6]
                        : btn_imgs[8]
                    : item.user.status == "offline"
                    ? btn_imgs[8]
                    : item.chat_contact != 0
                    ? btn_imgs[7]
                    : btn_imgs[8];
            const is_offline = item.user.status == "offline" ? true : false;
            const educatedHtml = `<span><img src="${educatedIcon}" alt="no-img" /></span>`;
            let html_item = item.company
                ? `<div class='cart-section' id='con_${item.user_id}'><div class='avatar-pic'>${educatedHtml}</div>`
                : `<div class='cart-section' id='con_${item.user_id}'><div class='avatar-pic'></div>`;

            if (item.hasOwnProperty("profile") && item.profile.profession) {
                const category = categories.find(
                    sel => sel.category_name === item.profile.profession
                );
                if (typeof category !== "undefined") {
                    const profession =
                        lang === "en"
                            ? category.category_name
                            : category.category_name_no;
                    html_item += `<label class='mt-3 mb-0'>${profession}</label>`;
                    html_item += `<h3>${item.user.first_name} ${item.user.last_name}</h3><small></small><div class='star-images'>${star_images}</div><small></small>`;
                }
            } else {
                html_item += `<h3 class='mt-3 mb-0'>${item.user.first_name} ${item.user.last_name}</h3><small></small><div class='star-images'>${star_images}</div><small></small>`;
            }
            html_item += `<div class='rm d-flex justify-content-between'><a href='${profile_url}'>${btn_profile_name}</a>` + renderBookingModal(item) + `<p>${item.currency} ${item.hourly_rate} p/m</p></div>`;
            html_item += "<div class='end-button d-flex'>";
            html_item += `<a class="btn-book" data-id="${item.user_id}">${btn_name}</a>`;
            //   html_item += `<a class='btn-session' href='${is_offline ? 'javascript:void(0)' : session_url}'><img src='${btn_phone_img}' alt='no-img'/></a>`;
            //   html_item += `<a class='btn-session' href='${is_offline ? 'javascript:void(0)' : session_url}'><img src='${btn_video_img}' alt='no-img'/></a>`;
            //   html_item += `<a class='btn-session' href='${is_offline ? 'javascript:void(0)' : session_url}'><img src='${btn_chat_img}' alt='no-img'/></a></div></div>`;
            html_item += "</div></div>";

            if (key == 0) {
                append_html += "<div class='cart-full'>";
                append_html += html_item;
            } else if (key % percentage == 0) {
                append_html += "</div><div class='cart-full'>";
                append_html += html_item;
            } else {
                append_html += html_item;
            }
            if (key == consultants.length - 1) {
                append_html += "</div>";
            }
        });
        $(".consultants-view").append(append_html);
        consultants.forEach(item => {
            const url =
                item.profile && item.profile.avatar != null
                    ? item.profile.avatar
                    : "images/white-logo.svg";
            const sizeCss =
                item.profile && item.profile.avatar != null
                    ? "cover"
                    : "20px 20px";
            $("#con_" + item.user_id)
                .children()
                .eq(0)
                .css("background-image", "url(" + url + ")");
            $("#con_" + item.user_id)
                .children()
                .eq(0)
                .css("background-size", sizeCss);
        });
        if (consultants.length > percentage) {
            // $('.consultants-view').slick({
            //   dots: true,
            //   infinite: false,
            //   mobileFirst: true,
            //   arrows: false,
            //   fade: false,
            //   speed: 300,
            //   slidesToShow: 1,
            //   cssEase: 'linear'
            // });
        }
    };

    const init = function() {
        slick(consultants);
        Object.values(countries).forEach(item => {
            if (item != null) {
                $(".country-sel").append(
                    `<option value="${item.toLowerCase()}">${item}</option>`
                );
            }
        });
        if (search.name != "null") {
            $(".search").val(search.name);
        }
        if (search.category != "All") {
            $(".category-sel").val(search.category);
        }
        if (search.price != "Default") {
            $(".price-sel").val(search.price);
        }
        if (search.status != "All") {
            $(".status-sel").val(search.status);
        }
        if (search.country != "All") {
            $(".country-sel").val(search.country);
        }
    };

    init();
};

const profile = function(user_info, review_info, chart_info, img_group) {
    var cover_image = user_info.profile ? user_info.profile.cover_img : "";
    var avatar_image = user_info.profile ? user_info.profile.avatar : "";
    var selected_timezone = "";
    init();
    function init() {
        if (cover_image) {
            $(".edit-cover-photo").attr(
                "style",
                `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${cover_image}')`
            );
            $(".imageupload").attr("style", "display: none;");
        }
        if (avatar_image) {
            $(".preview-profile-photo").attr(
                "style",
                `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${avatar_image}')`
            );
            $(".preview-profile-photo img").attr("style", "display: none;");
        }
        $(".profile-card.about").attr("style", "display: block;");
        $(".basic-form").validate({
            errorPlacement: function() {},
            errorClass: "label",
            highlight: function(element, errorClass, validClass) {
                $(element)
                    .parent()
                    .addClass("error");
                $(element)
                    .parent()
                    .removeClass("success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element)
                    .parent()
                    .removeClass("error");
                $(element)
                    .parent()
                    .addClass("success");
            }
        });
        $.ajax({
            url: "/api/get-universities",
            type: "GET",
            dataType: "JSON",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                data.array.forEach(item => {
                    $(".university-list").append(
                        `<option value="${item.name}">${item.name}</option>`
                    );
                });
                if (user_info.profile && user_info.profile.college) {
                    $(".university-list").val(user_info.profile.college);
                }
            }
        });
        $("#timezone").timezones();
        $("#phone").intlTelInput({
            allowDropdown: true,
            autoHideDialCode: false,
            autoPlaceholder: "polite",
            dropdownContainer: "body",
            preferredCountries: ["no", "se", "gb", "de", "us"],
            utilsScript: "/js/utils.js"
        });
        // completed session chart
        var columns = [];
        columns.push([
            "x",
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec"
        ]);
        var column_data = ["y"];
        var y_values = [];
        Object.keys(chart_info.completed_sessions).forEach((key, item) => {
            y_values.push(chart_info.completed_sessions[key]);
            column_data.push(chart_info.completed_sessions[key]);
        });
        columns.push(column_data);
        var maxValueInArray = Math.max.apply(Math, y_values);
        var chartWidth = $(".chart-body").width();
        var chart = c3.generate({
            bindto: "#completed-session-chart",
            size: {
                width: chartWidth
            },
            data: {
                x: "x",
                columns: columns,
                type: "bar",
                labels: true
            },
            color: {
                linearGradient: {
                    x1: 0,
                    x2: 0,
                    y1: 0,
                    y2: 1
                },
                stops: [
                    [0, "#8773ff"],
                    [1, "#67a5ff"]
                ]
            },
            bar: {
                width: { ratio: 0.8 },
                spacing: 2
            },
            axis: {
                x: {
                    type: "categories",
                    tick: {
                        format: "%b",
                        fit: true
                    }
                },
                y: {
                    min: 0,
                    max: maxValueInArray
                }
            },
            tooltip: {
                show: false
            },
            zoom: {
                enabled: false
            },
            onrendered: function() {
                let $graphic = $(".completed-session-chart svg g");
                $($graphic[0]).attr("style", "transform: translate(0, 0);");
                let $y_axis = $(".completed-session-chart .c3-axis-y");
                $($y_axis).attr("style", "display: none;");
                let $y2_axis = $(".completed-session-chart .c3-axis-y2");
                $($y2_axis).attr("style", "display: none;");
                let $legend_item_y = $(
                    ".completed-session-chart .c3-legend-item-y"
                );
                $($legend_item_y).attr("style", "display: none;");
                let $path = $(".completed-session-chart path.domain");
                $($path).attr("style", "display: none;");
                let $x_axis = $(".completed-session-chart .c3-axis-x");
                $($x_axis).attr("style", "transform: translate(0, 235px);");
                let $x_axis_span = $(
                    ".completed-session-chart .c3-axis-x g text tspan"
                );
                $($x_axis_span).attr(
                    "style",
                    "font-family: 'Poppins Regular';"
                );

                let $c3_shapes = $(".completed-session-chart .c3-shape");
                $.each($c3_shapes, (i, el) => {
                    var bar_radius =
                        y_values[i] > parseInt(maxValueInArray / 2)
                            ? 10
                            : y_values[i] > parseInt(maxValueInArray / 3)
                            ? 5
                            : 0;
                    var point_1X = parseFloat(
                        $(el)
                            .attr("d")
                            .split(" ")[2]
                            .replace("L", "")
                            .split(",")[0]
                    );
                    var point_1y = parseFloat(
                        $(el)
                            .attr("d")
                            .split(" ")[2]
                            .replace("L", "")
                            .split(",")[1]
                    );
                    var point_2X = parseFloat(
                        $(el)
                            .attr("d")
                            .split(" ")[3]
                            .replace("L", "")
                            .split(",")[0]
                    );
                    var point_2y = parseFloat(
                        $(el)
                            .attr("d")
                            .split(" ")[3]
                            .replace("L", "")
                            .split(",")[1]
                    );

                    var path =
                        "M " +
                        $(el)
                            .attr("d")
                            .split(" ")[1] +
                        " " +
                        "L" +
                        point_1X +
                        "," +
                        (point_1y + bar_radius) +
                        " " +
                        "Q" +
                        point_1X +
                        "," +
                        point_1y +
                        " " +
                        (point_1X + bar_radius) +
                        "," +
                        point_1y +
                        " " +
                        "L" +
                        (point_2X - bar_radius) +
                        "," +
                        point_2y +
                        " " +
                        "Q" +
                        point_2X +
                        "," +
                        point_2y +
                        " " +
                        point_2X +
                        "," +
                        (point_2y + bar_radius) +
                        " " +
                        $(el)
                            .attr("d")
                            .split(" ")[4] +
                        " " +
                        "z";

                    $(el).attr("d", path);
                    $(el).attr(
                        "style",
                        "fill: #e2e2e2; stroke: #e2e2e2; stroke-width: 1px;"
                    );
                });

                var d = new Date(),
                    n = d.getMonth();
                let $current_month_shape = $(
                    `.completed-session-chart .c3-shape-${n}`
                );
                $($current_month_shape).attr(
                    "style",
                    "fill: url(#MyGradient); stroke: url(#MyGradient); stroke-width: 1px;"
                );
            }
        });

        // resposne rate chart for consultant
        if (user.role == "consultant") {
            var response_columns = [];
            response_columns.push([
                "x",
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec"
            ]);
            var response_column_data = ["y"];
            var response_y_values = [];
            Object.keys(chart_info.response_rates).forEach((key, item) => {
                response_y_values.push(chart_info.response_rates[key]);
                response_column_data.push(chart_info.response_rates[key]);
            });
            response_columns.push(response_column_data);
            var response_maxValueInArray = Math.max.apply(
                Math,
                response_y_values
            );
            var chart = c3.generate({
                bindto: "#response-rate-chart",
                size: {
                    width: chartWidth
                },
                data: {
                    x: "x",
                    columns: response_columns,
                    type: "bar",
                    labels: true
                },
                color: {
                    linearGradient: {
                        x1: 0,
                        x2: 0,
                        y1: 0,
                        y2: 1
                    },
                    stops: [
                        [0, "#8773ff"],
                        [1, "#67a5ff"]
                    ]
                },
                bar: {
                    width: { ratio: 0.8 }
                },
                axis: {
                    x: {
                        type: "categories",
                        tick: {
                            format: "%b",
                            fit: true
                        }
                    },
                    y: {
                        min: 0,
                        max: response_maxValueInArray
                    }
                },
                tooltip: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                onrendered: function() {
                    let $graphic = $(".response-rate-chart svg g");
                    $($graphic[0]).attr("style", "transform: translate(0, 0);");
                    let $y_axis = $(".response-rate-chart .c3-axis-y");
                    $($y_axis).attr("style", "display: none;");
                    let $y2_axis = $(".response-rate-chart .c3-axis-y2");
                    $($y2_axis).attr("style", "display: none;");
                    let $legend_item_y = $(
                        ".response-rate-chart .c3-legend-item-y"
                    );
                    $($legend_item_y).attr("style", "display: none;");
                    let $path = $(".response-rate-chart path.domain");
                    $($path).attr("style", "display: none;");
                    let $x_axis = $(".response-rate-chart .c3-axis-x");
                    $($x_axis).attr("style", "transform: translate(0, 235px);");
                    let $x_axis_span = $(
                        ".completed-session-chart .c3-axis-x g text tspan"
                    );
                    $($x_axis_span).attr(
                        "style",
                        "font-family: 'Poppins Regular';"
                    );
                    let $text_elements = $(".response-rate-chart text.c3-text");
                    $.each($text_elements, (i, el) => {
                        $(el).text($(el).html() + "%");
                    });

                    let $c3_shapes = $(".response-rate-chart .c3-shape");
                    $.each($c3_shapes, (i, el) => {
                        var bar_radius =
                            response_y_values[i] >
                            parseInt(response_maxValueInArray / 2)
                                ? 10
                                : response_y_values[i] >
                                  parseInt(response_maxValueInArray / 3)
                                ? 5
                                : 0;

                        var point_1X = parseFloat(
                            $(el)
                                .attr("d")
                                .split(" ")[2]
                                .replace("L", "")
                                .split(",")[0]
                        );
                        var point_1y = parseFloat(
                            $(el)
                                .attr("d")
                                .split(" ")[2]
                                .replace("L", "")
                                .split(",")[1]
                        );
                        var point_2X = parseFloat(
                            $(el)
                                .attr("d")
                                .split(" ")[3]
                                .replace("L", "")
                                .split(",")[0]
                        );
                        var point_2y = parseFloat(
                            $(el)
                                .attr("d")
                                .split(" ")[3]
                                .replace("L", "")
                                .split(",")[1]
                        );

                        var path =
                            "M " +
                            $(el)
                                .attr("d")
                                .split(" ")[1] +
                            " " +
                            "L" +
                            point_1X +
                            "," +
                            (point_1y + bar_radius) +
                            " " +
                            "Q" +
                            point_1X +
                            "," +
                            point_1y +
                            " " +
                            (point_1X + bar_radius) +
                            "," +
                            point_1y +
                            " " +
                            "L" +
                            (point_2X - bar_radius) +
                            "," +
                            point_2y +
                            " " +
                            "Q" +
                            point_2X +
                            "," +
                            point_2y +
                            " " +
                            point_2X +
                            "," +
                            (point_2y + bar_radius) +
                            " " +
                            $(el)
                                .attr("d")
                                .split(" ")[4] +
                            " " +
                            "z";

                        $(el).attr("d", path);
                        $(el).attr(
                            "style",
                            "fill: #e2e2e2; stroke: #e2e2e2; stroke-width: 1px;"
                        );
                    });

                    var d = new Date(),
                        n = d.getMonth();
                    let $current_month_shape = $(
                        `.response-rate-chart .c3-shape-${n}`
                    );
                    $($current_month_shape).attr(
                        "style",
                        "fill: url(#MyGradient); stroke: url(#MyGradient); stroke-width: 1px;"
                    );
                }
            });
        }
        if (review_info) {
            $(".review")
                .slice(0, 5)
                .show();
            if ($(".blogBox:hidden").length != 0) {
                $("#loadMore").show();
            }
        }
    }
    $("#loadMore").on("click", function(e) {
        e.preventDefault();
        $(".review:hidden")
            .slice(0, review_info.length)
            .slideDown();
        if ($(".review:hidden").length == 0) {
            $("#loadMore").fadeOut("slow");
        }
    });
    $(".btn-edit-profile").on("click", function() {
        $("#edit-profile-modal").modal("show");
    });
    $("#edit-profile-modal").on("show.bs.modal", function() {
        $("#description").summernote({
            height: 200,
            dialogsInBody: true,
            focus: true,
            codemirror: {
                htmlMode: true,
                mode: "text/html"
            }
        });
        if (user_info.profile && user_info.profile.timezone) {
            $("#timezone").val(user_info.profile.timezone);
        }
        if (user_info.profile && user_info.profile.description) {
            $("#description").summernote("code", user_info.profile.description);
        }
    });
    $("#edit-profile-modal").on("hidden.bs.modal", function() {
        $("#description").summernote("destroy");
    });
    // upload profile image
    $("#upload_cover").on("change", function() {
        var formdata = new FormData();
        if (cover_image) {
            formdata.append("file", this.files[0]);
            formdata.append("remove_url", cover_image);
        } else {
            formdata.append("file", this.files[0]);
        }
        $.ajax({
            type: "post",
            dataType: "json",
            url: "/api/member_image_upload",
            data: formdata,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(e) {
                cover_image = e.url;
                $(".edit-cover-photo").attr(
                    "style",
                    `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${e.url}')`
                );
                $(".cover-file").attr("style", "display: none;");
            }
        });
    });
    $(".delete-file").on("click", function() {
        $.ajax({
            type: "post",
            dataType: "json",
            url: "/api/member_image_delete",
            data: { profileId: user_info.profile.id, type: "cover" },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(e) {
                cover_image = null;
                $(".edit-cover-photo").attr(
                    "style",
                    `background-position: center; background-repeat: no-repeat; background-size: 50px 50px; background-image:url('${e.src}')`
                );
                $(".cover-file").attr("style", "display: none;");
            }
        });
    });
    $("#delete_profile_avatar").on("click", function() {
        $.ajax({
            type: "post",
            dataType: "json",
            url: "/api/member_image_delete",
            data: { profileId: user_info.profile.id, type: "avatar" },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(e) {
                avatar_image = null;
                $(".preview-profile-photo").attr(
                    "style",
                    `background-position: center; background-repeat: no-repeat; background-size: 50px 50px; background-image:url('${e.src}')`
                );
                $(".preview-profile-photo img").attr("style", "display: none;");
            }
        });
    });
    // check if cover photo div has background image or not
    $(".edit-cover-photo").on("mouseover", function() {
        if ($(this).css("background-image") != "none") {
            $(".imageupload").attr("style", "display: block;");
        }
    });
    $(".edit-cover-photo").on("mouseleave", function() {
        if ($(this).css("background-image") != "none") {
            $(".imageupload").attr("style", "display: none;");
        }
    });
    // upload profile photos
    $("#upload_profile").on("change", function() {
        var formdata = new FormData();
        if (avatar_image) {
            formdata.append("file", this.files[0]);
            formdata.append("remove_url", avatar_image);
        } else {
            formdata.append("file", this.files[0]);
        }
        $.ajax({
            type: "post",
            dataType: "json",
            url: "/api/member_image_upload",
            data: formdata,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(e) {
                avatar_image = e.url;
                $(".preview-profile-photo").attr(
                    "style",
                    `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${e.url}')`
                );
                $(".preview-profile-photo img").attr("style", "display: none;");
            }
        });
    });
    $("#timezone").on("change", function(e) {
        selected_timezone = $(this)
            .find(":selected")
            .data("offset");
    });
    // personal info updating
    $("#profile_save").on("click", function(e) {
        e.preventDefault();
        if ($(".basic-form").valid()) {
            var info = {
                user_id: user_info.user.id,
                cover_image: cover_image,
                avatar: avatar_image,
                first_name: $("#first_name").val(),
                last_name: $("#last_name").val(),
                phone: $("#phone").intlTelInput("getNumber"),
                email: $("#email").val(),
                profession:
                    user_info.user.role == "consultant"
                        ? $(".profession").val()
                        : "",
                from: $("#from").val(),
                country: $("#country").val(),
                region: $("#region").val(),
                college:
                    user_info.user.role == "consultant"
                        ? $(".university-list").val()
                        : "",
                timezone: $("#timezone").val(),
                gmt: `(GMT ${selected_timezone})`,
                description: $("#description").summernote("code")
            };
            $.ajax({
                url: "/api/update_member_profile",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                type: "POST",
                data: info,
                dataType: "JSON",
                success: function(data) {
                    $("#edit-profile-modal").modal("hide");
                    location.reload();
                }
            });
        }
    });
    $(".tab.about").on("click", function(e) {
        e.preventDefault();
        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
            $(".tab.about img").attr("src", img_group["profile-icon-w"]);
            $(".profile-card.about").attr("style", "display: block;");
        }
        $(".tab.sessions").removeClass("active");
        $(".tab.sessions img").attr("src", img_group["comment"]);
        $(".profile-card.sessions").attr("style", "display: none;");
        $(".tab.reviews").removeClass("active");
        $(".tab.reviews img").attr("src", img_group["star"]);
        $(".profile-card.reviews").attr("style", "display: none;");
    });
    $(".tab.sessions").on("click", function(e) {
        e.preventDefault();
        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
            $(".tab.sessions img").attr("src", img_group["comment-w"]);
            $(".profile-card.sessions").attr("style", "display: block;");
        }
        $(".tab.about").removeClass("active");
        $(".tab.about img").attr("src", img_group["profile-icon"]);
        $(".profile-card.about").attr("style", "display: none;");
        $(".tab.reviews").removeClass("active");
        $(".tab.reviews img").attr("src", img_group["star"]);
        $(".profile-card.reviews").attr("style", "display: none;");
    });
    $(".tab.reviews").on("click", function(e) {
        e.preventDefault();
        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
            $(".tab.reviews img").attr("src", img_group["star-w"]);
            $(".profile-card.reviews").attr("style", "display: block;");
        }
        $(".tab.about").removeClass("active");
        $(".tab.about img").attr("src", img_group["profile-icon"]);
        $(".profile-card.about").attr("style", "display: none;");
        $(".tab.sessions").removeClass("active");
        $(".tab.sessions img").attr("src", img_group["comment"]);
        $(".profile-card.sessions").attr("style", "display: none;");
    });
};

const setting = function(user_info) {
    init();
    // contact setting
    $("#profile_save").on("click", function() {
        var contact = {
            phone_contact:
                $("#phone_checkbox:checkbox:checked").length > 0 ? 1 : 0,
            chat_contact:
                $("#chat_checkbox:checkbox:checked").length > 0 ? 1 : 0,
            video_contact:
                $("#video_checkbox:checkbox:checked").length > 0 ? 1 : 0,
            currency: $("#selected-currency").val(),
            rate: $("#rate").val(),
            role: user_info.user.role,
            user_id: user_info.user.id,
            type: "contact"
        };
        $.ajax({
            url: "/api/update_member_setting",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            data: contact,
            dataType: "JSON",
            success: function(data) {
                alert("Updated successfully");
            }
        });
    });
    // profile settings
    $("#education_save").on("click", function() {
        $.ajax({
            url: "/api/update_member_setting",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            data: {
                college: $("selected-education").val(),
                user_id: user_info.user.id,
                type: "education"
            },
            dataType: "JSON",
            success: function(data) {
                alert("Updated successfully");
            }
        });
    });
    // company settings
    $("#company_save").on("click", function(e) {
        e.preventDefault();
        var company_info = {
            company_name: $("#company_name").val(),
            organization_number: $("#organization_number").val(),
            bank_account: $("#bank_account").val(),
            first_name: $("#first_name").val(),
            last_name: $("#last_name").val(),
            address: $("#address").val(),
            zip_code: $("#zip_code").val(),
            zip_place: $("#zip_place").val(),
            country: $("#country").val(),
            role: user_info.user.role,
            user_id: user_info.user.id,
            type: "company"
        };
        $.ajax({
            url: "/api/update_member_setting",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            data: company_info,
            dataType: "JSON",
            success: function(data) {
                alert("Updated successfully");
            }
        });
    });
    //password updating
    $("#password_save").on("click", function() {
        var password_info = {
            old_password: $("#old_password").val(),
            new_password: $("#new_password").val(),
            user_id: user_info.user.id,
            type: "password"
        };

        $.ajax({
            url: "/api/update_member_setting",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            data: password_info,
            dataType: "JSON",
            success: function(data) {
                status = JSON.stringify(data["status"]);
                if (status == 1) {
                    $("#old_password_error").attr("style", "display: block;");
                    $("#old_password_error").text(
                        "Enter the previous password correctly"
                    );
                } else {
                    alert("Updated successfully");
                }
            }
        });
    });
    function init() {
        if (user_info.currency) {
            $("#selected-currency").val(user_info.currency);
        }
    }
};

const transaction = function(search, transactions, agent) {
    var query = {};
    $(".search").on("change", function(e) {
        query.number = e.target.value;
    });
    $(".consultant").on("change", function(e) {
        query.consultant = e.target.value;
    });
    $("#desktop_date").on("change", function(e) {
        query.date = e.target.value;
    });
    $("#mobile_date").on("change", function(e) {
        query.date = e.target.value;
    });
    $("#earn_type").on("change", function(e) {
        query.type = e.target.value;
    });
    $("#desktop_filter").on("click", function() {
        var date = query.date
            ? query.date
            : search.date != "null"
            ? search.date
            : "null";
        var consultant = query.consultant
            ? query.consultant
            : search.consultant != "null"
            ? search.consultant
            : "null";
        var type = query.type
            ? query.type
            : search.type != "null"
            ? search.type
            : "null";
        const url =
            lang == "en"
                ? "/transaction-search?consultant="
                : "/no/transaksjoner-sok?consultant=";
        setTimeout(function() {
            window.location =
                url + consultant + "&date=" + date + "&type=" + type;
        }, 50);
    });
    $("#mobile_filter").on("click", function() {
        var number = query.number
            ? query.number
            : search.number != "null"
            ? search.number
            : "null";
        var date = query.date
            ? query.date
            : search.date != "null"
            ? search.date
            : "null";
        var consultant = query.consultant
            ? query.consultant
            : search.consultant != "null"
            ? search.consultant
            : "null";
        var type = query.type
            ? query.type
            : search.type != "null"
            ? search.type
            : "null";
        const url =
            lang == "en"
                ? "/transaction-search?name="
                : "/no/transaksjon-sok?name=";
        setTimeout(function() {
            window.location =
                url +
                number +
                "&consultant=" +
                consultant +
                "&date=" +
                date +
                "&type=" +
                type;
        }, 50);
    });
    $("#show_filter").on("click", function() {
        if ($(".filter-body").hasClass("active")) {
            $(this).addClass("reversed");
            $(".filter-body").removeClass("active");
        } else {
            $(this).removeClass("reversed");
            $(".filter-body").addClass("active");
        }
    });
    var init = function() {
        $("#transactions").DataTable({
            rowReorder: true,
            responsive: true,
            searching: true,
            info: false,
            aaSorting: [],
            initComplete: function(settings, json) {
                $(this).removeClass("no-footer");
                agent === "mobile" &&
                    $(".dataTables_filter").attr("style", "display: none;");
            },
            language: {
                search: "_INPUT_",
                searchPlaceholder: `${lang === "en" ? "Search" : "Søk"}`
            }
        });
        transactions.length > 0 &&
            $(".transaction table tbody tr").each(function(key) {
                $(this)
                    .find("td")
                    .addClass("table-item");
                $(this)
                    .find("td")
                    .eq(0)
                    .addClass("table-item avatar");
                const url =
                    transactions[key].hasOwnProperty("consultant") &&
                    transactions[key].consultant.profile &&
                    transactions[key].consultant.profile.avatar != null
                        ? transactions[key].consultant.profile.avatar
                        : transactions[key].customer &&
                          transactions[key].customer.profile &&
                          transactions[key].customer.profile.avatar != null
                        ? transactions[key].customer.profile.avatar
                        : "images/white-logo.svg";
                const sizeCss =
                    transactions[key].hasOwnProperty("consultant") &&
                    transactions[key].consultant.profile &&
                    transactions[key].consultant.profile.avatar != null
                        ? "cover"
                        : transactions[key].customer &&
                          transactions[key].customer.profile &&
                          transactions[key].customer.profile.avatar != null
                        ? "cover"
                        : "20px 20px";
                $(this)
                    .find("td")
                    .eq(0)
                    .children()
                    .children(".avatar")
                    .css("background-image", "url(" + url + ")");
                $(this)
                    .find("td")
                    .eq(0)
                    .children()
                    .children(".avatar")
                    .css("background-size", sizeCss);
            });
        if ($("#transaction tbody").children().length == 0) {
            $("#transaction tbody").addClass("no-data");
            const no_transaction_title =
                lang == "en"
                    ? "No transactions yet."
                    : "Ingen transaksjoner ennå.";
            const no_transaction_des =
                lang == "en"
                    ? "Your transactions will show here once you have completed a session with a customer or consultant."
                    : "Transaksjonene dine vises her når du har fullført en økt med en kunde eller konsulent.";
            const html =
                "<div class='select-box'><div class='step'><img src='/images/mascot.svg' alt='no-image'/><label>" +
                no_transaction_title +
                "</label><p class='text'>" +
                no_transaction_des +
                "</p></div></div>";
            $("#transaction tbody").append(html);
        }
        $("#desktop_date").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            format: "mm/dd/yyyy",
            changeMonth: true,
            changeYear: true
        });
        $("#mobile_date").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            format: "mm/dd/yyyy",
            changeMonth: true,
            changeYear: true
        });
    };
    init();
}; // const transaction = function (search, transactions, agent) {

const payout = function(search, payouts, agent) {
    var query = {};
    $(".search").on("change", function(e) {
        query.number = e.target.value;
    });
    $(".status").on("change", function(e) {
        query.status = e.target.value;
    });
    $("#desktop_date").on("change", function(e) {
        query.date = e.target.value;
    });
    $("#mobile_date").on("change", function(e) {
        query.date = e.target.value;
    });
    $("#earn_type").on("change", function(e) {
        query.type = e.target.value;
    });
    $("#desktop_filter").on("click", function() {
        var date_from = $("#desktop_date_from").MonthPicker(
            "GetSelectedMonthYear"
        );
        var date_till = $("#desktop_date_till").MonthPicker(
            "GetSelectedMonthYear"
        );
        var status = $(".filter_status").val();

        const url =
            lang == "en"
                ? "/my-payouts-search?status="
                : "/no/transaksjoner-sok?status=";
        setTimeout(function() {
            window.location =
                url +
                status +
                "&date_from=" +
                date_from +
                "&date_till=" +
                date_till;
        }, 50);
    });
    $("#mobile_filter").on("click", function() {
        var date_from = $("#desktop_date_from").MonthPicker(
            "GetSelectedMonthYear"
        );
        var date_till = $("#desktop_date_till").MonthPicker(
            "GetSelectedMonthYear"
        );
        var status = query.status
            ? query.status
            : search.status != "null"
            ? search.status
            : "null";
        const url =
            lang == "en"
                ? "/my-payouts-search?status="
                : "/no/transaksjoner-sok?status=";
        setTimeout(function() {
            window.location =
                url +
                status +
                "&date_from=" +
                date_from +
                "&date_till=" +
                date_till;
        }, 50);
    });
    $("#show_filter").on("click", function() {
        if ($(".filter-body").hasClass("active")) {
            $(this).addClass("reversed");
            $(".filter-body").removeClass("active");
        } else {
            $(this).removeClass("reversed");
            $(".filter-body").addClass("active");
        }
    });
    var init = function() {
        $("#payouts").DataTable({
            rowReorder: true,
            responsive: true,
            searching: true,
            info: false,
            aaSorting: [],
            initComplete: function(settings, json) {
                $(this).removeClass("no-footer");
                agent === "mobile" &&
                    $(".dataTables_filter").attr("style", "display: none;");
            },
            language: {
                search: "_INPUT_",
                searchPlaceholder: `${lang === "en" ? "Search" : "Søk"}`
            }
        });
        payouts.length > 0 &&
            $(".payout table tbody tr").each(function(key) {
                $(this)
                    .find("td")
                    .addClass("table-item");
                $(this)
                    .find("td")
                    .eq(0)
                    .addClass("table-item avatar");
                // const url = payouts[key].hasOwnProperty('status') && payouts[key].status.profile && payouts[key].status.profile.avatar != null ? payouts[key].status.profile.avatar :
                // payouts[key].customer && payouts[key].customer.profile && payouts[key].customer.profile.avatar != null ? payouts[key].customer.profile.avatar : 'images/white-logo.svg';
                // const sizeCss = payouts[key].hasOwnProperty('status') && payouts[key].status.profile && payouts[key].status.profile.avatar != null ? 'cover' :
                // payouts[key].customer && payouts[key].customer.profile && payouts[key].customer.profile.avatar != null ? 'cover' : '20px 20px';
                // $(this).find('td').eq(0).children().children('.avatar').css('background-image', "url(" + url + ")");
                // $(this).find('td').eq(0).children().children('.avatar').css('background-size', sizeCss);
            });
        if ($("#payout tbody").children().length == 0) {
            $("#payout tbody").addClass("no-data");
            const no_payout_title =
                lang == "en" ? "No payouts yet." : "Ingen transaksjoner ennå.";
            const no_payout_des =
                lang == "en"
                    ? "Your payouts will show here once you have completed a session with a customer or consultant."
                    : "Transaksjonene dine vises her når du har fullført en økt med en kunde eller konsulent.";
            const html =
                "<div class='select-box'><div class='step'><img src='/images/mascot.svg' alt='no-image'/><label>" +
                no_payout_title +
                "</label><p class='text'>" +
                no_payout_des +
                "</p></div></div>";
            $("#payout tbody").append(html);
        }
        $("#desktop_date_from").MonthPicker({
            MonthFormat: "M, yy",
            SelectedMonth: search.date_from,
            ShowIcon: false
        });
        $("#desktop_date_till").MonthPicker({
            MonthFormat: "M, yy",
            SelectedMonth: search.date_till,
            ShowIcon: false
        });
    };
    init();
}; // const payout = function (search, payouts, agent) {

const wallet = function(
    amount,
    is_popup,
    currency,
    search,
    currency_key,
    stripe_key,
    booking
) {
    var selected_cost = currency == "NOK" ? 100 : 10;
    var payment_type = "stripe";
    var cardType = "new_card";
    var is_filter = false;
    var endpoint = "convert";
    var query = {};
    // stripe initial
    // Create a Stripe client.
    var stripe = Stripe(stripe_key, {
        locale: lang === "en" ? "en" : "nb"
    });
    // Create an instance of Elements.
    var elements = stripe.elements();
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
                color: "#aab7c4"
            }
        },
        invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
        }
    };
    // Create an instance of the card Element.
    var card = elements.create("card", {
        hidePostalCode: true,
        style
    });
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount("#card-element");
    // Handle real-time validation errors from the card Element.
    card.on("change", function(event) {
        var displayError = document.getElementById("card-errors");
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = "";
        }
    });
    // choose card
    $("#card1").on("click", function() {
        selected_cost = $("#card1 .cost").data("cost");
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html("Pay " + formatted_cost);
        $(".next-btn").html("Pay " + formatted_cost);

        if (!$("#card1").hasClass("active")) {
            $(".choose-group .choose-item .credit")
                .filter(function() {
                    return $(this).has(".cost").length > 0;
                })
                .each(function() {
                    if ($(this).attr("id") == "card1") {
                        $(this).addClass("active");
                    } else {
                        $(this).removeClass("active");
                    }
                });
        }
        // $.ajax({
        //   url: '/api/klarna_checkout',
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: 'POST',
        //   data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
        //   dataType: 'JSON',
        //   success: function (res) {
        //     $(".klarna-checkout").html(res.html_snippet);
        //   }
        // });
    });
    $("#card2").on("click", function() {
        selected_cost = $("#card2 .cost").data("cost");
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        // alert('formatted_cost formatted_cost::'+formatted_cost)
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html("Pay " + formatted_cost);
        $(".next-btn").html("Pay " + formatted_cost);

        if (!$("#card2").hasClass("active")) {
            $(".choose-group .choose-item .credit")
                .filter(function() {
                    return $(this).has(".cost").length > 0;
                })
                .each(function() {
                    if ($(this).attr("id") == "card2") {
                        $(this).addClass("active");
                    } else {
                        $(this).removeClass("active");
                    }
                });
        }
        // $.ajax({
        //   url: '/api/klarna_checkout',
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: 'POST',
        //   data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
        //   dataType: 'JSON',
        //   success: function (res) {
        //     $(".klarna-checkout").html(res.html_snippet);
        //   }
        // });
    });
    $("#card3").on("click", function() {
        selected_cost = $("#card3 .cost").data("cost");
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html("Pay " + formatted_cost);
        $(".next-btn").html("Pay " + formatted_cost);

        if (!$("#card3").hasClass("active")) {
            $(".choose-group .choose-item .credit")
                .filter(function() {
                    return $(this).has(".cost").length > 0;
                })
                .each(function() {
                    if ($(this).attr("id") == "card3") {
                        $(this).addClass("active");
                    } else {
                        $(this).removeClass("active");
                    }
                });
        }
        // $.ajax({
        //   url: '/api/klarna_checkout',
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: 'POST',
        //   data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
        //   dataType: 'JSON',
        //   success: function (res) {
        //     $(".klarna-checkout").html(res.html_snippet);
        //   }
        // });
    });
    $("#card4").on("click", function() {
        selected_cost = $("#card4 .cost").data("cost");
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html("Pay " + formatted_cost);
        $(".next-btn").html("Pay " + formatted_cost);

        if (!$("#card4").hasClass("active")) {
            $(".choose-group .choose-item .credit")
                .filter(function() {
                    return $(this).has(".cost").length > 0;
                })
                .each(function() {
                    if ($(this).attr("id") == "card4") {
                        $(this).addClass("active");
                    } else {
                        $(this).removeClass("active");
                    }
                });
        }
        // $.ajax({
        //   url: '/api/klarna_checkout',
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: 'POST',
        //   data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
        //   dataType: 'JSON',
        //   success: function (res) {
        //     $(".klarna-checkout").html(res.html_snippet);
        //   }
        // });
    });
    $("#card5").on("click", function() {
        selected_cost = $("#card5 .cost").data("cost");
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html("Pay " + formatted_cost);
        $(".next-btn").html("Pay " + formatted_cost);

        if (!$("#card5").hasClass("active")) {
            $(".choose-group .choose-item .credit")
                .filter(function() {
                    return $(this).has(".cost").length > 0;
                })
                .each(function() {
                    if ($(this).attr("id") == "card5") {
                        $(this).addClass("active");
                    } else {
                        $(this).removeClass("active");
                    }
                });
        }
        // $.ajax({
        //   url: '/api/klarna_checkout',
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: 'POST',
        //   data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
        //   dataType: 'JSON',
        //   success: function (res) {
        //     $(".klarna-checkout").html(res.html_snippet);
        //   }
        // });
    });
    $("#card6").on("click", function() {
        selected_cost = $("#card6 .cost").data("cost");
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html("Pay " + formatted_cost);
        $(".next-btn").html("Pay " + formatted_cost);

        if (!$("#card6").hasClass("active")) {
            $(".choose-group .choose-item .credit")
                .filter(function() {
                    return $(this).has(".cost").length > 0;
                })
                .each(function() {
                    if ($(this).attr("id") == "card6") {
                        $(this).addClass("active");
                    } else {
                        $(this).removeClass("active");
                    }
                });
        }
        // $.ajax({
        //   url: '/api/klarna_checkout',
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: 'POST',
        //   data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
        //   dataType: 'JSON',
        //   success: function (res) {
        //     $(".klarna-checkout").html(res.html_snippet);
        //   }
        // });
    });
    $("#card7").on("click", function() {
        selected_cost = $("#card7 .cost").data("cost");
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html("Pay " + formatted_cost);
        $(".next-btn").html("Pay " + formatted_cost);

        if (!$("#card7").hasClass("active")) {
            $(".choose-group .choose-item .credit")
                .filter(function() {
                    return $(this).has(".cost").length > 0;
                })
                .each(function() {
                    if ($(this).attr("id") == "card7") {
                        $(this).addClass("active");
                    } else {
                        $(this).removeClass("active");
                    }
                });
        }
        // $.ajax({
        //   url: '/api/klarna_checkout',
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: 'POST',
        //   data: { "price": selected_cost, "name": selected_cost + currency + 'CARD', 'currency': currency },
        //   dataType: 'JSON',
        //   success: function (res) {
        //     $(".klarna-checkout").html(res.html_snippet);
        //   }
        // });
    });
    $(".choose-item.custom").on("click", function() {
        $(".choose-item.custom .custom").addClass("display-none");
        $(".choose-item.custom .credit").removeClass("display-none");

        if (!$("#card8").hasClass("active")) {
            $(".choose-group .choose-item .credit")
                .filter(function() {
                    return $(this).has(".cost").length > 0;
                })
                .each(function() {
                    if ($(this).attr("id") == "card8") {
                        $(this).addClass("active");
                    } else {
                        $(this).removeClass("active");
                    }
                });
        }
    });
    $("#custom_card").on("change", function() {
        selected_cost = parseInt($(this).val());
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html("Pay " + formatted_cost);
        $(".next-btn").html("Pay " + formatted_cost);

        // $.ajax({
        //   url: '/api/klarna_checkout',
        //   headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //   },
        //   type: 'POST',
        //   data: { "price": selected_cost, "name": 'CUSTOMCARD' },
        //   dataType: 'JSON',
        //   success: function (res) {
        //     $(".klarna-checkout").html(res.html_snippet);
        //   }
        // });
    });
    // get klarna html html_snippet
    // $.ajax({
    //   url: '/api/klarna_checkout',
    //   headers: {
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //   },
    //   type: 'POST',
    //   data: { "price": currency == 'NOK' ? 100 : 10, "name": currency == 'NOK' ? '100NOKCARD' : '10' + currency + 'CARD', 'currency': currency },
    //   dataType: 'JSON',
    //   success: function (res) {
    //     $(".klarna-checkout").html(res.html_snippet);
    //   }
    // });

    // choose card type
    $("input[name='card_type']").on("click", function() {
        payment_type = $(this).val();
        if ($(this).val() == "stripe") {
            $(".pay-cust-credit.stripe").removeClass("display-none");
            $(".pay-cust-credit.paypal").addClass("display-none");
            $(".credit-box").removeClass("display-none");
            // $(".pay-cust-klarna").addClass("display-none");
        } else {
            $(".pay-cust-credit").addClass("display-none");
            $(".credit-box").addClass("display-none");
            // $(".pay-cust-klarna").removeClass("display-none");
        }
    });
    $(".filter-box.desktop").on("click", function() {
        is_filter = !is_filter;
        if (is_filter) {
            $(".filter-tag.desktop").attr("style", "display: flex;");
        } else {
            $(".filter-tag.desktop").attr("style", "display:none;");
        }
    });
    $(".filter-box.mobile").on("click", function() {
        is_filter = !is_filter;
        if (is_filter) {
            $(".filter-tag.mobile").attr("style", "display: flex;");
        } else {
            $(".filter-tag.mobile").attr("style", "display:none;");
        }
    });
    // search functionality
    $("#start_date").on("change", function(e) {
        query.start = e.target.value;
    });
    $("#end_date").on("change", function(e) {
        query.end = e.target.value;
    });
    $("#transaction_type").on("change", function(e) {
        query.type = e.target.value;
    });
    $("#go-search").on("click", function() {
        var start = query.start
            ? query.start
            : search.start != "null"
            ? search.start
            : "null";
        var end = query.end
            ? query.end
            : search.end != "null"
            ? search.end
            : "null";
        var type = query.type
            ? query.type
            : search.type != "null"
            ? search.type
            : "null";
        if (lang == "en") {
            var url = "/wallet-search?start=";
        } else {
            var url = "/no/lommebok-sok?start=";
        }
        setTimeout(function() {
            window.location = url + start + "&type=" + type + "&end=" + end;
        }, 50);
    });
    $(".payment-source").on("change", function(e) {
        cardType = e.target.value;
    });
    $(".pay-btn").on("click", async function() {
        if (payment_type == "stripe") {
            var pay_info = {};
            if (cardType != "new_card") {
                pay_info = {
                    currency: currency,
                    amount: selected_cost,
                    checked: null,
                    token: null,
                    card: null,
                    user_id: user.id,
                    type: "saved"
                };
            } else {
                const result = await stripe.createToken(card);
                if (result.error) {
                    var errorElement = document.getElementById("card-errors");
                    errorElement.textContent = result.error.message;
                } else {
                    pay_info = {
                        currency: currency,
                        amount: selected_cost,
                        checked:
                            $("#save-card-stripe").prop("checked") == true
                                ? true
                                : false,
                        token: result.token.id,
                        card: result.token.card,
                        user_id: user.id,
                        type: "new"
                    };
                }
            }
            $.ajax({
                url: "/api/stripe_charge",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                type: "POST",
                dataType: "JSON",
                data: pay_info,
                success: function(res) {
                    var calculated_charged_amount = 0;
                    if (res.status == "success") {
                        if (
                            res.transaction.currency == "usd" ||
                            res.transaction.currency == "eur"
                        ) {
                            const from = res.transaction.currency;
                            const to = "NOK";
                            $.ajax({
                                url:
                                    "https://api.currencylayer.com/" +
                                    endpoint +
                                    "?access_key=" +
                                    currency_key +
                                    "&from=" +
                                    from +
                                    "&to=" +
                                    to +
                                    "&amount=" +
                                    res.transaction.amount / 100,
                                dataType: "jsonp",
                                success: function(json) {
                                    formatted_cost = new Intl.NumberFormat(
                                        "no-NO",
                                        { style: "currency", currency: "NOK" }
                                    )
                                        .format(json.result)
                                        .replace("kr", "NOK");
                                    $.ajax({
                                        url: "/api/charge_balance",
                                        headers: {
                                            "X-CSRF-TOKEN": $(
                                                'meta[name="csrf-token"]'
                                            ).attr("content")
                                        },
                                        type: "POST",
                                        dataType: "JSON",
                                        data: {
                                            balance: json.result,
                                            user_id: user.id
                                        },
                                        success: function(res) {
                                            formatted_balance = new Intl.NumberFormat(
                                                "no-NO",
                                                {
                                                    style: "currency",
                                                    currency: "NOK"
                                                }
                                            )
                                                .format(res.balance)
                                                .replace("kr", "NOK");
                                            $("#my_balance").html(
                                                formatted_balance
                                            );
                                            $("#my_balance2").html(
                                                formatted_balance
                                            );
                                            if (lang === "en") {
                                                $("#pay-modal-amount").html(
                                                    "<b>" +
                                                        formatted_cost +
                                                        "</b>" +
                                                        " have been added to your balance."
                                                );
                                            } else {
                                                $("#pay-modal-amount").html(
                                                    "<b>" +
                                                        formatted_cost +
                                                        "</b>" +
                                                        " har blitt lagt til i saldoen din."
                                                );
                                            }
                                            $("#payment-confirmation").modal(
                                                "show"
                                            );
                                        }
                                    });
                                }
                            });
                        } else {
                            calculated_charged_amount =
                                res.transaction.amount / 100;
                            formatted_cost = new Intl.NumberFormat("no-NO", {
                                style: "currency",
                                currency: "NOK"
                            })
                                .format(calculated_charged_amount)
                                .replace("kr", "NOK");
                            $.ajax({
                                url: "/api/charge_balance",
                                headers: {
                                    "X-CSRF-TOKEN": $(
                                        'meta[name="csrf-token"]'
                                    ).attr("content")
                                },
                                type: "POST",
                                dataType: "JSON",
                                data: {
                                    balance: calculated_charged_amount,
                                    user_id: user.id
                                },
                                success: function(res) {
                                    formatted_balance = new Intl.NumberFormat(
                                        "no-NO",
                                        { style: "currency", currency: "NOK" }
                                    )
                                        .format(res.balance)
                                        .replace("kr", "NOK");
                                    $("#my_balance").html(formatted_balance);
                                    $("#my_balance2").html(formatted_balance);
                                    if (lang === "en") {
                                        $("#pay-modal-amount").html(
                                            "<b>" +
                                                formatted_cost +
                                                "</b>" +
                                                " have been added to your balance."
                                        );
                                    } else {
                                        $("#pay-modal-amount").html(
                                            "<b>" +
                                                formatted_cost +
                                                "</b>" +
                                                " har blitt lagt til i saldoen din."
                                        );
                                    }
                                    $("#payment-confirmation").modal("show");
                                }
                            });
                        }
                    } else {
                        var displayError = document.getElementById(
                            "card-errors"
                        );
                        displayError.textContent = res.err_msg;
                    }
                }
            });
        }
    });
    var payFromWallet = async function(wallet, my_balance) {
        if (currency == 'EUR') {
            amount = amount * 1.5;
        }
        if (currency == 'USD') {
            amount = amount * 1.2;
        }

        var pay_info = {
            id: user.id,
            cost: amount,
            time: 0,
            consultant_id: booking.consultant_id
        }
        $.ajax({
            url: "/api/manage_transaction",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            dataType: "JSON",
            data: pay_info,
            success: function(res) {
                $.ajax({
                    url: "/api/update_booking_status",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        id: booking.id
                    },
                    success: function (res) {
                        if (wallet == 'balance') {
                            var formatted_balance = new Intl.NumberFormat(
                                "no-NO",
                                { style: "currency", currency: "NOK" }
                            )
                                .format(my_balance - amount)
                                .replace("kr", "NOK");
                            $("#my_balance").html(
                                formatted_balance
                            );
                            $("#my_balance2").html(
                                formatted_balance
                            );
                        }
                        
                        if (lang === "en") {
                            $("#pay-modal-amount").html(
                                "NOK <b>" +
                                    amount.toFixed(2) +
                                    "</b>" +
                                    ` have been paid from your ${wallet}.`
                            );
                        } else {
                            $("#pay-modal-amount").html(
                                "NOK <b>" +
                                    amount.toFixed(2) +
                                    "</b>" +
                                    ` har blitt betalt fra saldoen ${wallet}.`
                            );
                        }
                        $("#payment-modal-title").html("Booking completed!")
                        $("#payment-confirmation").modal(
                            "show"
                        );
                    }
                })
            }
        });
    }
    $("#pay-with-balance-btn").on("click", async function() {
        var my_balance = this.getAttribute("my-balance");
        payFromWallet('balance', my_balance);
    });
    $("#pay-with-stripe-btn").on("click", async function() {
        if( currency == 'EUR') {
            amount = amount * 1.5;
        }
        if( currency == 'USD') {
            amount = amount * 1.2;
        }
        var pay_info = {};
        if (cardType != "new_card") {
            pay_info = {
                currency: "NOK",
                amount: amount,
                checked: null,
                token: null,
                card: null,
                user_id: user.id,
                type: "saved"
            };
        } else {
            const result = await stripe.createToken(card);
            if (result.error) {
                var errorElement = document.getElementById("card-errors");
                errorElement.textContent = result.error.message;
            } else {
                pay_info = {
                    currency: 'NOK',
                    amount: amount,
                    checked:
                        $("#save-card-stripe").prop("checked") == true
                            ? true
                            : false,
                    token: result.token.id,
                    card: result.token.card,
                    user_id: user.id,
                    type: "new"
                };
            }
        }
        $.ajax({
            url: "/api/stripe_charge",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            type: "POST",
            dataType: "JSON",
            data: pay_info,
            success: function(res) {
                var calculated_charged_amount = 0;
                if (res.status == "success") {
                    calculated_charged_amount =
                        res.transaction.amount / 100;
                    formatted_cost = new Intl.NumberFormat("no-NO", {
                        style: "currency",
                        currency: "NOK"
                    })
                        .format(calculated_charged_amount)
                        .replace("kr", "NOK");
                    $.ajax({
                        url: "/api/charge_balance",
                        headers: {
                            "X-CSRF-TOKEN": $(
                                'meta[name="csrf-token"]'
                            ).attr("content")
                        },
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            balance: calculated_charged_amount,
                            user_id: user.id
                        },
                        success: function(res) {
                            payFromWallet('stripe', 0);
                        }
                    });
                } else {
                    var displayError = document.getElementById(
                        "card-errors"
                    );
                    displayError.textContent = res.err_msg;
                }
            }
        });
    });
    $("#mobile_start_date").on("change", function(e) {
        query.start = e.target.value;
    });
    $("#mobile_end_date").on("change", function(e) {
        query.end = e.target.value;
    });
    $("#mobile_transaction_type").on("change", function(e) {
        query.type = e.target.value != "All" ? e.target.value : "null";
    });
    $("#mobile-go-search").on("click", function() {
        var start = query.start
            ? query.start
            : search.start != "null"
            ? search.start
            : "null";
        var end = query.end
            ? query.end
            : search.end != "null"
            ? search.end
            : "null";
        var type = query.type
            ? query.type
            : search.type != "null"
            ? search.type
            : "null";
        if (lang == "en") {
            var url = "/wallet-search?start=";
        } else {
            var url = "/no/lommebok-sok?start=";
        }
        setTimeout(function() {
            window.location = url + start + "&type=" + type + "&end=" + end;
        }, 50);
    });
    $(".add-credit-btn").on("click", function() {
        $(".prepaid-card-left").attr("style", "display: block;");
        $(".mobile-wallet-payment").attr("style", "display: block;");
        $(".content-wrapper.member-content").attr("style", "min-height:850px;");
        $(".mobile-step2").attr("style", "display: none;");
        $(".mobile-wallet-transaction").attr("style", "display: none;");
    });
    var slick = function(transactions) {
        let append_html = "";
        transactions.forEach((item, key) => {
            const date = item.created_at.split(" ")[0];
            const time = item.created_at.split(" ")[1];
            const img =
                item.type == "Klarna"
                    ? "images/klarna-transaction.png"
                    : "images/visa-transaction.png";
            const title =
                lang == "en"
                    ? item.type == "Visa"
                        ? "Visa"
                        : "Visum"
                    : "Klarna";
            let html_item =
                "<div class='table-item'><div class='pay-img'><img src='" +
                img +
                "' alt='transaction img'></div>";
            html_item +=
                "<div class='card-info'><p class='title'>" +
                title +
                "</p><p>" +
                date +
                ", " +
                time +
                "</p></div>";
            html_item +=
                "<div class='pay-result'><p class='amount'>" +
                item.currency +
                " " +
                item.amount +
                "</p><p class='status'>" +
                item.status +
                "</p></div></div>";
            if (key == 0) {
                append_html += "<div class='item-group'>";
                append_html += html_item;
            } else if (key % 5 == 0) {
                append_html += "</div><div class='item-group'>";
                append_html += html_item;
            } else {
                append_html += html_item;
            }
            if (key == transactions.length - 1) {
                append_html += "</div>";
            }
        });
        $(".mobile-transaction-table").append(append_html);
        // $('.mobile-transaction-table').slick({
        //   dots: true,
        //   infinite: true,
        //   mobileFirst: true,
        //   arrows: false,
        //   fade: false,
        //   speed: 300,
        //   slidesToShow: 1,
        //   cssEase: 'linear'
        // });
    };
    $(".next-btn").on("click", async function() {
        var btn_self = $(this);
        $(this).buttonLoader("start");
        if (payment_type == "stripe") {
            if (cardType != "new_card") {
                pay_info = {
                    currency: currency,
                    amount: selected_cost,
                    checked: null,
                    token: null,
                    card: null,
                    user_id: user.id,
                    type: "saved"
                };
            } else {
                const result = await stripe.createToken(card);
                if (result.error) {
                    var errorElement = document.getElementById("card-errors");
                    errorElement.textContent = result.error.message;
                } else {
                    pay_info = {
                        currency: currency,
                        amount: selected_cost,
                        checked:
                            $("#save-card-stripe").prop("checked") == true
                                ? true
                                : false,
                        token: result.token.id,
                        card: result.token.card,
                        user_id: user.id,
                        type: "new"
                    };
                }
            }
            $.ajax({
                url: "/api/stripe_charge",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                type: "POST",
                dataType: "JSON",
                data: pay_info,
                success: function(res) {
                    var calculated_charged_amount = 0;
                    if (res.status == "success") {
                        if (
                            res.transaction.currency == "usd" ||
                            res.transaction.currency == "eur"
                        ) {
                            const from = res.transaction.currency;
                            const to = "NOK";
                            $.ajax({
                                url:
                                    "https://api.currencylayer.com/" +
                                    endpoint +
                                    "?access_key=" +
                                    currency_key +
                                    "&from=" +
                                    from +
                                    "&to=" +
                                    to +
                                    "&amount=" +
                                    res.transaction.amount / 100,
                                dataType: "jsonp",
                                success: function(json) {
                                    formatted_cost = new Intl.NumberFormat(
                                        "no-NO",
                                        { style: "currency", currency: "NOK" }
                                    )
                                        .format(json.result)
                                        .replace("kr", "NOK");
                                    $.ajax({
                                        url: "/api/charge_balance",
                                        headers: {
                                            "X-CSRF-TOKEN": $(
                                                'meta[name="csrf-token"]'
                                            ).attr("content")
                                        },
                                        type: "POST",
                                        dataType: "JSON",
                                        data: {
                                            balance: json.result,
                                            user_id: user.id
                                        },
                                        success: function(res) {
                                            setTimeout(function() {
                                                $(btn_self).buttonLoader(
                                                    "stop"
                                                );
                                            }, 5000);
                                            slick(res.transactions);
                                            formatted_balance = new Intl.NumberFormat(
                                                "no-NO",
                                                {
                                                    style: "currency",
                                                    currency: "NOK"
                                                }
                                            )
                                                .format(res.balance)
                                                .replace("kr", "NOK");
                                            $(".prepaid-card-left").attr(
                                                "style",
                                                "display: none;"
                                            );
                                            $(".mobile-wallet-payment").attr(
                                                "style",
                                                "display: none;"
                                            );
                                            $(
                                                ".content-wrapper.member-content"
                                            ).attr(
                                                "style",
                                                "min-height:350px;"
                                            );
                                            $(".updated_balance").html(
                                                formatted_balance
                                            );
                                            $(".mobile-step2").attr(
                                                "style",
                                                "display: flex;"
                                            );
                                            $(
                                                ".mobile-wallet-transaction"
                                            ).attr("style", "display: block;");
                                            if (lang === "en") {
                                                $("#pay-modal-amount").html(
                                                    "<b>" +
                                                        formatted_cost +
                                                        "</b>" +
                                                        " have been added to your balance."
                                                );
                                            } else {
                                                $("#pay-modal-amount").html(
                                                    "<b>" +
                                                        formatted_cost +
                                                        "</b>" +
                                                        " har blitt lagt til i saldoen din."
                                                );
                                            }
                                            $("#payment-confirmation").modal(
                                                "show"
                                            );
                                        }
                                    });
                                }
                            });
                        } else {
                            calculated_charged_amount =
                                res.transaction.amount / 100;
                            formatted_cost = new Intl.NumberFormat("no-NO", {
                                style: "currency",
                                currency: "NOK"
                            })
                                .format(calculated_charged_amount)
                                .replace("kr", "NOK");
                            $.ajax({
                                url: "/api/charge_balance",
                                headers: {
                                    "X-CSRF-TOKEN": $(
                                        'meta[name="csrf-token"]'
                                    ).attr("content")
                                },
                                type: "POST",
                                dataType: "JSON",
                                data: {
                                    balance: calculated_charged_amount,
                                    user_id: user.id
                                },
                                success: function(res) {
                                    setTimeout(function() {
                                        $(btn_self).buttonLoader("stop");
                                    }, 5000);
                                    slick(res.transactions);
                                    formatted_balance = new Intl.NumberFormat(
                                        "no-NO",
                                        { style: "currency", currency: "NOK" }
                                    )
                                        .format(res.balance)
                                        .replace("kr", "NOK");
                                    $(".prepaid-card-left").attr(
                                        "style",
                                        "display: none;"
                                    );
                                    $(".mobile-wallet-payment").attr(
                                        "style",
                                        "display: none;"
                                    );
                                    $(".content-wrapper.member-content").attr(
                                        "style",
                                        "min-height:350px;"
                                    );
                                    $(".updated_balance").html(formatted_cost);
                                    $(".mobile-step2").attr(
                                        "style",
                                        "display: flex;"
                                    );
                                    $(".mobile-wallet-transaction").attr(
                                        "style",
                                        "display: block;"
                                    );
                                    if (lang === "en") {
                                        $("#pay-modal-amount").html(
                                            "<b>" +
                                                formatted_cost +
                                                "</b>" +
                                                " have been added to your balance."
                                        );
                                    } else {
                                        $("#pay-modal-amount").html(
                                            "<b>" +
                                                formatted_cost +
                                                "</b>" +
                                                " har blitt lagt til i saldoen din."
                                        );
                                    }
                                    $("#payment-confirmation").modal("show");
                                }
                            });
                        }
                    } else {
                        var displayError = document.getElementById(
                            "card-errors"
                        );
                        displayError.textContent = res.err_msg;
                    }
                }
            });
        }
    });
    //init
    var init = function() {
        // set datatables
        $("#transaction-table").DataTable({
            rowReorder: true,
            responsive: true,
            searching: false,
            aaSorting: [],
            initComplete: function(settings, json) {
                $(this).removeClass("no-footer");
            }
        });
        if ($("#transaction-table tbody").children().length == 0) {
            $(".status-section").attr("style", "min-height: auto;");
            $("#transaction-table tbody").addClass("no-data");
            const no_transaction_title =
                lang == "en"
                    ? "No transactions yet."
                    : "Ingen transaksjoner ennå.";
            const no_transaction_des =
                lang == "en"
                    ? "Your transactions will show here once you have completed a session with a customer or consultant."
                    : "Transaksjonene dine vises her når du har fullført en økt med en kunde eller konsulent.";
            const html =
                "<div class='select-box'><div class='step'><img src='/images/mascot.svg' alt='no-image'/><label>" +
                no_transaction_title +
                "</label><p class='text'>" +
                no_transaction_des +
                "</p></div></div>";
            $("#transaction-table tbody").append(html);
        }
        $(".dynatable-search").attr("style", "display:none;");
        $(".dynatable-per-page").attr("style", "display:none;");
        // set selected credit cost default
        if (currency == "NOK") {
            formatted_cost = new Intl.NumberFormat("no-NO", {
                style: "currency",
                currency: "NOK"
            })
                .format(selected_cost)
                .replace("kr", "NOK");
        } else if (currency == "USD") {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD"
            })
                .format(selected_cost)
                .replace("$", "USD ");
        } else {
            formatted_cost = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "EUR"
            })
                .format(selected_cost)
                .replace("€", "EUR ");
        }
        $(".selected-credit").html(formatted_cost);
        $(".sumbit-total").html(
            `${lang === "en" ? "Pay" : "Betal"} ${formatted_cost}`
        );
        $(".next-btn").html(
            `${lang === "en" ? "Pay" : "Betal"} ${formatted_cost}`
        );

        $("#start_date").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            format: "mm/dd/yyyy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-110:-18"
        });
        $("#end_date").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            format: "mm/dd/yyyy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-110:-18"
        });
        $("#mobile_start_date").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            format: "mm/dd/yyyy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-110:-18"
        });
        $("#mobile_end_date").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            format: "mm/dd/yyyy",
            changeMonth: true,
            changeYear: true,
            yearRange: "-110:-18"
        });
        // show purchase complete popup
        if (is_popup == "true") {
            const from = currency;
            const to = "NOK";
            if (currency !== "NOK") {
                $.ajax({
                    url:
                        "https://api.currencylayer.com/" +
                        endpoint +
                        "?access_key=" +
                        currency_key +
                        "&from=" +
                        from +
                        "&to=" +
                        to +
                        "&amount=" +
                        amount,
                    dataType: "jsonp",
                    success: function(json) {
                        formatted_cost = new Intl.NumberFormat("no-NO", {
                            style: "currency",
                            currency: "NOK"
                        })
                            .format(json.result)
                            .replace("kr", "NOK");
                        if (lang === "en") {
                            $("#pay-modal-amount").html(
                                "<b>" +
                                    formatted_cost +
                                    "</b>" +
                                    " have been added to your balance."
                            );
                        } else {
                            $("#pay-modal-amount").html(
                                "<b>" +
                                    formatted_cost +
                                    "</b>" +
                                    " har blitt lagt til i saldoen din."
                            );
                        }
                        $("#payment-confirmation").modal("show");
                    }
                });
            } else {
                formatted_cost = new Intl.NumberFormat("no-NO", {
                    style: "currency",
                    currency: "NOK"
                })
                    .format(amount)
                    .replace("kr", "NOK");
                if (lang === "en") {
                    $("#pay-modal-amount").html(
                        "<b>" +
                            formatted_cost +
                            "</b>" +
                            " have been added to your balance."
                    );
                } else {
                    $("#pay-modal-amount").html(
                        "<b>" +
                            formatted_cost +
                            "</b>" +
                            " har blitt lagt til i saldoen din."
                    );
                }
                $("#payment-confirmation").modal("show");
            }
        }
        if (
            isMobile &&
            (search.start != "null" ||
                search.end != "null" ||
                search.type != "null")
        ) {
            $(".prepaid-card-left").attr("style", "display: none;");
            $(".mobile-wallet-payment").attr("style", "display: none;");
            $(".content-wrapper.member-content").attr(
                "style",
                "min-height:350px;"
            );
            $(".mobile-step2").attr("style", "display: flex;");
            $(".mobile-wallet-transaction").attr("style", "display: block;");
        }
    };
    init();
    $(window).on("scroll", function() {
        if ($(this).scrollTop() > 100) {
            $(".sticky-sec").attr("style", "top: 75px;");
            if ($(this).scrollTop() > 1140) {
                $(".sticky-sec").attr("style", "top: -180px;");
            }
        } else {
            $(".sticky-sec").attr("style", "top: 147px;");
        }
    });
};

const renderBookingModal = function(consultant) {
    var step = 1;
    var myAvaliablity = Array(7).fill(['0:00', '1:00', '2:00', '3:00', '4:00', '5:00', '6:00', '7:00', '8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00']);
    var selectedDates = consultant.profile.timetable ? consultant.profile.timetable.split(",") : [];
    $(document).ready(function(){
        $(".modal-day-schedule").markyourcalendar({
            availability: myAvaliablity,
            weekdays: ['Sun','Mon','Tue','Wed','Thurs','Fri','Sat'],
            startDate: new Date(),
            isMultiple: true,
            selectedDates: [selectedDates],
            onClickNavigator:function(ev, instance) {
                instance.setAvailability(myAvaliablity);
                setTimeout(() => initScheduler(selectedDates));
            },
            onClick:function(ev, data) {
                var date = $(this).attr('data-date');
                var time = $(this).attr('data-time');
                selectedBookingDate = `${date} ${time}`;
                $(".booking-date").html(`<span style="font-weight: bold">Date: &nbsp;</span>` + selectedBookingDate);
            }
        });
        
        $(".btn-next").on('click', function(){
            step++;
            $(".step-circle.active").removeClass('active');
            $(`.step-circle:nth-child(${step})`).addClass('active');

            if(step === 2){
                $(".btn-preview").removeClass('d-none');
                $('#exampleModalLabel').html("Session options");
                $('.plan-container').addClass('d-none');
                $('.session-container').removeClass('d-none');
            }

            if(step === 3){
                $('#exampleModalLabel').html("Schedule your sessions");
                $('.session-container').addClass('d-none');
                $('.schedule-container').removeClass('d-none');
                initScheduler(selectedDates);

            }

            if(step === 4){
                $('#exampleModalLabel').html("Communication Tool");
                $('.schedule-container').addClass('d-none');
                $('.communication-container').removeClass('d-none');
            }

            if(step === 5){
                const data = {  
                    'profileID': $('#booking_profile_id').val(),
                    'consultantID': selectedConsultantId,
                    'planID': selectedPlanId,
                    'sessionID': selectedSessionId, 
                    'date': selectedBookingDate,
                    'communicationType': selectedCommunicationWay
                }
                $('#inp-booking-data').val(JSON.stringify(data));
                $('#from-booking').submit();
            }
        });

        $(".btn-preview").on('click', function(){
            step--;
            $(".step-circle.active").removeClass('active');
            $(`.step-circle:nth-child(${step})`).addClass('active');

            if(step === 1){
                $(".btn-preview").addClass('d-none');
                $('#exampleModalLabel').html("Selecet your plan");
                $('.plan-container').removeClass('d-none');
                $('.session-container').addClass('d-none');
            }

            if(step === 2){
                $('#exampleModalLabel').html("Session options");
                $('.session-container').removeClass('d-none');
                $('.schedule-container').addClass('d-none');
            }

            if(step === 3){
                $('#exampleModalLabel').html("Schedule your sessions");
                $('.schedule-container').removeClass('d-none');
                $('.communication-container').addClass('d-none');
            }
        });
    });
    let html = `
    <div class="modal modal-booking fade" id="modal-booking-${consultant.user_id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="headline">
                        <h5 class="modal-title" id="exampleModalLabel">Select your plan</h5>
                        <div class="steps">
                            <div class="step-circle active"></div>
                            <div class="step-circle"></div>
                            <div class="step-circle"></div>
                            <div class="step-circle"></div>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="plan-container">
                            ` + configPlanView(consultant.plan) + `
                        </div>
                        <div class="session-container text-center d-none">
                            session container
                        </div>
                        <div class="schedule-container d-none">
                            <div class="day-schedule-header d-flex justify-content-between mb-2">
                                <div class="day-status">
                                    <span class="caption">
                                        <i class="book-time-available"></i>    
                                        <span>Available</span>
                                    </span>
                                    <span class="caption ml-3">
                                        <i class="book-time-not-available"></i>    
                                        <span>Not available</span>
                                    </span>
                                    <span class="caption ml-3">
                                        <i class="booked-time"></i>    
                                        <span>Booked by you</span>
                                    </span>
                                </div>
                                <div class="timezone">
                                    Based on your timezone (UTC+8:00)
                                </div>
                            </div>
                            <div class="modal-day-schedule"></div>
                        </div>
                        <div class="communication-container text-center d-none">
                            communication tool
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div style="display: flex;column-gap: 20px;">
                        <img class="plan-footer-avatar" src="${consultant.profile.avatar ? consultant.profile.avatar : 'images/user.png'}"/>
                        <input id="booking_profile_id" value="${consultant.profile_id}" hidden/>
                        <div class="booking-detail">
                            <span style="display: flex; align-items:center; margin-right: 10px" class="booking-price"></span>
                            <span style="display: flex; align-items:center; margin-right: 10px" class="booking-title"></span>
                            <span style="display: flex; align-items:center; margin-right: 10px" class="booking-date"></span>
                            <span style="display: flex; align-items:center; margin-right: 10px" class="booking-tool"></span>
                        </div>
                    </div>
                    <div class="btn-groups">
                        <button type="button" class="btn btn-preview mr-1 d-none">Previous</button>
                        <button type="button" class="btn btn-next">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  `;
    return html;
};

const initScheduler = function(selectedDates)
{
    selectedDates.forEach((ele) => {
        var date = ele.split(" ")[0];
        var time = ele.split(" ")[1];
        $(`a.myc-available-time[data-date='${date}'][data-time='${time}']`).addClass('selected');
    });
}

const configPlanView = function (plans) {
    
    $(document).ready(function(){
        $("li.plan").on('click', function() {
            $("li.plan.active").removeClass('active');
            $(this).addClass('active');

            selectedPlanId = $(this).attr("data-id");
            const selectedPlan = plans.find(plan=> plan.id == selectedPlanId);
            if(selectedPlanId !== 0 && selectedPlan)
            { 
                const sessionViewHtml = configSessionView(selectedPlan.sessions);
                $(".session-container").html(sessionViewHtml);
            }
        });
    });

    let html = '';
    if(plans.length === 0)
        html += `<p>This consultant has no plans. Please wait until he is available with the plans.</p>`;
    else {
        html += `<ul class="plan-list">`;
        plans.forEach(plan => {
            html += `
                <li class="plan" data-id="${plan.id}">
                    <div class="plan-info">
                        <h5>${plan.title}</h5>
                        <span>${plan.sessions.length} sessions</span>
                    </div>
                    <div class="plan-price">
                        <span>NOK ${plan.price.toFixed(2)} +</span>
                    </div>
                </li>
            `;
        });
        html += `</ul>`;
    }
    return html;
}

const configSessionView = function (sessions) {
    $(document).ready(function(){
        $(".plan-session").on('click', function() {
            $(".plan-session.active").removeClass('active');
            $(this).addClass('active');

            selectedSessionId = $(this).attr("data-id");
            selectedSessionPrice = $(this).attr("data-price");
            selectedSessionCurrency = $(this).attr("data-currency");
            selectedSessionTitle = $(this).attr("data-title");

            $(".booking-price").html(`<span style="font-weight: bold">Price: &nbsp;</span>` + selectedSessionCurrency + '&nbsp;' + selectedSessionPrice);
            $(".booking-title").html(`<span style="font-weight: bold">Session: &nbsp;</span>` + selectedSessionTitle);
            const communicationToolViewHtml = configCommunicationView();
            $('.communication-container').html(communicationToolViewHtml);
        });
    });

    let html = '';
    html += `<h3>Sessions rules</h3>`;
    html += `<p>Sessions must be scheduled in advance.</p>`;
    html += `<p>Date and time for at least ONE session should be selected to purchase a Package.</p>`;
    html += `<p>Sessions must be scheduled within six months of purchase date.</p>`;

    html += `<div class="plan-sessions">`;
    sessions.forEach(session => {
        html += `<div class="plan-session-container">`;
        html += `<h2>${session.duration} min</h2>`;
        html += `<div class="plan-session" data-id=${session.id} data-currency=${session.currency_type} data-price=${session.price.toFixed(2)} data-title=${session.title}>`;
        html += `<span>${session.title}</span>`;
        html += `<span>${session.currency_type} ${session.price.toFixed(2)}</span>`;
        html += `</div>`;
        html += `</div>`;
    });
    html += `</div>`;
    return html;
}

const configCommunicationView = function () {
    $(document).ready(function(){
        $(".communication-tool").on('click', function() {
            $(".communication-tool.active").removeClass('active');
            $(this).addClass('active');

            selectedCommunicationWay = $(this).attr("data-type");
            selectedCommunicationWay = selectedCommunicationWay === 'gtc' ? 'GotoConsult' : selectedCommunicationWay;
            selectedCommunicationWay = selectedCommunicationWay === 'skype' ? 'Skype' : selectedCommunicationWay;
            $(".booking-tool").html(`<span style="font-weight: bold">Communication: &nbsp;</span>` + selectedCommunicationWay);
        });
    });

    let html = '';
    html += `<p>Your consultant can use any of the these communication tools.</p>`;
    html += `<p>Which communication tool would you like to use for your session?</p>`;

    html += `<div class="communication-tool-container">`;
    html += `<div class="communication-tool" data-type="gtc">`;
    html += `<img src="../images/color-full-logo.svg"/>`;
    html += `</div>`;
    html += `<div class="communication-tool" data-type="skype">`;
    html += `<img class="skype" src="../images/skype-logo.png" />`;
    html += `</div>`;
    html += `</div>`;
    return html;
}