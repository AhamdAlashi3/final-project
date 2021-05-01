@extends('cms.parents')

@section('title', 'Edit Patient')
@section('page-name', 'Edit Patient')
@section('main-page', 'Patient')
@section('sub-page', 'Edit Patient')

@section('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                            <h3 class="card-title">Edit Patient </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" id="create_form">
                            @csrf
                            <div class=" card-body">

                                <div class="form-group">
                                    <label>Doctors</label>
                                    <select class="form-control doctors" id="doctor_id" style="width: 100%;">
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}" @if ($patients->doctor_id == $patients->id) selected @endif>{{ $doctor->full_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="first_name">first_name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="{{ $patients->first_name }}" placeholder="Enter first_name">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">last_name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="{{ $patients->last_name }}" placeholder="Enter last_name">
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control cities" id="city_id" style="width: 100%;">
                                        {{-- <option selected="selected">Alabama</option> --}}
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @if ($city->city_id == $city->id) selected @endif>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="DoB">Date_Of_Barth</label>
                                    <input type="text" class="form-control" id="DoB" name="DoB"
                                        value="{{ $patients->DoB }}" placeholder="Enter Date_Of_Barth">
                                </div>
                                <div class="form-group">
                                    <label for="phone">phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $patients->phone }}" placeholder="Enter phone">
                                </div>
                                <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="text" class="form-control" id="email" value="{{ $patients->email }}"
                                        name="email" placeholder="Enter email">
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="male" name="gender" @if ($patients->gender == 'M') checked @endif>
                                        <label for="male" class="custom-control-label">Male</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="female" name="gender" @if ($patients->gender == 'F') checked @endif>
                                        <label for="female" class="custom-control-label">Female</label>
                                    </div>
                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" onclick="update({{ $patients->id }})"
                                    class="btn btn-primary">update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                @endsection


                @section('scripts')

                    <!-- Toastr -->
                    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>

                    <!-- Select2 -->
                    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>

                    <!-- bs-custom-file-input -->
                    <script src="{{ asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

                    <script type="text/javascript">
                        //Initialize Select2 Elements
                        $('.doctors').select2({
                            theme: 'bootstrap4'
                        });
                        //Initialize Select2 Elements
                        $('.cities').select2({
                            theme: 'bootstrap4'
                        });

                        $(document).ready(function() {
                            bsCustomFileInput.init();
                        });

                    </script>

                    <script>
                        function update(id) {
                            // Make a request for a user with a given ID
                            axios.put('/cms/admin/patient/' + id, {
                                    doctor_id: document.getElementById('doctor_id').value,
                                    first_name: document.getElementById('first_name').value,
                                    last_name: document.getElementById('last_name').value,
                                    city_id: document.getElementById('city_id').value,
                                    DoB: document.getElementById('DoB').value,
                                    phone: document.getElementById('phone').value,
                                    email: document.getElementById('email').value,
                                    gender: document.getElementById('male').checked ? 'M' : 'F',
                                })
                                .then(function(response) {
                                    // handle success
                                    console.log(response);
                                    // document.getElementById("edit_form").reset();
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
