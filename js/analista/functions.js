function openFiles(url, id_candidato, prefijo){
  $.ajax({
    url: url,
    type: 'post',
    data: {
      'id_candidato': id_candidato,
      'prefijo': 'Hola'
    },
    success: function(res) {
      $("#tablaDocs").html(res);
      $("#docsModal").modal("show");
    }
  });
}