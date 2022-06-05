// Scrollbar
// var elem = document.querySelector("body");
// var scrollbar = Scrollbar.init(elem,
// {
// 	speed: 0.7,
// 	damping:0.04
// });

const public = function () {
  $(".admin-btn-country").on('click', function (e) {
    e.preventDefault();
    const href = window.location.href;
    const origin = window.location.origin;
    var url = href.replace(origin, '');
    if (lang == 'no') {
      switch (url) {
        case '/no/sider':
          url = 'pages';
          break;
        case '/no/opprett-side':
          url = 'create-page';
          break;
        case '/no/kunder':
          url = 'customers';
          break;
        case '/no/opprett-kunde':
          url = 'create-customer';
          break;
        case '/no/konsulenter':
          url = 'consultants';
          break;
        case '/no/opprett-konsulent':
          url = 'create-consultant';
          break;
        case '/no/kategorier':
          url = 'categories';
          break;
        case '/no/opprett-kategori':
          url = 'create-category';
          break;
        case '/no/innstillinger':
          url = 'settings';
          break;
      }
      if (url.includes('rediger-side')) {
        url = url.replace('/no/rediger-side', 'edit-page');
      } else if (url.includes('rediger-kunde')) {
        url = url.replace('/no/rediger-kunde', 'edit-customer');
      } else if (url.includes('rediger-konsulent')) {
        url = url.replace('/no/rediger-konsulent', 'edit-consultant');
      } else if (url.includes('rediger-kategori')) {
        url = url.replace('/no/rediger-kategori', 'edit-category');
      } else if (url.includes('admin-transaksjoner-sok')) {
        url = url.replace('/no/admin-transaksjoner-sok', 'admin-transaction-search');
      }
    } else {
      switch (url) {
        case '/pages':
          url = 'sider';
          break;
        case '/create-page':
          url = 'opprett-side';
          break;
        case '/customers':
          url = 'kunder';
          break;
        case '/create-customer':
          url = 'opprett-kunde';
          break;
        case '/consultants':
          url = 'konsulenter';
          break;
        case '/create-consultant':
          url = 'opprett-konsulent';
          break;
        case '/categories':
          url = 'kategorier';
          break;
        case '/create-category':
          url = 'opprett-kategori';
          break;
        case '/settings':
          url = 'innstillinger';
          break;
      }
      if (url.includes('edit-page')) {
        url = url.replace('/edit-page', 'rediger-side');
      } else if (url.includes('edit-customer')) {
        url = url.replace('/edit-customer', 'rediger-kunde');
      } else if (url.includes('edit-consultant')) {
        url = url.replace('/edit-consultant', 'rediger-konsulent');
      } else if (url.includes('edit-category')) {
        url = url.replace('/edit-category', 'rediger-kategori');
      } else if (url.includes('admin-transaction-search')) {
        url = url.replace('/admin-transaction-search', 'admin-transaksjoner-sok');
      }
    }
    var new_lang = lang == 'en' ? 'no' : 'en';
    $(".admin_selected_lang").val(new_lang);
    $(".admin_current_address").val(url);
    $(".admin-lang-form").trigger('submit');
  });
  $(".navbar-toggler").on('click', function () {
    $(".navbar-sidebar").addClass('collapsed');
    $(".navigation__nav").addClass('collapsed');
  });
  $(".navigation-toggler").on('click', function() {
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

const authenticator = function () {
  var init = function () {
    floaLabel('#consultant-form .form-control');
    floaLabel('#education-form .form-control');
    floaLabel('#experience-form .form-control');
    floaLabel('#certificate-form .form-control');
  };
  init();
};

const dashboard = function(search) {
  var query = {};
  $("#start_date").on('change', function(e) {
    query.start = e.target.value;
  });
  $("#end_date").on('change', function(e) {
    query.end = e.target.value;
  });
  $("#filter").on('click', function () {
    var start = query.start ? query.start : search.start != 'null' ? search.start : 'null';
    var end = query.end ? query.end : search.end != 'null' ? search.end : 'null';
    if (lang == 'en') {
      var url = "/dashboard-search?start=";
    } else {
      var url = "/no/dashboard-sok?start=";
    }
    setTimeout(function () {
      window.location = url + start + "&end=" + end;
    }, 50);
  });
  var init = function() {
    $("#start_date").datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'mm/dd/yyyy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-18',
      defaultDate: new Date()
    });
    $("#end_date").datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'mm/dd/yyyy',
      changeMonth: true,
      changeYear: true,
      yearRange: '-110:-18',
      defaultDate: new Date()
    });
    if (search.start != null) {
      $("#start_date").val(search.start);
    }
    if (search.end != null) {
      $("#end_date").val(search.end);
    }
  };
  init();
};

const categories = function () {
  var init = function () {
    $('#example').DataTable({
      rowReorder: true,
      responsive: true,
      "aaSorting": [],
      "initComplete": function(settings, json) {
        $(this).removeClass("no-footer");
      }
    });
  }
  $('#example').on('click', 'tbody td', function() {
    if (!$(this).hasClass('dtr-control')) {
      const id = $(this).parent().children('td').eq(0).children('p').data('id');
      const url = lang == 'en' ? `/edit-category/${id}` : `/no/rediger-kategori/${id}`;
      window.location = url;
    }
  });
  init();
};
const createCategory = function () {
  var init = function () {
    $("label .avatar").css('background-image', "url('images/file-up.png')");
  }
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/member_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#avatar").val(e.url);
          $("label .avatar").css('background-image', "url(" + e.url  + ")");
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#profile_save").on('click', function () {
    var category = {
      category_name: $("#category_name").val(),
      category_name_no: $("#category_name_no").val(),
      category_url: $("#category_url").val(),
      category_description: $("#category_description").val(),
      category_description_no: $("#category_description_no").val(),
      select_file: $("#avatar").attr('src'),
      vat: $("#category_vat").val(),
      type: "profile"
    };
    $.ajax({
      url: '/api/create_category',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: category,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (!status) {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          $("#hidden_id").val(id);
          alert("Category updated successfully");
        }
      }
    });
  });
  $("#meta_save").on('click', function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: 'meta'
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/api/create_category',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: meta_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (!status) {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            alert("Meta data updated successfully");
          }
        }
      });
    } else {
      alert("please complete profile setting first.");
    }
  });
  init();
};
const editCategory = function (category) {
  var init = function () {
    const url = category.category_icon != null ? category.category_icon : 'images/file-up.png';
    $("label .avatar").css('background-image', "url(" + url  + ")");
  };
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/member_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#avatar").val(e.url);
          $("label .avatar").css('background-image', "url(" + e.url  + ")");
          $("label .avatar").css('background-size', 'cover');
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#image_save").on('click', function () {
    var data = {
      select_file: $("#avatar").attr('src'),
      hidden_id: category.id,
      type: 'image'
    };
    $.ajax({
      url: '/api/update_category',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: data,
      dataType: 'JSON',
      success: function (data) {
        alert("Pages updated successfully");
      }
    });
  });

  $("#profile_save").on('click', function () {
    var temp = {
      category_name: $("#category_name").val(),
      category_name_no: $("#category_name_no").val(),
      category_url: $("#category_url").val(),
      category_description: $("#category_description").val(),
      category_description_no: $("#category_description_no").val(),
      vat: $("#category_vat").val(),
      hidden_id: category.id,
      type: "profile"
    };
    $.ajax({
      url: '/api/update_category',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: temp,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Category updated successfully");
        }
      }
    });
  });

  $("#meta_save").on('click', function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: category.id,
      type: 'meta'
    };
    $.ajax({
      url: '/api/update_category',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (!status) {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta data updated successfully");
        }
      }
    });
  });
  init();
};

