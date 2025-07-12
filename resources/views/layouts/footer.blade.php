<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Iyan Almisbah</span>
        </div>
        <div class="copyright text-center my-auto">
            <span>Copyright © SIFOLAB 2025</span>
        </div>
    </div>
</footer>
        <!-- End of Footer -->
<!-- Bootstrap core JavaScript-->
<script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('sbadmin2/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{ asset('sbadmin2/vendor/datatables/jquery.dataTables.min.js')}}""></script>
<script src="{{ asset('sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js')}}""></script>

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
