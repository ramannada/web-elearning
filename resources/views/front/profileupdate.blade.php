@extends('front.layout')
@section('title', 'E-Learning')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
<div class="col-md-8 offset-md-2">
	<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#profil" role="tab">Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#password" role="tab">Follow</a>
    </li>
</ul>
<!-- Tab panels -->
<div class="tab-content card">
    <!--Panel 1-->
    <div class="tab-pane active" id="profil" role="tabpanel">
        <br>
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{route('profile.post.update')}}">
{{ csrf_field() }}
  <div class="">
    <label for="inputName" class="offset-md-1 control-label">Nama</label>
    <div class="col-md-10 offset-md-1">
      <input type="text" class="form-control" id="inputName" name="name" value="{{$user->name}}" placeholder="Nama Lengkap">
    </div>
     @isset (session('error')->name) <p class="help-block">{{ session('error')->name[0] }}</p> @endisset
  </div>

  <div class="">
    <label for="inputPhone" class="offset-md-1 control-label">Telepon</label>
    <div class="col-md-10 offset-md-1">
      <input type="text" class="form-control" id="inputPhone" name="phone" value="{{$user->phone_number}}" placeholder="Telepon">
    </div>
     @isset (session('error')->phone_number) <p class="help-block">{{ session('error')->phone_number[0] }}</p> @endisset
  </div> 

  <div class="">
      <label for="" class="offset-md-1"> Foto</label><br>
      <div class="col-md-10 offset-md-1">

        <div class="col-md-4">
            <!-- <img src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/img/avatar.png" alt="" class="img-thumbnail rounded-circle" id="image"> -->
                <input type="file" id="file" name="photo" class="manual-file-chooser height-full width-full ml-0">
        </div>

      </div>

  </div>

  <div class="">

    <div class="offset-md-1">
<br>
      <button type="submit" class="btn btn-danger ">Submit</button>

    </div>

  </div>

</form>
    </div>
    <!--/.Panel 1-->
    <!--Panel 2-->
    <div class="tab-pane fade" id="password" role="tabpanel">
        <br>
<form class="form-horizontal" method="post" action="{{route('profile.changepassword')}}">
	    {{ csrf_field() }}
	      @if ($errors->any())
	          <div class="alert alert-danger">
	              <ul>
	                  @foreach ($errors->all() as $error)
	                      <li>{{ $error }}</li>
	                  @endforeach
	              </ul>
	          </div>
	      @endif   

	      <div class="">
	        <label for="password_lama" class="col-sm-4 control-label">Password Lama</label>
	        <div class="col-sm-10">
	          <input type="password" class="form-control" id="password_lama" name="password_lama" placeholder="Password Lama">
	        </div>
	         @isset (session('error')->old_password) <p class="help-block">{{ session('error')->old_password[0] }}</p> @endisset
	      </div>
	      
	      <div class="">
	        <label for="password_baru" class="col-sm-4 control-label">Password baru</label>
	        <div class="col-sm-10">
	          <input type="password" class="form-control" id="password_baru" name="password_baru" placeholder="Password Baru">
	           @isset (session('error')->new_password) <p class="help-block">{{ session('error')->new_password[0] }}</p> @endisset
	        </div>
	      </div>

	      <div class="">
	        <label for="verifikasi_password" class="col-sm-4 control-label">Konfirmasi Password</label>
	        <div class="col-sm-10">
	          <input type="password" class="form-control" id="verifikasi_password" name="verifikasi_password" placeholder="Konfirmasi Password">
	        </div>
	        @isset (session('error')->confirm_new_password) <p class="help-block">{{ session('error')->confirm_new_password[0]}}</p> @endisset
	      </div>

	      <div class="">
	        <div class="col-sm-offset-2 col-sm-10">
	          <button type="submit" class="btn btn-danger">Submit</button>
	        </div>
	      </div>

	    </form>
    </div>
    <!--/.Panel 2-->
</div>
</div>
<!-- Nav tabs -->

             





                      
                        
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js">
</script>
<script>
function activaTab(tab){
   $('.nav-tabs a[href="#' + tab + '"]').tab('show');
};
activaTab('{{session('tab')}}');
</script>
@include('sweet::alert')
@endsection