const consultants = function (consultants) {
  var init = function () {
    $('#example').DataTable({
      rowReorder: true,
      responsive: true,
      "aaSorting": [],
      "initComplete": function(settings, json) {
        $(this).removeClass("no-footer");
      }
    });
  }
  $("#example tbody tr").each(function(key) {
    $(this).find('td').addClass('table-item');
    $(this).find('td').eq(0).addClass('table-item avatar');
    const url = consultants[key].profile && consultants[key].profile.avatar != null ? consultants[key].profile.avatar : 'images/white-logo.svg';
    $(this).find('td').eq(0).children().children('.avatar').css('background-image', "url(" + url  + ")");
    const sizeCss = consultants[key].profile && consultants[key].profile.avatar != null ? 'cover' : '20px 20px';
    $(this).find('td').eq(0).children().children('.avatar').css('background-size', sizeCss);
  });
  $('#example').on('click', 'tbody td', function(event) {
    if ($(this).index() != 3 && !$(this).hasClass('dtr-control')) {
      const id = $(this).parent().children('td').eq(1).children('p').data('id');
      const url = lang == 'en' ? `/edit-consultant/${id}` : `/no/rediger-konsulent/${id}`;
      if (event.target.className == "") {
        window.location = url;
      }
    } else {
      return;
    }
  });
  $('#example').on('change', "input[name='active']", function () {
    var $top_el = $(this).parent().parent();
    var $parent = $(this).parent();
    $top_el.children('label').removeClass('active');
    $parent.addClass('active');
    if ($("input[name='active']:checked").val() == 1) {
      $top_el.addClass('active');
    } else {
      $top_el.removeClass('active');
    }
    var id = $(this).data('id');
    var data = {
      value: $("input[name='active']:checked").val(),
      hidden_id: id,
      type: "activate"
    };
    $.ajax({
      url: '/api/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data,
      dataType: 'JSON',
      success: function (res) {
        alert("Updated successfully");
      }
    });
  });
  init();
};
const editConsultant = function (consultant) {
  var selected_timezone = "";
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/member_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#avatar").val(e.url);
          $("label .avatar").css('background-image', "url(" + e.url  + ")");
          $("label .avatar").css('background-size', 'cover');
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#image_save").on('click', function () {
    var data = {
      prof_img: $("#avatar").attr('src'),
      hidden_id: consultant.id,
      type: 'image'
    };
    $.ajax({
      url: '/api/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: data,
      dataType: 'JSON',
      success: function (data) {
        alert("Pages updated successfully");
      }
    });
  });
  $("#profile_save").on('click', function () {
    var profile = {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      phone: $("#phone").val(),
      hidden_id: consultant.user_id,
      type: 'profile'
    };
    $.ajax({
      url: '/api/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: profile,
      dataType: 'JSON',
      success: function (data) {
        if (data.status == true) {
          alert("Pages updated successfully.");
        } else {
          alert("Error is occured.");
          console.log(data.errors);
        }
      }
    });
  });
  $("#contact_save").on('click', function () {
    var contact = {
      phone_contact: $('#phone_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      chat_contact: $('#chat_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      video_contact: $('#video_checkbox:checkbox:checked').length > 0 ? 1 : 0,
      hidden_id: consultant.user_id,
      type: "contact"
    };
    $.ajax({
      url: '/api/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: contact,
      dataType: 'JSON',
      success: function (data) {
        alert("Updated successfully");
      }
    });
  });
  $("#password_save").on('click', function () {
    var password_info = {
      old_password: $("#old_password").val(),
      new_password: $("#new_password").val(),
      hidden_id: consultant.user_id,
      type: 'password'
    };

    $.ajax({
      url: '/api/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: password_info,
      dataType: 'JSON',
      success: function (data) {
        if (!data.status) {
          $("#old_password_error").attr('style', 'display: block;');
          $("#old_password_error").text('Enter the previous password correctly');
        } else {
          alert("Updated successfully");
        }
      }
    });
  });
  $(".btn-date-picker").on('click', function () {
    $(".date-picker").open();
  });
  $('#timezone').on('change', function (e) {
    selected_timezone = $(this).find(':selected').data('offset');
  });
  $("#private_save").on('click', function () {
    var data = {
      birth: $datepicker.value(),
      gender: $("#gender").val(),
      street: $("#street").val(),
      zip_code: $("#zip_code").val(),
      gmt: `(GMT ${selected_timezone})`,
      timezone: $("#timezone").val(),
      from: $("#from").val(),
      country: $("#country").val(),
      region: $("#region").val(),
      hidden_id: consultant.id,
      type: 'private'
    };
    $.ajax({
      url: '/api/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data,
      dataType: 'JSON',
      success: function (data) {
        if (data.status == true) {
          alert("Pages updated successfully.");
        } else {
          alert("Error is occured.");
          console.log(data.errors);
        }
      }
    });
  });
  $("#company_save").on('click', function () {
    var data = {
      company_name: $("#company_name").val(),
      organization_number: $("#org_number").val(),
      bank_account: $("#bank_account").val(),
      first_name: $("#cfirst_name").val(),
      last_name: $("#clast_name").val(),
      address: $("#company_address").val(),
      country: $("#company_from").val(),
      zip_place: $("#company_region").val(),
      zip_code: $("#czip_code").val(),
      hidden_id: consultant.id,
      type: 'company'
    };
    $.ajax({
      url: '/api/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data,
      dataType: 'JSON',
      success: function (data) {
        if (data.status == true) {
          alert("Pages updated successfully.");
        } else {
          alert("Error is occured.");
          console.log(data.errors);
        }
      }
    });
  });
  $("#consultant_pro_save").on('click', function () {
    var data = {
      profession: $("#profession").val(),
      hourly_rate: $("#rate").val(),
      currency: $("#currency").val(),
      description: $("#consultant_introduction").val(),
      hidden_id: consultant.id,
      type: 'consultant_pro'
    };
    $.ajax({
      url: '/api/update_consultant',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data,
      dataType: 'JSON',
      success: function (data) {
        if (data.status == true) {
          alert("Pages updated successfully.");
        } else {
          alert("Error is occured.");
          console.log(data.errors);
        }
      }
    });
  });
  var init = () => {
    const default_date = consultant.profile.birth ? consultant.profile.birth : `01/01/${moment().year()-15}`;
    $datepicker = $(".date-picker").datepicker({
      showOtherMonths: true,
      selectOtherMonths: true,
      format: 'mm/dd/yyyy',
      changeMonth: true,
      changeYear: true,
      maxDate: function() {
        var date_str = moment().year()-15 + "-12-31";
        return moment(date_str).toDate();
      },
      value: default_date
    });
    $("#consultant_introduction").summernote({height: 200});
    $("#timezone").timezones();
    if (consultant.profile && consultant.profile.description) {
      $("#consultant_introduction").summernote('code', consultant.profile.description);
    }
    if (consultant.profile && consultant.profile.timezone) {
      $("#timezone").val(consultant.profile.timezone);
    }
    const url = consultant.profile && consultant.profile.avatar != null ? consultant.profile.avatar : 'images/file-up.png';
    $("label .avatar").css('background-image', "url(" + url  + ")");
  };
  init();
};

