@extends('cms.parents')

@section('title', 'Edit Password')
@section('page-name', 'Edit Password')
@section('main-page', 'Password')
@section('sub-page', 'Edit Password')

@section('styles')
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Edit Password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="cahang-password">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="old_password">Old Password</label>
                                    <input type="text" class="form-control" id="old_password" name="old_password"
                                        placeholder="Enter old_password">
                                </div>

                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="text" class="form-control" id="new_password" name="new_password"
                                        placeholder="Enter new_password">
                                </div>

                                <div class="form-group">
                                    <label for="new_password_confirmation">New Password Confirmation</label>
                                    <input type="text" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation" placeholder="Enter new_password_confirmation">
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" onclick="updatePassword()" class="btn btn-primary">Edit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>

    <script>
        function updatePassword() {
            // Make a request for a user with a given ID
            axios.put('/cms/admin/update-password', {
                    old_password: document.getElementById('old_password').value,
                    new_password: document.getElementById('new_password').value,
                    new_password_confirmation: document.getElementById('new_password_confirmation').value,
                })
                .then(function(response) {
                    // handle success
                    console.log(response.data);
                    document.getElementById('cahang-password').reset();
                    showtoster(true, response.data.message);
                })
                .catch(function(error) {
                    // handle error
                    console.log(error.response);
                    showtoster(false, error.response.data.message);
                });
        }

        function showtoster(status, message) {
            if (status) {
                toastr.success(message)
            } else {
                toastr.error(message)
            }
        }

    </script>

@endsection
