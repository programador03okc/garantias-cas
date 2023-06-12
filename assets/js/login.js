$(function(){
	$('#formLogin').on('submit', function(){
		var data = $(this).serialize();
		$.ajax({
			type: 'POST',
			url: baseUrl+'login/logeo',
			data: data,
			dataType: 'JSON',
			success: function(response){
				if(response.sesion == 'ok'){
					document.location.href = baseUrl + 'inicio';
				}else if(response.sesion == 'e_clave'){
					$('.loading').remove();
					alert('Su contraseña es incorrecta.');
					$('[name=pass]').focus();
				}else if(response.sesion == 'e_usu'){
					$('.loading').remove();
					alert('Su usuario no esta activo.');
					$('[name=user]').focus();
				}
			}
		}).fail( function(jqXHR, textStatus, errorThrown ) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        });
		return false;
	});
});

