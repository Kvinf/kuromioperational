@extends('applayout')
@section('content')
    <div class="content-header">
    <h1>Item Management</h1>
    <button type="button" style="width: 75px" class="buttonCustom" data-bs-toggle="modal" data-bs-target="#exampleModal">
        +
    </button>
    </div>
    <br/>
    <table class="table">
        <thead>
            <tr style="background-color: transparent">
                <th style="background-color: transparent" scope="col">No.</th>
                <th style="background-color: transparent" scope="col">Item</th>
                <th style="background-color: transparent" scope="col">Price</th>
                <th style="background-color: transparent" scope="col">-</th>
            </tr>
        </thead>
        <tbody>
            
          @foreach($items as $index => $item)
          <tr style="background-color: transparent"> 
              <th style="background-color: transparent" scope="row">{{ $index + 1 }}</th>
              <td style="background-color: transparent" >{{ $item['name'] }}</td>
              <td style="background-color: transparent">Rp. {{ number_format($item['price'] ,2)}}</td>
              <td style="background-color: transparent"></td>
          </tr>
          @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('addItem') }}" method="POST">
                        @csrf
                        <div class="itemSection">
                          <label class="itemLabel">Name</label>
                          <input class="itemInput" name="name" type="text"> 
                        </div>
                        <div class="itemSection">
                          <label class="itemLabel">Price (RP. )</label>
                          <input  name="price" type="number" class="itemInput no-spinner"> 
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Add"/>
                </div>
              </form>

            </div>
        </div>
    </div>
@endsection
