@extends('layouts.applayout')
@section('dashboard_menu', 'active')

@section('content')
<div class="row">
  <div class="col-lg-3 col-md-12 col-6">
    <div class="card">
      <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
          <div class="avatar flex-shrink-0">
            <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}" alt="Credit Card" class="rounded">
          </div>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" style="">
              <a class="dropdown-item" href="{{ route('selling', LoofyHelper::getActiveStore()) }}">Selengkapnya</a>
            </div>
          </div>
        </div>
        <span class="fw-semibold d-block mb-1">Penjualan hari ini</span>
        <h3 class="card-title mb-0" id="selling" data-selling="{{ $selling }}">Rp 0</h3>
        {{-- <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +72.80%</small> --}}
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  $(document).ready(function() {
    $('#selling').text('Rp ' + $('#selling').data('selling').toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
  });
</script>
@endpush