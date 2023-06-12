<div class="container-page">
	<div class="row">
		<h3><strong>Tipos de Equipo</strong></h3>
		<br>
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary btn-sm btn-flat" onclick="openModal('tipo');">
					<span class="icon-plus"></span>Nuevo Tipo de Equipo
				</button>
			</div>
		</div>
		<br>
		<div class="col-md-8">
			<fieldset class="group-form">
				<legend><h5>Tabla de resultados</h5></legend>
				<table class="table table-hover table-bordered table-striped" id="tablaTipo" width="100%">
					<thead>
						<tr>
							<th width="20">N°</th>
							<th>Descripción</th>
							<th width="70">Acción</th>
						</tr>
					</thead>
				</table>
			</fieldset>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-tipo">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form class="formPage" id="formulario" form="tipo" type="register">
				<div class="modal-header">
					<h3 class="modal-title">Formulario de Registro</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="id" id="id">
							<div class="row">
								<div class="col-md-12">
									<h5>Descripción</h5>
									<input type="text" class="form-control input-sm" name="desc" id="desc" placeholder="Ingrese el nombre">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-success">Guardar <span class="fa fa-save"></span></button>
				</div>
			</form>
		</div>
	</div>
</div>