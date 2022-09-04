@if(session('swal-success'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                title: 'Operation Done Successfully',
                 text: '{{ session('swal-success') }}',
                 icon: 'success',
                 confirmButtonText: 'OK',
      });
        });
    </script>

@endif
