@extends('cms.parent')
@section('title', 'create')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create Category</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>User</label>
                                    <select class="form-control" id="user">
                                        @foreach ($user_categ as $item )
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" placeholder="Enter Title">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="active">
                                        <label class="custom-control-label" for="active">User Active Status</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" onclick="createCategory()" class="btn btn-primary">Submit</button>
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
        function createCategory() {
            // alert("Younis Talal Abu Amsha");
            const token = document.getElementsByName('_token')[0].value;
            // console.log(token);
            fetch('/cms/admin/categories', {
                method: 'POST',
                headers : {
                    "Accept" : 'application/json',
                    "Content-Type" : 'application/json'
                },
                body: JSON.stringify({
                    "_token" : token,
                    "users_name" : document.getElementById("user").value,
                    'category_title' : document.getElementById("title").value,
                    'category_active' : document.getElementById("active").checked,
                })
            }).then((response) => {
                console.log(response);
                return response.json();
            }).then((response) => {
                console.log(response);
                Swal.fire({
                    position: 'center',
                    icon: response.icon,
                    title: response.message,
                    showConfirmButton: false,
                    timer: 2500
                })
                window.location.href = '/cms/admin/categories'
            }).catsh((error) => {
                console.log('Error');
            })
        }
    </script>
@endsection
