@extends('cms.parent')
@section("title" , "Edit")
@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit Categories</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>User</label>
                        <select class="form-control" id="user_name">
                            @foreach ($user as $item )
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter Title" value="{{$categ->title}}">
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="active" @checked($categ->active)>
                            {{-- @checked($categ->active) === @if($categ->active) checked @endif --}}
                            <label class="custom-control-label" for="active">Category Active Status</label>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" onclick="updateCategory('{{$categ->id}}')" class="btn btn-primary">Submit</button>
                </div>
            </form>
            </div>
            <!-- /.card -->
        </div>
        <!--/.col (left) -->
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script>
        function updateCategory(id){
            axios.put(`/cms/admin/categories/${id}`,{
                "user_name" : document.getElementById('user_name').value,
                "title_catego" : document.getElementById('title').value,
                "active_catego" : document.getElementById('active').checked,
            })
            .then(function(response) {
                window.location.href = '/cms/admin/categories'
                showMessage('success' , response.data.message)
            })
            .catch(function(error){
                showMessage('error' , error.response.data.message)
            })
        }
        // showMessage
        function showMessage(icon , message){
            Swal.fire({
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        }
    </script>
@endsection
