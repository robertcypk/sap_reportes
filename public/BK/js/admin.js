function ingresar(){
  var usuario  = $('#usuario').val();
  var password = $('#password').val();
  if(usuario == null){
    msj('error', 'Ingrese su usuario');
    return;
  }
  if(password == null){
    msj('error', 'Ingrese su contraseña');
    return;
  }
  $.ajax({
    data : {usuario : usuario,
            password : password},
    url  : 'login/ingresar',
    type : 'POST'
  }).done(function(data){
    try{
        data = JSON.parse(data);
        if(data.error == 0){
          location.href = 'reporte';
          $('#usuario').val("");
          $('#password').val("");
        }else {
          msj('error', data.msj);
          return;
        }
      }catch(err){
        msj('error',err.message);
      }
  });
}
function verificarDatos(e){
  if(e.keyCode === 13){
    e.preventDefault();
    ingresar();
    }
}
function cerrarCesion(){
  $.ajax({
    url  : 'reporte/cerrarCesion',
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
function ingresoIdioma(){
    var idioma = $('#ingresoIdioma').val();
    $.ajax({
        data : { idioma : idioma },
        url  : 'reporte/ingresoIdioma',
        type : 'POST'
    }).done(function(data){
        try{
            data = JSON.parse(data);
            if(data.error == 0){
                $('#ingresoBody').html(data.html);
            }else {
                return;
            }
        }catch(err){
            msj('error',err.message);
        }
    });
}
function usuarioIdiomaCurso() {
    var curso  = $('#usuarioCurso').val();
    var idioma = $('#usuarioIdioma').val();
    $.ajax({
        data : { idioma : idioma,
                 curso  : curso },
        url  : 'reporte/usuarioIdiomaCurso',
        type : 'POST'
    }).done(function(data){
        try{
            data = JSON.parse(data);
            if(data.error == 0){
                $('#usuarioBody').html(data.html);
            }else {
                return;
            }
        }catch(err){
            msj('error',err.message);
        }
    });
}
function descargaCursos() {
    var curso  = $('#descargaCurso').val();
    $.ajax({
        data : { curso  : curso },
        url  : 'reporte/descargaCursos',
        type : 'POST'
    }).done(function(data){
        try{
            data = JSON.parse(data);
            if(data.error == 0){
                $('#cursoBody').html(data.html);
            }else {
                return;
            }
        }catch(err){
            msj('error',err.message);
        }
    });
}