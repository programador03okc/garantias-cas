<div class="container-page">
	<div class="row">
		<h3><strong>Asignación de Equipos</strong></h3>
		<br>
		<div class="row">
			<div class="col-md-3">
				<div class="input-group input-group-sm">
					<input type="hidden" class="form-control" name="id_equipo" id="id_equipo">
					<input type="text" class="form-control" name="equipo" id="equipo" placeholder="11PC101" style="text-align: center;">
					<span class="input-group-btn">
						<button class="btn btn-default btn-flat" type="button" onclick="searchComputer();">Buscar equipo</button>
					</span>
				</div>
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-default btn-sm btn-flat btn-block" id="new-asign" onclick="newAsign();" disabled>
					<span class="icon-plus"></span>Nuevo Equipo
				</button>
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th width="80">N°</th>
							<th width="100">Equipo</th>
							<th width="120">Area</th>
							<th width="180">Solicitante</th>
							<th width="180">Responsable</th>
							<th width="120">F.Solicitud F.Entrega</th>
							<th>Motivo</th>
							<th width="180">Técnico</th>
						</tr>
					</thead>
					<tbody id="tbodyAsig"><tr><td colspan="8">No hay registros encontrados (seleccionar un equipo).</td></tr></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Asignacion -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-asignacion">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="formPage" id="formAsign">
				<div class="modal-header">
					<h3 class="modal-title">Asignación</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<input type="hidden" class="form-control" name="id_equipo_asg" id="id_equipo_asg">
							<input type="hidden" class="form-control" name="equipo_asg" id="equipo_asg">
							<div class="row">
								<div class="col-md-6">
									<h5>Fecha Solicitud</h5>
									<input type="date" class="form-control input-sm" name="fec_sol" id="fec_sol">
								</div>
								<div class="col-md-6">
									<h5>Fecha Entrega</h5>
									<input type="date" class="form-control input-sm" name="fec_ent" id="fec_ent">
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<h5>Area</h5>
									<input type="text" class="form-control input-sm" name="area" id="area">
								</div>
								<div class="col-md-6">
									<h5>Solicitante</h5>
									<input type="text" class="form-control input-sm" name="solic" id="solic">
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<h5>Responsable</h5>
									<input type="text" class="form-control input-sm" name="resp" id="resp">
								</div>
								<div class="col-md-6">
									<h5>Técnico</h5>
									<input type="text" class="form-control input-sm" name="tecni" id="tecni" value="<?=$userName?>" disabled>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<h5>Motivo</h5>
									<textarea class="form-control input-sm" name="motiv" id="motiv"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-sm btn-success">Guardar</button>
				</div>
			</form>
		</div>
	</div>
</div>