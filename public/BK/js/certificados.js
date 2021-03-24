function certificado(session, img) {
    $.ajax({
        data : {session : session,
                img     : img },
        url  : 'Descargas/descarga',
        type : 'POST',
        async : false
    }).done(function(data){
        try{
            data = JSON.parse(data);
            if (data.error == 0) {
            } else {
                toastr.remove();
                msj('error', data.error);
            }
        } catch (err){
            toastr.remove();
            msj('error', err.message);
        }
    });
}
function cerrarSesion(){
    $.ajax({
        url  : 'Descargas/cerrarSesion',
        type : 'POST'
    }).done(function(data){
        try{
            data = JSON.parse(data);
            if(data.error == 0){
        	   location.href = 'Login';
            }else {
        	   return;
            }
        }catch(err){
            toastr.remove();
            msj('error',err.message);
        }
	});
}