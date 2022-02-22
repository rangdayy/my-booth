<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
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
                                <input type="number" class="form-control form-control-sm" id="add_pcs" min="0" placeholder="pcs">
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
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Make a Transaction</h4>
                <div class="row">
                    <div class="col-xs-12 col-md-4 order-1">
                        <blockquote class="blockquote blockquote-primary">
                            <p> fill the table below and click the ORDER button to make a transaction!.</p>
                            <!-- <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer> -->
                        </blockquote>
                    </div>
                    <div class="col-xs-12 col-md-3 order-2">
                        <address>
                            <p class="font-weight-bold"><?php echo ucwords((session()->get('id_user'))) ?></p>
                            <p class="font-weight-bold"><?php echo ucwords((session()->get('id_booth'))) . ' - ' . ucwords((session()->get('nama_booth'))) ?></p>
                            <p><?php echo ucwords(strtolower(session()->get('name'))) ?></p>
                            <p></p>
                            <p><?php echo ucwords(strtolower(session()->get('level'))) ?></p>
                        </address>
                        <!-- <form class="form-inline">
                    <label class="sr-only" for="inlineFormInputName2"></label>
                    <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="AUTOMATIC STRUCK NUMBER HERE">

                    <label class="sr-only" for="inlineFormInputGroupUsername2"></label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"></div>
                        </div>
                        <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="USER ID RIGHT HERE">
                    </div>
                    <button type="button" class="btn btn-primary mb-2">Submit</button>
                </form> -->
                    </div>
                    <!-- <div class="form-group d-flex"> -->

                        <div class="add-items col-xs-12 col-md-5 order-3">
                            <div class="form-group d-flex">
                                <input type="text" id="money" class="form-control todo-list-input" placeholder="Rp.">
                                <button type="button" id="transaction-btn" class="btn btn-primary mb-2">Order </button>
                            </div>
                        </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Trolley</h4>
                <p class="card-description">
                    Here's what your costumer buys!
                </p>
                <div class="table-wrapper">
                    <div class="table-responsive table-scrolly">
                        <table id="transaction_trolley_tbl" class="table table-main">
                            <form id="transaction_trolley_form">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Pcs</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                            </form>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 text-left">
                        <h4 class="card-description">Total</h4>
                    </div>
                    <div class="col-6 text-right">
                        <h4 class="card-description">Rp. <span id="price_total">0.00</span></h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">List of goods</h4>
                <p class="card-description">
                    put costumer's stuff on the trolley table by clicking the goods on this table!
                </p>
                <div class="table-wrapper">
                    <div class="table-responsive table-scrolly">
                        <table id="transaction_goods_tbl" class="table table-hover table-main">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
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
</div>
<script>
    $(document).ready(function() {
        getGoods();
        tableEmpty('#transaction_trolley_tbl');
        let trolley = $('#transaction_trolley_tbl tbody');
        $('#transaction-btn').on('click', function() {
            if((parseInt($('#money').val()) >= parseInt($('#price_total').text())) && (parseInt($('#money').val()) > 0)){
            makeTransaction();
            } else {
                swal('not enough money!', "","error");

            }
        });
        $(document).on("click", "button[btn='add_goods_btn']", function() {
            //some think
            let id_barang = $(this).closest('tr').find("td:eq(2)").text();
            let nama_barang = $(this).closest('tr').find("td:eq(3)").text();
            let harga = $(this).closest('tr').find("td:eq(4)").text();
            let stock = $(this).closest('tr').find("td:eq(5)").text();
            $('#add_pcs').attr('id_barang', id_barang);
            $('#add_pcs').attr('nama_barang', nama_barang);
            $('#add_pcs').attr('harga', harga);
            $('#add_pcs').attr('max', stock);
            $('#add_goods_modal').modal('show');
            // putTrolley(id, name, price, 1);
        });
        $(document).on("click", "button[btn='del_goods_btn']", function() {
            let goods = $('#transaction_goods_tbl tbody');
            let id_barang = $(this).closest('tr').find("td:eq(2)").text();
            let harga = $(this).closest('tr').find("td:eq(4)").text();
            let stock = parseInt($(this).closest('tr').find("td:eq(5)").text()) - 1;
            let total = $(this).closest('tr').find("td:eq(6)").text();
            let good_stock = $(goods).find("tr:contains(" + id_barang + ")").find('td:eq(5)').text();
            let good_total = (parseInt(stock) * parseInt(harga)) + '.00'
            $(goods).find("tr:contains(" + id_barang + ")").find('td:eq(5)').text(parseInt(good_stock) + 1);
            $(this).closest('tr').find("td:eq(6)").text(good_total);
            $(this).closest('tr').find("td:eq(5)").text(stock);
            if (stock == 0) {
                $(this).closest('tr').remove()
                if ($('#transaction_trolley_tbl tbody tr').length == 0) {
                    tableEmpty('#transaction_trolley_tbl');
                }
            }
        });
        $('#add_goods_btn_submit').on('click', function() {
            if ((parseInt($('#add_pcs').attr('max')) >= parseInt($('#add_pcs').val()) && parseInt($('#add_pcs').val()) > 0) && $('#add_pcs').val().length != '') {
                let goods = $('#transaction_goods_tbl tbody');
                let id = $('#add_pcs').attr('id_barang');
                let name = $('#add_pcs').attr('nama_barang');
                let price = $('#add_pcs').attr('harga');
                let pcs = $('#add_pcs').val();
                putTrolley(id, name, price, pcs)
                $(goods).find("tr:contains(" + id + ")").find('td:eq(5)').text($('#add_pcs').attr('max') - pcs);
                $('#add_pcs').val('');
                $('#add_goods_modal').modal('hide');
            } else {
                swal('not enough goods!', "","error");

            }
        });
    });

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
                        goods += '<td class=" table-actions"><button type="button" btn="add_goods_btn" class="btn btn-inverse-success btn-icon"><i class="ti-plus"></i></button></td>';
                        goods += '<td>' + (index + 1) + '</td>';
                        goods += '<td>' + item.id_barang + '</td>';
                        goods += '<td><b>' + item.nama_barang + '</b></td>';
                        goods += '<td>' + item.harga + '</b>';
                        goods += '<td>' + item.stock + '</td>';
                        goods += '</tr>';
                    });
                    $('#transaction_goods_tbl tbody').html(goods);
                } else {
                    tableEmpty('#transaction_goods_tbl');
                }


            },

        });
    }

    function putTrolley(id, name, price, pcs) {
        let trolley = $('#transaction_trolley_tbl tbody');
        let row;
        if (trolley.find('.empty_tbl').length) {
            trolley.find('.empty_tbl').remove();
            row = htmlTrolley(trolley, 1, id, name, price, pcs);
            $(trolley).append(row)
        } else {
            let number = parseInt(trolley.find('tr').last().find('td:eq(1)').text()) + 1;
            let check = false;
            $(trolley.find('tr')).each(function(index, tr) {
                if ($(this).find('td:eq(2)').text() == id) {
                    number = parseInt($(this).find('td:eq(1)').text());
                    console.log($(this).find('td:eq(5)').text(), pcs)
                    let new_pcs = parseInt($(this).find('td:eq(5)').text()) + parseInt(pcs);
                    let total = parseInt($(this).find('td:eq(4)').text()) * new_pcs;
                    $(this).find('td:eq(1)').text(number);
                    $(this).find('td:eq(5)').text(new_pcs);
                    $(this).find('td:eq(6)').text(total + '.00');
                    check = true;
                }
            });
            if (check == false) {
                row = htmlTrolley(trolley, number, id, name, price, pcs);
                $(trolley).append(row)
            }
        }
        priceTotal()

    }

    function htmlTrolley(trolley, no, id, name, price, pcs) {
        let html = '';
        html += '<tr>';
        html += '<td class=" table-actions"><button type="button" btn="del_goods_btn" class="btn btn-inverse-danger btn-icon"><i class="ti-minus"></i></button></td>';
        html += '<td>' + no + '</td>';
        html += '<td>' + id + '</td>';
        html += '<td>' + name + '</td>';
        html += '<td>' + price + '</td>';
        html += '<td>' + pcs + '</td>';
        html += '<td>' + parseInt(price) * pcs + '.00</td>';
        html += '</tr>';
        return html;

    }

    function makeTransaction() {
        let params = new FormData();
        let fields = $('#transaction_trolley_form').serializeArray();
        let array = [];
        $('#transaction_trolley_tbl tbody').find('tr').each(function(index, tr) {
            let item = {};
            item['id_barang'] = $(this).find("td:eq(2)").text();
            item['qty'] = $(this).find("td:eq(5)").text();
            item['harga_total'] = $(this).find("td:eq(6)").text();
            array.push(item);
        });
        params.append('data', JSON.stringify(array))
        params.append('money',$('#money').val())
        console.log(params.data)
        $.ajax({
            url: '<?php echo base_url('transaction/add'); ?>',
            type: 'POST',
            data: params,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {

            },
            success: function(data) {
                console.log(data)
                if (data.msg == "success") {
                    swal(data.result.id_struk, "amount of change : Rp. " + data.result.substract + ".00!", "success");
                    tableEmpty('#transaction_trolley_tbl');
                    $('#price_total').text('0.00');
                    $('#money').val('');
                    getGoods();
                }
            },
            complete: function(data) {

            }

        });
    }

    function priceTotal() {
        let id = $('#price_total')
        let trolley = $('#transaction_trolley_tbl tbody');
        let total = 0;
        $(trolley.find('tr')).each(function(index, tr) {
            total += parseInt($(this).find('td:eq(6)').text());
        });
        console.log(total + '.00')
        id.text(total + '.00')
    }
</script>
<?= $this->endSection() ?>