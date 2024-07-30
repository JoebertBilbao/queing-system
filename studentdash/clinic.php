<?php include 'index.php'; ?>
<style>
    body {
        background-color: #f8f9fa; /* Light gray background */
    }
</style>
<div class="container">
    <div class="text-center mt-5">
        <h1>Clinic Office</h1>
    </div>
    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                    <div class="container">
                    <form id="clinic-form" role="form" method="post" action="../action/clinic_process.php">
                            <div class="controls">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_fullname">Full Name *</label>
                                            <input id="form_fullname" type="text" name="fullname" class="form-control" placeholder="Please enter your full name *" required="required" data-error="Full name is required.">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_dob">Date of Birth *</label>
                                            <input id="form_dob" type="date" name="dob" class="form-control" required="required" data-error="Date of birth is required.">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_contact">Contact Number *</label>
                                            <input id="form_contact" type="text" name="contact" class="form-control" placeholder="Please enter your contact number *" required="required" data-error="Contact number is required.">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="form_email">Email Address *</label>
                                            <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_address">Permanent Address *</label>
                                            <input id="form_address" type="text" name="address" class="form-control" placeholder="Please enter your permanent address *" required="required" data-error="Permanent address is required.">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_medical_history">Medical History *</label>
                                            <textarea id="form_medical_history" name="medical_history" class="form-control" placeholder="Please enter your medical history *" rows="4" required="required" data-error="Medical history is required."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_medications">Current Medications *</label>
                                            <textarea id="form_medications" name="medications" class="form-control" placeholder="Please enter your current medications *" rows="2" required="required" data-error="Current medications are required."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_allergies">Allergies *</label>
                                            <textarea id="form_allergies" name="allergies" class="form-control" placeholder="Please enter your allergies *" rows="2" required="required" data-error="Allergies are required."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_symptoms">Current Symptoms/Concerns *</label>
                                            <textarea id="form_symptoms" name="symptoms" class="form-control" placeholder="Please enter your current symptoms/concerns *" rows="4" required="required" data-error="Current symptoms/concerns are required."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="form_appointment_date">Preferred Appointment Date *</label>
                                            <input id="form_appointment_date" type="date" name="appointment_date" class="form-control" required="required" data-error="Preferred appointment date is required.">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <br>
                                        <input type="submit" class="btn btn-success btn-send pt-2 btn-block" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.8 -->
        </div>
        <!-- /.row-->
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('clinic-form').addEventListener('submit', function(event) {
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
