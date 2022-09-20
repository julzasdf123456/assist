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



<li class="nav-item">
    <a href="{{ route('notifiers.index') }}"
       class="nav-link {{ Request::is('notifiers*') ? 'active' : '' }}">
        <p>Notifiers</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('thirdPartyTokens.index') }}"
       class="nav-link {{ Request::is('thirdPartyTokens*') ? 'active' : '' }}">
        <p>Third Party Tokens</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('thirdPartyTransactions.index') }}"
       class="nav-link {{ Request::is('thirdPartyTransactions*') ? 'active' : '' }}">
        <p>Third Party Transactions</p>
    </a>
</li>


