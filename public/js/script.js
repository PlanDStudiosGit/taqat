jQuery(document).ready(function(){


  // loader
  setTimeout(function(){ 
  $('.loaders').fadeOut(); }, 1000);

  //wow js
  var wow = new WOW(
    {
      boxClass:     'wow',      
      animateClass: 'animated',
      offset:       0,          
      mobile:       true,       
      live:         true,       
      callback:     function(box) {
      
      },
      scrollContainer: null,  
      resetAnimation: true,  
    }
  );
  wow.init();



  //mobile menu
  $(".mob").click(function(){
    $(".menu-area").addClass("mobile");

    return false;
  });


  $(".closes").click(function(){
    $(".menu-area").removeClass("mobile");

    return false;
  });


  $('.menu li a').click(function(){
      $('.menu li a').removeClass("active");
      $(this).addClass("active");
  });

  //action-link
  $('.action-link li a').click(function(){
      $('.action-link li a').removeClass("active");
      $(this).addClass("active");
      return false;
  });

  //radiosbtn
  $('.radiosbtn').click(function(){
      $('.radiosbtn').removeClass("act");
      $(this).addClass("act");
  });


  $(".menuwidth").click(function(){
    $(".menu-area").toggleClass("menu-full");
    $(".hide-item").toggleClass("show-item");
    $(".small-logo").toggleClass("show-logo");
    $(".main-contents").toggleClass("menu-full-body");

  });

  $(".menu-area ul li").click(function() {
    // $('.sub-menu').removeClass("submenu");
    $(this).find(".sub-menu").toggleClass("submenu");
    $(this).find(".drop-icon").toggleClass("roted");
  });


    //daterangepicker
    $(function() {

      var start = moment().subtract(29, 'days');
      var end = moment();

      function cb(start, end) {
          $('.reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      }

      $('.reportrange').daterangepicker({
          startDate: start,
          endDate: end,
          ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          }
      }, cb);

      cb(start, end);

  });

  $(function() {
    $('input[name="date"]').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 1901,
      maxYear: parseInt(moment().format('YYYY'),10)
    });
  });



  //table
  $('.display').addClass('nowrap').dataTable({
      responsive: true,
      columnDefs: [{ targets: [-1, -2], className: 'dt-body-right' }]
  });

  //tabs responsive
  $("a[data-toggle=\"tab\"]").on("shown.bs.tab", function (e) {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
  });



  $(".display :checkbox").change(function() {
      $(this).parent().parent().toggleClass('selecet-bg');
  });


  
  $(".display :checkbox").change(function() {
      $(this).parent().parent().parent().toggleClass('selecet-bg');
  });

  

  $(".display :checkbox").change( function(){
    if( $(this).is(':checked') ) {
        $('.carpost-area').addClass('show-car');
     }else{
      $('.carpost-area').removeClass('show-car');
    }
 });



  // select 2
  $('.select2').select2({
    createTag: function(params) {
        var term = $.trim(params.term);

        if (term === '') {
            return null;
        }

        return {
            id: term,
            text: term,
            newTag: true // add additional parameters
        }
    }
});

$(".tags1").select2({
  tags: true,
  dropdownParent: $('.select-modal')
});


$(".tags3").select2({
  tags: true,
  dropdownParent: $('.select-modal3')
});




$(".tags2").select2({
  tags: true
});


//audio play
$('.play-push').click(function(){
  $(this).toggleClass('show');
  return false;
});

  // show password
  $(".hide-eye").hide();

  $(".show-eye").click(function() {
      $(".hide-eye").show();
      $(".show-eye").hide();
  });

  $(".hide-eye").click(function() {
      $(".hide-eye").hide();
      $(".show-eye").show();
  });


  //login
  $('.input').focus(function(){
    $(this).parent().find(".label-txt").addClass('label-active');
    $(this).addClass('input-active');

  });

  $(".input").focusout(function(){
    if ($(this).val() == '') {
      $(this).parent().find(".label-txt").removeClass('label-active');
      $(this).removeClass('input-active');
    };
  });


      
//details slider
$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});


$('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true,
    responsive: [{
            breakpoint: 992,
            settings: {
                arrows: false,
                centerMode: true,
                slidesToShow: 2
            }
        },
        {
            breakpoint: 768,
            settings: {
                arrows: false,
                centerMode: true,
                slidesToShow: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: true,
                slidesToShow: 2
            }
        }
    ]
});






});

