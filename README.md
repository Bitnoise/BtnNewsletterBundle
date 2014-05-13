BtnNewsletterBundle
==================================================================
Simple bundle for generate form for newsletter (symfony 2.3) and save to dabase

1. add the following to your `composer.json`:

        "bitnoise/neewsletter-bundle": "dev-master"

    and

        "repositories": [
            {
                "type": "vcs",
                "url":  "https://github.com/Bitnoise/BtnNewsletterBundle.git"
            }
        ],

    and run:

        php composer.phar install
2. Add this bundle to your application's kernel:

        // app/AppKernel.php
        public function registerBundles()
        {
            return array(
                // ...
                new Btn\Newsletter\BtnNewsletterBundle(),
                // ...
            );
        }