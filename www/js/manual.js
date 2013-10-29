/**
 * Created by Siada-Apius on 29.10.13.
 */
$(document).ready(function () {
    $(function() {

        /**
         * wysiwyg
         */

        // Add markItUp! to your textarea in one line
        // $('textarea').markItUp( { Settings }, { OptionalExtraSettings } );
        $('.wysiwyg').markItUp(mySettings);
    });

});
