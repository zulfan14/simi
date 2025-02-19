@extends('layouts.app')

@section('content')
<!-- <div class="section-header">
  </div> -->
  
  <div class="dashboard-first">
  <div class="container">
  <h1>Dashboard</h1>
    <div class="row">
      <div class="col-lg-3 col-sm-6">
          <div class="card-box" style="background-color: #ff914d !important;  opacity:0.9">
              <div class="inner">
                  <h3> 6 </h3>
                  <p> Data Aset </p>
              </div>
              <div class="icon">
                  <i class="fa fa-university" aria-hidden="true"></i>
              </div>
              <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>

      <div class="col-lg-3 col-sm-6">
          <div class="card-box" style="background-color: #ff3131 !important; opacity:0.9">
              <div class="inner">
                  <h3> 10 </h3>
                  <p> Data Barang </p>
              </div>
              <div class="icon">
                  <i class="fa fa-desktop"></i>
              </div>
              <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>

      <div class="col-lg-3 col-sm-6">
          <div class="card-box" style="background-color: #1597ff; opacity:0.9">
              <div class="inner">
                  <h3> 7 </h3>
                  <p> Pengguna </p>
              </div>
              <div class="icon">
                  <i class="fa fa-user-plus" aria-hidden="true"></i>
              </div>
              <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>
      <div class="col-lg-3 col-sm-6">
          <div class="card-box" style="background-image: linear-gradient(#ff3131, #ff914d); opacity: ;">
              <div class="inner">
                  <h3> 723 </h3>
                  <p> Inventory Service </p>
              </div>
              <div class="icon">
                  <i class="fa fa-cogs"></i>
              </div>
              <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-sm-6">
          <div class="card-box" style="background-image: linear-gradient(to right, #000000, #c89116)">
              <div class="inner">
                  <h3> 1 </h3>
                  <p> Barang Rusak </p>
              </div>
              <div class="icon">
                  <i class="fa fa-exclamation-triangle"></i>
              </div>
              <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>

      <div class="col-lg-3 col-sm-6">
          <div class="card-box" style="background-image: linear-gradient(to right, #004aad, #cb6ce6)">
              <div class="inner">
                  <h3> 3 </h3>
                  <p> Aset Menyusut </p>
              </div>
              <div class="icon">
                  <!-- <i class="fa fa-money" aria-hidden="true"></i> -->
                  <i class="fa fa-building"></i>
              </div>
              <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>

    </div>
  </div>
  </div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('summaryChart').getContext('2d');
    var chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
          @foreach($barangMasukData as $data)
              '{{ date("F", strtotime($data->date)) }}',
          @endforeach
        ],
        datasets: [
          {
            label : 'Barang Masuk',
            data: [
                @foreach($barangMasukData as $data)
                    '{{ $data->total }}',
                @endforeach
            ],
            backgroundColor: 'blue'
          },
          {
            label : 'Barang Keluar',
            data: [
                @foreach($barangKeluarData as $data)
                    '{{ $data->total }}',
                @endforeach
            ],
            backgroundColor: 'red'
          }
        ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            precision: 0,
            stepSize: 1,
            ticks: {
              callback: function(value) {
                if (value % 1 === 0) {
                  return value;
                }
              }
            }
          }
        }
      }
    });
</script>
@endpush
