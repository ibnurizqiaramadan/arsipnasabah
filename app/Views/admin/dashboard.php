<?= $this->extend('admin/layouts/app'); ?>

<?= $this->section('content'); ?>

<div class="container-fluid pb-3">
    <div class="card shadow border-0">
        <div class="card-body">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere cumque pariatur, laudantium voluptas eius officia eos, aspernatur numquam provident autem aliquam animi maiores iusto vel fuga quas laboriosam! Animi, rerum!
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
<?= $this->section('js'); ?>
<script src="<?= base_url('assets/js/page/admin/dashboard.js') ?>" defer></script>
<?= $this->endSection(); ?>