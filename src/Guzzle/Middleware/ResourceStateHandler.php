<?php
namespace ShoppingFeed\Sdk\Guzzle\Middleware;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * This handler handle resource state header
 */
class ResourceStateHandler
{
    const STATE_STABLE      = 'stable';
    const STATE_DEVELOPMENT = 'development';
    const STATE_DEPRECATED  = 'deprecated';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param LoggerInterface|null $logger
     */
    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @param ResponseInterface|null $response
     *
     * @return bool
     */
    public function decide($count, RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;

        if (! $response->getHeaderLine('X-Api-Resource-State')) {
            return false;
        }

        return true;
    }

    /**
     * @param int               $retries
     * @param ResponseInterface $response
     */
    public function logState($retries, ResponseInterface $response)
    {
        $state = $response->getHeader('X-Api-Resource-State');
        if (null !== $this->logger && $state !== self::STATE_STABLE) {
            $this->logger->info(sprintf('Resource %s is in %s state', $this->request->getUri(), $state));
        }
    }
}
