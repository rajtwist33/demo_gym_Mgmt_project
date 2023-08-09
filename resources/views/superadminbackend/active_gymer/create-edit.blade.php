<div class="container">
    <div class="row">
            <div class="col-12">
                <label for="">Name : </label> <strong>{{$data_list->name}}</strong>
                <label for="" class="ml-4">Phone : </label> <strong>{{$data_list->getUserDetail->phone}}</strong>
            </div>
            <div class="col-12 mt-3">
            <div class="row justify-content-center">
                <div class="col-10">
            <table class="table table-bordered border-primary">
                <thead>
                    <tr>  
                    <th scope="col"> Date </th>
                    <th scope="col">Paid Amount</th>
                    <th scope="col">Dues</th>
                    <th scope="col">Advance</th>
                    
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach ($payments as $payment )
                    <tr>
                       <td>{{ $payment->date }}</td> 
                       <td>{{ $payment->amount }}</td> 
                       <td>{{ $payment->dues }}</td> 
                       <td>{{ $payment->advance }}</td> 
                       </tr>
                    @endforeach
                  
                </tbody>
                </table>
                </div>
            </div>
            </div>
    </div>
</div>
