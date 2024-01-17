@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>{{$project->title}}</h3>
                <p>{{$project->description}}</p>
                <img src="{{$project->image_path}}" alt="{{$project->title}}" class="img-fluid">
                <a href="{{route('admin.projects.index')}}" class="btn btn-primary">Back to The List</a>
            </div>
        </div>
    </div>
@endsection