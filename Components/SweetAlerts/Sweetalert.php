<?php
$ShowAlert = false;
// if thier is a error or other user reminder to show
if (isset($ShowAlert) && $ShowAlert) { ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.mixin({
                    toast: true,
                    position: "top-start",
                    showConfirmButton: false,
                    timer: 10000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                })
                .fire({
                    icon: 'info',
                    title: 'You can use the <b>tab</b> key to navigate through the size guide',
                })
                .then((result) => {});
        });
    </script>
<?php
// prevent the alert from showing again
unset($ShowAlert);
} ?>