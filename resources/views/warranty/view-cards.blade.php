@extends('welcome')
@section('title', 'View Cards')
@section('content')
<div class="container-fluid mt-4">
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="card-title mb-1">List of generated warranty cards</h6>
                    </div>
                    <div class="mb-4">
                        <div class="table-responsive">
                            <table id="registeredCustomerTable" class="table table-bordered mg-b-1 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>Sl. No.</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Material</th>
                                        <th>Warranty Issue On</th>
                                        <th>Warranty Valid Till</th>
                                        <th>View</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($get_warranty as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->customers->name }}</td>
                                            <td>{{ $item->customers->phone }}</td>
                                            <td>{{ $item->customers->material_type }}</td>
                                            <td>{{ $item->warranty_issue_date }}</td>
                                            <td>{{ $item->warranty_valid_till }}</td>
                                            <td><a href="{{ asset($item->card_link)}}" target="_blank">Warranty Card</a></td>
                                            <td>
                                                <button class="btn btn-sm btn-primary cutomerModalBtn" data-id={{encrypt($item->id)}}>View</button>
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