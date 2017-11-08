<table id="table" style="padding-top: 2em;"
       data-toggle="table"
       data-buttons-align="left"
       data-buttons-class="primary"
       data-toolbar="#myToolbar"
       data-search="true"
       data-search-align="left"
       data-unique-id="id"
       data-url="{{ config('qla.usercrud.route_name_prefix', 'Crud.User') . '.indexJson' }}"
       data-escape="true"
       data-id-field="id"
       data-pagination="true"
       data-maintain-selected="true"
       data-editable-emptytext="空"
>
    <thead>
    <tr>
        <th data-field="state" data-checkbox="true"></th>
        <th data-formatter="rownumberFormatter" data-align="center">序号</th>
        <th data-field="name" data-searchable="true">姓名</th>
        <th data-field="department.title" data-searchable="true">单位</th>
        <th data-field="department.pinyin" data-searchable="true" class="hidden">拼音</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>


@push('post_js')
    <script type="text/javascript">
        function rownumberFormatter(value, data, index) {
            return 1 + index;
        }

        var table = $('#table');

        table.on('post-body.bs.table', function (data) {
            table.bootstrapTable('checkBy', {field: 'id', values:{!! json_encode($selections) !!}});
        });
        $(document).ready(function () {
            var saveActions = $('#saveActions'),
                crudForm = saveActions.parents('form'),
                saveActionField = $('[name="save_action"]');

            crudForm.submit(function () {
                $('#selections').val(JSON.stringify(table.bootstrapTable('getSelections', null)));
            });


            table.on('post-body.bs.table', function (data) {
                table.show();
                resizeFrame();
            });

        });
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/qla/js/bootstrap-table-1.11.1/bootstrap-table.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/qla/js/jquery-gritter/jquery.gritter.min.css') }}"/>
@endpush

@push('js')
    <script src="{{ asset('vendor/qla/js/jquery-gritter/jquery.gritter.min.js') }}"></script>
@endpush
@push('pre_js')
    <script src="{{ asset('vendor/qla/js/bootstrap-table-1.11.1/bootstrap-table.js') }}"></script>
    <script src="{{ asset('vendor/qla/js/bootstrap-table-1.11.1/locale/bootstrap-table-zh-CN.min.js') }}"></script>
@endpush