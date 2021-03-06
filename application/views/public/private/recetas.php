 <div class="container-fluid mt-4 pt-2 col-12">

	<div class="page-header" id="banner">

		<h1>Gestión recetas</h1>
	</div>

	<div class="modal fade" id="myModal" role="dialog">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h5 class="modal-title" id="modalTitle">ELIMINAR RECETA</h5>
        			<button type="button" id="boton_cerrar_modal" class="btn-close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true"></span>
        			</button>
      			</div>
      			<div class="modal-body">
        			<p id="mensaje_eliminar" >Receta a eliminar</p>
					<input type="hidden" name="idreceta" id="id_receta_oculta">
     			</div>
     			<div class="modal-footer">
        			<button type="button" class="btn btn-primary" onclick="eliminarReceta()">Eliminar</button>
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      			</div>
    		</div>
  		</div>
	</div>

	
	<div class="pt-2">
		<div class="row m-2">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page" onclick="window.history.back();"><i class="fa-solid fa-angle-left"></i> Volver atras</li>
				</ol>
			</nav>
		</div>
		<div class="row m-2">
			<div class="row">
				<div class="col-4">
					<div class="input-group">
						<input type="text" class="form-control form-control-sm">
						<div class="input-group-prepend">
							<button class="btn btn-outline-primary btn-sm" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
						</div>
						
					</div>
				</div>
				<div class="col">
					<!-- <button class="form-control btn btn-primary btn-sm" type="button">CREAR RECETA <i class="fa-solid fa-plus"></i></button> -->
				</div>
				<div class="col">
					
				</div>
				<div class="col">
					<div id="agregar_receta">
						
					</div>
					<div class="row mt-2"></div>
					<!-- <button class="form-control btn btn-outline-primary btn-sm" type="button">EXPORTAR A EXCEL <i class="fa-solid fa-file-export"></i></button> -->
				</div>
			</div>
		</div>


		<div class="row m-2">
			<div class="table-responsive">			
 		<!-- table -->
				<table class="table table-hover table-sm table-bordered">
				  <thead class="table-dark">
				    <tr>
				      <th scope="col">#</th>
				      <th scope="col">RECETA</th>
				      <th scope="col">INGREDIENTES</th>
				      <th scope="col">PRESENTACION</th>
				      <th scope="col">PRECIO DE VENTA</th>
				      <th scope="col">ACCIONES</th>
				    </tr>
				  </thead>
				  <tbody id="tabla-recetas">
				  </tbody>
				</table>
 		<!-- ./table -->
 			</div>
		</div>


	</div>

<!-- 	<div class="d-flex justify-content-around m-2">
		<a href="http://localhost/inventario/">Login</a>
		<a href="http://localhost/inventario/controlador/puntosVenta">Puntos de venta</a>
		<a href="http://localhost/inventario/controlador/insumos">Insumos</a>
		<a href="http://localhost/inventario/controlador/recetas">Recetas</a>
		<a href="http://localhost/inventario/controlador/productos">productos</a>
		<a href="http://localhost/inventario/controlador/reportes">Reportes</a>
	</div> -->
	

</div>
