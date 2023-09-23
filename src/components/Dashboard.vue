<template>
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
</template>

<script>
    import { onMounted, reactive, toRefs } from 'vue';
    import { useRestApi } from '../modules/rest';
    export default {
        name: 'Dashboard',
        setup() {
            const { get } = useRestApi();
            const state = reactive({
                data: [],
            });

            const getData = async () => {
                try {
                    const response = await get('site-info');
                    state.data = response.data;
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