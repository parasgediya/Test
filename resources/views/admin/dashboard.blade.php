@extends('layouts.app')

@section('content')
<div class='row'>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Teams</span>
                <span class="info-box-number" id="lblTeam">0</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Playes Group</span>
                <span class="info-box-number" id="lblGroup">0</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Players</span>
                <span class="info-box-number" id="lblPlayer">0</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number" id="lblUser">0</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div><!-- /.row -->
@endsection

@section('section_js')

<script>
$(document).ready(function() {
    getCounterajx();
    setInterval(() => {
        getCounterajx();
    }, 5000);
});

function getCounterajx() {
    $.ajax({
        type: "GET",
        url: 'getCounter',
        dataType: 'JSON',
        success: function(data) {
            $('#lblUser').text(data.user);
            $('#lblTeam').text(data.team);
            $('#lblGroup').text(data.group);
            $('#lblPlayer').text(data.player);
        }
    });
}
</script>
@endsection