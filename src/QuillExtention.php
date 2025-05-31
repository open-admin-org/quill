<?php

namespace OpenAdmin\Admin\Quill;

use OpenAdmin\Admin\Extension;

class QuillExtention extends Extension
{
    public $name = 'quill';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';
}
