<div class="container-page-large">
	<div class="row">
		<h3><strong>Equipos</strong></h3>
		<br>
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary btn-sm btn-flat" onclick="openModal('equipo');">
					<span class="icon-plus"></span>Nuevo Equipo
				</button>
			</div>
		</div>
		<br>
		<div class="col-md-12">
			<fieldset class="group-form">
				<legend><h5>Tabla de resultados</h5></legend>
				<table class="table table-hover table-bordered table-striped" id="tablaEquipo" width="100%">
					<thead>
						<tr>
							<th width="30">Código</th>
							<th>Tipo</th>
							<th>Marca / Modelo</th>
							<th>Serie</th>
							<th>Procesador</th>
							<th>Disco Duro</th>
							<th>Direcciones</th>
							<th>Slot's</th>
							<th>Accesorios</th>
							<!-- <th>Garantía</th> -->
							<th width="50">Acción</th>
						</tr>
					</thead>
				</table>
			</fieldset>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-equipo">
	<div class="modal-dialog modal-xxl">
		<div class="modal-content">
			<form class="formPage" id="formulario" form="equipo" type="register">
				<div class="modal-header">
					<h3 class="modal-title">Formulario de Registro</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary box-solid">
								<div class="box-header with-border">
									<h3 class="box-title">1. Datos del Equipo</h3>
								</div>
								<div class="box-body">
									<div class="row">
										<input type="hidden" name="id" id="id">
										<div class="col-md-2">
											<h5>Código</h5>
											<input type="text" class="form-control input-sm" name="code" id="code" placeholder="Ingrese el código"
											maxlength="7" required>
										</div>
										<div class="col-md-2">
											<h5>Tipo equipo</h5>
											<select class="form-control input-sm" name="type_eq" id="type_eq" required>
												<option value="" disabled selected>Elija una opción</option>
												<?=$select_tipoe?>
											</select>
										</div>
										<div class="col-md-2">
											<h5>Marca</h5>
											<select class="form-control input-sm" name="mark" id="mark" required>
												<option value="" disabled selected>Elija una opción</option>
												<?=$select_marca?>
											</select>
										</div>
										<div class="col-md-3">
											<h5>Modelo</h5>
											<input type="text" class="form-control input-sm" name="model" id="model" placeholder="Ingrese el modelo" required>
										</div>
										<div class="col-md-3">
											<h5>Serie</h5>
											<input type="text" class="form-control input-sm" name="serie" id="serie" placeholder="Ingrese la serie" required>
										</div>
									</div>
									<div class="row">
										<div class="col-md-9">
											<h5>Garantía</h5>
											<textarea class="form-control input-sm" name="garant" id="garant"></textarea>
										</div>
										<div class="col-md-3">
											<h5>Código Marca</h5>
											<input type="text" class="form-control input-sm" name="code_mark" id="code_mark" placeholder="Ingrese el código">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-8">
									<div class="box box-primary box-solid">
										<div class="box-header with-border">
											<h3 class="box-title">2. Especificación Técnica</h3>
										</div>
										<div class="box-body">
											<div class="row">
												<div class="col-md-9">
													<h5>Procesador</h5>
													<input type="text" class="form-control input-sm" name="process" id="process" placeholder="Ingrese el código" required>
												</div>
												<div class="col-md-3">
													<h5>Memorias</h5>
													<select class="form-control input-sm" name="slot" id="slot" onclick="createSlot(this.value);" required>
														<option value="" disabled selected>Elija una opción</option>
														<option value="1">1 Slot</option>
														<option value="2">2 Slots</option>
														<option value="3">3 Slots</option>
														<option value="4">4 Slots</option>
													</select>
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<h5>Disco Duro</h5>
													<select class="form-control input-sm" name="disk" id="disk" required>
														<option value="" disabled selected>Elija una opción</option>
														<option value="MEC">MEC</option>
														<option value="M2">M2</option>
														<option value="SSD">SSD</option>
													</select>
												</div>
												<div class="col-md-3">
													<h5>Marca</h5>
													<select class="form-control input-sm" name="mark_esp" id="mark_esp" required>
														<option value="" disabled selected>Elija una opción</option>
														<?=$select_marca?>
													</select>
												</div>
												<div class="col-md-6">
													<h5>Modelo</h5>
													<input type="text" class="form-control input-sm" name="model_esp" id="model_esp" placeholder="Ingrese el modelo" required>
												</div>
											</div>
											<div class="row">
												<div class="col-md-2">
													<h5>Capacidad</h5>
													<input type="text" class="form-control input-sm" name="capac" id="capac" placeholder="1 Tb">
												</div>
												<div class="col-md-6">
													<h5>Gráfico</h5>
													<input type="text" class="form-control input-sm" name="graphic" id="graphic" placeholder="Tarjeta gráfica">
												</div>
												<div class="col-md-4">
													<h5>Sistema Op.</h5>
													<input type="text" class="form-control input-sm" name="sisop" id="sisop" placeholder="Windows 10">
												</div>
											</div>
											<div class="row">
												<div class="col-md-4">
													<h5>Direc. MAC #1</h5>
													<input type="text" class="form-control input-sm" name="dir_mac1" id="dir_mac1" placeholder="fe80::6c87:75aa:3c30:f871%24">
												</div>
												<div class="col-md-4">
													<h5>Direc. MAC #2</h5>
													<input type="text" class="form-control input-sm" name="dir_mac2" id="dir_mac2" placeholder="fe80::6c87:75aa:3c30:f871%24">
												</div>
												<div class="col-md-4">
													<h5>Direc. MAC "3</h5>
													<input type="text" class="form-control input-sm" name="dir_mac3" id="dir_mac3" placeholder="fe80::6c87:75aa:3c30:f871%24">
												</div>
											</div>
											<div class="row">
												<div class="col-md-3">
													<h5>Direc. IP</h5>
													<input type="text" class="form-control input-sm" name="dir_ip" id="dir_ip" placeholder="192.168.1.1">
												</div>
												<div class="col-md-2">
													<div class="form-group" style="margin-top: 35px;">
														<div class="checkbox">
															<label><input type="checkbox" name="lan" value="1">LAN</label>
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<div class="form-group" style="margin-top: 35px;">
														<div class="checkbox">
															<label><input type="checkbox" name="wifi" value="1">WIFI</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="box box-primary box-solid">
										<div class="box-header with-border">
											<h3 class="box-title">3. Cantidad de Memorias</h3>
										</div>
										<div class="box-body">
											<div class="row" id="cantSlot"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="box box-primary box-solid">
										<div class="box-header with-border">
											<h3 class="box-title">4. Estado Actual</h3>
										</div>
										<div class="box-body">
											<div class="row">
												<div class="col-md-3">
													<h5>Estado Actual</h5>
													<select class="form-control input-sm" name="status_act" id="status_act">
														<option value="DE FABRICA">De Frabrica</option>
														<option value="MODIFICADO">Modificado</option>
														<option value="REPOTENCIADO">Repotenciado</option>
													</select>
												</div>
												<div class="col-md-9">
													<h5>Observaciones del Equipo</h5>
													<textarea class="form-control input-sm" name="obs_act" id="obs_act"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-success">Guardar datos del equipo</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Accesory -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-add-accesory">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form class="formPage" id="formAccesory">
				<div class="modal-header">
					<h3 class="modal-title">Accesorios</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="id_equipo_acc" id="id_equipo_acc">
							<div class="row">
								<div class="col-md-12">
									<h5>Descripción</h5>
									<input type="text" class="form-control input-sm" name="desc_accessory" id="desc_accessory" placeholder="Ingrese el nombre">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Detalles</h5>
									<textarea class="form-control input-sm" name="detail_accessory" id="detail_accessory"></textarea>
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

