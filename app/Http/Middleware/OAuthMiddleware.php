<?php
namespace App\Http\Middleware;

use Closure;
use League\OAuth2\Server\Exception\InvalidScopeException;
use LucaDegasperi\OAuth2Server\Authorizer;

/**
 * @author pschmidt
 */
class OAuthMiddleware
{
    /**
     * The authorizer instance
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Whether or not to check the http headers only for an access token
     * @var bool
     */
    protected $httpHeadersOnly = false;

    /**
     * The scopes to check for
     * @var array
     */
    protected $scopes = [];

    /**
     * @param Authorizer $authorizer
     * @param bool $httpHeadersOnly
     */
    public function __construct(Authorizer $authorizer, $httpHeadersOnly = false)
    {
        $this->authorizer = $authorizer;
        $this->httpHeadersOnly = $httpHeadersOnly;
    }

    /**
     * Whether or not the filter will check only the http headers for an access token
     * @return bool
     */
    public function isHttpHeadersOnly()
    {
        return $this->httpHeadersOnly;
    }

    /**
     * Whether or not the filter should check only the http headers for an access token
     * @param $httpHeadersOnly
     */
    public function setHttpHeadersOnly($httpHeadersOnly)
    {
        $this->httpHeadersOnly = $httpHeadersOnly;
    }

    /**
     * Set the scopes to which the filter should check for
     * @param array $scopes
     */
    public function setScopes(array $scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * The scopes to which the filter should check for
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Validate the scopes
     * @throws \League\OAuth2\Server\Exception\InvalidScopeException
     */
    public function validateScopes()
    {
        if (!empty($this->scopes) and !$this->authorizer->hasScope($this->scopes)) {
            throw new InvalidScopeException(implode(',', $this->scopes));
        }
    }

    /**
     * @param $request
     * @param Closure $next
     * @param $scopes
     * @throws InvalidScopeException
     */
    public function handle($request, Closure $next, $scopes = [])
    {
        if (is_array($scopes)) {
            $this->scopes = $scopes;
        }

        $this->scopes[] = $scopes;

        try {
            $this->authorizer->validateAccessToken($this->httpHeadersOnly);
            $this->validateScopes();
        } catch (InvalidScopeException $e) {
            // TODO return request? or maybe just wait for update of the package
        } finally {
            $next($request);
        }
    }
}