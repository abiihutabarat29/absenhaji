<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>LOGIN</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card-transparant">
                    <div class="card-body-transparant">
                        <div class="app-brand justify-content-center mb-4">
                            {{-- <a href="{{ route('login') }}" class="app-brand-link gap-2">
                                <img src="{{ asset('assets/img/widget-blank.jpg') }}" class="rounded" width="100%"
                                    height="80px" alt="Logo">
                            </a> --}}
                            Silahkan masukkan akun kamu
                        </div>
                        <form method="POST" action="{{ route('login') }}" class="margin-bottom-0">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email kamu" autofocus value="{{ old('email') }}" />
                                @if ($errors->has('email'))
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @if ($errors->has('password'))
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">MASUK
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <footer class="footer mt-2"
                    style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                    <small class="mb-2">Copyright ©{{ date('Y') }} ABSENSI HAJI. All
                        rights
                        reserved.</small>
                    <small>Versi 1.0.0</small>

                </footer>
            </div>
        </div>
    </div>
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const texts = [
                `Selamat Datang di ${ {!! json_encode($setting->name_app ?? ' - ') !!} } <br> ${ {!! json_encode(ucwords(strtolower($setting->kabupaten_name ?? ' - '))) !!} }`,
                "Silahkan masuk ke akun anda!"
            ];
            const typingTextElement = document.getElementById("typing-text");
            let textIndex = 0;
            let charIndex = 0;

            function type() {
                if (charIndex < texts[textIndex].length) {
                    if (texts[textIndex].charAt(charIndex) === "<") {
                        const endIndex = texts[textIndex].indexOf(">", charIndex);
                        typingTextElement.innerHTML += texts[textIndex].substring(charIndex, endIndex + 1);
                        charIndex = endIndex + 1;
                    } else {
                        typingTextElement.innerHTML += texts[textIndex].charAt(charIndex);
                        charIndex++;
                    }
                    setTimeout(type, 100);
                } else {
                    setTimeout(resetAndType, 10000);
                }
            }

            function resetAndType() {
                typingTextElement.innerHTML = "";
                charIndex = 0;
                textIndex = (textIndex + 1) % texts.length;
                type();
            }

            type();

            setTimeout(() => {
                document.querySelectorAll('.text-danger').forEach((element) => {
                    element.style.display = 'none';
                });
            }, 5000);
        });
    </script>

</body>

</html>
