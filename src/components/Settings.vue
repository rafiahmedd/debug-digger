<template>
    <div class="dd_card">
        <div class="dd_card_list_content">
            <div class="dd_card_list_item" v-for="(item, index) in data" :key="index">
                <div class="dd_card_list_item_label">
                    <span> {{ item.label  }} </span>
                    <span class="dd_card_list_item_help_text"> {{ item.help_text }} </span>
                </div>
                <div class="dd_card_list_item_value">
                    <label class="switch">
                        <input type="checkbox" v-model="item.value" @change="update(index)">
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { onMounted, reactive, toRefs } from 'vue';
    import { useRestApi } from '../modules/rest';
    export default {
        name: 'Settings',
        setup() {
            const { get, post } = useRestApi();
            const state = reactive({
                data: [],
                item: {
                    label: 'Enable Debug Mode',
                    value: false,
                }
            });

            const getData = async () => {
                try {
                    const response = await get('settings');
                    state.data = response.data;
                } catch (error) {
                    console.log(error);
                }
            }

            const update = async (item) => {
                try {
                    const response = await post('settings', 
                    {
                        'key':item,
                        'value': state.data[item].value
                    }
                    );
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
                post,
                getData,
                update
            }
        }
    }
</script>

<style scoped>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ff7c7c;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #76cf08;
}

input:focus + .slider {
  box-shadow: 0 0 1px #76cf08;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.dd_card_list_item_label {
    font-size: 16px;
    font-weight: 700;
    width: 85%;
}

span.dd_card_list_item_help_text {
    display: block;
    font-size: 13px;
    font-style: italic;
    font-weight: 400;
    word-wrap: break-word;
    margin-top: 16px;
    color: #696969;
    line-height: 1.9;
}
</style>