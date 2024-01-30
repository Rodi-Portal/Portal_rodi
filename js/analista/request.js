function submitForm({id, id_seccion, url, refresh = false, num = 0, id_ref = 0, hideModal = true, updateButton = '', deleteButton = '', action = '', encrypt = false, clave_txt = ''}) {
  let datos = $('#dataForm').serialize();
  datos += '&id_candidato=' + id;
  datos += '&id_seccion=' + id_seccion;
  datos += '&num=' + num;
  datos += '&id_ref=' + id_ref;
  if(encrypt){
    datos += '&url=' + url;
    //let data = JSON.stringify(datos)
    let encryptedData = CryptoJSAesJson.encrypt(datos, clave_txt)
    var textFile = new File([encryptedData], {
			type: 'text/plain'
		});
		var fileNameToSaveAs = id+'-s'+id_seccion + ".txt";
		var downloadLink = document.createElement("a");
		downloadLink.download = fileNameToSaveAs;
		downloadLink.innerHTML = "My Hidden Link";
		window.URL = window.URL || window.webkitURL;
		downloadLink.href = window.URL.createObjectURL(textFile);
		downloadLink.onclick = destroyClickedElement;
		downloadLink.style.display = "none";
		document.body.appendChild(downloadLink);
		downloadLink.click();
  }
  $.ajax({
    url: url,
    type: 'POST',
    data: datos,
    success: function(res) {
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        if(hideModal)
          $("#formModal").modal('hide')
        if(refresh)
          recargarTable()
        if(data.nuevo_id != null && data.nuevo_id != ''){
          const parametros = {
            id: id,
            id_seccion: id_seccion,
            url: url,
            refresh: refresh,
            num: num,
            id_ref: data.nuevo_id,
            hideModal: hideModal,
            updateButton: updateButton,
            deleteButton: deleteButton
          }
          $('#'+updateButton+num).removeAttr('onclick');
          $('#'+updateButton+num).attr("onclick","submitForm("+JSON.stringify(parametros)+")");
          $('#'+deleteButton+num).prop('disabled', false);
          $('#'+deleteButton+num).attr("onclick","mostrarMensajeConfirmacion(\""+action+"\","+num+","+data.nuevo_id+")");
        }
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function destroyClickedElement(event) {
  document.body.removeChild(event.target);
}
// function submitForm({id, id_seccion, url, refresh = false}) {
//   let datos = $('#dataForm').serialize();
//   datos += '&id_candidato=' + id;
//   datos += '&id_seccion=' + id_seccion;
//   $.ajax({
//     url: url,
//     type: 'POST',
//     data: datos,
//     success: function(res) {
//       var data = JSON.parse(res);
//       if (data.codigo === 1) {
//         $("#formModal").modal('hide')
//         if(refresh)
//           recargarTable()
//         Swal.fire({
//           position: 'center',
//           icon: 'success',
//           title: data.msg,
//           showConfirmButton: false,
//           timer: 2500
//         })
//       } else {
//         Swal.fire({
//           icon: 'error',
//           title: 'Hubo un problema al enviar el formulario',
//           html: data.msg,
//           width: '50em',
//           confirmButtonText: 'Cerrar'
//         })
//       }
//     }
//   });
// }