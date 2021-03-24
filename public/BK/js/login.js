function ingresar() {
	var email = $('#exampleInputEmail1').val();
	if(email == null) {
		$('#exampleInputEmail1').parent().addClass('is-invalid');
		return;
	}
	if (!validateEmail(email)) {
		$('#exampleInputEmail1').parent().addClass('is-invalid');
		return;
	}
	$.ajax({
		data  : { email : email},
		url   : 'login/ingresar',
		type  : 'POST'
	}).done(function(data){
		try{
        	data = JSON.parse(data);
        	if(data.error == 0){
        		location.href = 'Descargas';
        		$('#exampleInputEmail1').val("");
        	}else {
				$('#exampleInputEmail1').parent().addClass('is-invalid');
				msj('error', 'Su correo no existe');
        		return;
        	}
      } catch (err){
        msj('error',err.message);
      }
	});
}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function verificarDatos(e) {
	if(e.keyCode === 13){
		e.preventDefault();
		ingresar();
    }
}
function cerrarCesion(){
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
        msj('error',err.message);
      }
	});
}