// Scroll totop button
var toTop = jQuery('#to-top');
toTop.click(function () {
  jQuery('html, body').animate({scrollTop: '0px'}, 800);
  return false;
});

/*scrool tabs */
jQuery('.navLinkList').click(function(){
  jQuery('html, body').animate({scrollTop: '250px'}, 800);
})

//tootip
jQuery(function () {
  jQuery('[data-toggle="tooltip"]').tooltip()
})

//Buscar
jQuery("#fieldSearch").click(function(){
  jQuery("#navConsultaAvancada").show(200);
  setTimeout(function () {
    jQuery("#navConsultaAvancada").hide(200);
  }, 10000);
});
jQuery("#fieldSearch").focus(function(){
  jQuery("#navConsultaAvancada").show(200);
});

/// Lista / Hierarquico

jQuery('#btnHierarquico').click(function(){
  jQuery('#hierarquico').show();
  jQuery('#lista').hide();
  jQuery('#btnHierarquico').attr('disabled','disabled');
  jQuery('#btnLista').removeAttr('disabled');
})
jQuery('#btnLista').click(function(){
  jQuery('#lista').show();
  jQuery('#hierarquico').hide();
  jQuery('#btnLista').attr('disabled','disabled');
  jQuery('#btnHierarquico').removeAttr('disabled');
})

// popover
jQuery(function () {
  jQuery('[data-toggle="popover"]').popover()
})

// Sliders Parceiros
jQuery('.sliderParceiros').slick({
  slidesToShow: 4,
  slidesToScroll: 2,
  autoplay: true,
  autoplaySpeed: 2000,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});
AOS.init();

/*
// Faz com que a aba seja selecionada após refresh
// -------------------------------------------------------------------------------
jQuery('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
   localStorage.setItem('activeTab', jQuery(e.target).attr('href'));
});
// Aqui salva o índice ao qual corresponde a aba. Você pode vê-lo na ferramenta de desenvolvimento do Chrome.

//Obtém os dados da localStorage
var activeTab = localStorage.getItem('activeTab');

// No console, ele mostrará a aba onde você fez o último clique e o 
// salve em "activeTab". Deixo o console para você ver. E quando você der refresh
// no navegador, o último em que você clicou estará ativo.

console.log(activeTab);

if (activeTab) {
  jQuery('a[href="' + activeTab + '"]').tab('show');

}
// -------------------------------------------------------------------------------
*/

$(function(){
  var hash = window.location.hash;
  var _hash = ( hash ) ? hash : "#Details";
  $('ul.nav a[href="' + _hash + '"]').tab('show');

  $('.nav-tabs a').click(function (e) {
    $(this).tab('show');
    var scrollmem = $('body').scrollTop() || $('html').scrollTop();
    window.location.hash = this.hash;
    $('html,body').scrollTop(scrollmem);
  });
});