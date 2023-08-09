
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>
<body>

<section class="content mt-3">
         <div class="container">
         <div class="card">
         <div class="card-body">
        <div class="row ">
            <div class="col-12  mb-5">
                <h2 class="text-center"> <u> {{ config('app.name') }}</u> </h2>
                <strong class="float-right mr-5 mt-3">Date : {{$date}}</strong>
            </div>

            <div class="col-md-12 mb-4 ">
                <strong >Name : </strong> <span class="mr-5">{{$datas->users->name}}</span><br>
                <strong >Adrress : </strong> <span class="mr-5">{{$datas->address}}</span><br>
                <strong >Phone : </strong> <span class="mr-5">{{$datas->phone}}</span><br>
                <strong >Email : </strong> <span class="mr-5">{{$datas->users->email}}</span><br>
                <strong  >Admission Fee : Rs. </strong> <span class="mr-5 ">{{$datas->admission}}</span><br>
                <strong >Total Paid Amount  : Rs. </strong> <span class="mr-5"> {{$total}}</span><br>

            </div>
            <div class="col-11">
                <table class="table table-bordered">
                     <thead>
                        <tr>
                            <th scope="col">Offers</th>
                            <th scope="col">Payment Types</th>
                            <th scope="col">Group Discounts</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if($offers)
                               {{ $offers->offer->name }}
                               @else
                                     <span> No Offer Type</span>
                                @endif
                            </td>
                            <td>
                                  @if($payment_types)
                                    {{ $payment_types->anual_payment->payment_name }}
                                    @else
                                        <span>No Payment Type</span>

                                    @endif
                            </td>
                            <td>
                                @if($discount_groups > 0)
                                        <span>{{ $group_percent }} %</span>
                                @else
                                    <span>No</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
        </div>
     </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>
