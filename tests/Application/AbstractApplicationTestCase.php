<?php

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class AbstractApplicationTestCase extends WebTestCase
{
    protected UrlGeneratorInterface $urlGenerator;
    protected HttpKernelBrowser $client;

    /**
     * @throws \Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $commands = [
            [
                'command' => 'doctrine:database:drop',
                '--no-interaction' => true,
                '--force' => true,
            ],
            [
                'command' => 'doctrine:database:create',
                '--no-interaction' => true,
            ],
            [
                'command' => 'doctrine:migrations:migrate',
                '--no-interaction' => true,
            ],
        ];

        foreach ($commands as $command) {
            $input = new ArrayInput($command);

            // You can use NullOutput() if you don't need the output
            $output = new BufferedOutput();
            $application->run($input, $output);
            echo sprintf(
                '%s %s',
                $command['command'],
                $output->fetch()
            ).PHP_EOL;
        }

        echo PHP_EOL.PHP_EOL;
    }

    public function setUp(): void
    {
        $this->client = static::createClient();
        $container = static::getContainer();

        /** @var UrlGeneratorInterface $urlGenerator */
        $urlGenerator = $container->get(UrlGeneratorInterface::class);
        $this->urlGenerator = $urlGenerator;
    }
}
