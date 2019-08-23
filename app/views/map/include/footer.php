

<!-- Push -->
<script src="https://js.pusher.com/4.2/pusher.min.js"></script>

<!-- JS Plugins -->
<script src="<?= BASE_STORANGE; ?>plugins/rwdImageMaps/jquery.rwdImageMaps.min.js" charset="utf-8"></script>
<script src="<?= BASE_STORANGE; ?>plugins/toastr.js/toastr.min.js"></script>
<script src="<?= BASE_STORANGE; ?>plugins/mascara/mascara.js"></script>
<script src="<?= BASE_STORANGE; ?>plugins/dropify/js/dropify.js" defer></script><!-- Dropzone JS Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>

<!-- JS Personalizado -->
<script src="<?= BASE_STORANGE; ?>assets/js/custom/global.js"></script>
<script src="<?= BASE_STORANGE; ?>assets/js/funcoes.js"></script>

<script>
    var clicked = false, clickY, clickX;

    $(document).on({
        'mousemove': function(e) {
            clicked && updateScrollPos(e);
        },
        'mousedown': function(e) {
            clicked = true;
            clickY = e.pageY;
            clickX = e.pageX;

            // console.log(e.pageX);
        },
        'mouseup': function() {
            clicked = false;
            $('html').css('cursor', 'auto');
        }
    });

    var updateScrollPos = function(e) {
        $('html').css('cursor', 'grabbing');
        $(window).scrollTop($(window).scrollTop() + (clickY - e.pageY));
        $(window).scrollLeft($(window).scrollLeft() + (clickX - e.pageX));
    }


    $(document).ready(function () {
        $('.dropify').dropify({
            messages: {
                'default': 'Arraste o arquivo ou click aqui',
                'replace': 'Arraste o arquivo ou click aqui',
                'remove':  'Remover',
                'error':   'Ooops, ocorreu um erro.'
            }
        });
    });
</script>
</body>
</html>