<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal modal-auto-h fade modal_main" id="add_employee_modal" tabindex="-1" role="dialog" aria-labelledby="add_employee_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add an employee</h4>
                        <form class="forms-sample" id="add_form">
                            <div class="form-group">
                                <label for="add_name">Name</label>
                                <input type="text" class="form-control form-control-sm" id="add_name" name="add_name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="number" class="form-control form-control-sm" id="add_phone" name="add_phone" placeholder="Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="add_level">Employment Level</label>
                                <select class="form-control form-control-sm" name="add_level" id="add_level">

                                </select>
                            </div>
                            <div class="row justify-content-end">
                                <button type="button" id="add_employee_btn_submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-auto-h fade modal_main" id="edit_employee_modal" tabindex="-1" role="dialog" aria-labelledby="edit_employee_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit an employee</h4>
                        <form class="forms-sample" id="edit_form">
                            <div class="form-group">
                                <label for="add_name">Name</label>
                                <input type="text" class="form-control form-control-sm" id="edit_name" name="edit_name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="number" class="form-control form-control-sm" id="edit_phone" name="edit_phone" placeholder="Phone Number">
                            </div>
                            <div class="form-group">
                                <label for="add_level">Employment Level</label>
                                <select class="form-control form-control-sm" name="edit_level" id="edit_level">
                                </select>
                            </div>
                            <div class="row justify-content-end">
                                <button type="button" id="edit_employee_btn_submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="card-title row">
                <div class="my-auto  col-xs- 12 col-xl-7 col-md-10">
                    <?php echo ucfirst(strtolower(session()->get('nama_booth'))) ?> Employees
                </div>
                <?php if (session()->get('level') == "OWNER") { ?>
                    <div class="col-xs- 12 col-xl-5 col-md-2 text-right"><button type="button" id="add_employee" class="btn btn-primary btn-rounded btn-icon"><i class="ti-plus"></i></button></div>
                <?php } ?>
            </div>
            <div class="table-wrapper">
                <div class="table-responsive table-scrolly">
                    <table id="employees_tbl" class="table table-striped table-main">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th> Name</th>
                                <th>Phone Number</th>
                                <th>Employment</th>
                                <?php if (session()->get('level') == "OWNER") { ?>
                                    <th colspan="2" class="text-center">
                                        Action
                                    </th>
                                <?php } ?>
                            </tr>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // A $( document ).ready() block.
    $(document).ready(function() {
        getEmployees();
        $('#add_employee').on('click', function() {
            getLevels();
            $('#add_employee_modal').modal('show');
        });
        $(document).on("click", "button[btn='edit_employee_btn']", function() {
            getLevels();
            let id_user = $(this).closest('tr').find("td:eq(1)").text();
            let nama_user = $(this).closest('tr').find("td:eq(2)").text();
            let hp = $(this).closest('tr').find("td:eq(3)").text();
            let level = $(this).closest('tr').find("td:eq(4)").prop('level');
            $('#edit_name').attr('id_user', id_user)
            $('#edit_name').val(nama_user)
            $('#edit_phone').val(hp)
            $("#edit_level").val(level).change();
            $('#edit_employee_modal').modal('show');
        });
        $('#add_employee_btn_submit').on('click', function() {
            addEmployees()
        });
        $('#edit_employee_btn_submit').on('click', function() {
            editEmployees()
        });
        $(document).on("click", "button[btn='delete_employee_btn']", function() {
            let target = $(this).closest('tr').find("td:eq(1)").text();
            console.log('deleting..');
            deleteEmployee(target);
        });
    });

    function getLevels() {
        $.ajax({
            url: '<?php echo base_url('employees/level'); ?>',
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(data) {
                let levels = '';
                if (data.result.length != 0) {
                    $.each(data.result, function(index, item) {
                        levels += '<option value="' + item.id_level + '">' + item.nama_jabatan + '</option>';
                    });
                } else {
                    levels += '<option value="-">No Data Found</option>';
                }
                $('#add_level').html(levels);
                $('#edit_level').html(levels);
            },

        });
    }

    function addEmployees() {
        let params = new FormData();
        let fields = $('#add_form').serializeArray();
        $.each(fields, function(i, v) {
            params.append(v.name, v.value);
        });
        $.ajax({
            url: '<?php echo base_url('employees/add'); ?>',
            type: 'POST',
            data: params,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {

            },
            success: function(data) {
                console.log(data.result);
                if (data.msg == "success") {
                    getEmployees();
                    swal("Success!", "data saved with ID "+data.result+"!", "success");
                }
                else{
                    swal("Failed!", "there's something wrong while saving data!", "danger");
                }
            },
            complete: function(data) {
                $('#add_form')[0].reset();
                $('#add_employee_modal').modal('hide');

            }

        });
    }

    function editEmployees() {
        let params = new FormData();
        let fields = $('#edit_form').serializeArray();
        $.each(fields, function(i, v) {
            params.append(v.name, v.value);
        });
        params.append('edit_id', $('#edit_name').attr('id_user'));
        $.ajax({
            url: '<?php echo base_url('employees/edit'); ?>',
            type: 'POST',
            data: params,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {

            },
            success: function(data) {
                if (data.msg == "success") {
                    getEmployees();
                    swal("Success!", "data with ID "+data.result+" successfully updated!", "success");
                }
                else{
                    swal("Failed!", "there's something wrong while saving data!", "danger");
                }
            },
            complete: function(data) {
                $('#edit_form')[0].reset();
                $('#edit_employee_modal').modal('hide');

            }

        });
    }

    function getEmployees() {
        $.ajax({
            url: '<?php echo base_url('employees/list'); ?>',
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(data) {
                if (data.result.length != 0) {
                    let employees = '';
                    $.each(data.result, function(index, item) {
                        employees += '<tr>'
                        employees += '<td>' + (index + 1) + '</td>';
                        employees += '<td>' + item.id_user + '</td>';
                        employees += '<td><b>' + item.nama_user + '</b></td>';
                        item.hp ? employees += '<td>' + item.hp + '</td>' : employees += '<td> - </td>';
                        employees += '<td level=' + item.id_level + '>' + item.nama_jabatan + '</td>';
                        let level = "<?php echo session()->get('level') ?>";
                        if (level == 'OWNER') {
                            employees += '<td class=" table-actions"><button type="button" btn="edit_employee_btn" class="btn btn-inverse-primary btn-icon"><i class="ti-pencil"></i></button></td>';
                            employees += '<td class=" table-actions"><button type="button" btn="delete_employee_btn" class="btn btn-inverse-danger btn-icon"><i class="ti-trash"></i></button></td>';
                        }
                        employees += '</tr>';
                    });
                    $('#employees_tbl tbody').html(employees);
                } else {
                    tableEmpty('#employees_tbl');
                }


            },

        });
    }

    function deleteEmployee(id_user) {
        $.ajax({
            url: '<?php echo base_url('employees/delete'); ?>',
            data: {
                id_user: id_user
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(data) {
                if (data.msg = "success") {
                    getEmployees();
                    swal("Success!", "data with ID "+data.result+" successfully deleted!", "success");
                }
                else{
                    swal("Failed!", "there's something wrong while deleting data!", "danger");
                }
            },

        });
    }
</script>
<?= $this->endSection() ?>