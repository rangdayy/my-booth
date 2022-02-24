<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Modal -->
<div class="modal fade modal_main" id="transaction_modal" tabindex="-1" role="dialog" aria-labelledby="transaction_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-12">

                                <hr>
                                <h4 class="card-title text-uppercase"><?= session()->get('nama_booth') ?></h4>
                                <hr>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <address>
                                    <p id="id_transaksi" class="font-weight-bold"></p>
                                    <p id="id_user"></p>
                                </address>
                            </div>
                            <div class="col-md-6">
                                <address>
                                    <p id="nama_user" class="text-capitalize font-weight-bold"></p>
                                    <p id="tanggal_transaksi"></p>
                                </address>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="receipt_tbl" class="table table-main">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 text-left">
                                <p class="font-weight-bold">Total</p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="font-weight-bold">Rp. <span id="price_total">0.00</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-left">
                            </div>
                            <div class="col-6 text-right">
                                <p class="">Rp. <span id="costumer_money">0.00</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-left">
                                <p class="">Change</p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="">Rp. <span id="change">0.00</span></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Transactions</h4>
            <p class="card-description">
                all the transactions that happen in your booth are recorded!.
            </p>
            <div class="table-wrapper">
                <div class="table-responsive table-scrolly">
                    <table id="transaction_tbl" class="table table-striped table-main">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Price</th>
                                <th>Cashier</th>
                                <th>Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($transactions) : ?>
                                <?php foreach ($transactions as $transaction) : ?>
                                    <tr>
                                        <td class="table-actions text-center"><button type="button" btn="show_receipt_btn" class="btn btn-inverse-primary btn-icon"><i class="ti-receipt"></i></button></td>
                                        <td class="font-weight-bold"><?php echo $transaction['id_struk']; ?></td>
                                        <td>Rp. <?php echo $transaction['harga_total']; ?></td>
                                        <td id="<?php echo $transaction['id_user']; ?>"><?php echo $transaction['nama_user']; ?></td>
                                        <td><?php echo $transaction['tanggal_transaksi']; ?></td>

                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="table-actions text-center"> there's no data yet!</td>
                                    

                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if ($pager) : ?>
                <?php echo $pager->links('transaksi', 'bs_simple') ?>
            <?php endif ?>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // tableEmpty('#transaction_tbl');
        $(document).on("click", "button[btn='show_receipt_btn']", function() {
            let id_struk = $(this).closest('tr').find("td:eq(1)").text();
            let harga = $(this).closest('tr').find("td:eq(2)").text();
            let user = $(this).closest('tr').find("td:eq(3)").text();
            let user_id = $(this).closest('tr').find("td:eq(3)").attr('id');
            let tanggal = $(this).closest('tr').find("td:eq(4)").text();
            $('#price_total').text('.00')
            getReceipt(id_struk);
            $('#id_transaksi').text(id_struk);
            $('#id_user').text(user_id);
            $('#nama_user').text(user);
            $('#tanggal_transaksi').text(tanggal);
            $('#transaction_modal').modal('show')
        });
    });

    function getReceipt(id) {
        $.ajax({
            url: '<?php echo base_url('report/receipt'); ?>',
            type: 'POST',
            data: {
                id_struk: id
            },
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data.result.length != 0) {
                    let receipt = '';
                    let total = 0;
                    let costumer_money = 0
                    $.each(data.result, function(index, item) {
                        receipt += '<tr>'
                        receipt += '<td>' + item.id_barang + '</td>';
                        receipt += '<td>' + item.nama_barang + '</td>';
                        receipt += '<td>Rp. ' + item.harga + '</td>';
                        receipt += '<td>' + item.qty + '</td>';
                        receipt += '<td>Rp. ' + (parseInt(item.harga) * parseInt(item.qty)) + '.00</td>';
                        receipt += '</tr>';
                        total += (parseInt(item.harga) * parseInt(item.qty));
                        costumer_money = parseInt(item.uang)
                    });
                    $('#receipt_tbl tbody').html(receipt);
                    $('#costumer_money').text(costumer_money + '.00')
                    $('#change').text((costumer_money - total) + '.00')
                    $('#price_total').text(total + '.00')
                } else {
                    tableEmpty('#receipt_tbl');
                }
            },

        });
    }
</script>
<?= $this->endSection() ?>