<template>
    <section class="table_section bg-white dark:bg-dark">
        <div class="container mx-auto">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full px-4">
                    <div class="max-w-full overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-center bg-primary">
                                <th class="w-1/6 min-w-[160px] border-l border-transparent py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4">
                                분류
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4">
                                제조사
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4">
                                제품명
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4">
                                굴절률
                                </th>
                                <th class="w-1/6 min-w-[160px] py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4">
                                제품마크#1
                                </th>
                                <th class="w-1/6 min-w-[160px] border-r border-transparent py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4">
                                제품마크#2
                                </th>
                                <th class="w-1/6 min-w-[160px] border-r border-transparent py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4">
                                제품링크
                                </th>
                                <th class="w-1/6 min-w-[160px] border-r border-transparent py-4 px-3 text-lg font-medium text-white lg:py-7 lg:px-4">
                                수정
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            
                            <tr v-for="item in state.items" :key="item.id">
                                    <td class="text-dark border-b border-l border-[#E8E8E8] bg-[#F3F6FF] dark:bg-dark-3 dark:border-dark dark:text-dark-7 py-5 px-2 text-center text-base font-medium">
                                        {{ item.classification }}
                                    </td>
                                    <td class="text-dark border-b border-[#E8E8E8] bg-white dark:border-dark dark:bg-dark-2 dark:text-dark-7 py-5 px-2 text-center text-base font-medium">
                                        {{ item.manufacturer }}
                                    </td>
                                    <td class="text-dark border-b border-[#E8E8E8] bg-[#F3F6FF] dark:bg-dark-3 dark:border-dark dark:text-dark-7 py-5 px-2 text-center text-base font-medium">
                                        {{ item.product_name }}
                                    </td>
                                    <td class="text-dark border-b border-[#E8E8E8] bg-white dark:border-dark dark:bg-dark-2 dark:text-dark-7 py-5 px-2 text-center text-base font-medium">
                                        {{ item.refractive_index }}
                                    </td>
                                    <td class="text-dark border-b border-r border-[#E8E8E8] bg-white dark:border-dark dark:bg-dark-2 dark:text-dark-7 py-5 px-2 text-center text-base font-medium">
                                        <img v-if="item.product_mark1" :src="item.product_mark1" alt="product_mark1">
                                        <!-- <a v-else href="javascript:void(0)" class="inline-block px-6 py-2.5 border rounded-md border-primary text-primary hover:bg-primary hover:text-white font-medium" target="_blank">
                                            등록하기
                                        </a> -->
                                    </td>
                                    <td class="text-dark border-b border-r border-[#E8E8E8] bg-white dark:border-dark dark:bg-dark-2 dark:text-dark-7 py-5 px-2 text-center text-base font-medium">
                                        <img v-if="item.product_mark2" :src="item.product_mark2" alt="product_mark2">
                                        <!-- <a v-else href="javascript:void(0)" class="inline-block px-6 py-2.5 border rounded-md border-primary text-primary hover:bg-primary hover:text-white font-medium" target="_blank">
                                            등록하기
                                        </a> -->
                                    </td>
                                    <td class="text-dark border-b border-r border-[#E8E8E8] bg-white dark:border-dark dark:bg-dark-2 dark:text-dark-7 py-5 px-2 text-center text-base font-medium">
                                        <a v-if="item.link" :href="item.link" class="inline-block px-6 py-2.5 border rounded-md border-primary text-primary hover:bg-primary hover:text-white font-medium" target="_blank">
                                            GO
                                        </a>
                                    </td>
                                    <td class="text-dark border-b border-r border-[#E8E8E8] bg-white dark:border-dark dark:bg-dark-2 dark:text-dark-7 py-5 px-2 text-center text-base font-medium">
                                        <Modal :buttonText ="this.buttonText" :id ="item.mark_no" @deleteSuccess="deleteRow($event)" />
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Modal from "./ModalSection.vue";
export default ({
    components: { Modal },
    props: {
        NewItem: {
            type: Object,
            default: () => ({}) // 기본 값으로 빈 객체를 반환
        } 
    },
    data() {
        return {
            buttonText: "modify",
            state: {
                items: [],
            },
        }
    },
    mounted () {
        this.getAllMarkLens();
        if(this.NewItem){
            console.log('TblSection_NewItem: ', this.NewItem);
        }else{
            console.log('TblSection_NewItem: 안들어옴');
        }
    },
    methods: {
        // 전체리스트 불러오기
        getAllMarkLens(){
            this.$axios.get('/api/lensMark')
                .then((res) => {  
                    this.state.items = res.data;
                    console.log("lens_data : " + JSON.stringify(res.data), null, 2);
                })
                .catch((error) => {
                    console.error('lensMarks API 호출 중 에러 발생:', error);
                });
        },
        // 자식페이지(modalSection)에서 삭제한 id 행 찾아서 삭제
        deleteRow(id) {
            const index = this.state.items.findIndex(item => item.id === id);
            if (index !== -1) {
                this.state.items.splice(index, 1);
            }
            this.getAllMarkLens();
        },
    },
    watch: {
        newItem(newVal) {
            if (newVal && Object.keys(newVal).length > 0) { // newItem이 존재하고 빈 객체가 아닐 경우
                console.log('newVal감지', newVal);
                this.state.items.push(newVal);
            }
        }
    },
})
</script>
