<template>
    <section class="sort_search_section bg-white dark:bg-dark py-20 lg:py-[10px]">
        <div class="container mx-auto">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full px-4">
                    <div class="mt-6">
                        <label for="sort1" class="classification mr-2">분류별:</label>
                        <select v-model="class_selected" name="sort1" id="sort1" class="border-b border-r rounded-md">
                            <option v-for="(option, index) in class_selectList" :value=option.value :key="index" >
                                {{ option.name }}
                            </option>
                        </select>
                        <div>선택됨 : {{ class_selected }}</div>
                    </div>
                    <div class="mt-6">
                        <label for="sort2" class="manufacturer mr-2">제조사별:</label>
                        <select v-model="manu_selected" name="sort2" id="sort2" class="border-b border-r rounded-md">
                            <option v-for="(option, index) in manu_selectList" :value=option.value :key="index" >
                                {{ option.name }}
                            </option>
                        </select>
                        <div>선택됨 : {{ manu_selected }}</div>
                    </div>
                    <div class="mt-6">
                        <label for="sort3" class="refractive_index mr-2">굴절률별:</label>
                        <select v-model="ref_selected" name="sort3" id="sort3" class="border-b border-r rounded-md">
                            <option v-for="(option, index) in ref_selectList" :value=option.value :key="index" >
                                {{ option.name }}
                            </option>
                        </select>
                        <div>선택됨 : {{ ref_selected }}</div>
                    </div>
                    <div class="mt-6">
                        <label for="sort4" class="keyword mr-2">제품마크별</label>
                        <input type="text" name="search_keyword" placeholder="Please enter keyword ">
                    </div>
                    <div class="mt-6">
                        <span class="text-3xl">SEARCH : </span>
                        <input type="text" name="search_keyword" placeholder="Please enter keyword ">
                    </div>
                </div>
            </div>
        </div>   
    </section>
</template>

<script>

export default ({
    props:{
        lensItems:{
            type: Array,
            default: () => []
        }
    },
    data(){
        return{
            class_selected : '',
            manu_selected : '',
            ref_selected : '',
            keyword_value: '',
            class_selectList : [],
            manu_selectList : [],
            ref_selectList : [],
            state:{
                lensItems:[]
            }
        }
    },
    mounted(){
        
        //this.getTypeFind('classification');
        
    },
    methods:{
        // 각 타입별 조회
        getTypeFind(type, value){
            this.$axios.get('/api/lensMark/search/', {
                params: {
                    "condition":type,
                    "selected": value
                }
            })
            .then((res)=>{
                console.log("class.data : ", res.data);
                this.state.lensItems = res.data;
                this.$emit('searchData', this.state.lensItems);  
            })
            .catch((err)=>{
                //console.log('err: ', err);
                if (err.message.indexOf('Network Error') > -1) {
                    alert('네트워크가 원활하지 않습니다.\n잠시 후 다시 시도해주세요.')
                }else if(err.response && err.response.status === 500){
                    alert('server error');
                }else if(err.response && err.response.status === 403){
                    alert('권한이 없습니다. 관리자에게 문의해주세요');
                }
            })
        },
    },
    watch: {
        lensItems: function(newVal) {   //  App.vue에서 받아온 AllLenData
            this.class_selectList = [{ name: 'noting selected', value: '' }, ...newVal.map(item => ({
                name: item.classification,
                value: item.classification
            }))];
            this.manu_selectList = [{ name: 'noting selected', value: '' }, ...newVal.map(item => ({
                name: item.manufacturer,
                value: item.manufacturer
            }))];
            this.ref_selectList = [{ name: 'noting selected', value: '' }, ...newVal.map(item => ({
                name: item.refractive_index,
                value: item.refractive_index
            }))];

        },

        'class_selected': function(newVal) {
            console.log('class_selected changed:', newVal);
            this.getTypeFind('classification', newVal);
        },
        'manu_selected': function(newVal) { 
            console.log('manu_selected changed:', newVal);
            this.getTypeFind('manufacturer', newVal);
        },
        'ref_selected': function(newVal) {
            console.log('ref_selected changed:', newVal);
            this.getTypeFind('refractive_index', newVal);
        },
        'keyword_value': function(newVal) {
            console.log('keyword_value changed:', newVal);
            this.getTypeFind('refractive_index', newVal);
        },
    },

})
</script>
