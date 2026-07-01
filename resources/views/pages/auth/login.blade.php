<x-auth-layout title="Login">
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div>
                            <a class="logo"><img class="img-fluid for-light"
                                    src="{{ asset('assets/images/ks/logobg.png') }}" alt="looginpage" width="150"><img
                                    class="img-fluid for-dark" src="{{ asset('assets/images/ks/logobg.png') }}"
                                    alt="looginpage" width="150"></a>
                        </div>
                        <div class="login-main">
                            <form class="theme-form" id="form_login">
                                <h4>
                                    <center>KARUNIA SIPOHOLON</center>
                                </h4>
                                <br>
                                {{-- <p>Enter your email & password to login</p> --}}
                                <div class="form-group">
                                    <label class="col-form-label form-label-title ">Email Address</label>
                                    <input class="form-control" type="text" name="email"
                                        placeholder="Masukkan Email Anda">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label form-label-title ">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password"
                                            placeholder="*********">
                                        {{-- <div class="show-hide"><span class="show"> </span></div> --}}
                                    </div>

                                </div>
                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <button type="submit" id="tombol_login"
                                            onclick="handle_post('#tombol_login','#form_login','{{ route('auth.login') }}','POST');"
                                            class="btn btn-primary btn-block w-100">Sign in</button>
                                    </div>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="button" id="googleLoginBtn" class="btn btn-danger btn-block w-100">
                                        <i class="fa fa-google"></i> Masuk dengan Google
                                    </button>
                                </div>
                                <p class="mt-3 mb-0 text-left">
                                    <a href="{{ route('forgot') }}">Forgot Password?</a>
                                </p>
                                <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2"
                                        href="{{ route('register') }}">Create Account</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        let isGoogleLoginPopupOpen = false;

        // Google Login Handler
        document.getElementById('googleLoginBtn').addEventListener('click', function(e) {
            e.preventDefault();
            if (isGoogleLoginPopupOpen) return;
            isGoogleLoginPopupOpen = true;
            const provider = new firebase.auth.GoogleAuthProvider();
            provider.setCustomParameters({
                'prompt': 'select_account'
            });

            auth.signInWithPopup(provider)
                .then(function(result) {
                    const user = result.user;
                    // Send user data to backend
                    fetch("{{ route('auth.firebase') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            email: user.email,
                            name: user.displayName || user.email.split('@')[0],
                            provider_id: user.uid
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                text: data.message,
                                icon: 'success',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, Mengerti!',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            }).then(() => {
                                window.location.href = data.redirect;
                            });
                        } else {
                            Swal.fire({
                                text: data.message,
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, Mengerti!',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            });
                        }
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
                    isGoogleLoginPopupOpen = false;
                });
        });
    </script>
</x-auth-layout>
