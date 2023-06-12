        </section>
	</div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalSettings">
        <div class="modal-dialog" style="width: 400px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Configuraciones</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="box box-success box-solid collapsed-box">
                        <div class="box-header with-border">
                            <h5 class="box-title"><span class="glyphicon glyphicon-lock"></span> Cambio de contraseña</h5>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <form id="formSettingsPassword" class="form-cfg">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Clave Actual</span>
                                            <input type="text" name="pass_1" class="form-control input-sm" placeholder="Clave actual">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Nueva Clave</span>
                                            <input type="text" name="pass_2" class="form-control input-sm" placeholder="Nueva clave">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon">Confirmar Clave</span>
                                            <input type="text" name="pass_3" class="form-control input-sm" placeholder="Repita nueva clave">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-success btn-flat btn-sm">Grabar 
                                            <span class="fa fa-save"></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-tipo-cambio">
        <div class="modal-dialog" style="width: 200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tipo de Cambio</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="formTypeChange">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Fecha:</h5>
                                <input type="date" name="fecha" class="form-control input-sm" value="<?=date('Y-m-d');?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Valor:</h5>
                                <input type="number" name="valor" class="form-control input-sm" step="any">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block btn-sm">Grabar 
                                    <span class="fa fa-save"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?=base_url('assets')?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?=base_url('assets')?>/plugins/jQueryUI/jquery-ui.min.js"></script>
    <script src="<?=base_url('assets')?>/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=base_url('assets')?>/bootstrap_filestyle/src/bootstrap-filestyle.min.js"></script>
    <script src="<?=base_url('assets')?>/template/js/app.min.js"></script>
    <script src="<?=base_url('assets')?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets')?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?=base_url('assets')?>/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?=base_url('assets')?>/js/sweetalert.min.js"></script>
    <script src="<?=base_url('assets')?>/plugins/chartjs/Chart.min.js"></script>
    <script src="<?=base_url('assets')?>/js/moment.min.js"></script>
    <script type="text/javascript"> var baseUrl = '<?=base_url();?>'; </script>
    <script src="<?=base_url('assets')?>/js/app.js"></script>
</body>
</html>