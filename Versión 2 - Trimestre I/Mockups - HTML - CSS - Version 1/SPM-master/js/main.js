$(document).ready(function(){

	/*  Show/Hidden Submenus */
	$('.nav-btn-submenu').on('click', function(e){
		e.preventDefault();
		var SubMenu=$(this).next('ul');
		var iconBtn=$(this).children('.fa-chevron-down');
		if(SubMenu.hasClass('show-nav-lateral-submenu')){
			$(this).removeClass('active');
			iconBtn.removeClass('fa-rotate-180');
			SubMenu.removeClass('show-nav-lateral-submenu');
		}else{
			$(this).addClass('active');
			iconBtn.addClass('fa-rotate-180');
			SubMenu.addClass('show-nav-lateral-submenu');
		}
	});

	/*  Show/Hidden Nav Lateral */
	$('.show-nav-lateral').on('click', function(e){
		e.preventDefault();
		var NavLateral=$('.nav-lateral');
		var PageConten=$('.page-content');
		if(NavLateral.hasClass('active')){
			NavLateral.removeClass('active');
			PageConten.removeClass('active');
		}else{
			NavLateral.addClass('active');
			PageConten.addClass('active');
		}
	});

	/*  Exit system buttom */
	$('.btn-exit-system').on('click', function(e){
		e.preventDefault();
		Swal.fire({
			title: 'Desea Cerrar Sesion?',
			text: "Esta a punto de cerrrar la sesion y slair del sistema ",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si!',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.value) {
				window.location="index.html";
			}
		});
	});
});
(function($){
    $(window).on("load",function(){
        $(".nav-lateral-content").mCustomScrollbar({
        	theme:"light-thin",
        	scrollbarPosition: "inside",
        	autoHideScrollbar: true,
        	scrollButtons: {enable: true}
        });
        $(".page-content").mCustomScrollbar({
        	theme:"dark-thin",
        	scrollbarPosition: "inside",
        	autoHideScrollbar: true,
        	scrollButtons: {enable: true}
        });
    });
})(jQuery);
$('.fa-sync-alt').on('click', function(e){
	e.preventDefault();
	Swal.fire({
		title: 'Desea Actualizar?',
		text: "",
		type: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si!',
		cancelButtonText: 'No, cancelar'
	}).then((result) => {
		if (result.value) {
			window.location="client-update.html";
		}
	});
});
(function($){
$(window).on("load",function(){
	$(".nav-lateral-content").mCustomScrollbar({
		theme:"light-thin",
		scrollbarPosition: "inside",
		autoHideScrollbar: true,
		scrollButtons: {enable: true}
	});
	$(".page-content").mCustomScrollbar({
		theme:"dark-thin",
		scrollbarPosition: "inside",
		autoHideScrollbar: true,
		scrollButtons: {enable: true}
	});
});
})(jQuery);

/*  Exit system buttom */
$('#btn_mañana').on('click', function(e){
	e.preventDefault();
	Swal.fire({
		position: "top-end",
		icon: "success",
		title: "Guardado Con Exito",
		showConfirmButton: false,
		timer: 1500
	  });
});

$('#btn_azul').on('click', function(e){
	e.preventDefault();
	Swal.fire({
		position: "top-end",
		icon: "success",
		title: "Actualizado Con Exito",
		showConfirmButton: false,
		timer: 1500
	  });
});

fa-trash-alt
$('#btn_lola').on('click', function(e){
	e.preventDefault();
	Swal.fire({
		position: "top-end",
		icon: "success",
		title: "Actualizado Con Exito",
		showConfirmButton: false,
		timer: 1500
	  });
});