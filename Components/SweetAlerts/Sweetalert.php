<?php
$ShowAlert = true;
// if thier is a error or other user reminder to show
if (isset($ShowAlert) && $ShowAlert) { ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.mixin({
                    toast: true,
                    position: "top-start",
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener("mouseenter", Swal.stopTimer);
                        toast.addEventListener("mouseleave", Swal.resumeTimer);
                    },
                })
                .fire({
                    icon: 'info',
                    title: 'You can press <kbd>UP</kbd> <kbd>UP</kbd> <kbd>DOWN</kbd> <kbd>DOWN</kbd> <kbd>LEFT</kbd> <kbd>RIGHT</kbd> <kbd>LEFT</kbd> <kbd>RIGHT</kbd> <kbd>B</kbd> <kbd>A</kbd> to activate easter egg',
                })
                .then((result) => {});
        });

        // Easter Egg
        var allowedKeys = {
            37: 'left',
            38: 'up',
            39: 'right',
            40: 'down',
            65: 'a',
            66: 'b'
        };

        var konamiCode = ['up', 'up', 'down', 'down', 'left', 'right', 'left', 'right', 'b', 'a'];
        var konamiCodePosition = 0;
        var count_EasterEgg = 0;

        document.addEventListener('keydown', function(e) {
            var key = allowedKeys[e.keyCode];
            var requiredKey = konamiCode[konamiCodePosition];

            if (key == requiredKey) {
                konamiCodePosition++;
                if (konamiCodePosition == konamiCode.length) {
                    count_EasterEgg++;
                    activateCheats();
                    konamiCodePosition = 0;
                }
            } else {
                konamiCodePosition = 0;
            }
        });

        function activateCheats() {
            Swal.fire({
                title: 'Easter Egg Activated',
                icon: 'success',
                html: '<p class="text-center">You have activated the Easter Egg <kbd>' + count_EasterEgg + '</kbd> times</p>',
                confirmButtonText: 'Close',
            });
        }
    </script>
<?php
    // prevent the alert from showing again
    unset($ShowAlert);
} ?>