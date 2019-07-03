@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-8">
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
                        <table class="table table-striped" id="tbl_player">
                            <colgroup>
                                <col style="width:5%">
                                <col style="width:10%">
                                <col style="width:25%">
                                <col style="width:20%">
                                <col style="width:20%">
                                <col style="width:20%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Team</th>
                                    <th>Group</th>
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
                <form id='frmPlayer' enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modal_title">Add Player</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group {{ $errors->has('team_id') ? ' has-error' : '' }}">
                                    <label for="name">Team</label>
                                    {!! Form::select('team_id',['0'=>'Please select']+$team,null, ['class' => 'select2
                                    select2-hidden-accessible form-control','id'=>'team_id', 'style' => 'width: 100%'])
                                    !!}
                                    <span class="help-block">
                                        <strong id="eteam_id"></strong>
                                    </span>
                                </div>
                                <div class="form-group {{ $errors->has('team_id') ? ' has-error' : '' }}">
                                    <label for="name">Player Group</label>
                                    <select class="form-control" name="group_id" id="group_id" disabled></select>
                                    <span class="help-block">
                                        <strong id="egroup_id"></strong>
                                    </span>
                                </div>
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name</label>
                                    {!! Form::text('name', null, ['class' => 'form-control','id'=>'name']) !!}
                                    <span class="help-block">
                                        <strong id='ename'></strong>
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" onChange="AjaxUploadImage(this,'DisplayImage')"
                                            class="form-control">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <div class="thumbnail">
                                            <img src="{{ asset('images/default.jpg') }}" alt="" class="img-thumbnail"
                                                id="DisplayImage" style="width: 100px;height: 100px;">
                                        </div>
                                    </div>
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
var tbl_player;

function cmbGroup(id) {
    $('#group_id').empty();
    $.ajax({
        type: 'POST',
        url: "cmbGroup",
        data: {
            id: id
        },
        dataType: 'JSON',
        success: function(data) {
            if (data.length !== 0) {
                $('#group_id').removeAttr('disabled', 'disabled');
                $('#group_id').append(
                    '<option value="0" selected="selected">--Select Group--</option>'
                );
                $.each(data, function(key, value) {
                    $('#group_id').append('<option value="' + value.id + '">' +
                        value.name + '</option>');
                });
                $('#group_id').append(data);
            } else {
                $('#group_id').append(
                    '<option value="0" selected="selected">--Select category--</option>'
                );
                $('#group_id').attr('disabled', 'disabled');
            }
        }
    });
}
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*Getting Survey list*/
    var tbl_player = $('#tbl_player').dataTable({
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
            url: route_url + "/admin/players/fetchData",
            type: 'POST',
        },
        "columns": [{
                "data": null
            },
            {
                "data": null
            },
            {
                "data": null
            },
            {
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
                    if (data.image) {
                        return '<image src="' + base_url + '/' + data.image +
                            '" height="50" width="50">';
                    } else {
                        return '<image src="' + base_url + '/images/default.jpg" height="50" width="50">';
                    }
                }
            },
            {
                'targets': 2,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    if (data.name) {
                        return data.name;
                    } else {
                        return '-';
                    }
                }
            },
            {
                'targets': 3,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    if (data.team) {
                        return data.team;
                    } else {
                        return '-';
                    }
                }
            },
            {
                'targets': 4,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    if (data.group) {
                        return data.group;
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
            $('td', nRow).eq(5).html(links);
        }
    });

    $('#team_id').on('change', function() {
        var id = $(this).val();
        cmbGroup(id);
    });

    $('#frmPlayer').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('image', $('input[type=file]')[0].files[0]);
        formData.append('name', $('#name').val());
        formData.append('team_id', $('#team_id').val());
        formData.append('group_id', $('#group_id').val());
        if ($('#hidden_id').val() != "") {
            formData.append('hidden_id', $('#hidden_id').val());
        }
        $.ajax({
            type: 'POST',
            url: 'players',
            data: formData,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
                $('#catModal').modal('hide');
                Tost(data.msg, data.type);
                $('#tbl_player').DataTable().ajax.reload();
            },
            error: function(data) {
                $.each(data.responseJSON.errors, function(key, value) {
                    $("#e" + key).text(value).css('color', 'red');
                });
            }
        });
    });

    $('#add_modal_btn').on('click', function() {
        $("#save_btn").show();
        $("#update_btn").hide();
        $('#modal_title').html('Add Player');
        $('#frmPlayer').trigger("reset");
        $('#DisplayImage').attr('src', route_url + '/images/default.jpg');
        $('#ename').text('');
        $('#eteam_id').text('');
        $('#hidden_id').val('');
        $('#catModal').modal('show');
    });

    $('#tbl_player').on('click', '.btn_edit', function() {
        var dataid = $(this).attr('data-id');
        $("#save_btn").hide();
        $("#update_btn").show();
        $('#modal_title').html('Edit Player');
        $('#frmPlayer').trigger("reset");
        $('#ename').text('');
        $('#eteam_id').text('');
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
            url: route_url + '/admin/players/getformdata',
            success: function(obj) {
                if (obj.flag == 1) {
                    $('#hidden_id').val(obj.data.id);
                    $('#name').val(obj.data.name);
                    $('#team_id').val(obj.data.team_id);
                    cmbGroup(obj.data.team_id);
                    $('#group_id').val(obj.data.group_id);
                    $('#DisplayImage').attr('src', route_url + '/' + obj.data.image);
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

    $('#tbl_player').on('click', '.btn_delete', function() {

        var id = $(this).attr('data-id');

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this Player!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: 'POST',
                url: route_url + "/admin/players/del",
                data: {
                    cid: id
                },
                dataType: 'JSON',
                success: function() {
                    swal({
                        title: "Deleted!",
                        text: "Player has been deleted.",
                        type: "success"
                    }, function() {
                        $('#tbl_player').DataTable().ajax.reload();
                    });
                }
            });
        });
    });
});
</script>
@endsection