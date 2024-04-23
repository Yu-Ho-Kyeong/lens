<template>
    <div class="container mx-auto">
        <Img/>          
        <SortSearch/>
        <Modal :titleText ="this.titleText" @saveSuccess="handleSaveSuccess"/>
        <TblSection :newItem ="this.newItem"/>
    </div>
</template>

<script>
import MyHome from './components/Home.vue';
import Img from './components/ImgSection.vue';
import SortSearch from './components/SortSearch.vue';
import Modal from './components/ModalSection.vue';
import TblSection from './components/TblSection.vue';
export default ({
    name: 'App',
    components: { MyHome, Img, SortSearch, Modal, TblSection },
    data(){
        return{
            titleText:"add new entry",
            newItem:{}
        }
    },
    methods: {
        handleSaveSuccess(newLensData) {
            
            if(newLensData){
                console.log('newLensData : ', newLensData);
                this.newItem = newLensData;
                console.log('this.items: ', this.newItem);
                console.log('this.items_type: ', typeof this.newItem);
                // this.getAllMarkLens();
            }
            
        },
    }
})
</script>

