<?php
/**
 * Class inserts code for initialize rich text editor WysiBB
 */
class My_View_Helper_FormWysibbEditor extends Zend_View_Helper_FormElement
{

    public function formWysibbEditor($name = null, $value = null, $attribs = null)
    {
        if (!$this->view->jQuery()->isEnabled())
            $this->view->jQuery()->enable();

        $this->view->jQuery()->addJavascriptFile('http://cdn.wysibb.com/js/jquery.wysibb.min.js')
            ->addStylesheet('http://cdn.wysibb.com/css/default/wbbtheme.css');

        $this->view->headScript()->captureStart() ?>
        $(document).ready(function() {
        $("#<?php echo $name . "_wysibb"; ?>").wysibb();
        $("#<?php echo $name . "_wysibb"; ?>").htmlcode($("#<?php echo $name; ?>").val());
        var frm = $("#<?php echo $name; ?>").closest("form");
        $(frm).submit(function(e) {
        var self = this;
        e.preventDefault();
        var text = $("#<?php echo $name . "_wysibb"; ?>").htmlcode();
        $("#<?php echo $name; ?>").val(text);
        self.submit();
        return false;
        });
        })
        <?php $this->view->headScript()->captureEnd();

        $info = $this->_getInfo($name, $value, $attribs);
        extract($info);

        $xhtml = '<textarea style="display: none;" name="' . $this->view->escape($name) . '"'
            . ' id="' . $this->view->escape($id) . '"'
            . $this->_htmlAttribs($attribs) . '>'
            . $this->view->escape($value) . '</textarea>'
            . '<textarea name="' . $this->view->escape($name) . '_wysibb"'
            . ' id="' . $this->view->escape($id) . '_wysibb"'
            . $this->_htmlAttribs($attribs) . '></textarea>';

        return $xhtml;

    }

}

?>