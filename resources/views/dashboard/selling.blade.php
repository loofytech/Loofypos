@extends('layouts.applayout')
@section('selling_menu', 'active')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="mt-1">
          <table id="table" class="table w-100">
            <thead>
              <tr>
                <th>Store</th>
                <th>Code</th>
                <th>Total</th>
                <th>Produk</th>
                {{-- <th>Aksi</th> --}}
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('datatables/datatables.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('datatables/datatables.min.js') }}"></script>
<script>
  $(document).ready(function() {
    const table = $('#table').DataTable({
      processing: true,
      serverSide: true,
      ordering: false,
      ajax: "{{ route('selling.data', LoofyHelper::getActiveStore()) }}",
      columns: [
        // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'store.store_name', name: 'store.store_name'},
        {data: 'code', name: 'code'},
        {data: 'total', name: 'total', render: function(value, meta, row) {
          return "Rp" + value.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
        }},
        {data: 'product_sale', name: 'product_sale', render: function(value, meta, row) {
          return value.map((d) => {
            return `<div class="d-flex gap-2 mt-2">
              <img src="${d.product_image}" width="50" height="50" style="border-radius: 4px" />
              <div>
                <b>${d.product_name}</b>
                <br />
                ${d.product_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.")} (x${d.pivot.quantity})
              </div>
            </div>`;
          }).join("");
        }}
        // {
        //   data: 'action', 
        //   name: 'action', 
        //   orderable: true, 
        //   searchable: true
        // },
      ]
    });
  });
</script>
@endpush