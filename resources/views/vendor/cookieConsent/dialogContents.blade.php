<style>
    #cookieWrapper {
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 100;
        margin: 0;
        border-radius: 0;
    }
</style>

<div id="cookieWrapper" class="bg-dark text-white w-100 py-3 text-center">
    <div class="js-cookie-consent d-inline  cookie-consent">

    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}
    </span>

        <button onclick="$('#cookieWrapper').remove()"
                class="js-cookie-consent-agree text-dark btn btn-light cookie-consent__agree">
            {{ trans('cookieConsent::texts.agree') }}
        </button>
    </div>
</div>