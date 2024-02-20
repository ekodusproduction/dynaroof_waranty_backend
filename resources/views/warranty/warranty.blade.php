@extends('welcome')
@section('title', 'Warranty Card')
@section('content')

<style>
    *{
        color:#2d2e2e;
        font-weight: 400;
        
    }
    .top-bar{
        height:70px;
        width:100%;
        background-color:#566a7f;
        margin-bottom:30px;
    }

    .pdf-header{
        text-align: center;
    }
    .pdf-header p{
        color: #174579;
        font-weight: 600;
        font-size: 25px;
        text-transform: uppercase;
        margin-bottom:0px;
    }
    .pdf-header h2{
        color: #154279;
        font-weight: 600;
        font-size: 40px;
        text-transform: uppercase;
    }
    .pdf-body{
        margin:50px;
    }
</style>
<div class="container-fluid mt-4">
    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="card-title mb-1">Generate Warranty Card</h6>
                    </div>
                    <form action="{{route('admin.load.warranty.card')}}" method="get">
                        <div class="form-group mb-3">
                            <label for="" class="mb-2">Select customer</label>
                            <select name="customer_id" class="form-control selected-customer" required>
                                <option value="" selected disabled hidden>- Select -</option>
                                @forelse ($get_customers as $item)
                                    <option value="{{$item->id}}">{{$item->name}} - ( phone : {{$item->phone}} )</option>
                                @empty
                                   <option value="">No data found</option> 
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Generate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- @section('custom-scripts')
    <script>
        $('.selected-customer').on('change', function(e){
            const selected_id =  e.target.value;
            $.ajax({
                url:"{{route('admin.generate.warranty.card')}}",
                type:"POST",
                data:{
                    'selected_id' : selected_id,
                    '_token' : "{{csrf_token()}}"
                },
                success:function(data){
                    console.log('Data ==>', data)
                },
                error:function(error){
                    console.log(error)
                }
            })
        });
    </script>
@endsection --}}