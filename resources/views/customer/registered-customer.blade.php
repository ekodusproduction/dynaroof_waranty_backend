@extends('welcome')
@section('title', 'Registered customers')
@section('content')
    <div class="container mt-4">
        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="card-title mb-1">Registered Customers</h6>
                        </div>
                        <div class="mb-4">
                            <div class="table-responsive" >
                                <table id="registeredCustomerTable" class="table table-bordered mg-b-1 text-md-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Dealer Name</th>
                                            <th>Material Type</th>
                                            <th>Date of Purchase</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customer as $index => $item)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->email}}</td>
                                                <td>{{$item->phone}}</td>
                                                <td>{{$item->dealer_name}}</td>
                                                <td>{{$item->material_type}}</td>
                                                <td>{{\Carbon\Carbon::parse($item->date_of_purchase)->format('d M, Y')}}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary">View</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>No data found.</td>
                                            </tr>
                                        @endforelse
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('custom-scripts')
    <script>
        $(document).ready(function() {
            $('#registeredCustomerTable').dataTable({
                dom: 'Bfrtip',
                ordering: true,
                searching: true,
                buttons: [
                    'pdf',
                    'excel',
                    'print'
                ]
            });
        });
    </script>
@endsection