const customers = function (customers) {
  var init = function () {
    $('#example').DataTable({
      rowReorder: true,
      responsive: true,
      "aaSorting": [],
      "initComplete": function(settings, json) {
        $(this).removeClass("no-footer");
      }
    });
  }
  $("#example tbody tr").each(function(key) {
    $(this).find('td').addClass('table-item');
    $(this).find('td').eq(0).addClass('table-item avatar');
    const url = customers[key].profile && customers[key].profile.avatar != null ? customers[key].profile.avatar : 'images/white-logo.svg';
    $(this).find('td').eq(0).children().children('.avatar').css('background-image', "url(" + url  + ")");
    const sizeCss = customers[key].profile && customers[key].profile.avatar != null ? 'cover' : '20px 20px';
    $(this).find('td').eq(0).children().children('.avatar').css('background-size', sizeCss);
  });
  $('#example').on('click', 'tbody td', function() {
    if (!$(this).hasClass('dtr-control')) {
      const id = $(this).parent().children('td').eq(1).children('p').data('id');
      const url = lang == 'en' ? `/edit-customer/${id}` : `/no/rediger-kunde/${id}`;
      window.location = url;
    }
  });
  init();
};
const createCustomer = function () {
  var init = function () {
    $("label .avatar").css('background-image', "url('images/file-up.png')");
  };
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/member_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#avatar").val(e.url);
          $("label .avatar").css('background-image', "url(" + e.url  + ")");
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#profile_save").on('click', function () {
    var profile = {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      email: $("#email").val(),
      phone: $("#phone").val(),
      prof_image: $("#avatar").val(),
      password: $("#password").val(),
      type: 'profile'
    };
    $.ajax({
      url: '/api/create_customer',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: profile,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          $("#hidden_id").val(id);
          $("#profile_save").prop("disabled", true);
          alert("A customer is added successfully");
        }
      }
    });
  });
  $("#invoice_save").on('click', function () {
    var invoice = {
      company_name: $("#company_name").val(),
      invoice_mail: $("#invoice_mail").val(),
      invoice_first_name: $("#company_first_name").val(),
      invoice_last_name: $("#company_last_name").val(),
      address: $("#address").val(),
      zip_code: $("#zip_code").val(),
      zip_place: $("#zip_place").val(),
      hidden_id: $("#hidden_id").val(),
      type: "invoice"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/api/create_customer',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: invoice,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            $("#company_name_error").hide();
            $("#invoice_mail_error").hide();
            $("#company_first_name_error").hide();
            $("#company_last_name_error").hide();
            $("#address_error").hide();
            $("#zip_code_error").hide();
            $("#zip_place_error").hide();
            alert("Updated successfully");
          }
        }
      });
    } else {
      alert("Please save page setting first");
    }

  });
  $("#password_save").on('click', function () {
    var password_info = {
      confirm_password: $("#confirm_password").val(),
      password: $("#password").val(),
      hidden_id: $("#hidden_id").val(),
      type: "password"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/api/create_customer',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: password_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 1) {
            $("#confirm_password_error").show();
            $("#confirm_password_error").text('Enter Correct Password');
          } else {
            $("#confirm_password_error").hide();
            $("#password_error").hide();
            alert("Updated successfully");
          }
        }
      });
    } else {
      alert("Please save page setting first");
    }
  });
  init();
};
const editCustomer = function (customer) {
  var init = function () {
    const url = customer.profile && customer.profile.avatar != null ? customer.profile.avatar : 'images/file-up.png';
    $("label .avatar").css('background-image', "url(" + url  + ")");
  };
  $("#upload_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/member_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#avatar").val(e.url);
          $("label .avatar").css('background-image', "url(" + e.url  + ")");
          $("label .avatar").css('background-size', 'cover');
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#image_save").on('click', function () {
    var data = {
      prof_img: $("#avatar").val(),
      hidden_id: customer.id,
      type: 'image'
    };
    $.ajax({
      url: '/api/update_customer',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: data,
      dataType: 'JSON',
      success: function (data) {
        alert("Pages updated successfully");
      }
    });
  });
  $("#profile_save").on('click', function () {
    var profile = {
      first_name: $("#first_name").val(),
      last_name: $("#last_name").val(),
      phone: $("#phone").val(),
      hidden_id: customer.user_id,
      type: 'profile'
    };
    $.ajax({
      url: '/api/update_customer',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: profile,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#first_name_error").hide();
            $("#last_name_error").hide();
            $("#email_error").hide();
            $("#phone_error").hide();
            alert("Pages updated successfully");
          }
        }
      }
    });
  });
  $("#password_save").on('click', function () {
    var password_info = {
      old_password: $("#old_password").val(),
      new_password: $("#new_password").val(),
      hidden_id: customer.user_id,
      type: 'password'
    };

    $.ajax({
      url: '/api/update_customer',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: password_info,
      dataType: 'JSON',
      success: function (data) {
        status = JSON.stringify(data['status']);
        if (status == 1) {
          $("#old_password_error").attr('style', 'display: block;');
          $("#old_password_error").text('Enter the previous password correctly');
        } else {
          alert("Updated successfully");
        }
      }
    });
  });
  init();
};

