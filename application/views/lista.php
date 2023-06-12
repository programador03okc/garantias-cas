<div class="container-page-large">
	<div class="row">
		<h3><strong>Solicitudes de Garantías</strong></h3>
		<div class="col-md-12">
			<fieldset class="group-form">
				<legend><h3>1° Garantías Pendientes</h3></legend>
				<table class="table table-hover table-striped" id="tablaSolicitud" width="100%">
					<thead>
						<tr>
							<th>Código</th>
							<th>Empresa</th>
							<th>Cliente</th>
							<th>Producto</th>
							<th>OC</th>
							<th>Fact</th>
							<th>Ubigeo</th>
							<th>Dirección</th>
							<th width="20">Modo</th>
							<th>Fec. Solic.</th>
							<th>Falla</th>
							<th width="40">Estado</th>
							<th width="65">Acción</th>
						</tr>
					</thead>
				</table>
			</fieldset>
			<br>
			<fieldset class="group-form">
				<legend><h3>2° Garantías Cerradas</h3></legend>
				<table class="table table-hover table-striped" id="tablaSolicitudCerrada" width="100%">
					<thead>
						<tr>
							<th>Código</th>
							<th>Empresa</th>
							<th>Cliente</th>
							<th>Producto</th>
							<th>OC</th>
							<th>Fact</th>
							<th>Ubigeo</th>
							<th>Dirección</th>
							<th width="20">Modo</th>
							<th>Fec. Solic.</th>
							<th>Falla</th>
							<th width="40">Estado</th>
							<th width="65">Acción</th>
						</tr>
					</thead>
				</table>
			</fieldset>
		</div>
	</div>
</div>

<!-- Modal Historial -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-historial">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="formHistory" form="historial">
				<div class="modal-header">
					<h3 class="modal-title" id="titleHistorial"></h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="id_solicitud" id="id_solicitud">
							<input type="hidden" name="status" id="status">
							<div class="row">
								<div class="col-md-5">
									<h5>Fecha</h5>
									<input type="date" class="form-control input-sm" name="fecha_hist" id="fecha_hist" required>
								</div>
								<div class="col-md-5">
									<h5>Código del Caso</h5>
									<input type="text" class="form-control input-sm" name="codigo_aten" id="codigo_aten">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Comentario</h5>
									<textarea class="form-control input-sm" name="comentario" id="comentario" rows="4" placeholder="Ingrese un comentario.." required></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-block btn-success">Guardar <span class="fa fa-save"></span></button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Edición -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-edition">
	<div class="modal-dialog modal-xxl">
		<div class="modal-content">
			<form id="formEdition" form="edition">
				<div class="modal-header">
					<h3 class="modal-title">Formulario de Edición</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<input type="hidden" name="id_solicit" id="id_solicit">
					<input type="hidden" name="id_contac" id="id_contac">
					<div class="row">
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<fieldset><legend><h4>1° Datos de la Solicitud</h4></legend>
										<div class="row">
											<div class="col-md-12">
												<h5>Descripción del problema</h5>
												<textarea class="form-control input-sm" name="problema" id="problema" rows="5" placeholder="Escribir el motivo de la solicitud" required></textarea>
											</div>
											<div class="col-md-12">
												<h5>Tipo de Intervención</h5>
												<select class="form-control input-sm" name="tipo_interv" id="tipo_interv" required>
													<option value="0" selected disabled>Elija una opción</option>
													<?=$tipo_interv?>
												</select>
											</div>
											<div class="col-md-6">
												<h5>Orden Compra</h5>
												<input type="text" class="form-control input-sm" name="orden_cc" id="orden_cc">
											</div>
											<div class="col-md-6">
												<h5>Cuadro Costo</h5>
												<input type="text" class="form-control input-sm" name="cuadro_cc" id="cuadro_cc">
											</div>
											<div class="col-md-12">
												<h5>Dirección</h5>
												<input type="text" class="form-control input-sm" name="direccion" id="direccion" placeholder="Ingresar la dirección exacta" required>
											</div>
										</div>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<fieldset><legend><h4>2° Contacto que reporta</h4></legend>
										<div class="row">
											<div class="col-md-12">
												<h5>Contacto (reporta)</h5>
												<input type="text" class="form-control input-sm" name="cont_reporta" id="cont_reporta" placeholder="Nombres del contacto" required>
											</div>
											<div class="col-md-12">
												<h5>Teléfono</h5>
												<input type="text" class="form-control input-sm" name="tlf_reporta" id="tlf_reporta" placeholder="+51 999000333">
											</div>
											<div class="col-md-12">
												<h5>Correo</h5>
												<input type="email" class="form-control input-sm" name="mail_reporta" id="mail_reporta" placeholder="example@gmail.com">
											</div>
										</div>
									</fieldset>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<fieldset><legend><h4>3° Contacto principal</h4></legend>
										<div class="row">
											<div class="col-md-12">
												<h5>Contacto (reporta)</h5>
												<input type="text" class="form-control input-sm" name="cont_princ" id="cont_princ" placeholder="Nombres del contacto" required>
											</div>
											<div class="col-md-12">
												<h5>Teléfono</h5>
												<input type="text" class="form-control input-sm" name="tlf_princ" id="tlf_princ" placeholder="+51 999000333">
											</div>
											<div class="col-md-12">
												<h5>Correo</h5>
												<input type="email" class="form-control input-sm" name="mail_princ" id="mail_princ" placeholder="example@gmail.com">
											</div>
										</div>
									</fieldset>
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

<!-- Modal Detalles -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-detalle-solicitud">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="titleCodigo"></h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="bodyDetail"></div>
		</div>
	</div>
</div>

<!-- Modal Historial -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-historial-solicitud">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="SolHistTitle"></h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="bodyHistoryDetail"></div>
		</div>
	</div>
</div>