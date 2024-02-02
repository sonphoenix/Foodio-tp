@extends('home') 
@section('main')
   <!-- Sidenav -->
   <div class="sidenav">
    <div class="profile">
        <img src="{{ asset('storage/' . (Auth::user()->profile_picture ? Auth::user()->profile_picture : 'defaultpfp.jpg')) }}" alt="Profile Picture" width="100" height="100">

        <div class="name">
            {{ $user->name }}
        </div>
        <div class="job">
            @if( $user->user_type==0 )
            Artisan
            @endif
            @if( $user->user_type==1 )
            Livreur
            @endif
            @if( $user->user_type==2 )
            Client
            @endif
        </div>
    </div>

    <div class="sidenav-url">
        <div class="url">
            <a href="/profile" class="active">Profile</a>
            <hr align="center">
        </div>
        <div class="url">
            <a href="{{ route('profile.edit') }}">update</a>
            <hr align="center">
        </div>
        <div class="url">
            <a href="/profile_history">history</a>
            <hr align="center">
        </div>
    </div>
</div>
<!-- End -->
    <div class="main">
        <h2>EDIT IDENTITY</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="adresse">Address</label>
                        <input type="text" id="adresse" name="adresse" value="{{ $user->adresse }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ $user->phone }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="profile_picture">New Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
