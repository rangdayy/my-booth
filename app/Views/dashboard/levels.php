<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal modal-auto-h fade modal_main" id="add_levels_modal" tabindex="-1" role="dialog" aria-labelledby="add_levels_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add an levels</h4>
                        <form class="forms-sample" id="add_form">
                            <div class="form-group">
                                <label for="add_name">Name</label>
                                <input type="text" class="form-control form-control-sm" id="add_name" name="add_name" placeholder="Name">
                            </div>
                            <div class="row justify-content-end">
                                <button type="button" id="add_levels_btn_submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal_main" id="edit_levels_modal" tabindex="-1" role="dialog" aria-labelledby="edit_levels_modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit an levels</h4>
                        <form class="forms-sample" id="edit_form">
                            <div class="form-group">
                                <label for="add_name">Name</label>
                                <input type="text" class="form-control form-control-sm" id="edit_name" name="edit_name" placeholder="Name">
                            </div>
                            <div class="table-responsive my-3">
                                <table id="form_tbl" class="table table-main">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Form</th>
                                            <th>Access</th>
                                            <th>Manage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($forms) : ?>
                                            <?php foreach ($forms as $form) : ?>
                                                <tr>
                                                    <td class="font-weight-bold"><?php echo $form['id_form']; ?></td>
                                                    <td><?php echo $form['nama_form']; ?></td>
                                                    <td>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" name="checkbox_access[<?php echo $form['id_form']; ?>]" id="<?php echo $form['id_form']; ?>_access">
                                                                <i class="input-helper"></i></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" name="checkbox_manage[<?php echo $form['id_form']; ?>]" id="<?php echo $form['id_form']; ?>_manage">
                                                                <i class="input-helper"></i></label>
                                                        </div>
                                                    </td>

                                                </tr>
                                            <?php endforeach ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="4" class="table-actions text-center"> there's no data yet!</td>
                                            </tr>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-end">
                                <button type="button" id="edit_levels_btn_submit" class="btn btn-primary mr-2">Submit</button>
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
                    <?php echo ucfirst(strtolower(session()->get('nama_booth'))) ?> Levels
                </div>
                <?php if (session()->get('level') == "OWNER") { ?>
                    <div class="col-xs- 12 col-xl-5 col-md-2 text-right"><button type="button" id="add_levels" class="btn btn-primary btn-rounded btn-icon"><i class="ti-plus"></i></button></div>
                <?php } ?>
            </div>
            <div class="table-wrapper">
                <div class="table-responsive table-scrolly">
                    <table id="levels_tbl" class="table table-striped table-main">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Job</th>
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
        getLevels();
        $('#add_levels').on('click', function() {
            getLevels();
            $('#add_levels_modal').modal('show');
        });
        $('#add_levels_btn_submit').on('click', function() {
            addLevels()
        });
        $(document).on("click", "button[btn='edit_levels_btn']", function() {
            $('input[type="checkbox"]').prop('checked', false);
            getLevels();
            let id_level = $(this).closest('tr').find("td:eq(1)").text();
            let nama_jabatan = $(this).closest('tr').find("td:eq(2)").text();
            getAccessForms(id_level)
            $('#edit_name').attr('id_level', id_level);
            $('#edit_name').val(nama_jabatan);
            $('#edit_levels_modal').modal('show');
        });
        $('#edit_levels_btn_submit').on('click', function() {
            editLevels()
        });
        $(document).on("click", "button[btn='delete_levels_btn']", function() {
            let target = $(this).closest('tr').find("td:eq(1)").text();
            console.log('deleting..');
            deletelevels(target);
        });
    });


    function addLevels() {
        let params = new FormData();
        let fields = $('#add_form').serializeArray();
        $.each(fields, function(i, v) {
            params.append(v.name, v.value);
        });
        $.ajax({
            url: '<?php echo base_url('levels/add'); ?>',
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
                    getLevels();
                    swal("Success!", "data saved with ID " + data.result + "!", "success");
                } else {
                    swal("Failed!", "there's something wrong while saving data!", "danger");
                }
            },
            complete: function(data) {
                $('#add_form')[0].reset();
                $('#add_levels_modal').modal('hide');

            }

        });
    }

    function editLevels() {
        let params = new FormData();
        let fields = $('#edit_form').serializeArray();
        $.each(fields, function(i, v) {
            params.append(v.name, v.value);
        });
        params.append('edit_id', $('#edit_name').attr('id_level'));
        $.ajax({
            url: '<?php echo base_url('levels/edit'); ?>',
            type: 'POST',
            data: params,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {

            },
            success: function(data) {
                console.log(data.result)
                if (data.msg == "success") {
                    getLevels();
                    swal("Success!", "data with ID " + data.result + " successfully updated!", "success");
                } else {
                    swal("Failed!", "there's something wrong while saving data!", "danger");
                }

            },
            complete: function(data) {
                $('#edit_form')[0].reset();
                $('#edit_levels_modal').modal('hide');

            }

        });
    }

    function getLevels() {
        $.ajax({
            url: '<?php echo base_url('levels/list'); ?>',
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data.result.length != 0) {
                    let levels = '';
                    $.each(data.result, function(index, item) {
                        levels += '<tr>'
                        levels += '<td>' + (index + 1) + '</td>';
                        levels += '<td>' + item.id_level + '</td>';
                        levels += '<td><b>' + item.nama_jabatan + '</b></td>';
                        let level = "<?php echo session()->get('level') ?>";
                        if (level == 'OWNER') {
                            levels += '<td class=" table-actions"><button type="button" btn="edit_levels_btn" class="btn btn-inverse-primary btn-icon"><i class="ti-pencil"></i></button></td>';
                            levels += '<td class=" table-actions"><button type="button" btn="delete_levels_btn" class="btn btn-inverse-danger btn-icon"><i class="ti-trash"></i></button></td>';
                        }
                        levels += '</tr>';
                    });
                    $('#levels_tbl tbody').html(levels);
                } else {
                    tableEmpty('#levels_tbl');
                }


            },

        });
    }

    function deletelevels(id_level) {
        $.ajax({
            url: '<?php echo base_url('levels/delete'); ?>',
            data: {
                id_level: id_level
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(data) {
                if (data.msg = "success") {
                    getLevels();
                    swal("Success!", "data with ID " + data.result + " successfully deleted!", "success");
                } else {
                    swal("Failed!", "there's something wrong while deleting data!", "danger");
                }
            },

        });
    }

    function getAccessForms(id_level) {
        $.ajax({
            url: '<?php echo base_url('levels/security'); ?>',
            data: {
                id_level: id_level
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data.result.length != 0) {
                    $.each(data.result, function(index, item) {
                        $('#form_tbl tbody').find('input[type="checkbox"]').each(function(index, checkbox) {
                            if($(this).attr('id') == item.id_form + '_access' && item.access == 'T'){
                                $(this).prop('checked', true);
                            }
                            if($(this).attr('id') == item.id_form + '_manage' && item.action == 'T'){
                                $(this).prop('checked', true);
                            }
                        });
                    });
                } else {
                    // swal("Failed!", "there's something wrong while fetching data!", "danger");
                }
            },

        });
    }
</script>
<?= $this->endSection() ?>