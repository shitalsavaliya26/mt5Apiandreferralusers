<li class="nav-item {{ Request::is('companies*') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('companies.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>Companies</span>
    </a>
</li>


<li class="nav-item {{ Request::is('employees*') ? 'active' : '' }}">
    <a class="nav-link" href="{!! route('employees.index') !!}">
        <i class="nav-icon icon-cursor"></i>
        <span>Employees</span>
    </a>
</li>

<li class="{{ Request::is('posts*') ? 'active' : '' }}">
    <a href="{{ route('posts.index') }}"><i class="fa fa-edit"></i><span>@lang('models/posts.plural')</span></a>
</li>

