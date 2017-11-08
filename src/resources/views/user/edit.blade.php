<div class="form-group">
    {!! Form::label('name', '姓名', ['class'=>'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('name', null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('email', '邮箱', ['class'=>'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <div class="input-group">
            {!! Form::requiredText('email', null, null, ['class'=>'form-control','style'=>'width:300px;'],'.slyt@sinopec.com') !!}
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('dep_id', '单位', ['class'=>'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        @include('crud::partials.select_form', ['select_name'=>'dep_id','datas'=>$deps,'chosen_id'=>$did, 'pinyin_search'=>1, 'select_width'=>300,'dropdown_height'=>300])
    </div>
</div>
<div class="form-group">

    {!! Form::label('phone_num', '电话', ['class'=>'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::hasValidatorText('phone_num', null, null,['class'=>'form-control','style'=>'width:300px;']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('ip', 'IP地址', ['class'=>'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::hasValidatorText('ip', null,null, ['class'=>'form-control','style'=>'width:300px;']) !!}
    </div>
</div>
@if(Route::has(config('qla.rolecrud.route_name_prefix', 'Crud.Role') . 'index'))
<div class="form-group">
    {!! Form::label('roles', '角色', ['class'=>'col-md-2 col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        @include('crud::partials.select_form', ['select_name'=>'role_ids','datas'=>$roles, 'chosen_id'=>json_encode($hasrole), 'title_attr'=>'name', 'multiple'=>1 ,'select_width'=>300])
    </div>
</div>
@endif
{!! Form::text('id', null, ['class'=>'form-control hidden']) !!}