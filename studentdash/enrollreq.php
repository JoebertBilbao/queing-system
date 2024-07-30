<?php include 'index.php'; ?>
<style>
    body {
        background-color: #f8f9fa; /* Light gray background */
    }
</style>
<div class="container">
    <div class="text-center mt-5">
        <h1>Enrollment Requirements</h1>
    </div>

    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                    <form id="contact-form" role="form" action="../action/process_form.php" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_name">Firstname *</label>
                                    <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_lastname">Lastname *</label>
                                    <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_email">Email *</label>
                                    <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email is required.">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">Date of Birth *</label>
                                    <input type="date" id="dob" name="dob" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address *</label>
                                    <input type="text" id="address" name="address" required class="form-control" placeholder="Please enter your address *">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="course">Course *</label>
                                    <select id="course" name="course" required class="form-control">
                                        <option value="">Select a course</option>
                                        <option value="BSIT">Bachelor of Science in Information Technology</option>
                                        <option value="BSHM">Bachelor of Science in Hospitality Management</option>
                                        <option value="BSBA">Bachelor of Science in Business Administration</option>
                                        <option value="BSED">Bachelor of Secondary Education</option>
                                        <option value="BEED">Bachelor of Elementary Education</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="high-school">High School *</label>
                                    <input type="text" id="high-school" name="highschool" required class="form-control" placeholder="High School graduate *">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_message">Message *</label>
                                    <textarea id="form_message" name="message" class="form-control" placeholder="Write your message here." rows="4" required="required" data-error="Please, leave us a message."></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                               <br> <input type="submit" class="btn btn-success btn-send pt-2 btn-block" value="Submit">
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
    document.getElementById('contact-form').addEventListener('submit', function(event) {
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
