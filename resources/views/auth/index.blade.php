<!DOCTYPE html>
<html lang="en">

@include('template.head')

<body>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Login</h4>
                                    <p class="mb-0">Enter your email and password!</p>
                                </div>

                                <div class="card-body">
                                    @if (session()->has('error'))
                                    <div class="alert alert-danger alert-dismissible fade show text-start" role="alert"
                                        style="color:white;">
                                        {{ session()->get('error') }}
                                        <button type="button" class="btn-close " data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif
                                    @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show text-start" role="alert"
                                        style="color:white;">
                                        {{ session()->get('success') }}
                                        <button type="button" class="btn-close " data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif
                                    <form role="form" action="{{ route('auth.login') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="email" class="form-control form-control-lg" placeholder="Email"
                                                aria-label="Email" name="email" id="email">
                                        </div>

                                        <div class="mb-3">
                                            <input type="password" class="form-control form-control-lg"
                                                placeholder="Password" aria-label="Password" name="password"
                                                id="password">
                                        </div>

                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-3 mb-0">Masuk</button>
                                        </div>

                                        <div class="text-center mt-3">
                                            <a href="{{ route('auth.forget') }}">Forget Password?</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://www.getillustrations.com/packs/plastic-illustrations-scene-builder-pack/scenes/_1x/accounts%20_%20man,%20workspace,%20desk,%20laptop,%20login,%20user_md.png');
          background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-1"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('template.script')
</body>

</html>
