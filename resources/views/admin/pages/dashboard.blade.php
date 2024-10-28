@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 bold mt-4">Dashboard</h1>
       
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card  shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12">
                           <img src="{{ asset('admin/img/1-icon.png') }}" width="50px" alt="">
                        </div>
                        <div class="col mt-3">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Sales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">TZS 3,500</div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card  shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12">
                           <img src="{{ asset('admin/img/2-cion.png') }}" width="50px" alt="">
                        </div>
                        <div class="col mt-3">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">480</div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card  shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12">
                           <img src="{{ asset('admin/img/3-icon.png') }}" width="50px" alt="">
                        </div>
                        <div class="col mt-3">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Total Customer</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">22995</div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-2 col-md-6 mb-4">
            <div class="card  shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12">
                           <img src="{{ asset('admin/img/4-cion.png') }}" width="50px" alt="">
                        </div>
                        <div class="col mt-3">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Ebooks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">195</div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
         <!-- Pending Requests Card Example -->
         <div class="col-xl-2 col-md-6 mb-4">
            <div class="card  shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12">
                           <img src="{{ asset('admin/img/5-cion.png') }}" width="50px" alt="">
                        </div>
                        <div class="col mt-3">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Cheat Sheets</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">50</div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
         <!-- Pending Requests Card Example -->
         <div class="col-xl-2 col-md-6 mb-4">
            <div class="card  shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12">
                           <img src="{{ asset('admin/img/6-cion.png') }}" width="50px" alt="">
                        </div>
                        <div class="col mt-3">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Exam Preps</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">80</div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
          <!-- Pending Requests Card Example -->
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Sales</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="myBarChart"></canvas>
                    </div>
                  
                </div>
                <div class="row pl-3 pr-3">
                    <div class="col-md-6">
                        <p class="text-dark">Total Sales: <span class="bold"> 12,345</span></p>
                    </div>
                    <div class="col-md-6 float-right">
                        <p class="text-dark float-right">Earnings: <span class="bold">1,32,450</span></p>
                    </div>
                  </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">Visitors</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
                <div class="row pl-3 pr-3">
                    <div class="col-md-6">
                        <p class="text-dark">Total Visitor : <span class="bold"> 3,424</span></p>
                    </div>
                  
                  </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Order</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Invoice NO</th>
                                    <th>Order Time</th>
                                    <th>Customer Name</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Cost</th>
                                    <th>Selling cost</th>
                                    <th>Margins</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                          
                            <tbody>
                                <tr>
                                    <td>10902</td>
                                    <td>Apr 13, 2024  9:59 AM</td>
                                    <td>John Doe</td>
                                    <td>Card</td>
                                    <td>TZS 3,500</td>
                                    <td>TZS 1,500</td>
                                    <td>TZS 1,000</td>
                                    <td>TZS 1,000</td>
                                    <td><i class="fa fa-circle text-success"></i> completed</td>
                                    <td>
                                        <div  class="row ml-1">
                                            <a class="text-gray-600" href=""><i class="fa fa-edit"></i></a>
                                            <div class="dropdown no-arrow ml-2 ">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10902</td>
                                    <td>Apr 13, 2024  9:59 AM</td>
                                    <td>John Doe</td>
                                    <td>Card</td>
                                    <td>TZS 3,500</td>
                                    <td>TZS 1,500</td>
                                    <td>TZS 1,000</td>
                                    <td>TZS 1,000</td>
                                    <td><i class="fa fa-circle text-danger"></i> Pending</td>
                                    <td>
                                        <div  class="row ml-1">
                                            <a class="text-gray-600" href=""><i class="fa fa-edit"></i></a>
                                            <div class="dropdown no-arrow ml-2 ">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10902</td>
                                    <td>Apr 13, 2024  9:59 AM</td>
                                    <td>John Doe</td>
                                    <td>Card</td>
                                    <td>TZS 3,500</td>
                                    <td>TZS 1,500</td>
                                    <td>TZS 1,000</td>
                                    <td>TZS 1,000</td>
                                    <td><i class="fa fa-circle text-primary"></i> Processing</td>
                                    <td>
                                        <div  class="row ml-1">
                                            <a class="text-gray-600" href=""><i class="fa fa-edit"></i></a>
                                            <div class="dropdown no-arrow ml-2 ">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10902</td>
                                    <td>Apr 13, 2024  9:59 AM</td>
                                    <td>John Doe</td>
                                    <td>Card</td>
                                    <td>TZS 3,500</td>
                                    <td>TZS 1,500</td>
                                    <td>TZS 1,000</td>
                                    <td>TZS 1,000</td>
                                    <td><i class="fa fa-circle text-primary"></i> Processing</td>
                                     <td>
                                        <div  class="row ml-1">
                                            <a class="text-gray-600" href=""><i class="fa fa-edit"></i></a>
                                            <div class="dropdown no-arrow ml-2 ">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10902</td>
                                    <td>Apr 13, 2024  9:59 AM</td>
                                    <td>John Doe</td>
                                    <td>Card</td>
                                    <td>TZS 3,500</td>
                                    <td>TZS 1,500</td>
                                    <td>TZS 1,000</td>
                                    <td>TZS 1,000</td>
                                    <td><i class="fa fa-circle text-primary"></i> Processing</td>
                                     <td>
                                        <div  class="row ml-1">
                                            <a class="text-gray-600" href=""><i class="fa fa-edit"></i></a>
                                            <div class="dropdown no-arrow ml-2 ">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>10902</td>
                                    <td>Apr 13, 2024  9:59 AM</td>
                                    <td>John Doe</td>
                                    <td>Card</td>
                                    <td>TZS 3,500</td>
                                    <td>TZS 1,500</td>
                                    <td>TZS 1,000</td>
                                    <td>TZS 1,000</td>
                                    <td><i class="fa fa-circle text-primary"></i> Processing</td>
                                     <td>
                                        <div  class="row ml-1">
                                            <a class="text-gray-600" href=""><i class="fa fa-edit"></i></a>
                                            <div class="dropdown no-arrow ml-2 ">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-600"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="dropdownMenuLink">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <!-- Additional styles for this page -->
    <!-- Inline styles -->
    <style>
        table {
            font-size: 13px;
        }
    </style>
@endpush

@push('scripts')
    <!-- Additional scripts for this page -->
    
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-pie-demo.js') }}"></script>
    <script src="{{ asset('admin/js/demo/chart-bar-demo.js') }}"></script>
@endpush
