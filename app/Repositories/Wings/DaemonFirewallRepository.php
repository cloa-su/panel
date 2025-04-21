<?php

namespace Pterodactyl\Repositories\Wings;

use Webmozart\Assert\Assert;
use Pterodactyl\Models\Server;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\TransferException;
use Pterodactyl\Exceptions\Http\Connection\DaemonConnectionException;

class DaemonFirewallRepository extends DaemonRepository
{
    /**
     * @param array $rules
     * @return ResponseInterface
     * @throws DaemonConnectionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add(array $rules): ResponseInterface
    {
        Assert::isInstanceOf($this->server, Server::class);

        try {
            return $this->getHttpClient()->post(
                sprintf('/api/servers/%s/firewall/add', $this->server->uuid),
                [
                    'json' => [
                        'rules' => $rules,
                    ],
                ]
            );
        } catch (TransferException $exception) {
            throw new DaemonConnectionException($exception);
        }
    }

    /**
     * @param array $rule
     * @return ResponseInterface
     * @throws DaemonConnectionException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function remove(array $rule): ResponseInterface
    {
        Assert::isInstanceOf($this->server, Server::class);

        try {
            return $this->getHttpClient()->post(
                sprintf('/api/servers/%s/firewall/remove', $this->server->uuid),
                [
                    'json' => [
                        'rule' => $rule,
                    ],
                ]
            );
        } catch (TransferException $exception) {
            throw new DaemonConnectionException($exception);
        }
    }
}
