@extends("cms.parent")

@section("title" , "users")
@section("content")
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users Data</h3>

                    <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>Categoey Count</th>
                        <th>Created At</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item) {{-- $users is varible in arry = $data --}}
                            <tr>
                                <td>{{$loop-> index + 1}}</td>
                                <td>{{$item->name}}</td> {{-- name = column name --}}
                                <td>{{$item->email}}</td> {{-- email = column name --}}
                                <td>
                                    @if ($item->fullMobile === "No Mobile")
                                        <span style="color: red; font-weight: bold">No Address</span>
                                    @else
                                        <span style="font-weight: bold">{{$item->fullMobile}}</span>
                                    @endif
                                </td> {{-- fullMobile = function name in user model --}}
                                <td>
                                    {{-- الطريقة الأولى --}}
                                    @if (!is_null($item->address))
                                        <span style="font-weight: bold">{{$item->address}}</span>
                                    @else
                                        <span style="color: red; font-weight: bold">No Address</span>
                                    @endif
                                    {{-- --------------------------------------- --}}
                                    {{-- الطريقة الثانية --}}
                                    {{-- @if ($item->address === null)
                                        <span style="color: red; font-weight: bold">No Address</span>
                                    @else
                                        <span style="font-weight: bold">{{$item->address}}</span>
                                    @endif --}}
                                </td> {{-- address = column name --}}
                                <td>
                                    @if ($item->categories_count === 0)
                                    <span style="font-weight: bold ; color: red" >{{$item->categories_count}}</span>
                                    @else
                                        <span style="color: green; font-weight: bold">{{$item->categories_count}}</span>
                                    @endif

                                </td>
                                <td>
                                    {{-- الطريقة السريعة بدون ستايل--}}
                                    {{-- {{$item->created_at ?? "No"}} --}}
                                    {{-- --------------------------------------- --}}
                                    {{--ستايل--}}
                                    @if (!is_null($item->created_at))
                                        <span style="font-weight: bold">{{$item->created_at}}</span>
                                    @else
                                        <span style="color: red; font-weight: bold">No</span>
                                    @endif
                                </td> {{-- created_at = column name --}}
                                <td style="display: flex">
                                    <a href="{{route("users.edit", $item->id)}}" class="btn btn-primary mr-2">Edit</a>
                                    <form method="POST" action="{{route("users.destroy", $item->id)}}">
                                        @method("DELETE")
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
@endsection
