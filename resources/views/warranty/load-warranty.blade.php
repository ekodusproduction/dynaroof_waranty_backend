<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Warranty Card</title>
</head>
<body>
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
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="warranty-pdf-div">
                            <div class="top-bar"></div>
                            <div class="pdf-header">
                                <p>Certificate <br /> of</p>
                                <h2 style="margin-top:0px;">Warranty</h2>
                            </div>
                            <div class="pdf-body">
                                <div style="margin-bottom:30px;">
                                    <p style="line-height: 30px;">
                                        This certificate serves as confirmation of product warranty for 
                                        <bold>{{$name}}</bold> - Phone No: <bold>{{$phone}}</bold>, residing in <bold>{{$address}}</bold>, who has purchased the 
                                        <bold>{{$material_type}}</bold> material with Serial No: <bold>{{$serial_no}}</bold> on <bold>{{$purchase_date}}</bold>.
                                        The warranty is valid until <bold>{{$warranty_valid_till}}</bold>, and was issued on <bold>{{$warranty_issue_date}}</bold>.
                                    </p>
                                </div>
                                <div style="margin-top:30px;">
                                    <p style="margin-right:102px;">Company Name  :  <bold>Dyna Roof</bold></p>
                                    <p>Contact No  :  <bold>7578800222</bold></p>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>