@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5>Set Roles for {{ $user->name }}</h5>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-4 offset-md-4 col-lg-4 offset-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <span><i class="fas fa-key ico-tab"></i>Choose Roles</span>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1">
                            <form class="form-horizontal" method="POST" action="{{ url('users/create-user-roles') }}">
                            @csrf
                            @foreach($roles as $role) 
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" value="{{ $role->id }}" name="roles[]" @if($user->roles) @if(in_array($role->id, $user->roles->pluck('id')->toArray())) checked @endif @endif>
                                    <label for="roles" class="form-check-label">{{ $role->name }}</label>
                                </div>
                            @endforeach
                            <!-- ADD USER ID -->
                            <input type="hidden" name="userId" value="{{ $user->id }}">

                            <br>
                            <!-- SUBMIT -->
                            <button type="submit" class="btn btn-sm btn-info"><i class="fas fa-fw fa-forward"></i> Next</button> 
                            </form>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection