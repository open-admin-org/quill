<?php

namespace OpenAdmin\Admin\Quill;

use OpenAdmin\Admin\Form\Field\Textarea;

class QuillField extends Textarea
{
    protected $view = 'open-admin-quill::quill-editor';

    public $minHeight = '200px';
    public $maxHeight = '600px';

    public $config = [
        'theme' => 'snow',
    ];

    public $toolbar = [
            [['header' => [1, 2, 3, 4, 5, 6, false]]],
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],
            [['align' => []]],
            ['link', 'image', 'video'],
            [['list' => 'ordered'], ['list' => 'bullet']],
            ['clean'],                                         // remove formatting button

            // addional options
            //[['font' => []]],
            //[['color' => []], ['background' => []]],          // dropdown with defaults from theme
            //[['script' => 'sub'], ['script' => 'super']],      // superscript/subscript
            //[['size' => ['small', false, 'large', 'huge']]],  // custom dropdown
            //[['indent' => '-1'], ['indent' => '+1']],          // outdent/indent
            //[['direction' => 'rtl']],                         // text direction
            //['list' => 'check'],
            //['formula']
            //[['header' => 1], ['header' => 2]],               // custom button values
        ];

    public function toolbar($toolbar = [])
    {
        $this->toolbar = $toolbar;

        return $this;
    }

    public function maxHeight(string $maxHeight)
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    public function minHeight(string $minHeight)
    {
        $this->minHeight = $minHeight;

        return $this;
    }

    public function render()
    {
        $config_arr = [
            ...$this->config,
            ...$this->options,
            'toolbar' => $this->toolbar,
        ];
        if (!isset($config_arr['modules'])) {
            $config_arr['modules'] = [];
        }
        $config_arr['modules']['toolbar'] = $this->toolbar;

        $config = json_encode($config_arr);

        $instance         = $this->getVariableName().'_quill';
        $instance_wrap    = $this->getVariableName().'_quill_wrap';
        $quill_element_id = $this->id.'_quill_editor';
        $quill_wrapper_id = $this->id.'_quill_wrapper';

        $this->script = <<<JS

            var {$instance_wrap} = document.getElementById('{$quill_wrapper_id}');
            function {$instance_wrap}_unfocus(e) {
                if (e.target != {$instance_wrap} && e.target.parentNode != {$instance_wrap}) {
                    {$instance_wrap}.classList.remove('focus');
                }
            };

            function {$instance}_showImageUI() {
                window.open('/admin/media/?select=true&close=true&fn=window.opener.{$instance}_insertImage', 'admin_media', 'width=1024,height=700,scrollbars=no');
            }
            function {$instance}_insertImage(url) {

                var range = {$instance}.getSelection();
                {$instance}.insertEmbed(range.index, 'image', url, Quill.sources.USER);
            }
            window.{$instance}_insertImage = {$instance}_insertImage;

            window.addEventListener('mouseup', {$instance_wrap}_unfocus);

            var {$instance} = new Quill('#{$quill_element_id}', {$config});
            {$instance}.on('text-change', function(delta, oldDelta, source) {
                document.getElementById('{$this->id}').value = {$instance}.root.innerHTML;
            });

            const {$instance}_toolbar = {$instance}.getModule('toolbar');
            {$instance}_toolbar.addHandler('image', {$instance}_showImageUI);

            admin.cleanup.add(function () {
                window.removeEventListener('mouseup', {$instance_wrap}_unfocus);
            })
        JS;

        $this->addVariables([
            'minHeight' => $this->minHeight,
            'maxHeight' => $this->maxHeight,
        ]);

        return parent::render();
    }
}
