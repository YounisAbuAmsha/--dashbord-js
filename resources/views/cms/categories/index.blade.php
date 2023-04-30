@extends('cms.parent')

@section('title', 'Category')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Category Data</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

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
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Active</th>
                                        <th>User</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($catego as $item)
                                        {{-- $catgie is varible in arry = $data --}}
                                        <tr id="remove_{{$item -> id}}" >
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->title }}</td> {{-- title = column name --}}
                                            <td>
                                                @if ($item->active)
                                                    <span style="font-weight: bold ; color:green">Active</span>
                                                @else
                                                    <span style="color: red; font-weight: bold">In Active</span>
                                                @endif
                                            </td> {{-- active = column name --}}
                                            <td>
                                                {{-- {{  $item->user->name }} --}}
                                            </td>
                                            <td>
                                                @if (!is_null($item->created_at))
                                                    <span style="font-weight: bold">{{ $item->created_at }}</span>
                                                @else
                                                    <span style="color: red; font-weight: bold">No</span>
                                                @endif
                                            </td> {{-- created_at = column name --}}
                                            <td style="display: flex">
                                                <a href="{{ route('categories.edit', $item->id) }}"
                                                    class="btn btn-primary mr-2">Edit</a>
                                                {{--
                                        <form method="POST" action="{{route("categories.destroy", $item->id)}}">
                                        @method("DELETE")
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    --}}
                                                <button type="button" onclick="deleteCategory('{{ $item->id }}')"
                                                    class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function deleteCategory(id) {
            axios.delete('/cms/admin/categories/' + id)
            .then(function(response) {
                console.log(response);
                document.getElementById(`remove_${id}`).remove(); //ecma script 6 ``
                Swal.fire({
                    icon: 'success',
                    title: response.data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            })
            .catch(function(error) {
                console.log(error);
                Swal.fire({
                    icon: 'error',
                    title: error.response.data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }
    </script>
@endsection
