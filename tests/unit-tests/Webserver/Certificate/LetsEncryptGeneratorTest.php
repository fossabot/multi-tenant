<?php

/*
 * This file is part of the hyn/multi-tenant package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://laravel-tenancy.com
 * @see https://github.com/hyn/multi-tenant
 */

namespace Hyn\Tenancy\Tests\Webserver\Certificate;

use Hyn\Tenancy\Generators\Webserver\Certificate\LetsEncryptGenerator;
use Hyn\Tenancy\Tests\Test;
use Illuminate\Contracts\Foundation\Application;

class LetsEncryptGeneratorTest extends Test
{
    /**
     * @var LetsEncryptGenerator
     */
    protected $generator;

    protected function duringSetUp(Application $app)
    {
        $app['config']->set('webserver.lets-encrypt.directory-url', 'https://acme-staging.api.letsencrypt.org/directory');
        $app['config']->set('webserver.lets-encrypt.agreement-url', 'https://letsencrypt.org/documents/LE-SA-v1.1.1-August-1-2016.pdf');
        $app['config']->set('webserver.lets-encrypt.key-pair.private', __DIR__ . '/../../../../ci-lets-encrypt-private.pem');
        $app['config']->set('webserver.lets-encrypt.key-pair.public', __DIR__ . '/../../../../ci-lets-encrypt-public.pem');

        $this->setUpHostnames();
        $this->setUpWebsites(true, true);

        $this->generator = $app->make(LetsEncryptGenerator::class);
    }

    /**
     * @test
     */
    public function can_create_a_request()
    {
        $this->generator->generate($this->website);
    }
}
