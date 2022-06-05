var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
/*  */
const public = function () {
  $(".public-btn-country").on('click', function (e) {
    e.preventDefault();
    const href = window.location.href;
    const origin = window.location.origin;
    var url = href.replace(origin, '');
    if (lang == 'no') {
      if (url.includes('/no/kategori-sok')) {
        url = url.replace('/no/kategori-sok', 'category-search');
      } else if (url.includes('/no/kategori')) {
        url = url.replace('/no/kategori', 'category');
      }
      switch (url) {
        case '/no/bli-konsulent':
          url = 'become-consultant';
          break;
        case '/no/funksjoner':
          url = 'features';
          break;
        case '/no/om-oss':
          url = 'about';
          break;
        case '/no/personvern':
          url = 'privacy';
          break;
        case '/no/vilkar-kunde':
          url = 'terms-customer';
          break;
        case '/no/vilkar-konsulent':
          url = 'terms-consultant';
          break;
        case '/no/logg-inn':
          url = 'login';
          break;
        case '/no/registrer':
          url = 'register';
          break;
        case '/no/passord/glemte':
          url = 'password/forgot';
          break;
        case '/no/kategori':
          url = 'category';
          break;
        case '/no/kalender':
          url = 'calendar';
          break;
        case '/no':
          url = '';
          break;
      }
    } else {
      if (url.includes('/category-search')) {
        url = url.replace('/category-search', 'kategori-sok');
      } else if (url.includes('/category')) {
        url = url.replace('/category', 'kategori');
      }
      switch (url) {
        case '/become-consultant':
          url = 'bli-konsulent';
          break;
        case '/features':
          url = 'funksjoner';
          break;
        case '/about':
          url = 'om-oss';
          break;
        case '/privacy':
          url = 'personvern';
          break;
        case '/terms-customer':
          url = 'vilkar-kunde';
          break;
        case '/terms-consultant':
          url = 'vilkar-konsulent';
          break;
        case '/login':
          url = 'logg-inn';
          break;
        case '/register':
          url = 'registrer';
          break;
        case '/password/forgot':
          url = 'passord/glemte';
          break;
        case '/category':
          url = 'kategori';
          break;
        case '/calendar':
          url = 'kalender';
          break;
        case '/':
          url = '';
          break;
      }
    }
    var new_lang = lang == 'en' ? 'no' : 'en';
    $(".selected_lang").val(new_lang);
    $(".current_address").val(url);
    $(".lang-form").trigger('submit');
  });
  $(".navbar-toggler").on('click', function () {
    $(".navbar-sidebar").addClass('collapsed');
    $(".navigation__nav").addClass('collapsed');
  });
  $(".navigation-toggler").on('click', function () {
    $(".navbar-sidebar").removeClass('collapsed');
    $(".navigation__nav").removeClass('collapsed');
  });
};

const floaLabel = function (element) {
  $(element).on('focusout', function () {
    var text_val = $(this).val();
    if ($(this)[0].tagName !== 'SELECT' && $(this).hasClass('yearpicker') !== true) {
      $("label[for='" + this.id + "']").toggleClass('labelfocus', text_val !== "");
    }
  });

  $(element).on('focus', function () {
    $("label[for='" + this.id + "']").addClass("labelfocus");
  });
  $(element).on('blur', function () {
    if (!$(this).val()) {
      if ($(this)[0].tagName !== 'SELECT' && $(this).hasClass('yearpicker') !== true) {
        $("label[for='" + this.id + "']").removeClass("labelfocus");
      }
    } else {
      $("label[for='" + this.id + "']").addClass("labelfocus");
    }
  });
};

const sticky = function () {
  $( window ).on('scroll', function() {
    if ($(this).scrollTop() > 300) {
      $(".navbar-brand img").attr("src", "/images/color-full-logo.svg");
      $(".navbar-toggler span").attr("style", "background: #000;");
      $('.navbar').removeClass('transparent');
    } else {
      $(".navbar-brand img").attr("src", "/images/w-full-logo.svg");
      $(".navbar-toggler span").attr("style", "background: #fff;");
      $('.navbar').addClass('transparent');
    }
  });
};

