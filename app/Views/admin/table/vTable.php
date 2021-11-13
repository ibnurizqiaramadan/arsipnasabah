<?= $this->extend('admin/layouts/app'); ?>
<?= $this->section('content'); ?>
<style>
    tbody tr:hover {
        background: #eee;
        box-shadow: 0 1px 2px rgb(242, 242, 242);
        cursor: pointer;
    }
</style>
<div class="container-fluid pb-3">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xl-12">
            <div class="card border-0 shadow mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="float-right ml-3">
                            <button class="btn btn-sm btn-primary" id="btnAdd" title="Data Baru">
                                <i class="fas fa-plus mr-1"> </i>Baru
                            </button>
                        </div>
                        <table id="<?= $table['id'] ?>" data-path="<?= $table['path'] ?? "" ?>" class="table table-bordered w-100 table-id">
                            <thead>
                                <tr>
                                    <?php foreach ($table['headerFooter'] as $headfoot) : ?>
                                        <th><?= $headfoot ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <?php foreach ($table['headerFooter'] as $headfoot) : ?>
                                        <th><?= $headfoot ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="floatButton"></div>
</div>

<div class="modal fade" id="modalForm" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="formInput">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="formBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<?php
foreach ($scripts as $script) {
    echo "<script src='$script' defer></script>";
}
?>
<?= $this->endSection(); ?>