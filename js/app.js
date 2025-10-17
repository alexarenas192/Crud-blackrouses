function cargarCocteles() {
  $.get("crud.php?listar=1", function(data) {
    $("#tablaCocteles").html(data);
  });
}

$(document).ready(function() {
  cargarCocteles();

  $("#btnAgregar").click(function(){
    $("#formCoctel")[0].reset();
    $("#formCoctel [name=accion]").val("agregar");
    $("#modalCoctel").modal("show");
  });

  $("#formCoctel").on("submit", function(e) {
    e.preventDefault();
    let btn = $(this).find("button[type=submit]");
    btn.prop("disabled", true);

    let fd = new FormData(this);
    let nombre = fd.get("nombre"),
        ingr = fd.get("ingredientes"),
        prep = fd.get("preparacion"),
        accion = fd.get("accion");

    if (!nombre || !ingr || !prep || (accion === "agregar" && !fd.get("imagen").name)) {
      $("#alertError").text("Completa todos los campos").fadeIn().delay(2000).fadeOut();
      btn.prop("disabled", false);
      return;
    }

    $.ajax({
      url: "crud.php",
      type: "POST",
      data: fd,
      processData: false,
      contentType: false,
      success: function(res) {
        btn.prop("disabled", false);
        res = res.trim();
        if (res === "OK") {
          $("#alertSuccess").text("Cóctel editado correctamente").fadeIn().delay(2000).fadeOut();
          $("#modalCoctel").modal("hide");
          cargarCocteles();
        } else if(res === "ERROR_UPLOAD") {
          $("#alertError").text("Error al subir la imagen").fadeIn().delay(2000).fadeOut();
        } else {
          $("#alertError").text("Error en la operación").fadeIn().delay(2000).fadeOut();
        }
      }
    });
  });

  $(document).on("click", ".btn-eliminar", function() {
    let id = $(this).data("id");
    if (confirm("¿Eliminar este cóctel?")) {
      $.post("crud.php", {accion: "eliminar", id: id}, function(res){
        if (res.trim() === "OK") {
          $("#alertSuccess").text("Cóctel eliminado").fadeIn().delay(2000).fadeOut();
          cargarCocteles();
        }
      });
    }
  });

  $(document).on("click", ".btn-editar", function(){
    let id = $(this).data("id");
    $.getJSON("crud.php?obtener="+id, function(data){
      $("#formCoctel [name=accion]").val("editar");
      $("#formCoctel [name=id]").val(data.id);
      $("#formCoctel [name=nombre]").val(data.nombre);
      $("#formCoctel [name=ingredientes]").val(data.ingredientes);
      $("#formCoctel [name=preparacion]").val(data.preparacion);
      $("#formCoctel [name=imagenActual]").val(data.imagen);
      $("#modalCoctel").modal("show");
    });
  });
});
