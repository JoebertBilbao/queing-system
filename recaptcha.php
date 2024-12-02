<!-- Add the following script in your <head> section -->
<script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_site_key"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
   function onSubmit(token) {
     document.getElementById("demo-form").submit();
   }
 </script>
  <script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('reCAPTCHA_site_key', {action: 'submit'}).then(function(token) {
              // Add your logic to submit to your backend server here.
          });
        });
      }
  </script>

<form method="post" class="form">
    <!-- Other form fields go here -->
    
    <!-- Add the reCAPTCHA widget -->
    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="mccsystemcapstone2/mccsystem"></div> <!-- Replace YOUR_SITE_KEY with your actual site key -->
    </div>

    <div class="form-group">
        <button class="g-recaptcha" 
        data-sitekey="reCAPTCHA_site_key" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button>

    </div>
</form>
