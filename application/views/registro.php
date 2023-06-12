<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default panel-okc-head">
			<div class="panel-heading">Nueva Solicitud</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-3 col-sm-12">
								<h5>Empresa</h5>
								<select class="form-control input-sm" name="empresa" id="empresa">
									<option value="0" selected disabled>Elija una opción</option>
									<?= $empresas ?>
								</select>
							</div>
							<div class="col-lg-2 col-sm-12">
								<h5>Categoría Producto</h5>
								<select class="form-control input-sm" name="categoria" id="categoria">
									<option value="0" selected disabled>Elija una opción</option>
									<?= $categorias ?>
								</select>
							</div>
							<div class="col-lg-3 col-sm-12">
								<h5>Producto (serie)</h5>
								<div class="input-group input-group-sm">
									<input type="text" class="form-control" name="producto" id="producto" readonly>
									<span class="input-group-btn">
										<button type="button" class="btn btn-default btn-flat" onclick="openModal('producto');">
											<i class="icon-search"></i>
										</button>
									</span>
								</div>
							</div>
							<div class="col-lg-2 col-sm-12">
								<h5>Fecha Solicitud</h5>
								<input type="date" class="form-control input-sm" name="fecha_sol" id="fecha_sol">
							</div>
							<div class="col-lg-2 col-sm-12">
								<button class="btn btn-flat btn-sm btn-block btn-primary" style="margin-top: 24px;" onclick="ProcessRequest();">Procesar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<form id="fomRegister">
			<input type="hidden" name="id_marca" id="id_marca">
			<input type="hidden" name="model_producto" id="model_producto">
			<div class="panel panel-default panel-okc">
				<div class="panel-heading">Ubicación del Servicio</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-3 col-sm-12">
									<h5>Departamento</h5>
									<select class="form-control input-sm" name="depart" id="depart" onchange="loadProvince(this.value);" disabled required>
										<option value="0" selected disabled>Elija una opción</option>
										<?= $departamento ?>
									</select>
								</div>
								<div class="col-lg-3 col-sm-12">
									<h5>Provincia</h5>
									<select class="form-control input-sm" name="provin" id="provin" onchange="loadDistrict(this.value);" disabled required>
										<option value="0" selected disabled>Elija una opción</option>
									</select>
								</div>
								<div class="col-lg-3 col-sm-12">
									<h5>Distrito</h5>
									<select class="form-control input-sm" name="dist" id="dist" disabled required>
										<option value="0" selected disabled>Elija una opción</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<h5>Dirección</h5>
									<input type="text" class="form-control input-sm" name="direccion" id="direccion" placeholder="Ingresar la dirección exacta" disabled required>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default panel-okc">
				<div class="panel-heading">Datos de Contacto</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-7 col-sm-12">
									<h5>Empresa/Cliente</h5>
									<input type="hidden" name="id_cliente" id="id_cliente" value="0">
									<div class="input-group input-group-sm">
										<input type="text" class="form-control input-sm" name="cliente" id="cliente" onkeyup="javascript:this.value = this.value.toUpperCase();" disabled>
										<span class="input-group-btn">
											<button type="button" class="btn btn-default btn-flat input-sm" onclick="clearCustomer();" disabled>
												<span class="icon-arrows-cw"></span>
											</button>
										</span>
									</div>
								</div>
								<div class="col-lg-3 col-sm-12">
									<h5>Medio Contacto</h5>
									<select class="form-control input-sm" name="cont_medio" id="cont_medio" disabled required>
										<option value="0" selected disabled>Elija una opción</option>
										<?= $medios ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-sm-12">
									<h5>Contacto (reporta)</h5>
									<input type="text" class="form-control input-sm" name="cont_reporta" id="cont_reporta" placeholder="Nombres del contacto" disabled required>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Teléfono</h5>
									<input type="text" class="form-control input-sm" name="tlf_reporta" id="tlf_reporta" placeholder="+51 999000333" disabled required>
								</div>
								<div class="col-lg-5 col-sm-12">
									<h5>Correo</h5>
									<input type="email" class="form-control input-sm" name="mail_reporta" id="mail_reporta" placeholder="example@gmail.com" disabled required>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-5 col-sm-12">
									<h5>Contacto (principal)</h5>
									<input type="text" class="form-control input-sm" name="cont_princ" id="cont_princ" placeholder="Nombres del contacto principal" disabled required>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Teléfono</h5>
									<input type="text" class="form-control input-sm" name="tlf_princ" id="tlf_princ" placeholder="+51 999000333" disabled required>
								</div>
								<div class="col-lg-5 col-sm-12">
									<h5>Correo</h5>
									<input type="email" class="form-control input-sm" name="mail_princ" id="mail_princ" placeholder="example@gmail.com" disabled required>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default panel-okc">
				<div class="panel-heading">Descripción del Problema</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-12 col-sm-12">
									<h5>Descripción</h5>
									<textarea class="form-control input-sm" name="problema" id="problema" rows="10" placeholder="Escribir el motivo de la solicitud" disabled></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-2 col-sm-12">
									<h5>Fecha de Recepción</h5>
									<input type="date" class="form-control input-sm" name="fecha_rec" id="fecha_rec" disabled>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Tipo de Atención</h5>
									<select class="form-control input-sm" name="aten_tipo" id="aten_tipo" disabled required>
										<option value="0" selected disabled>Elija una opción</option>
										<?= $tipo_atencion ?>
									</select>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Fecha de Atención</h5>
									<input type="date" class="form-control input-sm" name="aten_fecha" id="aten_fecha" disabled>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Plazo de Atención</h5>
									<input type="number" class="form-control input-sm" name="aten_plazo" id="aten_plazo" min="1" value="1" disabled style="text-align: right;" required>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Fecha de Cierre</h5>
									<input type="date" class="form-control input-sm" name="fecha_cie" id="fecha_cie" disabled readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default panel-okc">
				<div class="panel-heading">Datos Extras</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-3 col-sm-12">
									<h5>Modalidad</h5>
									<select class="form-control input-sm" name="modalidad" id="modalidad" disabled required>
										<option value="0" selected disabled>Elija una opción</option>
										<?= $modalidad ?>
									</select>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Factura</h5>
									<input type="text" class="form-control input-sm" name="factura" id="factura" disabled>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Orden Compra</h5>
									<input type="text" class="form-control input-sm" name="orden_cc" id="orden_cc" disabled>
								</div>
								<div class="col-lg-2 col-sm-12">
									<h5>Cuadro Costo</h5>
									<input type="text" class="form-control input-sm" name="cuadro_cc" id="cuadro_cc" disabled>
								</div>
								<div class="col-lg-3 col-sm-12">
									<h5>Tipo de Intervención</h5>
									<select class="form-control input-sm" name="tipo_interv" id="tipo_interv" disabled required>
										<option value="0" selected disabled>Elija una opción</option>
										<?= $tipo_interv ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3 col-sm-12">
									<h5>Condición</h5>
									<select class="form-control input-sm" name="condicion" id="selectCondicion" disabled required>
										<option value="0" selected disabled>Elija una opción</option>
										<option value="oem">OEM</option>
										<option value="transformacion">Transformación</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row panel-okc">
				<div class="col-lg-3 col-sm-12" id="spaceEnd"></div>
				<div class="col-lg-6 col-sm-12">
					<button type="submit" class="btn btn-flat btn-sm btn-block btn-success input-sm" disabled> Grabar Solicitud</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- Modal Producto -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-producto">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Producto</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form class="formPage">
					<div class="row">
						<div class="col-lg-12">
							<h5>Marca</h5>
							<select class="form-control input-sm" name="marca" id="marca">
								<option value="0" selected disabled>Elija una opción</option>
								<?= $marcas ?>
							</select>
						</div>
						<div class="col-lg-12">
							<h5>Modelo</h5>
							<input type="text" class="form-control input-sm" name="modelo" id="modelo" onkeyup="javascript:this.value = this.value.toUpperCase();">
						</div>
						<div class="col-lg-12">
							<h5>Serie</h5>
							<input type="text" class="form-control input-sm" name="serie" id="serie" onkeyup="javascript:this.value = this.value.toUpperCase();">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-block btn-success" onclick="selectProd();">Seleccionar </button>
			</div>
		</div>
	</div>
</div>