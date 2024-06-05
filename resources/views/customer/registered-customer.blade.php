@extends('welcome')
@section('title', 'Registered customers')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="card-title mb-1">Registered Customers</h6>
                        </div>
                        <div class="mb-4">
                            <div class="table-responsive">
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
                                            <th>Date of Reg.</th>
                                            <th>Warranty Issued</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customer as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Str::limit($item->name, 8) }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->dealer_name }}</td>
                                                <td>{{ $item->material_type }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->date_of_purchase)->format('d M, Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M, Y') }}</td>
                                                <td style="text-align: center;">
                                                    @if ($item->is_warranty_issued == 1)
                                                        <p style="font-weight:bold;color:rgb(3, 158, 3);">YES</p>
                                                    @else
                                                        <p style="font-weight:bold;color:rgb(202, 5, 5);">NO</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">More</button>
                                                        <ul class="dropdown-menu" style="padding:15px;">
                                                            <li>
                                                                <a class="dropdown-item btn btn-sm btn-primary cutomerModalBtn" href="javascript:void(0);" data-id={{encrypt($item->id)}}>
                                                                    <i class="tf-icons bx bxs-search"> View </i>
                                                                </a>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item btn btn-sm btn-info edit-customer-btn" href="{{route('admin.edit.customer', ['id' => encrypt($item->id)])}}">
                                                                    <i class="tf-icons bx bxs-edit"> Edit </i>
                                                                </a>
                                                                <hr class="dropdown-divider">
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item btn-sm btn-danger delete-customer-btn" href="javascript:void(0);"  data-id={{encrypt($item->id)}}>
                                                                    <i class="tf-icons bx bxs-trash"> Delete</i>
                                                                </a>
                                                            </li>
                                                            
                                                        </ul>
                                                    </div>
                                                    {{-- <button class="btn btn-sm btn-primary cutomerModalBtn" data-id={{encrypt($item->id)}}>
                                                        <i class="tf-icons bx bxs-search"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger delete-customer-btn" data-id={{encrypt($item->id)}}>
                                                        <i class="tf-icons bx bxs-trash"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-info delete-customer-btn" data-id={{encrypt($item->id)}}>
                                                        <i class="tf-icons bx bxs-edit"></i>
                                                    </button> --}}
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
    
    <div id="viewCustomerDetailsModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="padding:15px;">
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
                // buttons: [
                //     'pdf',
                //     'excel',
                //     'print'
                // ]
                buttons: [
                    {
                        extend: 'print',
                        pageSize: 'A4',
                        footer: true,
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7]
                        }
                    },
                    {
                        extend: 'pdf',
                        pageSize: 'A4',
                        footer: true,
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        footer: false,
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6,7]
                        }
                    } 
                ],
            });
        });

        $('.cutomerModalBtn').on('click', function(){
            const customer_id = $(this).data('id')
            $.ajax({
                url:"{{route('admin.get.customer.details')}}",
                type:"POST",
                data:{
                   'customer_id': customer_id,
                   '_token': "{!! csrf_token() !!}"
                },
                success:function(data){
                   if(data.status == 200){
                        const modalContent = 
                        `
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel3">Customer Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="demo-inline-spacing mt-3">
                                            <div class="list-group list-group-horizontal-md text-md-center">
                                                <a class="list-group-item list-group-item-action active" id="home-list-item"
                                                    data-bs-toggle="list" href="#basic">Basic</a>
                                                <a class="list-group-item list-group-item-action" id="profile-list-item"
                                                    data-bs-toggle="list" href="#dealer">Dealer</a>
                                                <a class="list-group-item list-group-item-action" id="messages-list-item"
                                                    data-bs-toggle="list" href="#product">Product</a>
                                                <a class="list-group-item list-group-item-action" id="settings-list-item"
                                                    data-bs-toggle="list" href="#documents">Documents</a>
                                            </div>
                                            <div class="tab-content px-0 mt-0">
                                                <div class="tab-pane fade show active" id="basic">
                                                    <div class="d-flex flex-row flex-wrap">
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Full Name:</label>
                                                            <p>${data.data.name}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Phone Number:</label>
                                                            <p>+91-${data.data.phone}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Email Id:</label>
                                                            <p>${data.data.email}</p>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="tab-pane fade" id="dealer">
                                                    <div class="d-flex flex-row flex-wrap">
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Name:</label>
                                                            <p>${data.data.dealer_name}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="product">
                                                    <div class="d-flex flex-row flex-wrap">
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Material Type:</label>
                                                            <p>${data.data.material_type}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Date of Purchase:</label>
                                                            <p>${data.data.date_of_purchase}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Country:</label>
                                                            <p>${data.data.country}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">State:</label>
                                                            <p>${data.data.state}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">District:</label>
                                                            <p>${data.data.district}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Color of Sheets:</label>
                                                            <p>${data.data.color_of_sheets}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Number of Sheets:</label>
                                                            <p>${data.data.number_of_sheets}</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Thickness of Sheets:</label>
                                                            <p>${data.data.thickness_of_sheets} (mm)</p>
                                                        </div>
                                                        <div class="mb-2" style="margin-left:50px;">
                                                            <label for="">Serial Number:</label>
                                                            <p>${data.data.serial_number}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="documents">
                                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                                        <img src="{{asset('bg-8.jpg')}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar">
                                                        <div class="button-wrapper">
                                                            <a href="../${data.data.invoice}" target="_blank" class="btn btn-primary me-2 mb-4" download data-id="${data.data.id}" id="downloadInvoiceBtn" >Download Invoice</a>
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"> Close </button>
                            </div>
                        `;
                    
                        $('#viewCustomerDetailsModal .modal-content').html(modalContent);

                        $('#viewCustomerDetailsModal').modal('show');
                   }
                },error:function(error){
                    console.log('Error ==>',error)
                }
            });
        });

        $('#downloadInvoiceBtn').on('click', function(){
            const customer_id = $(this).data('id');
            $.ajax({
                url:"{{route('admin.invoice.count')}}",
                type:"POST",
                data:{
                    customer_id : customer_id,
                    '_token' : "{{ csrf_token() }}"
                },success:function(data){
                    console.log(data)
                },error:function(error){
                    console.log(error)
                }

            });
        });

        $('.delete-customer-btn').on('click', function(e){
            e.preventDefault();

            const customer_id = $(this).data('id');

            $(this).text('Please wait...');
            $(this).attr('disabled', true);

            $.ajax({
                url:"{{route('admin.delete.customer')}}",
                type:"POST",
                data:{
                    '_token': "{!! csrf_token() !!}",
                    'customer_id':customer_id
                },
                success:function(data){

                    if(data.status == 200){
                       toastr.success(data.message)
                       window.location.reload(true);
                    }else{
                        toastr.error(data.message)
                        $('.delete-customer-btn').text('Delete');
                        $('.delete-customer-btn').attr('disabled', false);
                    }
                },error:function(err){
                    toastr.error("Oops! Something went wrong")
                    $('.delete-customer-btn').text('Delete');
                    $('.delete-customer-btn').attr('disabled', false);
                }
            });
        });
    </script>
@endsection
