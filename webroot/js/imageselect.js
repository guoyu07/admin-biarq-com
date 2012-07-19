/*
 * Egg Plugin Pack
 *
 * http://www.liam-galvin.co.uk/
 *
 */

/*

 - EggPreload
 - EggAccordion
 - EggSlideshow
 - EggImageDropdown



 */

/* Info */
var EGG = {
    version:{
        number:0.4
    }
};

/* EggPreload */
(function ($) {

    var methods = {
        init:function (options) { //init runs only to make sure images are loaded before plugin starts

            var $c = $(this);

            $c.addClass('please_wait_preloading');

            $c.data('options', options);

            //if not then wait for everything to preload

            $('img', $c).each(function (i, e) {
                $(e).attr('pre_src', $(e).attr('src'));
                $(e).attr('src', '');
            });

            //check if all (non-errored) images are loaded each time an image loads
            $('img', $c).one('load',function () {

                $(this).attr('preloaded', "1");

                var $parent = $(this);

                while (!$parent.hasClass("please_wait_preloading")) {
                    $parent = $parent.parent();
                }

                var total = $('img', $parent).length;
                var loads = $('img[preloaded=1]', $parent).length;

                if (loads >= total) {
                    $parent.removeAttr('preload_images_loaded');
                    $parent.removeAttr('preload_image_count');
                    $('img', $parent).removeAttr('preloaded');
                    var options = $parent.data('options');
                    $parent.data('options', '');
                    options.complete($parent, options.options);
                }

            }).each(function (i, e) {
                        if (this.complete) {
                            $(e).load();
                        }
                    });

            $('img', $c).each(function (i, e) {
                $(e).attr('src', $(e).attr('pre_src'));
                $(e).removeAttr('pre_src')
            });

        }
    };

    $.fn.EggPreload = function (method, options) {

        var settings = {
            complete:function () {
            },
            options:{}
        };

        method = method == undefined ? 'init' : method;
        if (options) {
            $.extend(settings, options);
        }
        if (typeof method === 'object') {
            $.extend(settings, method);
            method = 'init';
        }

        return this.each(function () {
            if (methods[method]) {
                return methods[method].apply(this, Array(settings));
            } else {
                $.error('Method ' + method + ' does not exist on jQuery Egg plugin.');
            }
        });

    };
})(jQuery);
/* End EggPreload */




