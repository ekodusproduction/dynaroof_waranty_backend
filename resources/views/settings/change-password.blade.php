@extends('welcome')
@section('title', 'Change Password')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card mt-4">
                    <div class="card-title mt-4 mb-0">
                        <h5 class="mx-4 mb-0">Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form id="changePasswordForm" class="form-horizontal" action="{{route('admin.settings.change.password')}}" method="POST">
                            @csrf
                            <div class="form-group mb-4">
                                <div class="mb-2">
                                    <label for="">New password</label>
                                </div>
                                <input type="text" name="newPassword" id="newPassword" class="form-control" placeholder="********">
                            </div>
                            <div class="form-group mb-4">
                                <div class="mb-2">
                                    <label for="">Confirm password</label>
                                </div>
                                <input type="text" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="********">
                            </div>
                            <div class="form-group mb-4">
                                <button type="submit" class="btn btn-md btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom-scripts')
<script>

    @if($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}');
        @endforeach
    @endif

    @if (session('success'))
        toastr.success('{{ session('success') }}', '', {
            positionClass: 'toast-top-right',
            timeOut: 3000
        });
    @endif

    // @if (session('error'))
    //     toastr.error('{{ session('error') }}', '', {
    //         positionClass: 'toast-top-right',
    //         timeOut: 3000
    //     });
    // @endif
</script>
@endsection