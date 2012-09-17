/**
 *
 * Created with IntelliJ IDEA.
 * User: stonedz
 * Date: 9/17/12
 * Time: 11:54 PM
 * To change this template use File | Settings | File Templates.
 */

(function() {
    tinymce.create('tinymce.plugins.simpleML', {
        init : function(ed, url) {
            ed.addButton('simpleML', {
                title : 'Lng',
                image : url+'/image.png',
                onclick : function() {
                    var lang = prompt("Choose language", "");
                    ed.selection.setContent('[simpleML lang="'+lang+'"]' + ed.selection.getContent() + '[/simpleML]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        }
    });
    tinymce.PluginManager.add('simpleML', tinymce.plugins.simpleML);
})();