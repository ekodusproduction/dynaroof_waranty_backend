@extends('welcome')
@section('title', 'Edit customers')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row row-sm">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="card-title mb-1">Edit Customers Details</h6>
                        </div>
                        <div class="mb-4">
                            <form id="editCustomerForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="mb-2">
                                        <label for="">Customer Name</label>
                                    </div>
                                    <input type="text" name="serial_number" class="form-control" value="{{$customer->name}}" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="mb-2">
                                        <label for="">Serial Number</label>
                                    </div>
                                    <input type="hidden" name="customer_id" value="{{$customer->id}}">
                                    <input type="text" name="serial_number" class="form-control" value="{{$customer->serial_number}}" minlength="6" maxlength="6" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-primary edit-update-btn">Update</button>
                                </div>
                            </form>
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
        $('#editCustomerForm').on('submit', function(e){
            e.preventDefault();
            
            const formData = new FormData(this);
            $('.edit-update-btn').text('Please wait...');
            $('.edit-update-btn').attr('disabled', true);

            $.ajax({
                url:"{{route('admin.save.edited.customer.details')}}",
                type:"POST",
                data:formData,
                contentType:false,
                processData:false,
                success:function(data){
                    if(data.status == 200){
                        toastr.success(data.message)
                        $('.edit-update-btn').text('Update');
                        $('.edit-update-btn').attr('disabled', false);
                    }else{
                        toastr.error(data.message)
                        $('.edit-update-btn').text('Update');
                        $('.edit-update-btn').attr('disabled', false);
                    }
                },error:function(err){
                    toastr.error('Oops! Something went wrong');
                    $('.edit-update-btn').text('Update');
                    $('.edit-update-btn').attr('disabled', false);
                }
            });
            
        });
    </script>
@endsection
