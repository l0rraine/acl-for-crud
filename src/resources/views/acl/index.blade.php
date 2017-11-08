<table id="table" style="padding-top: 2em;"
       data-toggle="table"
       data-show-refresh="true"
       data-pagination="false"
       data-buttons-align="left"
       data-buttons-class="primary"
       data-toolbar="#myToolbar"
       data-unique-id="id"
       data-url="{{ route($crud->route . 'indexJson') }}"
       data-escape="true"
       data-id-field="id"
       {{--data-editable-mode="inline"--}}
       data-editable-emptytext="空"
>
    <thead>
    <tr>
        <th data-field="state" data-checkbox="true"></th>
        <th data-formatter="rownumberFormatter" data-align="center">序号</th>
        <th data-field="name">名称</th>
        <th data-field="slug">调用名</th>
        <th data-field="description">描述</th>
        <th data-formatter="actionFormatter">操作</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>


@push('js')
<script type="text/javascript">

    function rownumberFormatter(value, data, index) {
        return 1 + index;
    }

    function actionFormatter(value, data, index){
        value = '<button class="btn btn-primary btn-xs" name="editBtn" data-id=' + data.id + '>编辑</button>';
        if(data.users_count === "0"){
            value += '<button class="btn btn-primary btn-xs" name="grantBtn" data-id=' + data.id + '>未分配到用户</button>';
        }else{
            value += '<button class="btn btn-primary btn-xs" name="grantBtn" data-id=' + data.id + '>已分配到<span style="color:yellow;margin:0px 1px">' + data.users_count + '</span>用户</button>';
        }

        return value;
    }

    function bindLink() {
        $('button[name=editBtn]').click(function () {
            var that = $(this);
                var id = that.data('id');
                window.location.href = "{{ route('Role.edit',':id') }}".replace(':id', id);

        });

        $('button[name=grantBtn]').click(function () {
            var that = $(this);
            var id = that.data('id');
            window.location.href = "{{ route('Role.grant',':id') }}".replace(':id', id);

        });
    }
</script>
@endpush