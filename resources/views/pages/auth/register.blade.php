<x-auth-layout title="Register">
    <!-- login page start-->
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
                            <form class="theme-form" id="form_login">
                                <h4>Create your account</h4>
                                <div class="form-group">
                                    <label class="col-form-label form-label-title ">Username</label>
                                    <input autocomplete="name" class="form-control" type="text" name="fullname" required=""
                                        placeholder="Masukkan Username Anda">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label form-label-title ">Email Address</label>
                                    <input autocomplete="email" class="form-control" type="email" name="email" required=""
                                        placeholder="Masukkan Email Anda">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label form-label-title ">Password</label>
                                    <input autocomplete="new-password" class="form-control" type="password" name="password" required=""
                                        placeholder="Masukkan Password Anda">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label form-label-title ">Ulangi Password</label>
                                    <div class="form-input position-relative">
                                        <input autocomplete="new-password" class="form-control" type="password" name="password_confirmation"
                                            required="" placeholder="*********">
                                        {{-- <div class="show-hide"><span class="show"></span></div> --}}
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    {{-- <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox">
                                        <label class="text-muted" for="checkbox1">Agree with<a class="ms-2"
                                                href="#">Privacy Policy</a></label>
                                    </div> --}}
                                    <button type="submit" id="tombol_login"
                                        onclick="handle_post('#tombol_login','#form_login','{{ route('auth.register') }}','POST');"
                                        class="btn btn-primary btn-block w-100">
                                        Sign Up
                                    </button>
                                </div>
                                <div class="form-group mt-2">
                                    <button type="button" id="googleRegisterBtn" class="btn btn-danger btn-block w-100">
                                        <i class="fa fa-google"></i> Daftar / Masuk dengan Google
                                    </button>
                                </div>
                                <p class="mt-4 mb-0">Already have an account?<a class="ms-2"
                                        href="{{ route('auth.index') }}">Sign
                                        in</a></p>
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
        let isGoogleRegisterPopupOpen = false;

        // Google Register/Login Handler
        document.getElementById('googleRegisterBtn').addEventListener('click', function(e) {
            e.preventDefault();
            if (isGoogleRegisterPopupOpen) return;
            isGoogleRegisterPopupOpen = true;
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
                    .then(response => {
                        return response.json().then(json => ({ ok: response.ok, status: response.status, json }));
                    })
                    .then(({ ok, status, json }) => {
                        if (json.status === 'success') {
                            // clear form to avoid autofill artifacts
                            try { document.getElementById('form_login').reset(); } catch(e){}

                            Swal.fire({
                                text: json.message,
                                icon: 'success',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, Mengerti!',
                                customClass: { confirmButton: 'btn btn-primary' }
                            }).then(() => {
                                window.location.href = json.redirect;
                            });
                        } else {
                            Swal.fire({
                                text: json.message || 'Terjadi kesalahan',
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'Ok, Mengerti!',
                                customClass: { confirmButton: 'btn btn-primary' }
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            text: err.message || 'Terjadi kesalahan jaringan',
                            icon: 'error',
                            buttonsStyling: false,
                            confirmButtonText: 'Ok, Mengerti!',
                            customClass: { confirmButton: 'btn btn-primary' }
                        });
                    })
                    .finally(() => {
                        isGoogleRegisterPopupOpen = false;
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
                    isGoogleRegisterPopupOpen = false;
                });
        });
    </script>
</x-auth-layout>
