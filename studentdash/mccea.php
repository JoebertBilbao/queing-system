<?php include 'index.php'; ?>
<style>
    body {
        background-color: #f8f9fa; /* Light gray background */
    }
</style>
<div class="container">
    <div class="text-center mt-5">
        <h1>MCCEA Office</h1>
    </div>

    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                    <div class="container">
                    <form id="uniform-request-form" role="form" method="post" action="../action/mccea.php">
    <div class="controls">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_name">Firstname *</label>
                    <input id="form_name" type="text" name="firstname" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_lastname">Lastname *</label>
                    <input id="form_lastname" type="text" name="lastname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="form_email">Email *</label>
            <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender">Gender *</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="upper_size">Upper Size *</label>
                    <select class="form-control" id="upper_size" name="upper_size" required>
                        <option value="">Select Size</option>
                        <option value="xs">XS - Extra Small</option>
                        <option value="s">S - Small</option>
                        <option value="m">M - Medium</option>
                        <option value="l">L - Large</option>
                        <option value="xl">XL - Extra Large</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="lower_size">Lower Size *</label>
                    <select class="form-control" id="lower_size" name="lower_size" required>
                        <option value="">Select Size</option>
                        <option value="xs">XS - Extra Small</option>
                        <option value="s">S - Small</option>
                        <option value="m">M - Medium</option>
                        <option value="l">L - Large</option>
                        <option value="xl">XL - Extra Large</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="price">Uniform Price *</label>
            <input type="number" class="form-control" id="price" name="price" min="0" placeholder="Please enter the price * " required>
        </div>
        <div class="form-group">
            <label for="form_message">Message</label>
            <textarea id="form_message" name="message" class="form-control" placeholder="Write your message here." rows="4"></textarea>
        </div>
        <div class="col-md-12 text-center">
            <br>
            <input type="submit" class="btn btn-success btn-send pt-2 btn-block" value="Submit">
        </div>
    </div>
</form>

               </div>
          </div>
      </div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('uniform-request-form').addEventListener('submit', function(event) {
        event.preventDefault(); 

        var formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Uniform request submitted successfully.',
                    showConfirmButton: false,
                    timer: 1500
                });

                this.reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again later.',
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Please try again later.',
            });
        });
    });
});
</script>