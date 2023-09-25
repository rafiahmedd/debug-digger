<template>
    <Loader v-if="loading"/>
    <div v-else>
        <div class="dd_card" v-if="!logs.length" style="text-align: center;">
        <span style="font-size: 16px; font-weight: 600; color: f38637;">
            No logs found yet!
        </span>
    </div>
    <div v-else>
            <div class="dd_log_table_actions">
                <div class="dd_log_actions">
                    <button class="dd_button" @click="fetchLogs">
                        <span class="dashicons dashicons-image-rotate"></span>
                    </button>
                    <button class="dd_button" @click="clearLog">
                        <span class="dashicons dashicons-trash"></span>
                    </button>
                </div>
            </div>
            <table class="dd_log_table">
                <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Message</th>
                        <th scope="col">File</th>
                        <th scope="col">Line Number</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="log, index in logs" :key="index">
                        <td :class="'dd_log_type_'+ log.errorType">{{ log.errorType }}</td>
                        <td>{{ log.errorDescription }}</td>
                        <td>{{ log.errorFile }}</td>
                        <td>{{ log.lineNumber }}</td>
                        <td>{{ log.errorTime }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import Loader from './parts/Loader.vue';
    import { reactive, toRefs, onMounted } from 'vue';
    import { useRestApi } from '../modules/rest'; 
    
    export default {
        name: 'Logs',
        components: {
            Loader
        },
        setup() {
            const { get, del } = useRestApi();
            const state = reactive({
                logs: [],
                loading: false
            });

            const fetchLogs = async () => {
                state.loading = true;
                const logs = await get('logs');
                state.logs = logs.log;
                state.loading = false;
            }

            const clearLog = async () => {
                const response = await del('logs');
                response.message;
                fetchLogs();
            }

            onMounted(() => {
                fetchLogs();
            });

            return { 
                ...toRefs(state),
                get,
                del,
                fetchLogs,
                clearLog
             };
        }
    }
</script>

<style scoped>

.dashicons-image-rotate:before {
    color: #697a8d;
}
.dashicons-image-rotate:hover:before {
    color: #73a5ff;
    cursor: pointer;
}
.dashicons-trash:before{
    color: #ee7b7b;
}
.dashicons-trash:hover:before {
    color: #eb5757;
    cursor: pointer;
}
</style>