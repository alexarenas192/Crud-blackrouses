<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cócteles</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="images/logo.jpg" width="40"> </a>
    
  </div>
</nav>

<div class="container">
  <div class="d-flex justify-content-between mb-3">
    <h3>Lista de Cócteles</h3>
    <button class="btn btn-success" id="btnAgregar">Agregar Cóctel</button>
  </div>

  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Nombre</th>
        <th>Ingredientes</th>
        <th>Preparación</th>
        <th>Foto</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="tablaCocteles"></tbody>
  </table>
</div>

<div class="alert alert-danger" id="alertError"></div>
<div class="alert alert-success" id="alertSuccess"></div>

<!-- Modal -->
<div class="modal fade" id="modalCoctel" tabindex="-1">
  <div class="modal-dialog">
    <form id="formCoctel" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cóctel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="accion" value="agregar">
        <input type="hidden" name="id">
        <input type="hidden" name="imagenActual">
        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre">
        <textarea name="ingredientes" class="form-control mb-2" placeholder="Ingredientes"></textarea>
        <textarea name="preparacion" class="form-control mb-2" placeholder="Preparación"></textarea>
        <input type="file" name="imagen" class="form-control mb-2" accept="image/*">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>
<!-- actualizado: agregado comentario -->
