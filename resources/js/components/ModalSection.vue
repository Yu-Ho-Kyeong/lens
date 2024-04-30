<template>
    <section :class="{ 'save-modal-section': true }" class="save-modal-section">
        <div class="container py-5 mx-auto">
            <button @click="openModal(); this.buttonText === 'modify' ? getLensMark(this.id) : ''" class="open_modal_btn cursor-pointer px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary">
                {{ this.buttonText }}
            </button>
        </div>

        <div v-if="modalOpen" class="overflow-x-auto overflow-y-auto fixed top-0 left-0 flex items-center justify-center w-full h-full min-h-screen px-4 py-5 bg-dark/90" style="z-index: 9999;">
            <div class="overflow-x-auto overflow-y-auto fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 max-w-[570px] max-h-[90vh] rounded-[20px] bg-white dark:bg-dark-2 py-12 px-8 text-center md:py-[60px] md:px-[70px]">
                <h3 class="pb-[18px] text-xl font-semibold text-dark dark:text-white sm:text-2xl">
                    {{ this.titleText}} 
                </h3>
                <span class="mx-auto mb-6 inline-block h-1 w-[90px] rounded bg-primary"></span>

                <!-- 분류 -->
                <div class="mb-4 flex flex-row items-center">
                    <label for="classification" class="flex-shrink-0 block text-base font-medium text-dark dark:text-white text-right mr-2 pr-4 w-1/4">분류:</label>
                    <input v-model="lensData.classification" type="text" name="classification" id="classification" class="flex-grow p-2 border-b rounded-md">
                </div>

                <!-- 제조사 -->
                <div class="mb-4 flex flex-row items-center" >
                    <label for="manufacturer" class="flex-shrink-0 block text-base font-medium text-dark dark:text-white text-right mr-2 pr-4 w-1/4">제조사:</label>
                    <input v-model="lensData.manufacturer" type="text" name="manufacturer" id="manufacturer" class="mt-1 p-2 w-full border-b rounded-md">
                </div>

                <!-- 제품명 -->
                <div class="mb-4 flex flex-row items-center">
                    <label for="product_name" class="flex-shrink-0 block text-base font-medium text-dark dark:text-white text-right mr-2 pr-4 w-1/4">제품명:</label>
                    <input v-model="lensData.product_name" type="text" name="product_name" id="product_name" class="mt-1 p-2 w-full border-b rounded-md">
                </div>

                <!-- 굴절률 -->
                <div class="mb-4 flex flex-row items-center">
                    <label for="refractive_index" class="flex-shrink-0 block text-base font-medium text-dark dark:text-white text-right mr-2 pr-4 w-1/4">굴절률:</label>
                    <input v-model="lensData.refractive_index" type="text" name="refractive_index" id="refractive_index" class="mt-1 p-2 w-full border-b rounded-md">
                </div>

                <!-- 제품마크#1 -->
                <div class="product_mark1_section mb-4 flex flex-row">
                    <label for="product_mark1" class="flex-shrink-0 block text-base font-medium text-dark dark:text-white text-right mr-2 pr-4 w-1/4">제품마크#1:</label>
                    <div v-if="lensData.product_mark1" class="product_mark1_wrap relative w-[250px] h-[250px] mb-6 flex flex-col items-center justify-center"> 
                        <div class="product_mark1_img w-[200px] h-[200px] border border-gray-300">
                            <img :src="lensData.product_mark1" alt="제품마크#1" class="object-contain w-full h-full">
                        </div>
                        <div class="product_mark1_btn mt-2 flex"> 
                            <button type="button" @click="changeProductMark1" class="change_btn px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary mr-2">change</button>
                            <button type="button" @click="removeProductMark1" class="remove_btn px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary">remove</button>
                        </div>
                    </div>
                    
                    <div v-else class="relative w-[200px] h-[200px] flex flex-col justify-center items-center"> 
                        <div class="mt-2">
                            <button type="button" @click="changeProductMark1" class="select_btn px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary">select</button>
                        </div>
                    </div>
                </div>

                
                <!-- 제품마크#2 -->
                <div class="product_mark2_section mb-4 flex flex-row">
                    <label for="product_mark2" class="flex-shrink-0 block text-base font-medium text-dark dark:text-white text-right mr-2 pr-4 w-1/4">제품마크#1:</label>
                    <div v-if="lensData.product_mark2" class="product_mark2_wrap relative w-[250px] h-[250px] mb-6 flex flex-col items-center justify-center"> 
                        <div class="product_mark2_img w-[200px] h-[200px] border border-gray-300">
                            <img :src="lensData.product_mark2" alt="제품마크#2" class="object-contain w-full h-full">
                        </div>
                        <div class="product_mark2_btn mt-2 flex"> 
                            <button type="button" @click="changeProductMark2" class="change_btn px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary mr-2">change</button>
                            <button type="button" @click="removeProductMark2" class="remove_btn px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary">remove</button>
                        </div>
                    </div>
                    
                    <div v-else class="relative w-[200px] h-[200px] flex flex-col justify-center items-center"> 
                        <div class="mt-2">
                            <button type="button" @click="changeProductMark2" class="select_btn px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary">select</button>
                        </div>
                    </div>
                </div>

                <!-- 검색어 -->
                <div class="mb-4 flex flex-row items-center">
                    <label for="keyword" class="flex-shrink-0 block text-base font-medium text-dark dark:text-white text-right mr-2 pr-4 w-1/4">검색어:</label>
                    <input v-model="lensData.keyword" type="text" name="keyword" id="keyword" class="mt-1 p-2 w-full border-b rounded-md">
                </div>

                <!-- 상세보기 -->
                <div class="mb-4 flex flex-row items-center">
                    <label for="link" class="flex-shrink-0 block text-base font-medium text-dark dark:text-white text-right mr-2 pr-4 w-1/4">상세보기:</label>
                    <input v-model="lensData.link" type="text" name="link" id="link" class="mt-1 p-2 w-full border-b rounded-md">
                </div>

                <!-- Actions -->
                <div class="flex justify-between">
                    <button @click="closeModal" type="button" class="cancel_btn cursor-pointer mr-2 px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary">
                        x Cancel
                    </button>

                    <div v-if="buttonText === 'modify'">
                        <button @click="getDelete(this.id)" type="button" class="delete_btn cursor-pointer mr-2 px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary">
                            Delete
                        </button>
                    </div>

                    <div>
                        <button @click="getSave(this.id)" type="button" class="save_btn cursor-pointer mr-2 px-6 py-3 text-base font-medium text-white rounded-full bg-primary hover:bg-secondary">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            default: ''
        },
        buttonText: {
            type: String,
            default: 'new'
        },
        titleText: {
            type: String,
            default: 'edit entry'
        }
    },
    data() {
        return {
            input : {
                classification : "",
                manufacturer : "",
                product_name : "",
                refractive_index : "",
                product_mark1 : "",
                product_mark2 : "",
                keyword : "",
                link : ""
            },
            modalOpen: false,
            lensMarkId: this.id,
            lensData: {}
        };
    },
    mounted(){
        // const id = this.id;
        // this.getMarkLens(id);
    },
    methods: {
        getLensMark(id, type){
            console.log("getLensMark : ", id);
            this.$axios.get('/api/lensMark/show/'+id)
                .then((res) => {
                    //console.log("res.data : ", res.data);
                    if(id){
                        this.lensData = res.data;
                        if(type){
                            console.log('부모컴포넌트로 전달_type : ', type);
                            this.$emit('saveSuccess', this.lensData); //부모 컴포넌트로 전달
                            //console.log('부모컴포넌트로 전달_type2 : ', type);
                        }
                    }
                    
                }).catch((err) => {
                    if (err.message.indexOf('Network Error') > -1) {
                      alert('네트워크가 원활하지 않습니다.\n잠시 후 다시 시도해주세요.')
                    }else if(err.response && err.response.status === 500){
                      alert('server error');
                    }else if(err.response && err.response.status === 403){
                        alert('권한이 없습니다. 관리자에게 문의해주세요');
                    }
                });
        },
        openModal() {
            this.modalOpen = true;
        },
        closeModal() {
            this.modalOpen = false;
        },
        getSave(id) {
            let apiUrl = '';
            const lensFormData = {
                    'classification' : this.lensData.classification,
                    'manufacturer' : this.lensData.manufacturer,
                    'product_name' : this.lensData.product_name,
                    'classification' : this.lensData.classification,
                    'refractive_index' : this.lensData.refractive_index,
                    'keyword' : this.lensData.keyword,
                    'link' : this.lensData.link
            }
            console.log('lensFormData' , lensFormData);
            if(id){
                apiUrl = '/api/lensMark/update/'+id;
            }else{
                apiUrl = '/api/lensMark/store';
            }
            this.$axios.post(apiUrl, lensFormData, {
                headers : {
                    'Content-Type' : 'application/json',
                }
            })
                .then((res)=>{ 
                    console.log('res.data.lensMark' , res.data.lensMark);
                    let id = res.data.lensMark;
                    this.closeModal();
                    this.getLensMark(id, 'refresh');
                    
                }).catch((err)=>{
                    console.log('err: ', err);
                    if (err.message.indexOf('Network Error') > -1) {
                        alert('네트워크가 원활하지 않습니다.\n잠시 후 다시 시도해주세요.')
                    }else if(err.response && err.response.status === 500){
                        alert('server error');
                    }else if(err.response && err.response.status === 403){
                        alert('권한이 없습니다. 관리자에게 문의해주세요');
                    }else if(err.response && err.response.status === 422){
                        const errors = err.response.data.errors;
                        const keys = Object.keys(errors);
                            keys.forEach(key => {
                                const messages = errors[key];
                                const firstMessage = messages[0];
                                if (firstMessage) {
                                    alert(firstMessage);
                                }
                            });
                    }
                });
        },
        getDelete(id){
            this.$axios.post('/api/lensMark/delete/'+id)
                .then((res)=>{
                    alert('삭제완료');
                    console.log('res.data' , res.data);
                    this.closeModal();
                    this.$emit('deleteSuccess', id);  // Emit deleteSuccess event

                }).catch((err)=>{
                    if (err.message.indexOf('Network Error') > -1) {
                      alert('네트워크가 원활하지 않습니다.\n잠시 후 다시 시도해주세요.')
                    }else if(err.response && err.response.status === 500){
                      alert('server error');
                    }else if(err.response && err.response.status === 403){
                        alert('권한이 없습니다. 관리자에게 문의해주세요');
                    }
                })
        }
    }
}
</script>