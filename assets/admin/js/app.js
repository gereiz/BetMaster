'use strict';

$(function(){
  $('#sidebar__menuWrapper').slimScroll({
    height: 'calc(100vh - 86.75px)'
  });
});

$(function(){
  $('.dropdown-menu__body').slimScroll({
    height: '270px'
  });
});

// modal-dialog-scrollable
$(function(){
  $('.modal-dialog-scrollable .modal-body').slimScroll({
    height: '100%'
  });
});

// activity-list 
$(function(){
  $('.activity-list').slimScroll({
    height: '385px'
  });
});

// recent ticket list 
$(function(){
  $('.recent-ticket-list__body').slimScroll({
    height: '295px'
  });
});





$('#navbar-search__field').on('input', function () {
    var search = $(this).val().toLowerCase();


    var search_result_pane = $('.navbar_search_result');
    $(search_result_pane).html('');
    if (search.length == 0) {
        return;
    }

    // search
    var match = $('.sidebar__menu-wrapper .nav-link').filter(function (idx, elem) {
        return $(elem).text().trim().toLowerCase().indexOf(search) >= 0 ? elem : null;
    }).sort();




    // show search result
    // search not found
    if (match.length == 0) {
        $(search_result_pane).append('<li class="text-muted pl-5">No search result found.</li>');
        return;
    }
    // search found
    match.each(function (idx, elem) {
        var item_url = $(elem).attr('href') || $(elem).data('default-url');
        var item_text = $(elem).text().replace(/(\d+)/g, '').trim();
        $(search_result_pane).append(`<li><a href="${item_url}">${item_text}</a></li>`);
    });


});

let img = $('.bg_img');
img.css('background-image', function () {
  let bg = ('url(' + $(this).data('background') + ')');
  return bg;
});

  const navTgg = $('.navbar__expand');
  navTgg.on('click', function(){
    $(this).toggleClass('active');
    $('.sidebar').toggleClass('active');
    $('.navbar-wrapper').toggleClass('active');
    $('.body-wrapper').toggleClass('active');
  });

  $(function () {
    $('[title]').tooltip()
  })

  $('.nice-select').niceSelect();

  // navbar-search 
  $('.navbar-search__btn-open').on('click', function (){
    $('.navbar-search').addClass('active');
  }); 

  $('.navbar-search__close').on('click', function (){
    $('.navbar-search').removeClass('active');
  }); 

  // responsive sidebar expand js 
  $('.res-sidebar-open-btn').on('click', function (){
    $('.sidebar').addClass('open');
  }); 

  $('.res-sidebar-close-btn').on('click', function (){
    $('.sidebar').removeClass('open');
  }); 

/* Get the documentElement (<html>) to display the page in fullscreen */
let elem = document.documentElement;

/* View in fullscreen */
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

/* Close fullscreen */
function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) { /* Firefox */
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE/Edge */
    document.msExitFullscreen();
  }
}

$('.fullscreen-btn').on('click', function(){
  $(this).toggleClass('active');
});

$('.sidebar-dropdown > a').on('click', function () {
  if ($(this).parent().find('.sidebar-submenu').length) {
    if ($(this).parent().find('.sidebar-submenu').first().is(':visible')) {
      $(this).find('.side-menu__sub-icon').removeClass('transform rotate-180');
      $(this).removeClass('side-menu--open');
      $(this).parent().find('.sidebar-submenu').first().slideUp({
        done: function done() {
          $(this).removeClass('sidebar-submenu__open');
        }
      });
    } else {
      $(this).find('.side-menu__sub-icon').addClass('transform rotate-180');
      $(this).addClass('side-menu--open');
      $(this).parent().find('.sidebar-submenu').first().slideDown({
        done: function done() {
          $(this).addClass('sidebar-submenu__open');
        }
      });
    }
  }
});

// select-2 init
$('.select2-basic').select2();
$('.select2-multi-select').select2();
$(".select2-auto-tokenize").select2({
  tags: true,
  tokenSeparators: [',']
});


function proPicURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var preview = $(input).parents('.thumb').find('.profilePicPreview');
            $(preview).css('background-image', 'url(' + e.target.result + ')');
            $(preview).addClass('has-image');
            $(preview).hide();
            $(preview).fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(".profilePicUpload").on('change', function () {
    proPicURL(this);
});

$(".remove-image").on('click', function () {
    $(this).parents(".profilePicPreview").css('background-image', 'none');
    $(this).parents(".profilePicPreview").removeClass('has-image');
    $(this).parents(".thumb").find('input[type=file]').val('');
});

$("form").on("change", ".file-upload-field", function(){ 
  $(this).parent(".file-upload-wrapper").attr("data-text",$(this).val().replace(/.*(\/|\\)/, '') );
});




//Custom Data Table
$('.custom-data-table').closest('.card').prepend('<div class="card-header" style="border-bottom: none;"><div class="text-right"><div class="form-inline float-sm-right bg--white"><input type="text" name="search_table" class="form-control" placeholder="Search"></div></div></div>');
$('.custom-data-table').closest('.card').find('.card-body').attr('style','padding-top:0px');
var tr_elements = $('.custom-data-table tbody tr');
$(document).on('input','input[name=search_table]',function(){
  var search = $(this).val().toUpperCase();
  var match = tr_elements.filter(function (idx, elem) {
    return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
  }).sort();
  var table_content = $('.custom-data-table tbody');
  if (match.length == 0) {
    table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
  }else{
    table_content.html(match);
  }
});



// Setup modal values
let cuModal = $("#cuModal");
let form = cuModal.find("form");
const action = form[0] ? form[0].action : null;

$(document).on("click", ".cuModalBtn", function () {
  let data = $(this).data();
  let resource = data.resource ?? null;

  

  if (!resource) {
    $(form).trigger("reset");
    form[0].action = `${action}`;
    cuModal.find(".status").empty();
  }
  cuModal.find(".modal-title").text(`${data.modal_title}`);
  if (resource) {
    form[0].action = `${action}/${resource.id}`;
    // If form has image
    if (resource.image_with_path) {
      cuModal
        .find(".profilePicPreview")
        .css("background-image", `url(${resource.image_with_path})`);
    }

    console.log(resource);

    if (data.has_status) {

      cuModal.find(".status").html(`
				<div class="form-group">
					<label class="font-weight-bold">Status</label>
					<input type="checkbox" data-width="100%" data-size="sm" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" data-on="Enabled" data-off="Disabled" name="status">
				</div>
			`);
      

      cuModal.find("[name=status]").bootstrapToggle();
    }

    let fields = cuModal.find("input, select, textarea");
    let fieldName;

    fields.each(function (index, element) {
      fieldName = element.name;

      if ($(element).hasClass('profilePicUpload')) {
        $(element).removeAttr('required');
      }

      // If input name is an array
      if (fieldName.substring(fieldName.length - 2) == "[]") {
        fieldName = fieldName.substring(0, fieldName.length - 2);
      }

      if (fieldName != "_token" && resource[fieldName]) {

        if (element.tagName == "TEXTAREA") {
          if ($(element).hasClass("nicEdit")) {
            $(".nicEdit-main").html(resource[fieldName]);
          } else {
            $(`[name='${fieldName}']`).text(resource[fieldName]);
          }
        } else if ($(element).data("toggle") == "toggle") {

          if(resource[fieldName] != 0) {
            $(element).bootstrapToggle("on");
          } else {
            $(element).bootstrapToggle("off");
          }
        } else if (element.type == "file") {
          
        } else {
          $(`[name='${element.name}']`).val(
            $.isNumeric(resource[fieldName])
              ? resource[fieldName] * 1
              : resource[fieldName]
          );
        }
      }
    });
  }
  cuModal.modal("show");
});