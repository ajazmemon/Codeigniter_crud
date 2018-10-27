@extends('layouts.admin')
@section('title','Department')
@section('style')
{!! Html::style('bower_components/DataTables/media/css/dataTables.bootstrap.min.css') !!}
{!! Html::style('bower_components/DataTables/media/css/responsive.bootstrap.min.css') !!}
@endsection
@section('content')
<div class="wrap-content" id="container">
    <!-- start: BREADCRUMB -->
    <div class="breadcrumb-wrapper">
        <h4 class="mainTitle no-margin">DEPARTMENT</h4>
        <!--<span class="mainDescription">overview &amp; status </span>-->
        <ul class="pull-right breadcrumb">
            
        </ul>
    </div>
    <div class="alert alert-white" id="divi" style="margin-top:10px;display: none;">
            <strong id='msg'></strong>
        </div>
    
    <!-- end: BREADCRUMB -->
    <div class="department">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="add-department panel panel-white">
                    <div class="panel-heading">
                        <h5 class="panel-title">ADD DEPARTMENT</h5>
                    </div>
                    <div class="panel-body" style="padding: 25px">
                        {{Form::open(['url'=>'department/add','method'=>'POST','class'=>'GlobalFormValidation','id'=>'form'])}}
                        <div class="row">
                            <div class="col-sm-10 col-lg-offset-1" style="margin-top: 10px;">
                                @include('layouts.alert_process')
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('dname','<strong>DEPARTMENT NAME:</strong> <span class="required">e.g.Account Department</span>', [], false) }}
                            {{ Form::text('department', null ,array('placeholder' => ' Enter Department',
                            'class' => 'form-control',
                            'data-fv-notempty'=>"true",
                            'data-fv-notempty-message'=>"Please Enter Department" )) }}


                            @if($errors->has('department'))
                            <div class="error text-left" style='color: red'>
                                {{ $errors->first('department') }}
                            </div>
                            @endif
                        </div>
                        <div class="space20">
                            {{ Form::button('<i class="fa fa-plus"></i> Add', ['type' => 'submit', 'class' => 'btn btn-success add-row'] )  }}
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12">
                <div class="all-department">
                    <div class="panel panel-white">
                        <div class="panel-heading">
                            <h5 class="panel-title">ALL DEPARTMENTS</h5>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="data_table" width="100%" cellspacing="0">                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>DEPARTMENT NAME</th>
                                        <th>STATUS</th>
                                        <th class="desktop">ACTIONS</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">EDIT DEPARTMENT</h4>
            </div>

            <div class="modal-body" style="padding: 25px">

                {{ Form::open(['method' => 'PUT','class'=>'GlobalFormValidation']) }}

                <div class="row">
                    <div class="col-sm-10 col-lg-offset-1" style="margin-top: 10px;">
                        @include('layouts.alert_process')
                    </div>
                </div>
                <div class="form-group">

                    {{ Form::label('dname','<strong>DEPARTMENT NAME:</strong> <span class="required">e.g. Account Department</span>', [], false) }}
                    {{ Form::text('department', null ,array('placeholder' => ' Enter Department',
                    'class' => 'form-control',
                    'data-fv-notempty'=>"true",
                    'data-fv-notempty-message'=>"The  Department  is required",
                    'id'=>'dname')) }}

                    @if($errors->has('department'))
                    <div class="error text-left" style='color: red'>
                        {{ $errors->first('department') }}
                    </div>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-close"> Close</i>
                </button>
                <button type="submit" class="btn btn-success" id="btn_update">
                    <i class="fa fa-check-circle"> Update</i>
                </button>
            </div>
            {{Form::close()}}

        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">DELETE DEPARTMENT</h4>
            </div>
            <div class="modal-body">
                <label><strong>Are you sure you want to delete?</strong></label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-close"> Cancel</i>
                </button>
                <button type="button" class="btn btn-success" id="btn_delete">
                    <i class="fa fa-check-circle"> Yes</i>
                </button>
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
{!! Html::script('bower_components/formValidation/js/formValidation.min.js') !!}
{!! Html::script('bower_components/formValidation/js/framework/bootstrap.min.js') !!}
{!! Html::script('js/globalAjax.js') !!}
{!! Html::script('js/department/department.js') !!}
@endsection

