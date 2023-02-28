@extends('layout.app')

@section('main-content')
    <!-- Basic Bootstrap Table -->
    <div class="container-sm mt-5">
        <div class="card">
            <div class="d-flex card-header justify-content-between align-items-center">
                <h5 class="m-0">To-Do List Update</h5>
                <a href="{{route('home')}}" class="btn btn-primary">back</a>
            </div>

            <div class="card mb-4">
                @if(session('success'))
                    <div style="list-style-type: none;" class="alert alert-success text-center mt-2 ms-5 me-5">
                        <ul class="m-0">
                            <li>{{session('success')}}</li>
                        </ul>
                    </div>
                @endif
                @error('server_error')
                <div style="list-style-type: none;" class="alert alert-danger text-center mt-2 ms-5 me-5">
                    <ul class="m-0">
                        <li>{{$message}}</li>
                    </ul>
                </div>
                @enderror
                <div class="card-body">
                    <form method="post" action="{{route('home.update', ['id' => \Illuminate\Support\Facades\Crypt::encrypt($data->id)])}}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-date">Date (*)<span class="text-danger ms-4">@error('date') {{$message}}  @enderror</span></label>
                            <input value="{{$data->date}}" type="date" name="date" class="form-control" id="basic-default-date">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-title">Title (*)<span class="text-danger ms-4">@error('title') {{$message}}  @enderror</span></label>
                            <input type="text" value="{{$data->title}}" name="title" class="form-control" id="basic-default-title" placeholder="Meeting with orrangetoolz">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-description">Description</label>
                            <textarea name="description" rows="6" id="basic-default-description" class="form-control" placeholder="type here for something details....">{{$data->description}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection
