<footer id="footer" class="footer">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-8 col-md-6 footer-about">
                    <a href="https://fpik.utu.ac.id/pendidikan/prodi-perikanan/" class="d-flex align-items-center">
                        <span class="sitename">Program Studi Perikanan | Developer</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Fakultas Perikanan dan Ilmu Kelautan</p>
                        <p>Univesitas Teuku Umar</p>
                        <p>Jl. Alue Peunyareng | Meulaboh, Aceh Barat</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>081360178635</span></p>
                        <p><strong>Email:</strong> <span>iyan.misbah@utu.ac.com</span></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 footer-links">
                    <h4 class="mt-2 mb-2">Follow Us</h4>
                        <p>Ayo dukung kami melalui sosial media agar lebih dikenal oleh masyarakat luar</p>
                    <div class="social-links d-flex">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Iyan Almisbah</strong> <span>All Rights Reserved</span></p>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
            {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href="https://themewagon.com">ThemeWagon</a> --}}
        </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('landing/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{ asset('landing/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{ asset('landing/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{ asset('landing/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{ asset('landing/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{ asset('landing/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{ asset('landing/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <!-- Main JS File -->
    <script src="{{ asset('landing/assets/js/main.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('sbadmin2/js/demo/datatables-demo.js')}}""></script>
    {{-- script untuk sweetalrt2 --}}
    <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
        @session('success')
            <script>
                Swal.fire({
                    title: "Selamat Anda Berhasil!",
                    text: "{{ session ('success') }}",
                    icon: "success",
                });
            </script>
        @endsession
        @session('error')
            <script>
                Swal.fire({
                    title: "Maaf Anda Gagal!",
                    text: "{{ session ('error') }}",
                    icon: "error",
                });
            </script>
        @endsession

    <!-- Skrip untuk ikon telunjuk -->

