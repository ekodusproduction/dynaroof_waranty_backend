@extends('welcome')
@section('title', 'Dashboard')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img class="card-img card-img-left" style="height:100%;" src="bg-4.jpg" alt="Card image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5>Registered Customers</h5>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="{{route('admin.get.registered.customer')}}">View More</a>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="card-title text-nowrap mb-1">{{$customer_count}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img class="card-img card-img-left" style="height:100%;" src="bg-9.jpg" alt="Card image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5>Invoices Downloaded</h5>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="card-title text-nowrap mb-1">7000</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img class="card-img card-img-left" style="height:100%;" src="bg-10.jpg" alt="Card image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <h5>Warranty Cards issued</h5>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="card-title text-nowrap mb-1">7000</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection