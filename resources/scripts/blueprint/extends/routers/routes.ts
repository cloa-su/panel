import React from 'react';

/* blueprint/import *//* VersionchangerImportStart */import VersionchangerGruwdbaaxh from '@/blueprint/extensions/versionchanger/VersionChangerContainer';/* VersionchangerImportEnd *//* MinecraftplayermanagerImportStart */import MinecraftplayermanagerWjqmecqwrh from '@/blueprint/extensions/minecraftplayermanager/PlayerManagerContainer';/* MinecraftplayermanagerImportEnd *//* MclogsImportStart */import MclogsFtgvpxxnle from '@/blueprint/extensions/mclogs/LogsPage';/* MclogsImportEnd */

interface RouteDefinition {
  path: string;
  name: string | undefined;
  component: React.ComponentType;
  exact?: boolean;
  adminOnly: boolean | false;
  identifier: string;
}
interface ServerRouteDefinition extends RouteDefinition {
  permission: string | string[] | null;
}
interface Routes {
  account: RouteDefinition[];
  server: ServerRouteDefinition[];
}

export default {
  account: [
    /* routes/account *//* VersionchangerAccountRouteStart *//* VersionchangerAccountRouteEnd *//* MinecraftplayermanagerAccountRouteStart *//* MinecraftplayermanagerAccountRouteEnd *//* MclogsAccountRouteStart *//* MclogsAccountRouteEnd */
  ],
  server: [
    /* routes/server *//* VersionchangerServerRouteStart */{ path: '/minecraft/versions', permission: 'file.update', name: 'Версии', component: VersionchangerGruwdbaaxh, adminOnly: false, identifier: 'versionchanger' },/* VersionchangerServerRouteEnd *//* MinecraftplayermanagerServerRouteStart */{ path: '/minecraft/players', permission: 'control.console', name: 'Игроки', component: MinecraftplayermanagerWjqmecqwrh, adminOnly: false, identifier: 'minecraftplayermanager' },/* MinecraftplayermanagerServerRouteEnd *//* MclogsServerRouteStart */{ path: '/mclogs', permission: null, name: 'Логи', component: MclogsFtgvpxxnle, adminOnly: false, identifier: 'mclogs' },/* MclogsServerRouteEnd */
  ],
} as Routes;
