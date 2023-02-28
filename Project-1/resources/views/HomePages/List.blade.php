@extends('layout.app')

@section('main-content')
    <!-- Basic Bootstrap Table -->
    <div class="container-sm mt-5">
        @if(session('success'))
            <div  class="alert alert-success text-center mt-2 ms-5 me-5">
                <ul style="list-style-type: none;" class="m-0">
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

        <div class="card">
            <div class="d-flex card-header justify-content-between align-items-center">
                <h5 class="m-0">To-Do List</h5>
                <a href="{{route('home.create')}}" class="btn btn-primary">Add</a>
            </div>

            <div class="{{--table-responsive--}} d-flex flex-column justify-content-between text-nowrap" style="min-height: 70vh">
                <table class="table" >
                    <thead>
                    <tr class="bg-light">
                        <th>Sl</th>
                        <th>Date</th>
                        <th>title</th>
                        <th>description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    @if(count($lists) > 0)
                        <?php (\Request::get('page') != "" && \Request::get('page') > 1) ? $sl = (\Request::get('page') -1) * $number_of_view : $sl =  0?>
                        @foreach($lists as $list)
                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{++$sl}}</strong></td>
                                <td>{{$list->date}}</td>
                                <td>{{$list->title}}</td>
                                <td>{{$list->description}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{route('home.edit', ['id' => \Crypt::encrypt($list->id)])}}"
                                            ><i class="bx bx-edit-alt me-1"></i> Edit</a
                                            >
                                            <a class="dropdown-item" href="{{route('home.delete', ['id' => \Crypt::encrypt($list->id)])}}"
                                            ><i class="bx bx-trash me-1"></i> Delete</a
                                            >
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    @else
                        <tr>
                            <td colspan="5" class="p-3 text-center"><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>No data found</strong></td>
                        </tr>
                    @endif
                    </tbody>
                </table>


                <div class="pagination">
                    {{$lists->links()}}
                </div>
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection

