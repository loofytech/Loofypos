@extends('layouts.applayout')
@section('product_menu', 'active')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProduct">
          Tambah Produk
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="createProduct" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah produk baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row" id="new-product">
          <div class="col-12 mb-3">
            <label for="product_name" class="form-label">Nama Produk</label>
            <input type="text" id="product_name" class="form-control" placeholder="Tulis nama produk" autocomplete="off">
          </div>
          <div class="col-12 mb-3">
            <label for="product_price" class="form-label">Harga Produk</label>
            <input type="text" id="product_price" class="form-control" placeholder="Tulis harga produk" autocomplete="off">
          </div>
          <div class="col-12 mb-4">
            <label for="product_image" class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" id="product_image">
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $('#new-product').on('submit', function(e) {
    e.preventDefault();

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('product_name', $('#product_name').val());
    formData.append('product_price', $('#product_price').val());
    formData.append('product_image', $('#product_image').prop('files')[0]);

    $.ajax({
      cache: false,
      url: '{{ route("product.post", LoofyHelper::getActiveStore()) }}',
      type: 'POST',
      processData: false,
      contentType: false,
      data: formData,
      beforeSend: function() {
        $('button[type="submit"]').prop('disabled', true);
      },
      success: function(data) {
        return location.reload();
      },
      error: function(err) {
        const error = JSON.parse(err.responseText);
        $('#password').val('');
        $('button[type="submit"]').prop('disabled', false);

        return Swal.fire('Submit Produk', error.message, 'warning');
      }
    });
  });
</script>
@endpush