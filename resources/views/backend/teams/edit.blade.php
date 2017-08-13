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
                   {!! Form::model($admin, ['route' => ['admin.admin-managements.update', $admin->id], 'method' => 'patch']) !!}

                        @include('backend.admins.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection