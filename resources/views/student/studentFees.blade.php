<form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal d-none" role="form">


    <input type="hidden" name="metadata" value="{{ json_encode($array = ['invoiceId' => $fee->id]) }}" >


    <input type="hidden" name="email" value="{{Auth::user()->email}}"> {{-- required --}}

    <input type="hidden" name="orderID" value="345">


    <input type="hidden" name="amount" value="{{$fee->total}}"> {{-- required in kobo --}}

    <input type="hidden" name="currency" value="NGN">

    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">
    {{ csrf_field() }}


    <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">

        <i class="fa fa-plus-circle fa-lg"></i> Pay Now!</button>
</form>
