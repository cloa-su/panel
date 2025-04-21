import http from '@/api/http';
import { FirewallResponse } from '@/components/server/firewall/FirewallContainer';

export default async (uuid: string): Promise<FirewallResponse> => {
    const { data } = await http.get(`/api/client/servers/${uuid}/firewall`);

    return (data.data || []);
};
