<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <p>Registered Users</p>
    </a>
</li>

<!-- 
<li class="nav-item">
    <a href="{{ route('accountMasters.index') }}"
       class="nav-link {{ Request::is('accountMasters*') ? 'active' : '' }}">
        <p>Account Masters</p>
    </a>
</li> -->



