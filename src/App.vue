<template>
    <div class="debug-digger-app">
        <div class="debug-digger-app_main-menu-items">
            <ul class="debug-digger-app_menu">
                <li v-for="item in menuItems" :key="item.route" class="debug-digger-app_menu_item">
                    <router-link :to="{ name: item.route }" class="debug-digger-app_menu_primary">
                        {{item.title}}
                    </router-link>
                </li>
            </ul>
        </div>

        <div class="debug-digger_app_body">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import {reactive, toRefs, onMounted} from "vue";
export default {
    name: 'App',
    setup() {
        const state = reactive({
            menuItems:  [
                    {
                        route: 'dashboard',
                        title: 'Dashboard'
                    },
                    {
                        route: 'logs',
                        title: 'Logs'
                    },
                    {
                        route: 'settings',
                        title: 'Settings'
                    },
                ]
            });
        onMounted(() => {
            jQuery('.update-nag,.notice, #wpbody-content > .updated, #wpbody-content > .error').remove();
        })
        return{
            ...toRefs(state),
        }
    },
}
</script>