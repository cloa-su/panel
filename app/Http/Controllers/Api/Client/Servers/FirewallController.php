<?php

namespace Pterodactyl\Http\Controllers\Api\Client\Servers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Validation\Rule;
use Pterodactyl\Exceptions\Http\Connection\DaemonConnectionException;
use Pterodactyl\Models\Server;
use Illuminate\Support\Facades\DB;
use Pterodactyl\Exceptions\DisplayException;
use Pterodactyl\Repositories\Wings\DaemonFirewallRepository;
use Pterodactyl\Http\Controllers\Api\Client\ClientApiController;
use Pterodactyl\Http\Requests\Api\Client\Servers\FirewallRequest;
use function GuzzleHttp\Psr7\str;

class FirewallController extends ClientApiController
{
    /**
     * @var DaemonFirewallRepository
     */
    protected $daemonFirewallRepository;

    /**
     * FirewallController constructor.
     * @param DaemonFirewallRepository $daemonFirewallRepository
     */
    public function __construct(DaemonFirewallRepository $daemonFirewallRepository)
    {
        parent::__construct();

        $this->daemonFirewallRepository = $daemonFirewallRepository;
    }

    /**
     * @param FirewallRequest $request
     * @param Server $server
     * @return array
     */
    public function index(FirewallRequest $request, Server $server)
    {
        return [
            'success' => true,
            'data' => [
                'rules' => DB::table('firewall_rules')->where('server_id', '=', $server->id)->orderBy('priority', 'ASC')->get(),
                'allocations' => DB::table('allocations')->where('server_id', '=', $server->id)->get(),
            ],
        ];
    }

    /**
     * @param FirewallRequest $request
     * @param Server $server
     * @return array
     * @throws DisplayException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function add(FirewallRequest $request, Server $server)
    {
        $this->validate($request, [
            'ip' => 'required',
            'allocation' => 'required|integer',
            'type' => ['required', Rule::in(['allow', 'block'])],
            'priority' => 'required|integer|min:1',
        ]);

        $splittedIp = explode("/", trim(strip_tags($request->input('ip', ''))));
        if (!filter_var($splittedIp[0], FILTER_VALIDATE_IP) || (isset($splittedIp[1]) && !ctype_digit($splittedIp[1])) || count($splittedIp) > 2) {
            throw new DisplayException('Invalid ip address.');
        }

        $allocation = DB::table('allocations')->where('server_id', '=', $server->id)->where('id', '=', (int) $request->input('allocation'))->first();
        if (!$allocation) {
            throw new DisplayException('Port not related to the server.');
        }

        $alreadyAdded = DB::table('firewall_rules')
            ->where('server_id', '=', $server->id)
            ->where('ip', '=', trim($request->input('ip')))
            ->where('port', '=', $allocation->port)
            ->first();
        if ($alreadyAdded) {
            throw new DisplayException('You\'ve already added rule to selected port and ip.');
        }

        DB::table('firewall_rules')->insert([
            'server_id' => $server->id,
            'ip' => trim($request->input('ip')),
            'port' => $allocation->port,
            'priority' => (int) $request->input('priority', 1),
            'type' => trim(strip_tags($request->input('type', 'block'))),
        ]);

        try {
            $addRule = $this->daemonFirewallRepository->setServer($server)->add(
                json_decode(json_encode(DB::table('firewall_rules')->where('server_id', '=', $server->id)->orderBy('priority', 'DESC')->get()), true),
            );
        } catch (GuzzleException | DaemonConnectionException $e) {
            throw new DisplayException('Rule is saved, but failed to add to the server. Please restart your server.');
        }

        if (json_decode($addRule->getBody())->success != true) {
            throw new DisplayException('Rule is saved, but failed to add to the server. Please restart your server.');
        }

        return [
            'success' => true,
            'data' => [],
        ];
    }

    /**
     * @param FirewallRequest $request
     * @param Server $server
     * @param $id
     * @return array
     * @throws DisplayException
     */
    public function remove(FirewallRequest $request, Server $server, $id)
    {
        $rule = DB::table('firewall_rules')->where('id', '=', (int) $id)->where('server_id', '=', $server->id)->first();
        if (!$rule) {
            throw new DisplayException('Rule not found.');
        }

        try {
            $addRule = $this->daemonFirewallRepository->setServer($server)->remove([
                'ip' => $rule->ip,
                'port' => $rule->port,
                'priority' => $rule->priority,
                'type' => $rule->type,
            ]);
        } catch (GuzzleException | DaemonConnectionException $e) {
            throw new DisplayException('Failed to remove from the rules of the running server. Please try again...');
        }

        if (json_decode($addRule->getBody())->success != true) {
            throw new DisplayException('Failed to remove from the rules of the running server. Please try again...');
        }

        DB::table('firewall_rules')->where('id', '=', $rule->id)->delete();

        return [
            'success' => true,
            'data' => [],
        ];
    }
}
