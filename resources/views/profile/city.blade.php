@extends('components.layouts.app')

@section('title', 'Cities List')

@section('css')
<style>
    button.btn.btn-sm.btn-primary.edit-finish {
        background-color: #ff0168;
        border: 1px solid;
    }
    button.btn.btn-sm.btn-danger.delete-finish {
        background-color: #ab0749;
    }
</style>
@endsection

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('partials/profilesidebar')
                </div>
                <div class="col-lg-9">
                    <div class="account-information">
                        <div class="frames-main">
                            <h1>City List</h1>

                            <button class="btn custom-btn" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addCityModal"> Add New</button>
                        </div>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Shipping Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade city-modal" id="addCityModal" tabindex="-1" aria-labelledby="addCityLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCityLabel">Add Custom Color</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('city.store') }}" id="add-city" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="state_id" class="form-control" required>
                                            <option value="" disabled selected>Select State</option>
                                            @foreach ($states as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" name="name" class="form-control" placeholder="City Name" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" step="any" value="0" name="shipping" class="form-control" placeholder="Shipping Price" required>
                                        @error('shipping')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="save-btn">
                                    <button class="btn custom-btn" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn custom-btn filled" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade states-modal" id="editCityModal" tabindex="-1" aria-labelledby="editCityLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCityLabel">Edit City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                        <form action="{{ route('states.update', ':id') }}" id="edit-states" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" id="id">
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <select name="state_id" class="form-control" id="state_id" required>
                                            <option value="" disabled selected>Select State</option>
                                            @foreach ($states as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('state_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="City Name" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group label-hover">
                                        <input type="number" step="any" name="shipping" id="shipping" class="form-control" placeholder="Shipping Price" required>
                                        @error('shipping')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="save-btn">
                                    <button class="btn custom-btn" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn custom-btn filled" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
     $(document).ready(function() {
        $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("city.get") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'state.name', name: 'state.name' },
                { data: 'name', name: 'name' },
                { data: 'shipping', name: 'shipping' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('#add-city').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Create a FormData object from the form
            var form = $(this);
            var formData = new FormData(form[0]); // Create FormData from the form

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                contentType: false, // Prevent jQuery from setting content type
                processData: false, // Prevent jQuery from processing the data
                success: function(response) {
                    if (response.success) {
                        // On success, show a SweetAlert success message and close the modal
                        Swal.fire({
                            icon: 'success',
                            title: 'City Added!',
                            text: 'The city has been added successfully.',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#addCityModal').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        // Display error messages without closing the modal
                        for (const field in response.errors) {
                            $(`[name="${field}"]`).next('.text-danger').remove();
                            $(`[name="${field}"]`).after('<span class="text-danger">' + response.errors[field][0] + '</span>');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please fix the errors in the form.',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX error (if necessary)
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                        text: 'There was an issue with the server. Please try again.',
                    });
                }
            });
        });

        // Open Edit Modal and load data
        $(document).on('click', '.edit-city', function () {
            let cityId = $(this).data('id'); // Get the color ID from the button's data-id attribute
            $.ajax({
                url: "{{ url('city/edit') }}/" + cityId, // Fetch existing data
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#id').val(response.city.id);
                        $('#name').val(response.city.name);
                        $('#shipping').val(response.city.shipping);
                        $( "#state_id option:selected" ).text(response.city.state.name);

                        // Update the form action URL
                        $('#edit-city').attr('action', "{{ url('city/update') }}/" + response.city.id);

                        // Show the modal
                        $('#editCityModal').modal('show');
                    }

                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Could not load city data.',
                    });
                }
            });
        });

        // Submit the edit form
        $('#edit-city').on('submit', function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var formData = new FormData(form);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false, // Important!
                processData: false, // Important!
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'City Updated!',
                            text: 'The city details have been updated successfully.',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#editCityModal').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        if (response.errors) {
                            for (const field in response.errors) {
                                $(`[name="${field}"]`).next('.text-danger').remove();
                                $(`[name="${field}"]`).after('<span class="text-danger">' + response.errors[field][0] + '</span>');
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong',
                                text: 'There was an issue with the server. Please try again.',
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong',
                        text: 'There was an issue with the server (500). Please try again.',
                    });
                }
            });
        });


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.delete-city', function() {
            var cityId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('city/delete') }}/" + cityId,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'The city has been deleted.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#example').DataTable().ajax.reload();
                                    }
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an issue deleting the city.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Error!',
                                'There was an issue deleting the city.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
