<div class="form-group">
    {!! Form::label('name', '名称', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('name', null, ['class'=>'form-control']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('slug', '缩写', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('slug', null, ['class'=>'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', '描述', ['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-8">
        {!! Form::text('description', null, ['class'=>'form-control']) !!}
    </div>
</div>
<hr>
<div class="form-group">
    <div class="col-sm-9 col-sm-offset-1">
        @php
            $i = 0;
            $old_class = 0;
        @endphp
        @foreach($permissions as $permission)
            @if($old_class != $permission['class_id'])
                @if($i>0)
                    {{--正好类别中数量为3个，又需换类别时需少加一个</div>--}}
                    @if($i % 3 !=0)
                    </div>
                    @endif
                <br>
                @endif
            @php
                $i=0;
                $old_class = $permission['class_id'];
            @endphp
            <label>{{config('acl.permission_class.' . $permission->class_id)}}</label>
            @endif
            @if($i % 3 ==0)
                <div class="row">
                    @endif
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                {{--{!! Form::checkbox('permissions[]',  $permission->id ,null,['data-id'=>$permission->id,'data-inherit_id'=>$permission->inherit_id]) !!}--}}
                                <input name="permissions[]" value="{{ $permission->id }}"
                                       type="checkbox" data-id="{{ $permission->id }}" data-inherit_id="{{ $permission->inherit_id }}"
                                       @if(is_array(old('permissions')) && in_array($permission->id, old('permissions'))) checked @endif>{{  $permission->description }}
                            </label>
                        </div>
                    </div>
                    @php
                        $i= $i+1;
                    @endphp
                    @if($i % 3 ==0)
                </div>
            @endif

        @endforeach
    </div>
</div>
@push('js')
<script type="text/javascript">
    $('input[name="permissions[]"]').click(function(){
        if($(this).prop('checked')) {
            $('input[name="permissions[]"][data-id=' + $(this).data('inherit_id') + ']').prop('checked', $(this).prop("checked"));
        }
        else
        {
            if($('input[name="permissions[]"][data-inherit_id="' + $(this).data('inherit_id') + '"]').filter(':checked').length==0){
                $('input[name="permissions[]"][data-id=' + $(this).data('inherit_id') + ']').prop('checked', false);
            }
        }
    })
</script>
@endpush