<template>
    <Loader v-if="loading" />
    <div v-else>
        <table class="dd_log_table">
            <thead>
                <tr>
                    <th scope="col">Hook</th>
                    <th scope="col">Next Run</th>
                    <th scope="col">Schedule</th>
                    <th scope="col">Args</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="cron, index in cronInfo" :key="index">
                    <td>{{ cron.hook }}</td>
                    <td>{{ cron.nextRun }}</td>
                    <td>{{ cron.schedule+'('+ cron.name  +')' }}</td>
                    <td>
                        <li v-for="arg, index in cron.args" :key="index">
                            {{ arg }}
                        </li>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Loader from './parts/Loader.vue';
import { useRestApi } from '../modules/rest';
import { reactive, toRefs, onMounted } from 'vue';

export default {
    name: 'CronInfo',
    components: {
        Loader
    },
    setup() {
        const state = reactive({
            cronInfo: [],
            loading: false
        });

        const { get } = useRestApi();

        const getCronInfo = async () => {
            state.loading = true;
            const cronInfo = await get('cron-info');
            state.cronInfo = cronInfo.cronJobs;
            state.loading = false;
        };

        onMounted(() => {
            getCronInfo();
        });

        return {
            ...toRefs(state),
            get,
            getCronInfo
        };
    },
};
</script>