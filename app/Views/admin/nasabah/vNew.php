<?= $this->extend('admin/layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid pb-3">
    <div class="card shadow border-0">
        <div class="card-header">
            <h4 class="card-title">Nasabah Baru</h4>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">NAMA LENGKAP</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nama">
                </div>
                <div id='validate_nama'></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nik">
                </div>
                <div id='validate_nik'></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">NOMOR REKENING</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="norek">
                </div>
                <div id='validate_norek'></div>
            </div>

            <div id="inputNasabah">

            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-danger btn-sm float-left">Batal</button>
            <button class="btn btn-success btn-sm float-right">Simpan</button>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script src="<?= base_url('assets/js/page/nasabahBaru.js') ?>" defer></script>
<?= $this->endSection(); ?>