<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambio de Artículos</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .text-disabled {
      color: rgb(204, 204, 204);
    }
    .text-line-through {
      text-decoration-line: line-through;
    }
    .virtual-scroll-table {
      height: 63vh;
      overflow-y: auto;
    }
  </style>
</head>
<body>
  <div id="cambios" class="container">
    <div class="row">
      <div class="col-12 text-center my-4">
        <h4>Cambio de artículos</h4>
      </div>
    </div>

    <!-- Input y Botón de Búsqueda -->
    <div class="row mb-4">
      <div class="col-md-8">
        <input id="numSalida" type="text" class="form-control" placeholder="Num. Salida" />
      </div>
      <div class="col-md-4">
        <button id="buscarBtn" class="btn btn-warning btn-block">Buscar</button>
      </div>
    </div>

    <!-- Información de Salida -->
    <div class="row mb-4">
      <div class="col-md-6">
        <p><strong>Fecha:</strong> <span id="fechaSalida">2025-03-06</span></p>
        <p><strong>Realizado por:</strong> <span id="realizadoPor">Juan Pérez</span></p>
      </div>
      <div class="col-md-6">
        <p><strong>Para:</strong> <span id="usuario">Carlos López</span></p>
        <p><strong>Tipo:</strong> <span id="tipoSalida">Devolución</span></p>
      </div>
    </div>

    <!-- Tablas de Artículos -->
    <div class="row">
      <div class="col-md-6">
        <h5>Artículos (original)</h5>
        <table id="tablaOriginal" class="table table-striped virtual-scroll-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Cantidad</th>
              <th>Nombre</th>
              <th>Talla</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <!-- Datos de artículos originales se agregarán aquí con JavaScript -->
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <h5>Artículos (cambio)</h5>
        <table id="tablaCambio" class="table table-striped virtual-scroll-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Cantidad</th>
              <th>Nombre</th>
              <th>Talla</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <!-- Datos de artículos para cambio se agregarán aquí con JavaScript -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Botón de Confirmación -->
    <div class="row">
      <div class="col-12 text-center my-4">
        <button id="realizarCambioBtn" class="btn btn-success">Realizar cambio</button>
      </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal" tabindex="-1" role="dialog" id="modalConfirmacion">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirmación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>¿Estás seguro de realizar el cambio de artículos? Los artículos cambiados serán regresados al almacén.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="confirmarCambioBtn">Aceptar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    // Variables para almacenar datos de ejemplo
    let salidaArticulos = [
      { id_articulo: 1, cantidad: 10, nombre: 'Camiseta', talla: 'M' },
      { id_articulo: 2, cantidad: 5, nombre: 'Pantalón', talla: 'L' }
    ];

    let articulosCambio = [];

    // Función para renderizar artículos en la tabla
    function renderArticulos() {
      const tablaOriginal = document.getElementById('tablaOriginal').getElementsByTagName('tbody')[0];
      const tablaCambio = document.getElementById('tablaCambio').getElementsByTagName('tbody')[0];
      tablaOriginal.innerHTML = '';
      tablaCambio.innerHTML = '';

      salidaArticulos.forEach(articulo => {
        // Fila de la tabla de artículos originales
        const row = tablaOriginal.insertRow();
        row.insertCell(0).innerText = articulo.id_articulo;
        row.insertCell(1).innerText = articulo.cantidad;
        row.insertCell(2).innerText = articulo.nombre;
        row.insertCell(3).innerText = articulo.talla;
        const accionCell = row.insertCell(4);
        const btnCambiar = document.createElement('button');
        btnCambiar.classList.add('btn', 'btn-sm', 'btn-success');
        btnCambiar.innerText = 'Cambiar';
        btnCambiar.onclick = () => {
          if (!articulosCambio.some(a => a.id_articulo === articulo.id_articulo)) {
            articulosCambio.push(articulo);
            renderArticulos();
          }
        };
        accionCell.appendChild(btnCambiar);
      });

      articulosCambio.forEach(articulo => {
        // Fila de la tabla de artículos de cambio
        const row = tablaCambio.insertRow();
        row.insertCell(0).innerText = articulo.id_articulo;
        row.insertCell(1).innerText = articulo.cantidad;
        row.insertCell(2).innerText = articulo.nombre;
        row.insertCell(3).innerText = articulo.talla;
        const accionCell = row.insertCell(4);
        const btnCancelar = document.createElement('button');
        btnCancelar.classList.add('btn', 'btn-sm', 'btn-danger');
        btnCancelar.innerText = 'Cancelar';
        btnCancelar.onclick = () => {
          articulosCambio = articulosCambio.filter(a => a.id_articulo !== articulo.id_articulo);
          renderArticulos();
        };
        accionCell.appendChild(btnCancelar);
      });
    }

    // Event listeners
    document.getElementById('buscarBtn').addEventListener('click', function() {
      // Lógica para cargar los artículos al realizar la búsqueda (simulado en este caso)
      renderArticulos();
    });

    document.getElementById('realizarCambioBtn').addEventListener('click', function() {
      $('#modalConfirmacion').modal('show');
    });

    document.getElementById('confirmarCambioBtn').addEventListener('click', function() {
      alert('Cambio realizado exitosamente');
      $('#modalConfirmacion').modal('hide');
    });

    // Inicializar
    renderArticulos();
  </script>
</body>
</html>