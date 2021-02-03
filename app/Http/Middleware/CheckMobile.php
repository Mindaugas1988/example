<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Session\Session;
use Jenssegers\Agent\Agent;

use Closure;

class CheckMobile
{

    protected $agent;
    protected $session;
    public function __construct(Agent $agent, Session $session)
    {
        $this->agent = $agent;
        $this->session = $session;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (!$this->session->exists('mobile')) {
          if ($this->agent->isMobile() || $this->agent->isTablet()) {
              $this->session->put('mobile', true);
          } else {
              $this->session->put('mobile', false);
          }
      }
        return $next($request);
    }
}
