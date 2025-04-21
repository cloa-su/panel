import http from '@/api/http';

export default (uuid: string, ip: string, allocation: number, priority: number, type: string): Promise<any> => {
    return new Promise((resolve, reject) => {
        http.post(`/api/client/servers/${uuid}/firewall/add`, {
            ip, allocation, priority, type,
        }).then((data) => {
            resolve(data.data || []);
        }).catch(reject);
    });
};
