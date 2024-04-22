function guardarComentario(id_bolsa) {
    let comentario = $('#comentario_bolsa').val();
    $.ajax({
      url: urlGuardarComentario,

      type: 'post',
      data: {
        'id_bolsa': id_bolsa,
        'comentario': comentario
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        var data = JSON.parse(res);
        if (data.codigo === 1) {
          $("#historialComentariosModal").modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg,
            showConfirmButton: false,
            timer: 3000
          })
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