<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="g-recaptcha {{ $hasError ? 'is-invalid' : '' }}" data-sitekey="{{ $client_key }}"></div>
