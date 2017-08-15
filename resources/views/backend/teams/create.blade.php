@extends('backend.layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Admin
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.team-managements.store']) !!}

                        @include('backend.teams.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
