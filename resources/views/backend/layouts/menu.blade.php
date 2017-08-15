<li class="{{ Request::is('admin-managements*') ? 'active' : '' }}">
    <a href="{!! route('admin.admin-managements.index') !!}"><i class="fa fa-user"></i><span>Admins</span></a>
</li>
<li class="{{ Request::is('team-managements*') ? 'active' : '' }}">
    <a href="{!! route('admin.team-managements.index') !!}"><i class="fa fa-users"></i><span>Teams</span></a>
</li>
