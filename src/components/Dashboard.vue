<template>
    <Loader v-if="loading"/>
    <div v-else>
        <div class="dd_card">
        <span class="dd_info">
            PHP Version => {{ data.php_version }}
        </span>
        <span class="dd_info">
            WordPress Version => {{ data.wp_version }}
        </span>
    </div>
    <div class="dd_card">
        <span class="dd_info" v-for="(value, label) in data.server">
            {{ label }} => {{ value }}
        </span>
    </div>
    </div>
</template>

<script>
    import Loader from './parts/Loader.vue';
    import { onMounted, reactive, toRefs } from 'vue';
    import { useRestApi } from '../modules/rest';
    export default {
        name: 'Dashboard',
        components: {
            Loader
        },
        setup() {
            const { get } = useRestApi();
            const state = reactive({
                data: [],
                loading: false
            });

            const getData = async () => {
                try {
                    state.loading = true;
                    const response = await get('site-info');
                    state.data = response.data;
                    state.loading = false;
                } catch (error) {
                    console.log(error);
                }
            }

            onMounted(() => {
                getData();
            });

            return {
                ...toRefs(state),
                get,
                getData
            }
        }
        
    }
</script>