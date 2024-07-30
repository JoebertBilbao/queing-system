<?php include 'index.php'; ?>
<style>
     body {
            background-color: #f8f9fa; /* Light gray background */
        }
</style>
<div class="container">
    <div class="text-center mt-5">
        <h1>Interview Form</h1>
    </div>

    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                <form id="interview-form" method="POST" action="../action/interview.php" role="form">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_name">Full Name *</label>
                                    <input id="form_name" type="text" name="name" class="form-control" placeholder="Enter your full name" required="required" data-error="Full name is required.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_email">Email *</label>
                                    <input id="form_email" type="email" name="email" class="form-control" placeholder="Enter your email" required="required" data-error="Valid email is required.">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_phone">Phone Number *</label>
                                    <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Enter your phone number" required="required" data-error="Phone number is required.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_address">Address *</label>
                                    <input id="form_address" type="text" name="address" class="form-control" placeholder="Enter your address" required="required" data-error="Address is required.">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="form_interest">Field of Interest *</label>
                            <input id="form_interest" type="text" name="interest" class="form-control" placeholder="Enter your field of interest" required="required" data-error="Field of interest is required.">
                        </div>

                        <div class="form-group">
                            <label for="form_experience">Previous Experience (if any)</label>
                            <textarea id="form_experience" name="experience" class="form-control" placeholder="Describe your previous experience, if any." rows="4"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="form_expectations">Expectations from the College *</label>
                            <textarea id="form_expectations" name="expectations" class="form-control" placeholder="Describe your expectations from the college." rows="4" required="required" data-error="Expectations are required."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="form_interviewer">Preferred Interviewer (if any)</label>
                            <input id="form_interviewer" type="text" name="interviewer" class="form-control" placeholder="Enter the name of your preferred interviewer">
                        </div>

                        <div class="form-group">
                            <label for="form_department_head">Select Head of Department *</label>
                            <select id="form_department_head" name="department_head" class="form-control" required="required" data-error="Department head selection is required.">
                                <option value="" disabled selected>Select your option</option>
                                <option value="BSIT - Dino Illustrisimo">BSIT - Dino Illustrisimo</option>
                                <option value="BSED - DR. Priscilla F. Canoy">BSED - DR. Priscilla F. Canoy</option>
                                <option value="BEED - Mr. Reyan Diaz">BEED - Mr. Reyan Diaz</option>
                                <option value="BSBA - Mrs. Mariel D. Castillo">BSBA - Mrs. Mariel D. Castillo</option>
                                <option value="BSHM - Mr. Cristy Forsuelo">BSHM - Mr. Cristy Forsuelo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="form_availability">Preferred Interview Date and Time *</label>
                            <input id="form_availability" type="datetime-local" name="availability" class="form-control" required="required" data-error="Preferred date and time are required.">
                        </div>

                        <div class="form-group">
                            <label for="form_additional">Additional Comments</label>
                            <textarea id="form_additional" name="additional" class="form-control" placeholder="Any additional comments or information." rows="4"></textarea>
                        </div>

                        <div class="form-group text-center">
                            <br>
                            <input type="submit" class="btn btn-success btn-send btn-block" value="Submit ">
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
    document.getElementById('interview-form').addEventListener('submit', function(event) {
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
                    text: 'Interview form submitted successfully.',
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
<?php include 'footer.php'; ?>
