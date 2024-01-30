//* #1 Documentacion Excel - Funciones Base - Asignacion de registros a usuario - Reclutamiento
function assignToUser(url, view) {
  let form = $('#formAsignacion').serialize();
  form += '&label_usuario=' + $('label[for="asignar_usuario"]').text();
  form += '&label_registro=' + $('label[for="asignar_registro"]').text();
  form += '&view=' + view;
  let selectedRegistro = $('#asignar_registro').selectpicker('val')
  $.ajax({
    url: url,
    method: 'POST',
    data: form,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#asignarUsuarioModal").modal('hide')
        //$('#divUsuario'+selectedRegistro).html('<b>'+$('#asignar_usuario option:selected').text()+'</b>');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        })
        setTimeout(function(){
          location.reload()
        },2500)
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}
//* #2 Documentacion Excel - Funciones Base - Carga/Subida de registros desde formato CSV - Reclutamiento
function uploadCSV(url){
  var docs = new FormData();
  var archivo = $("#archivo_csv")[0].files[0];
  docs.append("archivo", archivo);
  $.ajax({
    url: url,
    method: "POST",
    data: docs,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#subirCSVModal").modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        })
        setTimeout(function(){
          location.reload()
        },2500)
      }
      if (data.codigo === 0) {
        $("#archivo_csv").val('');
        Swal.fire({
            icon: 'warning',
          title: 'ATENCIÓN',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar',
        })
      }
      if (data.codigo === 2) {
        $("#archivo_csv").val('');
        Swal.fire({
            icon: 'warning',
          title: 'ATENCIÓN',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Actualizar requisiciones',
        })
        .then((result) => {
          if (result.isConfirmed) {
            location.reload()
          }
        })
      }
    }
  });
}
//*
function deleteUserOrder(id, url){
  $('#mensajeModal').modal('hide');
  $.ajax({
    url: url,
    type: 'post',
    data: {
      'id': id
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 300);
      var dato = JSON.parse(res);
      if(dato.codigo === 1){
        $('#divUser'+id).hide();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: dato.msg,
          showConfirmButton: false,
          timer: 2500
        })
        // setTimeout(function(){
        //   location.reload();
        // },2500)
      }
    }
  });
}