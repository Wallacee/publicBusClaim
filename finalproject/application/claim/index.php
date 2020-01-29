<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Central de reclamações</title>
        <?php //include "../layout/header.php" ?>
        <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
              folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="../../bower_components/bootstrap-sweetalert/dist/sweetalert.css"> 
        <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.css"> 
        <link href="../../dist/css/bootstrap-datetime/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>

        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Realizar reclamação
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box" >
                <div class="box-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="dtp_input1" class="col-sm-3 control-label">Data/Hora</label>
                            <div class="input-group date control-label form_datetime col-sm-9" data-date-format="yyyy-mm-dd HH:mm:ss" data-link-field="dtp_input1">
                                <input class="form-control" size="16" id="datetime" type="text" value="" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Número do ônibus</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="busnumber" maxlength="15" placeholder="Número do ônibus">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reclamação</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" maxlength="150" id="message" placeholder="...">
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" title="Salavar reclamação" id="btn-save"> <i class="fa fa-save"></i>Salvar</button>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include "../layout/footer.php" ?>
    <script src="../../bower_components/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.js"></script>
    <script src="../../plugins/bootstrap-datetime/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="../../plugins/bootstrap-datetime/bootstrap-datetimepicker.pt-BR.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.form_datetime').datetimepicker({
                language: 'pt-BR',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1
            });


            $("#btn-save").click(function () {
                if ($("#datetime").val() == '') {
                    swal("Insira uma data válida");
                    return;
                }
                if ($("#busnumber").val() == '') {
                    swal("Isira o numero número válido");
                    return;
                }
                if ($("#message").val() == '') {
                    swal("Insira uma reclamação válida");
                    return;
                }

                add_claim($("#datetime").val(), $("#busnumber").val(), $("#message").val());
            });
            function add_claim(_datetime, _busnumber, _message) {
                let ajax = {
                    method: "new_claim",
                    datetime: _datetime,
                    bus_num: _busnumber,
                    message: _message
                }
                $.ajax({
                    url: "claim.php",
                    type: "POST",
                    data: ajax,
                    success: function (data, textStatus, jqXHR)
                    {
                        swal("Reclamação salva com sucesso");
                        $("#datetime").val("");
                        $("#busnumber").val("");
                        $("#message").val("");
                    },
                    error: function (request, textStatus, errorThrown) {
                        swal("Error ", request.responseJSON.message, "error");
                    }
                });
            }
        });

    </script>
</body>
</html>
