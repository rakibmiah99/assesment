@extends('layout.app')

@section('main-content')
    <!-- Basic Bootstrap Table -->
    <div class="container-sm mt-5">
        <div class="card text-center">
            <div class="card-header">Delete</div>
            <div class="card-body">
                <h5 class="card-title">Are you want to delete this data?</h5>
                <p class="card-text">Ones you delete. You can't undo this.</p>
                    <form action="{{route('home.delete', ['id' => $id])}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger me-2">Delete</button>
                        <a href="{{route('home')}}" class="btn btn-secondary">Cancel</a>
                    </form>
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection
