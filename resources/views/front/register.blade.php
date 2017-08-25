@extends('front.layout')

@section('title', 'Article')

@section('css')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="panel-heading">
           <div class="panel-title text-center">
                <h1 class="title">Pendaftaran E-Learning</h1>
                <hr />
            </div>
        </div>

        <div class="container">
            <form class="form-horizontal" action="{{ route('auth.post.register') }}" method="post">
            {{ csrf_field() }}
                <div class="form-group row">
                  <label for="name" class="col-lg-2 col-sm-12 col-form-label">Nama</label>
                  <div class="col-lg-10 col-sm-12">
                    <input class="form-control" type="text" name="name" placeholder="Nama Kamu" id="name">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="username" class="col-lg-2 col-sm-12 col-form-label">Username</label>
                  <div class="col-lg-10 col-sm-12">
                    <input class="form-control" type="text" name="username" placeholder="Username Kamu" id="username">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="email" class="col-lg-2 col-sm-12 col-form-label">Email</label>
                  <div class="col-lg-10 col-sm-12">
                    <input class="form-control" type="email" placeholder="alamat@email.kamu" id="email" name="email">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="password" class="col-lg-2 col-sm-12 col-form-label">Sandi</label>
                  <div class="col-lg-10 col-sm-12">
                    <input class="form-control" type="password" placeholder="sandi kamu" id="password" name="password">
                  </div>
                </div>

                <div class="form-group ">
                    <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Daftar</button>
                </div>

                <div class="">
                    <p>Punya akun? <a href="#">Login</a></p>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')

@endsection
