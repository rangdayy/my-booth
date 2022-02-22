<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal modal-auto-h fade modal_main" id="add_goods_modal" tabindex="-1" role="dialog" aria-labelledby="add_goods_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add goods</h4>
                        <form class="forms-sample" id="add_form">
                            <div class="form-group">
                                <label for="add_name">Name</label>
                                <input type="text" class="form-control form-control-sm" id="add_name" name="add_name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="phone">Price</label>
                                <input type="number" class="form-control form-control-sm" id="add_price" name="add_price" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <label for="phone">Stock</label>
                                <input type="number" class="form-control form-control-sm" id="add_stock" name="add_stock" placeholder="Stock">
                            </div>
                            <div class="row justify-content-end">
                                <button type="button" id="add_goods_btn_submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-auto-h fade modal_main" id="edit_goods_modal" tabindex="-1" role="dialog" aria-labelledby="edit_goods_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit goods</h4>
                        <form class="forms-sample" id="edit_form">
                            <div class="form-group">
                                <label for="add_name">Name</label>
                                <input type="text" class="form-control form-control-sm" id="edit_name" name="edit_name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="phone">Price</label>
                                <input type="number" class="form-control form-control-sm" id="edit_price" name="edit_price" placeholder="Price">
                            </div>
                            <div class="form-group">
                                <label for="phone">Stock</label>
                                <input type="number" class="form-control form-control-sm" id="edit_stock" name="edit_stock" placeholder="Stock">
                            </div>
                            <div class="row justify-content-end">
                                <button type="button" id="edit_goods_btn_submit" class="btn btn-primary mr-2">Submit</button>
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
                    <?php echo ucfirst(strtolower(session()->get('nama_booth'))) ?> Goods
                </div>
                <?php if (session()->get('level') == "OWNER") { ?>
                    <div class="col-xs- 12 col-xl-5 col-md-2 text-right"><button type="button" id="add_goods" class="btn btn-primary btn-rounded btn-icon"><i class="ti-plus"></i></button></div>
                <?php } ?>
            </div>
            <div class="table-wrapper">
                <div class="table-responsive table-scrolly">
                    <table id="goods_tbl" class="table table-striped table-main">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Stock</th>
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
        tableEmpty('#goods_tbl');
        getGoods();
        $('#add_goods').on('click', function() {
            getLevels();
            $('#add_goods_modal').modal('show');
        });
        $(document).on("click", "button[btn='edit_goods_btn']", function() {
            getLevels();
            let id_barang = $(this).closest('tr').find("td:eq(1)").text();
            let nama_barang = $(this).closest('tr').find("td:eq(2)").text();
            let harga = $(this).closest('tr').find("td:eq(3)").text();
            let stock = $(this).closest('tr').find("td:eq(4)").text();
            $('#edit_name').attr('id_barang', id_barang);
            $('#edit_name').val(nama_barang);
            $('#edit_price').val(harga);
            $("#edit_stock").val(stock);
            $('#edit_goods_modal').modal('show');
        });
        $('#add_goods_btn_submit').on('click', function() {
            addGoods()
        });
        $('#edit_goods_btn_submit').on('click', function() {
            editGoods()
        });
        $(document).on("click", "button[btn='delete_goods_btn']", function() {
            let target = $(this).closest('tr').find("td:eq(1)").text();
            console.log('deleting..');
            deletegoods(target);
        });
    });

    function getLevels() {
        $.ajax({
            url: '<?php echo base_url('goods/level'); ?>',
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

    function addGoods() {
        let params = new FormData();
        let fields = $('#add_form').serializeArray();
        $.each(fields, function(i, v) {
            params.append(v.name, v.value);
        });
        $.ajax({
            url: '<?php echo base_url('goods/add'); ?>',
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
                    getGoods();
                    swal("Success!", "data saved with ID "+data.result+"!", "success");
                }
                else{
                    swal("Failed!", "there's something wrong while saving data!", "danger");
                }
            },
            complete: function(data) {
                $('#add_form')[0].reset();
                $('#add_goods_modal').modal('hide');
            },


        });
    }

    function editGoods() {
        let params = new FormData();
        let fields = $('#edit_form').serializeArray();
        $.each(fields, function(i, v) {
            params.append(v.name, v.value);
        });
        params.append('edit_id', $('#edit_name').attr('id_barang'));
        $.ajax({
            url: '<?php echo base_url('goods/edit'); ?>',
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
                    getGoods();
                    swal("Success!", "data with ID "+data.result+" successfully updated!", "success");
                }
                else{
                    swal("Failed!", "there's something wrong while saving data!", "danger");
                }
            },
            complete: function(data) {
                $('#edit_form')[0].reset();
                $('#edit_goods_modal').modal('hide');

            }

        });
    }

    function getGoods() {
        $.ajax({
            url: '<?php echo base_url('goods/list'); ?>',
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data.result.length != 0) {
                    let goods = '';
                    $.each(data.result, function(index, item) {
                        goods += '<tr>'
                        goods += '<td>' + (index + 1) + '</td>';
                        goods += '<td>' + item.id_barang + '</td>';
                        goods += '<td><b>' + item.nama_barang + '</b></td>';
                        goods += '<td><b>' + item.harga + '</b></td>';
                        goods += '<td><b>' + item.stock + '</b></td>';
                        let level = "<?php echo session()->get('level') ?>";
                        if (level == 'OWNER') {
                            goods += '<td class=" table-actions"><button type="button" btn="edit_goods_btn" class="btn btn-inverse-primary btn-icon"><i class="ti-pencil"></i></button></td>';
                            goods += '<td class=" table-actions"><button type="button" btn="delete_goods_btn" class="btn btn-inverse-danger btn-icon"><i class="ti-trash"></i></button></td>';
                        }
                        goods += '</tr>';
                    });
                    $('#goods_tbl tbody').html(goods);
                } else {
                    tableEmpty('#goods_tbl');
                }


            },

        });
    }

    function deletegoods(id_barang) {
        $.ajax({
            url: '<?php echo base_url('goods/delete'); ?>',
            data: {
                id_barang: id_barang
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(data) {
                console.log(data.result);
                if (data.msg = "success") {
                    getGoods();
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