<!-- Modal Repotenciar -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-repower">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form class="formPage" id="formRepower">
				<div class="modal-header">
					<h3 class="modal-title">Repotenciar Equipo</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="id_equipo_acc_rpw" id="id_equipo_acc_rpw">
							<div class="row">
								<div class="col-md-12">
									<h5>Nombre de la pieza</h5>
									<textarea class="form-control input-sm" name="desc_repower" id="desc_repower"
										placeholder="Ingrese la descripción de la pieza"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Detalles</h5>
									<textarea class="form-control input-sm" name="detail_repower" id="detail_repower"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Autorizado por</h5>
									<input type="text" class="form-control input-sm" name="autor_repowe" id="autor_repowe" placeholder="Ejm: Jontahan Medina">
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

<!-- Modal Mofificar Equipo -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-modify-pc">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form class="formPage" id="formModify">
				<div class="modal-header">
					<h3 class="modal-title">Modificar Equipo</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" name="id_equipo_acc_mod" id="id_equipo_acc_mod">
							<div class="row">
								<div class="col-md-6">
									<h5>Pieza a modificar</h5>
									<textarea class="form-control input-sm" name="mod_pieza_1" id="mod_pieza_1"
										placeholder="Ingrese la descripción de la pieza"></textarea>
								</div>
								<div class="col-md-6">
									<h5>Pieza nueva</h5>
									<textarea class="form-control input-sm" name="mod_pieza_2" id="mod_pieza_2"
										placeholder="Ingrese la descripción de la pieza"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Observaciones/Detalles</h5>
									<textarea class="form-control input-sm" name="mod_obs" id="mod_obs"
										placeholder="Ingrese la descripción de la pieza"></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<h5>Autorizado por</h5>
									<input type="text" class="form-control input-sm" name="mod_autor" id="mod_autor" placeholder="Ejm: Jontahan Medina">
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

<!-- Modal Accesoss -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-add-access">
	<div class="modal-dialog modal-xxm">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Accesos</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4 col-sm-12">
						<form class="formPage" id="formAccess">
							<input type="hidden" name="id_equipo_acs" id="id_equipo_acs">
							<div class="row">
								<div class="col-md-12">
									<h5>Tipo</h5>
									<select class="form-control input-sm" name="access_tpo" id="access_tpo">
										<option value="" selected disabled>Elija una opción</option>
										<option value="LOCAL">Acceso Local</option>
										<option value="REMOTO">Acceso Remoto</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Aplicación</h5>
									<input type="text" class="form-control input-sm" name="access_app" id="access_app" placeholder="Ingrese nombre de la aplicación">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Usuario</h5>
									<input type="text" class="form-control input-sm" name="access_usu" id="access_usu" placeholder="Ingrese usuario del acceso">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Clave</h5>
									<input type="text" class="form-control input-sm" name="access_pas" id="access_pas" placeholder="Ingrese clave del acceso">
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Detalles</h5>
									<textarea class="form-control input-sm" name="access_det" id="access_det"></textarea>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-md-12">
									<button type="submit" class="btn btn-sm btn-success btn-block">Guardar</button>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-8 col-sm-12">
						<code>1. Tabla de Resultados</code>
						<table class="table table-condensed table-bordered">
							<thead>
								<th>Tipo</th>
								<th>Aplicación</th>
								<th>Usuario</th>
								<th>Clave</th>
							</thead>
							<tbody id="tableAccesos"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>