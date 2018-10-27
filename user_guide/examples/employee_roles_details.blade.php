@extends('layouts.admin')
@section('title','Employee Roles')
@section('style')
{!! Html::style('bower_components/select2/dist/css/select2.min.css') !!}
{!! Html::style('bower_components/DataTables/media/css/jquery.dataTables.min.css') !!}
{!! Html::style('bower_components/DataTables/media/css/dataTables.bootstrap.min.css') !!}
@endsection
@section('content')
<div class="wrap-content container" id="container">
    <!-- start: BREADCRUMB -->
    <div class="breadcrumb-wrapper">
        <h4 class="mainTitle no-margin">EMPLOYEE ROLES</h4>
        <!--<span class="mainDescription">overview &amp; status </span>-->

    </div>
    <div class="alert alert-white" id="divi" style="margin-top:10px;display: none;">
        <strong id='msg'></strong>
    </div>
    <!-- end: BREADCRUMB -->
    <div class="department">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="all-department emp-role">
                    <div class="panel panel-white">
                        <div class="panel-body employee-details">
                            <!--<table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-full-width text-center" id="employee_roles">
                                    <thead>
                                        <tr>
                                            <th>Permissions</th>
                                            
                                            
                                            @foreach ($roles as $rl)
                                            <th>
                                                {{$rl->name}}
                                            </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($abc as $a)
                                        <tr>
                                            <th>
                                                {{$a->name}}
                                            </th>
                                            @foreach ($roles as $rl)
                                            @if(\App\Http\Controllers\Roles\RoleController::check($arr,$rl->id,$a->id))
                                            @php($chk = 'checked')
                                            @else
                                            @php($chk = 'unchecked')
                                            @endif
                                            
                                            @if($rl->name == 'Administrator')
                                                @php($disable = 'disabled')
                                                @else
                                                @php($disable = 'enabled')
                                                @endif
                                            <td>
                                                <input type="checkbox" data-role-id='{{$rl->id}}' data-permission-id='{{$a->id}}'  id="employee" class="js-switch" value="{{$rl->name}}" <?= $chk; ?> <?=$disable?>/>
                                            </td>
                                            @endforeach
                                        </tr>

                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
@section('pagejs')
{{ Html::script('bower_components/DataTables/media/js/jquery.dataTables.min.js') }}
{{ Html::script('bower_components/DataTables/media/js/dataTables.bootstrap.min.js') }}
{{ Html::script('bower_components/DataTables/media/js/dataTables.responsive.min.js') }}
{{ Html::script('bower_components/DataTables/media/js/responsive.bootstrap.min.js') }}
{!! Html::script('bower_components/select2/dist/js/select2.min.js') !!}
{!! Html::script('js/roles/role_details.js') !!}
<script>$('#status').select2();
    $('#employee_roles').DataTable()
</script>
@endsection