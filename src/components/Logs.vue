<template>
    <div>
        <!-- Create a nice table -->
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
            const { get } = useRestApi();
            const state = reactive({
                logs: []
            });

            const fetchLogs = async () => {
                const logs = await get('logs');
                state.logs = logs.log;
            }

            onMounted(() => {
                fetchLogs();
            });

            return { 
                ...toRefs(state),
                get,
                fetchLogs
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
</style>