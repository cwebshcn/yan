/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
    //添加字体
    config.font_names = ' 宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;' + config.font_names;
    // 界面语言，默认为 'en' 
    config.language = 'zh-cn';
    // 设置宽高 
    config.width = 900;
    config.height = 400;
    //设置工具箱
    config.toolbar_Full = [
['Source', '-', 'Save', 'NewPage', 'Preview', '-', 'Templates'],
['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Print', 'SpellChecker', 'Scayt'],
['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
'/',
['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
['Link', 'Unlink', 'Anchor'],
['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'],
'/',
['Styles', 'Format', 'Font', 'FontSize'],
['TextColor', 'BGColor', '-', 'About']
    ];


    //以下是ckfinder的设置
    config.filebrowserBrowseUrl = '../editor/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '../editor/ckfinder/ckfinder.html?type=Images';
    config.filebrowserFlashBrowseUrl = '../editor/ckfinder/ckfinder.html?type=Flash';
    config.filebrowserUploadUrl = '../editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=File';
    config.filebrowserImageUploadUrl = '../editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '../editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';

};