const authenticator = function () {
  var init = function () {
    floaLabel('#login-form .form-control');
    floaLabel('#register-form .form-control');
    floaLabel('#reset-form .form-control');
    floaLabel('#forgot-form .form-control');
    floaLabel('#consultant-form .form-control');
    floaLabel('#education-form .form-control');
    floaLabel('#experience-form .form-control');
    floaLabel('#certificate-form .form-control');
  };
  init();
};

const home = function (desktop_banner, mobile_banner) {
  $(".customer").on('click', function () {
    $(this).addClass('active');
    $(".consultant").removeClass('active');
    $(".customer-review").addClass('active');
    $(".consultant-review").removeClass('active');
  });
  $(".consultant").on('click', function () {
    $(this).addClass('active');
    $(".customer").removeClass('active');
    $(".consultant-review").addClass('active');
    $(".customer-review").removeClass('active');
    if (isMobile) {
      $(".consultant-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      if ($(".consultant-review").children().length > 3) {
        $(".consultant-review").slick({
          slidesToShow: 3,
          slidesToScroll: 3,
          dots:true,
          arrows: false
        });
      }
    }
  });
  var init = function () {
    $("nav").addClass('transparent');
    $(".navbar-toggler span").attr("style", "background: #fff;");
    if(window.matchMedia("(max-width: 767px)").matches) {
      $(".navbar-brand img").attr("src", "images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(" + mobile_banner + ");");
      $(".inner-footer").attr('style', "background-image: url(/images/footer-mobile-bg.png)");
      $(".customer-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".navbar-brand img").attr("src", "images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(" + desktop_banner + ");");
      $(".inner-footer").attr('style', "background-image: url(/images/footer-background.png)");
      if ($(".customer-review").children().length > 3) {
        $(".customer-review").slick({
          slidesToShow: 3,
          slidesToScroll: 3,
          dots:true,
          arrows: false
        });
      }
    }
  };
  init();
};

const about = function (desktop_banner, mobile_banner) {
  $(".customer").on('click', function () {
    $(this).addClass('active');
    $(".consultant").removeClass('active');
    $(".customer-review").addClass('active');
    $(".consultant-review").removeClass('active');

  });
  $(".consultant").on('click', function () {
    $(this).addClass('active');
    $(".customer").removeClass('active');
    $(".consultant-review").addClass('active');
    $(".customer-review").removeClass('active');
    if (isMobile) {
      $(".consultant-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      if ($(".consultant-review").children().length > 3) {
        $(".consultant-review").slick({
          slidesToShow: 3,
          slidesToScroll: 3,
          dots:true,
          arrows: false
        });
      }
    }
  });
  $(".btn-bio").on('click', function () {
    var x = $(this).data('key');
    if (lang == 'en') {
      if ($("#show_hide_bio" + x).text() == "Show Bio") {
        $("#show_hide_bio" + x).html("Hide Bio");
      }
      else {
        $("#show_hide_bio" + x).html("Show Bio");
      }
    } else {
      if ($("#show_hide_bio" + x).text() == "Vis Bio") {
        $("#show_hide_bio" + x).html("Skjul Bio");
      }
      else {
        $("#show_hide_bio" + x).html("Vis Bio");
      }
    }
    $("#bio_content" + x).slideToggle();
  });
  var init = function () {
    $("nav").addClass('transparent');
    $(".navbar-toggler span").attr("style", "background: #fff;");
    if(window.matchMedia("(max-width: 767px)").matches) {
      $(".navbar-brand img").attr("src", "/images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(" + mobile_banner + ");");
      $(".inner-footer").attr('style', "background-image: url(/images/footer-mobile-bg.png)");
      $(".customer-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".navbar-brand img").attr("src", "/images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(" + desktop_banner + ");");
      $(".inner-footer").attr('style', "background-image: url(/images/footer-background.png)");
      if ($(".customer-review").children().length > 3) {
        $(".customer-review").slick({
          slidesToShow: 3,
          slidesToScroll: 3,
          dots:true,
          arrows: false
        });
      }
    }
  };
  init();
};

const features = function (desktop_banner, mobile_banner) {
  $(".customer").on('click', function () {
    $(this).addClass('active');
    $(".consultant").removeClass('active');
    $(".customer-review").addClass('active');
    $(".consultant-review").removeClass('active');
  });
  $(".consultant").on('click', function () {
    $(this).addClass('active');
    $(".customer").removeClass('active');
    $(".consultant-review").addClass('active');
    $(".customer-review").removeClass('active');
    if (isMobile) {
      $(".consultant-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      if ($(".consultant-review").children().length > 3) {
        $(".consultant-review").slick({
          slidesToShow: 3,
          slidesToScroll: 3,
          dots:true,
          arrows: false
        });
      }
    }
  });
  var init = function () {
    $("nav").addClass('transparent');
    $(".user-btn img").attr("src", "/images/user-w.svg");
    if(window.matchMedia("(max-width: 767px)").matches) {
      $(".navbar-brand img").attr("src", "/images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(" + mobile_banner + ");");
      $(".inner-footer").attr('style', "background-image: url(/images/footer-mobile-bg.png)");
      $(".customer-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".navbar-brand img").attr("src", "/images/w-full-logo.svg");
      $(".banner").attr('style', "background-image: url(" + desktop_banner + ");");
      $(".inner-footer").attr('style', "background-image: url(/images/footer-background.png)");
      if ($(".customer-review").children().length > 3) {
        $(".customer-review").slick({
          slidesToShow: 3,
          slidesToScroll: 3,
          dots:true,
          arrows: false
        });
      }
    }
    $(".navbar-toggler span").attr("style", "background: #fff;");
  };
  init();
};

const login = function () {
  $(".login").on('click', function (event) {
    event.preventDefault();
    if ($("#login-form").valid()) {
      if ($('#remember').is(':checked')) {
        var email = $('#email').val();
        var password = $('#password').val();
        // set cookies to expire in 14 days
        $.cookie('email', email, { expires: 14 });
        $.cookie('password', password, { expires: 14 });
        $.cookie('remember', true, { expires: 14 });
      }
      $("#login-form").submit();
    }
  });
  var init = function () {
    var remember = $.cookie('remember');
    if (remember == 'true') {
      var email = $.cookie('email');
      var password = $.cookie('password');
      // autofill the fields
      $('#email').val(email);
      $('#password').val(password);
    }
    $('#login-form').validate({
      errorPlacement: function () { },
      errorClass: "label",
      highlight: function (element, errorClass, validClass) {
        $(element).parent().addClass("error");
        $(element).parent().removeClass("success");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).parent().removeClass("error");
        $(element).parent().addClass("success");
      }
    });
  }
  init();
};

const forgotPassword = function () {
  $(".send").on('click', function (event) {
    event.preventDefault();
    if ($("#forgot-form").valid()) {
      $("#forgot-form").submit();
    }
  });
  var init = function () {
    $('#forgot-form').validate({
      errorPlacement: function () { },
      errorClass: "label",
      highlight: function (element, errorClass, validClass) {
        $(element).parent().addClass("error");
        $(element).parent().removeClass("success");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).parent().removeClass("error");
        $(element).parent().addClass("success");
      }
    });
  }
  init();
};

const resetPassword = function () {
  $(".send").on('click', function (event) {
    event.preventDefault();
    if ($("#reset-form").valid()) {
      $("#reset-form").submit();
    }
  });
  var init = function () {
    $('#reset-form').validate({
      errorPlacement: function () { },
      errorClass: "label",
      highlight: function (element, errorClass, validClass) {
        $(element).parent().addClass("error");
        $(element).parent().removeClass("success");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).parent().removeClass("error");
        $(element).parent().addClass("success");
      },
      rules : {
        password : {
          minlength : 8
        },
        password_confirm : {
          minlength : 8,
          equalTo : "#password"
        }
      }
    });
  }
  init();
};

