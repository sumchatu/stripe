<form action ="{{route('stripe.payment')}}" method="post">
    @csrf

    <input type="hidden" name="name" value="{{$data['name']}}">
                <input type="hidden" name="mobile" value="{{$data['mobile']}}">
                <input type="hidden" name="email" value="{{$data['email']}}">
                <input type="hidden" name="amount" value="{{$data['amount']}}">
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="pk_test_51H1CFLBWYiAmbMxSbSoPZh1OCiNkPIIsmS8LXijHZsA1V07NFKlmYh4namHwvDwMhHoVfVHOuguRFFBWRNL7eWn1006fajH7la";
        data-amount = "{{$data['amount']*100}}"
        data-email = "{{$data['email']}}"
        data-name = "{{$data['name']}}"
        data-currency = "inr"
    >
    </script>
</form>