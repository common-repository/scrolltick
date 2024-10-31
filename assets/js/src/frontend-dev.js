//@codekit-prepend pause.js
//@codekit-prepend marquee.js

jQuery(document).on('ready',function () {
    jQuery('div.scrolltick').each(function () {
        jQuery(this).marquee();
    })
})