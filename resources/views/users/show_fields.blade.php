
<div class="col-sm-12">        
    <h2>
        {{ $users->name }}
        @if ($users->activity == 'active')
            <i class="fas fa-circle" style="font-size: .3em; color: green; vertial-align: center; align-items: center; padding-left: 5px;"></i>
        @else 
            <i class="far fa-circle" style="font-size: .3em; color: #bcbcbc; vertial-align: center; align-items: center; padding-left: 5px;"></i>
        @endif
    </h2>
    <p class="text-muted">
        {{ $users->username }} | {{ $users->email }} 
        
    </p>
</div>


