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
                                        <th>Send Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($get_warranty as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->customers->name }}</td>
                                            <td>{{ $item->customers->phone }}</td>
                                            <td>{{ $item->customers->material_type }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->warranty_issue_date)->format('d M, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->warranty_valid_till)->format('d M, Y') }}</td>
                                            <td><a href="{{asset(basename($item->card_link))}}" target="_blank">Warranty</a></td>
                                            <td>
                                                @if ($item->is_download_link_sent == 1)
                                                    <p class="text-success mb-0">Sent</p>
                                                @else
                                                    <p>Not Sent</p>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary sendLinkBtn" 
                                                data-id={{$item->customer_id}}
                                                data-phone={{$item->customers->phone}}
                                                data-material={{$item->customers->material_type}}
                                                data-link={{asset($item->card_link)}}
                                                >Send</button>
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
            $(this).attr('disabled', true)
            $(this).text('sending..')
            const customer_id = $(this).data('id');
            const phone = $(this).data('phone');
            const material = $(this).data('material');
            const link = $(this).data('link');

            console.log([{Id: customer_id, Phone: phone, Material: material, Link: link}]);
            
            $.ajax({
                url:"{{route('admin.send.warranty.card.link')}}",
                type:"POST",
                data:{
                    'customer_id' : customer_id,
                    'phone' : phone,
                    'material' : material,
                    'link' : link,
                    '_token' : "{{csrf_token()}}"
                },
                success:function(data){
                    if(data.status == 200){
                        toastr.success(data.message, '', {
                            positionClass: 'toast-top-right',
                            timeOut: 3000
                        });
                        $('.sendLinkBtn').attr('disabled', false)
                        $('.sendLinkBtn').text('Send Link')
                        location.reload(true)
                    }else{
                        toastr.error(data.message, '', {
                            positionClass: 'toast-top-right',
                            timeOut: 3000
                        });
                        $('.sendLinkBtn').attr('disabled', false)
                        $('.sendLinkBtn').text('Send Link')
                    }
                },error:function(error){
                    toastr.error(error, '', {
                        positionClass: 'toast-top-right',
                        timeOut: 3000
                    });
                    $('.sendLinkBtn').attr('disabled', false)
                    $('.sendLinkBtn').text('Send Link')
                }
            });
        });
    </script>
@endsection