/* EggImageDropdown */
(function ($) {

    var methods = {
        init:function (options) {
            if (!/select/i.test(this.tagName)) {
                return false;
            }

            var element = $(this);

            var selectName = element.attr('id');
            if (!selectName) {
                var nid = 'egg_rnd_' + Math.floor(Math.random() * 99999);
                while ($('#' + nid).length > 0) {
                    nid = 'egg_rnd_' + Math.floor(Math.random() * 99999);
                }
                element.attr('id', nid);
                selectNamer = nid;
            }
            var id = 'egg_imagedropdown_' + selectName;

            if ($('#' + id).length > 0) {
                //already exists
                return;
            }

            var iWidth = options.width > options.dropdownWidth ? options.width :
                    options.dropdownWidth;

            var imageSelect = $(document.createElement('div')).attr('id', id).addClass('jqis');

            imageSelect.css('width', iWidth + 'px').css('height', options.height + 'px');

            var header = $(document.createElement('div')).addClass('egg_imagedropdown_header');
            header.css('width', options.width + 'px').css('height', options.height + 'px');
            header.css('text-align', 'center').css('background-color', options.backgroundColor);
            header.css('border', '1px solid ' + options.borderColor);

            var dropdown = $(document.createElement('div')).addClass('egg_imagedropdown_dropdown');

            dropdown.css('width', options.dropdownWidth + 'px');//.css('height',options.dropdownHeight +'px');
            dropdown.css('z-index', options.z).css('background-color',
                    options.backgroundColor).css('border', '1px solid ' + options.borderColor);
            ;
            dropdown.hide();

            var selectedImage = $('option:selected', element).text();

            header.attr('lock', options.lock);
            if (options.lock == 'height') {
                header.append('<img style="height:' + options.height + 'px" />');
            } else {
                header.append('<img style="width:' + (options.width - 75) + 'px" />');
            }

            var $options = $('option', element);

            $options.each(function (i, el) {
                dropdown.append('<img style="width:100%" onclick="var t=jQuery(\'select[id=' +
                        selectName + ']\').val(\'' + $(el).val() +
                        '\').EggImageDropdown(\'close\').EggImageDropdown(\'update\',{src:\'' +
                        $(el).text() + '\'});t.trigger(\'change\');" src="' + $(el).text() + '"/>');
            });

            imageSelect.append(header);
            imageSelect.append(dropdown);

            element.after(imageSelect);
            element.hide();

            header.attr('linkedselect', selectName);
            header.children().attr('linkedselect', selectName);
            header.click(function () {
                $('select[id=' + $(this).attr('linkedselect') + ']').EggImageDropdown('open');
            });
            //header.children().click(function(){$('select[id=' + $(this).attr('linkedselect') + ']').ImageSelect('open');});

            var w = 0;

            $('.egg_imagedropdown_dropdown img').mouseover(function () {
                $(this).css('opacity', 1);
            }).mouseout(function () {
                        $(this).css('opacity', 0.9);
                    }).css('opacity', 0.9).each(function (i, el) {
                        w = w + $(el).width();
                    });

            dropdown.css('max-height', options.dropdownHeight + 'px');

            element.EggImageDropdown('update', {src:selectedImage});

        },

        update:function (options) {

            var element = $(this);

            var selectName = element.attr('id');
            var id = 'egg_imagedropdown_' + selectName;

            if ($('#' + id + ' .egg_imagedropdown_header').length == 1) {

                var ffix = false;

                if ($('#' + id + ' .egg_imagedropdown_header img').attr('src') != options.src) {
                    ffix = true; //run fix for firefox
                }

                $('#' + id + ' .egg_imagedropdown_header img').attr('src',
                        options.src).css('opacity', 0.1);

                if (ffix) {
                    setTimeout(function () {
                        element.EggImageDropdown('update', options);
                    }, 1);
                } else {

                    if ($('#' + id + ' .egg_imagedropdown_header').attr('lock') == 'height') {

                        $('#' + id + ' .egg_imagedropdown_header img').unbind('load');

                        $('#' + id + ' .egg_imagedropdown_header img').one('load',function () {

                            $(this).parent().stop();
                            //$('.jqis_dropdown',$(this).parent().parent()).stop();
                            $(this).parent().parent().stop();
                            $(this).parent().animate({width:$(this).width() + 60});
                            $(this).parent().parent().animate({width:$(this).width() + 60});
                            $('.egg_imagedropdown_dropdown',
                                    $(this).parent().parent()).animate({width:$(this).width() +
                                    50});

                        }).each(function () {
                                    if (this.complete) $(this).load();
                                });
                    } else {
                        $('#' + id + ' .egg_imagedropdown_header img').unbind('load');
                        $('#' + id + ' .egg_imagedropdown_header img').one('load',function () {
                            $(this).parent().parent().stop();
                            $(this).parent().stop();
                            $(this).parent().parent().css('height', ($(this).height() + 2) + 'px');
                            $(this).parent().animate({height:$(this).height() + 2});
                        }).each(function () {
                                    if (this.complete) $(this).load();
                                });

                    }

                    $('#' + id + ' .egg_imagedropdown_header img').animate({opacity:1});

                }

            }

            element.trigger('change');

        },
        open:function () {

            var element = $(this);

            var selectName = element.attr('id');
            var id = 'egg_imagedropdown_' + selectName;

            var w = 0;

            if ($('#' + id).length == 1) {

                if ($('#' + id + ' .egg_imagedropdown_dropdown').is(':visible')) {
                    $('#' + id + ' .egg_imagedropdown_dropdown').stop();
                    $('#' + id + ' .egg_imagedropdown_dropdown').slideUp().hide();
                } else {
                    $('#' + id + ' .egg_imagedropdown_dropdown').stop();
                    var mh = $('#' + id +
                            ' .egg_imagedropdown_dropdown').css('max-height').replace(/px/, '');
                    mh = parseInt(mh);

                    element.data('imageHeightTotal', 0);

                    $('#' + id + ' .egg_imagedropdown_dropdown').show().css('opacity', 1);

                    $('#' + id + ' .egg_imagedropdown_dropdown img').each(function (i, el) {
                        $(el).parent().parent().data('imageHeightTotal',
                                $(el).parent().parent().data('imageHeightTotal') + $(el).height());
                    });

                    var ih = element.data('imageHeightTotal');

                    mh = (ih < mh && ih > 0) ? ih : mh;

                    $('#' + id + ' .egg_imagedropdown_dropdown').height(mh).css('overflow-y',
                            'scroll');
                }

            }
        },
        close:function () {

            var element = $(this);

            var selectName = element.attr('id');
            var id = 'egg_imagedropdown_' + selectName;

            if ($('#' + id).length == 1) {

                $('#' + id + ' .egg_imagedropdown_dropdown').slideUp().hide();

            }
        },
        remove:function () {
            if (!/select/i.test(this.tagName)) {
                return false;
            }

            var element = $(this);

            var selectName = element.attr('id');
            var id = 'egg_imagedropdown_' + selectName;

            if ($('#' + id).length > 0) {
                $('#' + id).remove();
                $('select[id=' + selectName + ']').show();
                return;
            }
        }
    };

    $.fn.EggImageDropdown = function (method, options) {

        if (method == undefined) {
            method = 'init';
        }

        var settings = {
            width:200,
            height:75,
            dropdownHeight:250,
            dropdownWidth:200,
            z:99999,
            backgroundColor:'#ffffff',
            border:true,
            borderColor:'#cccccc',
            lock:'height'
        };

        if (options) {
            $.extend(settings, options);
        }

        if (typeof method === 'object') {
            $.extend(settings, method);
            method = 'init';
        }

        return this.each(function () {
            if (methods[method]) {
                return methods[method].apply(this, Array(settings));
            } else {
                $.error('Method ' + method + ' does not exist on EggPlugin');
            }
        });

    };
})(jQuery);

/* NiceForm */
// resize, validation
// http://james.padolsey.com/javascript/jquery-plugin-autoresize/
// http://www.tripwiremagazine.com/2010/01/75-top-jquery-plugins-to-improve-your-html-forms.html