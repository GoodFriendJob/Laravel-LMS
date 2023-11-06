<form id="caseFreePaymentForm" method="post" action="{{ $endPoint }}">
@foreach($parameters as $key => $value)
    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
@endforeach
    <input type="hidden" name="signature" value="{{ $signature }}">
</form>
<script>document.getElementById("caseFreePaymentForm").submit();</script>
