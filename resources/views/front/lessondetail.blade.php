@extends('front.layout')
@section('title', 'E-Learning')

@section('css')
<style>
    .lesson-part:hover{
        text-decoration: none;
    }
    .hitam{
        color: #000;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="card card-block" style="margin-top: 30px;"> 
        <div class="row">
             <div class="col-md-12">
                 <!-- <div class="row hidden-md hidden-lg"><h1 class="text-center" >TITULO LARGO DE UNA INVESTIGACION cualquiera</h1></div> -->
                     
                <!--  <div class="pull-left col-md-4 col-xs-12 thumb-contenido"><img class="center-block img-responsive" src='http://placehold.it/500x500' /></div> -->
                
                     
                        <h1  class="hidden-xs hidden-sm">{{ $lesson->data->title }}</h1>
                        <small class="col-2"><strong>{{ $lesson->data->owner }}</strong></small>
                        <hr>
                       
                        {{-- @foreach ($article->categories->data as $q => $category) --}}
                           {{--  <span class="badge badge-pill badge-default"><a href="#" style="color: #fff;">Ilmu Komputer</a></span> 
                            <span class="badge badge-pill badge-default"><a href="#" style="color: #fff;">Pengembangan Web</a></span>  --}}

                @if ($lesson->category->data)
                    @foreach ($lesson->category->data as $q => $category)
                        <span class="badge badge-pill badge-default">
                            <a href="{{ route('lesson.by.category', ['article' => $category->category->slug]) }}" style="color: #fff;">{{$category->category->category}}</a>
                        </span> 

                    @endforeach
                    <hr>
                @endif
                        
                     
                     <div class="row">
                         <div class="col-9">
                            <img class="img-fluid" src="{{url($lesson->data->thumbnail)}}" alt="default.jpg" style="max-width: 100%;">
                            <div class="clearfix"></div><br>

                            <p class="text-justify">
                               {{ $lesson->data->summary }}
                            </p>
                            <hr>
                            <h3>Lesson Part</h3>
                          
                            @isset ($part->data)
                                @php
                                    $i = 1;
                                @endphp
                                    @foreach ($part->data as $val)
                                        <ul class="list-group">
                                            <a href="{{ url()->current() ."/". $val->slug  }}" class="lesson-part">
                                                <li class="list-group-item hitam">
                                                    {{ $i++ }} &nbsp;&nbsp;&nbsp;
                                                    <i class="fa fa-film"  > </i> 
                                                    &nbsp;&nbsp;&nbsp;
                                                    <span class="hitam">{{ $val->title }}</span>
                                                    &nbsp;&nbsp;&nbsp; 
                                                    <span class="badge badge-pill badge-primary" style="color: #fff;">Video</span>
                                                </li>
                                            </a>
                                    @endforeach
                            @endisset

                            @isset ($part->error)
                                <p>{{ $part->error->message }}</p>
                            @endisset


                            {{-- <h3>Lesson Part</h3>
                            @php
                                $no =1;
                            @endphp
                            <ul class="list-group">
  <a href="" class="lesson-part"><li class="list-group-item hitam">1. &nbsp;&nbsp;&nbsp;<i class="fa fa-film"  > </i> &nbsp;&nbsp;&nbsp;<span class="hitam">Cras justo odio </span>&nbsp;&nbsp;&nbsp; <span class="badge badge-pill badge-primary" style="color: #fff;">
                                Video
                            </span></li></a>
  <li class="list-group-item">2. &nbsp;&nbsp;&nbsp;<i class="fa fa-film"> </i> &nbsp;&nbsp;&nbsp;Dapibus ac facilisis in</li>
  <li class="list-group-item">3. &nbsp;&nbsp;&nbsp;<i class="fa fa-film"> </i> &nbsp;&nbsp;&nbsp;Morbi leo risus</li>
  <li class="list-group-item">4. &nbsp;&nbsp;&nbsp;<i class="fa fa-film"> </i> &nbsp;&nbsp;&nbsp;Porta ac consectetur ac</li>
  <li class="list-group-item">5. &nbsp;&nbsp;&nbsp;<i class="fa fa-film"> </i> &nbsp;&nbsp;&nbsp;Vestibulum at eros</li>
</ul> --}}
                         </div>

                         <div class="col-3">
                             <div class="card card-block">
                                 <h5 class="text-center">{{ $lesson->data->type }}</h5>
                                 {{-- <div class="clearfix"></div><br> --}}
                                 <hr>
                                 <p>Kategori: Umum</p>
                                 <p>Jumlah Kursus: 26 bagian</p>
                                 <p>Diterbitkan: 12 Juli 2016</p>
                             </div>
                         </div>
                     </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
