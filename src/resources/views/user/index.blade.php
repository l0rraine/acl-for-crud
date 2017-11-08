<table id="table" style="padding-top: 2em;"
       data-toggle="table"
       data-show-refresh="true"
       data-pagination="true"
       data-buttons-align="left"
       data-buttons-class="primary"
       data-toolbar="#myToolbar"
       data-search="true"
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
        <th data-field="name" data-searchable="true">姓名</th>
        <th data-field="email" data-formatter="emailFormatter" data-searchable="true">中石化邮箱</th>
        <th data-field="department.title" data-searchable="true">单位</th>
        <th data-field="department.pinyin" data-searchable="true" class="hidden">拼音</th>
        <th data-field="phone_num" data-searchable="true">电话</th>
        <th data-field="ip" data-searchable="true">IP</th>
        <th data-searchable="true" data-formatter="roleFormatter">角色</th>
        <th data-formatter="actionFormatter">操作</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('select_show_buttons')
    <div class="btn-group" style="margin-left: 20px;">
        <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">
            <span class="fa fa-superpowers" role="presentation" aria-hidden="true"></span> &nbsp;
            <span>分配角色</span>
            <i class="ace-icon fa fa-angle-down icon-on-right"></i>
        </button>
        <ul class="dropdown-menu">
            @foreach( $roles as $role)
                <li>
                    <a name="roleLink" href="javascript:void(0);" data-value="{{ $role['id'] }}">
                            <span style="width:50px;display:inline-block;text-align:right;">{{ $role['slug'] }}
                                | </span>
                        {{ $role['description'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endpush

<script type="text/javascript">
    function rownumberFormatter(value, data, index) {
        return 1 + index;
    }

    function emailFormatter(value, data, index) {
        return value + '.slyt';
    }

    function roleFormatter(value, data, index) {
        var result = '';
        for (var i = 0; i < data.roles.length; i++) {
            result += data.roles[i].slug;
            result += ',';
        }

        result = result.replace(/,$/, '');
        return result;

    }


    function actionFormatter(value, data, index) {
        return '<button class="btn btn-xs btn-primary" name="editBtn" data-id=' + data.id + '>编辑</button>';
    }


    function bindLink() {
        $('button[name=editBtn]').each(function () {
            var that = $(this);
            that.on('click', function () {
                var id = that.data('id');
                window.location.href = "{{ route('User.edit',':id') }}".replace(':id', id);
            })
        })
    }

    $('[name=roleLink]').click(function () {
        var id = $(this).data('value');
        var table = $('#table');
        var selections = table.bootstrapTable('getSelections', null);
        $.ajax({
            url: '{{ route($crud->route . '.grant',['id'=>':id']) }}'.replace(':id', id),
            method: 'POST',
            data: {'selections': JSON.stringify(selections)},
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            success: function (d) {
                var data = $.parseJSON(d);
                if (data.success) {
                    $.gritter.add({
                        title: '成功',
                        text: data.message,
                        class_name: 'gritter-success',
                        time: 1000,
                        fade_out_speed: 2000
                    });
                    //
                } else {
                    $.gritter.add({
                        title: '失败',
                        text: data.message,
                        time: 3000,
                        class_name: 'gritter-error'

                    });
                }
                table.bootstrapTable('refresh', null);
                table.bootstrapTable('uncheckAll');

            }

        });
    });


</script>
@endpush