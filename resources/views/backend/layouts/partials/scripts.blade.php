<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jodit/4.2.50/es2021/jodit.fat.min.js"
    integrity="sha512-0MCdQHL1SpUBATxw2DY/gm3y54QC1VIYMCnB7IHQ3La1htIkid4yZYsW15QU9+IOuWfEjEVyirL4KBTkHjZP7w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('backend/js/scripts.js') }}"></script>
<script>
    if ('{{ session()->has('message') }}') {
        Swal.fire({
            position: "top-end",
            icon: "{{ session()->get('class') }}",
            toast: true,
            title: "{{ session()->get('message') }}",
            showConfirmButton: false,
            timer: 3000
        });
    }
</script>

<script>
    $('.delete-btn').on('click', function(e) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest('form').submit();
            }
        });
    })
</script>
@stack('scripts')
