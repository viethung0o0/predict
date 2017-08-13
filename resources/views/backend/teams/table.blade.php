@section('css')
    @include('backend.layouts.datatables_css')
@endsection

{!! $dataTable->table(['class' => 'table-bordered table-hover', 'width' => '100%']) !!}

@section('scripts')
    @include('backend.layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endsection