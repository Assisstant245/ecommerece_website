

        @extends('layout.user_app')
@section('content')        
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('/product_list')}}">Products</a></li>
                    <li class="breadcrumb-item active">Contact</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->
        
        <!-- Contact Start -->
        <div class="contact">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="contact-info">
                            <h2>Our Office</h2>
                            <h3><i class="fa fa-map-marker"></i>123 Office, Los Angeles, CA, USA</h3>
                            <h3><i class="fa fa-envelope"></i>office@example.com</h3>
                            <h3><i class="fa fa-phone"></i>+123-456-7890</h3>
                            <div class="social">
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-linkedin-in"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                                <a href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-info">
                            <h2>Our Store</h2>
                            <h3><i class="fa fa-map-marker"></i>123 Store, Los Angeles, CA, USA</h3>
                            <h3><i class="fa fa-envelope"></i>store@example.com</h3>
                            <h3><i class="fa fa-phone"></i>+123-456-7890</h3>
                            <div class="social">
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                                <a href=""><i class="fab fa-linkedin-in"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                                <a href=""><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contact-form">
                            <form id="contactform">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Your Name" />
                                        <span class="text-danger" id="user_name_error"></span>

                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Your Email" />
                                        <span class="text-danger" id="user_email_error"></span>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="user_subject" name="user_subject" class="form-control" placeholder="Subject" />
                                    <span class="text-danger" id="user_subject_error"></span>

                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" id="user_message" name="user_message" rows="5" placeholder="Message"></textarea>
                                </div>
                                <div><button class="btn" type="submit">Send Message</button></div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="contact-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3305.733248043701!2d-118.24532098539802!3d34.05071312525937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c648fa1d4803%3A0xdec27bf11f9fd336!2s123%20S%20Los%20Angeles%20St%2C%20Los%20Angeles%2C%20CA%2090012%2C%20USA!5e0!3m2!1sen!2sbd!4v1585634930544!5m2!1sen!2sbd" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->
        <script>

            $(document).ready(function(){
              $("#user_name").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#user_name_error").text("");
                } else if (!check_name.test(original)) {
                    $("#user_name_error").text("First Name should have only letters (A-Z or a-z).");
                } else {
                    $("#user_name_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });
            
            $("#user_email").keyup(function() {
                var user_email = $("#user_email").val();
                user_email = user_email.replace(/[^a-zA-Z0-9@._%+\-]/g, "");
                $("#user_email").val(user_email);

                var check_email = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;

                if (user_email === "") {
                    $("#user_email_error").text("");
                } else if (!check_email.test(user_email)) {
                    $("#user_email_error").text("Email should include valid characters and '@gmail.com'.");
                } else {
                    $("#user_email_error").text("");
                }
            });
             $("#user_subject").on("keyup", function() {
                var original = $(this).val();

                var check_name = /^[A-Za-z ]+$/;

                if (original.trim() === "") {
                    $("#user_subject_error").text("");
                } else if (!check_name.test(original)) {
                    $("#user_subject_error").text("subject Name should have only letters");
                } else {
                    $("#user_subject_error").text("");
                }

                // Clean the input for display
                var cleaned = original.replace(/[^A-Za-z ]/g, "");
                $(this).val(cleaned);
            });
            
            })
           


            $('#contactform').submit(function(e) {
                e.preventDefault();
                $(".text-danger").text(""); // clear previous errors

                let valid = true;

                // Get values
                let user_name = $('#user_name').val().trim();
                let user_subject = $('#user_subject').val().trim();

                let user_email = $('#user_email').val().trim();
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


                // Validation
                if (user_name === "") {
                    $('#user_name_error').text("name is required.");
                    valid = false;
                }
                if (user_subject === "") {
                    $('#user_subject_error').text("name is required.");
                    valid = false;
                }


                if (user_email === "") {
                    $('#user_email_error').text("Email is required.");
                    valid = false;
                } else if (!emailRegex.test(user_email)) {
                    $('#user_email_error').text("Enter a valid email.");
                    valid = false;
                }

                
                // if (!valid) return;

                // Proceed to submit if valid
                let data = new FormData(this);

                $.ajax({
                    url: "{{ route('user.contact') }}",
                    method: "POST",
                    data: data,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'message successfully done!',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        $('#contactform')[0].reset();
                        setTimeout(() => {
                            window.location.href = "/login";
                        }, 3000);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            $('.text-danger').text('');
                            $.each(errors, function(field, messages) {
                                $(`#${field}_error`).text(messages[0]);
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'Close'
                            });
                            console.error(xhr.responseText);
                        }
                    }
                });
            });

            </script>
        
 @endsection