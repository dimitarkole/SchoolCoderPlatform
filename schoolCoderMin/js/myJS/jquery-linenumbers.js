(function($){
    $.fn.linenumbers = function(in_opts){
        // Settings and Defaults
        var opt = $.extend({
            col_width: '10px',
            start: 1,
            digits: 1.
        },in_opts);

        // Remove existing div and the textarea from previous run
        $("[data-name='linenumbers']").remove();
        // Function run
        return this.each(function(){
            // Get some numbers sorted out for the CSS changes
            var textarea_width = $(this).prop("offsetWidth")+100;

            var textarea_height = $(this).prop("offsetHeight");
            var new_textarea_width = parseInt(textarea_width)-parseInt(opt.col_width);
            // Create the new textarea and style it
            $(this).before('<textarea data-name="linenumbers" style="width:'+new_textarea_width+'px;height:'+textarea_height+'px;float:left;margin-right:'+'-'+new_textarea_width+'px;white-space:pre;overflow:hidden;" disabled="disabled"></textarea>');
            // Edit the existing textarea's styles
            $(this).css({'width':new_textarea_width+'px','height':textarea_height+'px','float':'right'});

            // Define a simple variable for the line-numbers box
            var lnbox = $(this).parent().find('textarea[disabled="disabled"]');
            // Bind some actions to all sorts of events that may change it's contents
            $(this).bind('blur focus change keyup keydown',function(){

                // Break apart and regex the lines, everything to spaces sans linebreaks

               var text= $(this).val();
                var textWithOutNewLine= text.split("\n");
                var count=1;
                var result="";
                for (var i = 0; i < textWithOutNewLine.length; i++) {
                  result+=count+"\n";
                  count++;
                  var string=textWithOutNewLine[i];
                  var letterAtRow=string.length/80;
                  for (var j = 1; j < letterAtRow; j++) {
                    result+=count+"\n";
                    count++;
                  }
                }

                $(lnbox).val(result);
                // Change scroll position as they type, makes sure they stay in sync
                $(lnbox).scrollTop($(this).scrollTop());
            });
            // Lock scrolling together, for mouse-wheel scrolling
            $(this).scroll(function(){
                $(lnbox).scrollTop($(this).scrollTop());
            });
            // Fire it off once to get things started
            $(this).trigger('keyup');
        });
    };
})(jQuery);
$('textarea').linenumbers();
