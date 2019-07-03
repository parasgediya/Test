@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Users List</h3>
                <div class="box-header-actions text-right">
                    <a href="{{ URL::to('admin/users/add') }}" class="btn btn-primary">Add New</a>
                </div>
            </div>

            <div class="box-body" id='users'>
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-striped" id="tbl_users">
                            <colgroup>
                                <col style="width:5%">
                                <col style="width:15%">
                                <col style="width:20%">
                                <col style="width:20%">
                                <col style="width:10%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
    </div>

</div>

@endsection

@section('section_js')

<script>
var table;

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /*Getting Survey list*/
    var table = $('#tbl_users').DataTable({
        destroy: true,
        "tabIndex": 1,
        "processing": true,
        "serverSide": true,
        "aaSorting": [
            [0, "desc"]
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
            url: route_url + "/admin/users/fetchData",
            type: 'POST',
            // async : false,
        },
        "columns": [{
                "data": null
            },
            {
                "data": null,
                "orderable": false
            },
            {
                "data": null,
                "orderable": false
            },
            {
                "data": null,
                "orderable": false
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
                    if (data.firstname) {
                        return data.firstname + ' ' + data.lastname;
                    } else {
                        return '-';
                    }
                }
            },
            {
                'targets': 2,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    if (data.email) {
                        return data.email;
                    } else {
                        return '-';
                    }
                }
            },
            {
                'targets': 3,
                'className': 'dt-body-center',
                'render': function(data, type, full, meta) {
                    var select = $(
                        "<select class='form-control' onchange='updateRole(this)' data-id='" +
                        data.id +"'><option value='admin'>Super Admin</option><option value='club'>Club Admin</option></select>"
                    );
                    select.find('option[value="' + data.role + '"]').attr('selected',
                        'selected');
                    return select[0].outerHTML
                }
            }
        ],
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var links = "<a href='" + route_url + '/admin/users/edit/' + aData.id +
                "' class='btn btn-primary btn-sm btn_view ' data-id=" + aData.id +
                " ><i class='fa fa-edit'></i></a>&nbsp;" +
                "<a href='" + route_url + '/admin/impersonate/user/' + aData.id +
                "' title='Impersonate' class='btn btn-success btn-sm ' data-id=" + aData.id +
                " ><i class='fa fa-clone'></i></a>&nbsp;" +
                "<a class='btn btn-danger btn-sm btn_delete' data-id=" + aData.id +
                "><i class='fa fa-trash'></i></a>";
            $('td', nRow).eq(4).html(links);
        }
    });

    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();

    $('#tbl_users').on('click', '.btn_delete', function() {
        var id = $(this).attr('data-id');
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this user!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                type: 'POST',
                url: route_url + "/admin/users/del",
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function() {
                    swal({
                        title: "Deleted!",
                        text: "User has been deleted.",
                        type: "success"
                    }, function() {
                        $('#tbl_users').DataTable().ajax.reload();
                    });
                }
            });
        });
    
    });

});

@if(\Session::has('Success'))
Tost("{{\Session::get('Success')}}", 'success');
@endif
</script>
@endsection