const page = function () {
  var init = function () {
    $('#example').DataTable({
      rowReorder: true,
      responsive: true,
      "aaSorting": [],
      "initComplete": function(settings, json) {
        $(this).removeClass("no-footer");
      }
    });
  }
  $('#example').on('click', 'tbody td', function() {
    if (!$(this).hasClass('dtr-control')) {
      const id = $(this).children('p').data('id');
      const url = lang == 'en' ? `/edit-page/${id}` : `/no/rediger-side/${id}`;
      window.location = url;
    }
  });
  init();
};
const createPage = function () {
  $("#page_save").on('click', function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      type: "page"
    };
    if ($("#hidden_id").val() == '') {
      $.ajax({
        url: '/api/create_page',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: page_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            var id = JSON.stringify(data['id']);
            if (id != '') {
              $("#hidden_id").val(id);
              alert("Page is created successfully");
            }
          }
        }
      });
    } else {
      var page_info = {
        page_name: $("#page_name").val(),
        page_url: $("#page_url").val(),
        hidden_id: $("#hidden_id").val(),
        type: "page"
      };
      $.ajax({
        url: '/api/update_page',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: page_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            alert("Updated successfully");
          }
        }
      });
    }
  });
  $("#page_body_save").on('click', function () {
    var body_info = {
      page_body: $("#page_body").summernote('code'),
      hidden_id: $("#hidden_id").val(),
      type: "page_body"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/api/create_page',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: body_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            $("#hidden_id").val(data['id']);
            alert("Page Body updated successfully");
          }
        }
      });
    } else {
      alert("Complete page setting first!");
    }
  });
  $("#meta_save").on('click', function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    if ($("#hidden_id").val() != '') {
      $.ajax({
        url: '/api/create_page',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: meta_info,
        dataType: 'JSON',
        success: function (data) {
          var status = JSON.stringify(data['status']);
          if (status == 'false') {
            $.each(data.errors, function (index, value) {
              $("#" + index + "_error").show();
              $("#" + index + "_error").text(value[0]);
            });
          } else {
            alert("Meta Data updated successfully");
            $("#meta_title_error").hide();
            $("#meta_description_error").hide();
          }
        }
      });
    } else {
      alert("Complete page setting first!");
    }
  });
  var init = function () {
    $("#page_body").summernote({ height: 300 });
  };
  init();
};
const editPage = function () {
  $("#page_save").on('click', function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      hidden_id: $("#hidden_id").val(),
      type: "page"
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: page_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  $(".banner_desktop_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    formdata.append('id', $("#hidden_id").val());
    formdata.append('type', "desktop");
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_banner_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        alert("Banner Image is uploaded successfully.");
      }
    });
  });
  $(".banner_mobile_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    formdata.append('id', $("#hidden_id").val());
    formdata.append('type', "mobile");
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_banner_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        alert("Banner Image is uploaded successfully.");
      }
    });
  });
  //Home page functions
  $("#en_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "en_header",
      page_body: {
        "title": $("#header_en_title").val(),
        "description": $("#header_en_description").val(),
        "button_title1": $("#header_en_button1").val(),
        "button_link1": $("#header_en_button_link1").val(),
        "button_title2": $("#header_en_button2").val(),
        "button_link2": $("#header_en_button_link2").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Header English part is updated successfully");
      }
    });
  });
  $("#no_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "no_header",
      page_body: {
        "title": $("#header_no_title").val(),
        "description": $("#header_no_description").val(),
        "button_title1": $("#header_no_button1").val(),
        "button_link1": $("#header_no_button_link1").val(),
        "button_title2": $("#header_no_button2").val(),
        "button_link2": $("#header_no_button_link2").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Header Norwegian part is updated successfully");
      }
    });
  });
  $(".help_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('id');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_home_help_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#help_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#home_help_add").on('click', function () {
    var key = $(".help-group .panel").length;
    var new_item = "<div class='panel panel-default' id='home_help_panel" + key + "'><a class='remove_help_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#help_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='help_en_title" + key + "'></div></div>";
    new_item += "<div id='help_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='help_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='help_path" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='help_en_des" + key + "'></textarea><br><label>Title (Norwegian)</label><input type='text' id='help_no_title" + key + "'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='help_no_des" + key + "'></textarea><br><label>Button Link</label><input type='text' id='help_button_link" + key + "'><br><label>Button Title (English)</label><input type='text' id='help_en_btn_title" + key + "'><br><label>Button Title (Norwegian)</label><input type='text' id='help_no_btn_title" + key + "'></div></div></div>";
    $(".help-group").append(new_item);
  });
  $("#home_help_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "help_list",
      page_body: []
    };
    var count = $(".help-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#help_path" + i).val(),
        en_title: $("#help_en_title" + i).val(),
        no_title: $("#help_no_title" + i).val(),
        en_des: $("#help_en_des" + i).val(),
        no_des: $("#help_no_des" + i).val(),
        button_link: $("#help_button_link" + i).val(),
        en_button_title: $("#help_en_btn_title" + i).val(),
        no_button_title: $("#help_no_btn_title" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.help-group').on('click', '.remove_help_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "help_list",
      page_body: []
    };
    var key = $(this).data('key');
    $('#home_help_panel' + key).remove();
    var count = $(".help-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#help_path" + i).val(),
        en_title: $("#help_en_title" + i).val(),
        no_title: $("#help_no_title" + i).val(),
        en_des: $("#help_en_des" + i).val(),
        no_des: $("#help_no_des" + i).val(),
        button_link: $("#help_button_link" + i).val(),
        en_button_title: $("#help_en_btn_title" + i).val(),
        no_button_title: $("#help_no_btn_title" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".benefit_title_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "benefit_title",
      page_body: {
        en: $("#en_benefit_title").val(),
        no: $("#no_benefit_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Consult Available part is updated successfully");
      }
    });
  });
  $(".icon_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_home_benefit_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#benefit_icon" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#home_benefit_add").on('click', function () {
    var key = $(".benefit-group .panel").length;
    var new_item = "<div class='panel panel-default' id='home_benefit_panel" + key + "'><a class='remove_benefit_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#benefit_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='benefit_en_title'><br></div></div>";
    new_item += "<div id='benefit_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='icon_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='benefit_icon" + key + "'><label>Title (Norwegian)</label><input type='text' id='benefit_no_title" + key + "'><br><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='benefit_en_des" + key + "'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='benefit_no_des" + key + "'></textarea></div></div></div>";
    $(".benefit-group").append(new_item);
  });
  $("#home_benefit_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "benefit_arr",
      page_body: []
    };
    var count = $(".benefit-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#benefit_icon" + i).val(),
        en_title: $("#benefit_en_title" + i).val(),
        no_title: $("#benefit_no_title" + i).val(),
        en_des: $("#benefit_en_des" + i).val(),
        no_des: $("#benefit_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.benefit-group').on('click', '.remove_benefit_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "benefit_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#home_benefit_panel' + key).remove();
    var count = $(".benefit-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#benefit_icon" + i).val(),
        en_title: $("#benefit_en_title" + i).val(),
        no_title: $("#benefit_no_title" + i).val(),
        en_des: $("#benefit_en_des" + i).val(),
        no_des: $("#benefit_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".review_title_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_title",
      page_body: {
        en: $("#en_review_title").val(),
        no: $("#no_review_title").val()
      }
    };
    console.log(body_info);
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Review Title is updated successfully");
      }
    });
  });
  $(".user_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_home_review_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#review_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#home_footer_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "footer",
      page_body: {
        "en_title": $("#home_footer_en_title").val(),
        "no_title": $("#home_footer_no_title").val(),
        "en_des": $("#home_footer_en_des").val(),
        "no_des": $("#home_footer_no_des").val(),
        "en_btn_title1": $("#home_footer_en_btn_title1").val(),
        "en_btn_link1": $("#home_footer_en_btn_link1").val(),
        "no_btn_title1": $("#home_footer_no_btn_title1").val(),
        "no_btn_link1": $("#home_footer_no_btn_link1").val(),
        "en_btn_title2": $("#home_footer_en_btn_title2").val(),
        "en_btn_link2": $("#home_footer_en_btn_link2").val(),
        "no_btn_title2": $("#home_footer_no_btn_title2").val(),
        "no_btn_link2": $("#home_footer_no_btn_link2").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // Category single page functions
  $(".category_title_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "category_title",
      page_body: {
        "en": $("#en_category_title").val(),
        "no": $("#no_category_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $(".cat_review_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_home_review_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#cat_review_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#cat_review_add").on('click', function () {
    var key = $(".cat-review-group .panel").length;
    var new_item = "<div class='panel panel-default' id='cat_review_panel" + key + "'><a class='remove_review_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#cat_review_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='cat_author" + key + "'></div></div>";
    new_item += "<div id='cat_review_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='cat_review_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='cat_review_path" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='cat_review_en_des" + key + "'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='cat_review_no_des" + key + "'></textarea></div></div></div>";
    $(".cat-review-group").append(new_item);
  });
  $("#cat_review_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_arr",
      page_body: []
    };
    var count = $(".cat-review-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#cat_review_path" + i).val(),
        en_des: $("#cat_review_en_des" + i).val(),
        no_des: $("#cat_review_no_des" + i).val(),
        name: $("#cat_author" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.cat-review-group').on('click', '.remove_review_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#cat_review_panel' + key).remove();
    var count = $(".cat-review-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#cat_review_path" + i).val(),
        en_des: $("#cat_review_en_des" + i).val(),
        no_des: $("#cat_review_no_des" + i).val(),
        name: $("#cat_author" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // Become consultant page functions
  $(".main_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#platform_main_image").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".consultant_platform_title_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "platform_title",
      page_body: {
        "en": $("#en_platform_title").val(),
        "no": $("#no_platform_title").val(),
        "plat_img": $("#platform_main_image").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $(".become_consult_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#become_consult_icon" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#platform_add").on('click', function () {
    var key = $(".platform-group .panel").length;
    var new_item = "<div class='panel panel-default' id='platform_panel" + key + "'><a class='remove_plat_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#plat_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='en_platform_item_title" + key + "'></div></div>";
    new_item += "<div id='plat_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='become_consult_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='become_consult_icon" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='en_platform_des" + key + "'></textarea><br><label>Title (Norwegian)</label><input type='text' id='no_platform_item_title" + key + "'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_platform_des" + key + "'></textarea></div></div></div>";
    $(".platform-group").append(new_item);
  });
  $("#become_plat_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "become_consult_arr",
      page_body: []
    };
    var count = $(".platform-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#become_consult_icon" + i).val(),
        en_txt: $("#en_platform_des" + i).val(),
        no_txt: $("#no_platform_des" + i).val(),
        en_title: $("#en_platform_item_title" + i).val(),
        no_title: $("#no_platform_item_title" + i).val(),
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.platform-group').on('click', '.remove_plat_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "become_consult_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#platform_panel' + key).remove();
    var count = $(".platform-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        icon: $("#become_consult_icon" + i).val(),
        en_des: $("#en_platform_des" + i).val(),
        no_des: $("#no_platform_des" + i).val(),
        en_title: $("#en_platform_item_title" + i).val(),
        no_title: $("#no_platform_item_title" + i).val(),
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".become_review_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_home_review_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#become_review_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#become_review_add").on('click', function () {
    var key = $(".become-review-group .panel").length;
    var new_item = "<div class='panel panel-default' id='become_review_panel" + key + "'><a class='remove_review_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#become_review_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='become_author" + key + "'></div></div>";
    new_item += "<div id='become_review_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='become_review_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='become_review_path" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='become_review_en_des" + key + "'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='become_review_no_des" + key + "'></textarea></div></div></div>";
    $(".become-review-group").append(new_item);
  });
  $("#become_review_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_arr",
      page_body: []
    };
    var count = $(".become-review-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#become_review_path" + i).val(),
        en_des: $("#become_review_en_des" + i).val(),
        no_des: $("#become_review_no_des" + i).val(),
        name: $("#become_author" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.become-review-group').on('click', '.remove_review_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "review_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#become_review_panel' + key).remove();
    var count = $(".become-review-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#become_review_path" + i).val(),
        en_des: $("#become_review_en_des" + i).val(),
        no_des: $("#become_review_no_des" + i).val(),
        name: $("#become_author" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".become_register_title_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "register_title",
      page_body: {
        "en": $("#en_become_register_title").val(),
        "no": $("#no_become_register_title").val(),
        "en_des": $("#en_become_register_des_title").val(),
        "no_des": $("#no_become_register_des_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $("#become_register_add").on('click', function () {
    var key = $(".become-register-group .panel").length;
    var new_item = "<div class='panel panel-default' id='become_register_panel" + key + "'><a class='remove_register_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#become_register_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span></div></div>";
    new_item += "<div id='become_register_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='en_become_register_des" + key + "'></textarea><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_become_register_des" + key + "'></textarea></div></div></div>";
    $(".become-register-group").append(new_item);
  });
  $("#become_register_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "register_arr",
      page_body: []
    };
    var count = $(".become-register-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_des: $("#en_become_register_des" + i).val(),
        no_des: $("#no_become_register_des" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.become-register-group').on('click', '.remove_register_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "register_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#become_register_panel' + key).remove();
    var count = $(".become-register-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_des: $("#en_become_register_des" + i).val(),
        no_des: $("#no_become_register_des" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // About us page functions
  $(".article_title_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "article_title",
      page_body: {
        "en": $("#en_article_title").val(),
        "no": $("#no_article_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $(".article_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#article_icon" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#about_article_add").on('click', function () {
    var key = $(".article-group .panel").length;
    var new_item = "<div class='panel panel-default' id='about_article_panel" + key + "'><a class='remove_article_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#article_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='article_en_title" + key + "'></div></div>";
    new_item += "<div id='article_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='article_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='article_icon" + key + "'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='article_en_des" + key + "'></textarea><br><label>Title (Norwegian)</label><input type='text' id='article_no_title" + key + "'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='article_no_des" + key + "'></textarea></div></div></div>";
    $(".article-group").append(new_item);
  });
  $("#about_article_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "article_arr",
      page_body: []
    };
    var count = $(".article-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        icon: $("#article_icon" + i).val(),
        en_title: $("#article_en_title" + i).val(),
        no_title: $("#article_no_title" + i).val(),
        en_des: $("#article_en_des" + i).val(),
        no_des: $("#article_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.article-group').on('click', '.remove_article_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "article_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#about_article_panel' + key).remove();
    var count = $(".article-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        icon: $("#article_icon" + i).val(),
        en_title: $("#article_en_title" + i).val(),
        no_title: $("#article_no_title" + i).val(),
        en_des: $("#article_en_des" + i).val(),
        no_des: $("#article_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".story_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#story_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#about_story_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "story",
      page_body: {
        "en_part_title": $("#en_part_title").val(),
        "no_part_title": $("#no_part_title").val(),
        "en_title": $("#en_story_title").val(),
        "no_title": $("#no_story_title").val(),
        "en_des": $("#en_story_des").val(),
        "no_des": $("#no_story_des").val(),
        "path": $("#story_path").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Story part is updated successfully");
      }
    });
  });
  $(".team_member_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#team_member_avatar" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".about_team_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "team_title",
      page_body: {
        "en_part_title": $("#en_team_part_title").val(),
        "no_part_title": $("#no_team_part_title").val(),
        "en_title": $("#en_team_title").val(),
        "no_title": $("#no_team_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Team header is updated successfully");
      }
    });
  });
  $("#about_team_add").on('click', function () {
    var key = $(".team-group .panel").length;
    var new_item = "<div class='panel panel-default' id='about_team_panel" + key + "'><a class='remove_team_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#team_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='team_name" + key + "'></div></div>";
    new_item += "<div id='team_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='team_member_file' data-id='" + key + "' accept='image/*'><br><input type='hidden' id='team_member_avatar" + key + "'><label>Job (English)</label><input type='text' id='en_team_job" + key + "'><br><label>Job (Norwegian)</label><input type='text' id='no_team_job" + key + "'><br><label>Bio (English)</label><textarea rows='5' cols='150' class='form-control' id='en_team_bio" + key + "'></textarea><br><label>Bio (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='no_team_bio" + key + "'></textarea></div></div></div>";
    $(".team-group").append(new_item);
  });
  $("#about_team_member_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "team_arr",
      page_body: []
    };
    var count = $(".team-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        avatar: $("#team_member_avatar" + i).val(),
        name: $("#team_member_name" + i).val(),
        en_bio: $("#en_team_bio" + i).val(),
        no_bio: $("#no_team_bio" + i).val(),
        en_job: $("#en_team_job" + i).val(),
        no_job: $("#no_team_job" + i).val(),
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.team-group').on('click', '.remove_team_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "team_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#about_team_panel' + key).remove();
    var count = $(".team-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        avatar: $("#team_member_avatar" + i).val(),
        name: $("#team_member_name" + i).val(),
        en_bio: $("#en_team_bio" + i).val(),
        no_bio: $("#no_team_bio" + i).val(),
        en_job: $("#en_team_job" + i).val(),
        no_job: $("#no_team_job" + i).val(),
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".about_get_started_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "get_started_title",
      page_body: {
        en: $("#en_get_started_title").val(),
        no: $("#no_get_started_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Get started part is updated successfully");
      }
    });
  });
  $("#about_started_add").on('click', function () {
    var key = $(".started-group .panel").length;
    var new_item = "<div class='panel panel-default' id='about_started_panel" + key + "'><a class='remove_started_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#started_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='started_en_title" + key + "'></div></div>";
    new_item += "<div id='started_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='started_en_des" + key + "'></textarea><br><label>Title (Norwegian)</label><input type='text' id='started_no_title" + key + "'><br><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='started_no_des" + key + "'></textarea></div></div></div>";
    $(".started-group").append(new_item);
  });
  $("#about_started_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "get_started_arr",
      page_body: []
    };
    var count = $(".started-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_title: $("#started_en_title" + i).val(),
        no_title: $("#started_no_title" + i).val(),
        en_des: $("#started_en_des" + i).val(),
        no_des: $("#started_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.started-group').on('click', '.remove_started_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "get_started_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#about_started_panel' + key).remove();
    var count = $(".started-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_title: $("#started_en_title" + i).val(),
        no_title: $("#started_no_title" + i).val(),
        en_des: $("#started_en_des" + i).val(),
        no_des: $("#started_no_des" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // Register page functions
  $("#register_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "en_des": $("#register_header_en_des").val(),
        "no_des": $("#register_header_no_des").val(),
        "en_title": $("#register_header_en_title").val(),
        "no_title": $("#register_header_no_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Register header part is updated successfully");
      }
    });
  });
  $(".register_item_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#register_item_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#register_list_add").on('click', function () {
    var key = $(".register-item-group .panel").length;
    var new_item = "<div class='panel panel-default' id='register_panel" + key + "'><a class='remove_register_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#reg_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='register_item_en_text" + key + "'></div></div>";
    new_item += "<div id='reg_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='register_item_file' data-key='" + key + "' accept='image/*'><br><input type='hidden' id='register_item_path" + key + "'><label>Title (Norwegian)</label><input type='text' id='register_item_no_title" + key + "'><label>Text (English)</label><input type='text' id='register_item_en_text" + key + "'><label>Text (Norwegian)</label><input type='text' id='register_item_no_text" + key + "'></div></div></div>";
    $(".register-item-group").append(new_item);
  });
  $('.register-item-group').on('click', '.remove_register_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "list",
      page_body: []
    };
    var key = $(this).data('key');
    $('#register_panel' + key).remove();
    var count = $(".register-item-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#register_item_path" + i).val(),
        en_title: $("#register_item_en_title" + i).val(),
        no_title: $("#register_item_no_title" + i).val(),
        en_txt: $("#register_item_en_text" + i).val(),
        no_txt: $("#register_item_no_text" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("List item is updated successfully");
      }
    });
  });
  $("#register_item_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "list",
      page_body: []
    };
    var count = $(".register-item-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#register_item_path" + i).val(),
        en_title: $("#register_item_en_title" + i).val(),
        no_title: $("#register_item_no_title" + i).val(),
        en_txt: $("#register_item_en_text" + i).val(),
        no_txt: $("#register_item_no_text" + i).val()
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("List item is updated successfully");
      }
    });
  });
  //Login page functions
  $(".login_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#login_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#login_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "path": $("#login_path").val(),
        "en_des": $("#login_header_en_des").val(),
        "no_des": $("#login_header_no_des").val(),
        "en_title": $("#login_header_en_title").val(),
        "no_title": $("#login_header_no_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Login part is updated successfully");
      }
    });
  });
  $("#meta_save").on('click', function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta Data updated successfully");
          $("#meta_title_error").hide();
          $("#meta_description_error").hide();
        }
      }
    });
  });
  // FAQ page functions
  $(".faq_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#faq_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#faq_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "faq_header",
      page_body: {
        "en_title": $("#faq_header_en_title").val(),
        "no_title": $("#faq_header_no_title").val(),
        "en_des": $("#faq_header_en_des").val(),
        "no_des": $("#faq_header_no_des").val(),
        "path": $("#faq_path").attr('src'),
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Header English part is updated successfully");
      }
    });
  });
  $("#faq_question_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "faq_question_header",
      page_body: {
        "en_title": $("#faq_question_header_en_title").val(),
        "no_title": $("#faq_question_header_no_title").val(),
        "en_msg_title": $("#faq_question_message_en_title").val(),
        "no_msg_title": $("#faq_question_message_no_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Header English part is updated successfully");
      }
    });
  });
  $("#faq_question_add").on('click', function () {
    var key = $(".question-group .panel").length;
    var new_item = "<div class='panel panel-default' id='faq_panel" + key + "'><a class='remove_question_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#faq_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='faq_question_en_que" + key + "'></div></div>";
    new_item += "<div id='faq_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><label>Answer (English)</label><textarea rows='5' cols='150' class='form-control' id='faq_question_en_asw" + key + "'></textarea><br><label>Question (Norwegian)</label><input type='text' id='faq_question_no_que" + key + "'><br><label>Answer (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='faq_question_no_asw" + key + "'></textarea><br></div></div></div>";
    $(".question-group").append(new_item);
  });
  $("#faq_question_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "questions",
      page_body: []
    };
    var count = $(".question-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_que: $("#faq_question_en_que" + i).val(),
        no_que: $("#faq_question_no_que" + i).val(),
        en_asw: $("#faq_question_en_asw" + i).val(),
        no_asw: $("#faq_question_no_asw" + i).val(),
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.question-group').on('click', '.remove_team_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "questions",
      page_body: []
    };
    var key = $(this).data('key');
    $('#faq_panel' + key).remove();
    var count = $(".question-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        en_que: $("#faq_question_en_que" + i).val(),
        no_que: $("#faq_question_no_que" + i).val(),
        en_asw: $("#faq_question_en_asw" + i).val(),
        no_asw: $("#faq_question_no_asw" + i).val(),
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  // Feature page
  $(".service_title_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "service_title",
      page_body: {
        "en_title": $("#en_service_title").val(),
        "no_title": $("#no_service_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
  $(".service_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    var key = $(this).data('key');
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#service_file_path" + key).val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#feature_service_add").on('click', function () {
    var key = $(".service-group .panel").length;
    var new_item = "<div class='panel panel-default' id='feature_service_panel" + key + "'><a class='remove_service_item remove_btn' data-key=" + key + "><svg aria-hidden='true' focusable='false' data-prefix='far' data-icon='trash-alt' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-trash-alt fa-w-14 fa-lg'><path fill='currentColor' d='M268 416h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12zM432 80h-82.41l-34-56.7A48 48 0 0 0 274.41 0H173.59a48 48 0 0 0-41.16 23.3L98.41 80H16A16 16 0 0 0 0 96v16a16 16 0 0 0 16 16h16v336a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128h16a16 16 0 0 0 16-16V96a16 16 0 0 0-16-16zM171.84 50.91A6 6 0 0 1 177 48h94a6 6 0 0 1 5.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0 0 12-12V188a12 12 0 0 0-12-12h-24a12 12 0 0 0-12 12v216a12 12 0 0 0 12 12z'></path></svg></a><div class='panel-heading'><div class='toggle-input' data-toggle='collapse' href='#service_collapse" + key + "'><span class='glyphicon glyphicon-menu-right'></span><input type='text' id='service_en_title" + key + "'></div></div>";
    new_item += "<div id='service_collapse" + key + "' class='panel-collapse collapse'><div class='panel-body'><input type='file' class='service_file' data-key='" + key + "' accept='image/*' /><input type='hidden' id='service_file_path" + key + "'/><label>Title (Norwegian)</label><input type='text' id='service_no_title" + key + "' /><label>Description (English)</label><textarea rows='5' cols='150' class='form-control' id='service_en_des" + key + "'></textarea><label>Description (Norwegian)</label><textarea rows='5' cols='150' class='form-control' id='service_no_des" + key + "'></textarea></div></div></div>";
    $(".service-group").append(new_item);
  });
  $("#feature_service_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "service_arr",
      page_body: []
    };
    var count = $(".service-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#service_file_path" + i).val(),
        en_title: $("#service_en_title" + i).val(),
        no_title: $("#service_no_title" + i).val(),
        en_des: $("#service_en_des" + i).val(),
        no_des: $("#service_no_des" + i).val(),
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $('.service-group').on('click', '.remove_service_item', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "service_arr",
      page_body: []
    };
    var key = $(this).data('key');
    $('#feature_service_panel' + key).remove();
    var count = $(".service-group .panel").length;
    for (let i = 0; i < count; i++) {
      body_info.page_body.push({
        path: $("#service_file_path" + i).val(),
        en_title: $("#service_en_title" + i).val(),
        no_title: $("#service_no_title" + i).val(),
        en_des: $("#service_en_des" + i).val(),
        no_des: $("#service_no_des" + i).val(),
      });
    }
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $(".consultant_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#consultant_file_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".consultant_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "consultant",
      page_body: {
        "path": $("#consultant_file_path").val(),
        "en_title": $("#en_consultant_title").val(),
        "no_title": $("#no_consultant_title").val(),
        "en_des": $("#consultant_en_des").val(),
        "no_des": $("#consultant_no_des").val(),
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Consultant part is updated successfully");
      }
    });
  });
  $(".session_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#session_file_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".session_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "session",
      page_body: {
        "path": $("#session_file_path").val(),
        "en_title": $("#en_session_title").val(),
        "no_title": $("#no_session_title").val(),
        "en_des": $("#session_en_des").val(),
        "no_des": $("#session_no_des").val(),
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("session part is updated successfully");
      }
    });
  });
  $(".wallet_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#wallet_file_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".wallet_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "wallet",
      page_body: {
        "path": $("#wallet_file_path").val(),
        "en_title": $("#en_wallet_title").val(),
        "no_title": $("#no_wallet_title").val(),
        "en_des": $("#wallet_en_des").val(),
        "no_des": $("#wallet_no_des").val(),
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("session part is updated successfully");
      }
    });
  });
  $(".profile_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#profile_file_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".profile_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "profile",
      page_body: {
        "path": $("#profile_file_path").val(),
        "en_title": $("#en_profile_title").val(),
        "no_title": $("#no_profile_title").val(),
        "en_des": $("#profile_en_des").val(),
        "no_des": $("#profile_no_des").val(),
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("session part is updated successfully");
      }
    });
  });
  $(".transaction_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#transaction_file_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $(".transaction_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "transaction",
      page_body: {
        "path": $("#transaction_file_path").val(),
        "en_title": $("#en_transaction_title").val(),
        "no_title": $("#no_transaction_title").val(),
        "en_des": $("#transaction_en_des").val(),
        "no_des": $("#transaction_no_des").val(),
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("session part is updated successfully");
      }
    });
  });
  $(".feature_review_title_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "reviews",
      page_body: {
        "en_title": $("#en_service_title").val(),
        "no_title": $("#no_service_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Explore category title is updated successfully");
      }
    });
  });
};

