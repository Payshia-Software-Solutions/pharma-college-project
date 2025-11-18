<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src="assets/js/functions.js"></script>
<script src="assets/js/result-1.0.js"></script>
<script src="assets/js/contact.js"></script>
<script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<!-- <script src='assets/vendors/switcher/switcher.js'></script> 
    -->
<!-- Revolution JavaScripts Files -->
<script src="assets/vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="assets/vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
<!-- Slider revolution 5.0 Extensions  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script src="assets/vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="assets/vendors/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="assets/vendors/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="assets/vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="assets/vendors/revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="assets/vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="assets/vendors/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="assets/vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="assets/vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
<script>
    jQuery(document).ready(function() {
        var ttrevapi;
        var tpj = jQuery;
        if (tpj("#rev_slider_486_1").revolution == undefined) {
            revslider_showDoubleJqueryError("#rev_slider_486_1");
        } else {
            ttrevapi = tpj("#rev_slider_486_1").show().revolution({
                sliderType: "standard",
                jsFileLocation: "assets/vendors/revolution/js/",
                sliderLayout: "fullwidth",
                dottedOverlay: "none",
                delay: 9000,
                navigation: {
                    keyboardNavigation: "on",
                    keyboard_direction: "horizontal",
                    mouseScrollNavigation: "off",
                    mouseScrollReverse: "default",
                    onHoverStop: "on",
                    touch: {
                        touchenabled: "on",
                        swipe_threshold: 75,
                        swipe_min_touches: 1,
                        swipe_direction: "horizontal",
                        drag_block_vertical: false
                    },
                    arrows: {
                        style: "uranus",
                        enable: true,
                        hide_onmobile: false,
                        hide_onleave: false,
                        tmp: '',
                        left: {
                            h_align: "left",
                            v_align: "center",
                            h_offset: 10,
                            v_offset: 0
                        },
                        right: {
                            h_align: "right",
                            v_align: "center",
                            h_offset: 10,
                            v_offset: 0
                        }
                    },

                },
                viewPort: {
                    enable: true,
                    outof: "pause",
                    visible_area: "80%",
                    presize: false
                },
                responsiveLevels: [1240, 1024, 778, 480],
                visibilityLevels: [1240, 1024, 778, 480],
                gridwidth: [1240, 1024, 778, 480],
                gridheight: [768, 600, 600, 600],
                lazyType: "none",
                parallax: {
                    type: "scroll",
                    origo: "enterpoint",
                    speed: 400,
                    levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 46, 47, 48, 49, 50, 55],
                    type: "scroll",
                },
                shadow: 0,
                spinner: "off",
                stopLoop: "off",
                stopAfterLoops: -1,
                stopAtSlide: -1,
                shuffle: "off",
                autoHeight: "off",
                hideThumbsOnMobile: "off",
                hideSliderAtLimit: 0,
                hideCaptionAtLimit: 0,
                hideAllCaptionAtLilmit: 0,
                debugMode: false,
                fallbacks: {
                    simplifyAll: "off",
                    nextSlideOnWindowFocus: "off",
                    disableFocusListener: false,
                }
            });
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Smooth scrolling when clicking on links with class "smooth-scroll"
        $('a.smooth-scroll').click(function(event) {
            event.preventDefault(); // Prevent default link behavior


            var navbar = document.querySelector('.nav')
            var links = navbar.querySelectorAll('li')

            links.forEach(function(link) {
                link.addEventListener('click', function() {
                    // Remove active class from all links
                    links.forEach(function(link) {
                        link.classList.remove('active')
                    })
                    // Add active class to the clicked item's parent list item
                    $(this).closest('li').addClass('active');
                })
            })



            var target = $(this).attr('href'); // Get the target element ID from the href attribute
            $('html, body').animate({
                scrollTop: $(target).offset().top - 70 // Scroll to the target element with a top margin of 100 pixels
            }, 1000); // Adjust the animation speed (in milliseconds) as desired
        });
    });
</script>


<script>
    $(document).ready(function() {

        // function adjustSearchHeight() {
        //     var numResults = $('.search-item').length;
        //     var itemHeight = $('.search-item').outerHeight();
        //     var containerHeight = numResults * itemHeight + 12 * (numResults);
        //     $('#search-result').css('height', containerHeight);
        // }

        function adjustBoxHeight() {
            var itemHeight = $('.results-out').outerHeight()
            $('#search-result').css('height', itemHeight)
        }

        // Handle input changes
        $('#search-input').on('input', function() {
            document.getElementById('search-result').style.display = 'block';
            adjustBoxHeight();
            $('#search-result').html("<div class='row text-center'><div class='col-12'>Searching...</div><img class='search-loader' src='./assets/images/loader/search.svg'></div>");
            var query = $(this).val();
            if (query !== '') {
                // Make an AJAX request to get the search suggestions
                $.ajax({
                    url: 'component/search-result.php',
                    method: 'POST',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        // Display the search suggestions
                        $('#search-result').html(response);
                        adjustBoxHeight();
                    }
                });
            } else {
                // Clear the search suggestions
                document.getElementById('search-result').style.display = 'none';
            }
        });
    });
</script>
<script src="//code.tidio.co/ezoyatbvt4md1ouorfzx96jhahry3usk.js" async></script>