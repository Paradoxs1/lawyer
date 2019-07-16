function isValidName(name) {
	if (!(name == '')) {
		if (!(/[a-zA-ZА-Я\-а-я]+/.test(name.val()))) {
			name.addClass('red-border');
			return false;
		}
		name.removeClass('red-border');
		return true;
	}
	name = 'name';
	return true;
}
function isValidPhone(phone) {
	if (!(phone == '')) {
		if (!(/\+?\d+\ ?\(?\d+\)?\ ?\d+\ ?\d+\ ?\d+/.test(phone.val()))) {
			phone.addClass('red-border');
			return false;
		}
		phone.removeClass('red-border');
		return true;
	}
	phone = '0000000000';
	return true;
}
function isValidEmail(email) {
    if (!(email == '')) {
        if (!(/[a-zA-ZА-Я\-а-я]+/.test(email.val()))) {
            email.addClass('red-border');
            return false;
        }
        email.removeClass('red-border');
        return true;
    }
    email = 'email';
    return true;
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.tab_item:visible .register-foto img').attr('src', e.target.result).removeClass('none');
            $('.tab_item:visible .register-foto span').addClass('none');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function registerFileId() {
    var id = $('.tab_item:visible .register-foto-input').attr('id');
    $('.tab_item:visible label.register-foto').attr('for', id);
}

$(document).ready(function(){

    $(function(){
        $(".datepicker").datepicker({
            dateFormat: 'dd-mm-yy',
        });
    });

    $('.btn-register').click(function (event) {
        event.preventDefault();
        $(this).parents('.wrapper').find('.tab_content .tab_item:visible input[type="submit"]').click();

    });

  $('.help-slider').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      arrows: false,
      fade: true,
      asNavFor: '.help-gallery-slider'
    });
  $('.help-gallery-slider').slick({
      slidesToShow: 3,
      asNavFor: '.help-slider',
      dots: false,
      arrows: false,
      focusOnSelect: true
  });
  
  $('.slider').slick({
    infinite: true,
    dots: true,
    arrows: false,
    slidesToShow: 6,
    swipeToSlide: true,
    responsive: [
    {
      breakpoint: 900,
      settings: {
        slidesToShow: 4
      }
    },
    {
      breakpoint: 580,
      settings: {
        slidesToShow: 2
      }
    }
  ]
  });
  
  $('.consultation-slider').slick({
    infinite: true,
    dots: true,
    arrows: true,
    slidesToShow: 4,
    swipeToSlide: true,
    responsive: [
    {
      breakpoint: 1100,
      settings: {
        slidesToShow: 3
      }
    },
    {
      breakpoint: 900,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 800,
      settings: {
        slidesToShow: 3
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 460,
      settings: {
        slidesToShow: 1
      }
    }
  ]
  });
  
  $('.about-container').slick({
    infinite: true,
    dots: true,
    arrows: true,
    slidesToShow: 4,
    swipeToSlide: true,
    responsive: [
    {
      breakpoint: 1000,
      settings: {
        slidesToShow: 3
      }
    },
    {
      breakpoint: 700,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 460,
      settings: {
        slidesToShow: 1
      }
    }
  ]
  });

  registerFileId();

  $(".register-foto-input").change(function(){
      readURL(this);
  });

  $(".toggle-block").click(function () {
      $('.toggle-mnu').toggleClass("on");
      $('#menu').slideToggle(500);
      return false;
  });
      
  $('.aside-btn').click(function(){
    $(this).find('.icon-arrow').toggleClass('active');
    $(this).prev().slideToggle();
  });
  
  $('select').each(function(){
    var $this = $(this), numberOfOptions = $(this).children('option').length;
  
    $this.addClass('select-hidden'); 
    $this.wrap('<div class="select"></div>');
    $this.after('<div class="select-styled"></div>');

    var $styledSelect = $this.next('div.select-styled');
    $styledSelect.text($this.children('option').eq(0).text());
  
    var $list = $('<ul />', {
        'class': 'select-options'
    }).insertAfter($styledSelect);
  
    for (var i = 0; i < numberOfOptions; i++) {
        $('<li />', {
            text: $this.children('option').eq(i).text(),
            rel: $this.children('option').eq(i).val()
        }).appendTo($list);
    }
  
    var $listItems = $list.children('li');
  
    $styledSelect.click(function(e) {
        e.stopPropagation();
        $('div.select-styled.active').not(this).each(function(){
            $(this).removeClass('active').next('ul.select-options').hide();
        });
        $(this).toggleClass('active').next('ul.select-options').toggle();
    });
  
    $listItems.click(function(e) {
        e.stopPropagation();
        $styledSelect.text($(this).text()).removeClass('active');
        $this.val($(this).attr('rel'));
        $list.hide();
        //console.log($this.val());
    });
  
    $(document).click(function() {
        $styledSelect.removeClass('active');
        $list.hide();
    });

});
  
  $('.map .city').hover( 
    function(){
      $(this).css('opacity','0.8');
      $('#sc').children().hide(); 
      $ms = $(this).attr('id');
      $idblock = $ms + '_1_';
      var offset = $(this).offset();

      if($(window).width() > 768){
         $('#' + $idblock).css({"left": offset.left, "top": offset.top-135}).addClass('show');
      }else{
        $('#' + $idblock).css({"left": offset.left+15, "top": offset.top-50}).addClass('show');
      }
      },  
    function(){
      $(this).css('opacity','1');
      $('#sc').children().hide(); 
      $ms = $(this).attr('id');
      $idblock = $ms + '_1_';
      $('#' + $idblock).removeClass('show');
  });

$('.contact-map .city').hover( 
  function(){
    $(this).find('path').attr('fill','#f0c76d');
    $('#sc').children().hide(); 
    $ms = $(this).attr('id');
    $idblock = $ms + '_1_';
    var offset = $(this).offset();
    
    if($(window).width() > 600){
       $('#' + $idblock).css({"left": offset.left+20, "top": offset.top-110}).addClass('show');
    }else{
      $('#' + $idblock).css({"left": offset.left+15, "top": offset.top-75}).addClass('show');
    }
    
  },  
  function(){
    var elementPath = $(this).find('path');
    elementPath.attr('fill','#d0d0d0');
    elementPath.attr('stroke','#fff');
    elementPath.attr('stroke-miterlimit','10');
    
    $('#sc').children().hide(); 
    $ms = $(this).attr('id');
    $idblock = $ms + '_1_';
    $('#' + $idblock).removeClass('show');
    
});
  
  $(".button-top").click(function () {
    elementClick = $(this).attr("href");
    destination = $(elementClick).offset().top;
    $("body,html").animate({scrollTop: destination }, 800);
  });

  $('.btn-rating').click(function(event){
    event.preventDefault();
    $(this).toggleClass('active').parents('.rating-block').toggleClass('active')
    $(this).prev().slideToggle();
  });

  $('.inline-popups').magnificPopup({
	  delegate: 'a',
	  removalDelay: 500,
	  fixedContentPos: true,
	  callbacks: {
	    beforeOpen: function() {
	       this.st.mainClass = this.st.el.attr('data-effect');
	    }
	  },
	  midClick: true
	});
  
  $('.phone ').mask('+ 380 99 999 99 99');
  $('.counter-num').mask('9999');

  $('.counter-num').keyup(function(){
    var Value = $(this).val();
    num = Value;
    
    var value = $(this).val(),
        priceProduct = $(this).parents('tr').find('.order-price').attr('data-price');
    
    $(this).parents('tr').find('.order-price span').html(value * priceProduct); 
    sum();
  });
	
  $("#modal-form .submit" ).click(function() {
    isValidName($(this ).parent().find(".name"));
    isValidPhone($(this ).parent().find(".phone"));
    if(isValidName($(this ).parent().find(".name")) 
        && isValidPhone($(this ).parent().find(".phone"))){
        return true;
    }else {
        return false;
    }
  });

    $(".submit").click(function() {
        isValidEmail($(this ).parents('form').find(".email"));
        if(isValidEmail($(this ).parents('form').find(".email"))) {
            return true;
        }
        return false;
    });
  
  $(".wrapper .tab").click(function() {
      $(".wrapper .tab").removeClass("active").eq($(this).index()).addClass("active");
      $(".tab_item").hide().eq($(this).index()).show();
      registerFileId();
  });

    var checkbox = $('.agree-checkbox input'),
        check = false,
        error = '',
        div;

    checkbox.each(function (indx, element) {
        check = $(element).prop('checked');

        if (check) {
            $('.agree-checkbox input').prop('checked', true);
            $('.agree input').prop('checked', true);
        }
    });

    div = $('.agree-checkbox .error');

    div.each(function (indx, element) {
        error = $(element).html();

        if (error != '') {
            $('.agree .error').html(error);
        }
    });



    $('.agree label').click(function () {
        $(this).parents('.wrapper').find('form .agree-checkbox input').click();
    });

  
  $('.counter-right, .counter-left').click(function(){
    var value = $(this).siblings('.counter-num').val(),
        priceProduct = $(this).parents('tr').find('.order-price').attr('data-price');
    
    $(this).parents('tr').find('.order-price span').html(value * priceProduct); 
    
    sum();
  });
  
  $('.order-close').click(function(){
    $(this).parents('tr').remove();
    sum();
  });
  
  function sum(){
    var priceAll = 0,
        price;
    
    $('.order-basket tbody tr').each(function(){
      price = $(this).find('.order-price span').text();
      priceAll = +priceAll + +price;
      $('.order-sum span').html(priceAll);
    });
    
  };
  
  sum();
  
  $('.btn-slide').click(function(event){
    event.preventDefault();
    
    $(this).toggleClass('active')
      .parent().prev().slideToggle(500)
      .parent().prev().slideToggle(500);
  });
  
  $('.btn-add').click(function(event){
    event.preventDefault();
    
    var price,
        priceAll,
        pathPriceAll,
        name,
        li = '<li><span></span> <span class="notarius-price"></span></li>';
    
    price = $(this).parents('.personal-block').find('.personal-price span').text();
    name = $(this).parents('.personal-block').find('.personal-name').text();
    pathPriceAll = $(this).parents('.container').find('.personal-right-pay p span');
    priceAll = pathPriceAll.text();
    pathPriceAll.html(+priceAll + +price);
    
    $(this).addClass('active');
    
    pathPriceAll.parent().prev().append(li)
      .find('.notarius-price').html(price + 'грн.')
      .prev().html(name);
   
  });
  
  $('.document-image, .help-image').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
		mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
		image: {
			verticalFit: true
		},
		zoom: {
			enabled: true,
			duration: 300 // don't foget to change the duration also in CSS
		}
	});
  
  
   $("[type=file]").mnFileInput();
	 $(".widthPreview").mnFileInput({'preview': '.preview'});
  
  if($(window).width() > 769){
    $(".info-block, .main-about, .rating-block:nth-child(odd), .personal-block:nth-child(odd), .btn-slide, .contact-block:first-child, .document-block:nth-child(odd), .help-title, .gracious-block:nth-child(odd), .partner-block:nth-child(odd), .about-content-left, .new:nth-child(odd)").animated2("fadeInLeft", "zoomOutDown");
    
    $(".news-block, .map, .rating-block:nth-child(even), .personal-block:nth-child(even), .btn-buy, .contact-block:last-child, .help-content form, .document-block:nth-child(even), .help-block img, .gracious-block:nth-child(even), .partner-block:nth-child(even), .about-content-right, .new:nth-child(even)").animated2("fadeInRight", "zoomOutDown");
    
    $(".head-video iframe, .btn-save, .personal-proposal a, .consultation aside a, .btn-h, .entrance-block, .banner form input[type='submit'], .volanteer-form input[type='submit']").animated("bounce", "fadeOut");
      
    $(".questions-answer").animated2("fadeInLeft", "zoomOutDown");
    
    $(".questions-block").animated2("fadeInRight", "zoomOutDown");
   }
});
