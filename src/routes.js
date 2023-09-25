import Dashboard from "./components/Dashboard.vue";
import Settings from "./components/Settings.vue";
import Logs from "./components/Logs.vue";
import CronInfo from "./components/CronInfo.vue";

export var routes = [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            active: 'dashboard'
        }
    },
    {
        path: '/settings',
        name: 'settings',
        component: Settings,
        meta: {
            active: 'settings'
        }
    },
    {
        path: '/logs',
        name: 'logs',
        component: Logs,
        meta: {
            active: 'logs'
        }
    },
    {
        path: '/cron-info',
        name: 'cron-info',
        component: CronInfo,
        meta: {
            active: 'cron-info'
        }
    }
];