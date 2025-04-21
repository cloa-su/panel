<?php

namespace Pterodactyl\Http\Controllers\Api\Remote\Servers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pterodactyl\Http\Controllers\Controller;

class FirewallController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRules(Request $request, $uuid)
    {
        $server = DB::table('servers')->where('uuid', '=', $uuid)->first();
        if (!$server) {
            return response()->json([
                'Success' => false,
                'Error' => 'Server not found.',
            ]);
        }

        return response()->json([
            'Success' => true,
            'Rules' => json_decode(json_encode(DB::table('firewall_rules')->where('server_id', '=', $server->id)->orderBy('priority', 'DESC')->get()), true),
        ]);
    }
}