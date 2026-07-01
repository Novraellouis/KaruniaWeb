<x-auth-layout title="Forgot Password">
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div><a class="logo"><img class="img-fluid for-light"
                                    src="{{ asset('assets/images/ks/logobg.png') }}" alt="looginpage" width="150"><img
                                    class="img-fluid for-dark" src="{{ asset('assets/images/ks/logobg.png') }}"
                                    alt="looginpage" width="150"></a></div>
                        <div class="login-main">
                            <form class="theme-form" id="form_forgot_password" action="{{ route('auth.forgot') }}"
                                method="POST">
                                @csrf
                                <h4>Forgot Your Password?</h4>
                                <div class="form-group">
                                    <label class="col-form-label form-label-title ">Email Address</label>
                                    <input class="form-control" type="email" name="email" required=""
                                        placeholder="Enter your email address">
                                </div>
                                <div class="form-group mb-0">
                                    <button type="submit" id="tombol_forgot_password"
                                        class="btn btn-primary btn-block w-100">
                                        Cek Email
                                    </button>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="button" id="googleForgotBtn" class="btn btn-danger btn-block w-100">
                                        <i class="fa fa-google"></i> Reset Password dengan Google
                                    </button>
                                </div>
                                <p class="mt-4 mb-0">Remembered your password?<a class="ms-2"
                                        href="{{ route('auth.index') }}">Sign
                                        in</a></p>
                            </form>

                            <div id="reset-password-section" style="display: none;">
                                <form class="theme-form" id="form_reset_password">
                                    <h4>Reset Password</h4>
                                    <div class="form-group">
                                        <label class="col-form-label form-label-title">Email Address</label>
                                        <input class="form-control" type="email" name="email" required
                                            placeholder="Enter your email address">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label form-label-title">New Password</label>
                                        <input class="form-control" type="password" name="password" required
                                            placeholder="Enter your new password">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label form-label-title">Confirm Password</label>
                                        <input class="form-control" type="password" name="password_confirmation"
                                            required placeholder="Confirm your new password">
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" id="tombol_reset_password"
                                            onclick="handle_post('#tombol_reset_password','#form_reset_password','{{ route('auth.reset_password') }}','POST');"
                                            class="btn btn-primary btn-block w-100">Reset Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.8.0/firebase-auth-compat.js"></script>
    <script>
        // Initialize Firebase
        const firebaseConfig = {
            apiKey: "{{ config('firebase.api_key') }}",
            authDomain: "{{ config('firebase.auth_domain') }}",
            projectId: "{{ config('firebase.project_id') }}",
            storageBucket: "{{ config('firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('firebase.messaging_sender_id') }}",
            appId: "{{ config('firebase.app_id') }}"
        };

        firebase.initializeApp(firebaseConfig);
        const auth = firebase.auth();
        let isGoogleForgotPopupOpen = false;

        // Google Forgot Password Handler
        document.getElementById('googleForgotBtn').addEventListener('click', function(e) {
            e.preventDefault();
            if (isGoogleForgotPopupOpen) return;
            isGoogleForgotPopupOpen = true;
            const provider = new firebase.auth.GoogleAuthProvider();
            provider.setCustomParameters({
                'prompt': 'select_account'
            });

            auth.signInWithPopup(provider)
                .then(function(result) {
                    const user = result.user;
                    // Send password reset email
                    auth.sendPasswordResetEmail(user.email)
                        .then(() => {
                            Swal.fire({
                                text: 'Email reset password telah dikirim ke ' + user.email,
                                icon: 'success',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, Mengerti!',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            }).then(() => {
                                window.location.href = "{{ route('auth.index') }}";
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                text: error.message,
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, Mengerti!',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            });
                        });
                })
                .catch(error => {
                    Swal.fire({
                        text: error.message,
                        icon: 'error',
                        buttonsStyling: false,
                        confirmButtonText: 'Ok, Mengerti!',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        }
                    });
                })
                .finally(() => {
                    isGoogleForgotPopupOpen = false;
                });
        });

        $(document).ready(function() {
            $('#form_forgot_password').submit(function(event) {
                event.preventDefault();
                var form = $(this);
                var email = form.find('input[name="email"]').val();

                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: {
                        _token: form.find('input[name="_token"]').val(),
                        email: email
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Menampilkan bagian reset password dan menyembunyikan form cek email
                            $('#reset-password-section').show();
                            form.hide();
                        } else {
                            alert(
                                'Email not found.'); // Menampilkan pesan email tidak ditemukan
                        }
                    },
                    error: function(xhr) {
                        alert(
                            'An error occurred. Please try again.'
                        ); // Menampilkan pesan kesalahan
                    }
                });
            });
        });
    </script>
</x-auth-layout>