const register = function () {
  $(".register").on('click', function (event) {
    event.preventDefault();
    if ($("#register-form").valid()) {
      var form = document.getElementById('register-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'remember');
      form.appendChild(hiddenInput);
      if ($("#remember").prop("checked") == true) {
        hiddenInput.setAttribute('value', true);
      } else {
        hiddenInput.setAttribute('value', false);
      }
      $("#register-form").submit();
    }
  });

  var init = function () {
    $('#register-form').validate({
      errorPlacement: function () { },
      errorClass: "label",
      highlight: function (element, errorClass, validClass) {
        $(element).parent().addClass("error");
        $(element).parent().removeClass("success");
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).parent().removeClass("error");
        $(element).parent().addClass("success");
      }
    });
  }
  init();
};

const category = function (search, countries, consultants, categories, rate_imgs, btn_imgs) {
  $(".customer").on('click', function () {
    $(this).addClass('active');
    $(".consultant").removeClass('active');
    $(".customer-review").addClass('active');
    $(".consultant-review").removeClass('active');
  });
  $(".consultant").on('click', function () {
    $(this).addClass('active');
    $(".customer").removeClass('active');
    $(".consultant-review").addClass('active');
    $(".customer-review").removeClass('active');
    if (isMobile) {
      $(".consultant-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      if ($(".consultant-review").children().length > 3) {
        $(".consultant-review").slick({
          slidesToShow: 3,
          slidesToScroll: 3,
          dots:true,
          arrows: false
        });
      }
    }
  });

  var query = {};
  $("#show_filter").on('click', function () {
    if ($(".filter-body").hasClass('active')) {
      $(this).addClass('reversed');
      $(".filter-body").removeClass('active');
    } else {
      $(this).removeClass('reversed');
      $(".filter-body").addClass('active');
    }
  });

  $(".search").on('change', function (e) {
    query.name  = e.target.value != 'null' ? e.target.value : 'null';
  });
  $(".category-sel").on('change', function (e) {
    query.category  = e.target.value != 'null' ? e.target.value : 'null';
  });
  $(".price-sel").on('change', function (e) {
    query.price  = e.target.value != 'null' ? e.target.value : 'null';
  });
  $(".status-sel").on('change', function (e) {
    query.status  = e.target.value != 'null' ? e.target.value : 'null';
  });
  $(".country-sel").on('change', function (e) {
    query.country  = e.target.value != 'null' ? e.target.value : 'null';
  });

  $("#mobile_filter").on('click', function () {
    const name = query.name ? query.name : 'null';
    const category = search.category;
    const status = query.status ? query.status : 'All';
    const price = query.price ? query.price : 'Default';
    const country = query.country ? query.country : 'All';
    const url = lang == 'en' ? "/category-search?name=" : "/no/kategori-sok?name=";

    setTimeout(function () {
      window.location = url + name + "&category=" + category + "&price=" + price + "&status=" + status + "&country=" + country;
    }, 50);
  });
  $("#desktop_filter").on('click', function () {
    const name = query.name ? query.name : 'null';
    const category = search.category;
    const status = query.status ? query.status : 'All';
    const price = query.price ? query.price : 'Default';
    const country = query.country ? query.country : 'All';
    const url = lang == 'en' ? "/category-search?name=" : "/no/kategori-sok?name=";

    setTimeout(function () {
      window.location = url + name + "&category=" + category + "&price=" + price + "&status=" + status + "&country=" + country;
    }, 50);
  });

  const Uri = function (url) {
    return window.location.origin + url;
  };
  const slick = function (consultants) {
    let append_html = '';
    const percentage = $(window).width() < 768 ? 2 : $(window).width() == 768 ? 3 : $(window).width() >= 1024 & $(window).width() < 1440 ? 4 : 4;
    consultants.forEach((item, key) => {
      let star_images = "<ul class='d-flex'>";
      for (let i = 0; i < 5; i ++) {
        if (item.rate == 5) {
          star_images += `<li><img src='${rate_imgs[0]}' alt-img='no-img'/></li>`;
        } else if (item.rate == 4) {
          star_images += i < 4 ? `<li><img src='${rate_imgs[1]}' alt-img='no-img'/></li>` : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
        } else if (item.rate == 3) {
          star_images += i < 3 ? `<li><img src='${rate_imgs[2]}' alt-img='no-img'/></li>` : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
        } else if (item.rate == 2) {
          star_images += i < 2 ? `<li><img src='${rate_imgs[3]}' alt-img='no-img'/></li>` : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
        } else if (item.rate == 1) {
          star_images += i < 1 ? `<li><img src='${rate_imgs[4]}' alt-img='no-img'/></li>` : `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
        } else {
          star_images += `<li><img src='${rate_imgs[5]}' alt-img='no-img'/></li>`;
        }
      }
      star_images += "</ul>";
      const floatRate = item.rate ? item.rate : 0;
      star_images += `<p>${floatRate.toFixed(1)}</p>`;
      const profile_url = lang == 'en' ? item.user.account_id ? Uri('/profile/' + item.user.account_id) : Uri('/profile/' + item.user.id) : item.user.account_id ? Uri('/no/profil/' + item.user.account_id) : Uri('/no/profil/' + item.user.id);
      const btn_name = lang == 'en' ? 'Profile' : 'Profil';
      const session_url = Uri('/login');
      const btn_phone_img = item.user.status == "available" ? item.phone_contact != 0 ? btn_imgs[0] : btn_imgs[2] : item.user.status == "offline" ? btn_imgs[2] : item.phone_contact != 0 ? btn_imgs[1] : btn_imgs[2];
      const btn_video_img = item.user.status == "available" ? item.video_contact != 0 ? btn_imgs[3] : btn_imgs[5] : item.user.status == "offline" ? btn_imgs[5] : item.video_contact != 0 ? btn_imgs[4] : btn_imgs[5];
      const btn_chat_img = item.user.status == "available" ? item.chat_contact != 0 ? btn_imgs[6] : btn_imgs[8] : item.user.status == "offline" ? btn_imgs[8] : item.chat_contact != 0 ? btn_imgs[7] : btn_imgs[8];
      const is_offline = item.user.status == "offline" ? true : false;
      let html_item = `<div class='cart-section' id='con_${item.user_id}'><div class='avatar-pic'></div>`;
      if (item.hasOwnProperty('profile') && item.profile.profession) {
        const category = categories.find((sel) => sel.category_name === item.profile.profession);

        if (typeof category !== "undefined") {
          const profession = lang === 'en' ? category.category_name : category.category_name_no;
          html_item += `<label class='mt-3 mb-0'>${profession}</label>`;
          html_item += `<h3>${item.user.first_name} ${item.user.last_name}</h3><small></small><div class='star-images'>${star_images}</div><small></small>`;
        }
      } else {
        html_item += `<h3 class='mt-3 mb-0'>${item.user.first_name} ${item.user.last_name}</h3><small></small><div class='star-images'>${star_images}</div><small></small>`;
      }
      html_item += `<div class='rm d-flex justify-content-between'><a href='${profile_url}'>${btn_name}</a><p>${item.currency} ${item.hourly_rate} p/m</p></div>`;
      html_item += "<div class='end-button d-flex'>";
      html_item += `<a class='btn-session' href='${is_offline ? 'javascript:void(0)' : session_url}'><img src='${btn_phone_img}' alt='no-img'/></a>`;
      html_item += `<a class='btn-session' href='${is_offline ? 'javascript:void(0)' : session_url}'><img src='${btn_video_img}' alt='no-img'/></a>`;
      html_item += `<a class='btn-session' href='${is_offline ? 'javascript:void(0)' : session_url}'><img src='${btn_chat_img}' alt='no-img'/></a></div></div>`;

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
    consultants.forEach((item) => {
      const url = item.profile && item.profile.avatar != null ? item.profile.avatar : 'images/white-logo.svg';
      const sizeCss = item.profile && item.profile.avatar != null ? 'cover' : '20px 20px';
      $('#con_'+item.user_id).children().eq(0).css('background-image', "url(" + url  + ")");
      $('#con_'+item.user_id).children().eq(0).css('background-size', sizeCss);
    });
    // if (consultants.length > percentage) {
    //   $('.consultants-view').slick({
    //     dots: true,
    //     infinite: false,
    //     mobileFirst: true,
    //     arrows: false,
    //     fade: false,
    //     speed: 300,
    //     slidesToShow: 1,
    //     cssEase: 'linear'
    //   });
    // }
  }

  var init = function () {
    slick(consultants);
    if(window.matchMedia("(max-width: 767px)").matches) {
      $(".inner-footer").attr('style', "background-image: url(/images/home/footer-mobile-bg.png)");
      $(".customer-review").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots:true,
        arrows: false
      });
    } else {
      $(".inner-footer").attr('style', "background-image: url(/images/footer-background.png)");
      if ($(".customer-review").children().length > 3) {
        $(".customer-review").slick({
          slidesToShow: 3,
          slidesToScroll: 3,
          dots:true,
          arrows: false
        });
      }
    }
    Object.values(countries).forEach((item) => {
      if (item != null) {
        $('.country-sel').append(`<option value="${item.toLowerCase()}">${item}</option>`);
      }
    });
    if (search.name != 'null') {
      $(".search").val(search.name);
    }
    if (search.price != 'Default') {
      $(".price-sel").val(search.price);
    }
    if (search.status != 'All') {
      $(".status-sel").val(search.status);
    }
    if (search.country != 'All') {
      $(".country-sel").val(search.country);
    }
  };
  init();
};

const profile = function (user_profile, review_info, chart_info, img_group) {
  var cover_image = user_profile.profile ? user_profile.profile.cover_img : '';
  var avatar_image = user_profile.profile ? user_profile.profile.avatar : '';

  init();
  function init() {
    $(".profile-card.about").attr("style", "display: block;");
    if (cover_image) {
      $(".edit-cover-photo").attr('style', `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${cover_image}')`);
      $(".cover-file").attr('style', 'display: none;');
    }
    if (avatar_image) {
      $(".preview-profile-photo").attr('style', `background-position: center; background-repeat: no-repeat; background-size: cover; background-image:url('${avatar_image}')`);
      $(".preview-profile-photo img").attr('style', 'display: none;');
    }
    $.ajax({
      url: '/api/get-universities',
      type: 'GET',
      dataType: 'JSON',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        data.array.forEach((item) => {
          $('.university-list').append(`<option value="${item.name}">${item.name}</option>`);
        });
        if (user_profile.profile && user_profile.profile.college) {
          $('.university-list').val(user_profile.profile.college);
        }
      }
    });
    // completed session chart
    var columns = [];
    columns.push(['x', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
    var column_data = ['y'];
    var y_values = [];
    Object.keys(chart_info.completed_sessions).forEach((key, item) => {
      y_values.push(chart_info.completed_sessions[key]);
      column_data.push(chart_info.completed_sessions[key]);
    });
    columns.push(column_data);
    var maxValueInArray = Math.max.apply(Math, y_values);
    var chartWidth = $(".chart-body").width();
    var chart = c3.generate({
      bindto: '#completed-session-chart',
      size: {
        width: chartWidth
      },
      data: {
        x: 'x',
        columns: columns,
        type: 'bar',
        labels: true,
      },
      color: {
        linearGradient: {
          x1: 0,
          x2: 0,
          y1: 0,
          y2: 1
        },
        stops: [
          [0, '#8773ff'],
          [1, '#67a5ff']
        ]
      },
      bar: {
        width: { ratio: 0.8 },
        spacing: 2
      },
      axis: {
        x: {
          type: 'categories',
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
      onrendered: function () {
        let $graphic = $(".completed-session-chart svg g");
        $($graphic[0]).attr("style", "transform: translate(0, 0);");
        let $y_axis = $(".completed-session-chart .c3-axis-y");
        $($y_axis).attr("style", "display: none;");
        let $y2_axis = $(".completed-session-chart .c3-axis-y2");
        $($y2_axis).attr("style", "display: none;");
        let $legend_item_y = $(".completed-session-chart .c3-legend-item-y");
        $($legend_item_y).attr("style", "display: none;");
        let $path = $(".completed-session-chart path.domain");
        $($path).attr("style", "display: none;");
        let $x_axis = $(".completed-session-chart .c3-axis-x");
        $($x_axis).attr("style", "transform: translate(0, 235px);");
        let $x_axis_span = $(".completed-session-chart .c3-axis-x g text tspan");
        $($x_axis_span).attr("style", "font-family: 'Poppins Regular';");

        let $c3_shapes = $(".completed-session-chart .c3-shape");
        $.each($c3_shapes, (i, el) => {
          var bar_radius = y_values[i] > parseInt(maxValueInArray / 2) ? 10 : y_values[i] > parseInt(maxValueInArray / 3) ? 5 : 0;
          var point_1X = parseFloat($(el).attr('d').split(' ')[2].replace('L', '').split(',')[0]);
          var point_1y = parseFloat($(el).attr('d').split(' ')[2].replace('L', '').split(',')[1]);
          var point_2X = parseFloat($(el).attr('d').split(' ')[3].replace('L', '').split(',')[0]);
          var point_2y = parseFloat($(el).attr('d').split(' ')[3].replace('L', '').split(',')[1]);

          var path = 'M ' + $(el).attr('d').split(' ')[1] + ' ' +
          'L' + point_1X + ',' + (point_1y+bar_radius) + ' ' +
          'Q' + point_1X + ',' + point_1y + ' ' + (point_1X+bar_radius) + ',' + point_1y + ' ' +
          'L' + (point_2X-bar_radius) + ',' + point_2y + ' ' +
          'Q' + point_2X + ',' + point_2y + ' ' + point_2X + ',' + (point_2y+bar_radius) + ' ' +
          $(el).attr('d').split(' ')[4] + ' ' + 'z';

          $(el).attr('d', path);
          $(el).attr("style", "fill: #e2e2e2; stroke: #e2e2e2; stroke-width: 1px;");
        });

        var d = new Date(), n = d.getMonth();
        let $current_month_shape = $(`.completed-session-chart .c3-shape-${n}`);
          $($current_month_shape).attr('style', 'fill: url(#MyGradient); stroke: url(#MyGradient); stroke-width: 1px;');
        }
    });

    // resposne rate chart for consultant
    if (user_profile.user.role == 'consultant') {
      var response_columns = [];
      response_columns.push(['x', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
      var response_column_data = ['y'];
      var response_y_values = [];
      Object.keys(chart_info.response_rates).forEach((key, item) => {
        response_y_values.push(chart_info.response_rates[key]);
        response_column_data.push(chart_info.response_rates[key]);
      });
      response_columns.push(response_column_data);
      var response_maxValueInArray = Math.max.apply(Math, response_y_values);
      var chartWidth = $(".chart-body").width();
      var chart = c3.generate({
        bindto: '#response-rate-chart',
        size: {
          width: chartWidth
        },
        data: {
          x: 'x',
          columns: response_columns,
          type: 'bar',
          labels: true,
        },
        color: {
          linearGradient: {
            x1: 0,
            x2: 0,
            y1: 0,
            y2: 1
          },
          stops: [
            [0, '#8773ff'],
            [1, '#67a5ff']
          ]
        },
        bar: {
          width: { ratio: 0.8 }
        },
        axis: {
          x: {
            type: 'categories',
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
        onrendered: function () {
          let $graphic = $(".response-rate-chart svg g");
          $($graphic[0]).attr("style", "transform: translate(0, 0);");
          let $y_axis = $(".response-rate-chart .c3-axis-y");
          $($y_axis).attr("style", "display: none;");
          let $y2_axis = $(".response-rate-chart .c3-axis-y2");
          $($y2_axis).attr("style", "display: none;");
          let $legend_item_y = $(".response-rate-chart .c3-legend-item-y");
          $($legend_item_y).attr("style", "display: none;");
          let $path = $(".response-rate-chart path.domain");
          $($path).attr("style", "display: none;");
          let $x_axis = $(".response-rate-chart .c3-axis-x");
          $($x_axis).attr("style", "transform: translate(0, 235px);");
          let $x_axis_span = $(".completed-session-chart .c3-axis-x g text tspan");
          $($x_axis_span).attr("style", "font-family: 'Poppins Regular';");
          let $text_elements = $(".response-rate-chart text.c3-text");
          $.each($text_elements, (i, el) => {
            $(el).text($(el).html() + '%');
          });

          let $c3_shapes = $(".response-rate-chart .c3-shape");
          $.each($c3_shapes, (i, el) => {
            var bar_radius = response_y_values[i] > parseInt(response_maxValueInArray / 2) ? 10 : response_y_values[i] > parseInt(response_maxValueInArray / 3) ? 5 : 0;

            var point_1X = parseFloat($(el).attr('d').split(' ')[2].replace('L', '').split(',')[0]);
            var point_1y = parseFloat($(el).attr('d').split(' ')[2].replace('L', '').split(',')[1]);
            var point_2X = parseFloat($(el).attr('d').split(' ')[3].replace('L', '').split(',')[0]);
            var point_2y = parseFloat($(el).attr('d').split(' ')[3].replace('L', '').split(',')[1]);

            var path = 'M ' + $(el).attr('d').split(' ')[1] + ' ' +
            'L' + point_1X + ',' + (point_1y+bar_radius) + ' ' +
            'Q' + point_1X + ',' + point_1y + ' ' + (point_1X+bar_radius) + ',' + point_1y + ' ' +
            'L' + (point_2X-bar_radius) + ',' + point_2y + ' ' +
            'Q' + point_2X + ',' + point_2y + ' ' + point_2X + ',' + (point_2y+bar_radius) + ' ' +
            $(el).attr('d').split(' ')[4] + ' ' + 'z';

            $(el).attr('d', path);
            $(el).attr("style", "fill: #e2e2e2; stroke: #e2e2e2; stroke-width: 1px;");
          });

          var d = new Date(), n = d.getMonth();
          let $current_month_shape = $(`.response-rate-chart .c3-shape-${n}`);
          $($current_month_shape).attr('style', 'fill: url(#MyGradient); stroke: url(#MyGradient); stroke-width: 1px;');
        }
      });
    }
    if (review_info) {
      $(".review").slice(0, 5).show();
      if ($(".blogBox:hidden").length != 0) {
        $("#loadMore").show();
      }
    }
  }
  $("#loadMore").on('click', function (e) {
    e.preventDefault();
    $(".review:hidden").slice(0, review_info.length).slideDown();
    if ($(".review:hidden").length == 0) {
      $("#loadMore").fadeOut('slow');
    }
  });
  $(".tab.about").on('click', function(e) {
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
  $(".tab.sessions").on('click', function(e) {
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
  $(".tab.reviews").on('click', function(e) {
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
