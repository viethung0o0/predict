@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Admin
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('backend.admins.show_fields')
                    <a href="{!! route('admin.admin-managements.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
