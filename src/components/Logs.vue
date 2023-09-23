<template>
    <div>
        <!-- Create a nice table -->
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
</template>

<script>
    import { reactive, toRefs, onMounted } from 'vue';
    import { useRestApi } from '../modules/rest'; 
    
    export default {
        name: 'Logs',
        setup() {
            const { get, del } = useRestApi();
            const state = reactive({
                logs: []
            });

            const fetchLogs = async () => {
                const logs = await get('logs');
                state.logs = logs.log;
            }

            const clearLog = async () => {
                const response = await del('logs');
                response.message
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
.dd_log_table{
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 1em;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}
.dd_log_table thead tr {
    background-color: #73a5ff;
    color: #ffffff;
    text-align: left;
}
.dd_log_table th,
.dd_log_table td {
    padding: 12px 15px;
}

.dd_log_table tbody tr {
    border-bottom: 1px solid #dddddd;
}

.dd_log_table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.dd_log_table tbody tr:last-of-type {
    border-bottom: 2px solid #73a5ff;
}
.dd_log_type_Warning{
    background: #ff8c00;
    font-weight: bold;
    color: #fff;
}

.dd_log_table_actions {
    display: flex;
    flex-direction: row-reverse;
    gap: 12px;
}

.dd_log_actions {
    background: #fff;
    padding: 10px;
    border-radius: 5px;
}

.dd_log_actions button.dd_button {
    margin: 5px;
    background: transparent;
    border: none;
}

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