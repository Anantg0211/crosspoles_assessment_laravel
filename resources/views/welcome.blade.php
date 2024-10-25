<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
        integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CrossPoles</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">

</head>

<body>

    <div class="container mt-3">

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span class="fs-3 fw-semi-bold">Users</span>
                <button onclick="createUser()" class="btn btn-primary"> Add User</button>
            </div>
        </div>


        <div class="card-datatable mt-2 table-responsive">
            <table class="datatables-basic table " id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Profile Picture</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Description</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <div></div>
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form id="addUserForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role</label>
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger errors" id="role_id_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="userName" name="name"
                                placeholder="Enter name">
                            <span class="text-danger errors" id="name_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="userEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="userEmail" name="email"
                                placeholder="Enter email">
                            <span class="text-danger errors" id="email_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="userPhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="userPhone" name="phone_number"
                                placeholder="Enter phone number">
                            <span class="text-danger errors" id="phone_number_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter Description Here"></textarea>
                            <span class="text-danger errors" id="description_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Profile Picture</label>
                            <input type="file" class="form-control" id="profile_picture" name="profile_picture"
                                accept="image/*">
                            <span class="text-danger errors" id="profile_picture_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#usersTable").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                order : [
                    7, 'desc'
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'profile_picture',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        data: 'role.role_name',
                        searchable: false,
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ]
            });


            $("#addUserForm").on('submit', function(e) {
                e.preventDefault();
                $(".errors").text('');
                $(".errors").addClass('d-none');
                let formDataArray = $(this).serializeArray();
                let usersData = new FormData();
                var file = $('#profile_picture').prop('files')[0];
                $.each(formDataArray, function(i, field) {
                    usersData.append(field.name, field.value);
                });
                if (file) {
                    usersData.append('profile_picture', file);
                }
                usersData.append('_token', '{{ csrf_token() }}');
                let hasError = false;

                if (!file) {
                    $('#profile_picture_error').text('Profile picture is required');
                    hasError = true;
                }

                if (usersData.get('role_id').trim() == '') {
                    $('#role_id_error').text('Role is required');
                    hasError = true;
                }

                if (usersData.get('name').trim() == '' || usersData.get('name').trim().length > 255) {
                    $('#name_error').text('Name is required and must be less than 255 characters');
                    hasError = true;
                }

                if (usersData.get('email').trim() == '' || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(usersData.get(
                        'email').trim())) {
                    $('#email_error').text('Email is required and must be a valid email address');
                    hasError = true;
                }

                if (usersData.get('phone_number').trim() == '' || !/^[6-9]\d{9}$/.test(usersData.get(
                        'phone_number').trim())) {
                    $('#phone_number_error').text(
                        'Phone number is required and must be a valid Indian number');
                    hasError = true;
                }

                if (usersData.get('description').trim() == '') {
                    $('#description_error').text('Description is required');
                    hasError = true;
                }
                if (hasError) {
                    $(".errors").removeClass('d-none');
                    return;
                }

                $.ajax({
                    url: "{{ route('users.store') }}",
                    type: "POST",
                    data: usersData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#addUserModal").modal('hide');
                        $("#usersTable").DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON && error.responseJSON.errors) {
                            $.each(error.responseJSON.errors, function(key, value) {
                                $(`#${key}_error`).text(value[0]).removeClass('d-none');
                            });
                        }
                    }
                });
            });




        });
    </script>
    <script>
        function createUser() {
            $("#addUserModal").modal('show');
        }
    </script>

</body>

</html>
