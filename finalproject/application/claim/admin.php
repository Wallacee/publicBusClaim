<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Monitor |Projeto seleção</title>
        <?php include "../layout/header.php" ?>
        <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Monitor de transporte publico - Admin
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive margin">
                        <table id="table-claim" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Data/Hora</th>
                                    <th>Número do ônibus</th>
                                    <th>Reclamação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Editar reclamação</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="idclaim">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Data/Hora</label>
                        <input type="text" class="form-control" id="datefield" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Número do ônibus</label>
                        <input type="text" class="form-control" id="numbusfield" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Reclamação</label>
                        <input type="text" class="form-control" id="claimfield">
                    </div>
<!--                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Lido</label>
                        <input type="checkbox" id="readycheckfield">
                    </div>-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary btn-edit-claim">Salvar edição</button>
                </div>
            </div>
        </div>
    </div>
    <?php include "../layout/footer.php" ?>
    <script src="../../bower_components/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            (function () {
                var close = window.swal.close;
                var previousWindowKeyDown = window.onkeydown;
                window.swal.close = function () {
                    close();
                    window.onkeydown = previousWindowKeyDown;
                };
            })();

            $('#table-claim').DataTable({
                "ajax": {
                    "url": "claim.php",
                    "type": "POST",
                    "data": {method: "list_claim"},
                    "dataSrc": "claim"
                },

                "columns": [
                    {"data": "ID"},
                    {"data": "datetime"},
                    {"data": "bus_num"},
                    {"data": "message"},
                    {"data": null, render: function (data, type, row) {
                            return "<button id='btn-edit' title='Edit' class='btn btn-edit btn-warning btn-xs'data-toggle='modal' data-target='#modal-edit'><i class='fa fa-pencil'></i> Edit</button>  <button title='Delete' class='btn btn-delete btn-danger btn-xs'><i class='fa fa-remove'></i> Delete</button> ";
                        }}
                ]
            });

        });
//       
        $(document).on("click", ".btn-edit", function () {
            var table = $('#table-claim').DataTable();
            var data = table.row($(this).parents('tr')).data();
            $("#idclaim").val(data.ID);
            $("#datefield").val(data.datetime);
            $("#numbusfield").val(data.bus_num);
            $("#claimfield").val(data.message);
        });
        $(document).on("click", ".btn-edit-claim", function () {
            edit_claim($("#idclaim").val(), $("#datefield").val(), $("#numbusfield").val(), $("#claimfield").val());
        });
        $(document).on("click", ".btn-delete", function () {
            let current_row = $(this).parents('tr');
            if (current_row.hasClass('child')) {
                current_row = current_row.prev();
            }
            let table = $('#table-claim').DataTable();
            let data = table.row(current_row).data();
            let id = data.ID;
            swal({
                title: "Deletar reclamação?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Apagar",
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            },
                    function () {

                        let ajax = {
                            method: "delete_claim",
                            ID: id
                        }
                        $.ajax({
                            url: "claim.php",
                            type: "POST",
                            data: ajax,
                            success: function (data, textStatus, jqXHR)
                            {
                                $resp = JSON.parse(data);
                                if ($resp['status'] == true) {
                                    swal("Sucesso ao deletar reclamação");
                                    let xtable = $('#table-claim').DataTable();
                                    xtable.ajax.reload(null, false);
                                } else {
                                    swal("Erro ao apagar reclamação: " + $resp['message'])
                                }

                            },
                            error: function (request, textStatus, errorThrown) {
                                swal("Erro ", request.responseJSON.message, "error");
                            }
                        });
                    });
        });
        function edit_claim(_id, _datetime, _bus_num, _message) {
            let ajax = {
                method: "edit_claim",
                ID: _id,
                datetime: _datetime,
                bus_num: _bus_num,
                message: _message
            }
            $.ajax({
                url: "claim.php",
                type: "POST",
                data: ajax,
                success: function (data, textStatus, jqXHR)
                {
                    $resp = JSON.parse(data);
                    if ($resp['status'] == true) {
                        $("#modal-edit").modal("hide");
                        swal("Edição de reclamação realizada com sucesso!");
                        let xtable = $('#table-claim').DataTable();
                        xtable.ajax.reload(null, false);
                    } else {
                        swal("Erro ao salvar a reclamação: " + $resp['message'])
                    }
                },
                error: function (request, textStatus, errorThrown) {
                    swal("Error ", request.responseJSON.message, "error");
                }
            });
        }
    </script>
</body>
</html>
