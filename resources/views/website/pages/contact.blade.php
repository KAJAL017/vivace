@extends('website.main.app')
@section('title','Contact')
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Contact</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home /</a></li>
                            <li class=" active"> <a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="contact-main">
                <div class="row gy-3">
                    <div class="col-12">
                        <div class="title-1 address-content">
                            <p class="pb-0">Let's Get In Touch<span></span></p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="address-items">
                            <div class="icon-box"> <i class="iconsax" data-icon="location"></i></div>
                            <div class="contact-box">
                                <h6>Contact Number</h6>
                                <p>+91 78895 38626</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="address-items">
                            <div class="icon-box"> <i class="iconsax" data-icon="phone-calling"></i></div>
                            <div class="contact-box">
                                <h6>Email Address</h6>
                                <p>contact@vivacecollections.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="address-items">
                            <div class="icon-box"> <i class="iconsax" data-icon="mail"></i></div>
                            <div class="contact-box">
                                <h6>Office Address</h6>
                                <p>Chotta Bazaar Near Sheikhul Alam Hospital Karanagar, Srinagar, Jammu and Kashmir 190010</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="address-items">
                            <div class="icon-box"> <i class="iconsax" data-icon="map-1"></i></div>
                            <div class="contact-box">
                                <h6>Office Address</h6>
                                <p>Chotta Bazaar Near Sheikhul Alam Hospital Karanagar, Srinagar, Jammu and Kashmir 190010</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="contact-main">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 order-lg-1 order-2">
                        <div class="contact-box">
                            <h4>Contact Us </h4>
                            <p>If you've got fantastic products or want to collaborate, reach out to us. </p>
                            <div class="contact-form">
                                <div class="row gy-4">
                                    <div class="col-12">
                                        <label class="form-label" for="inputFullName">Full Name</label>
                                        <input class="form-control" id="inputFullName" type="text" name="name" placeholder="Enter Full Name">
                                        <span class="validation-error" id="nameError" style="color:red;"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="inputEmail">Email Address</label>
                                        <input class="form-control" id="inputEmail" type="email" name="email" placeholder="Enter Email Address">
                                        <span class="validation-error" id="emailError" style="color:red;"></span>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" for="inputPhone">Phone Number</label>
                                        <input class="form-control" id="inputPhone" type="number" name="phone" placeholder="Enter Phone Number">
                                        <span class="validation-error" id="phoneError" style="color:red;"></span>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label" for="inputSubject">Subject</label>
                                        <input class="form-control" id="inputSubject" type="text" name="subject" placeholder="Enter Subject">
                                        <span class="validation-error" id="subjectError" style="color:red;"></span>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" id="message" name="message" rows="6" placeholder="Enter Your Message"></textarea>
                                        <span class="validation-error" id="messageError" style="color:red;"></span>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn_black rounded sm" type="submit" id="submitForm">Send Message</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('website.js')
<script>
    $(document).on('click', '#submitForm', function(e) {
        e.preventDefault();
        let formData = {
            name: $('#inputFullName').val(),
            email: $('#inputEmail').val(),
            phone: $('#inputPhone').val(),
            subject: $('#inputSubject').val(),
            message: $('#message').val(),
        };
        $('.validation-error').text('');

        $.ajax({
            url: "{{ route('contact.store') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Show success message with Toastr
                    toastr.success(response.message);

                    // Reset the form fields
                    $('#inputFullName, #inputEmail, #inputPhone, #inputSubject, #message').val('');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    for (const [key, value] of Object.entries(errors)) {
                        $(`#${key}Error`).text(value[0]);
                        $(`[name="${key}"]`).addClass('is-invalid');
                    }
                }
            }
        });
    });
</script>


@endsection
