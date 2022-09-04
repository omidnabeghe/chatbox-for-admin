<script>

    $(document).ready(function () {
        var className = '{{ $className }}'
        var element = $('.' + className);

        element.on('click', function(e){

            e.preventDefault();

            const swalWithBootstrapButtons = Swal.mixin({
                customClass:{
                    confirmButton : 'btn btn-success mx-2',
                    cancelButton : 'btn btn-danger mx-2'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                     title: 'Are You Sure?',
                        text: "You Can Cancel",
                         icon: 'warning',
                         showCancelButton: true,
                        confirmButtonText: 'OK, data Deleted',
                        cancelButtonText: 'NO, request Canceled',
                        reverseButtons: true
                        }).then((result) => {

                            if(result.value == true){
                                $(this).parent().submit();
                            }
                            else if(result.dismiss === Swal.DismissReason.cancel){
                                swalWithBootstrapButtons.fire({
                                         title: 'Cancel',
                                         text: " Your Requet Canceled",
                                        icon: 'error',
                                       confirmButtonText: 'OK.'
                                })
                            }

                        })

        })

    })


</script>
