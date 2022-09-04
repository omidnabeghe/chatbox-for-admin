@if(session('swal-error'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                title: 'ERROR!!',
                 text: '{{ session('swal-error') }}',
                 icon: 'error',
                 confirmButtonText: 'OK',
      });
        });
    </script>

@endif
