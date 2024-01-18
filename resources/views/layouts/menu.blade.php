@php
    use App\Models\Users;
@endphp

@if (in_array(Auth::user()->username, Users::adminUsernames()))
<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <i class="fas fa-users ico-tab"></i><p>Registered Users</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('notifiers.index') }}"
       class="nav-link {{ Request::is('notifiers*') ? 'active' : '' }}">
       <i class="fas fa-bell ico-tab"></i><p>Notifiers</p>
    </a>
</li>
@endif

<!-- 
<li class="nav-item">
    <a href="{{ route('accountMasters.index') }}"
       class="nav-link {{ Request::is('accountMasters*') ? 'active' : '' }}">
        <p>Account Masters</p>
    </a>
</li> -->


{{-- <li class="nav-item">
    <a href="{{ route('thirdPartyTokens.index') }}"
       class="nav-link {{ Request::is('thirdPartyTokens*') ? 'active' : '' }}">
       <i class="fas fa-code ico-tab"></i><p>API Tokens</p>
    </a>
</li> --}}

<li class="nav-item">
    <a href="{{ route('thirdPartyTransactions.index') }}"
       class="nav-link {{ Request::is('thirdPartyTransactions*') ? 'active' : '' }}">
       <i class="fas fa-coins ico-tab"></i><p>API Collection</p>
    </a>
</li>


