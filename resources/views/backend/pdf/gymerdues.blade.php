
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-10">
      <h2 class="text-center"> <u> {{ config('app.name') }} </u> </h2> <br>
        <h2 class="text-center mb-4"><b> Gymer Dues</b> </h2>
        <br>
       <strong for="">Shift : {{ $shifts->shift_name }} <span class="ml-2">( {{ $shifts->starttime }} - {{ $shifts->endtime }} ) </span></strong> <strong class="float-right">Date : <span class="warning">{{$date}}</span></strong>
        <table class="table table-bordered mt-2">
            <thead class="thead-dark">
                <tr>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Dues</th>
                </tr>
            </thead>
            <tbody>

                    @foreach ($dues as $due )
                        <tr>
                            <td>{{$due->getUser->name}}</td>
                            <td>{{$due->getUserdetail->phone}}</td>
                            <td>{{abs($due->initial_advance)}}</td>
                        </tr>
                    @endforeach

        </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html>
