@extends('cms.parents')

@section('title', 'Index Doctor')
@section('page-name', 'Index Doctor')
@section('main-page', 'Doctor')
@section('sub-page', 'Index')

@section('styles')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Doctor</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>IMG</th>
                                        <th>First_name</th>
                                        <th>Last_name</th>
                                        <th>Specialization</th>
                                        <th>City</th>
                                        <th>Date_Of_Barth</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Created_at</th>
                                        <th>Updated_at</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctors as $index => $doctor)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $doctor->image }}</td>
                                            <td>{{ $doctor->first_name }}</td>
                                            <td>{{ $doctor->last_name }}</td>
                                            <td>{{ $doctor->specialization }}</td>
                                            <td>{{ $doctor->cities->name }}</td>
                                            <td>{{ $doctor->DoB }}</td>
                                            <td>{{ $doctor->phone }}</td>
                                            <td>{{ $doctor->email }}</td>
                                            <td><span class="badge bg-success">{{ $doctor->gender_title }}</span></td>
                                            <td><span @if ($doctor->active) class="badge bg-success" @else class="badge bg-danger" @endif>{{ $doctor->status }}</span></td>
                                            {{-- <td><span class="badge bg-success">{{ $doctor->status }}</span></td> --}}
                                            <td>{{ $doctor->created_at->diffForHumans() }}</td>
                                            <td>{{ $doctor->updated_at->diffForHumans() }}</td>
                                            <td>
                                                <div class="btn-group">

                                                    <a href="{{ route('doctor.edit', $doctor->id) }}" type="button"
                                                        class="btn btn-info">
                                                        <i class="fas fa-edit" aria-hidden="true">Edit</i>
                                                    </a>
                                                    {{-- <form role="form" method="POST"
                                                    action="{{ route('company.destroy', $company->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="fas fa-trash"></i>Delete</button>
                                                </form> --}}

                                                    {{-- <a href="{{ route('company.destroy', $company->id) }}" --}}
                                                    {{-- class="btn btn-danger"><i class="fas fa-trash"></i>Delete</a> --}}

                                                    {{-- @if (Auth::user()->id !== $user->id) --}}
                                                    <a href="#" class="btn btn-danger"
                                                        onclick="confirmDestroy({{ $doctor->id }}, this)"><i
                                                            class="fas fa-trash"></i>Delete</a>
                                                    {{-- @endif --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{-- {{ $merchants->render() }} --}}

                            {{ $doctors->links() }}


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function confirmDestroy(id, td) {
            // console.log("WE ARE IN JS");
            // alert("WELCOME IN JS");
            // console.log("CITY ID: " + id);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    /*
                    -> Confirm:
                        1) Delete City (JS)
                        2) Delete Row from table
                        3) Show Success Alert
                    */
                    destroy(id, td);
                }
            });
        }

        function destroy(id, td) {
            axios.delete('/cms/admin/doctor/' + id)
                .then(function(response) {
                    // handle success
                    console.log(response.data);
                    td.closest('tr').remove();
                    showAlert(response.data);
                })
                .catch(function(error) {
                    // handle error
                    // console.log(error);
                    console.log(error.response);
                    showAlert(error.response.data);
                })
                .then(function() {
                    // always executed
                });
        }

        function showAlert(data) {
            // Swal.fire(
            //     data.title,
            //     data.message,
            //     data.icon
            // )

            Swal.fire({
                title: data.title,
                text: data.message,
                icon: data.icon,
                timer: 2000,
                showConfirmButton: false,
                timerProgressBar: false,
                willOpen: () => {
                    // Swal.showLoading()
                },
                willClose: () => {

                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            });
        }

    </script>
@endsection
