<?php include 'index.php'; ?>
<style>
    body {
        background-color: #f8f9fa; /* Light gray background */
    }
</style>
<div class="container">
    <div class="text-center mt-5">
        <h1>SSC Registration</h1>
    </div>

    <div class="row">
        <div class="col-lg-7 mx-auto">
            <div class="card mt-2 mx-auto p-4 bg-light">
                <div class="card-body bg-light">
                    <form id="ssc-form" role="form" action="../action/ssc_process.php">

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
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">Date of Birth *</label>
                                    <input type="date" id="dob" name="dob" class="form-control" placeholder="Please enter your birthdate *" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact-number">Contact Number *</label>
                                    <input type="tel" id="contact-number" name="contact_number" class="form-control" placeholder="Please enter your contact *" required>
                                    <small id="contact-number-error" class="text-danger"></small>
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
                                    <label for="course">Course *</label>
                                    <select id="course" name="course" class="form-control" required>
                                        <option value="">Select a course</option>
                                        <option value="BSIT">BSIT-Bachelor of Science in Information Technology</option>
                                        <option value="BSHM">BSHM-Bachelor of Science in Hospitality Management</option>
                                        <option value="BSBA">BSBA-Bachelor of Science in Business Administration</option>
                                        <option value="BSED">BSED-Bachelor of Secondary Education</option>
                                        <option value="BEED">BEED-Bachelor of Elementary Education</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="counseling-issue">Counseling Issue *</label>
                                    <select id="counseling-issue" name="counseling_issue" class="form-control" required>
                                        <option value="">Select an issue</option>
                                        <option value="academic">Academic</option>
                                        <option value="personal">Personal</option>
                                        <option value="career">Career</option>
                                        <option value="mental-health">Mental Health</option>
                                        <option value="lovelife">Lovelife</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="details">Details of the Issue *</label>
                                    <textarea id="details" name="details" class="form-control" rows="5" placeholder="What is your issue *" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="preferred-counselor">Preferred Counselor</label>
                                    <input type="text" id="preferred-counselor" name="preferred_counselor" class="form-control" placeholder="Leave it blank if none">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="appointment-date">Preferred Appointment Date *</label>
                                    <input type="date" id="appointment-date" name="appointment_date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="form_message">Message *</label>
                            <textarea id="form_message" name="message" class="form-control" placeholder="Write your message here." rows="4" required="required" data-error="Please, leave us a message."></textarea>
                        </div>

                        <div class="form-group text-center">
                            <br><input type="submit" class="btn btn-success btn-send btn-block" value="Submit">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('ssc-form').addEventListener('submit', function (event) {
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
