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
                                        <th>Issued On</th>
                                        <th>Valid Till</th>
                                        <th>View</th>
                                        <th>Link Status</th>
                                        <th>Download Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($get_warranty as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->customers->name }}</td>
                                            <td>{{ $item->customers->phone }}</td>
                                            <td>{{ $item->customers->material_type }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->warranty_issue_date)->format('d M, Y h:i a') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->warranty_valid_till)->format('d M, Y h:i a') }}</td>
                                            <td><a href="{{ asset($item->card_link)}}" target="_blank">Warranty Card</a></td>
                                            <td>
                                                @if ($item->is_download_link_sent == 1)
                                                    <p>Sent</p>
                                                @else
                                                    <p>Not Sent</p>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary sendLinkBtn" 
                                                data-id={{encrypt($item->id)}}
                                                data-phone={{encrypt($item->phone)}}
                                                data-material={{encrypt($item->material_type)}}
                                                data-link={{encrypt($item->card_link)}}
                                                >Send Link</button>
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
        $('.sendLinkBtn').on('click', function(){
            alert();
        });
    </script>
@endsection