const editPrivacy = function (en_content, no_content) {
  $("#page_save").on('click', function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      hidden_id: $("#hidden_id").val(),
      type: "page"
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: page_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  $(".privacy_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#privacy_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#privacy_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "path": $("#privacy_path").val(),
        "en_des": $("#privacy_header_en_des").val(),
        "no_des": $("#privacy_header_no_des").val(),
        "en_title": $("#privacy_header_en_title").val(),
        "no_title": $("#privacy_header_no_title").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#privacy_page_body_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "contents",
      page_body: {
        "en": $("#en_privacy_page_body").summernote('code'),
        "no": $("#no_privacy_page_body").summernote('code')
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#meta_save").on('click', function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta Data updated successfully");
          $("#meta_title_error").hide();
          $("#meta_description_error").hide();
        }
      }
    });
  });
  var init = function () {
    $("#en_privacy_page_body").summernote({ height: 300 });
    $("#en_privacy_page_body").summernote('code', en_content);
    $("#no_privacy_page_body").summernote({ height: 300 });
    $("#no_privacy_page_body").summernote('code', no_content);
  };
  init();
};
const editTermsCustomer = function (en_content, no_content) {
  $("#page_save").on('click', function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      hidden_id: $("#hidden_id").val(),
      type: "page"
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: page_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  $(".terms_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#terms_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#terms_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "path": $("#terms_path").val(),
        "en_des": $("#terms_header_en_des").val(),
        "no_des": $("#terms_header_no_des").val(),
        "en_title": $("#terms_header_en_title").val(),
        "no_title": $("#terms_header_no_title").val(),
        "link": $("#terms_header_link").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#terms_page_body_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "contents",
      page_body: {
        "en": $("#en_terms_page_body").summernote('code'),
        "no": $("#no_terms_page_body").summernote('code')
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#meta_save").on('click', function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta Data updated successfully");
          $("#meta_title_error").hide();
          $("#meta_description_error").hide();
        }
      }
    });
  });
  var init = function () {
    $("#en_terms_page_body").summernote({ height: 300 });
    $("#en_terms_page_body").summernote('code', en_content);
    $("#no_terms_page_body").summernote({ height: 300 });
    $("#no_terms_page_body").summernote('code', no_content);
  };
  init();
};
const editTermsProvider = function (en_content, no_content) {
  $("#page_save").on('click', function () {
    var page_info = {
      page_name: $("#page_name").val(),
      page_url: $("#page_url").val(),
      hidden_id: $("#hidden_id").val(),
      type: "page"
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: page_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          var id = JSON.stringify(data['id']);
          if (id != '') {
            $("#category_name_error").hide();
            $("#category_url_error").hide();
            $("#category_description_error").hide();
            alert("Category updated successfully");
          }
        }
      }
    });
  });
  $(".terms_file").on('change', function () {
    var formdata = new FormData();
    formdata.append('file', this.files[0]);
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/api/admin_become_consultant_platform_image_upload',
      data: formdata,
      processData: false,
      contentType: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (e) {
        if (e.status) {
          $("#terms_path").val(e.url);
        } else {
          alert("Error occured in uploading the image.");
        }
      }
    });
  });
  $("#terms_header_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "header",
      page_body: {
        "path": $("#terms_path").val(),
        "en_des": $("#terms_header_en_des").val(),
        "no_des": $("#terms_header_no_des").val(),
        "en_title": $("#terms_header_en_title").val(),
        "no_title": $("#terms_header_no_title").val(),
        "link": $("#terms_header_link").val()
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#terms_page_body_save").on('click', function () {
    var body_info = {
      type: "page_body",
      hidden_id: $("#hidden_id").val(),
      detail_type: "contents",
      page_body: {
        "en": $("#en_terms_page_body").summernote('code'),
        "no": $("#no_terms_page_body").summernote('code')
      }
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: body_info,
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        alert("Updated successfully");
      }
    });
  });
  $("#meta_save").on('click', function () {
    var meta_info = {
      meta_title: $("#meta_title").val(),
      meta_description: $("#meta_description").val(),
      hidden_id: $("#hidden_id").val(),
      type: "meta"
    };
    $.ajax({
      url: '/api/update_page',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: meta_info,
      dataType: 'JSON',
      success: function (data) {
        var status = JSON.stringify(data['status']);
        if (status == 'false') {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else {
          alert("Meta Data updated successfully");
          $("#meta_title_error").hide();
          $("#meta_description_error").hide();
        }
      }
    });
  });
  var init = function () {
    $("#en_terms_page_body").summernote({ height: 300 });
    $("#en_terms_page_body").summernote('code', en_content);
    $("#no_terms_page_body").summernote({ height: 300 });
    $("#no_terms_page_body").summernote('code', no_content);
  };
  init();
};

