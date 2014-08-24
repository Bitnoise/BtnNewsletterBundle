BtnNewsletterBundle
==================================================================
Simple bundle for generate form for newsletter (symfony 2.3) and save to dabase

1. add the following to your `composer.json`:

        "bitnoise/newsletter-bundle": "dev-master"

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
                new Btn\NewsletterBundle\BtnNewsletterBundle(),
                // ...
            );
        }

3. add to routing.yml:

        btn_newsletter:
            resource: "@BtnNewsletterBundle/Controller/"
            type:     annotation
            prefix:   /

4. usage:

        {{ render(controller('BtnNewsletterBundle:Newsletter:create', {'request': app.request})) }}

5. custom config:

        btn_newsletter:
            template:        "BtnAppBundle::_newsletter.html.twig"

6. custom template:

        <form method="POST" action="">
            {{ form_errors(form) }}
            <div class="mail-text">
                {{ form_errors(form.email) }}
                {{ form_widget(form.email, {'attr': {'placeholder': 'enter your email address'}}) }}
            </div>
            <div class="mail-submit">
                {{ form_widget(form.submit, {'attr': {'class': 'btn violet'}}) }}
            </div>
            {{ form_row(form._token) }}
        </form>
