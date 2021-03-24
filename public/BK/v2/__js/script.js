var $frm;
$("#contactForm").submit(function(e) {
    e.preventDefault();
	//console.log (e.target + " ///")
	$frm = $(e.target);
}).validate({
    
	
	  rules: {
            nombre: "required",
            apellidos: "required",
            region: "required",
            pais: "required",
            email: {
                required: true,
                email: true
            },
       
            documento: "required",
            valoraproximado: "required",
            oportunidad: "required",
            fechacontrato: "required",
            completado: "required",
            solicitud: "required"            
        },
        messages: {
            nombre: "Ingresa tu nombre",
            apellidos: "",
            region: "",
            pais: "",
            email: "",
            
            documento: "",
            valoraproximado: "",
            oportunidad: "",
            fechacontrato: "",
            completado: "",
            solicitud: ""

        },
		  showErrors: function(errorMap, errorList) {
			
			$("#summary").html("Revisa e ingresa los campos obligatorios para proceder a enviarlos.");
			//this.defaultShowErrors();
		  },
		//errorLabelContainer: "#messageBox",
        submitHandler: function(e) {
			
			//e.preventDefault();
			console.log('Arracnando a probar .' + $frm.attr('action'));
			//var $frm = $(e.target);
			$('#summary').hide();
			$.ajax({
				type: $frm.attr('method'),
				url: $frm.attr('action'),
				data: $frm.serialize(),
				beforeSend: function(){
						console.log('Enviando...');
						$('#button').text('Enviando...');
						$('button').attr("disabled", true);
					},
            	success: function (data) {
						console.log('Submission was successful.');
						console.log(data);
						console.log('Enviado! ');
						 $('#button').text('Enviar solicitud');
						 $('button').attr("disabled", false);
						  $frm[0].reset();
						 if (data.result == "success"){
							 console.log('confirmado! ');
							  $("#summary").css("display","block");
								$("#summary").html("Datos enviados correctamente!!");
							 }
							
						 return;
						 /*$('#success').slideDown(300);
						 setInterval(function(){
							 $('#success').slideUp(300);
						}, 5000);
						 */
						// $frm.resetForm();
						
					 
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
				 $('#button').text('Enviar nuevamente');
                 $('button').attr("disabled", false);
            }
			})
			
		}
        })	