const settings = function () {
  // mail setting updating
  $("#mail_save").on('click', function () {
    var mail_info = {
      old_mail: $("#old_mail").val(),
      new_mail: $("#new_mail").val(),
      type: 'mail',
      hidden_id: $("#user_id").val()
    };
    $.ajax({
      url: '/api/update_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: mail_info,
      dataType: 'JSON',
      success: function (data) {
        status = JSON.stringify(data['status']);
        if (status == 0) {
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else if (status == 1) {
          $("#old_mail_error").show();
          $("#old_mail_error").text('Enter correct Email address');
        } else if (status == 2) {
          alert("Mail updated successfully");
        } else if (status == 3) {
          $("#new_mail_error").show();
          $("#new_mail_error").text('Email already registered');
        }
      }
    });
  });
  $("#private_save").on('click', function() {
    var mail_info = {
      fee: $("#fee").val(),
      type: 'private',
      hidden_id: $("#user_id").val()
    };
    $.ajax({
      url: '/api/update_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: mail_info,
      dataType: 'JSON',
      success: function (data) {
        alert("Updated successfully");
      }
    });
  });
  //password updating
  $("#password_save").on('click', function () {
    var password_info = {
      old_password: $("#old_password").val(),
      new_password: $("#new_password").val(),
      type: 'password',
      hidden_id: $("#user_id").val()
    };
    $.ajax({
      url: '/api/update_setting',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: password_info,
      dataType: 'JSON',
      success: function (data) {
        status = JSON.stringify(data['status']);
        if (status == 0) {
          $("#old_password_error").show();
          $("#new_password_error").show();
          $.each(data.errors, function (index, value) {
            $("#" + index + "_error").show();
            $("#" + index + "_error").text(value[0]);
          });
        } else if (status == 1) {
          alert("Password updated successfully");
        } else if (status == 2) {
          $("#old_password_error").show();
          $("#old_password_error").text('Enter the password correctly');
        }
      }
    });
  });
};

const transactions = function (data, search) {
  var query = {};
  $(".consultant").on('change', function (e) {
    query.consultant = $(this).val();
  });
  $("#desktop_filter").on('click', function () {
    var date = $('#desktop_date').MonthPicker('GetSelectedMonthYear');
    var consultant = query.consultant ? query.consultant : search.consultant != 'null' ? search.consultant : 'null';
    const url = lang == 'en' ? "/admin-transaction-search?date=" : "/no/admin-transaksjoner-sok?date=";
    setTimeout(function () {
      window.location = url + date + "&consultant=" + consultant;
    }, 50);
  });
  $("#mobile_filter").on('click', function () {
    var date = $('#mobile_date').MonthPicker('GetSelectedMonthYear');
    var consultant = query.consultant ? query.consultant : search.consultant != 'null' ? search.consultant : 'null';
    const url = lang == 'en' ? "/admin-transaction-search?date=" : "/no/admin-transaksjoner-sok?date=";
    setTimeout(function () {
      window.location = url + date + "&consultant=" + consultant;
    }, 50);
  });
  $("#show_filter").on('click', function () {
    if ($(".filter-body").hasClass('active')) {
      $(this).addClass('reversed');
      $(".filter-body").removeClass('active');
    } else {
      $(this).removeClass('reversed');
      $(".filter-body").addClass('active');
    }
  });
  var init = function () {
    $('#transaction').DataTable({
      rowReorder: true,
      responsive: true,
      "aaSorting": [],
      "initComplete": function(settings, json) {
        $(this).removeClass("no-footer");
      }
    });
    $("#desktop_date").MonthPicker({
      MonthFormat: 'M, yy',
      SelectedMonth: search.date,
      ShowIcon: false
    });
    $("#mobile_date").MonthPicker({
      MonthFormat: 'M, yy',
      SelectedMonth: search.date,
      ShowIcon: false
    });
  }
  $("#transaction tbody tr").each(function(key) {
    const payer_img = data[key].payer_img != null ? data[key].payer_img : 'images/white-logo.svg';
    const payer_size = data[key].payer_img != null ? 'cover' : '20px 20px';
    $(this).find('td').eq(0).children().children('.avatar').css('background-image', "url(" + payer_img  + ")");
    $(this).find('td').eq(0).children().children('.avatar').css('background-size', payer_size);
    const receiver_img = data[key].receiver_img != null ? data[key].receiver_img : 'images/white-logo.svg';
    const receiver_size = data[key].receiver_img != null ? 'cover' : '20px 20px';
    $(this).find('td').eq(1).children().children('.avatar').css('background-image', "url(" + receiver_img  + ")");
    $(this).find('td').eq(1).children().children('.avatar').css('background-size', receiver_size);
  });
  $('#transaction').on('click', 'tbody td', function() {
    if (!$(this).hasClass('dtr-control')) {
      const id = $(this).parent().children('td').eq(1).children('p').data('id');
      const url = lang == 'en' ? `/edit-customer/${id}` : `/no/rediger-kunde/${id}`;
      // window.location = url;
    }
  });
  init();
};



const payouts = function (data, search) {
    var query = {};
    $(".consultant").on('change', function (e) {
        query.consultant = $(this).val();
    });
    $("#desktop_filter").on('click', function () {
        var date_from = $('#desktop_date_from').MonthPicker('GetSelectedMonthYear');
        var date_till = $('#desktop_date_till').MonthPicker('GetSelectedMonthYear');
        var consultant = query.consultant ? query.consultant : search.consultant != 'null' ? search.consultant : 'null';
        const url = lang == 'en' ? "/admin-payout-search?date_from=" : "/no/admin-transaksjoner-sok?date_from=";
        setTimeout(function () {
            window.location = url + date_from + '&date_till=' + date_till + "&consultant=" + consultant;
        }, 50);
    });
    $("#mobile_filter").on('click', function () {
        var date = $('#mobile_date').MonthPicker('GetSelectedMonthYear');
        var consultant = query.consultant ? query.consultant : search.consultant != 'null' ? search.consultant : 'null';
        const url = lang == 'en' ? "/admin-payout-search?date_from=" : "/no/admin-transaksjoner-sok?date_from=";
        setTimeout(function () {
            window.location = url + date + "&consultant=" + consultant;
        }, 50);
    });
    $("#show_filter").on('click', function () {
        if ($(".filter-body").hasClass('active')) {
            $(this).addClass('reversed');
            $(".filter-body").removeClass('active');
        } else {
            $(this).removeClass('reversed');
            $(".filter-body").addClass('active');
        }
    });
    var init = function () {
        $('#payout').DataTable({
            rowReorder: true,
            responsive: true,
            "aaSorting": [],
            "initComplete": function(settings, json) {
                $(this).removeClass("no-footer");
            }
        });
        $("#desktop_date_from").MonthPicker({
            MonthFormat: 'M, yy',
            SelectedMonth: search.date_from,
            ShowIcon: false
        });
        $("#desktop_date_till").MonthPicker({
            MonthFormat: 'M, yy',
            SelectedMonth: search.date_till,
            ShowIcon: false
        });
        $("#mobile_date").MonthPicker({
            MonthFormat: 'M, yy',
            SelectedMonth: search.date_till,
            ShowIcon: false
        });
    }
    $("#payout tbody tr").each(function(key) {
        const payer_img = data[key].payer_img != null ? data[key].payer_img : 'images/white-logo.svg';
        const payer_size = data[key].payer_img != null ? 'cover' : '20px 20px';
        $(this).find('td').eq(0).children().children('.avatar').css('background-image', "url(" + payer_img  + ")");
        $(this).find('td').eq(0).children().children('.avatar').css('background-size', payer_size);
        const receiver_img = data[key].receiver_img != null ? data[key].receiver_img : 'images/white-logo.svg';
        const receiver_size = data[key].receiver_img != null ? 'cover' : '20px 20px';
        $(this).find('td').eq(1).children().children('.avatar').css('background-image', "url(" + receiver_img  + ")");
        $(this).find('td').eq(1).children().children('.avatar').css('background-size', receiver_size);
    });
    $('#payout').on('click', 'tbody td', function() {
        if (!$(this).hasClass('dtr-control')) {
            const id = $(this).parent().children('td').eq(1).children('p').data('id');
            const url = lang == 'en' ? `/edit-customer/${id}` : `/no/rediger-kunde/${id}`;
            // window.location = url;
        }
    });
    init();
}; // payouts = function



const invoices = function (data, search) {
    var query = {};
    $(".consultant").on('change', function (e) {
        query.consultant = $(this).val();
    });
    $("#desktop_filter").on('click', function () {
        var date_from = $('#desktop_date_from').MonthPicker('GetSelectedMonthYear');
        var date_till = $('#desktop_date_till').MonthPicker('GetSelectedMonthYear');
        var consultant = query.consultant ? query.consultant : search.consultant != 'null' ? search.consultant : 'null';
        const url = lang == 'en' ? "/admin-invoices-search?date_from=" : "/no/admin-transaksjoner-sok?date_from=";
        setTimeout(function () {
            window.location = url + date_from + '&date_till=' + date_till + "&consultant=" + consultant;
        }, 50);
    });
    $("#mobile_filter").on('click', function () {
        var date = $('#mobile_date').MonthPicker('GetSelectedMonthYear');
        var consultant = query.consultant ? query.consultant : search.consultant != 'null' ? search.consultant : 'null';
        const url = lang == 'en' ? "/admin-invoices-search?date_from=" : "/no/admin-transaksjoner-sok?date_from=";
        setTimeout(function () {
            window.location = url + date + "&consultant=" + consultant;
        }, 50);
    });
    $("#show_filter").on('click', function () {
        if ($(".filter-body").hasClass('active')) {
            $(this).addClass('reversed');
            $(".filter-body").removeClass('active');
        } else {
            $(this).removeClass('reversed');
            $(".filter-body").addClass('active');
        }
    });
    var init = function () {

        $('#invoices').DataTable({
            rowReorder: true,
            responsive: true,
            "aaSorting": [],
            "emptyTable": "no data available in table.",
            "oLanguage": {
                "sEmptyTable": "No data available in table."
            },
            "initComplete": function(settings, json) {
                $(this).removeClass("no-footer");
            }
        });
        $("#desktop_date_from").MonthPicker({
            MonthFormat: 'M, yy',
            SelectedMonth: search.date_from,
            ShowIcon: false
        });
        $("#desktop_date_till").MonthPicker({
            MonthFormat: 'M, yy',
            SelectedMonth: search.date_till,
            ShowIcon: false
        });
        $("#mobile_date").MonthPicker({
            MonthFormat: 'M, yy',
            SelectedMonth: search.date_till,
            ShowIcon: false
        });
    }
    $("#invoices tbody tr").each(function(key) {
        const payer_img = data[key].payer_img != null ? data[key].payer_img : 'images/white-logo.svg';
        const payer_size = data[key].payer_img != null ? 'cover' : '20px 20px';
        $(this).find('td').eq(0).children().children('.avatar').css('background-image', "url(" + payer_img  + ")");
        $(this).find('td').eq(0).children().children('.avatar').css('background-size', payer_size);
        const receiver_img = data[key].receiver_img != null ? data[key].receiver_img : 'images/white-logo.svg';
        const receiver_size = data[key].receiver_img != null ? 'cover' : '20px 20px';
        $(this).find('td').eq(1).children().children('.avatar').css('background-image', "url(" + receiver_img  + ")");
        $(this).find('td').eq(1).children().children('.avatar').css('background-size', receiver_size);
    });
    $('#invoices').on('click', 'tbody td', function() {
        if (!$(this).hasClass('dtr-control')) {
            const id = $(this).parent().children('td').eq(1).children('p').data('id');
            const url = lang == 'en' ? `/edit-customer/${id}` : `/no/rediger-kunde/${id}`;
            // window.location = url;
        }
    });
    init();
}; // invoices = function


