@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="box-header-actions text-right">
                    <button type="button" class="btn btn-primary" id="add_modal_btn">Add New</button>
                </div>
            </div>
            <div class="box-body" id='category'>
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-striped" id="tbl_team">
                            <colgroup>
                                <col style="width:5%">
                                <col style="width:45%">
                                <col style="width:20%">
                                <col style="width:25%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
    </div>
    <!-- Modal -->
    <div id='catModal' class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id='frmTeam'>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_title">Add Team</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-danger print-error-msg" style="display:none">
                                    <ul></ul>
                                </div>
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name</label>
                                    {!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
                                    <span class="help-block">
                                        <strong id='ename'></strong>
                                    </span>                                    
                                </div>
                                <input type="hidden" name="hidden_id" id="hidden_id" value="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="update_btn">Update</button>
                        <button type="submit" class="btn btn-primary" id="save_btn">Save</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
@endsection

@section('section_js')

<script>
var tbl_team;

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*Getting Survey list*/
    var tbl_team = $('#tbl_team').dataTable({
        destroy: true,
        "tabIndex": 1,
        "processing": true,
        "serverSide": true,
        "aaSorting": [
            [0, "asc"]
        ],
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw" style="opacity: 0.6;color:#1b731b;"></i><span class="sr-only"></span> ',
            paginate: {
                next: '<i class="fa fa-angle-right" aria-hidden="true"></i>', // or '>'
                previous: '<i class="fa fa-angle-left" aria-hidden="true"></i>', // or '<' 
            }
        },
        "pagingType": "full_numbers",
        ajax: {
            url: route_url + "/admin/teams/fetchData",
            type: 'POST',
        },
        "columns": [{
                "data": null
            },
            {
                "data": null
            },
            {
                "data": null,
                "orderable": false
            },
        ],
        "columnDefs": [{
                'targets': 0,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    return data.id;
                }
            },
            {
                'targets': 1,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    if (data.name) {
                        return data.name;
                    } else {
                        return '-';
                    }
                }
            }
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var links = "<a class='btn btn-primary btn-sm btn_edit' data-id=" + aData.id +
                " ><i class='fa fa-edit'></i></a>&nbsp;" +
                "<a class='btn btn-danger btn-sm btn_delete' data-id=" + aData.id +
                "><i class='fa fa-trash'></i></a>";
            $('td', nRow).eq(2).html(links);
        }
    });

    $('#frmTeam').submit(function(e) {
        e.preventDefault();
        var data = $('#frmTeam').serialize();
        $.ajax({
            type: 'POST',
            url: 'teams',
            data: data,
            dataType: 'JSON',
            success: function(data) {
                $('#catModal').modal('hide');
                Tost(data.msg, data.type);
                $('#tbl_team').DataTable().ajax.reload();
            },
            error: function(data) {
                $.each(data.responseJSON.errors, function(key, value) {
                    $("#e"+key).text(value).css('color','red');
                });
            }
        });
    });

    $('#add_modal_btn').on('click', function() {
        $("#save_btn").show();
        $("#update_btn").hide();
        $('#modal_title').html('Add Club');
        $('#frmTeam').trigger("reset");
        $('#ename').text('');
        $('#euser_id').text('');
        $('#hidden_id').val('');
        $('#catModal').modal('show');
    });

    $('#tbl_team').on('click', '.btn_edit', function() {
        var dataid = $(this).attr('data-id');
        $("#save_btn").hide();
        $("#update_btn").show();
        $('#modal_title').html('Edit Club');
        $('#name').val('');
        $('#ename').text('');
        $('#euser_id').text('');
        $('#hidden_id').val('');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            async: false,
            data: {
                'id': dataid
            },
            dataType: "json",
            url: route_url + '/admin/teams/getformdata',
            success: function(obj) {
                if (obj.flag == 1) {
                    $('#hidden_id').val(obj.data.id);
                    $('#name').val(obj.data.name);
                    $('#catModal').modal('show');

                } else if (obj.flag == 0) {
                    Tost(obj.message, 'warning');
                }
            },
            error: function(response) {
                Tost('Something went wrong!', 'warning');
            }
        });

    });

    $('#tbl_team').on('click', '.btn_delete', function() {

        var id = $(this).attr('data-id');

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this Club!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: 'POST',
                url: route_url + "/admin/teams/del",
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function() {
                    swal({
                        title: "Deleted!",
                        text: "Club has been deleted.",
                        type: "success"
                    }, function() {
                        $('#tbl_team').DataTable().ajax.reload();
                    });
                }
            });
        });
    });
});
</script>
@endsection